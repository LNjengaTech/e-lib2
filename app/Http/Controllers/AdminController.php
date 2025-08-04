<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;
use App\Models\Catalogue;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Loan;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     * Accessible by authenticated librarians/admins.
     */
    public function dashboard()
    {
        // --- Existing Dashboard Data ---
        $totalBooks = Catalogue::count();
        // Count only actual members (users with 'USR' utype)
        $totalMembers = User::where('utype', 'USR')->count();
        $booksBorrowed = Loan::where('returned_at', null)->count();
        $overdueBooks = Loan::where('due_date', '<', Carbon::now())
                            ->where('returned_at', null)
                            ->count();

        // --- Recent Activity Feed ---
        // Fetch recent loans (borrowed or returned) and fines (issued or paid)
        $recentActivities = collect()
            // Recent borrowings
            ->merge(Loan::with(['user', 'book'])
                ->orderBy('borrowed_at', 'desc')
                ->limit(5) // Limit to 5 most recent borrowings
                ->get()
                ->map(function ($loan) {
                    return [
                        'type' => 'loan',
                        'description' => "Book '{$loan->book->title}' borrowed by {$loan->user->name}",
                        'date' => $loan->borrowed_at,
                        'link' => route('admin.loans'), // Link to manage loans page
                    ];
                })
            )
            // Recent returns
            ->merge(Loan::with(['user', 'book'])
                ->whereNotNull('returned_at')
                ->orderBy('returned_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($loan) {
                    return [
                        'type' => 'return',
                        'description' => "Book '{$loan->book->title}' returned by {$loan->user->name}",
                        'date' => $loan->returned_at,
                        'link' => route('admin.loans'),
                    ];
                })
            )
            // Recent fines issued
            ->merge(Fine::with('user')
                ->orderBy('issued_at', 'desc')
                ->limit(3)
                ->get()
                ->map(function ($fine) {
                    return [
                        'type' => 'fine_issued',
                        'description' => "Fine of Ksh. " . number_format($fine->amount, 2) . " issued to {$fine->user->name} for '{$fine->reason}'",
                        'date' => $fine->issued_at,
                        'link' => route('admin.fines'),
                    ];
                })
            )
            // Recent fines paid
            ->merge(Fine::with('user')
                ->whereNotNull('paid_at')
                ->orderBy('paid_at', 'desc')
                ->limit(3)
                ->get()
                ->map(function ($fine) {
                    return [
                        'type' => 'fine_paid',
                        'description' => "Fine of Ksh. " . number_format($fine->amount, 2) . " paid by {$fine->user->name}",
                        'date' => $fine->paid_at,
                        'link' => route('admin.fines'),
                    ];
                })
            )
            ->sortByDesc('date')
            ->take(8); // Take the top 8 overall recent activities for display


        // --- Overdue Books Spotlight ---
        // Fetches up to 5 most critically overdue books (oldest due_date first)
        $criticalOverdueBooks = Loan::with(['user', 'book'])
            ->where('due_date', '<', Carbon::now()) // Due date is in the past
            ->where('returned_at', null)
            ->orderBy('due_date', 'asc')
            ->limit(5) // Get top 5
            ->get();

        // --- Books Nearing Due Date ---
        // Fetches up to 5 books due in the next 3 days
        $nearingDueBooks = Loan::with(['user', 'book'])
            ->whereBetween('due_date', [Carbon::now(), Carbon::now()->addDays(3)]) // Due within today and next 3 days
            ->where('returned_at', null) // Not yet returned
            ->orderBy('due_date', 'asc')
            ->limit(5) // Get top 5
            ->get();

        // --- Books Borrowed Over Time (Graph Data for last 30 days) ---
        // Query to get daily borrowing counts for the last 30 days
        $borrowingTrends = Loan::select(
                DB::raw('DATE(borrowed_at) as borrow_date'),
                DB::raw('COUNT(*) as total_borrowed') // Count borrowings per day
            )
            ->where('borrowed_at', '>=', Carbon::now()->subDays(29)->startOfDay()) // Start 29 days ago at the beginning of the day
            ->groupBy('borrow_date') // Group by date
            ->orderBy('borrow_date', 'asc') // Order chronologically
            ->get();

        $chartLabels = []; // Array to hold date labels for the chart
        $chartData = [];   // Array to hold borrowing counts for the chart

        // Populate all 30 days, even if no borrowings occurred on a specific day
        $period = Carbon::now()->subDays(29)->startOfDay(); // Start from 29 days ago (inclusive of today means 30 days)
        while ($period <= Carbon::now()->endOfDay()) {
            $dateString = $period->format('Y-m-d'); // Format for matching with query results
            $chartLabels[] = $period->format('M d'); // Format for display on the chart (e.g., "Aug 04")

            // Find the count for the current date, or default to 0 if not found
            $count = $borrowingTrends->firstWhere('borrow_date', $dateString)['total_borrowed'] ?? 0;
            $chartData[] = $count;

            $period->addDay(); // Move to the next day
        }

        // Pass all data to the dashboard view
        return view('admin-views.dashboard', [
            'totalBooks' => $totalBooks,
            'totalMembers' => $totalMembers,
            'booksBorrowed' => $booksBorrowed,
            'overdueBooks' => $overdueBooks,
            'recentActivities' => $recentActivities, // New data
            'criticalOverdueBooks' => $criticalOverdueBooks, // New data
            'nearingDueBooks' => $nearingDueBooks, // New data
            'chartLabels' => json_encode($chartLabels), // New data for Chart.js
            'chartData' => json_encode($chartData),     // New data for Chart.js
        ]);
    }

    /**
     * Display the manage books page.
     * Accessible by authenticated librarians/admins.
     */
    public function manageBooks(Request $request)
    {
        $books = Catalogue::latest()
            ->filter($request->only(['search', 'tags', 'category']))
            ->paginate(10);

        return view('admin-views.manage-books', compact('books'));
    }

    /**
     * Handle the submission of the "Add New Book" form.
     * Stores the new book in the database.
     */
    public function storeBook(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'isbn' => 'required|string|unique:catalogues,isbn|max:255', // Corrected table name to 'catalogues'
                'category' => 'required|string|max:255',
                'description' => 'required|string',
                'total_copies' => 'required|integer|min:0',
                'available_copies' => 'required|integer|min:0|lte:total_copies',
                'published_year' => 'required|integer|min:1000|max:' . (date('Y') + 1),
                'tags' => 'required|string|max:255',
                'image' => 'nullable|url|max:2048',
            ]);

            Catalogue::create($validatedData);

            return redirect()->route('admin.books')->with('success', 'Book added successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error adding book: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while adding the book. Please try again.')->withInput();
        }
    }

    /**
     * Handle the update of an existing book.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catalogue  $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateBook(Request $request, Catalogue $book)
    {
        try {
            $validatedData = $request->validate([
                'isbn' => 'required|string|unique:catalogues,isbn,' . $book->id . '|max:255', // Corrected table name to 'catalogues'
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'description' => 'required|string',
                'total_copies' => 'required|integer|min:0',
                'available_copies' => 'required|integer|min:0|lte:total_copies',
                'published_year' => 'required|integer|min:1000|max:' . (date('Y') + 1),
                'tags' => 'required|string|max:255',
                'image' => 'nullable|url|max:2048',
            ]);

            $book->update($validatedData);

            return redirect()->route('admin.books')->with('success', 'Book updated successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating book: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the book. Please try again.')->withInput();
        }
    }

    /**
     * Handle the deletion of a book.
     *
     * @param  \App\Models\Catalogue  $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyBook(Catalogue $book)
    {
        DB::beginTransaction();
        try {
            // Prevent deletion if there are active loans or pending reservations for this book
            if ($book->reservations()->where('status', 'pending')->exists()) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Cannot delete book: There are pending reservations for this book.');
            }
            if ($book->loans()->whereNull('returned_at')->exists()) { // Check for active loans
                DB::rollBack();
                return redirect()->back()->with('error', 'Cannot delete book: There are active loans for this book.');
            }

            $book->delete();
            DB::commit();
            return redirect()->route('admin.books')->with('success', 'Book deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting book: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the book.')->withInput();
        }
    }


    /**
     * Display the manage loans page.
     * Accessible by authenticated librarians/admins.
     */
    public function manageLoans()
    {
        // Fetch all loans with associated user and book details
        $loans = Loan::with(['user', 'book'])
                      ->orderBy('returned_at') // Nulls first, so active loans appear at top
                      ->latest('borrowed_at') // Then by most recent borrowed date
                      ->get(); // Get all loans first to process status dynamically

        // Dynamically set 'overdue' status for display if not already set by command
        foreach ($loans as $loan) {
            if ($loan->status === 'borrowed' && $loan->due_date->isPast()) {

                // Note: The actual database 'status' column is updated by the Artisan command.
                // This is for real-time display accuracy.

                $loan->status = 'overdue';
            }
        }

        //paginate the processed collection
        $perPage = 10;
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $loans->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $loans = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, $loans->count(), $perPage, $currentPage, [
            'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath()
        ]);


        return view('admin-views.manage-loans', compact('loans'));
    }



    /**
     * Handle marking a loan as returned.
     *
     * @param \App\Models\Loan $loan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markLoanReturned(Loan $loan)
    {
        DB::beginTransaction();
        try {
            // Only mark as returned if the loan is currently 'borrowed'
            if ($loan->status !== 'borrowed') {
                DB::rollBack();
                return redirect()->back()->with('error', 'This loan is not in a borrowed state and cannot be marked as returned.');
            }

            // Update the loan record
            $loan->update([
                'returned_at' => Carbon::now(),
                'status' => 'returned',
            ]);

            // Increment the available copies for the book
            $book = $loan->book;
            if ($book) {
                $book->increment('available_copies');
            }

            DB::commit();
            return redirect()->route('admin.loans')->with('success', 'Book "' . ($loan->book->title ?? 'N/A') . '" returned successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error marking loan returned: ' . $e->getMessage(), ['loan_id' => $loan->id]);
            return redirect()->back()->with('error', 'An error occurred while marking the book as returned. Please try again.');
        }
    }


    /**
     * Display the manage reservations page.
     * Accessible by authenticated librarians/admins.
     */
    public function manageReservations(Request $request)
    {
        $reservations = Reservation::with(['user', 'catalogue'])
                                 ->whereIn('status', ['pending', 'confirmed_pickup'])
                                 ->latest('reserved_at')
                                 ->paginate(10);

        return view('admin-views.manage-reservations', compact('reservations'));
    }

    /**
     * Handle confirming a reservation pickup by a student.
     * This will transition a reservation to a loan.
     *
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmReservationPickup(Reservation $reservation)
    {
        DB::beginTransaction();
        try {
            if ($reservation->status !== 'pending') {
                DB::rollBack();
                return redirect()->back()->with('error', 'This reservation is not in a pending state and cannot be confirmed.');
            }

            if ($reservation->user->fee_balance > 0) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Cannot confirm pickup: The student has an outstanding fee balance. Please clear their balance first.');
            }

            // Create a new Loan record
            Loan::create([
                'user_id' => $reservation->user_id,
                'catalogue_id' => $reservation->catalogue_id,
                'borrowed_at' => Carbon::now(),
                'due_date' => Carbon::now()->addDays(14), // Default loan period: 14 days
                'status' => 'borrowed',
            ]);

            // Update the reservation status to 'confirmed_pickup'
            $reservation->update(['status' => 'confirmed_pickup']);

            // available_copies was decremented on reservation creation, no change needed here.

            DB::commit();
            return redirect()->route('admin.reservations')->with('success', 'Reservation confirmed and book marked as picked up. Loan created.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error confirming reservation pickup: ' . $e->getMessage(), ['reservation_id' => $reservation->id]);
            return redirect()->back()->with('error', 'An error occurred while confirming pickup. Please try again.');
        }
    }

    /**
     * Handle cancelling a reservation.
     *
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelReservation(Reservation $reservation)
    {
        DB::beginTransaction();
        try {
            if ($reservation->status !== 'pending') {
                DB::rollBack();
                return redirect()->back()->with('error', 'This reservation cannot be cancelled as it is not in a pending state.');
            }

            $reservation->update(['status' => 'cancelled']);

            $book = $reservation->book;
            if ($book) {
                $book->increment('available_copies');
            }

            DB::commit();
            return redirect()->route('admin.reservations')->with('success', 'Reservation cancelled successfully and book made available.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error cancelling reservation: ' . $e->getMessage(), ['reservation_id' => $reservation->id]);
            return redirect()->back()->with('error', 'An error occurred while cancelling the reservation. Please try again.');
        }
    }


    /**
     * Display the manage fines page.
     * Accessible by authenticated librarians/admins.
     */
    public function manageFines()
    {

        $fines = Fine::with(['user', 'loan.book'])
                     ->latest('issued_at')
                     ->paginate(10);

        return view('admin-views.manage-fines', compact('fines'));
    }

    /**
     * Handle marking a fine as paid.
     *
     * @param \App\Models\Fine $fine
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markFinePaid(Fine $fine)
    {
        Log::info("Attempting to mark fine ID: {$fine->id} as paid.");

        DB::beginTransaction();
        try {
            if ($fine->status !== 'outstanding') {
                DB::rollBack();
                Log::warning("Fine ID: {$fine->id} is not outstanding (current status: {$fine->status}). Skipping mark paid.");
                return redirect()->back()->with('error', 'This fine is not outstanding and cannot be marked as paid.');
            }

            // Update the fine status and paid_at timestamp
            $fine->update([
                'paid_at' => Carbon::now(),
                'status' => 'paid',
            ]);
            Log::info("Fine ID: {$fine->id} updated. New status: {$fine->status}, Paid At: {$fine->paid_at->toDateTimeString()}");

            // Decrement the user's fee_balance
            $user = $fine->user;
            if ($user) {
                $oldBalance = $user->fee_balance;
                $user->decrement('fee_balance', $fine->amount);
                Log::info("User ID: {$user->id} fee_balance decremented. Old balance: {$oldBalance}, Fine amount: {$fine->amount}, New balance: {$user->fee_balance}");
            } else {
                Log::error("User not found for fine ID: {$fine->id}. User ID: {$fine->user_id}. Fee balance not decremented.");
            }

            //Mark associated loan as returned if it's currently not returned
            if ($fine->loan && $fine->loan->returned_at === null) {
                $fine->loan->update([
                    'returned_at' => Carbon::now(),
                    'status' => 'returned',
                ]);
                Log::info("Loan ID: {$fine->loan->id} status updated to 'returned' after fine payment.");

                // Increment the available copies for the book
                $book = $fine->loan->book;
                if ($book) {
                    $book->increment('available_copies');
                    Log::info("Book ID: {$book->id} available_copies incremented after loan return via fine payment.");
                }
            }


            DB::commit();
            Log::info("Transaction committed for fine ID: {$fine->id}. Fine marked paid successfully.");
            return redirect()->route('admin.fines')->with('success', 'Fine of Ksh. ' . number_format($fine->amount, 2) . ' for ' . ($fine->user->name ?? 'N/A') . ' marked as paid.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error marking fine paid for fine ID: ' . $fine->id . '. Message: ' . $e->getMessage(), ['exception_trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'An error occurred while marking the fine as paid. Please try again.');
        }
    }

    /**
     * Handle waiving a fine.
     *
     * @param \App\Models\Fine $fine
     * @return \Illuminate\Http\RedirectResponse
     */
    public function waiveFine(Fine $fine)
    {
        Log::info("Attempting to waive fine ID: {$fine->id}.");

        DB::beginTransaction();
        try {
            if ($fine->status !== 'outstanding') {
                DB::rollBack();
                Log::warning("Fine ID: {$fine->id} is not outstanding (current status: {$fine->status}). Skipping waive.");
                return redirect()->back()->with('error', 'This fine is not outstanding and cannot be waived.');
            }

            // Update the fine status
            $fine->update([
                'status' => 'waived',
            ]);
            Log::info("Fine ID: {$fine->id} updated. New status: {$fine->status}.");

            // Decrement the user's fee_balance as it's no longer owed
            $user = $fine->user;
            if ($user) {
                $oldBalance = $user->fee_balance;
                $user->decrement('fee_balance', $fine->amount);
                Log::info("User ID: {$user->id} fee_balance decremented (waived). Old balance: {$oldBalance}, Fine amount: {$fine->amount}, New balance: {$user->fee_balance}");
            } else {
                Log::error("User not found for fine ID: {$fine->id}. User ID: {$fine->user_id}. Fee balance not decremented (waived).");
            }

            //Reset associated loan status if it's currently 'overdue' and not returned
            if ($fine->loan && $fine->loan->status === 'overdue' && $fine->loan->returned_at === null) {
                $fine->loan->update(['status' => 'borrowed']);
                Log::info("Loan ID: {$fine->loan->id} status reset from 'overdue' to 'borrowed' after fine waiver.");
            }

            DB::commit();
            Log::info("Transaction committed for fine ID: {$fine->id}. Fine waived successfully.");
            return redirect()->route('admin.fines')->with('success', 'Fine of Ksh. ' . number_format($fine->amount, 2) . ' for ' . ($fine->user->name ?? 'N/A') . ' waived successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error waiving fine for fine ID: ' . $fine->id . '. Message: ' . $e->getMessage(), ['exception_trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'An error occurred while waiving the fine. Please try again.');
        }
    }

    /**
     * Display the manage members page.
     * Accessible by authenticated librarians/admins.
     */
    public function manageMembers(Request $request)
    {
        $search = $request->input('search');
        $query = User::where('utype', 'USR');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('reg_number', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $members = $query->paginate(10);

        return view('admin-views.manage-members', compact('members', 'search'));
    }

    /**
     * Handle the submission of the "Add New Member" form.
     * Creates a new User record with student details and generated password.
     */
    public function storeMember(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'reg_number' => 'required|string|max:255|unique:users,reg_number',
                'full_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'fee_balance' => 'required|numeric|min:0',
            ], [], [
                'reg_number' => 'memberAdding',
                'full_name' => 'memberAdding',
                'email' => 'memberAdding',
                'fee_balance' => 'memberAdding',
            ]);

            $firstName = Str::before($validatedData['full_name'], ' ');
            $generatedPassword = $firstName . $validatedData['reg_number'];

            User::create([
                'name' => $validatedData['full_name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($generatedPassword),
                'utype' => 'USR',
                'reg_number' => $validatedData['reg_number'],
                'fee_balance' => $validatedData['fee_balance'],
            ]);

            return redirect()->route('admin.members')->with('success', 'Member account created successfully! Initial password: ' . $generatedPassword);
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors(), 'memberAdding')
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error adding member: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while adding the member: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Handle the update of an existing member.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateMember(Request $request, User $member)
    {
        try {
            $validatedData = $request->validate([
                'reg_number' => 'required|string|max:255|unique:users,reg_number,' . $member->id,
                'full_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $member->id,
                'fee_balance' => 'required|numeric|min:0',
            ], [], [
                'reg_number' => 'memberEditing',
                'full_name' => 'memberEditing',
                'email' => 'memberEditing',
                'fee_balance' => 'memberEditing',
            ]);

            $member->update([
                'name' => $validatedData['full_name'],
                'email' => $validatedData['email'],
                'reg_number' => $validatedData['reg_number'],
                'fee_balance' => $validatedData['fee_balance'],
            ]);

            return redirect()->route('admin.members')->with('success', 'Member updated successfully!');
        } catch (ValidationException $e) {
            $request->session()->flash('editingMemberId', $member->id);
            return redirect()->back()
                ->withErrors($e->errors(), 'memberEditing')
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating member: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the member: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Handle the deletion of a member.
     *
     * @param  \App\Models\User  $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyMember(User $member)
    {
        DB::beginTransaction();
        try {
            if ($member->utype !== 'USR') {
                DB::rollBack();
                return redirect()->back()->with('error', 'Only student members can be deleted from this page.');
            }

            // Prevent deletion if the member has active loans or pending reservations
            if ($member->reservations()->where('status', 'pending')->exists()) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Cannot delete member: They have pending book reservations.');
            }
            if ($member->loans()->whereNull('returned_at')->exists()) { // Check for active loans
                DB::rollBack();
                return redirect()->back()->with('error', 'Cannot delete member: They have active book loans.');
            }

            $member->delete();
            DB::commit();
            return redirect()->route('admin.members')->with('success', 'Member deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting member: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the member: ' . $e->getMessage());
        }
    }

    /**
     * Handle the import of members from a CSV file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importMembers(Request $request)
    {
        try {
            $request->validate([
                'import_file' => 'required|file|mimes:csv,txt|max:2048',
            ], [], [
                'import_file' => 'importingMembers',
            ]);

            $file = $request->file('import_file');
            $filePath = $file->getRealPath();

            $importedCount = 0;
            $failedCount = 0;
            $errors = [];

            if (($handle = fopen($filePath, 'r')) !== FALSE) {
                $header = fgetcsv($handle, 1000, ',');

                $columnMap = [
                    'full_name' => -1,
                    'email' => -1,
                    'reg_number' => -1,
                    'fee_balance' => -1,
                ];

                foreach ($header as $index => $colName) {
                    $cleanedColName = Str::snake(trim(strtolower($colName)));
                    if (array_key_exists($cleanedColName, $columnMap)) {
                        $columnMap[$cleanedColName] = $index;
                    }
                }

                foreach ($columnMap as $colName => $index) {
                    if ($index === -1) {
                        return redirect()->back()->with('error', "Missing required column in CSV: '{$colName}'. Please ensure your CSV has 'full_name', 'email', 'reg_number', 'fee_balance' columns.")->withInput();
                    }
                }

                $rowNumber = 1;
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    $rowNumber++;
                    if (empty(array_filter($data))) {
                        continue;
                    }

                    $rowData = [
                        'full_name' => $data[$columnMap['full_name']] ?? null,
                        'email' => $data[$columnMap['email']] ?? null,
                        'reg_number' => $data[$columnMap['reg_number']] ?? null,
                        'fee_balance' => $data[$columnMap['fee_balance']] ?? null,
                    ];

                    DB::beginTransaction();
                    try {
                        $validator = \Illuminate\Support\Facades\Validator::make($rowData, [
                            'full_name' => 'required|string|max:255',
                            'email' => 'required|string|email|max:255|unique:users,email',
                            'reg_number' => 'required|string|max:255|unique:users,reg_number',
                            'fee_balance' => 'required|numeric|min:0',
                        ]);

                        if ($validator->fails()) {
                            $failedCount++;
                            $errors[] = "Row {$rowNumber}: " . implode(', ', $validator->errors()->all());
                            DB::rollBack();
                            continue;
                        }

                        $firstName = Str::before($rowData['full_name'], ' ');
                        $generatedPassword = $firstName . $rowData['reg_number'];

                        User::create([
                            'name' => $rowData['full_name'],
                            'email' => $rowData['email'],
                            'password' => Hash::make($generatedPassword),
                            'utype' => 'USR',
                            'reg_number' => $rowData['reg_number'],
                            'fee_balance' => $rowData['fee_balance'],
                        ]);

                        $importedCount++;
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        $failedCount++;
                        $errors[] = "Row {$rowNumber}: " . $e->getMessage();
                    }
                }
                fclose($handle);
            } else {
                return redirect()->back()->with('error', 'Could not open the uploaded file.')->withInput();
            }

            $message = "Import complete! Successfully imported {$importedCount} members.";
            if ($failedCount > 0) {
                $message .= " Failed to import {$failedCount} members.";
                return redirect()->route('admin.members')->with('warning', $message)->with('importErrors', $errors);
            }

            return redirect()->route('admin.members')->with('success', $message);

        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors(), 'importingMembers')
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error importing members: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during import: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Display the add librarian page.
     * Accessible by authenticated super admins.
     */
    public function addLibrarian()
    {
        return view('admin-views.add-librarian');
    }

    /**
     * Display the create student account page.
     * Accessible by authenticated super admins.
     */
    public function createStudentAccount()
    {
        return view('admin-views.create-student-account');
    }
}

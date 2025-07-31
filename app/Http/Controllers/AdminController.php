<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogue;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; // NEW: Import DB facade for transactions

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     * Accessible by authenticated librarians/admins.
     */
    public function dashboard()
    {
        return view('admin-views.dashboard');
    }

    /**
     * Display the manage books page.
     * Accessible by authenticated librarians/admins.
     */
    public function manageBooks()
    {
        // Fetch all books from the database
        $books = Catalogue::latest()
                ->filter(request(['search', 'tags', 'category']))
                ->paginate(10);
        $books = Catalogue::paginate(10); // Paginate the results, adjust the number as needed
        // Pass the fetched books to the view
        return view('admin-views.manage-books', compact('books'));
    }

    /**
     * Handle the submission of the "Add New Book" form.
     * Stores the new book in the database.
     */
    public function storeBook(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
               // 'isbn' => 'required|string|unique:books,isbn|max:255', // Ensure ISBN is unique
                'category' => 'required|string|max:255', // New validation rule for category
                'description' => 'required|string',
                'total_copies' => 'required|integer|min:0',
                'available_copies' => 'required|integer|min:0',
                'published_year' => 'required',
                'tags' => 'required',
                'image' => 'nullable|url|max:2048', // Validate as a URL, optional
            ]);

            // Create a new Book instance and fill it with validated data
            Catalogue::create($validatedData);

            // Redirect back to the manage books page with a success message
            return redirect()->route('admin.books')->with('success', 'Book added successfully!');
        } catch (ValidationException $e) {
            // If validation fails, redirect back with input and errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Catch any other exceptions and redirect with a generic error message
            return redirect()->back()->with('error', 'An error occurred while adding the book. Please try again.')->withInput();
        }
    }

    /**
     * Handle the update of an existing book.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catalogue  $book
     * @return \Illuminate\Http\Response
     */
    public function updateBook(Request $request, Catalogue $book)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
              //  'isbn' => 'required|string|unique:books,isbn,' . $book->id . '|max:255', // Ensure ISBN is unique, except for the current book
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'category' => 'required|string|max:255', // New validation rule for category
                'description' => 'required|string',
                'total_copies' => 'required|integer|min:0',
                'available_copies' => 'required|integer|min:0',
                'published_year' => 'required',
                'tags' => 'required',
                'image' => 'nullable|url|max:2048', // Validate as a URL, optional
            ]);

            // Update the book with validated data
            $book->update($validatedData);

            // Redirect back to the manage books page with a success message
            return redirect()->route('admin.books')->with('success', 'Book updated successfully!');
        } catch (ValidationException $e) {
            // If validation fails, redirect back with input and errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Catch any other exceptions and redirect with a generic error message
            return redirect()->back()->with('error', 'An error occurred while updating the book. Please try again.')->withInput();
        }
    }

    /**
     * Handle the deletion of a book.
     *
     * @param  \App\Models\Catalogue  $book
     * @return \Illuminate\Http\Response
     */
    public function destroyBook(Catalogue $book)
    {
        try {
            // Delete the book
            $book->delete();

            // Redirect back to the manage books page with a success message
            return redirect()->route('admin.books')->with('success', 'Book deleted successfully!');
        } catch (\Exception $e) {
            // Catch any exceptions during deletion
            return redirect()->back()->with('error', 'An error occurred while deleting the book.')->withInput();
        }
    }


    /**
     * Display the manage loans page.
     * Accessible by authenticated librarians/admins.
     */
    public function manageLoans()
    {
        return view('admin-views.manage-loans');
    }

    /**
     * Display the manage reservations page.
     * Accessible by authenticated librarians/admins.
     */
    public function manageReservations()
    {
        return view('admin-views.manage-reservations');
    }

    /**
     * Display the manage fines page.
     * Accessible by authenticated librarians/admins.
     */
    public function manageFines()
    {
        return view('admin-views.manage-fines');
    }

    /**
     * Display the manage members page.
     * Accessible by authenticated librarians/admins.
     */
    public function manageMembers(Request $request)
    {
        // Get search query from request
        $search = $request->input('search');

        // Fetch users with 'USR' utype (students)
        $query = User::where('utype', 'USR');

        // Apply search filter if a query is present
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('reg_number', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $members = $query->paginate(10); // Paginate the results

        return view('admin-views.manage-members', compact('members', 'search'));
    }

    /**
     * Handle the submission of the "Add New Member" form.
     * Creates a new User record with student details and generated password.
     */
    public function storeMember(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'reg_number' => 'required|string|max:255|unique:users,reg_number', // Validate uniqueness against users table
                'full_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email', // Validate uniqueness against users table
                'fee_balance' => 'required|numeric|min:0',
            ], [], [
                // Custom error bag name for this form, so errors don't clash with other forms
                'reg_number' => 'memberAdding',
                'full_name' => 'memberAdding',
                'email' => 'memberAdding',
                'fee_balance' => 'memberAdding',
            ]);

            // Extract first name for password generation
            $firstName = Str::before($validatedData['full_name'], ' ');

            // Generate password: first name + registration number
            $generatedPassword = $firstName . $validatedData['reg_number'];

            // Create a new User record with all details
            $user = User::create([
                'name' => $validatedData['full_name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($generatedPassword), // Hash the generated password
                'utype' => 'USR', // Assign the 'USR' type for regular users/students
                'reg_number' => $validatedData['reg_number'], // Store reg_number in users table
                'fee_balance' => $validatedData['fee_balance'], // Store fee_balance in users table
            ]);

            // Redirect back to the manage members page with a success message
            // In a real application, you would securely communicate this password to the student.
            return redirect()->route('admin.members')->with('success', 'Member account created successfully! Initial password: ' . $generatedPassword);
        } catch (ValidationException $e) {
            // If validation fails, redirect back with input and errors, using a named error bag
            return redirect()->back()
                             ->withErrors($e->errors(), 'memberAdding') // Use the 'memberAdding' error bag
                             ->withInput();
        } catch (\Exception $e) {
            // Catch any other exceptions
            return redirect()->back()->with('error', 'An error occurred while adding the member: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Handle the update of an existing member.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $member // Using User model for members
     * @return \Illuminate\Http\Response
     */
    public function updateMember(Request $request, User $member)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'reg_number' => 'required|string|max:255|unique:users,reg_number,' . $member->id, // Unique except for current user
                'full_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $member->id, // Unique except for current user
                'fee_balance' => 'required|numeric|min:0',
            ], [], [
                // Custom error bag name for this form
                'reg_number' => 'memberEditing',
                'full_name' => 'memberEditing',
                'email' => 'memberEditing',
                'fee_balance' => 'memberEditing',
            ]);

            // Update the member (User model) with validated data
            $member->update([
                'name' => $validatedData['full_name'],
                'email' => $validatedData['email'],
                'reg_number' => $validatedData['reg_number'],
                'fee_balance' => $validatedData['fee_balance'],
            ]);

            return redirect()->route('admin.members')->with('success', 'Member updated successfully!');
        } catch (ValidationException $e) {
            // Flash the member ID to re-open the modal with errors
            $request->session()->flash('editingMemberId', $member->id);
            return redirect()->back()
                             ->withErrors($e->errors(), 'memberEditing') // Use the 'memberEditing' error bag
                             ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the member: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Handle the deletion of a member.
     *
     * @param  \App\Models\User  $member // Using User model for members
     * @return \Illuminate\Http\Response
     */
    public function destroyMember(User $member)
    {
        try {
            // Ensure only 'USR' type users can be deleted from this interface
            if ($member->utype !== 'USR') {
                return redirect()->back()->with('error', 'Only student members can be deleted from this page.');
            }

            $member->delete();
            return redirect()->route('admin.members')->with('success', 'Member deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the member: ' . $e->getMessage());
        }
    }

    /**
     * Handle the import of members from a CSV file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importMembers(Request $request)
    {
        try {
            $request->validate([
                'import_file' => 'required|file|mimes:csv,txt|max:2048', // Max 2MB, CSV or plain text
            ], [], [
                'import_file' => 'importingMembers', // Custom error bag for import
            ]);

            $file = $request->file('import_file');
            $filePath = $file->getRealPath();

            $importedCount = 0;
            $failedCount = 0;
            $errors = [];

            // Open the CSV file
            if (($handle = fopen($filePath, 'r')) !== FALSE) {
                $header = fgetcsv($handle, 1000, ','); // Read header row

                // Map header columns to expected keys for validation
                $columnMap = [
                    'full_name' => -1,
                    'email' => -1,
                    'reg_number' => -1,
                    'fee_balance' => -1,
                ];

                // Find column indices
                foreach ($header as $index => $colName) {
                    $cleanedColName = Str::snake(trim(strtolower($colName))); // Normalize column names
                    if (array_key_exists($cleanedColName, $columnMap)) {
                        $columnMap[$cleanedColName] = $index;
                    }
                }

                // Check if all required columns are present
                foreach ($columnMap as $colName => $index) {
                    if ($index === -1) {
                        return redirect()->back()->with('error', "Missing required column in CSV: '{$colName}'. Please ensure your CSV has 'full_name', 'email', 'reg_number', 'fee_balance' columns.")->withInput();
                    }
                }

                $rowNumber = 1; // Start from 1 for actual data rows (after header)
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    $rowNumber++;
                    // Skip empty rows
                    if (empty(array_filter($data))) {
                        continue;
                    }

                    // Extract data based on column map
                    $rowData = [
                        'full_name' => $data[$columnMap['full_name']] ?? null,
                        'email' => $data[$columnMap['email']] ?? null,
                        'reg_number' => $data[$columnMap['reg_number']] ?? null,
                        'fee_balance' => $data[$columnMap['fee_balance']] ?? null,
                    ];

                    DB::beginTransaction(); // Start a database transaction for each row
                    try {
                        // Validate row data
                        $validator = \Illuminate\Support\Facades\Validator::make($rowData, [
                            'full_name' => 'required|string|max:255',
                            'email' => 'required|string|email|max:255|unique:users,email',
                            'reg_number' => 'required|string|max:255|unique:users,reg_number',
                            'fee_balance' => 'required|numeric|min:0',
                        ]);

                        if ($validator->fails()) {
                            $failedCount++;
                            $errors[] = "Row {$rowNumber}: " . implode(', ', $validator->errors()->all());
                            DB::rollBack(); // Rollback transaction for this row
                            continue; // Skip to next row
                        }

                        // Extract first name for password generation
                        $firstName = Str::before($rowData['full_name'], ' ');

                        // Generate password: first name + registration number
                        $generatedPassword = $firstName . $rowData['reg_number'];

                        // Create a new User record
                        User::create([
                            'name' => $rowData['full_name'],
                            'email' => $rowData['email'],
                            'password' => Hash::make($generatedPassword),
                            'utype' => 'USR', // Assign 'USR' type
                            'reg_number' => $rowData['reg_number'],
                            'fee_balance' => $rowData['fee_balance'],
                        ]);

                        $importedCount++;
                        DB::commit(); // Commit transaction for this row
                    } catch (\Exception $e) {
                        DB::rollBack(); // Rollback on any exception
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

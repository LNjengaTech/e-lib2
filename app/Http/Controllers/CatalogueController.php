<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CatalogueController extends Controller
{
    //get all books
    public function index()
    {
        //get categories column from catalogues table
        $categories = Catalogue::select('category')->distinct()->pluck('category');
        //dd(request('search'));
        return view('library-catalogue', [
            'books' => Catalogue::latest()
                ->filter(request(['search', 'tags', 'category']))
                ->paginate(10),
            'categories' => $categories
        ]);
    }

    //get book with id
    public function show($id) {
        return view('book-info', [
            'book' => Catalogue::find($id)
        ]);
    }


 public function borrowBook(Request $request, Catalogue $book)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Please log in to reserve a book.');
        }

        $user = Auth::user();

        // Check if the user has outstanding fee balances
        // Assuming 'fee_balance' is a numeric field and > 0 means outstanding balance
        if ($user->fee_balance > 0) {
            return redirect()->back()->with('error', 'You have an outstanding fee balance and cannot borrow books at this time. Please clear your balance to proceed.');
        }

        // Start a database transaction to ensure atomicity
        DB::beginTransaction();

        try {
            // Re-fetch the book to get the latest available_copies count within the transaction
            // This prevents race conditions if multiple users try to reserve the last copy simultaneously
            $book = $book->fresh();

            // Check if there are available copies
            if ($book->available_copies <= 0) {
                DB::rollBack(); // Rollback the transaction
                return redirect()->back()->with('error', 'Sorry, this book is currently not available for reservation.');
            }

            // Check if the user already has an active reservation for this specific book
            $existingReservation = Reservation::where('user_id', $user->id)
                                            ->where('catalogue_id', $book->id)
                                            ->whereIn('status', ['pending']) // Only consider pending reservations
                                            ->first();

            if ($existingReservation) {
                DB::rollBack(); // Rollback the transaction
                return redirect()->back()->with('warning', 'You already have a pending reservation for this book.');
            }

            // Define reservation expiration (e.g., 24 hours from now)
            $reservedAt = Carbon::now();
            $expiresAt = $reservedAt->copy()->addHours(24); // Use copy() to avoid modifying $reservedAt

            // Create the reservation record
            Reservation::create([
                'user_id' => $user->id,
                'catalogue_id' => $book->id,
                'reserved_at' => $reservedAt,
                'expires_at' => $expiresAt,
                'status' => 'pending',
            ]);

            // Decrement the available copies for the book
            $book->decrement('available_copies');

            // Commit the transaction
            DB::commit();

            return redirect()->back()->with('success', 'Book "' . $book->title . '" has been reserved for you! Please pick it up within 24 hours.');

        } catch (\Exception $e) {
            // Rollback the transaction on any error
            DB::rollBack();
            // Log the error for debugging
            Log::error('Error reserving book: ' . $e->getMessage(), ['book_id' => $book->id, 'user_id' => $user->id ?? 'guest']);
            return redirect()->back()->with('error', 'An error occurred while reserving the book. Please try again.');
        }
    }
}

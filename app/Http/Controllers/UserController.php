<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\Loan;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display the student dashboard.
     * Accessible by authenticated students.
     */
    public function dashboard()
    {
        return view('users-views.dashboard');
    }

    public function myReturnedBooks()
    {
        $userId = Auth::id();
        $returned = Loan::with(['user', 'book'])
            ->where('user_id', $userId)
            ->whereIn('status', ['returned'])
            ->get();
        return view('users-views.my-returned-books', compact('returned'));
    }


    /**
     * Display the user's borrowed and reserved books.
     * Accessible by authenticated students.
     */
    public function myReservedBooks()
    {
        $userId = Auth::id();
        $reservations = Reservation::with('catalogue')
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'confirmed_pickup']) // active reservations
            ->get();

        return view('users-views.my-reserved-books', compact('reservations'));
    }

    // public function myBorrowedBooks()
    // {
    //     $userId = Auth::id();
    //     $borrowed = Loan::with(['user', 'book'])
    //         ->where('user_id', $userId)
    //         ->whereIn('status', ['borrowed', 'overdue'])
    //         ->get();
    //     return view('users-views.my-borrowed-books', compact('borrowed'));
    // }
    public function myBorrowedBooks()
    {
        $user = Auth::user();

        // Fetch all loans for the authenticated user, eager load book details
        $loans = $user->loans()->with('book')
                      ->orderBy('returned_at') // Active loans first
                      ->latest('borrowed_at')
                      ->get(); // Get all to process status dynamically

        // Dynamically set 'overdue' status for display
        foreach ($loans as $loan) {
            if ($loan->status === 'borrowed' && $loan->due_date->isPast()) {
                $loan->status = 'overdue';
            }
        }

        // Now paginate the processed collection
        $perPage = 10;
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $loans->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $loans = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, $loans->count(), $perPage, $currentPage, [
            'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath()
        ]);

        return view('users-views.my-borrowed-books', compact('loans'));
    }

    public function myPenalties()
    {
        $userId = Auth::id();
       $fines = Fine::with(['user', 'loan.book']) // NOT catalogue
    ->where('user_id', Auth::id())
    ->get();

        return view('users-views.my-penalties', compact('fines'));
    }
}

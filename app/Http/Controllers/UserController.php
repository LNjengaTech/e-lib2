<?php

namespace App\Http\Controllers;

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
        return view('users-views.my-returned-books');
    }


    /**
     * Display the user's borrowed and reserved books.
     * Accessible by authenticated students.
     */
    public function myBorrowedBooks()
    {
        $userId = Auth::id();
        $reservations = Reservation::with('catalogue')
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'confirmed_pickup']) // active reservations
            ->get();

        return view('users-views.my-borrowed-books', compact('reservations'));
    }

    public function myPenalties()
    {
        return view('users-views.my-penalties');
    }
}
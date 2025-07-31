<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{


    //Borrow book
    public function borrow(Catalogue $book)
    {

        //Check if user has already reserved book
        $existing = Reservation::where('user_id', Auth::id())->where('catalogue_id', $book->id)
            ->where('status', 'pending')
            ->first();

        //Create reservation
        Reservation::create([
            'user_id' => Auth::id(),
            'catalogue_id' => $book->id,
            'reserved_at' => now(),
            'expires_at' => now()->addDay(), //reservation expires after 24 hours
            'status' => 'pending'
        ]);

        if ($existing) {
            return redirect()->back()->with('error', 'You already have a pending reservation for this book.');
        }

        return redirect()->back()->with('success', 'Book reserved successfully. Please pick it up within 24 hours!');
    }
}
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
        $userId = Auth::id();

        $existingReservation = Reservation::where('user_id', $userId)
            ->where('catalogue_id', $book->id)
            ->whereIn('status', ['cancelled', 'expired']) // Reuse only cancelled or expired
            ->first();

        if ($existingReservation) {
            $existingReservation->update([
                'status' => 'pending',
                'reserved_at' => now(),
                'expires_at' => now()->addHours(24),
            ]);
        } else {
            Reservation::create([
                'user_id' => $userId,
                'catalogue_id' => $book->id,
                'reserved_at' => now(),
                'expires_at' => now()->addHours(24),
                'status' => 'pending',
            ]);
        }

        return redirect()->back()->with('success', 'Book reserved successfully!');
    }

    //Allow user to cancel reservation
    public function cancel($bookId)
    {
        $reservation = Reservation::where('user_id', Auth::id())
            ->where('catalogue_id', $bookId)
            ->where('status', 'pending')
            ->first();

        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($reservation) {
            $reservation->status = 'cancelled';
            $reservation->save();
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Reservation cancelled.');
    }
}
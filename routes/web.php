<?php

use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

//Public Routes

Route::get('/library-catalogue', [CatalogueController::class, 'index']);
Route::get('/library-catalogue/category/{category}', [CatalogueController::class, 'browseByCategory'])->name('catalogue.byCategory');
Route::get('/book/{book}', [CatalogueController::class, 'show'])->name('book.show');
Route::get('/exam-bank', function () {
    return response('<p>Exams Coming Soon!!</p>');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Breeze Profile Routes (keep these as they are)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Authenticated User Routes (Student/General User)
    Route::middleware(['user'])->group(function () {
        Route::get('/user-dashboard', [UserController::class, 'dashboard'])->name('user-dashboard');
        Route::get('/returned-books', [UserController::class, 'myReturnedBooks'])->name('returned-books');
        Route::get('/reserved-books', [UserController::class, 'myReservedBooks'])->name('reserved-books');
        Route::get('/borrowed-books', [UserController::class, 'myBorrowedBooks'])->name('borrowed-books');
        Route::get('/my-penalties', [UserController::class, 'myPenalties'])->name('my-penalties');

        Route::post('/borrow/{book}', [ReservationController::class, 'borrow']);
        Route::patch('/cancel-reservation/{book}', [ReservationController::class, 'cancel'])->name('reservation.cancel');
    });

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

        // AdminController handles all admin-related actions

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/books', [AdminController::class, 'manageBooks'])->name('books');
        Route::post('/books', [AdminController::class, 'storeBook'])->name('books.store');

        Route::put('/books/{book}', [AdminController::class, 'updateBook'])->name('books.update');
        Route::delete('/books/{book}', [AdminController::class, 'destroyBook'])->name('books.destroy');

        Route::get('/reservations', [AdminController::class, 'manageReservations'])->name('reservations');
        Route::put('/reservations/{reservation}/confirm', [AdminController::class, 'confirmReservationPickup'])->name('reservations.confirm');
        Route::delete('/reservations/{reservation}/cancel', [AdminController::class, 'cancelReservation'])->name('reservations.cancel');

        Route::get('/members', [AdminController::class, 'manageMembers'])->name('members');
        Route::post('/members', [AdminController::class, 'storeMember'])->name('members.store');
        Route::put('/members/{member}', [AdminController::class, 'updateMember'])->name('members.update');
        Route::delete('/members/{member}', [AdminController::class, 'destroyMember'])->name('members.destroy');
        Route::post('/members/import', [AdminController::class, 'importMembers'])->name('members.import');

        Route::get('/loans', [AdminController::class, 'manageLoans'])->name('loans');
        Route::put('/loans/{loan}/return', [AdminController::class, 'markLoanReturned'])->name('loans.return');

        Route::get('/fines', [AdminController::class, 'manageFines'])->name('fines');
        Route::put('/fines/{fine}/pay', [AdminController::class, 'markFinePaid'])->name('fines.pay');
        Route::put('/fines/{fine}/waive', [AdminController::class, 'waiveFine'])->name('fines.waive');


        // Super Admin Specific Routes
        Route::middleware(['super_admin'])->group(function () {
            Route::get('/add-librarian', [AdminController::class, 'addLibrarian'])->name('add-librarian');
            Route::get('/create-student-account', [AdminController::class, 'createStudentAccount'])->name('create-student-account');
        });
    });
});







// Laravel Breeze Auth Routes
require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

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
});


// Authenticated User Routes (Student/General User)
Route::middleware(['auth', 'verified', 'user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user-dashboard');
    Route::get('/returned-books', [UserController::class, 'myReturnedBooks'])->name('returned-books');
    Route::get('/reserved-books', [UserController::class, 'myReservedBooks'])->name('reserved-books');
    Route::get('/borrowed-books', [UserController::class, 'myBorrowedBooks'])->name('borrowed-books');
    Route::get('/my-penalties', [UserController::class, 'myPenalties'])->name('my-penalties');
    // Breeze Profile Routes (keep these as they are)
    Route::get('/user-dashboard', [UserController::class, 'dashboard'])->name('user-dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/borrow/{book}', [ReservationController::class, 'borrow']);
    Route::patch('/cancel-reservation/{book}', [ReservationController::class, 'cancel'])->name('reservation.cancel');

});


// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // AdminController handles all admin-related actions
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/books', [AdminController::class, 'manageBooks'])->name('books');
    Route::post('/books', [AdminController::class, 'storeBook'])->name('books.store');

    // Routes for editing and deleting books
    Route::put('/books/{book}', [AdminController::class, 'updateBook'])->name('books.update');
    Route::delete('/books/{book}', [AdminController::class, 'destroyBook'])->name('books.destroy');

    Route::get('/loans', [AdminController::class, 'manageLoans'])->name('loans');
    Route::get('/reservations', [AdminController::class, 'manageReservations'])->name('reservations');
    // FIX: Changed this route from POST to PUT to match the form's @method('PUT')
    Route::put('/reservations/{reservation}/confirm', [AdminController::class, 'confirmReservationPickup'])->name('reservations.confirm');
    Route::delete('/reservations/{reservation}/cancel', [AdminController::class, 'cancelReservation'])->name('reservations.cancel');
    Route::get('/fines', [AdminController::class, 'manageFines'])->name('fines');

    // Members routes
    Route::get('/members', [AdminController::class, 'manageMembers'])->name('members');
    Route::post('/members', [AdminController::class, 'storeMember'])->name('members.store');
    Route::put('/members/{member}', [AdminController::class, 'updateMember'])->name('members.update');
    Route::delete('/members/{member}', [AdminController::class, 'destroyMember'])->name('members.destroy');
    Route::post('/members/import', [AdminController::class, 'importMembers'])->name('members.import');

    // Loan Management Routes
    Route::get('/loans', [AdminController::class, 'manageLoans'])->name('loans');
    Route::put('/loans/{loan}/return', [AdminController::class, 'markLoanReturned'])->name('loans.return'); // Mark Loan Returned

    // Fine Management Routes
    Route::get('/fines', [AdminController::class, 'manageFines'])->name('fines');
    Route::put('/fines/{fine}/pay', [AdminController::class, 'markFinePaid'])->name('fines.pay'); // NEW: Mark Fine Paid
    Route::put('/fines/{fine}/waive', [AdminController::class, 'waiveFine'])->name('fines.waive'); // NEW: Waive Fine





    // Super Admin Specific Routes
    Route::middleware(['super_admin'])->group(function () { //Apply super_admin middleware
        Route::get('/add-librarian', [AdminController::class, 'addLibrarian'])->name('add-librarian');
    });
});

// Laravel Breeze Auth Routes (keep these as they are)
require __DIR__ . '/auth.php';

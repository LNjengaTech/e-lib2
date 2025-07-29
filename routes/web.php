<?php

use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController; // Import our new controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
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

//library-catalogue
Route::get('/library-catalogue', [CatalogueController::class, 'index']);
// New route for browsing books by category
Route::get('/library-catalogue/category/{category}', [CatalogueController::class, 'browseByCategory'])->name('catalogue.byCategory');


//book with id
Route::get('/book/{id}', [CatalogueController::class, 'show']);

//exam-bank
Route::get('/exam-bank', function () {
    return response('<p>Exams Coming Soon!!</p>');
});

//! USER -- Add them to the authenticated routes later


// Authenticated User Routes (Student/General User)
Route::middleware(['auth', 'verified'])->group(function () {
    //User dashboard
    Route::get('/user-dashboard', [UserController::class, 'dashboard'])->name('user-dashboard');

    // Returned books
    Route::get('/returned-books', [UserController::class, 'myReturnedBooks'])->name('returned-books');

    // Borrowed books
    Route::get('/borrowed-books', [UserController::class, 'myBorrowedBooks'])->name('borrowed-books');

    //User penalties
    Route::get('/my-penalties', [UserController::class, 'myPenalties'])->name('my-penalties');


    // Breeze Profile Routes (keep these as they are)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/books', [AdminController::class, 'manageBooks'])->name('books');
    Route::post('/books', [AdminController::class, 'storeBook'])->name('books.store');

    // Routes for editing and deleting books
    Route::put('/books/{book}', [AdminController::class, 'updateBook'])->name('books.update');
    Route::delete('/books/{book}', [AdminController::class, 'destroyBook'])->name('books.destroy');

    Route::get('/loans', [AdminController::class, 'manageLoans'])->name('loans');
    Route::get('/reservations', [AdminController::class, 'manageReservations'])->name('reservations');
    Route::get('/fines', [AdminController::class, 'manageFines'])->name('fines');
    Route::get('/members', [AdminController::class, 'manageMembers'])->name('members');

    // Super Admin Specific Routes (will be further restricted later)
    Route::get('/add-librarian', [AdminController::class, 'addLibrarian'])->name('add-librarian');
});

// Laravel Breeze Auth Routes (keep these as they are)
require __DIR__ . '/auth.php';



// use App\Http\Controllers\ProfileController;
// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
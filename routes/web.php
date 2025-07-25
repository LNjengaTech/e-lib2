<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController; // Import our new controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CatalogueController;
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
// Route::get('/', [HomeController::class, 'index'])->name('welcome');
// Route::get('/books/browse', [UserController::class, 'browseBooks'])->name('books.browse'); // Accessible by anyone

//home page
Route::get('/', function() {
    return view('welcome');
});

//library-catalogue
Route::get('/library-catalogue', [CatalogueController::class, 'index']);

//book with id
Route::get('/book/{id}', [CatalogueController::class, 'show']);

//exam-bank
Route::get('/exam-bank', function() {
    return response('<p>Exams Coming Soon!!</p>');
});

// Authenticated User Routes (Student/General User)
// The 'auth' middleware ensures only logged-in users can access these.
// The 'verified' middleware ensures only email-verified users can access these.
Route::middleware(['auth', 'verified'])->group(function () {
    // User Dashboard (default Breeze dashboard route modified)
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // User-specific library routes
    Route::get('/my-borrowed-books', [UserController::class, 'myBorrowedBooks'])->name('user.my-borrowed-books');

    // Breeze Profile Routes (keep these as they are)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin Routes
// We'll create a new middleware 'admin' later to restrict access to librarians and super admins.
// For now, any authenticated user can technically access these, but we'll fix that soon.
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/books', [AdminController::class, 'manageBooks'])->name('books');
    Route::get('/loans', [AdminController::class, 'manageLoans'])->name('loans');
    Route::get('/reservations', [AdminController::class, 'manageReservations'])->name('reservations');
    Route::get('/fines', [AdminController::class, 'manageFines'])->name('fines');
    Route::get('/members', [AdminController::class, 'manageMembers'])->name('members'); // New route for managing members

    // Super Admin Specific Routes (will be further restricted later)
    Route::get('/add-librarian', [AdminController::class, 'addLibrarian'])->name('add-librarian');
    // Route::get('/create-student-account', [AdminController::class, 'createStudentAccount'])->name('create-student-account'); // Removed as per new requirement
});

// Laravel Breeze Auth Routes (keep these as they are)
require __DIR__.'/auth.php';













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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Import the Book model
use Illuminate\Validation\ValidationException; // Import ValidationException

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
        $books = Book::all();
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
                'isbn' => 'required|string|unique:books,isbn|max:255', // Ensure ISBN is unique
                'category' => 'required|string|max:255', // New validation rule for category
                'available_copies' => 'required|integer|min:0',
                'cover_image_url' => 'nullable|url|max:2048', // Validate as a URL, optional
            ]);

            // Create a new Book instance and fill it with validated data
            Book::create($validatedData);

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
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function updateBook(Request $request, Book $book)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'isbn' => 'required|string|unique:books,isbn,' . $book->id . '|max:255', // Ensure ISBN is unique, except for the current book
                'category' => 'required|string|max:255',
                'available_copies' => 'required|integer|min:0',
                'cover_image_url' => 'nullable|url|max:2048',
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
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroyBook(Book $book)
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
    public function manageMembers()
    {
        return view('admin-views.manage-members');
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


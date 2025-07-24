<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('admin-views.manage-books');
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

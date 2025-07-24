<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     * Accessible by anyone.
     */
    public function index()
    {
        return view('homepage');
    }
}

<?php

  namespace App\Http\Controllers;
 
  use Illuminate\Http\Request;
 
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
         return view('users-views.my-returned-books');
     }

 
     /**
      * Display the user's borrowed and reserved books.
      * Accessible by authenticated students.
      */
     public function myBorrowedBooks()
     {
         return view('users-views.my-borrowed-books');
    }

    public function myPenalties() {
        return view('users-views.my-penalties');
    }
}
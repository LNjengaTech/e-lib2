<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    //get all books
    public function index()
    {
        //dd(request('search'));
        return view('library-catalogue', [
            'books' => Catalogue::latest()
                ->filter(request(['search', 'tags', 'category']))
                ->paginate(10)
        ]);
    }
}
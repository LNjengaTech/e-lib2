<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    //get all books
    public function index()
    {
        //get categories column from catalogues table
        $categories = Catalogue::select('category')->distinct()->pluck('category');
        //dd(request('search'));
        return view('library-catalogue', [
            'books' => Catalogue::latest()
                ->filter(request(['search', 'tags', 'category']))
                ->paginate(10),
            'categories' => $categories
        ]);
    }

    //get book with id
    public function show($id) {
        return view('book-info', [
            'book' => Catalogue::find($id)
        ]);
    }
}
<?php

namespace App\Http\Controllers\Web;

use App\Models\Author;

class AuthorController extends WebController
{
    public function index()
    {
        $authors = Author::orderBy('id', 'desc')->paginate();

        return view('pages.authors.index', [
            'authors' => $authors,
        ]);
    }
}
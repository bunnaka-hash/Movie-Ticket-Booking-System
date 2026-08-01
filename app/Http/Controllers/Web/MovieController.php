<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->paginate(12);

        return view('pages.movies.index', compact('movies'));
    }

    public function show(Movie $movie)
    {
        return view('pages.movies.show', compact('movie'));
    }
}
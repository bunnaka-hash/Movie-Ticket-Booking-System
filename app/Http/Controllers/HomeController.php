<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch movies with 'now_showing' status, or fall back to latest movies
        $nowShowing = Movie::where('status', 'now_showing')
            ->orWhere('status', null)
            ->latest()
            ->take(4)
            ->get();

        // If no now_showing movies, get the latest ones
        if ($nowShowing->isEmpty()) {
            $nowShowing = Movie::latest()->take(4)->get();
        }

        $comingSoon = Movie::where('status', 'coming_soon')
            ->latest()
            ->take(4)
            ->get();

        return view('home.index', compact(
            'nowShowing',
            'comingSoon'
        ));
    }
}
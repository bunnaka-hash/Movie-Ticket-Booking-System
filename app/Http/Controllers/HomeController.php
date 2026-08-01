<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class HomeController extends Controller
{
    public function index()
    {
        $nowShowing = Movie::where('status', 'now_showing')
            ->take(4)
            ->get();

        $comingSoon = Movie::where('status', 'coming_soon')
            ->take(4)
            ->get();

        return view('home.index', compact(
            'nowShowing',
            'comingSoon'
        ));
    }
}
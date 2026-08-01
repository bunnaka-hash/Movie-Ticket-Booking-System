<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Showtime;
use App\Http\Requests\StoreShowtimeRequest;
use App\Http\Requests\UpdateShowtimeRequest;
use App\Http\Resources\ShowtimeResource;
use App\Http\Resources\MovieResource;
use App\Http\Resources\HallResource;

class ShowtimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Showtime::with(['movie', 'hall']);

        if ($request->filled('movie_id')) {
            $query->where('movie_id', $request->movie_id);
        }

        if ($request->filled('hall_id')) {
            $query->where('hall_id', $request->hall_id);
        }

        $showtimes = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Showtimes retrieved successfully.',
            'data' => ShowtimeResource::collection($showtimes),
            'pagination' => [
                'current_page' => $showtimes->currentPage(),
                'last_page' => $showtimes->lastPage(),
                'per_page' => $showtimes->perPage(),
                'total' => $showtimes->total(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShowtimeRequest $request)
    {
        $showtime = Showtime::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Showtime created successfully.',
            'data' => new ShowtimeResource($showtime),
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(Showtime $showtime)
    {
        $showtime->load(['movie', 'hall']);

        return response()->json([
            'success' => true,
            'message' => 'Showtime retrieved successfully.',
            'data' => new ShowtimeResource($showtime),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShowtimeRequest $request, Showtime $showtime)
    {
        $showtime->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Showtime updated successfully.',
            'data' => new ShowtimeResource($showtime),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Showtime $showtime)
    {
        $showtime->delete();

        return response()->json([
            'success' => true,
            'message' => 'Showtime deleted successfully.',
        ]);
    }
}

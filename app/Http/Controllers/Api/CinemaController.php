<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Cinema;
use App\Http\Requests\StoreCinemaRequest;
use App\Http\Requests\UpdateCinemaRequest;
use App\Http\Resources\CinemaResource;

class CinemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cinemas = Cinema::with('halls')->get();

        return response()->json([
            'success' => true,
            'message' => 'Cinemas retrieved successfully.',
            'data' => CinemaResource::collection($cinemas),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCinemaRequest $request)
    {
        $cinema = Cinema::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Cinema created successfully.',
            'data' => new CinemaResource($cinema),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cinema $cinema)
    {
        $cinema->load('halls');

        return response()->json([
            'success' => true,
            'message' => 'Cinema retrieved successfully.',
            'data' => new CinemaResource($cinema),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCinemaRequest $request, Cinema $cinema)
    {
        $cinema->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Cinema updated successfully.',
            'data' => new CinemaResource($cinema),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cinema $cinema)
    {
        $cinema->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cinema deleted successfully.',
        ]);
    }
}

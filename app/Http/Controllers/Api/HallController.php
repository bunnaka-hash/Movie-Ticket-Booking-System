<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hall;
use App\Http\Resources\HallResource;
use App\Http\Requests\StoreHallRequest;
use App\Http\Requests\UpdateHallRequest;

class HallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $halls = Hall::with('cinema')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Halls retrieved successfully.',
            'data' => HallResource::collection($halls),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHallRequest $request)
    {
        $hall = Hall::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Hall created successfully.',
            'data' => new HallResource($hall),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hall $hall)
    {
        $hall->load('cinema');

        return response()->json([
            'success' => true,
            'message' => 'Hall retrieved successfully.',
            'data' => new HallResource($hall),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHallRequest $request, Hall $hall)
    {
        $hall->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Hall updated successfully.',
            'data' => new HallResource($hall),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hall $hall)
    {
        $hall->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hall deleted successfully.',
        ]);
    }
}

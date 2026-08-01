<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Seat;
use App\Http\Resources\SeatResource;
use App\Http\Requests\StoreSeatRequest;
use App\Http\Requests\UpdateSeatRequest;

class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seats = Seat::with('hall')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Seats retrieved successfully.',
            'data' => SeatResource::collection($seats),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSeatRequest $request)
    {
        $seat = Seat::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Seat created successfully.',
            'data' => new SeatResource($seat),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Seat $seat)
    {
        $seat->load('hall');

        return response()->json([
            'success' => true,
            'message' => 'Seat retrieved successfully.',
            'data' => new SeatResource($seat),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeatRequest $request, Seat $seat)
{
    $seat->update($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'Seat updated successfully.',
        'data' => new SeatResource($seat),
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seat $seat)
    {
        $seat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Seat deleted successfully.',
        ]);
    }
}

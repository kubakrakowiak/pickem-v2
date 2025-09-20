<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePickemRequest;
use App\Http\Requests\UpdatePickemRequest;
use App\Models\Pickem;

class PickemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pickems = Pickem::all();
        return response()->json($pickems, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePickemRequest $request)
    {
        $validated = $request->validated();
        $pickem = $request->user()->pickems()->create($validated);

        return response()->json($pickem, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pickem $pickem)
    {
        return response()->json($pickem, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePickemRequest $request, Pickem $pickem)
    {
        $pickem->update($request->validated());
        return response()->json($pickem, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pickem $pickem)
    {
        $pickem->delete();
        return response()->json(null, 204);
    }

    /**
     * Pickem games.
     */
    public function games(Pickem $pickem)
    {
        return response()->json($pickem->games(), 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompleteGameRequest;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\StorePickemRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Http\Requests\UpdatePickemRequest;
use App\Models\Game;
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

    /**
     * Pickem add game.
     */
    public function storeGame(Pickem $pickem, StoreGameRequest $request)
    {
        $game = $pickem->games()->create($request->validated());
        return response()->json($game, 201);
    }

    /**
     * Update game.
     */
    public function updateGame(Pickem $pickem, Game $game, UpdateGameRequest $request)
    {
        if ($game->pickem_id !== $pickem->id) {
            abort(404);
        }

        $game->update($request->validated());

        return response()->json($game, 200);
    }

    /**
     * Complete the result of a game.
     */
    public function completeGame(Pickem $pickem, Game $game, CompleteGameRequest $request)
    {
        if ($game->pickem_id !== $pickem->id) {
            abort(404);
        }

        $game->update($request->validated());

        return response()->json($game, 200);
    }
    /**
     * Complete the result of a game.
     */
    public function showGame(Pickem $pickem, Game $game)
    {
        if ($game->pickem_id !== $pickem->id) {
            abort(404);
        }

        return response()->json($game, 200);
    }
}

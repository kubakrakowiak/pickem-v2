<?php

use App\Http\Controllers\PickemController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// healthcheck
Route::get('/ping', fn() => response()->json(['message' => 'pong']));

Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'email' => ['required','email'],
        'password' => ['required'],
    ]);

    /** @var User|null $user */
    $user = User::where('email', $data['email'])->first();

    if (! $user || ! Hash::check($data['password'], $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 422);
    }

    // $user->tokens()->where('name','web')->delete();

    $token = $user->createToken('web')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => ['id'=>$user->id, 'name'=>$user->name, 'email'=>$user->email],
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $r) => response()->json($r->user()));

    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()?->delete();
        return response()->json(['message' => 'Logged out']);
    });

    Route::apiResource('pickems', PickemController::class);
    Route::get('pickems/{pickem}/games', [PickemController::class, 'games'])->name('pickems.games');
    Route::post('pickems/{pickem}/games', [PickemController::class, 'storeGame'])->name('pickems.game.store');
    Route::post('pickems/{pickem}/games/{game}', [PickemController::class, 'updateGame'])->name('pickems.game.update');
    Route::post('pickems/{pickem}/games/{game}/complete', [PickemController::class, 'completeGame'])->name('pickems.game.complete');
});

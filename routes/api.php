<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// healthcheck
Route::get('/ping', fn() => response()->json(['message' => 'pong']));

// LOGIN → zwraca Bearer token
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

    // opcjonalnie: usuń stare tokeny tego samego „urządzenia”
    // $user->tokens()->where('name','web')->delete();

    $token = $user->createToken('web')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => ['id'=>$user->id, 'name'=>$user->name, 'email'=>$user->email],
    ]);
});

// chronione endpointy (wymagają Authorization: Bearer <token>)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn(Request $r) => response()->json($r->user()));

    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()?->delete();
        return response()->json(['message' => 'Logged out']);
    });
});

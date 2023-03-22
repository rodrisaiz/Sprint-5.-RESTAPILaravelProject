<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/players', [UserController::class, 'index']);
Route::post('/players', [UserController::class, 'store']);
Route::get('/players/{id}', [UserController::class, 'show']);
Route::put('/players/{id}', [UserController::class, 'update']);
Route::delete('/players/{id}', [UserController::class, 'destroy']);




/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
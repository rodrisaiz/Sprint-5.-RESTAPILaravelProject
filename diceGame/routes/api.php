<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// No authentication needed routes

Route::post('/player/register', [UserController::class, 'register']);
Route::post('/player/login', [UserController::class, 'login']);
Route::get('/players', [UserController::class, 'index']);
Route::get('/players/ranking', [UserController::class, 'rank']);


// Authentication needed routes

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('/players/{id}', [UserController::class, 'show']);
    Route::put('/players/{id}', [UserController::class, 'update']);
    Route::delete('/player/{id}', [UserController::class, 'destroy']);
    Route::get('/players/ranking/loser', [UserController::class, 'rank_loser']);
    Route::get('/players/ranking/winner', [UserController::class, 'rank_winner']);

    Route::post('/players/{id}/games', [GameController::class, 'roll']);
    Route::delete('/players/{id}/games', [GameController::class, 'destroy']);

});



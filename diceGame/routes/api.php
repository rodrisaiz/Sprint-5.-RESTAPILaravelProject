<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/players', [UserController::class, 'index']);
Route::post('/player', [UserController::class, 'store']);
Route::get('/player/{id}', [UserController::class, 'show']);
Route::put('/player/{id}', [UserController::class, 'update']);
Route::delete('/player/{id}', [UserController::class, 'destroy']);

Route::post('/players/{id}/games', [GameController::class, 'roll']);
Route::delete('/players/{id}/games', [GameController::class, 'destroy']);
Route::get('/players/ranking', [GameController::class, 'rank']);
Route::get('/players/ranking/loser', [GameController::class, 'rank_loser']);
Route::get('/players/ranking/winner', [GameController::class, 'rank_winner']);


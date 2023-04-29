<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// No authentication needed routes

Route::post('/players/register', [UserController::class, 'register'])->missing(function(){
    return response(['error_message' => 'Ooops! 404'], 404)->header('Content-Type','text/plain');
});

Route::post('/players/login', [UserController::class, 'login'])->missing(function(){
    return response(['error_message' => 'Ooops! 404'], 404)->header('Content-Type','text/plain');
});

Route::get('/players/ranking', [UserController::class, 'rank'])->missing(function(){
    return response(['error_message' => 'Ooops! 404'], 404)->header('Content-Type','text/plain');
});


// Authentication needed routes

Route::GROUP(['middleware' => ['auth:api']], function () {

    Route::get('/players', [UserController::class, 'index'])->missing(function(){
        return response(['error_message' => 'Ooops! 404'], 404)->header('Content-Type','text/plain');
    });

    Route::get('/players/{id}', [UserController::class, 'show'])->missing(function(){
        return response(['error_message' => 'Ooops! 404'], 404)->header('Content-Type','text/plain');
    });


    Route::put('/players/{id}', [UserController::class, 'update'])->missing(function(){
        return response(['error_message' => 'Ooops! 404'], 404)->header('Content-Type','text/plain');
    });

    Route::delete('/players/{id}', [UserController::class, 'destroy'])->missing(function(){
        return response(['error_message' => 'Ooops! 404'], 404)->header('Content-Type','text/plain');
    });

    Route::get('/players/ranking/loser', [UserController::class, 'rank_loser'])->missing(function(){
        return response(['error_message' => 'Ooops! 404'], 404)->header('Content-Type','text/plain');
    });

    Route::get('/players/ranking/winner', [UserController::class, 'rank_winner'])->missing(function(){
        return response(['error_message' => 'Ooops! 404'], 404)->header('Content-Type','text/plain');
    });

    Route::post('/players/{id}/games', [GameController::class, 'roll'])->missing(function(){
        return response(['error_message' => 'Ooops! 404'], 404)->header('Content-Type','text/plain');
    });

    Route::get('/players/{id}/games', [GameController::class, 'show'])->missing(function(){
        return response(['error_message' => 'Ooops! 404'], 404)->header('Content-Type','text/plain');
    });

    Route::delete('/players/{id}/games', [GameController::class, 'destroy'])->missing(function(){
        return response(['error_message' => 'Ooops! 404'], 404)->header('Content-Type','text/plain');
    });



});



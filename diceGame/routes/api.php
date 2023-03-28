<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/player/register', [UserController::class, 'register']);
Route::post('/player/login', [UserController::class, 'login']);
Route::get('/players', [UserController::class, 'index']);

Route::group(['middleware' => ['auth:api']], function () {

    
    Route::get('/players/{id}', [UserController::class, 'show']);
    Route::put('/players/{id}', [UserController::class, 'update']);
    Route::delete('/player/{id}', [UserController::class, 'destroy']);

    Route::post('/players/{id}/games', [GameController::class, 'roll']);
    Route::delete('/players/{id}/games', [GameController::class, 'destroy']);
    Route::get('/players/ranking', [GameController::class, 'rank']);
    Route::get('/players/ranking/loser', [GameController::class, 'rank_loser']);
    Route::get('/players/ranking/winner', [GameController::class, 'rank_winner']);


});




/*    

Route::group(['middleware' => ['cors', 'json.response']], function () {

    // ...

    // public routes
    Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');
    Route::post('/register','Auth\ApiAuthController@register')->name('register.api');
    Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');

    // ...

});

Route::get('/players', [UserController::class, 'index']);
Route::get('/players/{id}', [UserController::class, 'show'])->middleware('auth:api');
Route::put('/players/{id}', [UserController::class, 'update']);
Route::delete('/player/{id}', [UserController::class, 'destroy']);

Route::post('/players/{id}/games', [GameController::class, 'roll']);
Route::delete('/players/{id}/games', [GameController::class, 'destroy']);
Route::get('/players/ranking', [GameController::class, 'rank']);
Route::get('/players/ranking/loser', [GameController::class, 'rank_loser']);
Route::get('/players/ranking/winner', [GameController::class, 'rank_winner']);

*/
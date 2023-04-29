<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{

    public function roll($id)
    {
        $user = auth()->user();

        if($user->admin_role == 'Admin' || $user->id == $id)
        {

                $user = User::find($id);
                 
                $dice_1 = rand(1,5);

                $dice_2 = rand(1,5);

                $total_dices = $dice_1 + $dice_2;

                if($total_dices == 7){

                    $user->total_wins = $user->total_wins + 1;
                
                }

                $user->total_games = $user->total_games + 1;

                $user->winning_percentage = ($user->total_wins * 100) / $user->total_games;

                $user->save();

                
                $game = Game::create([
                    
                    'player_id' => $id,
                    'dice_1' => $dice_1,
                    'dice_2' => $dice_2,
                    'result' => $total_dices
          
                ]);

            return response(['game' => $game
                , 'message' => "You have roll the dices!"]
            , 201 );

        }else{

            return response([
                'error_message' => "Sorry! You don't have access"
            ], 401 );

        }
        
    }





    public function destroy($id)
    {
        $user = auth()->user();

        if($user->admin_role == 'Admin' || $user->id == $id)
        {

            foreach(Game::all() as $game){

                if($game->player_id == $id){

                    Game::destroy($game->id);
        
                }
            }

            return response([
                'message' => "The games have been destroyed!!"
            ], 200 );

        }else{

            return response([
                'error_message' => "Sorry! You don't have access"
            ], 401 );

        }
    }

    public function show($id)
    {
        $user = auth()->user();
        $list_of_games = array();
        

        if($user->admin_role == 'Admin' || $user->id == $id)
        {
            foreach(Game::all() as $one_game){

                if($one_game->player_id == $id){

                    array_push($list_of_games, $one_game);
    
                }
            }
            return $list_of_games;

            return response(['list_of_games' => $list_of_games
                , 'message' => "Successful access!"]
            , 201 );
            

        }else{

            return response([
                'error_message' => "Sorry! You don't have access"
            ], 401 );

        }
    }


}

?>


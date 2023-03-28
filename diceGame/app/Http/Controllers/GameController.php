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

        if($user->admin_roll == 'Admin' || $user->id == $id)
        {

                $user = User::find($id);
                //totla game
                //total wins 
                
                $dice = rand(1,5) + rand(1,5);

                if($dice == 7){

                    $user->total_wins = $user->total_wins + 1;
                
                }

                $user->total_games = $user->total_games + 1;

                $user->winning_percentage = ($user->total_wins * 100) / $user->total_games;

                $user->save();

                
                $game = Game::create([
                    
                    'player_id' => $id,
                    'result' => $dice,
                    
                    
                ]);

            return  $game;

        }else{

            return response([
                'error_message' => "Sorry! You don't have access"
            ], 401 );

        }
    }


    public function destroy($id)
    {
        $user = auth()->user();

        if($user->admin_roll == 'Admin' || $user->id == $id)
        {

            foreach(Game::all() as $game){

                if($game->player_id == $id){

                    Game::destroy($game->id);
        
                }
            }

        }else{

            return response([
                'error_message' => "Sorry! You don't have access"
            ], 401 );

        }
    
    }


    public function rank()
    {
        $players = User::orderBy('winning_percentage','desc')->get();
      

        return $players;

    }


    public function rank_loser()
    {

        $player = User::where('total_games', '!=', null)->orderBy('winning_percentage', 'asc')->get()->first();
      
        return $player;

    }


    public function rank_winner()
    {

        $player = User::orderBy('winning_percentage', 'desc')->get()->first();
      
        return $player;

    }

}

?>


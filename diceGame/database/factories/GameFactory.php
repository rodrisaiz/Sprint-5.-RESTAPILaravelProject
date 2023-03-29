<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Game;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [

            'player_id' =>fake()->numberBetween(1,50),
            'result' => fake()->numberBetween(1,12),
            
        ];


/*
        return [

            'player_id' => fake()->numberBetween(1,50),
            'result' => fake()->unique()->safeEmail(),
            `updated_at` => fake()->dateTime(),
            `created_at` => fake()->dateTime(),
        ];


        $game = new Game();

        $player_id = fake()->numberBetween(1,50);

        return [

            'player_id' => $player_id,
            'result' => $game->roll($player_id),
            
        ];

        


        $game = new Game();

        $game->id_player = rand(1,50);
        //$game->result = $game->roll($game->id_player);

        $game->save();

                    /*    
                    $user = User::find(rand(1,50));
                        
                
                    
                    $dice = rand(1,5) + rand(1,5);


    
                    if($dice == 7){
    
                    $total_wins = $user->total_wins + 1;
                    
                    }
    
                    $total_games = $user->total_games + 1;
    
                    $winning_percentage = ($user->total_wins * 100) / $user->total_games;
    
                    $user->save();
    
                     

                    Game::roll(rand(1,50));
                    *Game::create([
                        
                        'player_id' => $user->id,
                        'result' => $dice,
                        
                    ]);

                        return [

                            'username' => $user->username,
                            'email' => $user->email,
                            'email_verified_at' => $user->email_verofoed_at,
                            'password' => $user->password, 
                            'remember_token' => $user->remember_token,
                            'admin_roll' => $user->admin_roll,
                            'total_games' => $total_games,
                            'total_wins' => $total_wins,
                            'winning_percentage' => $winning_percentage,

                                        
                    
                ];

                $game = Game()->roll(rand(1,50));
    */
            
        
               


               
    }
}

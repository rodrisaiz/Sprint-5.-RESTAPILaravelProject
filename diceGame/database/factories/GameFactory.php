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

        $dice_1 = rand(1,5);

        $dice_2 = rand(1,5);

        $total_dices = $dice_1 + $dice_2;

        return [

            'player_id' => User::factory(),
            'dice_1' => $dice_1,
            'dice_2' => $dice_2,
            'result' => $total_dices
            
        ];
     
    }
}

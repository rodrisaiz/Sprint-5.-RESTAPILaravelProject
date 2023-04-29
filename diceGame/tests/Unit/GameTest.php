<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Game;
use App\Models\User;
//use Illuminate\Support\Facades\Auth;
//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\Passport;

class GameTest extends TestCase
{
    //Testing all the game routes


     //Testing -> Route::post('/players/{id}/games', [GameController::class, 'roll']);

        public function test_roll_dice_admin():void
        {
            // Data needed for the test
            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

            }

            $user = User::orderBy('id', 'desc')->get()->first();


              // Validation admin 
              Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'Admin',
        
        
                ]),
                ['create-servers']
                );
         
            //Test

            $response = $this->postJson("api/players/{$user->id}/games");
    
            $response->assertStatus(201);

            //Restoring of DB

            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }


        
        public function test_roll_dice_valid_user():void
        {


            // Data needed for the test 

            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

            }

            // Validation user 

            Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
        
        
                ]),
                ['create-servers']
                );

            $user = User::orderBy('id', 'desc')->get()->first();
         
            //Test

            $response = $this->postJson("api/players/{$user->id}/games");
    
            $response->assertStatus(201);

            //Restoring of DB

            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }

        public function test_roll_dice_invalid_user():void
        {

            // Creating of invalid user

            Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
        
        
                ]),
                ['create-servers']
                );
        
            // Data needed for the test 
         
            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

            }

        

            $user = User::orderBy('id', 'desc')->get()->first();
         
            //Test

            $response = $this->postJson("api/players/{$user->id}/games");
    
            $response->assertStatus(401);


            //Restoring of DB

            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }

        public function test_roll_dice_invalid_acces():void
        {
           
            // Data needed for the test
         
            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

            }

        

            $user = User::orderBy('id', 'desc')->get()->first();
         
            //Test

            $response = $this->postJson("api/players/24/games");
    
            $response->assertStatus(401);

            //Restoring of DB

            for($i = 0; $i <= 5; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }

        //Testing -> Route::delete('/players/{id}/games', [GameController::class, 'destroy']);


        public function test_delete_game_admin():void
        {


            // Data needed for the test 

            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

                $user = User::orderBy('id', 'desc')->get()->first();

                $dice_1 = rand(1,5);

                $dice_2 = rand(1,5);

                $total_dices = $dice_1 + $dice_2;

                Game::factory()->create([

                    'player_id' =>  $user->id,
                    'dice_1' => $dice_1,
                    'dice_2' => $dice_2,
                    'result' => $total_dices,  
        
                ]);



            }


            $user = User::orderBy('id', 'desc')->get()->first();


            // Validation Admin

            Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'Admin',
        
        
                ]),
                ['create-servers']
                );
         
         
            //Test

            $response = $this->deleteJson("api/players/{$user->id}/games");
    
            $response->assertStatus(200);


            //Restoring of DB

            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }

        public function test_delete_game_invalid_user():void
        {

            // Data needed for the test

            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

                $user = User::orderBy('id', 'desc')->get()->first();

                $dice_1 = rand(1,5);

                $dice_2 = rand(1,5);

                $total_dices = $dice_1 + $dice_2;

                Game::factory()->create([

                    'player_id' =>  $user->id,
                    'dice_1' => $dice_1,
                    'dice_2' => $dice_2,
                    'result' => $total_dices,  
        
                ]);



            }

        

            $user = User::orderBy('id', 'desc')->get()->first();


            // Validation user

            Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
        
        
                ]),
                ['create-servers']
                );
         
         
            //Test

            $response = $this->deleteJson("api/players/{$user->id}/games");
    
            $response->assertStatus(401);
            

            //Restoring of DB

            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }

        public function test_delete_game_valid_user():void
        {

        
            // Data needed for the test 

            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

                $user = User::orderBy('id', 'desc')->get()->first();

                $dice_1 = rand(1,5);

                $dice_2 = rand(1,5);

                $total_dices = $dice_1 + $dice_2;

                Game::factory()->create([

                    'player_id' =>  $user->id,
                    'dice_1' => $dice_1,
                    'dice_2' => $dice_2,
                    'result' => $total_dices,  
        
                ]);


            }

            // Validation user

            Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
        
        
                ]),
                ['create-servers']
                );

                $user = User::orderBy('id', 'desc')->get()->first();
         
         
            //Test

            $response = $this->deleteJson("api/players/{$user->id}/games");
    
            $response->assertStatus(200);
            

            //Restoring of DB

            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }


        public function test_delete_game_invalid_acces():void
        {

            // Data needed for the test
        
            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

                $user = User::orderBy('id', 'desc')->get()->first();

                $dice_1 = rand(1,5);

                $dice_2 = rand(1,5);

                $total_dices = $dice_1 + $dice_2;

                Game::factory()->create([

                    'player_id' =>  $user->id,
                    'dice_1' => $dice_1,
                    'dice_2' => $dice_2,
                    'result' => $total_dices,  
        
                ]);


            }


            $user = User::orderBy('id', 'desc')->get()->first();
         
         
            //$Test

            $response = $this->deleteJson("api/players/{$user->id}/games");
    
            $response->assertStatus(401);
            

            //Restoring of DB

            for($i = 0; $i <= 5; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }

/*
test nuevos
*/

        public function test_get_all_the_games_from_an_speciific_player_invalid_acces():void
        {

            // Data needed for the test
        
            for($i = 0; $i <= 4; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

            }

                $user = User::orderBy('id', 'desc')->get()->first();

                for($i = 0; $i <= 5; $i++){

                    $dice_1 = rand(1,5);

                    $dice_2 = rand(1,5);

                    $total_dices = $dice_1 + $dice_2;

                    Game::factory()->create([

                        'player_id' =>  $user->id,
                        'dice_1' => $dice_1,
                        'dice_2' => $dice_2,
                        'result' => $total_dices,  
            
                    ]);

                }

            


            $test_user = User::orderBy('id', 'desc')->get()->first();
         
         
            //$Test

            $response = $this->getJson("api/players/{$test_user->id}/games");
    
            $response->assertStatus(401);
            

            //Restoring of DB

            for($i = 0; $i <= 4; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);
    
            }
    
            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);

        }


        public function test_get_all_the_games_from_an_speciific_player_valid_acces():void
        {

            // Data needed for the test
        
            for($i = 0; $i <= 4; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

            }

                $user = User::orderBy('id', 'desc')->get()->first();

                for($i = 0; $i <= 5; $i++){

                    $dice_1 = rand(1,5);

                    $dice_2 = rand(1,5);

                    $total_dices = $dice_1 + $dice_2;

                    Game::factory()->create([

                        'player_id' =>  $user->id,
                        'dice_1' => $dice_1,
                        'dice_2' => $dice_2,
                        'result' => $total_dices,  
            
                    ]);

                }

            


            $test_user = User::orderBy('id', 'desc')->get()->first();
         

            Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'Admin',
        
        
                ]),
                ['create-servers']
                );

         
            //$Test

            $response = $this->getJson("api/players/{$test_user->id}/games");
    
            $response->assertStatus(200);
            

            //Restoring of DB

            for($i = 0; $i <= 5; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);
    
            }
    
            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);

        }


        public function test_get_all_the_games_from_an_unexisting_player_valid_acces():void
        {

            // Data needed for the test
        
            for($i = 0; $i <= 4; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

            }

                $user = User::orderBy('id', 'desc')->get()->first();

                for($i = 0; $i <= 5; $i++){

                    $dice_1 = rand(1,5);

                    $dice_2 = rand(1,5);

                    $total_dices = $dice_1 + $dice_2;

                    Game::factory()->create([

                        'player_id' =>  $user->id,
                        'dice_1' => $dice_1,
                        'dice_2' => $dice_2,
                        'result' => $total_dices,  
            
                    ]);

                }

            


            $test_user = User::orderBy('id', 'desc')->get()->first();

            $id = $test_user->id + 2;
         

            Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_role' => 'Admin',
        
        
                ]),
                ['create-servers']
                );

         
            //$Test

            $response = $this->getJson("api/players/{$id}/games");
    
            $response->assertStatus(200);
            

            //Restoring of DB

            for($i = 0; $i <= 5; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);
    
            }
    
            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);

        }


   
}

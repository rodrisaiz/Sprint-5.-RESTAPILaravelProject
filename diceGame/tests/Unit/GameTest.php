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
    /**
     * A basic unit test example.
     */


     //Route::post('/players/{id}/games', [GameController::class, 'roll']);

        public function test_roll_dice_admin():void
        {

        

            //$token = User::find(3)->createToken('API Token')->accessToken;


    
            //$user = User::create($data);
    
            //$token = $user->createToken('API Token')->accessToken;

            //$user2 = [ 'user' => $user, 'token' => $token];
            Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'Admin',
        
        
                ]),
                ['create-servers']
                );

         
            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

            }

            $user = User::orderBy('id', 'desc')->get()->first();
         
            //$response = $this->post('/api/create-server');

            $response = $this->postJson("api/players/{$user->id}/games");
    
            $response->assertStatus(201);


            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }

        public function test_roll_dice_valid_user():void
        {

        

            //$token = User::find(3)->createToken('API Token')->accessToken;


    
            //$user = User::create($data);
    
            //$token = $user->createToken('API Token')->accessToken;

            //$user2 = [ 'user' => $user, 'token' => $token];
        
         
            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

            }

            Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'User',
        
        
                ]),
                ['create-servers']
                );

            $user = User::orderBy('id', 'desc')->get()->first();
         
            //$response = $this->post('/api/create-server');

            $response = $this->postJson("api/players/{$user->id}/games");
    
            $response->assertStatus(201);


            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }

        public function test_roll_dice_invalid_user():void
        {

        

            //$token = User::find(3)->createToken('API Token')->accessToken;


    
            //$user = User::create($data);
    
            //$token = $user->createToken('API Token')->accessToken;

            //$user2 = [ 'user' => $user, 'token' => $token];

            Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'User',
        
        
                ]),
                ['create-servers']
                );
        
         
            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

            }

        

            $user = User::orderBy('id', 'desc')->get()->first();
         
            //$response = $this->post('/api/create-server');

            $response = $this->postJson("api/players/{$user->id}/games");
    
            $response->assertStatus(401);


            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }

        public function test_roll_dice_invalid_acces():void
        {

        

            //$token = User::find(3)->createToken('API Token')->accessToken;


    
            //$user = User::create($data);
    
            //$token = $user->createToken('API Token')->accessToken;

            //$user2 = [ 'user' => $user, 'token' => $token];

        
        
         
            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

            }

        

            $user = User::orderBy('id', 'desc')->get()->first();
         
            //$response = $this->post('/api/create-server');

            $response = $this->postJson("api/players/24/games");
    
            $response->assertStatus(401);


            for($i = 0; $i <= 5; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }

        //Route::delete('/players/{id}/games', [GameController::class, 'destroy']);


        public function test_delete_game_admin():void
        {

        

            //$token = User::find(3)->createToken('API Token')->accessToken;


    
            //$user = User::create($data);
    
            //$token = $user->createToken('API Token')->accessToken;

            //$user2 = [ 'user' => $user, 'token' => $token];

        
            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

                $user = User::orderBy('id', 'desc')->get()->first();

                Game::factory()->create([

                    'player_id' =>  $user->id,
                    'result' => fake()->numberBetween(1,12),  
        
                ]);



            }

        

            $user = User::orderBy('id', 'desc')->get()->first();


            Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'Admin',
        
        
                ]),
                ['create-servers']
                );
         
         
            //$response = $this->post('/api/create-server');

            $response = $this->deleteJson("api/players/{$user->id}/games");
    
            $response->assertStatus(200);
            


            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }

        public function test_delete_game_invalid_user():void
        {

        

            //$token = User::find(3)->createToken('API Token')->accessToken;


    
            //$user = User::create($data);
    
            //$token = $user->createToken('API Token')->accessToken;

            //$user2 = [ 'user' => $user, 'token' => $token];

        
            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

                $user = User::orderBy('id', 'desc')->get()->first();

                Game::factory()->create([

                    'player_id' =>  $user->id,
                    'result' => fake()->numberBetween(1,12),  
        
                ]);



            }

        

            $user = User::orderBy('id', 'desc')->get()->first();


            Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'User',
        
        
                ]),
                ['create-servers']
                );
         
         
            //$response = $this->post('/api/create-server');

            $response = $this->deleteJson("api/players/{$user->id}/games");
    
            $response->assertStatus(401);
            


            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }

        public function test_delete_game_valid_user():void
        {

        

            //$token = User::find(3)->createToken('API Token')->accessToken;


    
            //$user = User::create($data);
    
            //$token = $user->createToken('API Token')->accessToken;

            //$user2 = [ 'user' => $user, 'token' => $token];

        
            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

                $user = User::orderBy('id', 'desc')->get()->first();

                Game::factory()->create([

                    'player_id' =>  $user->id,
                    'result' => fake()->numberBetween(1,12),  
        
                ]);

            }


            Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'User',
        
        
                ]),
                ['create-servers']
                );

                $user = User::orderBy('id', 'desc')->get()->first();
         
         
            //$response = $this->post('/api/create-server');

            $response = $this->deleteJson("api/players/{$user->id}/games");
    
            $response->assertStatus(200);
            


            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }


        public function test_delete_game_invalid_acces():void
        {

        

            //$token = User::find(3)->createToken('API Token')->accessToken;


    
            //$user = User::create($data);
    
            //$token = $user->createToken('API Token')->accessToken;

            //$user2 = [ 'user' => $user, 'token' => $token];

        
            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'User',
                    'total_games' => fake()->numberBetween(1,100),
                    'total_wins' => fake()->numberBetween(1,50),
                    'winning_percentage' => fake()->numberBetween(1,50),
        
                ]);

                $user = User::orderBy('id', 'desc')->get()->first();

                Game::factory()->create([

                    'player_id' =>  $user->id,
                    'result' => fake()->numberBetween(1,12),  
        
                ]);

            }


            $user = User::orderBy('id', 'desc')->get()->first();
         
         
            //$response = $this->post('/api/create-server');

            $response = $this->deleteJson("api/players/{$user->id}/games");
    
            $response->assertStatus(401);
            


            for($i = 0; $i <= 5; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }


    /*

    --Route::post('/players/{id}/games', [GameController::class, 'roll']);
    --Route::delete('/players/{id}/games', [GameController::class, 'destroy']);

    */
   
}

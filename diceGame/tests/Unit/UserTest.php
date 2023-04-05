<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\Passport;


class UserTest extends TestCase
{

    /**
     * A basic unit test example.
     */

     // Route::post('/player/register', [UserController::class, 'register']);


     //Valid register request
    public function test_register_valid_form():void
    {

     
/*
------------------------------
        User::factory()->create([

            'username' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
            'admin_roll' => fake()->randomElement(['Admin' ,'User']),


        ]);
------------------------
        
*/


        // Preparation 

        $user = [

            'username' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
            'admin_roll' => 'Admin',
            
        ];

        // Test 

        $response = $this->postJson('api/player/register', $user);

        $response->assertStatus(200);


        // Restauration of DB

        $userCreated = User::orderBy('id', 'desc')->get()->first();
        
        User::destroy($userCreated->id);

        $response= $this->assertDatabaseMissing('users',[
            
        'id' => $userCreated->id ]);
        
        
    }


    //Invalid register request


    public function test_register_invalid_form():void
    {
        
/*

--------------------------
        User::factory()->create([

            'username' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
            'admin_roll' => fake()->randomElement(['Admin' ,'User']),


        ]);
------------------------------
*/


         // Preparation 

         $user = [

            'username' => fake()->name(),
            'email' => '',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
            'admin_roll' => 'Admin',
            
        ];

        $response = $this->postJson('api/player/register',$user);

        //$response->assertJsonFragment(['422']);
        $response->assertStatus(422);
        
    }



    public function test_register_invalid_form_user_already_exist():void
    {


         // Preparation 

         $user = [

            'username' => fake()->name(),
            'email' => 'rodrisaiz@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
            'admin_roll' => 'Admin',
            
        ];


         
        User::factory()->create($user);

        $response = $this->postJson('api/player/register',$user);

     
        $response->assertStatus(422);


        // Restauration of DB

        $userCreated = User::orderBy('id', 'desc')->get()->first();
        
        User::destroy($userCreated->id);

        $response= $this->assertDatabaseMissing('users',[
            
        'id' => $userCreated->id ]);
        
    }
    

//Route::post('/player/login', [UserController::class, 'login']);

    public function test_login_valid():void
    {


        $user = [
            'username' =>  "Rodri",
            'email' => 'user@user.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1234'),
            'admin_roll' => 'Admin',
        ];

        User::factory()->create($user);

        $user2 = [
            'username' =>  "Rodri",
            'email' => 'user@user.com',
            'email_verified_at' => now(),
            'password' => '1234',
            'admin_roll' => 'Admin',
        ];


        $response = $this->postJson('api/player/login', $user2);

 
        $response->assertStatus(200);



    // Restauration of DB

    $userCreated = User::orderBy('id', 'desc')->get()->first();
        
    User::destroy($userCreated->id);

    $response= $this->assertDatabaseMissing('users',[
        
    'id' => $userCreated->id ]);


    }



    public function test_login_invalid():void
    {

     $user = [

        'username' => fake()->name(),
        'email' => '123456879@gmail.com',
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
        'admin_roll' => 'Admin',
        
    ];

    $response = $this->postJson('api/player/login',$user);

 
    $response->assertStatus(422);

    }

    public function test_login_no_data():void
    {

     $user = [

        'username' => '',
        'email' => '',
        'email_verified_at' => '',
        'password' => '', 
        'admin_roll' => '',
        
    ];

    $response = $this->postJson('api/player/login',$user);

 
    $response->assertStatus(422);

    }


    //Route::get('/players', [UserController::class, 'index']);

    public function test_get_all_the_players_no_data():void
    {

    $response = $this->getJson('api/players');

 
    $response->assertStatus(200);

    }



    public function test_get_all_the_players_with_data():void
    {

        $user = [
            'username' =>  "Rodri",
            'email' => 'user@user.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1234'),
            'admin_roll' => 'Admin',
        ];

        User::factory()->create($user);


        $response = $this->getJson('api/players');

    
        $response->assertStatus(200);


        $userCreated = User::orderBy('id', 'desc')->get()->first();
            
        User::destroy($userCreated->id);

        $response= $this->assertDatabaseMissing('users',[
            
        'id' => $userCreated->id ]);

        }

        //Route::get('/players/ranking', [GameController::class, 'rank']);

        public function test_rank_all_the_players_no_data():void
        {

        $response = $this->getJson('api/players/ranking');

    
        $response->assertStatus(200);

        }

        public function test_rank_all_the_players_with_data():void
        {



            $user = [
                'username' =>  "Rodri",
                'email' => 'user@user.com',
                'email_verified_at' => now(),
                'password' => bcrypt('1234'),
                'admin_roll' => 'Admin',
                'total_games' => 80,
                'total_wins' => 30,
                'winning_percentage' => 26,

            ];
    
            User::factory()->create($user);

            $user2 = [
                'username' =>  "Rodris",
                'email' => 'user2@user.com',
                'email_verified_at' => now(),
                'password' => bcrypt('1234'),
                'admin_roll' => 'Admin',
                'total_games' => 100,
                'total_wins' => 50,
                'winning_percentage' => 50,
            ];
    
            User::factory()->create($user2);
    
    
            $response = $this->getJson('api/players/ranking');
    
        
            $response->assertStatus(200);
    
    
            $userCreated = User::orderBy('id', 'desc')->get()->first();
                
            User::destroy($userCreated->id);
    
            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);
            
            $userCreated = User::orderBy('id', 'desc')->get()->first();
                
            User::destroy($userCreated->id);
    
            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);
            
        

        }

        //Route::get('/players/{id}', [UserController::class, 'show']); -- midellwear 


        public function test_show_a_specific_player_valid_access():void
        {

           
            

            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'Admin',
                    'total_games' => 80,
                    'total_wins' => 30,
                    'winning_percentage' => 26,
        
                ]);

            }
        

            //$token = User::find(3)->createToken('API Token')->accessToken;
/*
            $data = [

                'username' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => bcrypt('1234'),
                'admin_roll' => 'Admin',
                
            ];

    
            $user = User::create($data);
    
            $token = $user->createToken('API Token')->accessToken;

            $user2 = [ 'user' => $user, 'token' => $token];
*/

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

            $response = $this->getJson('api/players/3');
    
        
            $response->assertStatus(200);


            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }
        
            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);
          

        }


        public function test_show_a_specific_player_that_don´t_exist_admin_roll():void
        {

        

            //$token = User::find(3)->createToken('API Token')->accessToken;
/*
            $data = [

                'username' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => bcrypt('1234'),
                'admin_roll' => 'Admin',
                
            ];

    
            $user = User::create($data);
    
            $token = $user->createToken('API Token')->accessToken;

            $user2 = [ 'user' => $user, 'token' => $token];
*/

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

            $response = $this->getJson('api/players/5');
    
        
            $response->assertStatus(200);



            $userCreated = User::orderBy('id', 'desc')->get()->first();
            
            User::destroy($userCreated->id);

        
            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);
          

        }

        public function test_show_a_specific_player_that_don´t_exist_user_roll():void
        {

        

            //$token = User::find(3)->createToken('API Token')->accessToken;
/*
            $data = [

                'username' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => bcrypt('1234'),
                'admin_roll' => 'Admin',
                
            ];

    
            $user = User::create($data);
    
            $token = $user->createToken('API Token')->accessToken;

            $user2 = [ 'user' => $user, 'token' => $token];
*/

            Passport::actingAs(

                User::factory()->create([

                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'user',
        
        
                ]),
                ['create-servers']
            );
         
            //$response = $this->post('/api/create-server');

            $response = $this->getJson('api/players/5');
    
        
            $response->assertStatus(401);



            $userCreated = User::orderBy('id', 'desc')->get()->first();
            
            User::destroy($userCreated->id);

        
            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);
          

        }

        public function test_show_a_specific_player_invalid_access():void
        {

           
            
/*
            for($i = 0; $i <= 5; $i++){

                User::factory()->create([

                
                    'username' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'),
                    'admin_roll' => 'Admin',
                    'total_games' => 80,
                    'total_wins' => 30,
                    'winning_percentage' => 26,
        
                ]);

            }
        */

            //$token = User::find(3)->createToken('API Token')->accessToken;
/*
            $data = [

                'username' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => bcrypt('1234'),
                'admin_roll' => 'Admin',
                
            ];

    
            $user = User::create($data);
    
            $token = $user->createToken('API Token')->accessToken;

            $user2 = [ 'user' => $user, 'token' => $token];
*/

            //$response = $this->post('/api/create-server');

            $response = $this->getJson('api/players/3');
    
        
            $response->assertStatus(401);
/*

            for($i = 0; $i <= 6; $i++){
            $userCreated = User::orderBy('id', 'desc')->get()->first();
            
            User::destroy($userCreated->id);

            }   
        
            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);
           
          */

        }

        //Route::put('/players/{id}', [UserController::class, 'update']);


        public function test_update_an_specific_player_that_don´t_exist_admin_roll():void
        {

        

            //$token = User::find(3)->createToken('API Token')->accessToken;

            $user = [

                'username' => fake()->name(),
                
            ];

    
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
         
            //$response = $this->post('/api/create-server');

            $response = $this->putJson('api/players/5', $user);
    
        
            $response->assertStatus(405);



            $userCreated = User::orderBy('id', 'desc')->get()->first();
            
            User::destroy($userCreated->id);

        
            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);
          

        }


        public function test_update_a_specific_player_that_don´t_exist_user_roll():void
        {

        

            //$token = User::find(3)->createToken('API Token')->accessToken;

            $user = [

                'username' => fake()->name(),
                
            ];
/*
    
            $user = User::create($data);
    
            $token = $user->createToken('API Token')->accessToken;

            $user2 = [ 'user' => $user, 'token' => $token];
*/

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

            $response = $this->putJson('api/players/3', $user);
    
        
            $response->assertStatus(401);



            $userCreated = User::orderBy('id', 'desc')->get()->first();
            
            User::destroy($userCreated->id);

        
            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);
          

        }

        public function test_update_a_specific_player_valid():void
        {

            
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
                    'admin_roll' => 'Admin',
                    'total_games' => 80,
                    'total_wins' => 30,
                    'winning_percentage' => 26,
        
                ]);

            }

            //$token = User::find(3)->createToken('API Token')->accessToken;

            $user = [

                'username' => fake()->name(),
                
            ];

            $player = User::orderBy('id', 'desc')->get()->first();
   
            //$user = User::create($data);
    
            //$token = $user->createToken('API Token')->accessToken;

            //$user2 = [ 'user' => $user, 'token' => $token];




         
            //$response = $this->post('/api/create-server');

            $response = $this->putJson("api/players/{$player->id}", $user);
    
        
            $response->assertStatus(200);


            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }
        
            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);
          
          

        }

        //Route::delete('/player/{id}', [UserController::class, 'destroy']);

        public function test_delete_an_specific_player_that_don´t_exist_admin_roll():void
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
         
            //$response = $this->post('/api/create-server');

            $response = $this->deleteJson('api/player/1');
    
        
            $response->assertStatus(405);


            $userCreated = User::orderBy('id', 'desc')->get()->first();
            
            User::destroy($userCreated->id);

        
            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


          

        }

        public function test_delete_an_specific_player_that_don´t_exist_user_roll():void
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
         
            //$response = $this->post('/api/create-server');

            $response = $this->deleteJson('api/player/5');
    
        
            $response->assertStatus(405);


            $userCreated = User::orderBy('id', 'desc')->get()->first();
            
            User::destroy($userCreated->id);

        
            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


          

        }

        public function test_delete_an_specific_player_valid():void
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
                    'total_games' => 80,
                    'total_wins' => 30,
                    'winning_percentage' => 26,
        
                ]);

            }


            $user = User::orderBy('id', 'desc')->get()->first();
            

            //$response = $this->post('/api/create-server');

            $response = $this->deleteJson("api/player/{$user->id}");
    
        
            $response->assertStatus(200);

            
            for($i = 0; $i <= 5; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


          

        }


        //Route::get('/players/ranking/loser', [UserController::class, 'rank_loser']);


        public function test_rank_loser_admin_roll():void
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

         
            //$response = $this->post('/api/create-server');

            $response = $this->getJson('api/players/ranking/loser');
    
        
            $response->assertStatus(200);


            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


          

        }

        public function test_rank_loser_user_roll():void
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

         
            //$response = $this->post('/api/create-server');

            $response = $this->getJson('api/players/ranking/loser');
    
        
            $response->assertStatus(200);


            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


          

        }


        public function test_rank_loser_invalid():void
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

         
            //$response = $this->post('/api/create-server');

            $response = $this->getJson('api/players/ranking/loser');
    
        
            $response->assertStatus(401);


            for($i = 0; $i <= 5; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }


            //Route::get('/players/ranking/winner', [UserController::class, 'rank_winner']);



            public function test_rank_winner_admin_roll():void
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

         
            //$response = $this->post('/api/create-server');

            $response = $this->getJson('api/players/ranking/winner');
    
        
            $response->assertStatus(200);


            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


          

        }

        public function test_rank_winner_user_roll():void
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

         
            //$response = $this->post('/api/create-server');

            $response = $this->getJson('api/players/ranking/winner');
    
        
            $response->assertStatus(200);


            for($i = 0; $i <= 6; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


          

        }


        public function test_rank_winner_invalid():void
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

         
            //$response = $this->post('/api/create-server');

            $response = $this->getJson('api/players/ranking/winner');
    
        
            $response->assertStatus(401);


            for($i = 0; $i <= 5; $i++){

                $userCreated = User::orderBy('id', 'desc')->get()->first();
                
                User::destroy($userCreated->id);

            }

            $response= $this->assertDatabaseMissing('users',[
                
            'id' => $userCreated->id ]);


        }



     /*

----------------------------------------------------------------------------------------------------------------------------------
     


Route::group(['middleware' => ['auth:api']], function () {



    --Route::get('/players/ranking/loser', [UserController::class, 'rank_loser']);
    --Route::get('/players/ranking/winner', [UserController::class, 'rank_winner']);

    Route::post('/players/{id}/games', [GameController::class, 'roll']);
    Route::delete('/players/{id}/games', [GameController::class, 'destroy']);
});

    }

*/
}
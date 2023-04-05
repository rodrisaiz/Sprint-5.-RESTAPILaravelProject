<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => '',
            'email' => 'required|email|unique:users',
            'email_verified_at' => 'required',
            'password' => 'required',
            'admin_roll' => '',
        ]);

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        return response([ 'user' => $user, 'token' => $token]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Incorrect Details. 
            Please try again'], 422);
        }


        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token],);


    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if($user->admin_roll == 'Admin' || $user->id == $id)
        {

       $request->validate([
            
            'email' => 'required|email',
            'email_verified_at' => 'required',
            'password' => 'required'
        ]);

        return User::create($request->all());

        }else{
                    
            return response([
                'error_message' => "Sorry! You don't have access"
            ], 401);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = auth()->user();

        if($user->admin_roll == 'Admin' || $user->id == $id)
        {

            return User::find($id);

        }else{

            return response([
                'error_message' => "Sorry! You don't have access"
            ], 401 );

        }

      
    }

    /**
     * Update the specified resource in storage.
     * 
     */
    public function update(Request $request, $id)
    {
    
        $request->validate([
            
            'username' => 'required',
        
        ]);

        $user = auth()->user();

        if($user->admin_roll == 'Admin' || $user->id == $id)
        {

            $user=User::find($id);

                if (isset($user->username)){

                    $user->username = $request->username;
                
                    $user->save();

                }else{
            
                    return response([
                        'error_message' => "Sorry! The user don't exist"
                    ], 405);
        
                }

            return $user;

        }else{
            
            return response([
                'error_message' => "Sorry! You don't have access"
            ], 401 );

        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth()->user();

        $player = User::find($id);

        if(($user->admin_roll == 'Admin' || $user->id == $id) && isset($player->id))
        {

            return response([User::destroy($id)], 200);

        }elseif(!isset($player->id)) {

            return response([
                'error_message' => "Sorry! The user don't exist"
            ], 405);
            
        }else{
                
            return response([
                'error_message' => "Sorry! You don't have access"
            ], 401 );

        }
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

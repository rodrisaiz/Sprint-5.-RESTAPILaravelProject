<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;


class UserController extends Controller
{

    
    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => 'unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required',
        ]);

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $id = $user->id;

        $token = $user->createToken('API Token')->accessToken;
 
        return response(['user' => new UserResource(User::find($id))
                , 'token' => $token], 200 );

    }



    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);


        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Wrong credentials. Please try again'], 422);
        }


        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token,'message' => "You have been logged in! Welcome!"],);


    }
    
    
    public function index()
    {
        $user = auth()->user();
        
        if(isset($user->id))
        {

            return response(['allUsers' => new UserCollection(User::all())
                , 'message' => "Successful access!"], 200 );

        }else{
                    
            return response([
                'error_message' => "Sorry! You don't have access"], 401);

        }
    }

    

    public function store(Request $request)
    {
        $user = auth()->user();

        if($user->admin_role == 'Admin' || $user->id == $id)
        {

        $request->validate([
                
                'email' => 'required|email',
                'password' => 'required'
            ]);
            
            $stored = User::create($request->all());

            return response(['stored' => new UserResource(User::find($store))
                , 'message' => "Your information have saved!"], 200 );

        }else{
                    
            return response([
                'error_message' => "Sorry! You don't have access"], 401);

        }
    }

   

    
    public function show($id)
    {
        $user = auth()->user();

        if($user->admin_role == 'Admin' || $user->id == $id)
        {

            $specific_user=User::find($id);

                if (isset($specific_user->id)){

                    return response(['user' => new UserResource(User::find($id))
                    , 'message' => "There is your information!"], 200 );

                }else{
            
                    return response([
                        'error_message' => "Sorry! The user don't exist"], 405);
        
                }

        }else{

            return response([
                'error_message' => "Sorry! You don't have access"], 401 );

        }
    }


    public function update(Request $request, $id)
    {
    
        $request->validate([
            
            'username' => 'required',
        
        ]);

        $user = auth()->user();

        if($user->admin_role == 'Admin' || $user->id == $id)
        {

            $user=User::find($id);

                if (isset($user->username)){

                    $user->username = $request->username;
                
                    $user->save();

                }else{
            
                    return response([
                        'error_message' => "Sorry! The user don't exist"], 405);
        
                }

            return response(['user' => new UserResource(User::find($id))
                , 'message' => "Your information have been saved!"], 200 );

        }else{
            
            return response([
                'error_message' => "Sorry! You don't have access"], 401 );

        }
    }



    public function destroy($id)
    {
        $user = auth()->user();

        $player = User::find($id);

        if(($user->admin_role == 'Admin' || $user->id == $id))
        {

            if(isset($player->id)){

                return response([User::destroy($id),'message' => "Your user have been deleted!"], 200);

            }elseif(!isset($player->id)) {

                return response([
                    'error_message' => "Sorry! The user don't exist"], 405);
            }
        }else{
                
            return response([
                'error_message' => "Sorry! You don't have access"], 401 );

        }
    }




    public function rank()
    {
        $all = User::orderBy('winning_percentage', 'desc')->get();

        return response(['rank' => $all
        , 'message' => "Successful access!"], 200 );

    }




    public function rank_loser()
    {
     
        $loser = User::where('total_games', '!=', null)->orderBy('winning_percentage', 'asc')->get()->first();

        return response(['loser_users' => new UserResource($loser)
        , 'message' => "Successful access!"], 200 );

    }



    

    public function rank_winner()
    {

        $winner = User::orderBy('winning_percentage', 'desc')->get()->first();

        return response(['winning_users' => new UserResource($winner)
                , 'message' => "Successful access!"]
            , 200 );

    }

}

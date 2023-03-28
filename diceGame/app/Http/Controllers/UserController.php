<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            Please try again']);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token]);

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

       $request->validate([
            
            'email' => 'required|email',
            'email_verified_at' => 'required',
            'password' => 'required'
        ]);

        return User::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
            return User::find($id);

    }

        
    

    /**
     * Update the specified resource in storage.
     * 
     */
    public function update(Request $request, $id)
    {
    
        $user=User::find($id);

        if (!$request->username == null){

            $user->username = $request->username;
        
            $user->save();
        }

        return $user;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return User::destroy($id);
    }
}

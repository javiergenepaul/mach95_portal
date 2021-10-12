<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Supports\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'company' => 'string',
            'role_id' => 'required|numeric',
            'status' => 'required|numeric',
            'password' => 'required|min:6|confirmed',
            
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'company' => $fields['company'],
            'role_id' => $fields['role_id'],
            'status' => $fields['status'],
            'password' => bcrypt($fields['password']),
        ]);

        return response([
            'message' => 'user created',
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ]);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::Firstwhere('email', $fields['email']);

        
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid Credentials.',
                'errors' => [
                    'credentials' => 'Credentials do not match to out records.'
                ]
            ], 401);
        }

        $token = $user->createToken('myapptoken', ['user'])->plainTextToken;

        $reponse = [
            'message' => 'Successfully login.',
            'user' => $user,
            'token' => $token
        ];

        return response($reponse,200);
    }
}

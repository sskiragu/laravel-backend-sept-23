<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('auth-token');

            return $token->plainTextToken;
        } else {
            return "Login Failed";
        }
    }

    // signup
    public function signup(Request $request)
    {
        $user_input =  $request->all();

        User::create($user_input);

        return "User successfully created";
    }

    // logout
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

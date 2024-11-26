<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
    public function login(LoginRequest $request){

        // Attempt to authenticate the user
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $token = Auth::user()->createToken('authToken')->accessToken;

            return response()->json(['token' => $token],200);
        }else{
            // Return an error response if the authentication fails
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function logout(Request $request){
        Auth::guard('api')->user()->token()->revoke();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function register(RegisterRequest $request){

    }
}

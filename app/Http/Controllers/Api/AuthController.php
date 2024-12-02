<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Log;
class AuthController extends Controller
{
    public function login(LoginRequest $request){
        // Attempt to authenticate the user
        try{
            $auth=Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            if($auth){
                return response()->json(['logged in'],200);
            }
           return response()->json(['error' =>'Invalid credentials'],401);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request){
        Auth::guard('api')->user()->token()->revoke();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function register(RegisterRequest $request){
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password)
        ]);
    }
}

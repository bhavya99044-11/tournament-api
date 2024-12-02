<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\LoginRequest;
class AuthController extends Controller
{
    public function logout(Request $request){
        try{
            Auth::logout();
            return response()->json(['status'=>200,
            'msg'=>'succesfully logedout']);
        }
        catch(\Exception $e){
            return response()->json(['status'=>500,
            'msg'=>$e->getMessage()]);
        }
    }

    public function login(LoginRequest $request){
        // Attempt to authenticate the user
        try{
            $auth=Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            if($auth){
                return response()->json(['status'=>200,
                'msg'=>'logged in'],200);
            }
           return response()->json(['error' =>'Invalid credentials'],401);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

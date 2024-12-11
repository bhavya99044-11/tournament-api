<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' =>  bcrypt($request->password),
            ]);
            return ApiResponse::success('user registered successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validation->fails()) {
            return ApiResponse::error($validation->errors(), 400);
        }
        if (Auth::attempt($request->all())) {
            $data['token'] = Auth::user()->createToken('vvvv')->accessToken;
            return ApiResponse::success('User logged in successfully', $data['token']);
        }
        return ApiResponse::error('Invalid credentials', 401);
    }
    public function logout(Request $request)
    {
        if (Auth::guard('api')->user()) {
            Auth::guard('api')->user()->token()->revoke();
            return ApiResponse::success('User logged out successfully');
        }
        return ApiResponse::error('User not logged in', 401);
    }
}

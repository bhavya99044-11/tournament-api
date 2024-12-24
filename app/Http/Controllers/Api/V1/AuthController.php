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

/**
 *
 * @group Authentication
 *
 */

class AuthController extends Controller
{

    /**
     * User register
     *
     *
     * For new user registration in app
     *
     * @bodyParam password string required The length of this field minimum 8. Example:12345678
     * @bodyParam name string The name of the user. Example:panthil
     * @response 200 scenario=success {
     *   "status":true,
     *   "message":"User registered succesfully"
     * }
     * @response 422 scenario="invalid data field" {
     *   "status":false,
     *   "errors":{
     *   "email":[
     *       "The email field is invalid"
     *     ]
     *   },
     *   "message":"Validation errors"
     *   }
     *
     */


    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return $this->success('user registered successfully');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * User Login
     *
     * This endpoint is used to user login
     * @bodyParam password string required The length of this field minimum 8. Example:12345678
     * @response 200 scenario="success token" {
     *   "status":true,
     *   "data":
     *      [
     *          "token"=>"dasfsdafgsGSDFGRS",
     *      ]
     * }
      * @response 422 scenario="invalid data field" {
     *   "status":false,
     *   "errors":{
     *   "email":[
     *       "The email field is invalid"
     *     ]
     *   },
     *   "message":"Validation errors"
     *   }
     *@response 429 scenario="too many attempts" {
     * "status":false,
     * "message":"too many attempts"
     *
     * }
     */
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
            return $this->success('User logged in successfully', $data['token']);
        }
        return $this->error('Invalid credentials', 401);
    }

    /**
     *User logout api

     * User logout for this user must be logged in otherwise it will return error
    * @header Authorization 'Bearer token'
    * @response 200 scenario="success" {"status":true, "message":"User logged out successfully"}
    * @response 401 scenario="unauthorized" {"status":false, "message":"unauthorized"}
     */
    public function logout(Request $request)
    {
        if (Auth::guard('api')->user()) {
            Auth::guard('api')->user()->token()->revoke();
            return $this->success('User logged out successfully');
        }
        return $this->error('User not logged in', 401);
    }
}

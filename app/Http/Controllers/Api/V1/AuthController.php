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


    /**
     * @OA\Post(
     *  tags={"Auth"},
     * path="/api/v1/register",
     * summary="Register a new user",
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="application/x-www-form-urlencoded",
     * @OA\Schema(
     * required={"name","email","password"},
     * @OA\Property(property="name",type="string",example="Bhavya jain"),
     * @OA\Property(property="email",type="email",example="bhavya@example.com"),
     * @OA\Property(property="password",type="string(min 8 length)",example="12345678"),
     * )
     * )
     * ),
     * @OA\Response(response="200", description="User registered successfully",
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="status",example="true"),
     * @OA\Property(property="message",example="User registered successfully"),
     * )
     * ),
     * @OA\Response(response="400", description="invalid data field",
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="data",type="object",
     *  @OA\Property(property="email",type="array",
     *  @OA\Items(
     * type="string",
     * description="invalid",
     * )
     * ),
     * ),
     * ),
     * ),
     * ),
     * @OA\Response(response="500", description="internal server error"),
     * @OA\Response(response="429", description="too many requests"),
     * )
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return ApiResponse::success('user registered successfully');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }
    /**
     * @OA\Post(
     * tags={"Auth"},
     * path="/api/v1/login",
     * summary="User Login",
     *  @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="application/x-www-form-urlencoded",
     * @OA\Schema(
     * required={"email","password"},
     * @OA\Property(property="email",type="email"),
     * @OA\Property(property="password",type="password")
     * )
     * )
     * ),
     *  @OA\Response(response="200",description="User Login",
     *  @OA\JsonContent(
     * type="object",
     * @OA\Property(property="data",example="jhasghduifjhdaFJK")
     * ),
     * ),
     * @OA\Response(response="401",description="invalid credential"),
     * )
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

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    /**
     * @OA\Post(
     * tags={"profile"},
     * path="api/v1/profile-view",
     * summary="Profile view",
     * @OA\Response(response="200",description="profile updated",
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="status",example="success"),
     * @OA\Property(property="data",type="object",
     * @OA\Property(property="id",example="10"),
     * @OA\Property(property="name",example="bhavya"),
     * @OA\Property(property="email",example="bhavya@example.com"),
     * ),
     * )
     * ),
     * ),
     * )
     */
    public function profileView()
    {
        $user = auth('api')->user();
        return ApiResponse::success('Profile', $user);
    }


    /**
     * @OA\Post(
     * tags={"profile"},
     * path="api/v1/profile-update",
     * summary="Profile update",
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="application/x-www-form-urlencoded",
     * @OA\Schema(
     * required={"name","email"},
     * @OA\Property(property="email",type="email"),
     * @OA\Property(property="name",type="name"),
     * ),
     * ),
     * ),
     * @OA\Response(response="200",description="profile updated"),
     * )
     */
    public function profileUpdate(ProfileRequest $request)
    {
        try {
            $user = auth('api')->user();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();
            return ApiResponse::success('Profile updated');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }
}

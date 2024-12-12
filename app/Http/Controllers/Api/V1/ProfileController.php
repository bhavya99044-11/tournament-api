<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Http\Requests\ProfileRequest;
class ProfileController extends Controller
{
    public function profileView(){
      $user=auth('api')->user();
        return ApiResponse::success('Profile', $user);
    }

    public function profileUpdate(ProfileRequest $request){
        try{
            $user=auth('api')->user();
            $user->name=$request->input('name');
            $user->email=$request->input('email');
            $user->save();
         return ApiResponse::success('Profile updated');
        }catch(\Exception $e){
            return ApiResponse::error($e->getMessage(), 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
    public function __construct(){

    }

    public function profile(Request $request){
        $user=Auth::guard('api')->user();
        dd($user);
    }
}

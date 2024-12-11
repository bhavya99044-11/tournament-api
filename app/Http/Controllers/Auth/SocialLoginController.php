<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class SocialLoginController extends Controller
{
    public function redirect(Request $request){
       $clientId=env('GOOGLE_CLIENT_ID');
       $clientSecret=env('GOOGLE_CLIENT_SECRET');
       $redirectUri='http://127.0.0.1:8000/auth/google/callback';
       $scope='email%20profile';

       return redirect("https://accounts.google.com/o/oauth2/auth?client_id=$clientId&redirect_uri=$redirectUri&response_type=code&scope=$scope");
    }
    public function callback(Request $request){
        $code = $request->query('code');
        if (empty($code)) {
            return response()->json(['error' => 'Authorization code not provided'], 400);
        }
        $clientId = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $redirectUri ='http://127.0.0.1:8000/auth/google/callback';

        // Exchange the authorization code for an access token
        $response = Http::post('https://accounts.google.com/o/oauth2/token', [
            'code'          => $code,
            'client_id'     => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri'  => $redirectUri,
            'grant_type'    => 'authorization_code',
            'access_type'=>'offline'
        ]);
    }
}

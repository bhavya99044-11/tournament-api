<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\PlayerPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Team;

class Teamcontroller extends Controller
{
    public function create(Request $request)
    {
        try {
            $team=
            $userMail=User::whereEmail($request->email)->first();
            $team=Team::find($request->team_id);

            if($userMail){
                $user=$userMail;
            }
            else{
                $password = $request->name . rand(100000, 999999);
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($password),
                ]);
                $user['password']=$password;
                Mail::to($user->email)->send(new PlayerPasswordMail($password));
            }
            return response()->json([
                'message' => 'User created successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}

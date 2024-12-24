<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Http\Requests\ProfileRequest;
use App\Models\Tournament;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
       /**
        * User Profile-data
        *
        * To get logged in user profile data with tournament stats
     * @group Profile-data
     * @header Authorization 'Bearer token'
     * @response 200 scenario="success" {
     * "status":true,
     * "data":
     *   [
     *    {
     *     id:1,
     *     name:ipl20,
     *     totalTournaments:100,
     *     wonTournaments:50
     *    }
     *   ]
     * }
      * @response 401 scenario="unautorized" {"status":'false', "message":"unautorized"}
     */
    public function profileView()
    {
        $user = auth('api')->user();
        $tournaments = Tournament::withWhereHas('teams', function ($query,$user) {
            $query->whereHas('players', function ($query2,$user) {
                // $query2->with('teams');
                $query2->whereUserId($user->id);
            });
        })->select('id', 'won_team_id')->get();
        //Filtering winning teams
        if ($tournaments->isNotEmpty()) {
            $user->totalTournaments = $tournaments->count();
            $user->wonTournaments = $tournaments->filter(function ($query) {
                return $query->won_team_id == $query->teams->first()->id;
            })->count();
        }
        return $this->success('Profile', $user);
    }



     /**
     * Profile data update
     *
     * User profile update with this api pass the name and password field to update
     * @group Profile-data
     * @header Authorization 'Bearer token'
     * @bodyParam  name string For user name update. Example:bhavesh
     * @bodyParam password string Minimum length of this field must be 8. Example:61327812367
     * @response 200 scenario="success" {
     * "status":true,
     * "message":"profile is updated successfully"
     * }
     * @response 401 scenario="unautorized" {"status":'false', "message":"unauthorized"}
     */
    public function profileUpdate(ProfileRequest $request)
    {
        try {
            $user = auth('api')->user();
            $user->name = $request->input('name');
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return $this->success('Profile updated');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}

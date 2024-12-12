<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Matches;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TournamentController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->per_page ? $request->per_page : 10;
        $offset = $request->offset ? $request->offset : 0;
        $result = Tournament::query();
        //perticular player played tournaments
        if ($player = $request->get('player_id') && !$favourite = $request->get('favourite')) {
            $result->whereHas('teams', function ($query) use ($player) {
                $query->whereHas('players', function ($query) use ($player) {
                    $query->where('user_id', '=', 24);
                });
            });
        }
        //Search query
        if ($search = $request->get('search')) {
            $result->where('name', 'LIKE', '%' . $search . '%');
        }
        //Tournaments filtered by date(past,active,upcoming)
        if ($filter = $request->get('filter')) {
            $validation = Validator::make($request->all(), [
                'filter' => 'in:past,active,upcoming'
            ]);
            if ($validation->fails()) {
                return ApiResponse::error($validation->errors(), 400);
            }
            if ($filter == 'active') {
                $result->where('start_date', '<=', now())->where('end_date', '>=', now());
            }
            if ($filter == 'past') {
                $result->where('end_date', '<', now());
            }
            if ($filter == 'upcoming') {
                $result->where('end_date', '>', now());
            }
        }
        //Tournaments filtered by favourite and player
        if ($favourite = $request->get('favourite') && $user = $request->get('player_id')) {
            $result->whereHas('favouriteUsers', function ($query) use ($user) {
                $query->where('user_id', '=', 1);
            });
        }
        $result = $result->paginate($perPage, ['*'], 'page', $offset);
        return ApiResponse::success($result);
    }
    //Getting serach box suggestion
    public function search(Request $request)
    {
        try {
            $msg = 'result not found';
            $tournaments = null;
            if ($query = $request->get('query')) {
                $tournaments = Tournament::where('name', 'LIKE', '%' . $query . '%')->take(5)->get();
                $msg = $tournaments ? "result found" : $msg;
            }
            return ApiResponse::success($msg, $tournaments);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }
    //Profile page Win and total tournaments
    public function playerStats(Request $request)
    {
        try {
            if ($player = $request->get('player_id')) {
                $data['tournaments'] =  Tournament::withWhereHas('teams', function ($query) {
                    $query->whereHas('players', function ($query2) {
                        $query2->with('teams');
                        $query2->whereUserId(24);
                    });
                })->select('id', 'won_team_id')->get();
                if ($data['tournaments']) {
                    $data['totalTournaments'] = $data['tournaments']->count();
                    $data['tournamentWins'] = $data['tournaments']->filter(function ($query) {
                        return  $query->won_team_id == $query->teams->first()->id;
                    })->count();
                    return ApiResponse::success('stats', $data);
                }
                return ApiResponse::success('no data found');
            }
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }

    //Selected tournament matches
    public function tournamentMatches(Request $request, $tournament)
    {
        try {
            $round=$request->round?$request->round:Matches::whereTournamentId($tournament)->orderBy('id','DESC')->first()->round;

            $data['tournaments'] = Tournament::with(['matches'=>function($query) use($round){
                $query->when($round,function($query2)use($round){
                    $query2->whereRound($round);
                });
            }])->whereId($tournament)->get();
            return ApiResponse::success('success', $data['tournaments']);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function matchStats(){
        try {
            $data['matches']=Matches::whereId(154)->first();
            return ApiResponse::success('success', $data['matches']);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }
}

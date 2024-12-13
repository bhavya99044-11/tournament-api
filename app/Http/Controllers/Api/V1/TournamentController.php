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
        if ($request->has('player') && $request->hasNot('favourite')) {
            $player = $request->input('player');
            $result->whereHas('teams', function ($query) use ($player) {
                $query->whereHas('players', function ($query) use ($player) {
                    $query->where('user_id', '=', auth('api')->user()->id);
                });
            });
        }
        //Search query
        if ($request->has('search')) {
            $search = $request->input('search');
            $result->where('name', 'LIKE', '%' . $search . '%');
        }
        //Tournaments filtered by date(past,active,upcoming)
        if ($request->has('filter')) {
            $filter = $request->input('filter');
            // dd($filter);
            $now = date('Y-m-d H:i:s');

            if ($filter == 'active') {
                $result->where('start_datetime', '<=', $now)->where('end_datetime', '>=', $now);
            }
            if ($filter == 'past') {
                $result->where('end_datetime', '<', $now);
            }
            if ($filter == 'upcoming') {
                $result->where('end_datetime', '>', $now);
            }
        }
        //Tournaments filtered by favourite and player
        if ($request->has('favourite')) {
            $favourite = $request->input('filter');
            $result->whereHas('favouriteUsers', function ($query) {
                $query->where('user_id', '=', auth('api')->user()->id);
            });
        }
        $result = $result->paginate($perPage, ['*'], 'page', $offset);
        $meta = [
            'perPage' => $result->perPage(),
            'currentPage' => $result->currentPage(),
            'totalPages' => $result->lastPage(),
            'total' => $result->total(),
            'firstItem' => $result->firstItem(),
            'lastItem' => $result->lastItem(),
        ];
        return ApiResponse::success('data fetched', $result->items(), $meta);
    }
    //Getting serach box suggestion
    public function search(Request $request)
    {
        try {
            $msg = 'result not found';
            $tournaments = null;
            if ($request->has('query')) {
                $query = $request->input('query');
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
            $data['tournaments'] = Tournament::withWhereHas('teams', function ($query) {
                $query->whereHas('players', function ($query2) {
                    $query2->with('teams');
                    $query2->whereUserId(auth('api')->user()->id);
                });
            })->select('id', 'won_team_id')->get();
            //Filtering winning teams
            if ($data['tournaments']) {
                $data['totalTournaments'] = $data['tournaments']->count();
                $data['tournamentWins'] = $data['tournaments']->filter(function ($query) {
                    return $query->won_team_id == $query->teams->first()->id;
                })->count();
                return ApiResponse::success('stats', $data);
            }

            return ApiResponse::success('no data found');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }

    //Selected tournament matches
    public function tournamentMatches(Request $request, $tournament)
    {
        try {
            $round = $request->has('round') ? $request->input('round') : Matches::whereTournamentId($tournament)->orderBy('id', 'DESC')->first();
            if($round){
            $matches = Matches::where('round',$round)->whereTournamentId($tournament)->get();
            if ($matches->isNotEmpty()) {
                return ApiResponse::success('success', $matches);
            }
        }
            return ApiResponse::error('no data found', 400);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

}

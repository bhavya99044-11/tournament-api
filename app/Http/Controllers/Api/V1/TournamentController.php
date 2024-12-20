<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\Matches;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

/**
 * @group Tournament-data
 */
class TournamentController extends Controller
{


    /**
     *
     * Tournament data with query params
     *
     * Get all Tournament related data in this pass query according to your selection.
         *  @header Authorization 'Bearer token'
     * @queryParam isPlayer boolean To get player related tournament data. Example:0
     * @queryParam search string To get user specific tournament data.
     * @queryParam status(past,active,upcoming) To get the tournament data .Example:past
     * @queryParam per_page string To get data rows per page. Example:2
     * @queryParam offset string To get data from selected page.
     * @response 200 scenario="success token" {
     * "status":true,
     * "data":[
     *      {
     *         "id":1,
     *         "name":"ipl20",
     *         "location":"gujarat"
     *      }
     *    ],
     * "meta":
     *     {
     *       "perPage": 10,
     *       "currentPage": 1,
     *       "totalPages": 4,
     *       "total": 32,
     *       "firstItem": 1,
     *       "lastItem": 10
     *     }
     * }
     */
    public function index(Request $request)
    {
        $perPage = $request->has('per_page') ? $request->per_page : 10;
        $offset = $request->has('offset')  ? $request->offset : 0;
        $result = Tournament::query();
        //perticular player played tournaments
        if ($request->has('player')) {
            $result->with('teamPlayers');
        }
        //Search query
        if ($request->has('search') && $search = $request->input('search')) {
            $result->where('name', 'LIKE', '%' . $search . '%');
        }
        //Tournaments filtered by date(past,active,upcoming)
        if ($request->has('status') && $filter = $request->input('status')) {
            $now = date('Y-m-d H:i:s');
            switch ($filter) {
                case 'past':
                    $result->where('end_datetime', '<', $now);
                    break;
                case 'active':
                    $result->where('start_datetime', '<', $now)
                        ->where('end_datetime', '>', $now);
                    break;
                case 'upcoming':
                    $result->where('start_datetime', '>', $now);
                    break;
            }
        }
        //Tournaments filtered by favourite and player
        if ($request->has('isFavourite') &&  $favourite = $request->input('isFavourite')) {
            $result->whereHas('favouriteUsers', function ($query) {
                $query->where('user_id', '=', auth('api')->user()->id);
            });
        }
        $result = $result->paginate($perPage, ['*'], 'page', $offset);
        dd($result);
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


    /**
     *
     * Search box suggestion
     *
     * For app search box suggestion in this top 5 related tournament data with id will be given.
     *  @header Authorization 'Bearer token'
     * @queryParam search string To search specific tournament.
     * @response 200 scenario="success" {
     * "status":true,
     * "data":[
     *      {
     *         "id":1,
     *         "name":"ipl20",
     *         "location":"gujarat"
     *      }
     *    ]
     * }

     */
    //Getting serach box suggestion
    public function search(Request $request)
    {
        try {
            $msg = 'result not found';
            $tournaments = [];
            if ($request->has('search')) {
                $tournaments = Tournament::where('name', 'LIKE', '%' . $request->input('search') . '%')->select('name', 'id')->take(5)->get();
                $msg = $tournaments ? "result found" : $msg;
            }
            return ApiResponse::success($msg, $tournaments);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }


    /**
     *Tournament matches with rounds
     *
     * To get the selected tournament matches with rounds.
          *  @header Authorization 'Bearer token'
     * @bodyParam round integer Pass round number in this to get selected round data. Example:8
     * @UrlParam tournament Pass tournament id in this. Example:2
     * @response 200 scenario="success" {
     * "status":true,
     * "data":[
     *     {
     *        id:100,
     *        winner_team_id:100,
     *        home_team:{
     *            id:100,
     *            name:inpl40
     *         }
     *        opponent_team:{
     *             id:30,
     *             name:ww50
     *         }
    *         won_team:{
     *             id:30,
     *             name:ww50
     *         }
     *     }
     *   ]
     * }
     * @response 404 scenario="No data found" {
     * "status":false,
     * "message":"This round is not available in the tournament"
     * }
     */
    //Selected tournament matches
    public function tournamentMatches(Request $request, $tournament)
    {
        try {
            $round = $request->has('round') ? $request->input('round') : Matches::whereTournamentId($tournament)->orderBy('id', 'DESC')->first();
            if ($round) {
                $matches = Matches::with(['opponentTeam','homeTeam','winnerTeam'])->where('round', $round)->whereTournamentId($tournament)->get();
                if ($matches->isNotEmpty()) {
                    return ApiResponse::success('success', $matches);
                }
            }
            return ApiResponse::error('This round is not available in the tournament', 400);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }
}

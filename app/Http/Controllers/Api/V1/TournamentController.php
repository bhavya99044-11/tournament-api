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

 /**
     * @OA\Get(
     * tags={"tournament"},
     * path="api/v1/tournament",
     * summary="Tournament Data",
     *   @OA\Parameter(
     *      name="search",
     *      in="query",
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="player",
     *      in="query",
     *      @OA\Schema(
     *           type="boolean"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="favourite",
     *      in="query",
     *      @OA\Schema(
     *           type="boolean"
     *      )
     *   ),
         *   @OA\Parameter(
     *      name="per_page",
     *      in="query",
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
         *   @OA\Parameter(
     *      name="offset",
     *      in="query",
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="filter",
     * in="query",
     *      @OA\Schema(
     * type="string",
     * enum={"past","active","upcoming"},
     *      )
     *   ),
     * @OA\Response(response=200,description="data fetched",
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="data",type="array",
     * @OA\Items(
     * @OA\Property(property="id",example="10"),
     * @OA\Property(property="name",example="ipl2"),
     * @OA\Property(property="won_team_id",example="10"),
     * @OA\Property(property="organizer_id",example="10"),
     * @OA\Property(property="location",example="gujarat"),
     * @OA\Property(property="start_dateTime",example="2024-12-02 11:28:54"),
     * @OA\Property(property="end_dateTime",example="2024-12-02 11:28:54"),
     * ),
     * ),
     * @OA\Property(property="total",example=0),
     * @OA\Property(property="meta",type="object",
     * @OA\Property(property="total",example=0),
     * @OA\Property(property="current_page",example=10)
     * )
     * )
     *
     * )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->has('per_page') ? $request->per_page : 10;
        $offset = $request->has('offset')  ? $request->offset : 0;
        $result = Tournament::query();
        //perticular player played tournaments
        if ($request->has('player') && $player = $request->input('player')) {
            $result->whereHas('teams', function ($query) use ($player) {
                $query->whereHas('players', function ($query) use ($player) {
                    $query->where('user_id', '=', auth('api')->user()->id);
                });
            });
        }
        //Search query
        if ($request->has('search') && $search = $request->input('search')) {
            $result->where('name', 'LIKE', '%' . $search . '%');
        }
        //Tournaments filtered by date(past,active,upcoming)
        if ($request->has('filter') && $filter = $request->input('filter')) {
            $now = date('Y-m-d H:i:s');
          switch($filter){
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
        if ($request->has('favourite') &&  $favourite = $request->input('favourite')) {
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
          $tournaments = Tournament::withWhereHas('teams', function ($query) {
                $query->whereHas('players', function ($query2) {
                    $query2->with('teams');
                    $query2->whereUserId(1);
                });
            })->select('id', 'won_team_id')->get();
            //Filtering winning teams
            if ($tournaments->isNotEmpty()) {
                $data['totalTournaments'] = $tournaments->count();
                $data['tournamentWins'] = $tournaments->filter(function ($query) {
                    return $query->won_team_id == $query->teams->first()->id;
                })->count();
                return ApiResponse::success('stats', $data);
            }
            return ApiResponse::success('no data found',$data=null);
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

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Helpers\ApiResponse;

class TournamentController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->per_page ? $request->per_page : 10;
        $offset = $request->offset ? $request->offset : 0;
        $result = Tournament::query();
        if ($player=$request->get('player_id')) {
            $result->whereHas('teams', function ($query)use($player) {
                $query->whereHas('players', function ($query)use($player) {
                    $query->where('id','=', $player);
                });
            });
        }
        if($search=$request->get('search')){
            $result->where('name', 'LIKE', '%' . $search . '%');
        };

        $result = $result->get();
        // if($query=$request->get('tournament_id')){
        //     $result->where('id', $query);
        // }
        // if($query=$request->get('player_id')){
        //   $result->where('player_id',$query);
        // }
        // $result=$result->get();
        return ApiResponse::success($result);
        // $tournaments = Tournament::paginate($perPage, ['*'], 'page', $offset);
    }

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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matches;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MatchController extends Controller
{
    protected $data;
    public function matches(Request $request)
    {
        try {
            $tournament = Tournament::with('teams', 'teams.players')->where(function ($query) use ($request, $data) {
                $query->whereRaw('current_teams>=min_teams');
            })->find($request->tournament_id);
            if ($tournament) {
                return response()->json([
                    'data' => $tournament,
                    'message' => 'Tournament details',
                    'status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'Not created ',
                    'status' => 404
                ]);
            }
            // return view('admin-panel.match.list');
        } catch (\Exception $e) {
        }
    }
    public function createMatch(Request $request)
    {
        Db::beginTransaction();
        try {
            $tournament = Tournament::with(['teams', 'matches' => function ($query) {
                $query->orderBy('id' ,'DESC')->limit(1);
            }])
            ->when($request->round,function($query)use ($request){
                $query->where('round', $request->round());
            })
            ->whereId($request->tournament_id)->whereRaw('current_teams>=min_teams')->firstOrFail();
            //Return if matches already created
            if ($tournament->matches->isNotEmpty() && $tournament->matches->first()->round!=null) {
                    return response()->json([
                        'message' => 'Matches are already created',
                       'status' => 400
                    ]);
            }
            $matchChunk = $tournament->teams->shuffle()->chunk(2);
            $matchDate=Carbon::parse($tournament->start_date);
        $startTime=$matchDate->format('H:i:s');
            $perDayMatchChunk = $matchChunk->chunk(2);
            $key=0;
            foreach($perDayMatchChunk as $dayMatch){
               foreach($dayMatch as $match){
                 $matchArray=[
                     'home_team_id' => $match[$key]->id,
                     'opponent_team_id' => $match[$key+1]->id,
                     'tournament_id' => $request->tournament_id,
                     'round' => $key+1,
                     'created_at' => Carbon::now(),
                     'updated_at' => Carbon::now()
                 ];


               }
            }



        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function rounds($id)
    {
        try {

            $this->data['matches'] = Matches::with('homeTeam', 'opponentTeam')->whereTournamentId($id)->get();
            return view('admin-panel.match.list')->with([
                'data' => $this->data
            ]);
        } catch (\Exception $e) {
            dd($e->getMEssage());
        }
    }

    public function roundGenerate(){

    }
}


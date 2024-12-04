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

    public function matches(Request $request)
    {
        try {
            $tournament = Tournament::with('teams', 'teams.players')->where(function ($query) use ($request, $data) {
                $query->whereRaw('current_teams>=min_teams');
            })->find($request->tournament_id);
                if($tournament){
                    return response()->json([
                        'data' => $tournament,
                        'message' => 'Tournament details',
                       'status' => 200
                    ]);
                }else{
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
        //Check if match can be created
        //Check if there are enough teams
        //Check if there are enough players
        //Create match
        try {
            $tournament = Tournament::with('teams', 'teams.players')->whereId($request->tournament_id)->whereRaw('current_teams>=min_teams')->first();
            if($tournament){
                $count=count($tournament['teams']);
                if($count%2==0){
                    for($i=2;$i<$count;$i+=2){
                        $team1=$tournament['teams'][$i];
                        $team2=$tournament['teams'][($i+1)];
                        $match=Matches::whereRound($count/2)->whereTournamentId($request->tournament_id)->orderBy('id', 'desc')->limit(2)->get();
                        dd($match);
                        if($match){
                            $date=Carbon::parse($match['end_time']);
                            $matchDate=$date->format('Y-m-d');
                            $startTime=$date->format('Y-m-d H:i:s');
                            $endTime=Carbon::parse($startTime)->addHours(3)->format('Y-m-d H:i:s');
                        }
                        else{
                        $date=Carbon::parse($tournament['start_date']);
                        $matchDate=$date->format('Y-m-d');
                        $startTime=$date->format('Y-m-d H:i:s');
                        $endTime=Carbon::parse($startTime)->addHours(3)->format('Y-m-d H:i:s');
                        }
                        $match=Matches::create([
                            'home_team_id'=>$team1->id,
                            'opponent_team_id'=>$team2->id,
                            'tournament_id'=>$request->tournament_id,
                            'result_id'=>null,
                            'match_date'=>$matchDate,
                            'start_time'=>$startTime,
                            'end_time'=>$endTime,
                            'round'=>$count/2,
                            'status'=>0
                        ]);
                        // $match->homeTeam()->associate($team1);
                        // $match->opponentTeam()->associate($team2);
                        // $match->tournament()->associate($tournament);
                        // $match->save();
                    }
                }else{
                    dd('odd');
                }
            return response()->json([
                'message' => 'Matches Created',
               'status' => 200
            ]);
        }else{
            return response()->json([
               'message' => 'Not created ',
               'status' => 404
            ]);
        }

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}

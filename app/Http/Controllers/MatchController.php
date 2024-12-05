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
            })->findOrFail($request->tournament_id);
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
            $tournament = Tournament::whereId($request->tournament_id)->whereRaw('current_teams>=min_teams')->firstOrFail();
            //Return if matches already created
            
            $matchExists = Matches::whereTournamentId($tournament->id)->whereRound($request->round)->get();
            if ($matchExists->isNotEmpty()) {
                return response()->json([
                    'message' => 'Matches are already created',
                    'status' => 400
                ]);
            } else {
                if ($request->round > 1) {
                    $tournamentTeams = Matches::with('winnerTeam')->whereTournamentId($request->tournament_id)->whereRound($request->round - 1)
                        ->get();
                    $emptyResult = $tournamentTeams->filter(function ($query) {
                        return $query->result_id == null;
                    });
                    if ($emptyResult->isNotEmpty()) {
                        return response()->json([
                            'message' => 'all matches result not declared',
                            'status' => 404
                        ]);
                    } else {
                        $matchDate = Carbon::parse($tournamentTeams->where('opponent_team_id', '!=', null)->last()->match_date)->addDay();
                        $startTime = Carbon::parse($tournament->st);
                        $tournamentTeams = $tournamentTeams->pluck('winnerTeam');
                        $round = $request->round;
                    }
                } else {
                    $tournamentTeams = Tournament::with('teams')->whereTournamentId($request->tournament_id);
                    $round = 1;
                    $matchDate = Carbon::parse($tournament->start_date);
                }
            }
            $matchChunk = $tournamentTeams->shuffle()->chunk(2);
            //Taking match date from tournament start date
            $startTime = Carbon::parse($tournament->start_date);
            $endTime = $matchDate->copy()->addHours(3);
            $perDayMatchChunk = $matchChunk->chunk(2);
            $key = 0;
            foreach ($perDayMatchChunk as $dayMatch) {
                foreach ($dayMatch as $match) {
                    $count = count($match) % 2 == 0;
                    $matchArray[] = [
                        'home_team_id' => $match[$key]->id,
                        'opponent_team_id' => $count ? $match[$key + 1]->id : null,
                        'tournament_id' => $request->tournament_id,
                        'round' => $round,
                        'result_id' => $count ? null : $match[$key + 1]->id,
                        'match_date' => $count ? $matchDate->format('Y-m-d') : null,
                        'start_time' => $count ? $startTime->format('H:i:s') : null,
                        'end_time' => $count ? $endTime->format('H:i:s') : null,
                        'status' => null,
                    ];
                    $startTime = $startTime->copy()->addHours(3);
                    $endTime = $startTime->copy()->addHours(3);
                    $key += 2;
                }
                $matchDate = $matchDate->copy()->addDays(1);
                $startTime = $matchDate->copy();
                $endTime = $startTime->copy()->addHours(3);
            }
            Matches::insert($matchArray);
            DB::commit();
            return response()->json([
                'message' => 'succesfully created',
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function rounds($id)
    {
        try {
            $this->data['matches'] = Matches::with('homeTeam', 'opponentTeam')->whereTournamentId($id)->get()->groupBy('round');
            return view('admin-panel.match.list')->with([
                'data' => $this->data
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function roundGenerate() {}
}

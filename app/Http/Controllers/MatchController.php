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
            $hourGap=3;
            $tournament = Tournament::whereId($request->tournament_id)->whereRaw('current_teams>=min_teams')->firstOrFail();
            //Checking if matches of round exists or not
            $matchExists = Matches::whereTournamentId($tournament->id)->whereRound($request->round)->get();
            if ($matchExists->isNotEmpty()) {
                return response()->json([
                    'message' => 'Matches are already created',
                    'status' => 400
                ]);
            }
                //Creating matches if round>1
                //Then fetch from match table
                if ($request->round > 1) {
                    $tournamentTeams = Matches::with('winnerTeam')->whereTournamentId($request->tournament_id)->whereRound($request->round - 1)
                        ->get();
                    $emptyResult = $tournamentTeams->filter(function ($query) {
                        return $query->result_id == null;
                    });
                    //All result of match must be declared otherwise returns
                    if ($emptyResult->isNotEmpty()) {
                        return response()->json([
                            'message' => 'all matches result not declared',
                            'status' => 404
                        ]);
                    }
                        //Getting all matches of the round to schedule next round
                        $matchDate = Carbon::parse($tournamentTeams->where('opponent_team_id', '!=', null)->last()->match_date)->addDay();
                        $startTime = Carbon::parse($tournament->start_date);
                        $tournamentTeams = $tournamentTeams->pluck('winnerTeam');
                        $round = $request->round;

                } else {
                    //If this is first round will fetch from Tournamnet with registered team
                    $tournamentTeams = Tournament::with('teams')->whereId($request->tournament_id)->first();
                    $tournamentTeams=$tournamentTeams->teams;
                    $round = 1;
                    $matchDate = Carbon::parse($tournament->start_date);
                }
            //Suffeling and chunking array in pair for matches
            $matchChunk = $tournamentTeams->shuffle()->chunk(2);
            $startTime = Carbon::parse($tournament->start_date);
            $endTime = $startTime->copy()->addHours(3);
            //Again chunk created For per day two matches
            $perDayMatchChunk = $matchChunk->chunk(2);
            $key = 0;
            foreach ($perDayMatchChunk as $dayMatch) {
                foreach ($dayMatch as $match) {
                    //Odd and even case
                    $count = count($match) % 2 == 0;
                    //Array to store the object and insert in database
                    $matchArray[] = [
                        'home_team_id' => $match[$key]->id,
                        'opponent_team_id' => $count ? $match[$key + 1]->id : null,
                        'tournament_id' => $request->tournament_id,
                        'round' => $round,
                        'result_id' => $count ? null : $match[$key]->id,
                        'match_date' => $count ? $matchDate->format('Y-m-d') : null,
                        'start_time' => $count ? $startTime->format('H:i:s') : null,
                        'end_time' => $count ? $endTime->format('H:i:s') : null,
                        'status' => null,
                    ];
                    //Increase hour to avoide match conflicts
                    $startTime = $startTime->copy()->addHours(3+$hourGap);
                    $endTime = $startTime->copy()->addHours(3);
                    $key += 2;
                }
                //After two match arrangement Update date
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
            log::info($e->getMessage());
        }
    }

    public function roundGenerate() {}
}

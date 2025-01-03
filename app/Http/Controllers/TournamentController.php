<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Tournament;
use App\Http\Resources\TournamentResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use App\TournamentStatus;
use App\Models\Matches;
use App\Models\Team;
use \Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Player;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\TeamPlayers;
use App\Events\RecordNotificationEvent;
use Illuminate\Support\Facades\Artisan;
use Pusher\Pusher;
use App\Models\MatchRecords;
class TournamentController extends Controller
{
    public $data;
    public function __construct() {}
    public function index(Request $request)
    {
        log::info(env('PUSHER_APP_KEY'));
        // log::info(config('app.pusher.key'));
        $tournamentStatus = TournamentStatus::cases();
        $data = Tournament::latest()->get();
        //Datatbel for the tournament
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) use ($tournamentStatus) {
                    foreach ($tournamentStatus as $tournament) {
                        $key = $tournament->value;
                        $value = ucfirst($tournament->name);
                        if ($row->status == $key) {
                            $status = $value;
                        }
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) use ($data) {
                    $button = '<div class="relative mb-10"><button class="edit-data" data-id=' . $row->id . '><i class="fas fa-ellipsis-v"></i></button>
                    </div>';
                    return $button;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('admin-panel.tournament.index');
    }

    public function create(Request $request, $id) {}
    public function store(TournamentRequest $request)
    {
        $request->merge(['organizaer_id' => Auth::user()->Id]);
        return response()->json(['message' => 'Tournament created successfully'], 200);
    }

    //Shows dahsboard tournaments on status value
    public function filterTournaments(Request $request, $id)
    {

        $this->data['tournaments'] = Tournament::whereStatus($id)->get();
        return view('admin-panel.tournament.tournament_list')->with([
            'data' => $this->data
        ]);
    }

    //For registraion of team and player view
    public function createTeamForm($team)
    {
        $this->data['tournament_id'] = $team;
        return view('admin-panel.team.create')->with([
            'data' => $this->data
        ]);
    }

    //Team registartion with players
    public function registerTeam(Request $request)
    {
        DB::beginTransaction();
        try {
            $teamArray = [];
            parse_str($request->team, $teamArray);
            $tournament = Tournament::whereId($teamArray['tournament_id'])->first();
            //Current team less than max team and registration date limit
            if ($tournament->current_teams < $tournament->max_teams && Carbon::now() < Carbon::parse($tournament->start_date)->subDays(2)) {
                $tournament->current_teams++;
                $tournament->save();
                $team = Team::create($teamArray);
                $tournament->teams()->attach($team);
                foreach ($request->playerData as $playerData) {
                    $teamArray = [];
                    parse_str($playerData, $teamArray);
                    if ($user = User::whereEmail($teamArray['playerEmail'])->first()) {
                    } else {
                        $password = $teamArray['playerName'] . rand(10000, 99999);
                        $user = User::create([
                            'name' => $teamArray['playerName'],
                            'email' => $teamArray['playerEmail'],
                            'password' => Hash::make($password),
                        ]);
                        //Add Mail functionality to send password to player
                    }
                    $player = $user->players()->create([
                        'player_position' => $teamArray['playerPosition']
                    ]);
                    $team->players()->attach($player);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error');
        }
    }

    //Add team in tournament
    public function addTeam($id)
    {
        try {
            $this->data['tournament'] = Tournament::findOrFail($id);
            return view('admin-panel.team.team_add')->with([
                'data' => $this->data
            ]);
        } catch (\Exception $e) {
            log::info($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function tournamentTeams(Request $request, $id)
    {

        try {
            $this->data['tournament'] = Tournament::with('teams', 'teams.players', 'teams.players.user')->find($id);
            return view('admin-panel.tournament.teams')->with([
                'data' => $this->data
            ]);
        } catch (\Exception $e) {
            log::info($e->getMessage());
        }
    }

    public function tournamentMatches($id)
    {
        try {
            $this->data['tournament'] = Tournament::with(['matches' => function ($query) {
                $query->where('opponent_team_id', '!=', null);
            }, 'matches.homeTeam', 'matches.opponentTeam'])->select('id', 'name')->findOrFail($id);
            return view('admin-panel.tournament.tournament-matches')->with(['data' => $this->data]);
        } catch (\Exception $e) {
            log::info($e->getMessage());
        }
    }

    public function match($id)
    {
        try {
            $this->data['match'] = Matches::with(['matchRecords'=>function($query){
                $query->select('match_id','home_team_score','opponent_team_score');
            }])
                ->join('tournaments', 'tournaments.id', '=', 'matches.tournament_id')
                ->join('teams as home_team', 'home_team.id', '=', 'matches.home_team_id')
                ->join('teams as opponent_team', 'opponent_team.id', '=', 'matches.opponent_team_id')
                ->select('home_team.name as home_team_name','matches.*','tournaments.name as tournament_name','tournaments.start_datetime as tournament_start','opponent_team.name as opponent_team_name', 'matches.*')
                ->findOrFail($id);
            return view('admin-panel.tournament.match_records')->with(['data' => $this->data]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function matchCron(Request $request)
    {

        $matchId = (int)$request->match_id;

        Artisan::call('app:match-records-generate' . ' ' . $matchId);
    }

    public function practice()
    {
        $this->data=MatchRecords::limit(10)->latest()->get();
        dd($this->data);
        return view('admin-panel.tournament.practice');
    }
}

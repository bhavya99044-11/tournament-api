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
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use App\Models\Player;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TournamentController extends Controller
{
    public $data;
    public function __construct()
    {

    }
    public function index(Request $request)
    {
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
                ->addColumn('action',function ($row) use ($data) {
                    $button='<div class="relative mb-10"><button class="edit-data" data-id='.$row->id.'><i class="fas fa-ellipsis-v"></i></button>
                   
                    </div>';
                    return $button;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('admin-panel.tournament.index');
    }

    public function create(Request $request, $id)
    {
    }
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

    public function registerTeam(Request $request)
    {
        DB::beginTransaction();

        try {
            $teamArray = [];
            parse_str($request->team, $teamArray);
            $tournament = Tournament::whereId($teamArray['tournament_id'])->first();
            $team = Team::create($teamArray);
            $tournament->teams()->attach($team);
            foreach ($request->playerData as $playerData) {
                $teamArray = [];
                parse_str($playerData, $teamArray);
                if ($user = User::whereEmail($teamArray['playerEmail'])->first()) {

                } else {
                    $password = $teamArray['playerName'] . rand(10000, 99999);
                    $user = User::create([
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
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

}

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
use App\Models\Player;
use App\Models\User;
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
                ->rawColumns(['status'])
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
        $this->data['team_id'] = $team;
        return view('admin-panel.team.create')->with([
            'data' => $this->data
        ]);
    }

    public function registerTeam(Request $request)
    {
        try {


            $teamArray = [];
            parse_str($request->team, $teamArray);
            $team = Team::create($teamArray);
            foreach ($request->playerData as $team) {

            }
        } catch (\Exception $e) {

        }
    }

}

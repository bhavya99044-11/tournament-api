<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayerPosition;
use App\Models\Team;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
class TeamController extends Controller
{
    protected $data;
    public function getPlayerPositions(){
        $positions = PlayerPosition::all();
        return response()->json($positions);
    }

    public function getTeamPlayers(Request $request,$id){
        $this->data['team']=Team::with('players','players.user')->find($id);
        $playerPosition=PlayerPosition::all();
        if ($request->ajax()) {
            // log::info();
            return DataTables::of($this->data['team']['players'])
                ->addIndexColumn()
                ->addColumn('name',function($row){
                    return $row->user->name;
                })
                ->addColumn('player_position',function($row) use ($playerPosition){
                  return $playerPosition->where('id','=',$row->player_position)->first()->name;
                })
                ->rawColumns(['name','player_position'])
                ->make(true);
        }
        return view('admin-panel.team.list')
        ->with(['data'=>$this->data]);
    }
}

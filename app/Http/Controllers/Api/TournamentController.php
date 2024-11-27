<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TournamentRequest;
use App\Models\Tournament;
use Illuminate\Support\Facades\Log;
use App\Models\Team;
class TournamentController extends Controller
{
    public function create(TournamentRequest $request){
        try{
           Tournament::create($request->all());
            return response()->json(['message'=>'Tournament created successfully'],200);
        }catch(\Exception $e){
            return response()->json(['message'=>$e->getMessage()],404);
        }
    }

    public function index(){
        $tournaments = Tournament::all();
        return response()->json(['data'=>$tournaments],200);
    }

    public function registerTeam(Request $request){
        try{
        $tournament=Tournament::findOrFail($request->tournament_id);
        $team=Team::create([
            'name'=>$request->team_name
        ]);
        $tournament->teams()->attach($team);
        return response()->json(['message'=>'Team registered successfully'],200);
    }
    catch(\Exception $e){
        return response()->json(['message'=>$e->getMessage()],404);
    }
    }

    public function show($id){
        try{
            $tournament=Tournament::find($id);
            return response()->json(['data'=>$tournament],200);
        }catch(\Exception $e){
            return response()->json(['message'=>$e->getMessage()],401);
        }
    }
}

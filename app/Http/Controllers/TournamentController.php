<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Tournament;
use App\Http\Resources\TournamentResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TournamentController extends Controller
{
    public function __construct(){

    }
    public function index(Request $request){
        if($request->ajax()){
            $tournaments = Tournament::all();
            return  TournamentResource::collection($tournaments);
        }
        return view('admin-panel.tournament.index');
    }

    public function create(Request $request,$id){
        Session::put('admin'.$id,$id);
        Session::save();
        // Log::info(Session::all());
        dd(Session::all());
    }
    public function store(TournamentRequest $request){
        // Store tournament data in database
        $request->merge(['organizaer_id'=>Auth::user()->Id]);
        dd($request->validated());
        return response()->json(['message' => 'Tournament created successfully'], 200);
    }

    public function filterTournaments(Request $request ,$id){

    }
}

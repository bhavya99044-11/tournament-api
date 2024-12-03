<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayerPosition;
class TeamController extends Controller
{
    public function getPlayerPositions(){
        $positions = PlayerPosition::all();
        return response()->json($positions);
    }
}

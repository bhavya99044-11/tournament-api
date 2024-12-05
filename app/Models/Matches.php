<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    protected $table='matches';

    protected $fillable=[
        'home_team_id',
        'opponent_team_id',
        'tournament_id',
        'result_id',
        'match_date',
        'start_time',
        'end_time',
        'round',
        'status'
    ];

    public function homeTeam(){
        return $this->belongsTo(Team::class,'home_team_id','id');
    }
    public function opponentTeam(){
        return $this->belongsTo(Team::class,'opponent_team_id','id');
    }

    public function winnerTeam(){
        return $this->belongsTo(Team::class,'result_id','id');
        }
    public function tournament(){
        return $this->belongsTo(Tournament::class,'tournament_id','id');
    }
}

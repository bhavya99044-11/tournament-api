<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table="teams";

    protected $fillable=[
        'name'
    ];

    public function tournament(){
        return $this->belongsToMany(Tournament::class,'tournament_teams','team_id','tournament_id');
    }

    public function players(){
        return $this->belongsToMany(Player::class,'team_players','team_id','player_id')->withPivot('team_id');
    }

}

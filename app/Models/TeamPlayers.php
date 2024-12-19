<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamPlayers extends Model
{
    protected $table='team_players';

    protected $fillable=[
        'team_id',
        'player_id'
    ];

    protected $timestamp=false;

    public function team(){
        return $this->belongsTo(Team::class,'team_id');
    }

    public function player(){
        return $this->belongsTo(Player::class,'player_id');
    }
}

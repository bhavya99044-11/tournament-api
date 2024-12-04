<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table='players';

    protected $fillable=[
        'user_id',
        'player_position'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function teams(){
        return $this->belongsToMany(Player::class,'player_id','team_id');
    }

}

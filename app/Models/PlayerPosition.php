<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerPosition extends Model
{
    protected $table="player_positions";
    protected $fillable=[
        'name'
    ];

    protected $timestamp=false;

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $table="tournaments";

    protected $fillable=[
        'name',
        'location',
        'max_teams',
        'min_teams',
        'start_date',
        'end_date',
        'current_teams',
        'status',
        'organizer_id',
        'tournament_type',
    ];
    public function matches(){
        return $this->hasMany(Matches::class);
    }

    public function teams(){
        return $this->belongsToMany(Team::class,'tournament_teams','tournament_id','team_id');
    }

}

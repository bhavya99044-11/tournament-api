<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
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

    public function favouriteUsers(){
        return $this->belongsToMany(User::class,'favourite_user_tournaments','tournament_id','user_id');
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}

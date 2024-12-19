<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchRecords extends Model
{
    protected $table='match_records';

    protected $fillable=[
        'match_id',
        'home_team_score',
        'opponent_team_score'
    ];

    public function match(){
        return $this->belongsTo(Matches::class,'match_id');
    }
}

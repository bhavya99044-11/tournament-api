<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentTeams extends Model
{
    protected $table='tournament_teams';

    protected $fillable=[
        'tournament_id',
        'team_id'
    ];
}

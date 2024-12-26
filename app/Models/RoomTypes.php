<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomTypes extends Model
{
    protected $table='room_types';

    protected $fillable=[
        'room_id',
        'type'
    ];
}

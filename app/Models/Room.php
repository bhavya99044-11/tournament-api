<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table='rooms';

    protected $fillable=['hotel_id','room_type','meal_plan','name'];

    public function hotel(){
        return $this->belongsTo(Hotel::class,'hotel_id','id');
    }

    public function roomTypes(){
        return $this->hasMany(RoomTypes::class,'room_id','id');
    }
}

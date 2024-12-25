<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table='hotels';

    protected $fillable=['name','image_url'];

    public function hotemAmenities(){
        return $this->hasMany(HotelAmenities::class,'hotel_id','id');
    }

    public function hotelRooms(){
        return $this->hasMany(Room::class,'hotel_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelAmenities extends Model
{
    protected $table='hotel_amenities';

    protected $fillable=['name','hotel_id'];

    public $timestamps=false;

    public function hotel(){
        return $this->belongsTo(Hotel::class,'hotel_id','id');
    }
}

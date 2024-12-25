<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table='hotel_amenities';

    protected $fillable=['name','hotel_id'];

    public function hotel(){
        return $this->belongsTo(Hotel::class,'hotel_id','id');
    }
}

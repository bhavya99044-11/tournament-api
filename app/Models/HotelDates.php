<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelDates extends Model
{
    protected $table='hotel_dates';

    protected $fillable=[
        'hotel_id',
        'start_date',
        'end_date',
    ];

    public function hotel(){
        return $this->belongsTo(Hotel::class,'hotel_id','id');
    }
}

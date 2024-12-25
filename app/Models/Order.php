<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\OrderStatus;
use Illuminate\Database\Eloquent\Builder;
use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    protected $table='orders';

    public $casts=[
        'status'=>OrderStatus::class
    ];

    protected $fillable=[
        'status',
        'user_id'
    ];

    public function scopeActiveStatus(Builder $builder){
        $builder->where('status',2);
    }
}

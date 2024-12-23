<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Csv extends Model
{
    protected $fillable=[
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'basic_salary'
    ];

    protected $table='csvs';
}

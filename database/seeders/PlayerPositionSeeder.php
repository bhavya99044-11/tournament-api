<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlayerPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions=['Goalkeeper','Defender','Fielder','Striker'];

        foreach($positions as $position){
            \App\Models\PlayerPosition::insert(['name' => $position]);
        }
    }

}

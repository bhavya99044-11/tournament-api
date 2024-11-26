<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\factory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //static use
        User::create([
            'name' => 'Bhavya',
            'email' => 'Bhavya@example.com',
            'password' => Hash::make('123')
        ]);
    }
}

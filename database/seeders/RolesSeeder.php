<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles=['super admin', 'admin','Tournament Organizer','Team Owner','Player'];

        foreach($roles as $role){
            \Spatie\Permission\Models\Role::create(['name' => $role]);
        }

        $user=User::whereEmail('bhavya@example.com')->first();
        $user->assignRole('super admin');
    }
}

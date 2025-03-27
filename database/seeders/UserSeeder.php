<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;


class UserSeeder extends Seeder
{
    public function run()
    {
        // Create an Admin User
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $adminUser->roles()->attach($adminRole);


        // Create a regular User
        $regularUser = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bycrypt('password')
        ]);

        $userRole = Role::where('name', 'user')->first();
        $regularUser->roles()->attach($userRole);
    }
}

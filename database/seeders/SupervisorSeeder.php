<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class SupervisorSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'UserName' => 'Supervisor1',
            'email' => 'supervisor1@example.com',
            'password' => bcrypt('password123'),
            'Role' => 'supervisor',
            'Program' => 'Engineering',
        ]);
    }
}


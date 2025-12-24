<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class SupervisorSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['Email' => 'supervisor1@example.com'],
            [
                'UserName' => 'Supervisor1',
                'password' => 'password123',
                'Role' => 'supervisor',
                'Program' => 'Engineering',
                'password_changed' => false,
            ]
        );
    }
}


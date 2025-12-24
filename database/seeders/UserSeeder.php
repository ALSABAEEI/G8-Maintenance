<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['Email' => 'test@example.com'],
            [
                'UserName' => 'test_user',
                'password' => 'password123',
                'Role' => 'admin',
                'Program' => 'Software Engineering',
                'password_changed' => false,
            ]
        );
    }
}


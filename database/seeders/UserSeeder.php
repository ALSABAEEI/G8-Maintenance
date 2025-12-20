<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'UserName' => 'test_user',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'Role' => 'admin',
            'Program' => 'Software Engineering',
        ]);
    }
}


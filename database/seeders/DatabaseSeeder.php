<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['Email' => 'admin@example.com'],
            [
                'UserName' => 'admin',
                'password' => 'password',
                'Role' => 'admin',
                'Program' => 'Default',
                'password_changed' => false,
            ]
        );

        User::updateOrCreate(
            ['Email' => 'supervisor@example.com'],
            [
                'UserName' => 'supervisor',
                'password' => 'password',
                'Role' => 'supervisor',
                'Program' => 'Engineering',
                'password_changed' => false,
            ]
        );

        User::updateOrCreate(
            ['Email' => 'student@example.com'],
            [
                'UserName' => 'student',
                'password' => 'password',
                'Role' => 'student',
                'Program' => 'Software Engineering',
                'password_changed' => false,
            ]
        );
    }
}

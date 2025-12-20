<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'UserName' => $this->faker->userName, // Matches the UserName field
            'Email' => $this->faker->unique()->safeEmail,
            'password' => 'password123', // Hashed automatically by model
            'Role' => $this->faker->randomElement(['admin', 'supervisor', 'student']),
            'Program' => $this->faker->word, // Matches the Program field
        ];
    }
}

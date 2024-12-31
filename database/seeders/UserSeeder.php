<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => fake()->name(),
                'role' => $i,
                'email' => fake()->unique()->safeEmail(),
                'password' => 'test',
            ]);
        }
    }
}

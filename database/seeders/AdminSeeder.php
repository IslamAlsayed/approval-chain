<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create(['name' => 'admin1', 'role' => 1]);
        Admin::create(['name' => 'admin2', 'role' => 2]);
        Admin::create(['name' => 'admin3', 'role' => 3]);
    }
}

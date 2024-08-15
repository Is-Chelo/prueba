<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => '12345678',
        ]);

        User::factory()->create([
            'name' => 'Customer 1',
            'email' => 'customer1@gmail.com',
            'role' => 'customer',
            'password' => '12345678',

        ]);
    }
}

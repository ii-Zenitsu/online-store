<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a specific admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'balance' => 0,
            'password' => Hash::make('password'), // Default password, change as needed
            'role' => 'admin',
        ]);

        // Create some regular users
        User::factory()->count(5)->create();
    }
}

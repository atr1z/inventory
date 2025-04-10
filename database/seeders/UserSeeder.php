<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a manager user for testing
        User::create([
            'name' => 'Admin',
            'last_name' => 'Manager',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'encargado',
        ]);
        
        // Create a seller user for testing
        User::create([
            'name' => 'Seller',
            'last_name' => 'User',
            'email' => 'seller@example.com',
            'password' => Hash::make('password'),
            'role' => 'vendedor',
        ]);
    }
}

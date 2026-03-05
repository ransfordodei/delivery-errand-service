<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin1234'),
            'role' => User::ROLE_ADMIN,
        ]);

        // Test User
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => User::ROLE_USER,
        ]);

        // Additional customers
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('john1234'),
            'role' => User::ROLE_USER,
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('jane1234'),
            'role' => User::ROLE_USER,
        ]);

        // Vendors
        User::create([
            'name' => 'Vendor User',
            'email' => 'vendor@example.com',
            'password' => Hash::make('vendor1234'),
            'role' => User::ROLE_VENDOR,
        ]);

        User::create([
            'name' => 'Pizza Palace',
            'email' => 'pizza@example.com',
            'password' => Hash::make('pizza1234'),
            'role' => User::ROLE_VENDOR,
        ]);

        User::create([
            'name' => 'Burger Barn',
            'email' => 'burgers@example.com',
            'password' => Hash::make('burgers1234'),
            'role' => User::ROLE_VENDOR,
        ]);

        // Riders
        User::create([
            'name' => 'Rider User',
            'email' => 'rider@example.com',
            'password' => Hash::make('rider1234'),
            'role' => User::ROLE_RIDER,
        ]);

        User::create([
            'name' => 'Tom Wilson',
            'email' => 'tom@example.com',
            'password' => Hash::make('tom1234'),
            'role' => User::ROLE_RIDER,
        ]);

        User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@example.com',
            'password' => Hash::make('sarah1234'),
            'role' => User::ROLE_RIDER,
        ]);
    }
}
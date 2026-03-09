<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Store;
use App\Models\Rider;
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

        // Vendors with multiple stores
        $vendor1 = User::create([
            'name' => 'Vendor User',
            'email' => 'vendor@example.com',
            'password' => Hash::make('vendor1234'),
            'role' => User::ROLE_VENDOR,
        ]);
        $vendorRecord1 = Vendor::create([
            'user_id' => $vendor1->id,
            'name' => 'Vendor User',
            'category' => 'General',
            'description' => 'A reliable vendor company',
            'phone' => '555-0100',
            'address' => 'Main Office',
            'rating' => 4.5,
        ]);
        Store::create([
            'vendor_id' => $vendorRecord1->id,
            'name' => 'Vendor User - Downtown Store',
            'category' => 'General',
            'description' => 'Downtown location',
            'phone' => '555-0101',
            'address' => '123 Main St',
            'rating' => 4.5,
            'is_active' => true,
        ]);
        Store::create([
            'vendor_id' => $vendorRecord1->id,
            'name' => 'Vendor User - Uptown Store',
            'category' => 'General',
            'description' => 'Uptown location',
            'phone' => '555-0102',
            'address' => '456 Oak Ave',
            'rating' => 4.4,
            'is_active' => true,
        ]);

        $vendor2 = User::create([
            'name' => 'Pizza Palace',
            'email' => 'pizza@example.com',
            'password' => Hash::make('pizza1234'),
            'role' => User::ROLE_VENDOR,
        ]);
        $vendorRecord2 = Vendor::create([
            'user_id' => $vendor2->id,
            'name' => 'Pizza Palace',
            'category' => 'Food & Beverage',
            'description' => 'Authentic Italian pizza restaurant chain',
            'phone' => '555-0110',
            'address' => 'Main Office',
            'rating' => 4.8,
        ]);
        Store::create([
            'vendor_id' => $vendorRecord2->id,
            'name' => 'Pizza Palace - Central',
            'category' => 'Food & Beverage',
            'description' => 'Authentic Italian pizza restaurant',
            'phone' => '555-0111',
            'address' => '456 Pizza Lane',
            'rating' => 4.8,
            'is_active' => true,
        ]);
        Store::create([
            'vendor_id' => $vendorRecord2->id,
            'name' => 'Pizza Palace - East Side',
            'category' => 'Food & Beverage',
            'description' => 'East side branch',
            'phone' => '555-0112',
            'address' => '789 East Blvd',
            'rating' => 4.7,
            'is_active' => true,
        ]);

        $vendor3 = User::create([
            'name' => 'Burger Barn',
            'email' => 'burgers@example.com',
            'password' => Hash::make('burgers1234'),
            'role' => User::ROLE_VENDOR,
        ]);
        $vendorRecord3 = Vendor::create([
            'user_id' => $vendor3->id,
            'name' => 'Burger Barn',
            'category' => 'Food & Beverage',
            'description' => 'Delicious burgers and fries chain',
            'phone' => '555-0120',
            'address' => 'Main Office',
            'rating' => 4.6,
        ]);
        Store::create([
            'vendor_id' => $vendorRecord3->id,
            'name' => 'Burger Barn - Main',
            'category' => 'Food & Beverage',
            'description' => 'Signature location',
            'phone' => '555-0121',
            'address' => '789 Burger Blvd',
            'rating' => 4.6,
            'is_active' => true,
        ]);
        Store::create([
            'vendor_id' => $vendorRecord3->id,
            'name' => 'Burger Barn - North',
            'category' => 'Food & Beverage',
            'description' => 'North location',
            'phone' => '555-0122',
            'address' => '321 North St',
            'rating' => 4.5,
            'is_active' => true,
        ]);

        // Riders
        $rider1 = User::create([
            'name' => 'Rider User',
            'email' => 'rider@example.com',
            'password' => Hash::make('rider1234'),
            'role' => User::ROLE_RIDER,
        ]);
        Rider::create([
            'user_id' => $rider1->id,
            'phone' => '555-0110',
            'vehicle_type' => 'Bicycle',
            'status' => 'available',
            'rating' => 4.7,
        ]);

        $rider2 = User::create([
            'name' => 'Tom Wilson',
            'email' => 'tom@example.com',
            'password' => Hash::make('tom1234'),
            'role' => User::ROLE_RIDER,
        ]);
        Rider::create([
            'user_id' => $rider2->id,
            'phone' => '555-0111',
            'vehicle_type' => 'Motorcycle',
            'status' => 'available',
            'rating' => 4.9,
        ]);

        $rider3 = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@example.com',
            'password' => Hash::make('sarah1234'),
            'role' => User::ROLE_RIDER,
        ]);
        Rider::create([
            'user_id' => $rider3->id,
            'phone' => '555-0112',
            'vehicle_type' => 'Car',
            'status' => 'available',
            'rating' => 4.8,
        ]);
    }
}
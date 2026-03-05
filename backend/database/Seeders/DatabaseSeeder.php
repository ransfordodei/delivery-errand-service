<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // call other seeders
        $this->call([
            UserSeeder::class,
            // you can add other seeders here
        ]);
    }
}

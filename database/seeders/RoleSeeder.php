<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        Role::firstOrCreate(['name' => 'Member']);
        Role::firstOrCreate(['name' => 'Admin']);
        // Add any other roles your app needs
    
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Admin User
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password123'),
            ]
        );

        // Test Student Officer User
        User::updateOrCreate(
            ['email' => 'officer@example.com'],
            [
                'name' => 'Academic Officer',
                'password' => Hash::make('password123'),
            ]
        );

        $this->call([
            DepartmentSeeder::class,
            StudentSeeder::class,
        ]);
    }
}

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
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@smecone.music'],
            [
                'name' => 'Admin Smecone',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_approved' => true,
            ]
        );

        // Perkap
        User::updateOrCreate(
            ['email' => 'perkap@smecone.music'],
            [
                'name' => 'Perkap Smecone',
                'password' => Hash::make('password'),
                'role' => 'perkap',
                'is_approved' => true,
            ]
        );

        // Regular User (Approved)
        User::updateOrCreate(
            ['email' => 'user@smecone.music'],
            [
                'name' => 'Anggota Smecone',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_approved' => true,
            ]
        );
    }
}

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
        $this->call(RoleAndPermissionSeeder::class);

        // Ketua / Super Admin
        User::updateOrCreate(
            ['email' => 'admin@smecone.music'],
            [
                'name' => 'Ketua Smecone Music',
                'password' => Hash::make('password'),
                'role' => 'ketua',
                'is_approved' => true,
            ]
        );

        // Regular User (Approved)
        User::updateOrCreate(
            ['email' => 'user@smecone.music'],
            [
                'name' => 'Anggota Music',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_approved' => true,
            ]
        );
    }
}

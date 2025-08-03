<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        AdminUser::create([
            'name' => 'Admin Chorale',
            'email' => 'admin@chorale.com',
            'password' => Hash::make('password123'),
        ]);

    }
}

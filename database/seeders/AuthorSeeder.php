<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create the Fixed Test Author (For you to log in)
        User::create([
            'name' => 'Dr. John Doe',
            'email' => 'author@plantshealth.com',
            'password' => Hash::make('password123'),
            'role' => 'author',
            'bio' => 'Senior Researcher in Agricultural Sciences.',
            'is_blocked' => false,
        ]);

        // 2. Create 20 Random Authors
        User::factory()->count(20)->create([
            'role' => 'author', // Ensure they are authors
        ]);
    }
}

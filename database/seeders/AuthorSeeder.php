<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         User::create([
            'name' => 'Dr. John Doe',
            'email' => 'author@plantshealth.com',
            'password' => Hash::make('password123'), // Encrypted password
            'role' => 'author', // Explicitly set as author
        ]);
    }
}

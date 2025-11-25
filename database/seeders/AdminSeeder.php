<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
          User::create([
            'name' => 'Super Admin',
            'email' => 'admin@plantshealth.com',
            'password' => Hash::make('password123'), // Secure hashing
            'role' => 'admin', // This is the magic key
        ]);
    }
}

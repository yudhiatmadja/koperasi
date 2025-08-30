<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'Koperasi.caremedia@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('K0p3r@si_C@r3M3d!a2025'),
            'role' => 'admin',
        ]);
    }
}

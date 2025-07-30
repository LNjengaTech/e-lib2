<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Admin user
    User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'utype' => 'ADM',
        'password' => Hash::make('password123'),
    ]);

}
}

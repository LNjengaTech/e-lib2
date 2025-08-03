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
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'utype' => 'ADM',
        'password' => Hash::make('password123'),
    ]);

    //Normal User
    User::create([
        'name' => 'Super Admin',
        'email' => 'superadmin@example.com',
        'utype' => 'SPRADM',
        'password' => Hash::make('password123')
    ]);

}
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin123',
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Staff1',
            'email' => 'staf1@gmail.com',
            'password' => 'staf1123',
            'role' => 'staff'
        ]);
        User::create([
            'name' => 'Staf2',
            'email' => 'staf2@gmail.com',
            'password' => 'staf2123',
            'role' => 'staff'
        ]);
    }
}

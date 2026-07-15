<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/seed-users', function () {
    if (User::count() > 0) {
        return response()->json(['message' => 'Users already seeded']);
    }
    
    User::create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('admin123'),
        'role' => 'admin'
    ]);
    User::create([
        'name' => 'Staff1',
        'email' => 'staf1@gmail.com',
        'password' => bcrypt('staf1123'),
        'role' => 'staff'
    ]);
    User::create([
        'name' => 'Staf2',
        'email' => 'staf2@gmail.com',
        'password' => bcrypt('staf2123'),
        'role' => 'staff'
    ]);
    
    return response()->json(['message' => 'Users seeded successfully']);
});

<?php

namespace Tests\Feature;

use App\Models\User;

test('test login berhasil dapat token', function () {
    $user = User::factory()->create([
        'role' => 'admin',
        'password' => bcrypt('admin123')
    ]);

    $response = $this->postJson('api/login', [
        'email' => $user->email,
        'password' => 'admin123'
    ]);
    $response->assertStatus(200)
        ->assertJsonStructure([
            'token',
            'user'
        ]);
});

test('test login gagal salah password', function(){
    $user = User::factory()->create([
        'role' => 'admin',
        'password' => bcrypt('admin123')
    ]);

    $response = $this->postJson('api/login', [
        'email' => $user->email,
        'password' => 'admin321'
    ]);
    $response->assertStatus(401);
});

test('test logout revoke token', function(){
    $user = User::factory()->create([
        'role' => 'admin',
        'password' => bcrypt('admin123')
    ]);

    $token = $user->createToken('test-token')->plainTextToken;
    $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('api/logout');
    $response->assertStatus(200);
});
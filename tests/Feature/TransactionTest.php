<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use App\Events\StockLow;

test('staff bisa mencatat stock transaction', function () {
    $user = User::factory()->create(['role' => 'staff']);
    $token = $user->createToken('test')->plainTextToken;

    $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
    $supplier = Supplier::create(['name' => 'Test Supplier', 'email' => 'test@gmail.com', 'phone' => '08123456789', 'address' => 'Test Address']);

    $product = Product::factory()->create([
        'category_id' => $category->id,
        'supplier_id' => $supplier->id,
        'stock' => 10
    ]);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('/api/transactions', [
            'product_id' => $product->id,
            'type' => 'in',
            'quantity' => 5,
            'note' => 'Restock'
        ]);
    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'data' => ['id', 'product_id', 'type', 'quantity', 'stock_before', 'stock_after']
        ]);

    expect($product->fresh()->stock)->toBe(15);
});

test('transaction out melebihi stock tolak', function () {
    $user = User::factory()->create(['role' => 'staff']);
    $token = $user->createToken('test')->plainTextToken;

    $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
    $supplier = Supplier::create(['name' => 'Test Supplier', 'email' => 'test@gmail.com', 'phone' => '08123456789', 'address' => 'Test Address']);

    $product = Product::factory()->create([
        'category_id' => $category->id,
        'supplier_id' => $supplier->id,
        'stock' => 5
    ]);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('/api/transactions', [
            'product_id' => $product->id,
            'type' => 'out',
            'quantity' => 6,
            'note' => 'Restock'
        ]);
    $response->assertStatus(422);
});

test('fire Event StockLow saat stock <= min_stock', function(){
    Event::fake();
    
    $user = User::factory()->create(['role' => 'staff']);
    $token = $user->createToken('test')->plainTextToken;

    $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
    $supplier = Supplier::create([
        'name' => 'Test Supplier', 
        'email' => 'test@gmail.com', 
        'phone' => '08123456789', 
        'address' => 'Test Address'
    ]);

    $product = Product::factory()->create([
        'category_id' => $category->id,
        'supplier_id' => $supplier->id,
        'stock' => 10,
        'min_stock' => 5
    ]);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('/api/transactions', [
            'product_id' => $product->id,
            'type' => 'out',
            'quantity' => 6,
            'note' => 'Sale'
        ]);
    
    $response->assertStatus(201);
    
    Event::assertDispatched(StockLow::class, function ($event) use ($product) {
        return $event->transaction->product_id === $product->id;
    });
});

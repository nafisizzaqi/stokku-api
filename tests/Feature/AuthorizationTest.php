<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

test('staff dapat 403 ketika post product', function () {
    $user = User::factory()->create(['role' => 'staff']);
    $token = $user->createToken('test-token')->plainTextToken;

    $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
    $supplier = Supplier::create(['name' => 'Test Supplier', 'email' => 'test@gmail.com', 'phone' => '08123456789', 'address' => 'Test Address']);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('/api/products', [
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'name' => 'Buggle',
            'sku' => 'Test',
            'price' => '10000.00',
            'stock' => 5,
            'min_stock' => 1,
            'image' => UploadedFile::fake()->image('product.jpg'),
            'is_active' => 0
        ]);
    $response->assertStatus(403);
});

test('staff dapat 403 ketika update product', function () {
    $user = User::factory()->create(['role' => 'staff']);
    $token = $user->createToken('test-token')->plainTextToken;

    $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
    $supplier = Supplier::create(['name' => 'Test Supplier', 'email' => 'test@gmail.com', 'phone' => '08123456789', 'address' => 'Test Address']);

    $product = Product::create([
        'category_id' => $category->id,
        'supplier_id' => $supplier->id,
        'name' => 'Old Product',
        'sku' => 'OLD-SKU',
        'price' => 5000.00,
        'stock' => 10,
        'min_stock' => 1,
        'image_path' => 'old.jpg',
        'is_active' => 1
    ]);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson("/api/products/{$product->id}", [
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'name' => 'Mie',
            'sku' => 'M',
            'price' => '12000.00',
            'stock' => 10,
            'min_stock' => 2,
            'image' => UploadedFile::fake()->image('product.jpg'),
            'is_active' => 0
        ]);
    $response->assertStatus(403);
});

test('staff dapat 403 ketika delete product', function () {
    $user = User::factory()->create(['role' => 'staff']);
    $token = $user->createToken('test-token')->plainTextToken;

    $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
    $supplier = Supplier::create(['name' => 'Test Supplier', 'email' => 'test@gmail.com', 'phone' => '08123456789', 'address' => 'Test Address']);

    $product = Product::create([
        'category_id' => $category->id,
        'supplier_id' => $supplier->id,
        'name' => 'Old Product',
        'sku' => 'OLD-SKU',
        'price' => 5000.00,
        'stock' => 10,
        'min_stock' => 1,
        'image_path' => 'old.jpg',
        'is_active' => 1
    ]);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson("/api/products/{$product->id}");
    $response->assertStatus(403);
});

test('admin dapat 201 ketika post product', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('test-token')->plainTextToken;

    $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
    $supplier = Supplier::create(['name' => 'Test Supplier', 'email' => 'test@gmail.com', 'phone' => '08123456789', 'address' => 'Test Address']);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('/api/products', [
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'name' => 'Buggle',
            'sku' => 'Test',
            'price' => '10000.00',
            'stock' => 5,
            'min_stock' => 1,
            'image' => UploadedFile::fake()->image('product.jpg'),
            'is_active' => 0
        ]);
    $response->assertStatus(201);
});

test('admin dapat 200 ketika update product', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('test-token')->plainTextToken;

    $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
    $supplier = Supplier::create(['name' => 'Test Supplier', 'email' => 'test@gmail.com', 'phone' => '08123456789', 'address' => 'Test Address']);

    $product = Product::create([
        'category_id' => $category->id,
        'supplier_id' => $supplier->id,
        'name' => 'Old Product',
        'sku' => 'OLD-SKU',
        'price' => 5000.00,
        'stock' => 10,
        'min_stock' => 1,
        'image_path' => 'old.jpg',
        'is_active' => 1
    ]);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson("/api/products/{$product->id}", [
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'name' => 'Mie',
            'sku' => 'M',
            'price' => '12000.00',
            'stock' => 10,
            'min_stock' => 2,
            'image' => UploadedFile::fake()->image('product.jpg'),
            'is_active' => 0
        ]);
    $response->assertStatus(200);
});

test('admin dapat 200 ketika delete product', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $token = $user->createToken('test-token')->plainTextToken;

    $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
    $supplier = Supplier::create(['name' => 'Test Supplier', 'email' => 'test@gmail.com', 'phone' => '08123456789', 'address' => 'Test Address']);

    $product = Product::create([
        'category_id' => $category->id,
        'supplier_id' => $supplier->id,
        'name' => 'Old Product',
        'sku' => 'OLD-SKU',
        'price' => 5000.00,
        'stock' => 10,
        'min_stock' => 1,
        'image_path' => 'old.jpg',
        'is_active' => 1
    ]);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson("/api/products/{$product->id}");
    $response->assertStatus(200);
});
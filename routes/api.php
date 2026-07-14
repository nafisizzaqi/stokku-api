<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\SupplierController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/me', [LoginController::class, 'me']);

    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products', ProductController::class)->except('update');
    Route::post('/products/{product}', [ProductController::class, 'update']);
    Route::post('/transactions', [StockController::class, 'store']);
    Route::get('/transactions', [StockController::class, 'history']);

    Route::get('/reports/low-stock', [ReportController::class, 'lowStock']);
    Route::post('/reports/export', [ReportController::class, 'export']);
    Route::get('/reports/export/download', [ReportController::class, 'download']);
});

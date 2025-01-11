<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/api/categories', CategoryController::class);
// Route::apiResource('/api/categories', [CategoryController::class, 'index']);

Route::apiResource('/api/products', ProductController::class);

<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::apiResource('/api/categories/{id}', CategoryController::class);
Route::apiResource('/api/categories', CategoryController::class);
// ->middleware('auth:sanctum');
// Route::apiResource('/api/categories', [CategoryController::class, 'index']);

Route::apiResource('/api/products', ProductController::class);
// ->middleware('auth:sanctum');

Route::apiResource('/api/activities', ActivityController::class);

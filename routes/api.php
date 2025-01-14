<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::post('/login', [LoginController::class,'authentificate']);
Route::post('/login', [LoginController::class,'authentificate'])->middleware('auth:sanctum');

<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::post('/login', [LoginController::class,'authentificate']);
Route::post('/login', [LoginController::class,'authentificate'])->middleware('auth:sanctum');

Route::post('/registration',[RegistrationController::class, 'registration']);
<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryGroupController;
use App\Http\Controllers\DailyRationController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\UserController;
use App\Http\Resources\CategoryGroupCollection;
use App\Models\CategoryGroup;
use App\Models\DailyRation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::post('/login', [LoginController::class,'authentificate']);
// ->middleware('auth:sanctum')
Route::apiResource('/category-groups', CategoryGroupController::class);

Route::apiResource('/categories', CategoryController::class);

Route::apiResource('/products', ProductController::class);

Route::apiResource('/activities', ActivityController::class);

Route::apiResource('/diets', DietController::class)->middleware('auth:sanctum');

Route::apiResource('/users', UserController::class)->middleware('auth:sanctum');

Route::apiResource('/daily-rations', DailyRationController::class)->middleware('auth:sanctum');

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::controller(StatisticController::class)->group(
    function () {
        Route::get('/statistic', 'index');
        Route::get('/statistic/{resource}', 'show');
    }
)->name('statistic');

Route::post('/login', [LoginController::class, 'authentificate']);

Route::get('/logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/registration', [RegistrationController::class, 'registration']);

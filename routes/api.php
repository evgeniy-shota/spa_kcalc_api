<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdditionalProductDataController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\Category\CategoryDestroyController;
use App\Http\Controllers\Category\CategoryIndexController;
use App\Http\Controllers\Category\CategoryShowController;
use App\Http\Controllers\Category\CategoryStoreController;
use App\Http\Controllers\Category\CategoryUpdateController;

use App\Http\Controllers\CategoryGroup\CategoryGroupDestroyController;
use App\Http\Controllers\CategoryGroup\CategoryGroupIndexController;
use App\Http\Controllers\CategoryGroup\CategoryGroupShowController;
use App\Http\Controllers\CategoryGroup\CategoryGroupStoreController;
use App\Http\Controllers\CategoryGroup\CategoryGroupUpdateController;

// use App\Http\Controllers\CategoryGroupController;
use App\Http\Controllers\DailyRationController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Product\ProductIndexController;
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

Route::get('/category-groups/{id}', CategoryGroupShowController::class)->name('categoryGroup.show');
Route::get('/category-groups/', CategoryGroupIndexController::class)->name('categoryGroup.index');
// ->middleware('auth:sanctum')
Route::post('/category-groups/{id}', CategoryGroupUpdateController::class)->name('categoryGroup.update')->middleware('auth:sanctum');
Route::post('/category-groups/', CategoryGroupStoreController::class)->name('categoryGroup.store')->middleware('auth:sanctum');
Route::delete('/category-groups/{id}', CategoryGroupDestroyController::class)->name('categoryGroup.destroy')->middleware('auth:sanctum');

// Route::apiResource('/category-groups', CategoryGroupController::class);

Route::get('/categories/{id}', CategoryShowController::class)->name('category.show');
Route::get('/categories/', CategoryIndexController::class)->name('category.index');
// ->middleware('auth:sanctum')
Route::post('/categories/{id}', CategoryUpdateController::class)->name('category.update')->middleware('auth:sanctum');
Route::post('/categories/', CategoryStoreController::class)->name('category.store')->middleware('auth:sanctum');
Route::delete('/categories/{id}', CategoryDestroyController::class)->name('category.destroy')->middleware('auth:sanctum');


// Route::controller(CategoryController::class)->group(function () {
// Route::get('/categories', 'index');
// Route::get('/categories/{id}', 'show');
// Route::post('/categories', 'store');
// Route::patch('/categories/{id}', 'update');
// Route::delete('/categories/{id}', 'destroy');
// });

// Route::apiResource('/categories', CategoryController::class);

Route::get('/products/', ProductIndexController::class)->name('products.index');

Route::controller(ProductController::class)->group(function () {
    Route::post('/products/create/', 'store');
    Route::post('/products', 'index');
    Route::post('/products/{category_id}', 'productsFromCategory');
    // Route::get('/products/{id}', 'show');
    Route::patch('/products/{id}', 'update');
    Route::delete('/products/{id}', 'destroy');
});

// Route::apiResource('/products', ProductController::class);

Route::get('/additional-products-data', [AdditionalProductDataController::class, 'index'])->name('additionalProductData');

Route::apiResource('/activities', ActivityController::class);

Route::apiResource('/diets', DietController::class)->middleware('auth:sanctum');

Route::apiResource('/users', UserController::class)->middleware('auth:sanctum');

Route::apiResource('/daily-rations', DailyRationController::class)->middleware('auth:sanctum');

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::controller(StatisticController::class)->group(
    function () {
        Route::get('/statistic', 'index');
        Route::get('/statistic/{resource}', 'show');
        Route::post('/statistic', 'splitByTimeStat');
    }
)->name('statistic');

Route::post('/login', [LoginController::class, 'authentificate']);

Route::get('/logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/registration', [RegistrationController::class, 'registration']);

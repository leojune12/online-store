<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Modules\ShopController;
use App\Http\Controllers\Modules\UserController;
use App\Http\Controllers\Modules\ProductController;
use App\Http\Controllers\Modules\CategoryController;
use App\Http\Controllers\Modules\PermissionController;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware(['is_active', 'auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('products', ProductController::class);

    Route::resource('shop', ShopController::class);

    Route::middleware(['role:Superadmin|Admin'])->group(function () {

        Route::resource('permissions', PermissionController::class);

        Route::resource('users', UserController::class);

        Route::post('users/{user}/disable', [UserController::class, 'disable'])->name('users.disable');

        Route::resource('categories', CategoryController::class);
    });
});

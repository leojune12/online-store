<?php

use App\Http\Controllers\Modules\PermissionController;
use App\Http\Controllers\Modules\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['is_active', 'auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/items', function () {
        return Inertia::render('Shop/Products');
    })->name('items');

    Route::middleware(['role:Superadmin|Admin'])->group(function () {

        Route::resource('permissions', PermissionController::class);

        Route::resource('users', UserController::class);

        Route::post('users/{user}/disable', [UserController::class, 'disable'])->name('users.disable');
    });
});

Route::get('/logout-user', function () {
    Auth::logout();

    return redirect('/');
});

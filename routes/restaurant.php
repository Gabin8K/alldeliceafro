<?php

use App\Http\Controllers\Restaurant\DashboardController;
use App\Http\Controllers\Restaurant\InfoController;
use App\Http\Controllers\Restaurant\ProductController;
use App\Http\Controllers\Restaurant\ProfileController;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => '{language}/restaurant',
    'as' => 'restaurant.'
], function () {

    Route::middleware(['auth.restaurant', 'verified'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::put('/profile', [ProfileController::class, 'updatePassword'])
            ->name('profile.password.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');

        Route::get('/info', [InfoController::class, 'edit'])
            ->name('info.edit');

        Route::patch('/info', [InfoController::class, 'update'])
            ->name('info.update');

        Route::patch('/info/update/opening-hours', [InfoController::class, 'updateOpeningHours'])
            ->name('info.update.opening.hours');

        Route::get('/products', [ProductController::class, 'index'])
            ->name('products');

        Route::get('/products/{product}', [ProductController::class, 'show'])
            ->name('products.show');

        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');

        Route::patch('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');

        Route::delete('/products/{product}', [ProductController::class, 'delete'])
            ->name('products.delete');
    });

});

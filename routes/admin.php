<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ArticleShopController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ShopController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '{language}/admin',
    'as' => 'admin.'
], function () {

    Route::middleware(['auth.admin', 'verified'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('categories', CategoryController::class)
            ->except(['create', 'edit']);

        Route::resource('articles', ArticleController::class)
            ->except(['create', 'edit']);

        Route::resource('shops', ShopController::class)
            ->except(['create']);

        Route::post('/shops/{shop}/edit/store-article', [ArticleShopController::class, 'store'])
            ->name('shops.store.article');

        Route::patch('/shops/{shop}/edit/update-article', [ArticleShopController::class, 'update'])
            ->name('shops.update.article');

        Route::delete('/shops/{shop}/edit/destroy-article', [ArticleShopController::class, 'destroy'])
            ->name('shops.destroy.article');

        Route::post('/logout', [AuthController::class, 'destroy'])
            ->name('logout');

    });

    Route::middleware(['guest'])->group(function () {

        Route::get('/login', [AuthController::class, 'login'])
            ->name('login');

        Route::post('/login', [AuthController::class, 'authenticate'])
            ->name('authenticate');

    });
});

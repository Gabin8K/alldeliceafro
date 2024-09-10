<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TemporaryFileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\CheckLanguage;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/en');

Route::group([
    'prefix' => '{language}',
    'middleware' => CheckLanguage::class
], function () {
    Route::get('/', WelcomeController::class)->name('welcome');

    Route::get('/change/locale/{newLocale}', LocaleController::class)->name('change.locale');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::post('/upload-tmp', [TemporaryFileController::class, 'store'])->middleware('auth');
    Route::delete('/delete-tmp/{uniqueId}', [TemporaryFileController::class, 'delete'])->middleware('auth');

    Route::get('/images/{disk}/{id}', [ImageController::class, 'show'])->middleware('auth');
    Route::delete('/images/{id}', [ImageController::class, 'delete'])->middleware('auth')->name('delete.image');

    Route::get('/shops', [ShopController::class, 'index'])->name('get.shops');
});



require __DIR__.'/auth.php';
require __DIR__.'/partner.php';
require __DIR__.'/restaurant.php';
require __DIR__.'/admin.php';

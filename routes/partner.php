<?php

use App\Http\Controllers\Partner\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '{language}/partner',
    'as' => 'partner.'
], function () {

    Route::middleware('guest')->group(function () {
        Route::get('/', [AuthController::class, 'index'])
            ->name('index');

        Route::get('register', [AuthController::class, 'create'])
            ->name('register');

        Route::post('register', [AuthController::class, 'store'])
            ->name('register.store');

        Route::get('login', [AuthController::class, 'login'])
            ->name('login');

        Route::post('login', [AuthController::class, 'authenticate']);

        Route::get('forgot-password', [AuthController::class, 'forgotPassword'])
            ->name('password.request');

        Route::post('forgot-password', [AuthController::class, 'forgotPasswordStore'])
            ->name('password.email');

        Route::get('reset-password/{token}', [AuthController::class, 'resetPassword'])
            ->name('password.reset');

        Route::post('reset-password', [AuthController::class, 'resetPasswordStore'])
            ->name('password.store');

        Route::get('verify-email/{user_id}', [AuthController::class, 'verifyEmail'])
            ->name('verify.email');

        Route::post('verify-email', [AuthController::class, 'verifyEmailStore'])
            ->name('verify.email.store');

        Route::get('verify-email-request/{user_id}', [AuthController::class, 'verifyEmailRequest'])
            ->name('verify.email.request');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'destroy'])
            ->name('logout');
    });

});

<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DocumentController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\RestaurantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/authenticate', [AuthController::class, 'authenticate']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/request-verification-code', [AuthController::class, 'requestVerificationCode']);
    Route::post('/verify', [AuthController::class, 'verify']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile/picture/get', [DocumentController::class, 'getPicture']);
    Route::post('/profile/picture/update', [DocumentController::class, 'updatePicture']);
    Route::delete('/profile/picture/delete', [DocumentController::class, 'deletePicture']);

    Route::get('/restaurants', [RestaurantController::class, 'index']);
    Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
});

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Route::get('/products', [ProductController::class])->name('products');

Route::prefix('auth')->group(function(){

    Route::post('/login', [AuthController::class, 'login'])
    ->withoutMiddleware(['auth:api', 'auth:sanctum']);

    Route::post('/register', [AuthController::class, 'register'])
    ->withoutMiddleware(['auth:api', 'auth:sanctum']);;

    // withoutMiddleware no se ocupa el token para entrar
    Route::post('/logout', [AuthController::class, 'logout']);

});

Route::prefix('products')->group(function(){

    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{productId}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{productId}', [ProductController::class, 'update']);
    Route::delete('/{productId}', [ProductController::class, 'destroy']);

});

Route::prefix('category')->group(function(){

    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{categoryId}', [CategoryController::class, 'show']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('/{categoryId}', [CategoryController::class, 'update']);
    Route::delete('/{categoryId}', [CategoryController::class, 'destroy']);

});

Route::prefix('rating')->group(function(){

    Route::get('/', [RatingController::class, 'index']);
    Route::post('/{model}/{modelId}', [RatingController::class, 'store']);

});
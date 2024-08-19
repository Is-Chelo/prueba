<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

Route::post('/auth/login', [AuthController::class, 'login']);
// Route::post('/auth/register', [AuthController::class, 'register']);
// password with otp

// * With Auth
Route::group(['middleware' => ['auth:sanctum']], function () {
    // TODO: Categorias
    Route::get('/categorias', [CategoryController::class, 'index']);
    Route::get('/categorias/{id}', [CategoryController::class, 'show']);
    Route::post('/categorias', [CategoryController::class, 'store']);
    Route::put('/categorias/{id}', [CategoryController::class, 'update']);
    Route::delete('/categorias/{id}', [CategoryController::class, 'destroy']);

    // TODO: Productos
    Route::get('/productos', [ProductController::class, 'index']);
    Route::get('/productos/{id}', [ProductController::class, 'show']);
    Route::post('/productos', [ProductController::class, 'store']);
    Route::put('/productos/{id}', [ProductController::class, 'update']);
    Route::delete('/productos/{id}', [ProductController::class, 'destroy']);
});

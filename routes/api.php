<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

use Illuminate\Http\Request;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logOut', [AuthController::class, 'logOut']);

    Route::apiResource('brands', BrandController::class);
    Route::get('brands/{brand}/products', [BrandController::class, 'products']);

    Route::apiResource('categories', CategoryController::class);
    Route::get('categories/{category}/children', [CategoryController::class, 'children']);
    Route::apiResource('products', ProductController::class);

    Route::post('products/addToCart', [OrderController::class, 'addToCart']);
    Route::post('products/transaction', [OrderController::class, 'transaction']);
});

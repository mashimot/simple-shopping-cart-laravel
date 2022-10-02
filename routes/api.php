<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\OrderController;
use App\Http\Controllers\API\v1\OrderItemController;
use App\Http\Controllers\API\v1\CartController;
use App\Http\Controllers\API\v1\UserAddressController;

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


//Auth::loginUsingId(4);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('order_items', OrderItemController::class);
    Route::apiResource('addresses', UserAddressController::class);
    Route::post('carts/pay', [CartController::class, 'pay']);
    Route::apiResource('carts', CartController::class);
});


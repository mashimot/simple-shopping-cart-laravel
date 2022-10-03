<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\OrderController;
use App\Http\Controllers\API\v1\OrderItemController;
use App\Http\Controllers\API\v1\CartController;
use App\Http\Controllers\API\v1\UserAddressController;
use Illuminate\Support\Facades\DB;


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

$usersTable = DB::select(
    "
    SELECT table_schema 
        FROM information_schema.tables
    WHERE table_schema = DATABASE()
            AND table_name = 'users';
    "
);

//Apenas para conectar como algum usuário
if(count($usersTable) > 0){
    Auth::loginUsingId(1);
}

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('order_items', OrderItemController::class);
    Route::apiResource('addresses', UserAddressController::class);
    Route::post('carts/pay', [CartController::class, 'pay']);
    Route::apiResource('carts', CartController::class);
});


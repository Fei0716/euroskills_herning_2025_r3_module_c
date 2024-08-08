<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\MenuCategoryController;
use App\Http\Controllers\api\v1\MenuItemController;
use App\Http\Controllers\api\v1\OrderController;
use App\Http\Controllers\api\v1\OrderItemController;
use App\Http\Controllers\api\v1\TableController;
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
Route::prefix('v1')->group(function(){
    Route::post('login' , [AuthController::class, 'login']);
    Route::post('login/pin' , [AuthController::class, 'pinLogin']);
    Route::post('reset-db' , [AuthController::class, 'resetDB']);

    Route::middleware('check.token')->group(function(){
        Route::post('logout' , [AuthController::class, 'logout']);
        Route::apiResource('menuCategories', MenuCategoryController::class)->only('index', 'store', 'update','destroy');
        Route::apiResource('menuItems', MenuItemController::class)->only('index', 'store', 'update','destroy');

        //for orders
        Route::get('orders' , [OrderController::class, 'index']);
        Route::post('orders' , [OrderController::class, 'store']);
        Route::get('orders/tables/{id}' , [OrderController::class, 'getLastOpenOrderByTable']);
        Route::put('orders/tables/{id}/close' , [OrderController::class, 'closeOrder']);

        //orderitems
        Route::post('orderItems' , [OrderItemController::class, 'store']);

        //stats
        Route::get('stats' , [OrderController::class, 'generateStats']);

        //tables
        Route::get('tables' , [TableController::class, 'index']);
    });
});

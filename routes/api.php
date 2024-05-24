<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\ApiKeyAuthMiddleware;
use \App\Http\Controllers\Api\V1\{
    ProspectsApiController,
    ProductsApiController,
    OrdersApiController
};
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1/')->middleware(ApiKeyAuthMiddleware::class)->name('api.')->group(function () {
    Route::prefix('admin/')->middleware(IsAdmin::class)->name('user.')->group( function () {
        
    });
    Route::prefix('users/')->name('users.')->group(function () {
        Route::prefix('prospects/')->name('prospects.')->group(function () {
            Route::get('index.json', [ProspectsApiController::class, 'index'])->name('index');
            Route::get('{prospect}.json', [ProspectsApiController::class, 'show'])->name('show');
            Route::post('store', [ProspectsApiController::class, 'store'])->name('store');
            Route::put('{prospect}', [ProspectsApiController::class, 'update'])->name('update');
        });
        Route::prefix('products/')->name('products.')->group(function () {
            Route::get('index.json', [ProductsApiController::class, 'index'])->name('index');
            Route::get('{product}.json', [ProductsApiController::class, 'show'])->name('show');
            Route::post('store', [ProductsApiController::class, 'store'])->name('store');
            Route::put('{product}', [ProductsApiController::class, 'update'])->name('update');
        });
        Route::prefix('orders/')->name('orders.')->group(function () {
            Route::get('index.json', [OrdersApiController::class, 'index'])->name('index');
            Route::get('{order}.json', [OrdersApiController::class, 'show'])->name('show');
            Route::post('{prospect}/store', [OrdersApiController::class, 'store'])->name('store');
            Route::put('{order}', [OrdersApiController::class, 'update'])->name('update');
        });
    });
});

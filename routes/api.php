<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//API CRM route prefixes

//GET/POST/PUT for prospects
Route::prefix('api/v1/prospects/')->middleware('auth:api')->name('api.prospects.')->group(base_path('routes/api/prospects.php'));

//GET/POST/PUT for products
Route::prefix('api/v1/products/')->middleware('auth:api')->name('api.products.')->group(base_path('routes/api/products.php'));

//GET/POST/PUT for orders
Route::prefix('api/v1/orders/')->middleware('auth:api')->name('api.orders.')->group(base_path('routes/api/orders.php'));
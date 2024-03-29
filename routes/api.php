<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\ApiKeyAuthMiddleware;
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


//CRM API route prefixes

//GET/POST/PUT for prospects
Route::prefix('v1/prospects/')->middleware(ApiKeyAuthMiddleware::class)->name('api.prospects.')->group(base_path('routes/api/prospects.php'));

//GET/POST/PUT for products
Route::prefix('v1/products/')->middleware(ApiKeyAuthMiddleware::class)->name('api.products.')->group(base_path('routes/api/products.php'));

//GET/POST/PUT for orders
Route::prefix('v1/orders/')->middleware(ApiKeyAuthMiddleware::class)->name('api.orders.')->group(base_path('routes/api/orders.php'));
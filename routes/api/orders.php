<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\OrdersApiController;

//GET info about all orders
Route::get('index.json', [OrdersApiController::class, 'index'])->name('index');
//GET info of one order
Route::get('{orderId}', [OrdersApiController::class, 'show'])->name('show');
//POST an order
Route::post('{prospectId}/store', [OrdersApiController::class, 'store'])->name('store');

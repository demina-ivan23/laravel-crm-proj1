<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//GET info about all orders
Route::get('index.json', [OrdersApiController::class, 'index'])->name('index');
//GET info of one order
Route::get('show/{orderId}.json', [OrdersApiController::class, 'show'])->name('show');
//POST an order
Route::post('store', [OrdersApiController::class, 'store'])->name('store');

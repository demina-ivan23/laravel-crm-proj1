<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductsApiController;

//GET info about all products
Route::get('index.json', [ProductsApiController::class, 'index'])->name('index');
//GET info of one product
Route::get('{productId}', [ProductsApiController::class, 'show'])->name('show');
//POST a product
Route::post('store', [ProductsApiController::class, 'store'])->name('store');
//PUT a product
Route::put('{productId}', [ProductsApiController::class, 'update'])->name('update');
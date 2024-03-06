<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Products\ProductsController;



Route::get('/products', [ProductsController::class, 'index'])->name('dashboard');
Route::get('/create', [ProductsController::class, 'create'])->name('create');
Route::get('{product}/edit', [ProductsController::class, 'edit'] )->name('edit')->where('product', '[0-9]+');
Route::get('{product}', [ProductsController::class, 'show'] )->name('show')->where('product', '[0-9]+');

Route::post('/store', [ProductsController::class, 'store'])->name('store');

Route::put('/{product}', [ProductsController::class, 'update'])->name('update');

Route::delete('/{product}', [ProductsController::class, 'destroy'])->name('destroy');















?>
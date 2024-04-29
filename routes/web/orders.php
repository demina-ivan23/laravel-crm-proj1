<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Orders\OrdersController;

Route::get('/orders', [OrdersController::class, 'index'])->name('dashboard');
Route::get('/orders/{order}', [OrdersController::class, 'show'])->name('show');

Route::get('/{prospect}/create/select_products', [OrdersController::class, 'create'])->name('create.select_products');

Route::get('/{prospect}/create', [OrdersController::class, 'create'])->name('create');

Route::get('/{order}/edit', [OrdersController::class, 'edit'])->name('edit');

Route::post('/{prospect}/store', [OrdersController::class, 'store'])->name('store');


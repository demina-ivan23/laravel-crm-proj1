<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Orders\OrdersController;

Route::get('/orders', [OrdersController::class, 'index'])->name('dashboard');

Route::get('/{prospect}/create', [OrdersController::class, 'create'])->name('create');

Route::post('/{prospect}/store', [OrdersController::class, 'store'])->name('store');
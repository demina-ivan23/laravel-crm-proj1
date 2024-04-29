<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Orders\OrdersController;
use App\Http\Controllers\Admin\Prospects\ProspectsController;
use App\Http\Controllers\Admin\Prospects\ProspectsContactController;

// Prefix: prospects
// name(s): admin.prospect.{route's_name}

Route::get('/prospects', [ProspectsController::class, 'index'])->name('dashboard');
Route::get('create', [ProspectsController::class, 'create'])->name('create');
Route::get('{prospect}/edit', [ProspectsController::class, 'edit'])->name('edit')->where('prospect', '[0-9]+');
Route::get('{prospect}', [ProspectsController::class, 'show'])->name('show')->where('prospect', '[0-9]+');
Route::get('{prospect}/orders', [ProspectsController::class, 'show'])->name('show-orders')->where('prospect', '[0-9]+');


Route::post('/store', [ProspectsController::class, 'store'])->name('store');

Route::put('/{prospect}/update', [ProspectsController::class, 'update'])->name('update')->where('prospect', '[0-9]+');

Route::delete('/{prospect}/delete', [ProspectsController::class, 'destroy'])->name('destroy')->where('prospect', '[0-9]+');






































?>
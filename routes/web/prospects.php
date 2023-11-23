<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Prospects\ProspectsController;

// Prefix: prospects
// name(s): admin.prospect.{route's_name}

Route::get('prospects', [ProspectsController::class, 'index'])->name('dashboard');
Route::get('create', [ProspectsController::class, 'create'])->name('create');
Route::get('{prospect}/edit', [ProspectsController::class, 'edit'])->name('edit');
Route::get('{prospect}', [ProspectsController::class, 'show'])->name('show')->where('prospect', '[0-9]+');

Route::post('/store', [ProspectsController::class, 'store'])->name('store');

Route::put('{prospect}/update', [ProspectsController::class, 'update'])->name('update')->where('prospect', '[0-9]+');




































?>
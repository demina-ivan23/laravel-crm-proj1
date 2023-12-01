<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Prospects\ProspectsController;
use App\Http\Controllers\Admin\Prospects\ProspectsContactController;

// Prefix: prospects
// name(s): admin.prospect.{route's_name}

Route::get('/prospects', [ProspectsController::class, 'index'])->name('dashboard');
Route::get('create', [ProspectsController::class, 'create'])->name('create');
Route::get('{prospect}/edit', [ProspectsController::class, 'edit'])->name('edit')->where('prospect', '[0-9]+');
Route::get('{prospect}', [ProspectsController::class, 'show'])->name('show')->where('prospect', '[0-9]+');

Route::post('/store', [ProspectsController::class, 'store'])->name('store');

Route::put('/{prospect}', [ProspectsController::class, 'update'])->name('update')->where('prospect', '[0-9]+');

Route::delete('/{prospect}', [ProspectsController::class, 'destroy'])->name('destroy')->where('prospect', '[0-9]+');


// Contacts addition and managment routes

Route::get('/{prospect}/contacts/create', [ProspectsContactController::class, 'create'])->name('contacts.create')->where('prospect', '[0-9]+');
Route::get('/{prospect}/contacts/edit', [ProspectsContactController::class, 'edit'])->name('contacts.edit')->where('prospect', '[0-9]+');


Route::post('/{prospect}/contacts/store', [ProspectsContactController::class, 'store'])->name('contacts.store');

 




































?>
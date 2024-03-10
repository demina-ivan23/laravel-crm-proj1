<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('index.json', [ProspectsApiController::class, 'index'])->name('index');
Route::get('show/{prospectId}.json', [ProspectsApiController::class, 'index'])->name('show');
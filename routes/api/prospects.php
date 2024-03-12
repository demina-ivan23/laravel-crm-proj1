<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProspectsApiController;

//GET info about all prospects
Route::get('index.json', [ProspectsApiController::class, 'index'])->name('index');
//GET info of one prospect
Route::get('show/{prospectId}.json', [ProspectsApiController::class, 'show'])->name('show');
//POST a prospect
Route::post('store', [ProspectsApiController::class, 'store'])->name('store');
//PUT a prospect
Route::put('update/{prospectId}', [ProspectsApiController::class, 'update'])->name('update');
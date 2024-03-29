<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProspectsApiController;

//GET info about all prospects
Route::get('index.json', [ProspectsApiController::class, 'index'])->name('index');
//GET info of one prospect
Route::get('{prospectId}', [ProspectsApiController::class, 'show'])->name('show');
//POST a prospect
Route::post('store', [ProspectsApiController::class, 'store'])->name('store');
//PUT a prospect
Route::put('{prospectId}', [ProspectsApiController::class, 'update'])->name('update');
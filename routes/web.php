<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('prospects')->middleware('auth')->name('admin.prospects.')->group(base_path('routes/web/prospects.php'));

Route::prefix('products')->middleware('auth')->name('admin.products.')->group(base_path('routes/web/products.php'));
// Route::prefix('leads')->middleware('auth')->group(base_path('routes/web/leads.php'));
// Route::prefix('customers')->middleware('auth')->group(base_path('routes/web/customers.php'));
<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\SuperadminController;

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

//Superadmin routes (superadmins manage CRM users and their data)
Route::prefix('superadmin')->middleware('auth')->group(function () {
    Route::middleware('superadmin')->group(function () {
        Route::resource('users', UserController::class)->except('show');
        Route::get('/superadmin/order_product_chart', [SuperadminController::class, 'index'])->name('superadmin.order_product_chart');     
        Route::resource('superadmin', SuperadminController::class)->except(['create', 'store', 'destroy']);
    });
    Route::get('users/show/{id}', [UserController::class, 'show'])->name('users.show');
});


//Admin routes (anyone who can access the CRM is considered an admin) 
Route::prefix('prospects')->middleware('auth')->name('admin.prospects.')->group(base_path('routes/web/prospects.php'));

Route::prefix('products')->middleware('auth')->name('admin.products.')->group(base_path('routes/web/products.php'));

Route::prefix('orders')->middleware('auth')->name('admin.orders.')->group(base_path('routes/web/orders.php'));




//Graph route is for a page that determines prospects creation, 
// product creation and order creation speed via testing
Route::get('/graphs', [GraphController::class, 'index'])->name('graphs.index');
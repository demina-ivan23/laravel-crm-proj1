<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\SuperadminController;
use App\Http\Controllers\Superadmin\OrderStatusController;

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

//Superadmin routes
Route::prefix('superadmin')->middleware(['auth', 'superadmin'])->group(function () {
    // User routes that are listed under the 'superadmin' middleware are the routes created for 
    // superadmins to manage CRM's users' data
    Route::resource('users', UserController::class)->except('show');
    
    // Superadmin routes are the routes which allow superadmins to manage their data
    Route::resource('superadmin', SuperadminController::class)->except(['create', 'store', 'destroy']);
    
    // All superadmin charts are drawn by the index method, thus the code is cleaner  
    Route::get('/order_product_chart', [SuperadminController::class, 'index'])->name('superadmin.order_product_chart');  
    Route::get('/order_prospect_chart', [SuperadminController::class, 'index'])->name('superadmin.order_prospect_chart');
    Route::get('/order_chart', [SuperadminController::class, 'index'])->name('superadmin.order_chart');

    // Order status is the almost the same thing as prospect state or product category, it's difference 
    //from the upper mentioned two is that process of it's creation and modification requires admin access
    Route::name('superadmin.')->group(function () {
        Route::resource('order_statuses', OrderStatusController::class)->except(['show', 'destroy']);
    });
});

Route::get('users/show/{id}', [UserController::class, 'show'])->middleware('auth')->name('users.show');


//Admin routes (anyone who can access the CRM is considered an admin) 
Route::prefix('prospects')->middleware('auth')->name('admin.prospects.')->group(base_path('routes/web/prospects.php'));

Route::prefix('products')->middleware('auth')->name('admin.products.')->group(base_path('routes/web/products.php'));

Route::prefix('orders')->middleware('auth')->name('admin.orders.')->group(base_path('routes/web/orders.php'));




//Graph route is for a page that determines prospects creation, 
// product creation and order creation speed via testing
Route::get('/graphs', [GraphController::class, 'index'])->name('graphs.index');
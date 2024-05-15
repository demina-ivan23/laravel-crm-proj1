<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    User\UserController,
    User\Orders\OrdersController,
    User\Prospects\ProspectsController,
    User\Products\ProductsController,
    User\AdminController,
    User\OrderStatusController
};
use App\Http\Controllers\User\MessageController;

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


Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::redirect('/', '/home');

//Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // User routes that are listed under the 'Admin' middleware are the routes created for 
    // Admins to manage CRM's users' data
    Route::resource('users', UserController::class)->except('show');
    
    Route::resource('admin', AdminController::class)->except(['create', 'store', 'destroy']);
    // Admin routes are the routes which allow Admins to manage their data

    // All Admin charts are drawn by the index method, thus the code is cleaner  
    Route::get('/order_product_chart', [AdminController::class, 'index'])->name('admin.order_product_chart');
    Route::get('/order_prospect_chart', [AdminController::class, 'index'])->name('admin.order_prospect_chart');
    Route::get('/order_chart', [AdminController::class, 'index'])->name('admin.order_chart');

    // Order status is the almost the same thing as prospect state or product category, it's difference 
    //from the upper mentioned two is that process of it's creation and modification requires admin access
    Route::name('admin.')->group(function () {
        Route::resource('order_statuses', OrderStatusController::class)->except(['show', 'destroy']);
    });
});

Route::get('users/show/{id}', [UserController::class, 'show'])->middleware('auth')->name('users.show');


//General CRM routes (accessed by any user who has proper permissions) 
Route::prefix('users/')->middleware('auth')->name('user.')->group(function () {
    Route::resource('prospects', ProspectsController::class)->names(['index' => 'prospects.dashboard']);
    Route::get('{prospect}/orders', [ProspectsController::class, 'show'])->name('prospects.show-orders')->where('prospect', '[0-9]+');

    Route::resource('products', ProductsController::class)->names(['index' => 'products.dashboard']);

    Route::resource('orders', OrdersController::class)->names(['index' => 'orders.dashboard'])->except(['create', 'store']);
    Route::prefix('orders/')->name('orders.')->group(function () {
        Route::get('{prospect}/create/select_products', [OrdersController::class, 'create'])->name('create.select_products');
        Route::get('{prospect}/create', [OrdersController::class, 'create'])->name('create');
        Route::post('{prospect}', [OrdersController::class, 'store'])->name('store');
    });
    Route::prefix('messages/')->name('messages.')->group(function () {
        Route::get('{id}/{messagable}/view_all', [MessageController::class, 'index'])->name('index');
        Route::get('show/{message}', [MessageController::class, 'show'])->name('show');
    });
});


//Graph route is for a page that measures prospects creation, 
// product creation and order creation speed via testing
// Route::get('/graphs', [GraphController::class, 'index'])->name('graphs.index');

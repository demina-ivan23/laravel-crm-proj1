<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\{
    UserController,
    Orders\OrdersController,
    Orders\OrderStatusController,
    Prospects\ProspectsController,
    Prospects\ProspectStateController,
    Products\ProductsController,
    Messages\MessageController,
    Charts\ChartsController,
    Roles\RoleController
};

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




//User management routes
Route::resource('users', UserController::class)->middleware('auth');

//User-managed routes
Route::prefix('user/')->middleware('auth')->name('user.')->group(function () {
    //Roles
    Route::resource('roles', RoleController::class)->except(['destroy'])->names(['index' => 'roles.dashboard']);
    Route::delete('roles/{role}', [RoleController::class, 'delete'])->name('roles.delete')->where('role', '[0-9]+');
    Route::put('roles/{role}/restore', [RoleController::class, 'restore'])->name('roles.restore')->where('role', '[0-9]+');

    //Charts
    Route::get('order_product_chart', [ChartsController::class, 'index'])->name('order_product_chart');
    Route::get('order_prospect_chart', [ChartsController::class, 'index'])->name('order_prospect_chart');
    Route::get('order_chart', [ChartsController::class, 'index'])->name('order_chart');

    //Prospect states
    Route::put('prospect_states/update_via_table', [ProspectStateController::class, 'updateAll'])->name('prospect_states.update_via_table');
    Route::resource('prospect_states', ProspectStateController::class)->except(['show', 'destroy']);
    Route::get('prospect_states/edit_via_table', [ProspectStateController::class, 'edit'])->name('prospect_states.edit_via_table');

    //Order statuses
    Route::put('order_statuses/update_via_table', [OrderStatusController::class, 'updateAll'])->name('order_statuses.update_via_table');
    Route::resource('order_statuses', OrderStatusController::class)->except(['show', 'destroy']);
    Route::get('order_statuses/edit_via_table', [OrderStatusController::class, 'edit'])->name('order_statuses.edit_via_table');

    //Prospects
    Route::resource('prospects', ProspectsController::class)->names(['index' => 'prospects.dashboard']);
    Route::get('{prospect}/orders', [ProspectsController::class, 'show'])->name('prospects.show-orders')->where('prospect', '[0-9]+');

    //Products
    Route::resource('products', ProductsController::class)->names(['index' => 'products.dashboard']);

    //Orders
    Route::resource('orders', OrdersController::class)->names(['index' => 'orders.dashboard'])->except(['create', 'store']);
    Route::prefix('orders/')->name('orders.')->group(function () {
        Route::get('{prospect}/create/select_products', [OrdersController::class, 'create'])->name('create.select_products');
        Route::get('{prospect}/create', [OrdersController::class, 'create'])->name('create');
        Route::post('{prospect}', [OrdersController::class, 'store'])->name('store');
    });

    //Messages
    Route::prefix('messages/')->name('messages.')->group(function () {
        Route::get('{id}/{messagable}/view_all', [MessageController::class, 'index'])->name('index');
        Route::get('show/{message}', [MessageController::class, 'show'])->name('show');
    });
});


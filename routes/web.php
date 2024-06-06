<?php

use App\Http\Controllers\Dashboards\ProspectsProductsOrdersController;
use App\Http\Controllers\Dashboards\StatesController;
use App\Http\Controllers\Dashboards\ChartsController;
use App\Http\Controllers\Dashboards\UsersRolesController;
use App\Http\Controllers\TimezoneController;
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

//Timezone 
Route::post('/set-timezone', TimezoneController::class)->name('set-timezone');


//Dashboards
Route::prefix('dashboards/')->name('dashboards.')->group(function () {
    Route::get('states', StatesController::class)->middleware('permissions:states-dashboard')->name('states');
    Route::get('users-roles', UsersRolesController::class)->middleware('permissions:users-roles-dashboard')->name('users-roles');
    Route::get('prospects-products-orders', ProspectsProductsOrdersController::class)->middleware('permissions:prospects-products-orders-dashboard')->name('prospects-products-orders');
    Route::get('order-charts', [ChartsController::class, 'index'])->middleware('permissions:order-chart-read-web')->name('order-charts');
});

//User management routes
Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class)->only(['create', 'store'])->middleware('permissions:user-write-web');
    Route::get('users/{user}', [UserController::class, 'show'])->middleware('permissions:user-read-all-web')->name('users.show');
    Route::resource('users', UserController::class)->only(['edit', 'update'])->middleware('permissions:user-edit-all-web');

    Route::delete('users/{user}', [UserController::class, 'delete'])->middleware('permissions:user-edit-all-web')->name('users.delete')->where('user', '[0-9]+');
    Route::put('user/{user}/restore', [UserController::class, 'restore'])->middleware('permissions:user-edit-all-web')->name('users.restore')->where('user', '[0-9]+');

    Route::get('users/show-self', [UserController::class, 'showSelf'])->middleware('permissions:user-read-self-web')->name('users.show-self');

    Route::get('users/edit-self', [UserController::class, 'editSelf'])->middleware('permissions:user-edit-self-web')->name('users.edit-self');
    Route::put('users/update-self', [UserController::class, 'updateSelf'])->middleware('permissions:user-edit-self-web')->name('users.update-self');
});
//User-managed routes
Route::prefix('user/')->middleware('auth')->name('user.')->group(function () {
    //Roles
    Route::resource('roles', RoleController::class)->only(['create', 'store'])->middleware('permissions:role-write-web');
    Route::get('roles/{role}', [RoleController::class, 'show'])->middleware('permissions:role-read-web')->name('roles.show');
    Route::resource('roles', RoleController::class)->only(['edit', 'update'])->middleware('permissions:role-edit-web');

    Route::delete('roles/{role}', [RoleController::class, 'delete'])->middleware('permissions:role-edit-web')->name('roles.delete')->where('role', '[0-9]+');
    Route::put('roles/{role}/restore', [RoleController::class, 'restore'])->middleware('permissions:role-edit-web')->name('roles.restore')->where('role', '[0-9]+');

    //Prospect states
    Route::middleware('permissions:prospect_state-edit-web')->group(function () {
        Route::get('prospect_states/edit_via_table', [ProspectStateController::class, 'edit'])->name('prospect_states.edit_via_table');
        Route::put('prospect_states/update_via_table', [ProspectStateController::class, 'updateAll'])->name('prospect_states.update_via_table');
        Route::resource('prospect_states', ProspectStateController::class)->only(['edit', 'update']);
    });

    Route::resource('prospect_states', ProspectStateController::class)->only(['create', 'store'])->middleware('permissions:prospect_state-write-web');

    //Order statuses
    Route::middleware('permissions:order_status-edit-web')->group(function () {
        Route::get('order_statuses/edit_via_table', [OrderStatusController::class, 'edit'])->name('order_statuses.edit_via_table');
        Route::put('order_statuses/update_via_table', [OrderStatusController::class, 'updateAll'])->name('order_statuses.update_via_table');
        Route::resource('order_statuses', OrderStatusController::class)->only(['edit', 'update']);
    });

    Route::resource('order_statuses', OrderStatusController::class)->only(['create', 'store'])->middleware('permissions:order_status-write-web');

    //Prospects
    Route::resource('prospects', ProspectsController::class)->only(['create', 'store'])->middleware('permissions:prospect-write-web');
    Route::get('prospects/{prospect}', [ProspectsController::class, 'show'])->middleware('permissions:prospect-read-web')->name('prospects.show');
    Route::resource('prospects', ProspectsController::class)->only(['edit', 'update'])->middleware('permissions:prospect-edit-web');

    Route::delete('prospects/{prospect}', [ProspectsController::class, 'delete'])->middleware('permissions:prospect-update-web')->name('prospects.delete');
    Route::put('prospects/{prospect}/restore', [ProspectsController::class, 'restore'])->middleware('permissions:prospect-update-web')->name('prospects.restore');

    Route::delete('prospects/{prospect}/force_delete', [ProspectsController::class, 'destroy'])->middleware('permissions:prospect-delete-web')->name('prospects.destroy');

    Route::get('prospects/{prospect}/orders', [ProspectsController::class, 'show'])->middleware('permissions:order-read-web')->name('prospects.show-orders')->where('prospect', '[0-9]+');

    //Products
    Route::resource('products', ProductsController::class)->only(['create', 'store'])->middleware('permissions:product-write-web');
    Route::get('products/{product}', [ProductsController::class, 'show'])->middleware('permissions:product-read-web')->name('products.show');
    Route::resource('products', ProductsController::class)->only(['edit', 'update'])->middleware('permissions:product-edit-web');

    Route::delete('products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');

    //Orders
    Route::prefix('orders/')->middleware('permissions:order-write-web')->name('orders.')->group(function () {
        Route::get('{prospect}/create/select_products', [OrdersController::class, 'create'])->name('create.select_products');
        Route::get('{prospect}/create', [OrdersController::class, 'create'])->name('create');
        Route::post('{prospect}', [OrdersController::class, 'store'])->name('store');
    });
    
    Route::get('orders/{order}', [ProspectsController::class, 'show'])->middleware('permissions:order-read-web')->name('orders.show');
    Route::resource('orders', OrdersController::class)->only(['edit', 'update'])->middleware('permissions:order-edit-web');
   
    //Messages
    Route::prefix('messages/')->name('messages.')->group(function () {
        Route::get('{id}/{messagable}/view_all', [MessageController::class, 'index'])->name('index');
        Route::get('show/{message}', [MessageController::class, 'show'])->name('show');
    });
});

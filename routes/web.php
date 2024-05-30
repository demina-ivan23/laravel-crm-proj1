<?php

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
    Charts\ChartsController,
    Roles\RoleController
};
use App\Services\UserService;

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



//User management routes
Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class)->only(['create', 'store'])->middleware('permissions:user-write-web');
    Route::resource('users', UserController::class)->only(['index', 'show'])->middleware('permissions:user-read-all-web')->names(['index' => 'users.dashboard']);
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
    Route::resource('roles', RoleController::class)->only(['index', 'show'])->middleware('permissions:role-read-web')->names(['index' => 'roles.dashboard']);
    Route::resource('roles', RoleController::class)->only(['edit', 'update'])->middleware('permissions:role-edit-web');

    Route::delete('roles/{role}', [RoleController::class, 'delete'])->middleware('permissions:role-edit-web')->name('roles.delete')->where('role', '[0-9]+');
    Route::put('roles/{role}/restore', [RoleController::class, 'restore'])->middleware('permissions:role-edit-web')->name('roles.restore')->where('role', '[0-9]+');

    //Charts
    Route::get('order_product_chart', [ChartsController::class, 'index'])->middleware('permissions:order-chart-read-web')->name('order_product_chart');
    Route::get('order_prospect_chart', [ChartsController::class, 'index'])->middleware('permissions:order-chart-read-web')->name('order_prospect_chart');
    Route::get('order_chart', [ChartsController::class, 'index'])->middleware('permissions:order-chart-read-web')->name('order_chart');

    //Prospect states
    Route::middleware('permissions:prospect_state-edit-web')->group(function () {
        Route::get('prospect_states/edit_via_table', [ProspectStateController::class, 'edit'])->name('prospect_states.edit_via_table');
        Route::put('prospect_states/update_via_table', [ProspectStateController::class, 'updateAll'])->name('prospect_states.update_via_table');
        Route::resource('prospect_states', ProspectStateController::class)->only(['edit', 'update']);
    });

    Route::resource('prospect_states', ProspectStateController::class)->only(['create', 'store'])->middleware('permissions:prospect_state-write-web');
    Route::get('index', [ProspectStateController::class, 'index'])->middleware('permissions:prospect_state-read-web')->name('prospect_states.index');

    //Order statuses
    Route::middleware('permissions:order_status-edit-web')->group(function () {
        Route::get('order_statuses/edit_via_table', [OrderStatusController::class, 'edit'])->name('order_statuses.edit_via_table');
        Route::put('order_statuses/update_via_table', [OrderStatusController::class, 'updateAll'])->name('order_statuses.update_via_table');
        Route::resource('order_statuses', OrderStatusController::class)->only(['edit', 'update']);
    });

    Route::resource('order_statuses', OrderStatusController::class)->only(['create', 'store'])->middleware('permissions:order_status-write-web');
    Route::get('index', [OrderStatusController::class, 'index'])->middleware('permissions:order_status-read-web')->name('order_statuses.index');

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

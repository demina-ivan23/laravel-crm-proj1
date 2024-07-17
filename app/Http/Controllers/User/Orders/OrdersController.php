<?php

namespace App\Http\Controllers\User\Orders;

use App\Models\Order;
use App\Models\Prospect;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\ProspectService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\StoreOrderRequest;
use App\Http\Requests\Orders\UpdateOrderRequest;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = OrderService::getAllOrders();
        return view('user.orders.index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Prospect $prospect)
    {
        $products = ProductService::getAllProducts();
        if (request()->routeIs('user.orders.create.select_products')) {
            return view('user.orders.select_products', ['products' => $products, 'prospect' => $prospect]);
        }
        if (request()->routeIs('user.orders.create')) {
            return view('user.orders.create', ['prospect' => $prospect]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Prospect $prospect, StoreOrderRequest $request)
    {
        $order = OrderService::storeOrder($prospect, $request->all());
        if (!$order) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('user.prospects.dashboard')->with('success', 'Order Successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('user.orders.show', ['order' => $order]);
    }

    public function edit(Order $order)
    {
        return view('user.orders.edit', ['order' => $order]);
    }

    public function update(Order $order, UpdateOrderRequest $request)
    {
        $data = $request->all();
        $result = OrderService::updateOrder($data, $order);
        if (str_contains($result, 'successful')) {
            return redirect()->route('user.orders.dashboard')->with('success', $result);
        } else {
            return redirect()->back()->with('error', $result);
        }
    }

    public function delete(Order $order)
    {
        $order->delete();
        return redirect()->back()->with('success', 'Order Trashed Successfully');
    }
    
    public function restore(string $id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        $order->restore();
        return redirect()->back()->with('success', 'Order Restored Successfully');
    }
    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Order $order)
    {
        $order->forceDelete();
        return redirect()->back()->with('success', 'Order Deleted Permanently');
    }
}

<?php

namespace App\Http\Controllers\Admin\Orders;

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
        return view('admin.orders.index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $products = ProductService::getAllProducts();
        $prospect = ProspectService::findProspect($id);
        if (request()->routeIs('admin.orders.create.select_products')) {
            return view('admin.orders.select_products', ['products' => $products, 'prospect' => $prospect]);
        }
        if (request()->routeIs('admin.orders.create')) {
            return view('admin.orders.create', ['prospect' => $prospect]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id, StoreOrderRequest $request)
    {
        $prospect = ProspectService::findProspect($id);
        $order = OrderService::storeOrder($prospect, $request->all());
        if (!$order) {
            return redirect('/prospects/prospects')->with('error', 'Something went wrong');
        }
        return redirect('/prospects/prospects')->with('success', 'Order Successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.show', ['order' => $order]);
    }

    public function edit(string $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.edit', ['order' => $order]);
    }

    public function update(string $id, UpdateOrderRequest $request)
    {
        $data = $request->all();
        $data['order_id'] = $id;
        $result = OrderService::updateOrder($data);
        if (str_contains($result, 'successful')) {
            return redirect()->route('admin.orders.dashboard')->with('success', $result);
        } else {
            return redirect()->back()->with('error', $result);
        }
    }


    /**
     * Remove the specified resource from storage.
     */

    // public function destroy(string $id)
    // {
    //     $order = Order::find($id);
    //     if($order){
    //         $order->delete();
    //     }
    //     return redirect()->back()->with('success', 'Order trashed successfully');
    // }
}

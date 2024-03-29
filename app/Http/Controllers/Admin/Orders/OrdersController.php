<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\ProspectService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\StoreOrderRequest;
use App\Models\Prospect;

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
        return view('admin.orders.create', ['products' => $products, 'prospect' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id, StoreOrderRequest $request)
    {
        $prospect = ProspectService::findProspect($id);
        $order = OrderService::storeOrder($prospect, $request->all());
        return redirect('/prospects/prospects');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prospect = ProspectService::findProspect($id);
        $orders = Order::where('customer_id', $id)->latest()->paginate(5);
        return view('admin.orders.show', ['orders' => $orders, 'prospect' => $prospect]);
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

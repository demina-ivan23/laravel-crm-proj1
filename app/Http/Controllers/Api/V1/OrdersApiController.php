<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\ProspectService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Orders\OrdersController;

class OrdersApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = OrderService::getAllOrders();
        return response()->json(['orders' => $orders]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id, Request $request)
    {
        $prospect = ProspectService::findProspect($id);
        $order = OrderService::storeOrder($prospect, $request->all());
        if($order){
            return response()->json(['result' => 'Order created successfully', 'order' => $order]);
        } else {
            return response()->json(['result' => 'Something went wrong']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = OrderService::findOrder($id);
        return response()->json(['order' => $order]);
    }

}

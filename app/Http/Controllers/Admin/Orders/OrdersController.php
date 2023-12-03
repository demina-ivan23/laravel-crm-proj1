<?php

namespace App\Http\Controllers\Admin\Orders;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\ProspectService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\StoreOrderRequest;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.orders.index');
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
        $prospect = ProspectService::getProspectById($id);
        OrderService::storeOrder($prospect, $request);
        ProspectService::setStateToCustomer($id);
        return redirect('/prospects/prospects');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

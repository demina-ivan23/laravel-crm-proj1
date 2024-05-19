<?php

namespace App\Http\Controllers\User;

use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\OrderStatusService;
use App\Http\Requests\Admin\OrderStatus\UpdateOrderStatusRequest;


class OrderStatusController extends Controller
{
    public function index()
    {
        return view('admin.order_statuses.index', ['order_statuses' => OrderStatusService::getAllOrderStatuses()]);
    }
    public function create()
    {
        return view('admin.order_statuses.create');
    }
    public function store(Request $request)
    {
        $result = OrderStatusService::storeOrderStatus($request->all());
        if (str_contains($result, 'successfully')) {
            return redirect()->route('admin.order_statuses.index')->with('success', $result);
        } else {
            return redirect()->route('admin.order_statuses.create')->with('error', $result);
        }
    }
    public function edit(OrderStatus $orderStatus)
    {
        $routeName = request()->route()->getName();
        if($routeName == 'admin.order_statuses.edit'){
            return view('admin.order_statuses.edit', compact('orderStatus'));
        } elseif($routeName == 'admin.order_statuses.edit_via_table'){
            return view('admin.order_statuses.edit_via_table', ['orderStatuses' => OrderStatus::all()]);
        } else {
            dd($routeName);
        }
    }
    public function update(OrderStatus $orderStatus, UpdateOrderStatusRequest $request)
    {
        $routeName = $request->route()->getName();
        if($routeName === 'admin.order_statuses.update'){
            $result = OrderStatusService::updateOrderStatus($orderStatus, $request->all());
        } elseif($routeName === 'admin.order_statuses.update_via_table') {
            $result = OrderStatusService::updateOrderStatusesViaTable($request->all());
        }
        if (str_contains($result, 'successfully')) {
            return redirect()->route('admin.order_statuses.index')->with('success', $result);
        } else {
            return redirect()->route('admin.order_statuses.edit', ['order_status' => $orderStatus])->with('error', $result);
        }
    }
}

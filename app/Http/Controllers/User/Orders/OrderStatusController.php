<?php

namespace App\Http\Controllers\User\Orders;

use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\OrderStatusService;
use App\Http\Requests\Admin\OrderStatus\UpdateOrderStatusRequest;
use App\Http\Requests\Admin\OrderStatus\UpdateAllOrderStatusesRequest;


class OrderStatusController extends Controller
{
    public function index()
    {
        return view('user.order_statuses.index', ['order_statuses' => OrderStatusService::getAllOrderStatuses()]);
    }
    public function create()
    {
        return view('user.order_statuses.create');
    }
    public function store(Request $request)
    {
        $result = OrderStatusService::storeOrderStatus($request->all());
        if (str_contains($result, 'successfully')) {
            return redirect()->route('user.order_statuses.index')->with('success', $result);
        } else {
            return redirect()->route('user.order_statuses.create')->with('error', $result);
        }
    }
    public function edit(OrderStatus $orderStatus)
    {
        $routeName = request()->route()->getName();
        if ($routeName == 'user.order_statuses.edit') {
            return view('user.order_statuses.edit', compact('orderStatus'));
        } elseif ($routeName == 'user.order_statuses.edit_via_table') {
            return view('user.order_statuses.edit_via_table', ['orderStatuses' => OrderStatus::all()]);
        } else {
            dd($routeName);
        }
    }
    public function update(OrderStatus $orderStatus, UpdateOrderStatusRequest $request)
    {
        $result = OrderStatusService::updateOrderStatus($orderStatus, $request->all());
        if (str_contains($result, 'successfully')) {
            return redirect()->route('user.order_statuses.index')->with('success', $result);
        } else {
            return redirect()->route('user.order_statuses.edit', ['order_status' => $orderStatus])->with('error', $result);
        }
    }

    public function updateAll(UpdateAllOrderStatusesRequest $request) //till now I tried my best not to create custom methods
    {
        $result = OrderStatusService::updateOrderStatusesViaTable($request->all());
        if (str_contains($result, 'successfully')) {
            return redirect()->route('user.order_statuses.index')->with('success', $result);
        } else {
            return redirect()->route('user.order_statuses.edit_via_table')->with('error', $result);
        }
    }
}

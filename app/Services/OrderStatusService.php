<?php

namespace App\Services;

use Exception;
use App\Models\OrderStatus;

class OrderStatusService
{
    static function getAllOrderStatuses()
    {
        return OrderStatus::all();
    }
    static function storeOrderStatus(array $data)
    {
        $orderStatus = OrderStatus::create($data);
        if (!$orderStatus) {
            return 'Order status creation failed, something must have gone wrong';
        }
        if ($data['can_transit_into'] ?? null) {
            foreach ($data['can_transit_into'] as $id) {
                $orderStatus->statuses()->attach($id);
            }
        }
        return 'Order status created successfully';
    }
    static function updateOrderStatus(OrderStatus $orderStatus, array $data)
    {
        try {
            if($orderStatus == null){
                abort(404);
            }
            $orderStatus->update($data);
            foreach (OrderStatus::all() as $other_order_status) {
                $orderStatus->statuses->contains($other_order_status->id) ? $orderStatus->statuses()->detach($other_order_status->id) : '';
            }
            if ($data['can_transit_into'] ?? null) {
                foreach ($data['can_transit_into'] as $id) {
                    $orderStatus->statuses()->attach($id);
                }
            }
            return 'Order status updated successfully';
        } catch (Exception $e) {
            return 'Something went wrong, Exception message: ' . $e->getMessage();
        }
    }
    static function updateOrderStatusesViaTable(array $data)
    {
        try {
            foreach ($data as $key => $value) {
                $keyStringArray = explode('-', $key);
                if (array_key_exists(1, $keyStringArray)  && $keyStringArray[1] == 'can_transit_into') {
                    $orderStatus = OrderStatus::findOrFail($keyStringArray[0]);
                    foreach($orderStatus->statuses as $oldOrderStatus){
                        $orderStatus->statuses()->detach($oldOrderStatus->id);
                    }
                    foreach ($value as $item) {
                        $newOrderStatus = OrderStatus::findOrFail($item);
                        if($newOrderStatus->id !== $orderStatus->id){
                            $orderStatus->statuses()->attach($newOrderStatus->id);
                        }
                    }
                }
            }
            return "Order statuses updated successfully";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    static function getAllFSS()
    {
        return OrderStatus::all()->where('first_step_status', 1);
    }
}

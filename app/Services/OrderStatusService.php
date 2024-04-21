<?php

namespace App\Services;

use Exception;
use App\Models\OrderStatus;

class OrderStatusService 
{
    static function getAllOrderStatuses(){
        return OrderStatus::all();
    } 
    static function storeOrderStatus($data)
    {
        $order_status = OrderStatus::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'first_step_status' => $data['first_step_status'],
            'can_transit_into' => $data['can_transit_into'] ?? ''
        ]);

        if(!$order_status){
            return 'Order status creation failed, something must have gone wrong';
        }
        return 'Order status created successfully';
    }
    static function findOrderStatus($id)
    {
        $order_status = OrderStatus::find($id);
        if(!$order_status){
            abort(404);
        }
        return $order_status;
    } 
    static function updateOrderStatus($id, $request)
    {
        try{
            $order_status = static::findOrderStatus($id);
            $order_status->update($request->only(['title', 'description', 'first_step_status']));
            if($request['can_transit_into'] ?? null)
            {
                $order_status->update($request['can_transit_into']);
            }
            return 'Order status updated successfully';
        } catch(Exception $e){
            return 'Something went wrong, Exception message: ' . $e->getMessage();
        }
    }
}
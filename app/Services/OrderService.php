<?php 

namespace App\Services;

use App\Models\Order;
use App\Services\ProspectService;


class OrderService{
    static function storeOrder($prospect, $request)
    {      
       $selectedProducts = $request['selected_products'];

       $customerName = $prospect->name;
       $customerEmail = $prospect->email;
       $order = Order::create([
         'customer_id' => $prospect->id,
         'products_id' => $selectedProducts,
         'customer_name' => $customerName,
         'customer_email' => $customerEmail
       ]);
return $order;
    }
}
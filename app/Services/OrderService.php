<?php

namespace App\Services;

use Exception;
use App\Models\Order;
use App\Services\ProductService;
use App\Services\ProspectService;


class OrderService
{
  static function storeOrder($prospect, $request)
  {

    $customerName = $prospect->name;
    $customerEmail = $prospect->email;
    $order = Order::create([
      'customer_id' => $prospect->id,
      'customer_name' => $customerName,
      'customer_email' => $customerEmail
    ]);

    $selectedProducts = $request['selected_products'];

    foreach ($selectedProducts as $product) {
      $product_obj = ProductService::getProductById($product);
      if ($product_obj) {
        $order->products()->attach($product);
      } else {
        throw new Exception('not_exist ' . $product);
      }
    }
    return $order;
  }

  static function getAllOrders()
  {
    $orders = Order::latest()->filter()->paginate(10);
    return $orders;
  }
}

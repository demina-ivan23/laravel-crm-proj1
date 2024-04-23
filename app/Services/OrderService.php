<?php

namespace App\Services;

use Exception;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Services\ProductService;
use App\Services\ProspectService;
use Carbon\Carbon;

class OrderService
{
  static function storeOrder($prospect, $data)
  {
    $order = Order::create([
      'customer_id' => $prospect->id
    ]);
    $selectedProducts = json_decode($data['selected_products_json'], true);

    foreach ($selectedProducts as $productId => $quantity) {
      $product = ProductService::getProductById($productId);
      if ($product) {
        $order->products()->attach($productId, ['quantity' => $quantity]);
      } else {
        throw new Exception('Product not found ' . $product);
      }
    }
    $order_status = OrderStatus::find($data['order_status']);
    $prospect->update(['state_id' => 3]);
    $order->statuses()->attach($order_status, ['explanation' => $data['order_status_explanation'], 'expires_at' => $data['expires_at'] ?? Carbon::now()->addDays(1), 'default_order_transition' => $data['default_order_transition']] ?? null);
    return $order;

  }

  static function getAllOrders()
  {
    $orders = Order::latest()->filter()->paginate(10);
    return $orders;
  }
  static function findOrder($id)
  {
    $order = Order::find($id);
    if(!$order)
    {
      abort(404);
    }
    return $order;
  }
}

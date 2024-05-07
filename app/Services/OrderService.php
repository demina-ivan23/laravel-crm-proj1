<?php

namespace App\Services;

use Exception;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Services\ProductService;
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
  static function updateOrder($data)
  {
    $order = Order::findOrFail($data['order_id']);
    unset($data['order_id']);
    $currentStatus = $order->statuses()->latest()->first();
    $status = OrderStatus::findOrFail($data['order_status']);
    if ($status->id == $currentStatus->id) {
      $pivot = $currentStatus->pivot;
      $order->statuses()->updateExistingPivot($currentStatus->id, ['explanation' => $data['order_status_explanation'] ?? $pivot->explanation, 'expires_at' => $data['expires_at'] ?? $pivot->expires_at]);
    } elseif ($currentStatus->statuses->contains($status->id)) {
      $expires_at = $status->is_final ? null : ($data['expires_at'] ?? Carbon::now()->addDays(1));
      $order->statuses()->attach($status->id, ['explanation' => $data['order_status_explanation'] ?? null, 'expires_at' => $expires_at]);
    } else {
      return 'Invalid status provided';
    }
    $order->update(['updated_at' => $order->statuses()->latest()->first()->pivot->updated_at]);
    return 'Order updating successful';
  }
  static function getAllOrders()
  {
    $orders = Order::latest('updated_at')
      ->filter()
      ->paginate(10);

    return $orders;
  }
}

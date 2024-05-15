<?php

namespace App\Services;

use App\Models\Message;
use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderStatus;


class OrderService
{
  static function storeOrder($prospect, $data)
  {
    $order = Order::create([
      'customer_id' => $prospect->id
    ]);
    $selectedProducts = json_decode($data['selected_products_json'], true);

    foreach ($selectedProducts as $productId => $quantity) {
      $product = Product::findOrFail($productId);
      if ($product) {
        $order->products()->attach($productId, ['quantity' => $quantity]);
      } else {
        throw new Exception('Product not found: ' . $product);
      }
    }
    $orderStatus = OrderStatus::findOrFail($data['order_status']);
    $order->statuses()->attach($orderStatus, ['explanation' => $data['order_status_explanation'], 'expires_at' => $data['expires_at'] ?? Carbon::now()->addDays(1), 'default_order_transition' => $data['default_order_transition']] ?? null);
    $statusIsFinal = $order->statuses()->latest()->first()->is_final ? 'Status is final.' : 'Status is not final';
    $message = new Message([
      'text' => "Order created. Status: $orderStatus->title; Explanation: {$data['order_status_explanation']}; Expires at: " . ($order->statuses()->latest()->first()->pivot->expires_at . "; " ?? "no expiration date; ") . " By default transits to: " . (OrderStatus::find($data['default_order_transition'])->title . "; " ?? "no default transition; ") . $statusIsFinal,
    ]);
    $order->messages()->save($message);
    $productsStr = '';
    foreach($order->products as $product)
    {
      $productsStr .= $product->title . ': ' . $product->pivot->quantity . ' pcs, ';
    }
    $messageForProspect = new Message([
      'text' => 'Order created. Id of the order: ' . $order->id . ';  Products chosen: ' . substr_replace($productsStr, '', -1)
    ]);
    $order->customer->messages()->save($messageForProspect);
    return $order;
  }
  static function updateOrder($data, $order)
  {
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
    $statusIsFinal = $order->statuses()->latest()->first()->is_final ? 'Status is final.' : 'Status is not final';
    $message = new Message([
      'text' => "Order updated. Status: {$order->statuses()->latest()->first()->title}; Explanation: {$order->statuses()->latest()->first()->pivot->explanation}; Expires at: " . ($order->statuses()->latest()->first()->pivot->expires_at . "; " ?? "no expiration date; ") . "By default transits to: " . (OrderStatus::find($order->statuses()->latest()->first()->pivot->default_order_transition)->title . "; " ?? 'no default transition') . $statusIsFinal,
    ]);
    $order->messages()->save($message);
    $productsStr = '';
    foreach($order->products as $product)
    {
      $productsStr .= $product->title . ': ' . $product->pivot->quantity . ' pcs, ';
    }
    $messageForProspect = new Message([
      'text' => 'Order updated. Id of the order: ' . $order->id . ';  Products: ' . substr_replace($productsStr, '', -1)
    ]);
    $order->customer->messages()->save($messageForProspect);
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

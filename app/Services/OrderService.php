<?php

namespace App\Services;

use Exception;
use App\Models\{
   Order,
   Message,
   Product,
   Prospect,
   OrderStatus
};


class OrderService
{
  static function storeOrder(Prospect $prospect, array $data)
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
    $order->statuses()->attach($orderStatus, ['explanation' => $data['order_status_explanation'], 'expires_at' => $data['expires_at'] ?? null , 'default_order_transition' => $data['default_order_transition']] ?? null);
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
  static function updateOrder(array $data, Order $order)
  {
    $currentStatus = $order->latestStatus;
    $status = OrderStatus::findOrFail($data['order_status']);
    if ($status->id == $currentStatus->id) {
      $pivot = $currentStatus->pivot;
      $order->statuses()->updateExistingPivot($currentStatus->id, ['explanation' => $data['order_status_explanation'] ?? $pivot->explanation, 'expires_at' => $data['expires_at'] ?? $pivot->expires_at]);
    } elseif ($currentStatus->statuses->contains($status->id)) {
      $expires_at = $status->is_final ? null : ($data['expires_at'] ?? null);
      $order->statuses()->attach($status->id, ['explanation' => $data['order_status_explanation'] ?? null, 'expires_at' => $expires_at]);
    } else {
      return 'Invalid status provided';
    }
    $order->update(['updated_at' => $order->latestStatus->pivot->updated_at]);
    $statusIsFinal = $order->latestStatus->is_final ? 'Status is final.' : 'Status is not final';
    $defaultTransition = OrderStatus::find($order->defaultStatusTransition) ?? null;
    $defaultTransitionTitle = $defaultTransition !=null ? $defaultTransition->title : 'no default transition';
    $message = new Message([
      'text' => "Order updated. Status: {$order->latestStatus->title}; Explanation: {$order->latestStatus->pivot->explanation}; Expires at: " . ($order->expiresAt . "; " ?? "no expiration date; ") . "By default transits to: " . "{$defaultTransitionTitle}; " . $statusIsFinal,
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

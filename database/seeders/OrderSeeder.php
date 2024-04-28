<?php

namespace Database\Seeders;

use App\Models\{
    Product, 
    Order,
    OrderStatus,
};
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::factory(30)->create();
        $orders->each(function ($order) {
            $products = Product::inRandomOrder()->limit(rand(1, 5))->get();
            $products->each(function ($product) use ($order) {
                $order->products()->attach($product, ['quantity' => rand(1, 5)]);
            });
            $order_status = OrderStatus::inRandomOrder()->first();
            $order->statuses()->attach($order_status->id, ['explanation' => 'loremus ipsumus', 'expires_at' => $order_status->is_final ? null : Carbon::now()->addDays(rand(1,5)), 'default_order_transition' => null]);
            $order->save();
        });
    }
}

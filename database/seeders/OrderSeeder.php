<?php

namespace Database\Seeders;

use App\Models\{
    Product, 
    Order,
};
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            $order->customer()->associate($order->customer_id);
            $order->save();
        });
    }
}

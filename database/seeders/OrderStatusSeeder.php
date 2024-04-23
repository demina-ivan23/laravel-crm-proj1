<?php

namespace Database\Seeders;

use App\Models\{
    OrderStatus,
};
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        OrderStatus::create([
            'title' => 'new',
            'description' => 'a status for a new order',
            'first_step_status' => true,
            'can_transit_into' => 'pending, successful, canceled'
        ]);
        OrderStatus::create([
            'title' => 'pending',
            'description' => 'a status for an order in process',
            'first_step_status' => false,
            'can_transit_into' => 'successful, canceled'
        ]);
        OrderStatus::create([
            'title' => 'successful',
            'description' => 'a status of a finished order. Final status',
            'first_step_status' => false,
            'can_transit_into' => ''
        ]);
        OrderStatus::create([
            'title' => 'canceled',
            'description' => 'a status for a canceled order. Final status',
            'first_step_status' => false,
            'can_transit_into' => ''
        ]);
    }
}
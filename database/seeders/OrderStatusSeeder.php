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
        $successful = OrderStatus::create([
            'title' => 'successful',
            'description' => 'a status of a finished order. Final status',
            'first_step_status' => false,
            'is_final' => true
        ]);
        $canceled = OrderStatus::create([
            'title' => 'canceled',
            'description' => 'a status for a canceled order. Final status',
            'first_step_status' => false,
            'is_final' => true
        ]);
        $pending = OrderStatus::create([
            'title' => 'pending',
            'description' => 'a status for an order in process',
            'first_step_status' => false,
            'is_final' => false
        ]);
        $pending->statuses()->attach($successful);
        $pending->statuses()->attach($canceled);
        $new = OrderStatus::create([
            'title' => 'new',
            'description' => 'a status for a new order',
            'first_step_status' => true,
            'is_final' => false
        ]);
        $new->statuses()->attach($pending);
        $new->statuses()->attach($successful);
        $new->statuses()->attach($canceled);
    }
}

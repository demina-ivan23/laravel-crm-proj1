<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Product;
use App\Models\Prospect;
use Illuminate\Bus\Queueable;
use App\Models\TimeTakenForOrder;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class OrderCreationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
         for($i=0; $i < 100; $i++)
        {
            $prospect = Prospect::inRandomOrder()->first();
            $startTime = microtime(true);
            $order = Order::create(
                [
                    'customer_id' => $prospect->id,
                    'customer_name' => $prospect->name,
                    'customer_email' => $prospect->email,
                    ]
                );
                $randProducts = Product::all()->shuffle()->take(2)->values();
                
                $order->products()->attach([$randProducts[0]->id, $randProducts[1]->id]);
                
                $endTime = microtime(true);
                $timeTaken = ($endTime - $startTime) * 1000;
                
                  TimeTakenForOrder::create([
                    'order_id' => $order->id,
                    'time_taken' => $timeTaken,
                ]);

            $delayInSeconds = rand(30, 180);
            
            sleep($delayInSeconds);
            }
            }
}

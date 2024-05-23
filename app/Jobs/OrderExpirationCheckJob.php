<?php

namespace App\Jobs;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class OrderExpirationCheckJob implements ShouldQueue
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
        foreach(Order::all() as $order) 
        {
            if(!empty($order) && $order->expiresAt <= Carbon::now())
            {
                try{
                    $order->delete();
                    Log::info("Order {$order->id} trashed successfully.");
                } catch(Exception $e) {
                    Log::error("Error deleting order {$order->id}: {$e->getMessage()}");
                }
            }
        }
    }
}

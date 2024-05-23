<?php

namespace App\Jobs;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Message;
use App\Models\OrderStatus;
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
                    if($order->defaultStatusTransition != null)
                    {
                        $defaultStatus = OrderStatus::findOrFail($order->defaultStatusTransition);
                        $order->statuses()->attach($defaultStatus->id, ['explanation' => 'order expired']);
                        $order->update(['updated_at' => $order->latestStatus->pivot->updated_at]);
                        $message = new Message([
                            'text' => 'Order automatically transited to a status of ' . $defaultStatus->title
                        ]);
                        $order->messages()->save($message);
                    } else {
                        $order->delete();
                        // later, with soft-deletes enabeled, I'll use the code below:
                        // $message = new Message([
                        //     'text' => 'Order trashed upon reaching it\'s expiery date'
                        // ]);
                        // $order->messages()->save($message);
                    }
                    Log::info("Order {$order->id} trashed successfully.");
                } catch(Exception $e) {
                    Log::error("Error deleting order {$order->id}: {$e->getMessage()}");
                }
            }
        }
    }
}

<?php

namespace App\Console;

use App\Jobs\OrderCreationJob;
use App\Jobs\OrderExpirationCheckJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->job(OrderCreationJob::class)->withoutOverlapping()->onOneServer();
        $schedule->job(OrderExpirationCheckJob::class)->everyMinute();
        
    }
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

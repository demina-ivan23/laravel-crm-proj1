<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ContinuousScheduler extends Command
{
    protected $signature = 'scheduler:continuous';

    protected $description = 'Run the scheduler continuously';

    public function handle()
    {
        while (true) {
            if (!$this->isSchedulerRunning()) {
                $this->call('schedule:run');
            }
        }
    }

    protected function isSchedulerRunning()
    {
        $process = new Process(['pgrep', '-f', 'artisan schedule:run']);
        $process->run();

        return $process->isSuccessful();
    }
}

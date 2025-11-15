<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Run anomaly detection daily at midnight
        $schedule->job(new \App\Jobs\DetectAnomalies)->daily();
        $schedule->job(new \App\Jobs\CheckLowStock)->daily();
        $schedule->job(new \App\Jobs\GenerateForecasts)->dailyAt('01:00');

        
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
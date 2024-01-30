<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\Front\ProductController;
use App\Jobs\DeleteExpiredCoupons;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        // Add the cleanupRecentlyViewedItems method to run daily
        $schedule->call([ProductController::class, 'cleanupRecentlyViewedItems'])->daily();
        // Add the cleanupRecentlyViewedItems method to run daily
        $schedule->job(new DeleteExpiredCoupons)->daily();
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

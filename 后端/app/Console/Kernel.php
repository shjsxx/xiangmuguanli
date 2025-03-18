<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendExpiryReminders; // 确保引入您的命令

class Kernel extends ConsoleKernel
{
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(SendExpiryReminders::class)->dailyAt('8:00'); // 每天早上 8 点运行
    }
}
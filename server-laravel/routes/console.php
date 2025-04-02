<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule the NotifyLowTemperature command
Artisan::command('schedule:run', function (Schedule $schedule) {
    Log::info('Scheduler is working!');
    $this->info('Scheduler is working!');
    $schedule->command('app:notify-low-temperature')->everyMinute();
});

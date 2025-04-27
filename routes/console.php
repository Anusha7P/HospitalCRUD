<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\SendAppointmentConfirmationEmail;

/**
 * Register all of the application's console commands.
 */
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// $Schedule =>schedule->command('appointment:send-confirmation')->daily();

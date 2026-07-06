<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Backup database otomatis setiap hari pukul 02:00.
// Aktif bila cron server menjalankan: * * * * * php artisan schedule:run
Schedule::command('backup:db')->dailyAt('02:00');

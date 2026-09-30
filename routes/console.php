<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('carts:abandon-expired')->hourly();

// Sync Dropbox → HTML locali + immagini su R2 (notturna; anche manuale: php artisan dropbox:sync-h)
Schedule::command('dropbox:sync-h')
    ->dailyAt('02:30')
    ->withoutOverlapping(120)
    ->appendOutputTo(storage_path('logs/schedule-dropbox.log'))
    ->when(fn () => filled(config('dropbox_sync.shared_link_url'))
        && (filled(config('dropbox_sync.access_token')) || filled(config('dropbox_sync.refresh_token'))));

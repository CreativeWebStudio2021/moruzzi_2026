<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('carts:abandon-expired')->hourly();

Schedule::command('dropbox:sync-h')
    ->everyFifteenMinutes()
    ->withoutOverlapping(30)
    ->appendOutputTo(storage_path('logs/schedule-dropbox.log'))
    ->when(fn () => filled(config('dropbox_sync.shared_link_url'))
        && (filled(config('dropbox_sync.access_token')) || filled(config('dropbox_sync.refresh_token'))));
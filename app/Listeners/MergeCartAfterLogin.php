<?php

namespace App\Listeners;

use App\Services\CartMergeService;
use Illuminate\Auth\Events\Login;

class MergeCartAfterLogin
{
    public function handle(Login $event): void
    {
        app(CartMergeService::class)->mergeForUser($event->user->id);
    }
}

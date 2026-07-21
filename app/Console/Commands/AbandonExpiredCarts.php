<?php

namespace App\Console\Commands;

use App\Services\CartService;
use Illuminate\Console\Command;

class AbandonExpiredCarts extends Command
{
    protected $signature = 'carts:abandon-expired';

    protected $description = 'Marca come abbandonati i carrelli attivi scaduti e libera lo stock riservato';

    public function handle(CartService $cartService): int
    {
        $count = $cartService->abandonExpiredCarts();

        $this->info("Carrelli abbandonati: {$count}");

        return self::SUCCESS;
    }
}

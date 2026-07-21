<?php

namespace App\Services;

use App\Mail\OrderConfirmationAdminMail;
use App\Mail\OrderConfirmationCustomerMail;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderConfirmationNotificationService
{
    /**
     * Invia email di conferma ordine a cliente e amministrazione (bonifico, pagamento in sede, ecc.).
     */
    public function send(Order $order, ?string $locale = null): void
    {
        $order->loadMissing('items.product');
        $locale = normalize_mail_locale($locale ?? app()->getLocale());

        try {
            Mail::to($order->email)->send(new OrderConfirmationCustomerMail($order, $locale));
        } catch (\Throwable $e) {
            Log::error('Invio email conferma ordine al cliente fallito', [
                'order_id' => $order->id,
                'message'  => $e->getMessage(),
            ]);
        }

        $adminEmail = config('mail.from.address');
        if (! $adminEmail) {
            return;
        }

        try {
            Mail::to($adminEmail)->send(new OrderConfirmationAdminMail($order, $locale));
        } catch (\Throwable $e) {
            Log::error('Invio email conferma ordine all\'admin fallito', [
                'order_id' => $order->id,
                'message'  => $e->getMessage(),
            ]);
        }
    }
}

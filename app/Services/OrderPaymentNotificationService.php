<?php

namespace App\Services;

use App\Mail\OrderPaymentAdminMail;
use App\Mail\OrderPaymentCustomerMail;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderPaymentNotificationService
{
    /**
     * Invia email di conferma pagamento a cliente e amministrazione.
     */
    public function send(Order $order, ?string $locale = null): void
    {
        $order->loadMissing('items.product');
        $locale = normalize_mail_locale($locale ?? app()->getLocale());

        try {
            Mail::to($order->email)->send(new OrderPaymentCustomerMail($order, $locale));
        } catch (\Throwable $e) {
            Log::error('Invio email pagamento ordine al cliente fallito', [
                'order_id' => $order->id,
                'message'  => $e->getMessage(),
            ]);
        }

        $adminEmail = config('mail.from.address');
        if (! $adminEmail) {
            return;
        }

        try {
            Mail::to($adminEmail)->send(new OrderPaymentAdminMail($order, $locale));
        } catch (\Throwable $e) {
            Log::error('Invio email pagamento ordine all\'admin fallito', [
                'order_id' => $order->id,
                'message'  => $e->getMessage(),
            ]);
        }
    }
}

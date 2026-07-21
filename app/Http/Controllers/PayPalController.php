<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    public function __construct(
        protected PayPalService $payPal
    ) {}

    /**
     * Endpoint IPN (Instant Payment Notification) — chiamato da PayPal in POST.
     * Compatibile con il vecchio /ipn.php del sito precedente.
     */
    public function ipn(Request $request)
    {
        if (! $this->payPal->validateIpn($request)) {
            Log::warning('PayPal IPN non verificato', ['payload' => $request->all()]);

            return response('INVALID', 200);
        }

        $this->payPal->processPaymentNotification($request->all(), 'ipn');

        return response('OK', 200);
    }

    /**
     * Ritorno utente da PayPal (rm=2 → POST con custom e txn_id).
     */
    public function return(Request $request)
    {
        $orderId = $this->payPal->parseOrderIdFromCustom(
            $request->input('custom') ?? $request->query('custom')
        );

        if ($orderId) {
            $this->payPal->processPaymentNotification($request->all(), 'return');

            /** @var Order|null $order */
            $order = Order::query()->find($orderId);

            if ($order) {
                if (! auth()->check() && ! session()->has('checkout_order_id')) {
                    session(['checkout_order_id' => $order->id]);
                }

                return redirect()->to(locale_route('checkout.thankyou', ['order' => $order->id]))
                    ->with('paypal_paid', $order->status === 'pagato');
            }
        }

        return redirect()->to(locale_route('home'))
            ->with('error', __('checkout.paypal_return_error'));
    }
}

<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PayPalService
{
    public function __construct(
        protected OrderPaymentNotificationService $paymentNotifications,
        protected OrderConfirmationNotificationService $orderNotifications,
    ) {}

    public function isSandbox(): bool
    {
        return (bool) config('paypal.sandbox');
    }

    public function businessEmail(): string
    {
        return $this->isSandbox()
            ? (string) config('paypal.sandbox_business_email')
            : (string) config('paypal.business_email');
    }

    public function checkoutUrl(): string
    {
        return $this->isSandbox()
            ? 'https://www.sandbox.paypal.com/cgi-bin/webscr'
            : 'https://www.paypal.com/cgi-bin/webscr';
    }

    public function ipnValidationUrl(): string
    {
        return $this->checkoutUrl();
    }

    public function shouldUseTestPaymentAmount(?Request $request = null): bool
    {
        if (! config('paypal.test_payment_enabled')) {
            return false;
        }

        $allowedIps = (array) config('paypal.test_payment_ips', []);
        if ($allowedIps === []) {
            return false;
        }

        $request = $request ?? request();

        foreach ($this->clientIps($request) as $ip) {
            if (in_array($ip, $allowedIps, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Campo custom legacy: {id_ordine}-{session_id}-{locale}
     */
    public function buildCustomField(Order $order): string
    {
        $locale = app()->getLocale();

        return $order->id.'-'.session()->getId().'-'.$locale;
    }

    /**
     * @return array<string, string>
     */
    public function buildCartFormFields(Order $order, ?Request $request = null): array
    {
        $order->loadMissing('items');
        $request = $request ?? request();

        $fields = [
            'cmd'            => '_cart',
            'redirect_cmd'   => '_xclick',
            'upload'         => '1',
            'rm'             => '2',
            'business'       => $this->businessEmail(),
            'currency_code'  => (string) config('paypal.currency', 'EUR'),
            'custom'         => $this->buildCustomField($order),
            'first_name'     => (string) $order->nome_spe,
            'last_name'      => (string) $order->cognome_spe,
            'address1'       => (string) $order->indirizzo_spe,
            'zip'            => (string) $order->cap_spe,
            'city'           => (string) $order->citta_spe,
            'state'          => (string) $order->prov_spe,
            'notify_url'     => route('paypal.ipn', [], true),
            'return'         => route('paypal.return', [], true),
            'cancel_return'  => locale_route('checkout.thankyou', ['order' => $order->id]),
            'lc'             => (string) config('paypal.locale', 'IT'),
            'country'        => $this->countryCode((string) $order->paese_spe),
            'H_PhoneNumber'  => (string) $order->telefono_spe,
            'email_address'  => (string) $order->email,
        ];

        if ($this->shouldUseTestPaymentAmount($request)) {
            $amount = (float) config('paypal.test_payment_amount', 0.01);

            $fields['amount_1']    = $this->formatAmount($amount);
            $fields['item_name_1'] = 'Ordine n. '.$order->id.' (importo test)';
            $fields['quantity_1']  = '1';
            $fields['handling_cart'] = '0.00';

            return $fields;
        }

        $fields['handling_cart'] = $this->formatAmount((float) $order->spese);

        $index = 1;
        foreach ($order->items as $item) {
            $fields['amount_'.$index]     = $this->formatAmount((float) $item->prezzo);
            $fields['item_name_'.$index]  = Str::limit((string) $item->nome, 127, '');
            $fields['quantity_'.$index]   = (string) (int) $item->quantita;
            $index++;
        }

        return $fields;
    }

    public function parseOrderIdFromCustom(?string $custom): ?int
    {
        if (! $custom) {
            return null;
        }

        $custom = urldecode($custom);
        $parts = explode('-', $custom);

        if (count($parts) < 3 || ! is_numeric($parts[0])) {
            return null;
        }

        return (int) $parts[0];
    }

    public function parseLocaleFromCustom(?string $custom): ?string
    {
        if (! $custom) {
            return null;
        }

        $custom = urldecode($custom);
        $parts = explode('-', $custom);

        return $parts[2] ?? null;
    }

    public function validateIpn(Request $request): bool
    {
        $payload = array_merge(['cmd' => '_notify-validate'], $request->all());

        try {
            $response = Http::asForm()
                ->timeout(30)
                ->post($this->ipnValidationUrl(), $payload);
        } catch (\Throwable $e) {
            Log::error('PayPal IPN validation request failed', ['message' => $e->getMessage()]);

            return false;
        }

        return trim($response->body()) === 'VERIFIED';
    }

    /**
     * Registra il pagamento, aggiorna l'ordine e invia le email (idempotente).
     *
     * @param  array<string, mixed>  $payload
     */
    public function processPaymentNotification(array $payload, string $source): bool
    {
        $paymentStatus = (string) ($payload['payment_status'] ?? '');
        if (! in_array($paymentStatus, ['Completed', 'Processed'], true)) {
            return false;
        }

        $txnId = (string) ($payload['txn_id'] ?? '');
        if ($txnId === '') {
            return false;
        }

        $receiverEmail = strtolower((string) ($payload['receiver_email'] ?? ''));
        $expectedEmail = strtolower($this->businessEmail());
        if ($receiverEmail !== '' && $receiverEmail !== $expectedEmail) {
            Log::warning('PayPal IPN receiver email mismatch', [
                'expected' => $expectedEmail,
                'received' => $receiverEmail,
            ]);

            return false;
        }

        $orderId = $this->parseOrderIdFromCustom($payload['custom'] ?? null);
        if (! $orderId) {
            return false;
        }

        /** @var Order|null $order */
        $order = Order::query()->with('items')->find($orderId);
        if (! $order || $order->pagamento !== 'paypal') {
            return false;
        }

        $alreadyLogged = $this->transactionAlreadyLogged($txnId);
        if ($alreadyLogged && $order->status === 'pagato') {
            return false;
        }

        $newlyPaid = DB::transaction(function () use ($order, $payload, $source, $txnId, $alreadyLogged) {
            if (! $alreadyLogged) {
                $this->logPaymentInfo($payload, $txnId);
            }

            if ($source === 'ipn' && (string) $order->pp_response === '1') {
                return false;
            }

            if ($source === 'return' && (string) $order->ipn === '1') {
                return false;
            }

            if ($order->status === 'pagato') {
                return false;
            }

            $now = now();

            $order->update([
                'status'       => 'pagato',
                'data_pagato'  => $now,
                'data_mod'     => $now,
                'ipn'          => $source === 'ipn' ? '1' : $order->ipn,
                'pp_response'  => $source === 'return' ? '1' : $order->pp_response,
            ]);

            return true;
        });

        if ($newlyPaid) {
            $locale = $this->parseLocaleFromCustom($payload['custom'] ?? null);
            $order = $order->fresh(['items.product']);
            $this->orderNotifications->send($order, $locale);
            $this->paymentNotifications->send($order, $locale);
        }

        return $newlyPaid;
    }

    protected function transactionAlreadyLogged(string $txnId): bool
    {
        return DB::table('paypal_payment_info')
            ->where('txnid', $txnId)
            ->exists();
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    protected function logPaymentInfo(array $payload, string $txnId): void
    {
        $txnType = (string) ($payload['txn_type'] ?? '');

        DB::table('paypal_payment_info')->insert([
            'paymentstatus'  => $this->clip($payload['payment_status'] ?? '', 15),
            'buyer_email'    => $this->clip($payload['payer_email'] ?? '', 100),
            'firstname'      => $this->clip($payload['first_name'] ?? '', 100),
            'lastname'       => $this->clip($payload['last_name'] ?? '', 100),
            'street'         => $this->clip($payload['address_street'] ?? '', 100),
            'city'           => $this->clip($payload['address_city'] ?? '', 50),
            'state'          => $this->clip($payload['address_state'] ?? '', 3),
            'zipcode'        => $this->clip($payload['address_zip'] ?? '', 11),
            'country'        => $this->clip($payload['address_country'] ?? '', 20),
            'mc_gross'       => $this->clip($payload['mc_gross'] ?? '', 6),
            'mc_fee'         => $this->clip($payload['mc_fee'] ?? '', 5),
            'memo'           => $this->clip($payload['memo'] ?? '', 255),
            'paymenttype'    => $this->clip($payload['payment_type'] ?? '', 10),
            'paymentdate'    => $this->clip($payload['payment_date'] ?? '', 50),
            'txnid'          => $this->clip($txnId, 30),
            'pendingreason'  => $this->clip($payload['pending_reason'] ?? '', 10),
            'reasoncode'     => $this->clip($payload['reason_code'] ?? '', 20),
            'tax'            => $this->clip($payload['tax'] ?? '', 10),
            'custom'         => $this->clip($payload['custom'] ?? '', 255),
            'txntype'        => $txnType !== '' ? $this->clip($txnType, 10) : null,
            'mc_currency'    => $this->clip($payload['mc_currency'] ?? config('paypal.currency', 'EUR'), 5),
            'datecreation'   => now(),
        ]);

        if ($txnType === 'cart') {
            $numItems = (int) ($payload['num_cart_items'] ?? 0);
            for ($i = 1; $i <= $numItems; $i++) {
                DB::table('paypal_cart_info')->insert([
                    'txnid'      => $this->clip($txnId, 30),
                    'itemname'   => $this->clip($payload['item_name'.$i] ?? '', 255),
                    'itemnumber' => $this->clip($payload['item_number'.$i] ?? '', 50),
                    'os0'        => $this->clip($payload['option_selection1_'.$i] ?? '', 20),
                    'on0'        => $this->clip($payload['option_name1_'.$i] ?? '', 50),
                    'os1'        => $this->clip($payload['option_selection2_'.$i] ?? '', 20),
                    'on1'        => $this->clip($payload['option_name2_'.$i] ?? '', 50),
                    'quantity'   => $this->clip($payload['quantity'.$i] ?? '', 3),
                    'invoice'    => $this->clip($payload['invoice'] ?? '', 255),
                    'custom'     => $this->clip($payload['custom'] ?? '', 255),
                ]);
            }
        }
    }

    /**
     * Tronca i valori alle dimensioni colonne della tabella legacy mor_paypal_*.
     */
    protected function clip(?string $value, int $maxLength): string
    {
        $value = trim((string) ($value ?? ''));

        if ($maxLength <= 0 || $value === '') {
            return '';
        }

        return mb_strimwidth($value, 0, $maxLength, '');
    }

    /**
     * @return array<int, string>
     */
    protected function clientIps(Request $request): array
    {
        $ips = [];

        $cf = $request->header('CF-Connecting-IP');
        if ($cf) {
            $ips[] = trim($cf);
        }

        $xff = $request->header('X-Forwarded-For');
        if ($xff) {
            foreach (explode(',', $xff) as $part) {
                $ips[] = trim($part);
            }
        }

        foreach ($request->getClientIps() as $ip) {
            $ips[] = $ip;
        }

        $ips[] = $request->ip();

        return array_values(array_filter(array_unique($ips)));
    }

    protected function countryCode(string $countryName): string
    {
        $key = strtolower(preg_replace('/\s+/', '', $countryName) ?? '');

        $codes = (array) config('paypal.country_codes', []);

        return $codes[$key] ?? 'IT';
    }

    protected function formatAmount(float $amount): string
    {
        return number_format($amount, 2, '.', '');
    }
}


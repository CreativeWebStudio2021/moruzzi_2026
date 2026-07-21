<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use App\Services\OrderConfirmationNotificationService;
use App\Services\PayPalService;
use App\Services\ProductAvailabilityService;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
    ) {}

    /**
     * Scelta modalità checkout: login, registrazione o ospite.
     */
    public function options(Request $request)
    {
        $cart = $this->cartService->findForCurrentVisitor();

        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->to(locale_route('cart.index'));
        }

        if (auth()->check()) {
            return redirect()->to(locale_route('checkout.shipping'));
        }

        $guest = session('checkout_guest', []);
        if (!empty($guest['email'])) {
            if ($this->guestEmailIsRegistered($guest['email'])) {
                session()->forget('checkout_guest');
            } else {
                return redirect()->to(locale_route('checkout.shipping'));
            }
        }

        session(['url.intended' => locale_route('checkout.shipping')]);

        return view('web.checkout.options');
    }

    /**
     * Form acquisto come ospite.
     */
    public function guestForm(Request $request)
    {
        $cart = $this->cartService->findForCurrentVisitor();

        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->to(locale_route('cart.index'));
        }

        if (auth()->check()) {
            return redirect()->to(locale_route('checkout.shipping'));
        }

        $guest = session('checkout_guest', []);

        if (!empty($guest['email']) && $this->guestEmailIsRegistered($guest['email'])) {
            session()->forget('checkout_guest');
            $guest = [];
        }

        return view('web.checkout.guest', [
            'guest' => $guest,
        ]);
    }

    /**
     * Salva i dati minimi dell'ospite e avvia il checkout.
     */
    public function storeGuest(Request $request)
    {
        $cart = $this->cartService->findForCurrentVisitor();

        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->to(locale_route('cart.index'));
        }

        $data = $request->validate([
            'nome'    => ['required', 'string', 'max:255'],
            'cognome' => ['required', 'string', 'max:255'],
            'email'   => ['required', 'string', 'email', 'max:255'],
        ]);

        $email = strtolower($data['email']);

        if ($this->guestEmailIsRegistered($email)) {
            session(['url.intended' => locale_route('checkout.shipping')]);

            return back()
                ->withErrors(['email' => __('checkout.guest_email_registered')])
                ->withInput($data);
        }

        $data['email'] = $email;

        session([
            'checkout_guest' => array_merge(session('checkout_guest', []), $data),
        ]);

        return redirect()->to(locale_route('checkout.shipping'));
    }

    /**
     * Step 1: dati di spedizione.
     */
    public function shipping(Request $request)
    {
        $cart = $this->cartService->findForCurrentVisitor();

        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->to(locale_route('cart.index'));
        }

        $customer = $this->checkoutCustomer();

        return view('web.checkout.shipping', [
            'customer' => $customer,
            'cart' => $cart,
        ]);
    }

    /**
     * Salva i dati di spedizione sul cliente e passa al riepilogo.
     */
    public function storeShipping(Request $request)
    {
        $cart = $this->cartService->findForCurrentVisitor();

        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->to(locale_route('cart.index'));
        }

        /** @var Customer $customer */
        $customer = $this->checkoutCustomer();

        $data = $request->validate([
            'nome'           => ['required', 'string', 'max:255'],
            'cognome'        => ['required', 'string', 'max:255'],
            'indirizzo'      => ['required', 'string', 'max:255'],
            'citta'          => ['required', 'string', 'max:255'],
            'provincia'      => ['required', 'string', 'max:255'],
            'cap'            => ['required', 'string', 'max:20'],
            'nazione'        => ['required', 'string', 'max:255'],
            'cod_fiscale'    => ['nullable', 'string', 'max:50'],
            'rag_sociale'    => ['nullable', 'string', 'max:255'],
            'partita_iva'    => ['nullable', 'string', 'max:50'],
            'pec_sdu'        => ['nullable', 'string', 'max:255'],
            'telefono'       => ['required', 'string', 'max:50'],
        ]);

        if ($data['nazione'] === 'Italia' && empty($data['cod_fiscale'])) {
            return back()
                ->withErrors(['cod_fiscale' => __('validation.required', ['attribute' => 'codice fiscale'])])
                ->withInput();
        }

        if ($this->isGuestCheckout()) {
            $guest = array_merge(session('checkout_guest', []), [
                'nome_sped'    => $data['nome'],
                'cognome_sped' => $data['cognome'],
                'indirizzo'    => $data['indirizzo'],
                'citta'        => $data['citta'],
                'provincia'    => $data['provincia'],
                'cap'          => $data['cap'],
                'nazione'      => $data['nazione'],
                'cod_fiscale'  => $data['cod_fiscale'] ?? null,
                'rag_sociale'  => $data['rag_sociale'] ?? null,
                'partita_iva'  => $data['partita_iva'] ?? null,
                'pec_sdu'      => $data['pec_sdu'] ?? null,
                'telefono'     => $data['telefono'],
            ]);
            session(['checkout_guest' => $guest]);

            return redirect()->to(locale_route('checkout.review'));
        }

        $customer->nome_sped   = $data['nome'];
        $customer->cognome_sped= $data['cognome'];
        $customer->indirizzo   = $data['indirizzo'];
        $customer->citta       = $data['citta'];
        $customer->provincia   = $data['provincia'];
        $customer->cap         = $data['cap'];
        $customer->nazione     = $data['nazione'];
        $customer->cod_fiscale = $data['cod_fiscale'] ?? null;
        $customer->rag_sociale = $data['rag_sociale'] ?? null;
        $customer->partita_iva = $data['partita_iva'] ?? null;
        $customer->pec_sdu     = $data['pec_sdu'] ?? null;
        $customer->telefono    = $data['telefono'];

        $customer->save();

        return redirect()->to(locale_route('checkout.review'));
    }

    /**
     * Step 2: riepilogo carrello + selezione spedizione/pagamento.
     */
    public function review(Request $request)
    {
        $cart = $this->cartService->findForCurrentVisitor();

        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->to(locale_route('cart.index'));
        }

        /** @var Customer $customer */
        $customer = $this->checkoutCustomer();

        $items = $cart->items()->with('product')->get();

        $subtotal = 0.0;
        $weight   = 0.0;

        foreach ($items as $item) {
            if (!$item->product) {
                continue;
            }

            $linePrice = $item->price_snapshot * $item->quantity;
            $subtotal += $linePrice;

            $productWeight = (float) ($item->product->weight ?? 0);
            $weight += $productWeight * $item->quantity;
        }

        [$defaultShippingLabel, $defaultShippingCost] = $this->computeShippingCost($customer, $subtotal, $weight);

        $shippingMethods = [
            'standard' => [
                'label' => $defaultShippingLabel,
                'cost'  => $defaultShippingCost,
            ],
            'pickup' => [
                'label' => __('checkout.pickup_in_store'),
                'cost'  => 0.0,
            ],
        ];

        $paymentMethods = [
            'paypal'   => __('checkout.payment_paypal'),
            'bonifico' => __('checkout.payment_bank_transfer'),
            'sede'     => __('checkout.payment_in_store'),
        ];

        return view('web.checkout.review', [
            'customer'        => $customer,
            'cart'            => $cart,
            'items'           => $items,
            'subtotal'        => $subtotal,
            'weight'          => $weight,
            'shippingMethods' => $shippingMethods,
            'paymentMethods'  => $paymentMethods,
        ]);
    }

    /**
     * Step 3: conferma ordine.
     */
    public function confirm(Request $request, OrderConfirmationNotificationService $orderNotifications)
    {
        $cart = $this->cartService->findForCurrentVisitor();

        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->to(locale_route('cart.index'));
        }

        /** @var Customer $customer */
        $customer = $this->checkoutCustomer();

        $items = $cart->items()->with('product')->get();

        if ($items->isEmpty()) {
            return redirect()->to(locale_route('cart.index'));
        }

        $subtotal = 0.0;
        $weight   = 0.0;

        foreach ($items as $item) {
            if (!$item->product) {
                continue;
            }

            $linePrice = $item->price_snapshot * $item->quantity;
            $subtotal += $linePrice;

            $productWeight = (float) ($item->product->weight ?? 0);
            $weight += $productWeight * $item->quantity;
        }

        [$defaultShippingLabel, $defaultShippingCost] = $this->computeShippingCost($customer, $subtotal, $weight);

        $data = $request->validate([
            'shipping_method'  => ['required', 'in:standard,pickup'],
            'payment_method'   => ['required', 'in:paypal,bonifico,sede'],
            'note'             => ['nullable', 'string', 'max:500'],
            'terms_accepted'   => ['accepted'],
        ]);

        $shippingLabel = $defaultShippingLabel;
        $shippingCost  = $defaultShippingCost;

        if ($data['shipping_method'] === 'pickup') {
            $shippingLabel = __('checkout.pickup_in_store');
            $shippingCost  = 0.0;
        }

        $payment = $data['payment_method'];
        $paymentLabel = match ($payment) {
            'sede'     => 'pagamento in sede',
            'bonifico' => 'bonifico',
            default    => 'paypal',
        };
        $note    = $data['note'] ?? '';

        $total = $subtotal + $shippingCost;

        if ($this->isGuestCheckout()) {
            $customer = $this->persistGuestCustomer();
        }

        $cartId = $cart->id;

        $order = DB::transaction(function () use ($customer, $items, $subtotal, $shippingLabel, $shippingCost, $total, $note, $payment, $paymentLabel, $cartId) {
                $productIds = $items->pluck('product_id')->filter()->unique()->values();

                $products = Product::query()
                    ->whereIn('entity_id', $productIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('entity_id');

                $stockErrors = $this->validateCartStock($items, $products, $cartId);

                if ($stockErrors !== []) {
                    throw new HttpResponseException(
                        redirect()
                            ->to(locale_route('checkout.review'))
                            ->withErrors(['stock' => $stockErrors])
                            ->withInput()
                    );
                }

            $now = now();

            $orderStatus = $payment === 'paypal' ? 'annullato' : 'nuovo';

            $order = Order::create([
                'id_cliente'   => $customer->id,
                'nome'         => $customer->nome,
                'cognome'      => $customer->cognome,
                'email'        => $customer->email,
                'nome_spe'     => $customer->nome_sped ?? $customer->nome,
                'cognome_spe'  => $customer->cognome_sped ?? $customer->cognome,
                'indirizzo_spe'=> $customer->indirizzo,
                'cap_spe'      => $customer->cap,
                'citta_spe'    => $customer->citta,
                'prov_spe'     => $customer->provincia,
                'paese_spe'    => $customer->nazione,
                'azienda_spe'  => $customer->rag_sociale,
                'piva'         => $customer->partita_iva,
                'pec_sdu'      => $customer->pec_sdu,
                'cod_fiscale'  => $customer->cod_fiscale,
                'telefono_spe' => $customer->telefono,
                'note_spe'     => $note,
                'spedizione'   => $shippingLabel,
                'pagamento'    => $paymentLabel,
                'totale'       => $total,
                'spese'        => $shippingCost,
                'data_ord'     => $now,
                'data_mod'     => $now,
                'status'       => $orderStatus,
                'ipn'          => '0',
                'pp_response'  => '0',
            ]);

            foreach ($items as $item) {
                if (!$item->product) {
                    continue;
                }

                $unitPrice   = $item->price_snapshot;
                $linePrice   = $unitPrice * $item->quantity;
                $weightUnit  = (float) ($item->product->weight ?? 0);
                $weightLine  = $weightUnit * $item->quantity;

                OrderItem::create([
                    'id_prod'   => $item->product_id,
                    'id_ord'    => $order->id,
                    'cod_prod'  => $item->product->sku,
                    'nome'      => Str::limit((string) $item->product->name, 255, ''),
                    'prezzo'    => $unitPrice,
                    'prezzo_f'  => $linePrice,
                    'peso'      => $weightUnit,
                    'peso_f'    => $weightLine,
                    'quantita'  => $item->quantity,
                ]);
            }

            // Svuota il carrello
            $orderCart = $this->cartService->findForCurrentVisitor();
            if ($orderCart) {
                $orderCart->items()->delete();
                $orderCart->delete();
            }

            return $order;
        });

        app(ProductAvailabilityService::class)->forgetMany(
            $items->pluck('product_id')->filter()->unique()->values()
        );

        if ($this->isGuestCheckout()) {
            session([
                'checkout_order_id' => $order->id,
            ]);
            session()->forget('checkout_guest');
        }

        if ($payment !== 'paypal') {
            $orderNotifications->send($order->fresh(['items.product']), app()->getLocale());
        }

        if ($payment === 'paypal') {
            return redirect()->to(locale_route('checkout.paypal', ['order' => $order->id]));
        }

        return redirect()->to(locale_route('checkout.thankyou', ['order' => $order]));
    }

    /**
     * Redirect automatico verso PayPal dopo la creazione dell'ordine.
     */
    public function paypalRedirect(Order $order, PayPalService $payPal)
    {
        if (! $this->canAccessOrder($order) || $order->pagamento !== 'paypal') {
            abort(403);
        }

        if ($order->status === 'pagato') {
            return redirect()->to(locale_route('checkout.thankyou', ['order' => $order->id]));
        }

        return view('web.checkout.paypal-redirect', [
            'order'       => $order->load('items'),
            'action'      => $payPal->checkoutUrl(),
            'formFields'  => $payPal->buildCartFormFields($order, request()),
            'testPayment' => $payPal->shouldUseTestPaymentAmount(request()),
        ]);
    }

    /**
     * Step finale: pagina di ringraziamento / esito.
     */
    public function thankYou(Order $order)
    {
        if (! $this->canAccessOrder($order)) {
            abort(403);
        }

        return view('web.checkout.thankyou', [
            'order' => $order->load('items.product'),
        ]);
    }

    private function canAccessOrder(Order $order): bool
    {
        if (auth()->check() && (int) $order->id_cliente === (int) auth()->id()) {
            return true;
        }

        return (int) session('checkout_order_id') === (int) $order->id;
    }

    private function isGuestCheckout(): bool
    {
        $guest = session('checkout_guest', []);

        return !auth()->check() && !empty($guest['email']);
    }

    private function checkoutCustomer(): Customer
    {
        if (auth()->check()) {
            return Auth::user();
        }

        $this->ensureGuestEmailIsAvailable();

        $guest = session('checkout_guest', []);

        if (empty($guest['email'])) {
            abort(redirect()->to(locale_route('checkout.options')));
        }

        $customer = new Customer();
        $customer->forceFill([
            'nome'         => $guest['nome'] ?? '',
            'cognome'      => $guest['cognome'] ?? '',
            'email'        => $guest['email'] ?? '',
            'nome_sped'    => $guest['nome_sped'] ?? ($guest['nome'] ?? ''),
            'cognome_sped' => $guest['cognome_sped'] ?? ($guest['cognome'] ?? ''),
            'indirizzo'    => $guest['indirizzo'] ?? '',
            'citta'        => $guest['citta'] ?? '',
            'provincia'    => $guest['provincia'] ?? '',
            'cap'          => $guest['cap'] ?? '',
            'nazione'      => $guest['nazione'] ?? 'Italia',
            'cod_fiscale'  => $guest['cod_fiscale'] ?? null,
            'rag_sociale'  => $guest['rag_sociale'] ?? null,
            'partita_iva'  => $guest['partita_iva'] ?? null,
            'pec_sdu'      => $guest['pec_sdu'] ?? null,
            'telefono'     => $guest['telefono'] ?? '',
        ]);

        return $customer;
    }

    private function persistGuestCustomer(): Customer
    {
        $guest = session('checkout_guest', []);
        $email = strtolower(trim($guest['email'] ?? ''));

        if ($this->guestEmailIsRegistered($email)) {
            session()->forget('checkout_guest');
            session(['url.intended' => locale_route('checkout.shipping')]);

            throw new HttpResponseException(
                redirect()->to(locale_route('checkout.guest'))
                    ->withErrors(['email' => __('checkout.guest_email_registered')])
                    ->withInput($guest)
            );
        }

        $payload = [
            'nome'         => $guest['nome'] ?? '',
            'cognome'      => $guest['cognome'] ?? '',
            'email'        => $guest['email'] ?? '',
            'nome_sped'    => $guest['nome_sped'] ?? ($guest['nome'] ?? ''),
            'cognome_sped' => $guest['cognome_sped'] ?? ($guest['cognome'] ?? ''),
            'indirizzo'    => $guest['indirizzo'] ?? '',
            'citta'        => $guest['citta'] ?? '',
            'provincia'    => $guest['provincia'] ?? '',
            'cap'          => $guest['cap'] ?? '',
            'nazione'      => $guest['nazione'] ?? 'Italia',
            'cod_fiscale'  => $guest['cod_fiscale'] ?? null,
            'rag_sociale'  => $guest['rag_sociale'] ?? null,
            'partita_iva'  => $guest['partita_iva'] ?? null,
            'pec_sdu'      => $guest['pec_sdu'] ?? null,
            'telefono'     => $guest['telefono'] ?? '',
        ];

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < 15; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return Customer::create(array_merge($payload, [
            'data_iscr'  => now(),
            'password'   => Hash::make(Str::random(32)),
            'codice'     => $code,
            'confermato' => '1',
            'news'       => '0',
        ]));
    }

    private function guestEmailIsRegistered(string $email): bool
    {
        $email = strtolower(trim($email));

        if ($email === '') {
            return false;
        }

        return Customer::whereRaw('LOWER(email) = ?', [$email])->exists();
    }

    private function ensureGuestEmailIsAvailable(): void
    {
        if (!$this->isGuestCheckout()) {
            return;
        }

        $guest = session('checkout_guest', []);

        if (!$this->guestEmailIsRegistered($guest['email'] ?? '')) {
            return;
        }

        session()->forget('checkout_guest');
        session(['url.intended' => locale_route('checkout.shipping')]);

        throw new HttpResponseException(
            redirect()->to(locale_route('checkout.guest'))
                ->withErrors(['email' => __('checkout.guest_email_registered')])
                ->withInput($guest)
        );
    }

    /**
     * Replica la logica di calcolo spese di spedizione del vecchio sito.
     */
    private function computeShippingCost(Customer $customer, float $subtotal, float $weight): array
    {
        $prezziSpedizioni = [
            'italia' => [
                'fino_100g' => [
                    'fino_36_euro'     => 8.00,
                    'fino_50_euro'     => 8.50,
                    'fino_250_euro'    => 11.00,
                    'fino_500_euro'    => 13.60,
                    'fino_1000_euro'   => 16.20,
                    'fino_2000_euro'   => 18.80,
                    'fino_3000_euro'   => 21.40,
                ],
                'oltre_100g_fino_250g' => [
                    'fino_36_euro'     => 8.65,
                    'fino_50_euro'     => 9.15,
                    'fino_250_euro'    => 11.65,
                    'fino_500_euro'    => 14.25,
                    'fino_1000_euro'   => 16.85,
                    'fino_2000_euro'   => 19.45,
                    'fino_3000_euro'   => 22.05,
                ],
                'oltre_250g_fino_350g' => [
                    'fino_36_euro'     => 9.65,
                    'fino_50_euro'     => 10.10,
                    'fino_250_euro'    => 12.60,
                    'fino_500_euro'    => 15.20,
                    'fino_1000_euro'   => 17.80,
                    'fino_2000_euro'   => 20.40,
                    'fino_3000_euro'   => 23.00,
                ],
                'oltre_350g_fino_1000g' => [
                    'fino_36_euro'     => 11.85,
                    'fino_50_euro'     => 12.25,
                    'fino_250_euro'    => 14.75,
                    'fino_500_euro'    => 17.35,
                    'fino_1000_euro'   => 19.95,
                    'fino_2000_euro'   => 22.55,
                    'fino_3000_euro'   => 25.15,
                ],
                'oltre_1000g_fino_2000g' => [
                    'fino_36_euro'     => 15.80,
                    'fino_50_euro'     => 16.05,
                    'fino_250_euro'    => 18.55,
                    'fino_500_euro'    => 21.15,
                    'fino_1000_euro'   => 23.75,
                    'fino_2000_euro'   => 26.35,
                    'fino_3000_euro'   => 28.95,
                ],
            ],
            'internazionale' => [
                'fino_100g' => [
                    'fino_36_euro'     => 10.90,
                    'fino_50_euro'     => 12.10,
                    'fino_250_euro'    => 14.60,
                    'fino_500_euro'    => 17.20,
                    'fino_1000_euro'   => 19.80,
                    'fino_2000_euro'   => 22.40,
                    'fino_3000_euro'   => 25.00,
                ],
                'oltre_100g_fino_250g' => [
                    'fino_36_euro'     => 13.15,
                    'fino_50_euro'     => 14.30,
                    'fino_250_euro'    => 16.80,
                    'fino_500_euro'    => 19.40,
                    'fino_1000_euro'   => 22.00,
                    'fino_2000_euro'   => 24.60,
                    'fino_3000_euro'   => 27.20,
                ],
                'oltre_250g_fino_350g' => [
                    'fino_36_euro'     => 14.75,
                    'fino_50_euro'     => 15.90,
                    'fino_250_euro'    => 18.40,
                    'fino_500_euro'    => 21.00,
                    'fino_1000_euro'   => 23.60,
                    'fino_2000_euro'   => 26.20,
                    'fino_3000_euro'   => 28.80,
                ],
                'oltre_350g_fino_1000g' => [
                    'fino_36_euro'     => 20.00,
                    'fino_50_euro'     => 21.20,
                    'fino_250_euro'    => 23.70,
                    'fino_500_euro'    => 26.30,
                    'fino_1000_euro'   => 28.90,
                    'fino_2000_euro'   => 31.50,
                    'fino_3000_euro'   => 34.10,
                ],
                'oltre_1000g_fino_2000g' => [
                    'fino_36_euro'     => 29.40,
                    'fino_50_euro'     => 30.60,
                    'fino_250_euro'    => 33.10,
                    'fino_500_euro'    => 35.70,
                    'fino_1000_euro'   => 38.30,
                    'fino_2000_euro'   => 40.90,
                    'fino_3000_euro'   => 43.50,
                ],
            ],
        ];

        $country = $customer->nazione ?: 'Italia';
        $dest = (strtolower($country) === 'italia') ? 'italia' : 'internazionale';

        $soglia_peso = 'oltre_1000g_fino_2000g';
        if ($weight <= 1.0) {
            $soglia_peso = 'oltre_350g_fino_1000g';
        }
        if ($weight <= 0.350) {
            $soglia_peso = 'oltre_250g_fino_350g';
        }
        if ($weight <= 0.250) {
            $soglia_peso = 'oltre_100g_fino_250g';
        }
        if ($weight <= 0.100) {
            $soglia_peso = 'fino_100g';
        }

        $soglia_spesa = 'fino_3000_euro';
        if ($subtotal <= 2000) {
            $soglia_spesa = 'fino_2000_euro';
        }
        if ($subtotal <= 1000) {
            $soglia_spesa = 'fino_1000_euro';
        }
        if ($subtotal <= 500) {
            $soglia_spesa = 'fino_500_euro';
        }
        if ($subtotal <= 250) {
            $soglia_spesa = 'fino_250_euro';
        }
        if ($subtotal <= 50) {
            $soglia_spesa = 'fino_50_euro';
        }
        if ($subtotal <= 36) {
            $soglia_spesa = 'fino_36_euro';
        }

        $nome_sped = $subtotal > 36
            ? __('checkout.insured_shipping')
            : __('checkout.registered_shipping');

        $spese = $prezziSpedizioni[$dest][$soglia_peso][$soglia_spesa] ?? 0.0;

        return [$nome_sped, $spese];
    }

    /**
     * @param  \Illuminate\Support\Collection<int, \App\Models\CartItem>  $items
     * @param  \Illuminate\Support\Collection<int, \App\Models\Product>  $products
     * @return list<string>
     */
    private function validateCartStock($items, $products, int $cartId): array
    {
        $errors = [];

        foreach ($items as $item) {
            $product = $products->get($item->product_id);

            if (! $product) {
                $errors[] = __('checkout.stock_product_missing');

                continue;
            }

            $available = $product->availableQuantityExcludingCart($cartId);
            $requested = (int) $item->quantity;

            if ($requested > $available) {
                $errors[] = $available > 0
                    ? __('checkout.stock_error_line', [
                        'product' => $product->localizedName(),
                        'requested' => $requested,
                        'available' => $available,
                    ])
                    : __('checkout.stock_error_line_none', [
                        'product' => $product->localizedName(),
                    ]);
            }
        }

        return $errors;
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Order;
use App\Services\NewsletterSubscriptionService;

class AccountController extends Controller
{
    public function __construct(
        protected NewsletterSubscriptionService $newsletter,
    ) {}

    public function dashboard()
    {
        /** @var Customer $customer */
        $customer = auth()->user();

        return view('web.account.dashboard', [
            'customer' => $customer,
        ]);
    }

    public function orders()
    {
        /** @var Customer $customer */
        $customer = auth()->user();

        $status = request()->query('status', 'in_corso');

        $query = Order::where('id_cliente', $customer->id);

        if ($status === 'in_corso') {
            $query->whereIn('status', ['pagato', 'nuovo', 'pending', 'processing', 'holded', 'payment_review']);
        } elseif ($status === 'evasi') {
            $query->whereIn('status', ['spedito', 'complete', 'closed']);
        } elseif ($status === 'annullati') {
            $query->whereIn('status', ['annullato', 'canceled']);
        }

        $orders = $query->orderByDesc('id')->get();

        return view('web.account.orders', [
            'orders' => $orders,
            'status' => $status,
        ]);
    }

    public function orderDetail(Order $order)
    {
        /** @var Customer $customer */
        $customer = auth()->user();

        if ($order->id_cliente !== $customer->id) {
            abort(404);
        }

        $order->load('items');

        $orderDate = $order->data_ord
            ? \Carbon\Carbon::parse($order->data_ord)->format('d-m-Y')
            : '';

        $subtotal = $order->items->sum('prezzo_f');

        return view('web.account.order-detail', [
            'order' => $order,
            'orderDate' => $orderDate,
            'subtotal' => $subtotal,
        ]);
    }

    public function shipping()
    {
        /** @var Customer $customer */
        $customer = auth()->user();

        $customer->nome_sped = $customer->nome_sped ?: $customer->nome;
        $customer->cognome_sped = $customer->cognome_sped ?: $customer->cognome;

        return view('web.account.shipping', [
            'customer' => $customer,
        ]);
    }

    public function password()
    {
        return view('web.account.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return back()->with([
            'status' => __('Password aggiornata con successo.'),
            'status_type' => 'success',
        ]);
    }

    public function updateProfile(Request $request)
    {
        /** @var Customer $customer */
        $customer = auth()->user();

        $data = $request->validate([
            'nome'      => ['required', 'string', 'max:255'],
            'cognome'   => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:clienti_new,email,' . $customer->id],
            'newsletter'=> ['nullable', 'boolean'],
        ]);

        $newsletter = $request->boolean('newsletter') ? '1' : '0';
        $previousEmail = $customer->email;

        $customer->nome    = $data['nome'];
        $customer->cognome = $data['cognome'];
        $customer->email   = $data['email'];
        $customer->news    = $newsletter;
        $customer->save();

        if ($previousEmail !== $customer->email) {
            DB::table('newsletter_subscriber')
                ->where('subscriber_email', $previousEmail)
                ->update([
                    'subscriber_email' => $customer->email,
                    'customer_id' => $customer->id,
                ]);
        }

        if ($newsletter === '1') {
            if ($previousEmail !== $customer->email) {
                $this->newsletter->unsubscribe($previousEmail);
            }
            $this->newsletter->subscribeCustomer($customer);
        } else {
            $this->newsletter->unsubscribe($customer->email);
            if ($previousEmail !== $customer->email) {
                $this->newsletter->unsubscribe($previousEmail);
            }
        }

        return back()->with([
            'status' => __('Dati account aggiornati correttamente.'),
            'status_type' => 'success',
        ]);
    }

    public function updateShipping(Request $request)
    {
        /** @var Customer $customer */
        $customer = auth()->user();

        $data = $request->validate([
            'nome_sped'      => ['required', 'string', 'max:255'],
            'cognome_sped'   => ['required', 'string', 'max:255'],
            'indirizzo'      => ['required', 'string', 'max:255'],
            'cap'            => ['required', 'string', 'max:20'],
            'citta'          => ['required', 'string', 'max:255'],
            'provincia'      => ['required', 'string', 'max:255'],
            'nazione'        => ['required', 'string', 'max:255'],
            'telefono'       => ['nullable', 'string', 'max:50'],
            'cod_fiscale'    => ['nullable', 'string', 'max:32'],
            'rag_sociale'    => ['nullable', 'string', 'max:255'],
            'partita_iva'    => ['nullable', 'string', 'max:64'],
            'pec_sdu'        => ['nullable', 'string', 'max:128'],
        ]);

        // Validazioni aggiuntive tipo vecchio JS
        if (empty($data['rag_sociale']) && empty($data['cod_fiscale'])) {
            return back()
                ->withErrors(['cod_fiscale' => __('Campo "Codice fiscale" obbligatorio se non è presente la Ragione Sociale.')])
                ->withInput();
        }
        if (!empty($data['rag_sociale']) && empty($data['partita_iva'])) {
            return back()
                ->withErrors(['partita_iva' => __('Se presente la Ragione Sociale inserire una Partita IVA.')])
                ->withInput();
        }
        if (!empty($data['rag_sociale']) && empty($data['pec_sdu'])) {
            return back()
                ->withErrors(['pec_sdu' => __('Inserisci Codice SDI o PEC.')])
                ->withInput();
        }

        $customer->fill($data);
        $customer->save();

        return back()->with([
            'status' => __('Dati di spedizione aggiornati correttamente.'),
            'status_type' => 'success',
        ]);
    }
}


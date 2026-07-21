<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterSubscriptionMail;
use App\Services\NewsletterSubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function __construct(
        protected NewsletterSubscriptionService $newsletter,
    ) {}

    /**
     * Iscrizione newsletter dal popup (solo prima apertura per sessione).
     */
    public function subscribe(Request $request): RedirectResponse
    {
        $request->validate([
            'subscriber_email' => ['required', 'email'],
        ], [], [
            'subscriber_email' => __('newsletter.email'),
        ]);

        $email = strtolower(trim($request->input('subscriber_email')));

        if ($this->newsletter->isSubscribed($email)) {
            session()->flash('newsletter_message', __('newsletter.already_subscribed'));
            session()->flash('newsletter_message_type', 'error');
            session()->put('newsletter_popup_shown', true);

            return redirect()->back();
        }

        $customerId = 0;
        $firstName = null;
        $lastName = null;
        $customer = DB::table('clienti_new')->where('email', $email)->first();

        if ($customer) {
            $customerId = (int) $customer->id;
            $firstName = $customer->nome ?? null;
            $lastName = $customer->cognome ?? null;
        }

        $this->newsletter->subscribe($email, $customerId, $firstName, $lastName);

        Mail::to($email)->send(new NewsletterSubscriptionMail($email, app()->getLocale()));

        session()->flash('newsletter_message', __('newsletter.subscribed'));
        session()->flash('newsletter_message_type', 'success');
        session()->put('newsletter_popup_shown', true);

        return redirect()->back();
    }

    /**
     * Segna come "popup già mostrato" per la sessione (chiusura senza iscrizione).
     * Usato in AJAX dal pulsante chiudi per evitare reload.
     */
    public function dismiss(): Response
    {
        session()->put('newsletter_popup_shown', true);

        return response()->noContent();
    }
}

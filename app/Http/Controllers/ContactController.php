<?php

namespace App\Http\Controllers;

use App\Mail\ContactRequestMail;
use App\Mail\ContactRequestConfirmationMail;
use App\Services\ContactSpamGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __construct(
        protected ContactSpamGuard $spamGuard,
    ) {}

    public function show()
    {
        return view('web.contatti.form');
    }

    public function submit(Request $request)
    {
        if ($request->filled('website')) {
            return redirect()->to(locale_route('contact.thankyou'));
        }

        $data = $request->validate([
            'nome'      => ['required', 'string', 'max:255'],
            'cognome'   => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255'],
            'telefono'  => ['nullable', 'string', 'max:255'],
            'messaggio' => ['required', 'string'],
            '_started'  => ['nullable', 'integer'],
        ]);

        unset($data['_started']);

        if ($this->spamGuard->shouldReject($request, $data)) {
            return redirect()->to(locale_route('contact.thankyou'));
        }

        $adminEmail = config('mail.from.address');

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new ContactRequestMail($data));
        }

        Mail::to($data['email'])->send(new ContactRequestConfirmationMail($data, app()->getLocale()));

        return redirect()->to(locale_route('contact.thankyou'));
    }

    public function thankyou()
    {
        return view('web.contatti.thankyou');
    }
}


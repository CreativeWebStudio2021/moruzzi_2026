<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewRegistrationAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Customer $customer
    ) {
        $this->locale = 'it';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('emails.admin_registration_subject'),
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            replyTo: [
                new Address($this->customer->email, $this->customer->nome.' '.$this->customer->cognome),
            ],
        );
    }

    public function content(): Content
    {
        $dataIscrizione = $this->customer->data_iscr
            ? \Carbon\Carbon::parse($this->customer->data_iscr)->format('d/m/Y')
            : now()->format('d/m/Y');

        return new Content(
            view: 'emails.new-registration-admin',
            with: [
                'nome' => $this->customer->nome,
                'cognome' => $this->customer->cognome,
                'email' => $this->customer->email,
                'dataIscrizione' => $dataIscrizione,
                'showPrivacyFooter' => false,
                'subject' => __('emails.admin_registration_subject'),
            ]
        );
    }
}

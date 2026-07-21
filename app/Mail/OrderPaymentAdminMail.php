<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPaymentAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        ?string $locale = null,
    ) {
        $this->locale = normalize_mail_locale($locale);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('emails.order_payment_admin_subject', ['number' => $this->order->id]),
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            replyTo: [
                new Address($this->order->email, trim($this->order->nome.' '.$this->order->cognome)),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-payment-admin',
            with: [
                'order' => $this->order,
                'showPrivacyFooter' => false,
                'subject' => __('emails.order_payment_admin_subject', ['number' => $this->order->id]),
            ],
        );
    }
}

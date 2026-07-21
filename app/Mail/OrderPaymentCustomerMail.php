<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPaymentCustomerMail extends Mailable
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
            subject: __('emails.order_payment_subject', ['number' => $this->order->id]),
            from: new Address(config('mail.from.address'), config('mail.from.name')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-payment-customer',
            with: [
                'order' => $this->order,
                'showPrivacyFooter' => true,
                'subject' => __('emails.order_payment_subject', ['number' => $this->order->id]),
            ],
        );
    }
}

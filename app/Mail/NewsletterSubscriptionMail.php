<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $email,
        ?string $locale = null,
    ) {
        $this->locale = normalize_mail_locale($locale);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('emails.newsletter_subject'),
            from: new Address(config('mail.from.address'), config('mail.from.name')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter-subscription',
            with: [
                'email' => $this->email,
                'showPrivacyFooter' => true,
                'subject' => __('emails.newsletter_subject'),
            ]
        );
    }
}

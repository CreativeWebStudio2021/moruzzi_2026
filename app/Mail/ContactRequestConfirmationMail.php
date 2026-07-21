<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactRequestConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data, ?string $locale = null)
    {
        $this->data = $data;
        $this->locale = normalize_mail_locale($locale);
    }

    public function build(): self
    {
        return $this
            ->subject(__('contact.user_subject'))
            ->view('emails.contact-request-confirmation');
    }
}

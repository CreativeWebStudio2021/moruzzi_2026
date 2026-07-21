<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->locale = 'it';
    }

    public function build(): self
    {
        return $this
            ->subject(__('contact.admin_subject'))
            ->view('emails.contact-request', ['showPrivacyFooter' => false]);
    }
}

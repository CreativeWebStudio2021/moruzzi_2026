<?php

namespace App\Services;

use App\Mail\NewRegistrationAdminMail;
use App\Mail\NewsletterSubscriptionMail;
use App\Mail\WelcomeCustomerMail;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;

class RegistrationNotificationService
{
    public function __construct(
        protected NewsletterSubscriptionService $newsletter,
    ) {}

    /**
     * Invia le email di benvenuto e notifica admin, e gestisce l'iscrizione newsletter.
     */
    public function sendAfterRegistration(Customer $customer, string $newsletter, ?string $locale = null): void
    {
        $locale = normalize_mail_locale($locale);

        Mail::to($customer->email)->send(new WelcomeCustomerMail($customer, $locale));

        $adminEmail = config('mail.from.address');
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new NewRegistrationAdminMail($customer));
        }

        if ($newsletter === '1') {
            $this->newsletter->subscribeCustomer($customer);
            Mail::to($customer->email)->send(new NewsletterSubscriptionMail($customer->email, $locale));
        }
    }
}

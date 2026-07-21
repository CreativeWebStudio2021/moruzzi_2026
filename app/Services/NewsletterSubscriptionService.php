<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class NewsletterSubscriptionService
{
    protected string $table = 'newsletter_subscriber';

    public function __construct(
        protected BrevoContactService $brevo,
    ) {}

    public function subscribe(
        string $email,
        ?int $customerId = null,
        ?string $firstName = null,
        ?string $lastName = null,
    ): void {
        $email = strtolower(trim($email));
        $now = now()->format('Y-m-d H:i:s');

        $exists = DB::table($this->table)->where('subscriber_email', $email)->exists();

        if (! $exists) {
            DB::table($this->table)->insert([
                'change_status_at' => $now,
                'customer_id' => $customerId ?? 0,
                'subscriber_email' => $email,
                'subscriber_status' => '1',
            ]);
        } else {
            DB::table($this->table)
                ->where('subscriber_email', $email)
                ->update([
                    'customer_id' => $customerId ?? 0,
                    'subscriber_status' => '1',
                    'change_status_at' => $now,
                ]);
        }

        $this->brevo->subscribe($email, $this->brevo->attributesFromNames($firstName, $lastName));
    }

    public function subscribeCustomer(Customer $customer): void
    {
        $this->subscribe(
            $customer->email,
            (int) $customer->id,
            $customer->nome,
            $customer->cognome,
        );
    }

    public function unsubscribe(string $email): void
    {
        $email = strtolower(trim($email));
        $exists = DB::table($this->table)->where('subscriber_email', $email)->exists();

        if ($exists) {
            DB::table($this->table)
                ->where('subscriber_email', $email)
                ->update([
                    'subscriber_status' => '0',
                    'change_status_at' => now()->format('Y-m-d H:i:s'),
                ]);
        }

        $this->brevo->unsubscribe($email);
    }

    public function isSubscribed(string $email): bool
    {
        return DB::table($this->table)
            ->where('subscriber_email', strtolower(trim($email)))
            ->where('subscriber_status', '1')
            ->exists();
    }
}

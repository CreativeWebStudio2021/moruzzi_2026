<?php

namespace App\Actions\Fortify;

use App\Models\Customer;
use App\Services\RegistrationNotificationService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered customer.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function create(array $input): Customer
    {
        Validator::make($input, [
            'nome' => ['required', 'string', 'max:255'],
            'cognome' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(Customer::class, 'email'),
            ],
            'password' => $this->passwordRules(),
            'privacy' => ['accepted'],
            'newsletter' => ['nullable', 'boolean'],
        ])->validate();
        
        $newsletter = !empty($input['newsletter']) ? '1' : '0';

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < 15; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }

        $customer = Customer::create([
            'data_iscr' => now(),
            'nome' => $input['nome'],
            'cognome' => $input['cognome'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'news' => $newsletter,
            'codice' => $code,
            'confermato' => '1',
        ]);

        app(RegistrationNotificationService::class)->sendAfterRegistration($customer, $newsletter, app()->getLocale());

        return $customer;
    }
}

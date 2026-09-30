<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Actions\Fortify\LoginResponse as CustomLoginResponse;
use App\Actions\Fortify\RegisterResponse as CustomRegisterResponse;
use App\Models\Customer;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Override risposta di login Fortify per aggiungere messaggio di successo
        $this->app->singleton(LoginResponse::class, CustomLoginResponse::class);
        // Override risposta di registrazione Fortify per aggiungere messaggio di successo
        $this->app->singleton(RegisterResponse::class, CustomRegisterResponse::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Rate limiting per login e two-factor
        RateLimiter::for('login', function (Request $request) {
            return [
                Limit::perMinute(5)->by($request->input('email').$request->ip()),
            ];
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return [
                Limit::perMinute(5)->by($request->session()->get('login.id')),
            ];
        });

        // Azioni Fortify
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Blocca il login se l'account non è attivo (confermato = 0).
        Fortify::authenticateUsing(function (Request $request) {
            $username = (string) $request->input(Fortify::username());

            $user = Customer::query()
                ->whereRaw('LOWER('.Fortify::username().') = ?', [strtolower($username)])
                ->first();

            if (! $user || ! Hash::check((string) $request->input('password'), (string) $user->password)) {
                return null;
            }

            if ((string) $user->confermato !== '1') {
                throw ValidationException::withMessages([
                    Fortify::username() => [__('auth.inactive')],
                ]);
            }

            return $user;
        });

        // View personalizzate
        Fortify::loginView(function () {
            return view('web.auth.login');
        });

        Fortify::registerView(function () {
            return view('web.auth.register');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('web.auth.forgot-password');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('web.auth.reset-password', ['request' => $request]);
        });
    }
}

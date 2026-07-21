<?php

namespace App\Actions\Fortify;

use App\Models\Cart;
use App\Services\CartMergeService;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param  Request  $request
     */
    public function toResponse($request)
    {
        if ($request->user()) {
            app(CartMergeService::class)->mergeForUser($request->user()->id);
        }

        return redirect()
            ->intended($this->defaultRedirectUrl())
            ->with('login_success', true);
    }

    private function defaultRedirectUrl(): string
    {
        return locale_route('checkout.shipping');
    }
}

<?php

namespace App\Actions\Fortify;

use App\Services\CartMergeService;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
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
            ->with('register_success', true);
    }

    private function defaultRedirectUrl(): string
    {
        return locale_route('checkout.shipping');
    }
}

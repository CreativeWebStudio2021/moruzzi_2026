<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle($request, Closure $next)
	{
		$locale = $request->route('locale');
		
		$availableLocales = ['it', 'en', 'es', 'fr', 'de'];
		 
		if ($locale && in_array($locale, $availableLocales)) {
            App::setLocale($locale);
        } else {
            // URL senza prefisso lingua (es. /prodotto-123.html) = sempre italiano
            App::setLocale('it');
        }

		return $next($request);
	}

}

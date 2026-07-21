<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanonicalHostAndFontCors
{
    public function handle(Request $request, Closure $next): Response
    {
        if (strtolower($request->getHost()) === 'moruzzi.it') {
            return redirect()->to('https://www.moruzzi.it'.$request->getRequestUri(), 301);
        }

        $response = $next($request);

        if (preg_match('/\.(woff2?|ttf|eot|otf)$/i', $request->path())) {
            $response->headers->set('Access-Control-Allow-Origin', '*');
        }

        return $response;
    }
}

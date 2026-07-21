<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Reindirizza in 301 i PDF legacy verso pagine pertinenti del nuovo sito.
 */
class RedirectLegacyPdf
{
    private const WWW_HOSTS = ['moruzzi.it', 'www.moruzzi.it'];

    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->getHost(), self::WWW_HOSTS, true)) {
            return $next($request);
        }

        $path = trim($request->path(), '/');

        if (! str_ends_with(strtolower($path), '.pdf')) {
            return $next($request);
        }

        if (is_file(public_path($path))) {
            return $next($request);
        }

        $target = $this->resolveTarget($path);
        if ($target === null) {
            return $next($request);
        }

        return redirect()->to($target, 301);
    }

    private function resolveTarget(string $path): ?string
    {
        $files = config('legacy_pdf_redirects.files', []);
        $basename = strtolower(rawurldecode(basename($path)));

        if (isset($files[$basename])) {
            return $this->urlFromRule($files[$basename]);
        }

        $folders = config('legacy_pdf_redirects.folders', []);
        $longest = '';

        foreach ($folders as $folder => $rule) {
            $folder = rtrim($folder, '/');
            if (str_starts_with($path, $folder.'/') && strlen($folder) > strlen($longest)) {
                $longest = $folder;
            }
        }

        if ($longest !== '' && isset($folders[$longest])) {
            return $this->urlFromRule($folders[$longest]);
        }

        $prefixDefaults = config('legacy_pdf_redirects.prefix_defaults', []);
        $longestPrefix = '';

        foreach ($prefixDefaults as $prefix => $rule) {
            if (str_starts_with($path, $prefix) && strlen($prefix) > strlen($longestPrefix)) {
                $longestPrefix = $prefix;
            }
        }

        if ($longestPrefix !== '' && isset($prefixDefaults[$longestPrefix])) {
            return $this->urlFromRule($prefixDefaults[$longestPrefix]);
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $rule
     */
    private function urlFromRule(array $rule): ?string
    {
        if (isset($rule['path'])) {
            return url('/'.ltrim((string) $rule['path'], '/'));
        }

        if (isset($rule['route'])) {
            $locale = 'it';
            $slugs = config('localized_slugs', []);
            $relative = ltrim((string) ($slugs[$rule['route']]['it'] ?? ''), '/');

            return $relative === '' ? url('/') : url('/'.$relative);
        }

        return null;
    }
}

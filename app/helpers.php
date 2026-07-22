<?php

use Illuminate\Support\Facades\Request;

if (! function_exists('route_url_for_locale')) {

    /**
     * URL di una named route nella lingua indicata.
     */
    function route_url_for_locale(string $routeName, string $locale, array $parameters = [], bool $absolute = true): string
    {
        unset($parameters['locale']);

        $slugs = config('localized_slugs')[$routeName] ?? null;
        if (is_array($slugs) && array_key_exists($locale, $slugs)) {
            $path = (string) $slugs[$locale];

            foreach ($parameters as $key => $value) {
                if (is_scalar($value) || (is_object($value) && method_exists($value, 'getRouteKey'))) {
                    $value = is_object($value) ? $value->getRouteKey() : $value;
                    $path = str_replace('{'.$key.'}', (string) $value, $path);
                }
            }

            if ($locale === 'it') {
                return url($path === '' ? '/' : $path);
            }

            return url($locale.'/'.ltrim($path, '/'));
        }

        if ($locale === 'it') {
            return route($routeName, $parameters, $absolute);
        }

        return route('locale.'.$routeName, array_merge(['locale' => $locale], $parameters), $absolute);
    }
}

if (! function_exists('localized_url')) {

    /**
     * Restituisce l'URL della pagina corrente nella lingua richiesta.
     */
    function localized_url(string $locale): string
    {
        $availableLocales = ['it', 'en', 'fr', 'es', 'de'];

        if (! in_array($locale, $availableLocales, true)) {
            $locale = 'it';
        }

        $query = Request::getQueryString();
        $queryString = $query ? '?'.$query : '';

        if (request()->isMethod('GET')) {
            $route = request()->route();
            $routeName = $route?->getName();

            if ($routeName) {
                $routeName = str_starts_with($routeName, 'locale.')
                    ? substr($routeName, 7)
                    : $routeName;

                if (! str_ends_with($routeName, '.submit')
                    && ! str_ends_with($routeName, '.store')
                    && ! str_ends_with($routeName, '.update')
                    && ! str_ends_with($routeName, '.add')
                    && ! str_ends_with($routeName, '.remove')
                    && ! str_ends_with($routeName, '.clear')
                    && ! str_ends_with($routeName, '.confirm')
                    && ! str_ends_with($routeName, '.load')
                    && ! str_ends_with($routeName, '.search')
                    && ! str_ends_with($routeName, '.mini')
                    && ! str_ends_with($routeName, '.count')
                    && ! str_ends_with($routeName, '.dismiss')
                    && ! str_ends_with($routeName, '.session')
                ) {
                    try {
                        return route_url_for_locale($routeName, $locale, $route->parameters()).$queryString;
                    } catch (\Throwable $e) {
                        // fallback sotto
                    }
                }
            }
        }

        $segments = Request::segments();

        if (isset($segments[0]) && in_array($segments[0], $availableLocales, true)) {
            array_shift($segments);
        }

        $path = implode('/', $segments);

        if ($path !== '' && preg_match('/-(\d+)\.html$/i', $path, $matches)) {
            $product = \App\Models\Product::where('entity_id', (int) $matches[1])->first();
            if ($product) {
                return product_url($product, $locale).$queryString;
            }
        }

        if ($path !== '' && preg_match('/\.html$/i', $path) && ! preg_match('/-\d+\.html$/i', $path)) {
            $fullLink = $path;
            if (! str_ends_with($fullLink, '.html')) {
                $fullLink .= '.html';
            }

            $cat = resolve_category_by_link($fullLink, app()->getLocale())
                ?? \App\Models\Category::where('link_it', $fullLink)
                    ->orWhere('link_en', $fullLink)
                    ->orWhere('link_de', $fullLink)
                    ->orWhere('link_fr', $fullLink)
                    ->orWhere('link_es', $fullLink)
                    ->first();

            if ($cat) {
                $linkCol = $locale === 'it' ? 'link_it' : ('link_'.$locale);
                $translatedPath = $cat->$linkCol ?? $cat->link_it;
                if ($translatedPath) {
                    $path = $translatedPath;
                }
            }
        }

        $guideArticle = \App\Support\GuideRegistry::findByPath($path);
        if ($guideArticle !== null) {
            $guideRoute = $guideArticle['redirect_route'] ?? $guideArticle['route'];

            try {
                return route_url_for_locale($guideRoute, $locale, []).$queryString;
            } catch (\Throwable $e) {
                $targetPath = \App\Support\GuideRegistry::pathForArticle($guideArticle, $locale);

                return $locale === 'it'
                    ? url($targetPath).$queryString
                    : url($locale.'/'.$targetPath).$queryString;
            }
        }

        return $locale === 'it'
            ? url($path ?: '/').$queryString
            : url($locale.'/'.($path ?: '')).$queryString;
    }
}

if (! function_exists('current_locale_prefix')) {

    /**
     * Prefisso lingua per gli URL ('' per italiano, 'en/', 'fr/', ecc. per le altre).
     * Usa il primo segmento dell'URL se è una lingua valida, altrimenti app()->getLocale().
     */
    function current_locale_prefix(): string
    {
        $locale = app()->getLocale();
        $firstSegment = request()->segment(1);
        if (in_array($firstSegment, ['en', 'es', 'fr', 'de'], true)) {
            $locale = $firstSegment;
        }
        return $locale === 'it' ? '' : $locale . '/';
    }
}

if (! function_exists('request_path_without_locale')) {

    function request_path_without_locale(): string
    {
        $locale = app()->getLocale();
        $firstSegment = request()->segment(1);

        if (in_array($firstSegment, ['en', 'es', 'fr', 'de'], true)) {
            $locale = $firstSegment;
        }

        $path = trim(request()->path(), '/');

        if ($locale !== 'it' && str_starts_with($path, $locale.'/')) {
            $path = substr($path, strlen($locale) + 1);
        }

        return $path;
    }
}

if (! function_exists('locale_route_is')) {

    /**
     * Verifica se la richiesta corrente corrisponde a una named route,
     * anche quando il path tradotto è registrato senza nome (alias localizzati).
     */
    function locale_route_is(string $routeName): bool
    {
        if (request()->routeIs($routeName, 'locale.'.$routeName)) {
            return true;
        }

        $locale = app()->getLocale();
        $firstSegment = request()->segment(1);

        if (in_array($firstSegment, ['en', 'es', 'fr', 'de'], true)) {
            $locale = $firstSegment;
        }

        $path = request_path_without_locale();
        $localizedPath = config('localized_slugs')[$routeName][$locale] ?? null;

        if ($localizedPath !== null && trim($localizedPath, '/') === $path) {
            return true;
        }

        $article = \App\Support\GuideRegistry::findByPath($path);

        if ($article !== null) {
            $effectiveRoute = $article['redirect_route'] ?? $article['route'];

            return $effectiveRoute === $routeName || $article['route'] === $routeName;
        }

        return false;
    }
}

if (! function_exists('is_home_page')) {

    function is_home_page(): bool
    {
        return request()->routeIs('home', 'locale.home');
    }
}

if (! function_exists('should_show_home_intro')) {

    /**
     * Mostra l'intro animata solo al primo accesso home per sessione.
     */
    function should_show_home_intro(): bool
    {
        static $show = null;

        if ($show !== null) {
            return $show;
        }

        if (! is_home_page() || session('home_intro_seen')) {
            return $show = false;
        }

        session()->put('home_intro_seen', true);

        return $show = true;
    }
}

if (! function_exists('product_is_delisted')) {

    /**
     * Prodotto rimosso dal catalogo: visibilità off e quantità a zero.
     */
    function product_is_delisted($product): bool
    {
        $visibility = (int) ($product->visibility ?? 0);
        $isVisible = in_array($visibility, [1, 4], true);
        $qty = (int) ($product->qty ?? 0);

        return ! $isVisible && $qty <= 0;
    }
}

if (! function_exists('product_primary_category_url')) {

    /**
     * URL della categoria principale del prodotto (la più specifica, escluse vetrine speciali).
     */
    function product_primary_category_url($product, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $raw = trim((string) ($product->categorie ?? ''), '@');

        if ($raw === '') {
            return null;
        }

        $ids = collect(preg_split('/@+/', $raw, -1, PREG_SPLIT_NO_EMPTY))
            ->map(fn ($value) => (int) str_replace('@', '', trim($value)))
            ->filter()
            ->unique()
            ->values()
            ->all();

        if ($ids === []) {
            return null;
        }

        // Offerte, in evidenza, ultimi arrivi: non sono categorie di navigazione principali.
        $excludeIds = [969, 1435, 1436];

        $category = \App\Models\Category::query()
            ->whereIn('entity_id', $ids)
            ->whereNotIn('entity_id', $excludeIds)
            ->orderByDesc('level')
            ->orderByDesc('position')
            ->first();

        if (! $category) {
            return null;
        }

        $link = $category->{'link_'.$locale} ?? $category->link_it ?? null;
        if ($link === null || $link === '') {
            return null;
        }

        $prefix = ($locale === 'it') ? '' : $locale.'/';

        return url($prefix.ltrim($link, '/'));
    }
}

if (! function_exists('product_delisted_redirect_url')) {

    /**
     * Destinazione redirect 301 per prodotto delistato: categoria principale o homepage.
     */
    function product_delisted_redirect_url($product, ?string $locale = null): string
    {
        return product_primary_category_url($product, $locale) ?? locale_route('home');
    }
}

if (! function_exists('locale_route')) {

    /**
     * Restituisce l'URL della named route nella lingua corrente.
     * - "it" usa le route senza prefisso.
     * - en/fr/de/es usano le route nel gruppo {locale} (prefisso "locale.") se esistono,
     *   altrimenti fanno fallback aggiungendo solo il prefisso /{locale}/ al path generato.
     */
    function locale_route(string $name, $parameters = [], bool $absolute = true): string
    {
        $locale = app()->getLocale();

        // Accetta anche un singolo modello/scalare (come route()), normalizzandolo in array.
        if (! is_array($parameters)) {
            $parameters = [$parameters];
        }

        // Italiano: route "normale"
        if ($locale === 'it') {
            return route($name, $parameters, $absolute);
        }

        // Altre lingue: path tradotto da config (guide, catalogo, ecc.)
        $localizedPaths = config('localized_slugs', [])[$name] ?? null;
        if (is_array($localizedPaths) && ! empty($localizedPaths[$locale])) {
            return url($locale.'/'.ltrim($localizedPaths[$locale], '/'));
        }

        // Altre lingue: prova con la rotta localizzata "locale.{name}"
        $paramsWithLocale = array_merge(['locale' => $locale], $parameters);

        try {
            return route('locale.'.$name, $paramsWithLocale, $absolute);
        } catch (\Throwable $e) {
            // fallback: usa la rotta base e aggiungi il prefisso /{locale}/ al path
            try {
                $url = route($name, $parameters, false);
            } catch (\Throwable $e2) {
                $base = $locale.'/';
                return $absolute ? url($base) : '/'.$base;
            }

            $url = ltrim($url, '/');
            $final = $locale.'/'.$url;

            return $absolute ? url($final) : '/'.$final;
        }
    }
}

if (!function_exists('highlight_search')) {
    function highlight_search(?string $text, array $keywords): string
    {
        if ($text === null || $text === '') {
            return '';
        }
        foreach ($keywords as $word) {
            $word = preg_quote($word, '/');
            $text = preg_replace('/(' . $word . ')/iu', '<span class="search-highlight">$1</span>', $text);
        }
        return $text;
    }
}

if (!function_exists('image_alt')) {

    /**
     * Testo alt normalizzato: strip HTML, spazi, troncamento a 100 caratteri (SEO).
     */
    function image_alt(?string $text, ?string $fallback = null, int $maxLength = 100): string
    {
        $value = '';

        foreach ([$text, $fallback] as $candidate) {
            if (! is_string($candidate)) {
                continue;
            }

            $candidate = trim(preg_replace('/\s+/u', ' ', strip_tags(html_entity_decode($candidate, ENT_QUOTES | ENT_HTML5, 'UTF-8'))));

            if ($candidate !== '') {
                $value = $candidate;
                break;
            }
        }

        if ($value === '') {
            return '';
        }

        if (mb_strlen($value) <= $maxLength) {
            return $value;
        }

        $truncated = mb_substr($value, 0, $maxLength);
        $lastSpace = mb_strrpos($truncated, ' ');

        if ($lastSpace !== false && $lastSpace >= (int) ($maxLength * 0.6)) {
            $truncated = mb_substr($truncated, 0, $lastSpace);
        }

        return rtrim($truncated, " \t\n\r\0\x0B.,;:-");
    }
}

if (!function_exists('image_alt_from_file')) {

    /**
     * Alt di fallback leggibile dal nome file immagine.
     */
    function image_alt_from_file(?string $filename): string
    {
        if ($filename === null || $filename === '') {
            return '';
        }

        $base = pathinfo($filename, PATHINFO_FILENAME);
        $base = preg_replace('/[-_]+/', ' ', (string) $base);
        $base = preg_replace('/\s+/u', ' ', trim((string) $base));

        if ($base === '') {
            return '';
        }

        return image_alt(mb_convert_case($base, MB_CASE_TITLE, 'UTF-8'));
    }
}

if (!function_exists('content_image_alt')) {

    /**
     * Alt per immagini editoriali (guida, chi siamo, certificazioni).
     *
     * @param  array<string, mixed>  $image
     */
    function content_image_alt(array $image, string ...$fallbacks): string
    {
        $primary = (string) ($image['alt'] ?? '');

        foreach ($fallbacks as $fallback) {
            if (trim(strip_tags($primary)) === '') {
                $primary = $fallback;
            }
        }

        if (trim(strip_tags($primary)) === '') {
            $primary = image_alt_from_file((string) ($image['file'] ?? ''));
        }

        return image_alt($primary);
    }
}

if (!function_exists('normalize_html_image_alts')) {

    /**
     * Corregge alt mancanti o troppo lunghi nelle immagini inline HTML.
     */
    function normalize_html_image_alts(string $html, ?string $fallbackAlt = null): string
    {
        if ($html === '') {
            return '';
        }

        return (string) preg_replace_callback(
            '/<img\b([^>]*?)>/iu',
            static function (array $matches) use ($fallbackAlt): string {
                $attrs = $matches[1];

                if (preg_match('/\balt=(["\'])(.*?)\1/is', $attrs, $altMatch)) {
                    $normalized = image_alt($altMatch[2], $fallbackAlt);
                    $replacement = 'alt="'.e($normalized).'"';
                    $attrs = preg_replace('/\balt=(["\']).*?\1/is', $replacement, $attrs, 1);
                } else {
                    $normalized = image_alt('', $fallbackAlt);
                    $attrs .= ' alt="'.e($normalized).'"';
                }

                return '<img'.$attrs.'>';
            },
            $html
        );
    }
}

if (!function_exists('resolve_guide_html')) {

    function resolve_guide_html(?string $html, ?string $fallbackAlt = null): string
    {
        if ($html === null || $html === '') {
            return '';
        }

        $html = preg_replace_callback(
            '/href="__ROUTE:([^"#]+)(#[^"]+)?__"/',
            static function (array $matches): string {
                $route = $matches[1];
                $anchor = $matches[2] ?? '';

                try {
                    $url = locale_route($route);
                } catch (\Throwable) {
                    return 'href="#"';
                }

                return 'href="'.e($url.$anchor).'"';
            },
            $html
        );

        return normalize_html_image_alts($html, $fallbackAlt);
    }
}

if (!function_exists('moruzzi_asset')) {

    function moruzzi_asset($path)
    {
        $localPath = public_path($path);

        if (file_exists($localPath)) {
            return asset($path);
        }

        return 'https://shop.moruzzi.it/' . ltrim($path, '/');
    }
}

if (!function_exists('product_seo_slug')) {

    /**
     * Slug URL prodotto: usa il campo url_key della scheda (come il sito legacy),
     * senza il suffisso -{entity_id} che viene aggiunto da product_url().
     */
    function product_seo_slug($product, ?string $locale = null): string
    {
        $entityId = (int) ($product->entity_id ?? 0);
        $urlKey = trim((string) ($product->url_key ?? ''));

        if ($urlKey !== '') {
            $suffix = '-'.$entityId;
            if ($entityId > 0 && str_ends_with($urlKey, $suffix)) {
                $urlKey = substr($urlKey, 0, -strlen($suffix));
            }

            return $urlKey;
        }

        $locale = $locale ?? app()->getLocale();
        $slugField = 'slug_'.$locale;
        $baseSlug = $product->$slugField ?? ($product->{'name_'.$locale} ?? $product->name);

        return \Illuminate\Support\Str::slug(
            \Illuminate\Support\Str::limit((string) $baseSlug, 160, '')
        );
    }
}

if (!function_exists('product_url')) {

    /**
     * URL canonico scheda prodotto.
     */
    function product_url($product, ?string $locale = null): string
    {
        if ($locale === null) {
            $locale = app()->getLocale();
            $firstSegment = request()->segment(1);
            if (in_array($firstSegment, ['en', 'es', 'fr', 'de'], true)) {
                $locale = $firstSegment;
            }
        }

        $prefix = ($locale === 'it') ? '' : $locale.'/';
        $slug = product_seo_slug($product, $locale);

        return url($prefix.$slug.'-'.$product->entity_id.'.html');
    }
}

if (!function_exists('product_video_src')) {

    /**
     * Normalizza il campo video prodotto (URL, embed o iframe HTML) in un URL riproducibile.
     */
    function product_video_src(?string $video): ?string
    {
        if ($video === null) {
            return null;
        }

        $video = trim($video);
        if ($video === '' || $video === ' ') {
            return null;
        }

        if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/i', $video, $m)) {
            $video = html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        } elseif (preg_match('/<embed[^>]+src=["\']([^"\']+)["\']/i', $video, $m)) {
            $video = html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        } elseif (! preg_match('#^https?://#i', $video) && preg_match('/src=["\']([^"\']+)["\']/i', $video, $m)) {
            $video = html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        $video = trim($video);
        if ($video === '') {
            return null;
        }

        if (str_starts_with($video, '//')) {
            $video = 'https:'.$video;
        }

        if (preg_match('#(?:youtube\.com/embed/|youtube-nocookie\.com/embed/)([a-zA-Z0-9_-]{11})#', $video, $m)) {
            return 'https://www.youtube.com/embed/'.$m[1];
        }

        if (preg_match('#(?:youtube\.com/watch\?(?:[^&]*&)*v=|youtu\.be/)([a-zA-Z0-9_-]{11})#', $video, $m)) {
            return 'https://www.youtube.com/embed/'.$m[1];
        }

        if (preg_match('#vimeo\.com/(?:video/)?(\d+)#', $video, $m)) {
            return 'https://player.vimeo.com/video/'.$m[1];
        }

        if (preg_match('#^https?://#i', $video)) {
            return $video;
        }

        return null;
    }
}

if (!function_exists('product_video_youtube_thumbnail')) {

    function product_video_youtube_thumbnail(?string $src): ?string
    {
        if (! $src) {
            return null;
        }

        if (preg_match('#(?:embed/|youtu\.be/|[?&]v=)([a-zA-Z0-9_-]{11})#', $src, $m)) {
            return 'https://img.youtube.com/vi/'.$m[1].'/hqdefault.jpg';
        }

        return null;
    }
}

if (!function_exists('product_video_fancybox_type')) {

    function product_video_fancybox_type(string $src): string
    {
        if (preg_match('#\.(mp4|webm|ogv|ogg)(\?.*)?$#i', $src)) {
            return 'html5video';
        }

        return 'iframe';
    }
}

if (!function_exists('product_video_media')) {

    /**
     * @return array{type: string, src: string, thumb: ?string, fancybox_type: string}|null
     */
    function product_video_media(?string $video): ?array
    {
        $src = product_video_src($video);
        if (! $src) {
            return null;
        }

        return [
            'type' => 'video',
            'src' => $src,
            'thumb' => product_video_youtube_thumbnail($src),
            'fancybox_type' => product_video_fancybox_type($src),
        ];
    }
}

if (! function_exists('cache_remember_safe')) {

    /**
     * Cache::remember resistente a errori del file store
     * (cartelle mancanti / permessi su storage/framework/cache/data).
     * In caso di fallimento esegue comunque il callback senza bloccare la pagina.
     *
     * @template T
     * @param  \Closure(): T  $callback
     * @return T
     */
    function cache_remember_safe(string $key, mixed $ttl, \Closure $callback): mixed
    {
        try {
            return cache()->remember($key, $ttl, $callback);
        } catch (\Throwable $e) {
            report($e);

            return $callback();
        }
    }
}

if (!function_exists('product_image_url')) {

    /**
     * URL immagine prodotto su Cloudflare R2.
     *
     * @param  string|null  $path  Percorso DB relativo (es. "2024/12/foto.jpg")
     * @param  string  $size  full|thumb|xs
     */
    function product_image_url(?string $path, string $size = 'full'): string
    {
        return app(\App\Services\ProductImageService::class)->url($path, $size);
    }
}

if (!function_exists('category_image_url')) {

    /**
     * URL immagine categoria da admin/img_up/categorie/.
     *
     * @param  string|null  $filename  Nome file nel DB (es. "monete_greche.png")
     * @param  string  $size  full|thumb|xs  (thumb: s_ poi xs_ poi originale)
     */
    function category_image_url(?string $filename, string $size = 'full'): string
    {
        if (empty($filename)) {
            return '';
        }

        $filename = ltrim(str_replace('\\', '/', $filename), '/');
        $base = 'admin/img_up/categorie/';

        $prefixes = match ($size) {
            'thumb' => ['s_', 'xs_'],
            'xs' => ['xs_'],
            default => [],
        };

        foreach ($prefixes as $prefix) {
            $path = $base . $prefix . $filename;
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        return moruzzi_asset($base . $filename);
    }
}

if (!function_exists('category_has_visible_image')) {

    /**
     * True se esiste almeno una variante locale dell'immagine categoria.
     */
    function category_has_visible_image(?string $filename): bool
    {
        if (empty($filename)) {
            return false;
        }

        $filename = ltrim(str_replace('\\', '/', $filename), '/');
        $dir = public_path('admin/img_up/categorie/');

        foreach (['s_', 'xs_', ''] as $prefix) {
            if (is_file($dir . $prefix . $filename)) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('category_link_alternates')) {

    /**
     * Varianti URL categoria per apostrofi (d'oltremare ↔ d-oltremare, dell'Europa ↔ dell-europa).
     *
     * @return list<string>
     */
    function category_link_alternates(string $link): array
    {
        $alternates = [$link];
        $pairs = [
            '-doltremare' => '-d-oltremare',
            '-d-oltremare' => '-doltremare',
            '-delleuropa' => '-dell-europa',
            '-dell-europa' => '-delleuropa',
            '-dell-impero-romano' => '-dellimpero-romano',
            '-dellimpero-romano' => '-dell-impero-romano',
        ];

        foreach ($pairs as $from => $to) {
            if (str_contains($link, $from)) {
                $alternates[] = str_replace($from, $to, $link);
            }
        }

        return array_values(array_unique($alternates));
    }
}

if (!function_exists('resolve_category_by_link')) {

    function resolve_category_by_link(string $fullLink, ?string $locale = null): ?\App\Models\Category
    {
        $locale = $locale ?? app()->getLocale();
        $linkColumn = 'link_' . $locale;

        foreach (category_link_alternates($fullLink) as $candidate) {
            $category = \App\Models\Category::where($linkColumn, $candidate)->first()
                ?? \App\Models\Category::where('link_it', $candidate)->first();

            if ($category) {
                return $category;
            }
        }

        $prefix = preg_replace('/\.html$/i', '', ltrim(str_replace('\\', '/', $fullLink), '/'));
        if ($prefix === '') {
            return null;
        }

        $child = \App\Models\Category::query()
            ->where($linkColumn, 'like', $prefix.'/%')
            ->orderBy('level')
            ->first();

        if ($child === null) {
            return null;
        }

        $expectedLevel = substr_count($prefix, '/') + 2;
        $node = $child;

        while ($node && (int) $node->level > $expectedLevel && (int) $node->parent_id > 0) {
            $node = \App\Models\Category::query()
                ->where('entity_id', $node->parent_id)
                ->first();
        }

        return ($node && (int) $node->level === $expectedLevel) ? $node : null;
    }
}

if (! function_exists('locale_number_format')) {

    /**
     * Formatta un numero secondo le convenzioni del paese principale della lingua attiva.
     *
     * it/de/es → 1.234,56 | en → 1,234.56 | fr → 1 234,56
     */
    function locale_number_format(float|int|string|null $value, int $decimals = 2, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $value = (float) ($value ?? 0);

        [$decimal, $thousands] = match ($locale) {
            'en' => ['.', ','],
            'fr' => [',', ' '],
            default => [',', '.'],
        };

        return number_format($value, $decimals, $decimal, $thousands);
    }
}

if (! function_exists('format_price')) {

    /**
     * Prezzo in euro con separatore decimale/migliaia localizzato.
     */
    function format_price(float|int|string|null $value, ?string $locale = null): string
    {
        return locale_number_format($value, 2, $locale).' €';
    }
}

if (! function_exists('field_placeholder')) {

    /**
     * Etichetta campo per placeholder, con asterisco se obbligatorio.
     */
    function field_placeholder(string $translationKey, bool $required = true): string
    {
        $label = __($translationKey);

        if (! $required) {
            return $label;
        }

        return trim($label).' '.__('general.required_mark');
    }
}

if (! function_exists('normalize_mail_locale')) {

    /**
     * Normalizza la lingua per l'invio delle email transazionali.
     */
    function normalize_mail_locale(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $available = ['it', 'en', 'fr', 'de', 'es'];

        return in_array($locale, $available, true) ? $locale : 'it';
    }
}

if (! function_exists('category_url')) {

    /**
     * URL canonico di una categoria catalogo (es. monete.html, en/coins.html).
     */
    function category_url(int $entityId, ?string $locale = null): string
    {
        $locale = normalize_mail_locale($locale);
        $category = \App\Models\Category::query()
            ->select(['entity_id', 'link_it', 'link_en', 'link_fr', 'link_de', 'link_es'])
            ->where('entity_id', $entityId)
            ->first();

        if (! $category) {
            return url('/');
        }

        $link = $category->{'link_'.$locale} ?? $category->link_it;
        $prefix = $locale === 'it' ? '' : $locale.'/';

        return url($prefix.ltrim((string) $link, '/'));
    }
}

if (! function_exists('email_time_cell')) {

    /**
     * Testo orario per email: evita auto-link iOS Mail (data detectors) che ereditano stili dei bottoni.
     */
    function email_time_cell(string $text): string
    {
        $text = e($text);

        return str_replace(
            [':', '.'],
            ['&#8203;:', '&#8203;.'],
            $text
        );
    }
}

if (! function_exists('email_asset')) {

    /**
     * URL assoluto per asset usati nelle email (logo, icone, immagini).
     */
    function email_asset(string $path): string
    {
        return rtrim(config('app.url'), '/').'/'.ltrim($path, '/');
    }
}
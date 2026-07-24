@php
    $availableLocales = ['en', 'es', 'fr', 'de'];
    $segment = request()->segment(1);
    $locale = in_array($segment, $availableLocales, true) ? $segment : 'it';
    app()->setLocale($locale);

    $homeUrl = $locale === 'it' ? url('/') : url('/'.$locale);
    $catalogSlug = (string) (config('localized_slugs.catalog.index.'.$locale) ?: 'catalogo');
    $catalogUrl = $locale === 'it' ? url('/'.$catalogSlug) : url('/'.$locale.'/'.$catalogSlug);
    $contactSlug = (string) (config('localized_slugs.contact.form.'.$locale) ?: 'contatti');
    $contactUrl = $locale === 'it' ? url('/'.$contactSlug) : url('/'.$locale.'/'.$contactSlug);

    $title = __('errors.404.meta_title').' | '.config('app.name');
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ __('errors.404.meta_description') }}">
    <base href="{{ rtrim(config('app.url'), '/') }}/">
    <link rel="icon" type="image/png" href="/images/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="shortcut icon" href="/images/favicon/favicon.ico">
    <link rel="preload" href="/fonts/Inria_Serif/InriaSerif-Regular.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="/fonts/fonts.css">
    <style>
        :root {
            --black: #2d2d2d;
            --blackLight: #5f5f5f;
            --red: #802810;
            --background: #e7e0d4;
            --dirtyWhite: #FFFDF5;
        }
        * { box-sizing: border-box; }
        html, body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }
        body {
            background: var(--background);
            color: var(--black);
            font-family: 'Inria Sans', 'Segoe UI', sans-serif;
            font-size: 18px;
            line-height: 1.5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }
        .error-minimal {
            width: 100%;
            max-width: 560px;
            text-align: center;
        }
        .error-minimal__logo {
            display: inline-block;
            margin-bottom: 36px;
        }
        .error-minimal__logo img {
            display: block;
            height: 56px;
            width: auto;
        }
        .error-minimal__code {
            font-family: 'Inria Serif', Georgia, serif;
            font-size: clamp(4rem, 14vw, 6.5rem);
            line-height: 1;
            color: var(--red);
            margin: 0 0 8px;
        }
        h1 {
            font-family: 'Inria Serif', Georgia, serif;
            font-size: clamp(1.6rem, 4vw, 2.2rem);
            font-weight: 400;
            margin: 0 0 12px;
            color: var(--black);
        }
        .error-minimal__message {
            margin: 0 0 28px;
            color: var(--blackLight);
        }
        .error-minimal__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            justify-content: center;
            margin-bottom: 36px;
        }
        .morButton {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 180px;
            min-height: 40px;
            padding: 8px 24px;
            border-radius: 20px;
            text-decoration: none;
            color: var(--black);
            background: var(--dirtyWhite);
            box-shadow: 4px 4px 8px 2px rgb(0 0 0 / 0.2);
            font-family: 'DM Mono', ui-monospace, monospace;
            font-size: 15px;
            font-weight: 300;
            transition: background 0.25s ease, color 0.25s ease;
        }
        .morButton:hover {
            background: var(--blackLight);
            color: #fff;
        }
        .morButton2 {
            background: var(--red);
            color: #fff;
        }
        .morButton2:hover {
            background: var(--black);
            color: #fff;
        }
        .error-minimal__contacts {
            border-top: 1px solid rgba(45, 45, 45, 0.18);
            padding-top: 24px;
            font-size: 15px;
            color: var(--blackLight);
        }
        .error-minimal__contacts strong {
            display: block;
            color: var(--black);
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 16px;
        }
        .error-minimal__contacts a {
            color: var(--black);
            text-decoration: none;
        }
        .error-minimal__contacts a:hover {
            color: var(--red);
        }
        .error-minimal__contacts p {
            margin: 0 0 4px;
        }
    </style>
</head>
<body>
    <main class="error-minimal">
        <a class="error-minimal__logo" href="{{ $homeUrl }}" title="Moruzzi Numismatica">
            <img src="{{ asset('images/logo_r.png') }}" alt="Moruzzi Numismatica" width="200" height="56">
        </a>

        <div class="error-minimal__code" aria-hidden="true">404</div>
        <h1>{{ __('errors.404.heading') }}</h1>
        <p class="error-minimal__message">{{ __('errors.404.message') }}</p>

        <div class="error-minimal__actions">
            <a href="{{ $homeUrl }}" class="morButton morButton2">{{ __('errors.404.home') }}</a>
            <a href="{{ $catalogUrl }}" class="morButton">{{ __('errors.404.catalog') }}</a>
        </div>

        <div class="error-minimal__contacts">
            <strong>Moruzzi Numismatica</strong>
            <p>Viale dei Salesiani, 12a — 00175 Roma</p>
            <p>
                <a href="tel:+390671510220">+39 0671510220</a>
                ·
                <a href="tel:+390671545937">+39 0671545937</a>
            </p>
            <p><a href="{{ $contactUrl }}">{{ __('errors.404.contacts') }}</a></p>
        </div>
    </main>
</body>
</html>

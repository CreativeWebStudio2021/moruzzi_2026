@php
    $locale = app()->getLocale();
    $homeUrl = locale_route('home');
    $title = __('product.gone.meta_title').' | '.config('app.name');
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ __('product.gone.meta_description') }}">
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
        .gone-page {
            width: 100%;
            max-width: 560px;
            text-align: center;
        }
        .gone-page__logo {
            display: inline-block;
            margin-bottom: 36px;
        }
        .gone-page__logo img {
            display: block;
            height: 100px;
            width: auto;
        }
        .gone-page__code {
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
        .gone-page__message {
            margin: 0 0 28px;
            color: var(--blackLight);
        }
        .gone-page__actions {
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
    </style>
</head>
<body>
    <main class="gone-page">
        <a class="gone-page__logo" href="{{ $homeUrl }}" title="Moruzzi Numismatica">
            <img src="{{ asset('images/logo_r.png') }}" alt="Moruzzi Numismatica" width="200" height="56">
        </a>

        <div class="gone-page__code" aria-hidden="true">410</div>
        <h1>{{ __('product.gone.heading') }}</h1>
        <p class="gone-page__message">{{ __('product.gone.message') }}</p>

        <div class="gone-page__actions">
            @if(!empty($categoryUrl))
                <a href="{{ $categoryUrl }}" class="morButton morButton2">{{ __('product.gone.category') }}</a>
            @endif
            @if(!empty($newArrivalsUrl))
                <a href="{{ $newArrivalsUrl }}" class="morButton">{{ __('product.gone.new_arrivals') }}</a>
            @endif
            @if(!empty($sellUrl))
                <a href="{{ $sellUrl }}" class="morButton">{{ __('product.gone.sell') }}</a>
            @endif
            <a href="{{ $homeUrl }}" class="morButton">{{ __('product.gone.home') }}</a>
        </div>
    </main>
</body>
</html>

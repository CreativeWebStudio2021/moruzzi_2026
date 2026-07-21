@php
    $availableLocales = ['en', 'es', 'fr', 'de'];
    $segment = request()->segment(1);

    if (in_array($segment, $availableLocales, true)) {
        app()->setLocale($segment);
    } else {
        app()->setLocale('it');
    }

    Illuminate\Support\Facades\View::share('error_page', $errorCode);
@endphp

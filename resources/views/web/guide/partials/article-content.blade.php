@php
    $guidePage = __('guide.articles.' . $guideKey);
    $blocks = $guidePage['blocks'] ?? [];
@endphp

@if (! empty($blocks))
    @include('web.guide.partials.page-content', [
        'guideKey' => $guideKey,
        'guidePage' => $guidePage,
    ])
@else
    <p>{{ __('guide.content_pending') }}</p>
@endif

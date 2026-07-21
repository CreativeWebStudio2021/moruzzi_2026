@php
    $langConfiguration = [];

    foreach (config('iubenda.languages', []) as $iubendaLocale => $settings) {
        $appLocale = $settings['app_locale'] ?? $iubendaLocale;

        $langConfiguration[$iubendaLocale] = [
            'cookiePolicyId' => (int) ($settings['cookie_policy_id'] ?? config('iubenda.default_cookie_policy_id')),
            'cookiePolicyUrl' => route_url_for_locale('legal.cookie_policy', $appLocale),
        ];
    }
@endphp
<script type="text/javascript">
var _iub = _iub || [];
_iub.csConfiguration = {
    "siteId": {{ (int) config('iubenda.site_id') }},
    "cookiePolicyId": {{ (int) config('iubenda.default_cookie_policy_id') }}
};
_iub.csLangConfiguration = @json($langConfiguration, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
</script>
<script type="text/javascript" src="https://cs.iubenda.com/autoblocking/{{ (int) config('iubenda.site_id') }}.js"></script>
<script type="text/javascript" src="https://cdn.iubenda.com/cs/iubenda_cs.js" charset="UTF-8" async></script>

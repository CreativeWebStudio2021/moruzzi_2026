@php
    $turnstileSiteKey = app(\App\Services\TurnstileService::class)->siteKey();
    $turnstileAction = $action ?? 'form';
    $turnstileWidgetId = 'cf-turnstile-' . $turnstileAction . '-' . uniqid();
@endphp
@if($turnstileSiteKey)
    @once
        <link rel="preconnect" href="https://challenges.cloudflare.com">
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit" async defer></script>
        <script>
            window.moruzziTurnstile = window.moruzziTurnstile || {
                widgets: {},
                ready: function (fn) {
                    if (window.turnstile && typeof window.turnstile.render === 'function') {
                        fn();
                        return;
                    }
                    var tries = 0;
                    var timer = setInterval(function () {
                        tries++;
                        if (window.turnstile && typeof window.turnstile.render === 'function') {
                            clearInterval(timer);
                            fn();
                        } else if (tries > 80) {
                            clearInterval(timer);
                        }
                    }, 50);
                },
                bindForm: function (form, containerId, sitekey, action) {
                    var self = this;
                    this.ready(function () {
                        if (self.widgets[containerId]) {
                            return;
                        }
                        var pendingSubmit = false;
                        var widgetId = turnstile.render('#' + containerId, {
                            sitekey: sitekey,
                            size: 'invisible',
                            action: action,
                            callback: function () {
                                if (pendingSubmit) {
                                    pendingSubmit = false;
                                    if (typeof form.requestSubmit === 'function') {
                                        form.requestSubmit();
                                    } else {
                                        form.submit();
                                    }
                                }
                            }
                        });
                        self.widgets[containerId] = widgetId;

                        form.addEventListener('submit', function (event) {
                            var tokenInput = form.querySelector('[name="cf-turnstile-response"]');
                            var token = tokenInput ? tokenInput.value : '';
                            if (token) {
                                return;
                            }
                            event.preventDefault();
                            pendingSubmit = true;
                            try {
                                turnstile.execute(widgetId);
                            } catch (e) {
                                pendingSubmit = false;
                            }
                        });
                    });
                }
            };
        </script>
    @endonce

    <div id="{{ $turnstileWidgetId }}" class="moruzzi-turnstile-slot"></div>
    @if(isset($errors) && $errors->has('cf-turnstile-response'))
        <div class="register-errors" style="margin-top:12px; color:#dc2626; font-size:14px;">{{ $errors->first('cf-turnstile-response') }}</div>
    @endif
    <script>
        (function () {
            var form = document.currentScript.closest('form');
            if (!form || !window.moruzziTurnstile) return;
            window.moruzziTurnstile.bindForm(
                form,
                @json($turnstileWidgetId),
                @json($turnstileSiteKey),
                @json($turnstileAction)
            );
        })();
    </script>
@endif

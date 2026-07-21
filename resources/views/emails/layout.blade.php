<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <title>{{ $subject ?? 'Moruzzi Numismatica' }}</title>
    <!--[if mso]>
    <style type="text/css">
        table { border-collapse: collapse; }
        .header-logo-img { width: 231px !important; height: 69px !important; }
    </style>
    <![endif]-->
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@300;400&family=Inria+Sans:wght@400;600&family=Inria+Serif:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inria Sans', Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e7e0d4;
            color: #2d2d2d;
            font-size: 16px;
            line-height: 1.55;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fffdf5;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #e0d8cc;
        }
        .header {
            background-color: #802810;
            padding: 20px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        .header-social-cell {
            vertical-align: middle;
            text-align: right;
        }
        .social-icons {
            margin-top: 0;
            line-height: 0;
            font-size: 0;
        }
        .social-icons a {
            margin: 0 5px;
            display: inline-block;
        }
        .social-icons img {
            width: 40px;
            height: 40px;
        }
        .content {
            padding: 24px 28px;
        }
        .content h1,
        .content h2,
        .content h3 {
            font-family: 'Inria Serif', Georgia, 'Times New Roman', serif;
            font-style: italic;
            font-weight: 400;
            color: #802810;
            margin: 0 0 16px;
        }
        .content h1 {
            font-size: 22px;
            line-height: 1.25;
            text-align: center;
        }
        .content h3 {
            font-size: 24px;
            line-height: 1.2;
            text-align: center;
        }
        .order-info {
            background-color: #f3ede4;
            padding: 18px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .order-info p { margin: 5px 0; }
        .order-info a {
            color: #802810;
            font-weight: 600;
        }
        .order-confirmation {
            text-align: center;
            margin: 20px 0;
        }
        .order-confirmation img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .order-items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
            font-size: 14px;
        }
        .order-items-table th,
        .order-items-table td {
            padding: 8px;
            border: 1px solid #e0d8cc;
            vertical-align: middle;
        }
        .order-items-table thead th {
            background: #f3ede4;
        }
        .order-items-table .order-item-thumb {
            width: 56px;
            text-align: center;
        }
        .order-items-table .order-item-thumb img {
            width: 48px;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 4px;
        }
        .order-items-table .order-item-qty {
            width: 60px;
            text-align: center;
        }
        .order-items-table .order-item-price {
            width: 90px;
            text-align: right;
        }
        .menu {
            margin: 24px 0;
            text-align: center;
        }
        .menu a {
            display: inline-block;
            padding: 8px 16px;
            margin: 4px;
            color: #fffdf5;
            text-decoration: none;
            font-size: 14px;
            font-family: 'DM Mono', 'Courier New', monospace;
            font-weight: 300;
            letter-spacing: 0.02em;
            background: #802810;
            border-radius: 20px;
            line-height: 1.4;
            box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.18);
        }
        .email-hours {
            margin: 24px auto;
            text-align: center;
            max-width: 320px;
        }
        .email-hours h3 {
            font-family: 'Inria Serif', Georgia, 'Times New Roman', serif;
            font-style: italic;
            font-weight: 400;
            color: #802810;
            font-size: 24px;
            line-height: 1.2;
            margin: 0 0 16px;
        }
        .tabella-orari a,
        .tabella-orari a:link,
        .tabella-orari a:visited,
        .tabella-orari a:hover {
            color: inherit !important;
            text-decoration: none !important;
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            display: inline !important;
            font: inherit !important;
            letter-spacing: inherit !important;
        }
        .footer {
            background-color: #802810;
            text-align: center;
            padding: 18px 20px;
            font-size: 14px;
            color: #fffdf5;
            font-family: 'Inria Sans', Arial, Helvetica, sans-serif;
        }
        .footer a {
            color: #fffdf5;
            text-decoration: underline;
        }
        .footer-title {
            font-family: 'Inria Serif', Georgia, serif;
            font-style: italic;
            font-size: 18px;
        }
        .tabella-orari {
            width: auto;
            border-collapse: collapse;
            font-size: 12px;
            margin: 0 auto;
            font-family: 'Inria Sans', Arial, sans-serif;
        }
        .tabella-orari th,
        .tabella-orari td {
            border: 2px solid #e0d8cc;
            padding: 4px 8px;
            text-align: center;
            white-space: nowrap;
            line-height: 1.3;
        }
        .tabella-orari td:first-child {
            text-align: left;
            font-family: 'DM Mono', 'Courier New', monospace;
            font-size: 11px;
        }
        .tabella-orari th {
            background-color: #f3ede4;
            color: #802810;
            font-family: 'DM Mono', 'Courier New', monospace;
            font-size: 11px;
        }
        .divider {
            background: #802810;
            height: 2px;
            border: 0;
            margin: 24px 0;
        }
        @media (max-width: 600px) {
            .content { padding: 16px; }
            .content h1 { font-size: 19px; }
        }
    </style>
</head>
<body>
    @php
        $emailCategories = [
            'layout_menu_coins' => 963,
            'layout_menu_medals' => 964,
            'layout_menu_banknotes' => 965,
            'layout_menu_publications' => 966,
            'layout_menu_antiques' => 970,
            'layout_menu_accessories' => 971,
        ];
    @endphp
    <div class="email-container">
        <div class="header">
            <table class="header-table" role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td valign="middle" align="left" style="padding:0;margin:0;line-height:0;font-size:0;mso-line-height-rule:exactly;">
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="231" style="width:231px;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
                            <tr>
                                <td width="231" height="69" valign="top" align="left" style="width:231px;height:69px;padding:0;margin:0;line-height:0;font-size:0;mso-line-height-rule:exactly;overflow:hidden;">
                                    <a href="{{ rtrim(config('app.url'), '/') }}/" style="text-decoration:none;border:0;outline:none;">
                                        @php
                                            // Asset @2x (462x138): HTML resta 231x69 così resta nitido anche con scaling Windows ~110%
                                            $logoPath = public_path('images/logo_moruzzi_email@2x.png');
                                            if (! is_file($logoPath)) {
                                                $logoPath = public_path('images/logo_moruzzi_email.png');
                                            }
                                            $logoSrc = (isset($message) && is_file($logoPath))
                                                ? $message->embed($logoPath)
                                                : email_asset(str_replace(public_path().'/', '', $logoPath));
                                        @endphp
                                        <img
                                            class="header-logo-img"
                                            src="{{ $logoSrc }}"
                                            alt="Moruzzi Numismatica"
                                            width="231"
                                            height="69"
                                            border="0"
                                            style="display:block;border:0;outline:none;text-decoration:none;line-height:0;font-size:0;-ms-interpolation-mode:bicubic;"
                                        >
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="header-social-cell" valign="middle" align="right" style="padding:0;">
                        <div class="social-icons">
                            <a href="https://www.facebook.com/moruzzi.numismatica"><img src="{{ email_asset('images/icon-fb.png') }}" alt="Facebook" width="40" height="40" border="0" style="display:inline-block;border:0;"></a>
                            <a href="https://www.instagram.com/moruzzi_numismatica/?hl=it"><img src="{{ email_asset('images/icon-insta.png') }}" alt="Instagram" width="40" height="40" border="0" style="display:inline-block;border:0;"></a>
                            <a href="https://x.com/Moruzzi_Monete"><img src="{{ email_asset('images/icon-x.png') }}" alt="X" width="40" height="40" border="0" style="display:inline-block;border:0;"></a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        @yield('preinfo')

        @yield('image')

        @yield('content')

        @if ($showPrivacyFooter ?? true)
            <div class="content" style="padding-top:0;">
                <hr class="divider">
                <div class="menu">
                    <h3>{{ __('emails.layout_explore_title') }}</h3>
                    @foreach ($emailCategories as $labelKey => $categoryId)
                        <a href="{{ category_url($categoryId) }}">{{ __('emails.'.$labelKey) }}</a>
                    @endforeach
                </div>
                <hr class="divider">
                <div class="email-hours">
                    <h3>{{ __('emails.layout_hours_title') }}</h3>
                    <table class="tabella-orari" x-apple-data-detectors="false" role="presentation" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td></td>
                            <td x-apple-data-detectors="false">{!! __('emails.layout_hours_period_winter') !!}</td>
                            <td x-apple-data-detectors="false">{!! __('emails.layout_hours_period_summer') !!}</td>
                        </tr>
                        <tr><td x-apple-data-detectors="false">{{ __('emails.layout_day_monday') }}</td><td x-apple-data-detectors="false">{!! email_time_cell('15:30-19:00') !!}</td><td x-apple-data-detectors="false">{!! email_time_cell('11:00-14.00') !!}<br/>{!! email_time_cell('15:30-19:00') !!}</td></tr>
                        <tr><td x-apple-data-detectors="false">{{ __('emails.layout_day_tuesday') }}</td><td x-apple-data-detectors="false">{!! email_time_cell('11:00-14.00') !!}<br/>{!! email_time_cell('15:30-19:00') !!}</td><td x-apple-data-detectors="false">{!! email_time_cell('11:00-14.00') !!}<br/>{!! email_time_cell('15:30-19:00') !!}</td></tr>
                        <tr><td x-apple-data-detectors="false">{{ __('emails.layout_day_wednesday') }}</td><td x-apple-data-detectors="false">{!! email_time_cell('11:00-14.00') !!}<br/>{!! email_time_cell('15:30-19:00') !!}</td><td x-apple-data-detectors="false">{!! email_time_cell('11:00-14.00') !!}<br/>{!! email_time_cell('15:30-19:00') !!}</td></tr>
                        <tr><td x-apple-data-detectors="false">{{ __('emails.layout_day_thursday') }}</td><td x-apple-data-detectors="false">{!! email_time_cell('11:00-14.00') !!}<br/>{!! email_time_cell('15:30-19:00') !!}</td><td x-apple-data-detectors="false">{!! email_time_cell('11:00-14.00') !!}<br/>{!! email_time_cell('15:30-19:00') !!}</td></tr>
                        <tr><td x-apple-data-detectors="false">{{ __('emails.layout_day_friday') }}</td><td x-apple-data-detectors="false">{!! email_time_cell('11:00-14.00') !!}<br/>{!! email_time_cell('15:30-19:00') !!}</td><td x-apple-data-detectors="false">{!! email_time_cell('11:00-14.00') !!}<br/>{!! email_time_cell('15:30-19:00') !!}</td></tr>
                        <tr><td x-apple-data-detectors="false">{{ __('emails.layout_day_saturday') }}</td><td x-apple-data-detectors="false">{!! email_time_cell('11:00-14.00') !!}<br/>{!! email_time_cell('15:30-19:00') !!}</td><td x-apple-data-detectors="false">{!! email_time_cell('11:00-14.00') !!}</td></tr>
                    </table>
                </div>
                <hr class="divider">
                <div class="order-info" style="margin-top:0;">
                    <p style="font-size:12px; margin:0;">
                        {!! __('emails.layout_privacy_notice') !!}
                    </p>
                </div>
            </div>
        @endif

        <div class="footer">
            <span class="footer-title">Moruzzi Numismatica</span><br>
            Viale dei Salesiani, 12a Roma 00175<br>
            @php $siteEmail = config('mail.from.address'); @endphp
            @if($siteEmail)
                Email: <a href="mailto:{{ $siteEmail }}" style="text-decoration:none">{{ $siteEmail }}</a> -
            @endif
            Tel: <a href="tel:+390671510220" style="text-decoration:none">+39 06 71510220</a><br/>
            <a href="{{ locale_route('contact.form') }}">{{ __('emails.layout_store_hours_link') }}</a><br/>
            <a href="{{ rtrim(config('app.url'), '/') }}/">{{ __('emails.layout_visit_site') }}</a>
        </div>
    </div>
</body>
</html>

<?php

if (! defined('MORUZZI_EMAIL_BRAND_BOOTSTRAP')) {
    define('MORUZZI_EMAIL_BRAND_BOOTSTRAP', true);

    $laravelRoot = dirname(__DIR__, 3);
    require_once $laravelRoot.'/vendor/autoload.php';
    $app = require $laravelRoot.'/bootstrap/app.php';
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
}

$mail_site_base = rtrim(($http ?? config('app.url', 'https://www.moruzzi.it')), '/');
if (! str_contains($mail_site_base, '://')) {
    $mail_site_base = rtrim(($http ?? 'https').'://'.($ind_sito ?? 'www.moruzzi.it'), '/');
}

if (! function_exists('moruzzi_admin_email_asset')) {
    function moruzzi_admin_email_asset(string $path): string
    {
        global $mail_site_base;

        return $mail_site_base.'/'.ltrim($path, '/');
    }
}

if (! function_exists('moruzzi_admin_email_styles')) {
    function moruzzi_admin_email_styles(): string
    {
        return <<<'CSS'
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
        }
        .header-social-cell {
            vertical-align: middle;
            text-align: right;
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
        .order-info p {
            margin: 5px 0;
        }
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
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
            font-size: 14px;
        }
        .order-table th,
        .order-table td {
            padding: 8px;
            border: 1px solid #e0d8cc;
            vertical-align: top;
        }
        .order-table th {
            background: #f3ede4;
            text-align: left;
            color: #802810;
            font-family: 'Inria Serif', Georgia, serif;
            font-style: italic;
            font-weight: 400;
        }
        .order-table td.qty,
        .order-table th.qty {
            text-align: center;
            width: 60px;
        }
        .order-table td.price,
        .order-table th.price {
            text-align: right;
            width: 90px;
        }
        .totals-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .totals-table td {
            padding: 6px 8px;
        }
        .totals-table td:last-child {
            text-align: right;
            white-space: nowrap;
        }
        .totals-table tr.total-row td {
            border-top: 2px solid #802810;
            font-weight: bold;
            padding-top: 10px;
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
        CSS;
    }
}

if (! function_exists('moruzzi_admin_email_header_html')) {
    function moruzzi_admin_email_header_html(): string
    {
        global $mail_site_base;
        $logo = moruzzi_admin_email_asset('images/logo_moruzzi_email@2x.png');

        return '
        <div class="header">
            <table class="header-table" role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td valign="middle" align="left">
                        <a href="'.htmlspecialchars($mail_site_base.'/', ENT_QUOTES, 'UTF-8').'" style="text-decoration:none;border:0;">
                            <img src="'.$logo.'" alt="Moruzzi Numismatica" width="231" height="69" border="0" style="display:block;border:0;max-width:231px;height:auto;">
                        </a>
                    </td>
                    <td class="header-social-cell" valign="middle" align="right">
                        <div class="social-icons">
                            <a href="https://www.facebook.com/moruzzi.numismatica"><img src="'.moruzzi_admin_email_asset('images/icon-fb.png').'" alt="Facebook" width="40" height="40"></a>
                            <a href="https://www.instagram.com/moruzzi_numismatica/?hl=it"><img src="'.moruzzi_admin_email_asset('images/icon-insta.png').'" alt="Instagram" width="40" height="40"></a>
                            <a href="https://x.com/Moruzzi_Monete"><img src="'.moruzzi_admin_email_asset('images/icon-x.png').'" alt="X" width="40" height="40"></a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>';
    }
}

if (! function_exists('moruzzi_admin_email_footer_html')) {
    function moruzzi_admin_email_footer_html(bool $showPrivacy = true): string
    {
        global $mail_site_base;
        $categories = [
            ['Monete', 963],
            ['Medaglie', 964],
            ['Banconote', 965],
            ['Pubblicazioni', 966],
            ['Antiquariato', 970],
            ['Accessori', 971],
        ];

        $menuLinks = '';
        foreach ($categories as [$label, $id]) {
            $url = function_exists('category_url') ? category_url($id, 'it') : moruzzi_admin_email_asset('');
            $menuLinks .= '<a href="'.htmlspecialchars($url, ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars($label, ENT_QUOTES, 'UTF-8').'</a>';
        }

        $privacy = '';
        if ($showPrivacy) {
            $privacy = '
            <div class="content" style="padding-top:0;">
                <hr class="divider">
                <div class="menu">
                    <h3>Esplora il nostro sito</h3>
                    '.$menuLinks.'
                </div>
                <hr class="divider">
                <div class="menu" style="max-width:320px;margin-left:auto;margin-right:auto;">
                    <h3>Orari del negozio</h3>
                    <table class="tabella-orari">
                        <tr>
                            <td></td>
                            <td>dal 1° ottobre<br/>al 31 maggio</td>
                            <td>dal 1° giugno<br/>al 30 settembre</td>
                        </tr>
                        <tr><td>LUNEDÌ</td><td>15:30-19:00</td><td>11:00-14.00<br/>15:30-19:00</td></tr>
                        <tr><td>MARTEDÌ</td><td>11:00-14.00<br/>15:30-19:00</td><td>11:00-14.00<br/>15:30-19:00</td></tr>
                        <tr><td>MERCOLEDÌ</td><td>11:00-14.00<br/>15:30-19:00</td><td>11:00-14.00<br/>15:30-19:00</td></tr>
                        <tr><td>GIOVEDÌ</td><td>11:00-14.00<br/>15:30-19:00</td><td>11:00-14.00<br/>15:30-19:00</td></tr>
                        <tr><td>VENERDÌ</td><td>11:00-14.00<br/>15:30-19:00</td><td>11:00-14.00<br/>15:30-19:00</td></tr>
                        <tr><td>SABATO</td><td>11:00-14.00<br/>15:30-19:00</td><td>11:00-14.00</td></tr>
                    </table>
                </div>
                <hr class="divider">
                <div class="order-info" style="margin-top:0;">
                    <p style="font-size:12px;margin:0;">
                        P.S. questa email è stata spedita automaticamente dal nostro sistema informatico.<br>
                        Avviso di riservatezza - Il testo e gli eventuali documenti trasmessi contengono informazioni riservate al destinatario indicato.
                        La seguente e-mail è confidenziale e la sua riservatezza è tutelata dal GDPR 679/16.
                    </p>
                </div>
            </div>';
        }

        $siteEmail = config('mail.from.address', 'info@moruzzi.it');
        $contactUrl = function_exists('locale_route') ? locale_route('contact.form') : moruzzi_admin_email_asset('contatti');

        return $privacy.'
        <div class="footer">
            <span class="footer-title">Moruzzi Numismatica</span><br>
            Viale dei Salesiani, 12a Roma 00175<br>
            Email: <a href="mailto:'.$siteEmail.'" style="text-decoration:none">'.$siteEmail.'</a> -
            Tel: <a href="tel:+390671510220" style="text-decoration:none">+39 06 71510220</a><br/>
            <a href="'.$contactUrl.'">Vedi gli orari del negozio</a><br/>
            <a href="'.htmlspecialchars($mail_site_base.'/', ENT_QUOTES, 'UTF-8').'">Visita il nostro sito</a>
        </div>';
    }
}

<?php

require __DIR__.'/email_brand.inc.php';

$showPrivacy = ! isset($email_privacy) || (int) $email_privacy === 1;

$body = '<!DOCTYPE html>
<html lang="it">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Moruzzi Numismatica</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@300;400&family=Inria+Sans:wght@400;600&family=Inria+Serif:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
<style>'.moruzzi_admin_email_styles().'</style>
</head>
<body>
<div class="email-container">';

$body .= moruzzi_admin_email_header_html();

if (! empty($preinfo ?? '')) {
    $body .= '
    <div class="content" style="padding-bottom:0">
        <div class="order-info">'.$preinfo.'</div>
    </div>';
}

if (! empty($emailImg ?? '')) {
    $imgAlt = htmlspecialchars($emailImgAlt ?? '', ENT_QUOTES, 'UTF-8');
    $imgSrc = moruzzi_admin_email_asset('images/'.basename($emailImg));
    $body .= '
    <div class="content" style="padding-top:0;padding-bottom:0">
        <div class="order-confirmation">
            <img src="'.$imgSrc.'" alt="'.$imgAlt.'">
        </div>
    </div>';
}

if (! empty($testo1 ?? '')) {
    $body .= '
    <div class="content" style="padding-top:0">
        <h1>Comunicazione evasione ordine</h1>
        <div class="order-info">'.$testo1.'</div>
    </div>';
}

if (! empty($riepilogo_ordine)) {
    $body .= '
    <div class="content" style="padding-top:0">
        <h3>Riepilogo dell\'ordine</h3>
        <table class="order-table">
            <thead>
                <tr>
                    <th style="width:56px"></th>
                    <th>Prodotto</th>
                    <th class="qty">Qt.</th>
                    <th class="price">Prezzo</th>
                </tr>
            </thead>
            <tbody>
                '.($email_lista_prodotti ?? '').'
            </tbody>
        </table>
        <div class="order-info">
            <table class="totals-table">';

    if (! empty($email_peso)) {
        $body .= '
                <tr>
                    <td>Peso</td>
                    <td>'.htmlspecialchars((string) $email_peso, ENT_QUOTES, 'UTF-8').' Kg</td>
                </tr>';
    }
    if (! empty($email_tot_parziale)) {
        $body .= '
                <tr>
                    <td>Totale parziale</td>
                    <td>€'.htmlspecialchars((string) $email_tot_parziale, ENT_QUOTES, 'UTF-8').'</td>
                </tr>';
    }
    if (! empty($email_spedizione)) {
        $body .= '
                <tr>
                    <td>Spedizione</td>
                    <td>€'.htmlspecialchars((string) $email_spedizione, ENT_QUOTES, 'UTF-8').'</td>
                </tr>';
    }
    if (! empty($email_totale)) {
        $body .= '
                <tr class="total-row">
                    <td>Totale</td>
                    <td>€'.htmlspecialchars((string) $email_totale, ENT_QUOTES, 'UTF-8').'</td>
                </tr>';
    }

    $body .= '
            </table>
        </div>
    </div>';
}

if (! empty($email_dati_cliente)) {
    $body .= '
    <div class="content" style="padding-top:0">
        <h3>Dati cliente</h3>
        <div class="order-info">
            <p><strong>Spedizione:</strong></p>
            <p>
                '.htmlspecialchars(($email_nome ?? '').' '.($email_cognome ?? ''), ENT_QUOTES, 'UTF-8').'<br>
                '.htmlspecialchars($email_indirizzo ?? '', ENT_QUOTES, 'UTF-8').'<br>
                '.htmlspecialchars(($email_cap ?? '').' '.($email_citta ?? ''), ENT_QUOTES, 'UTF-8').', '.htmlspecialchars($email_nazione ?? '', ENT_QUOTES, 'UTF-8').'<br>
                E-mail: '.htmlspecialchars($email_email ?? '', ENT_QUOTES, 'UTF-8');

    if (! empty($email_telefono)) {
        $body .= '<br>Telefono: '.htmlspecialchars($email_telefono, ENT_QUOTES, 'UTF-8');
    }
    if (! empty($email_cod_fiscale)) {
        $body .= '<br>Codice Fiscale: '.htmlspecialchars($email_cod_fiscale, ENT_QUOTES, 'UTF-8');
    }
    if (! empty($email_azienda)) {
        $body .= '<br>Nome Azienda: '.htmlspecialchars($email_azienda, ENT_QUOTES, 'UTF-8');
    }
    if (! empty($email_piva)) {
        $body .= '<br>P. Iva: '.htmlspecialchars($email_piva, ENT_QUOTES, 'UTF-8');
    }
    if (! empty($email_sdu)) {
        $body .= '<br>PEC o Codice Destinatario: '.htmlspecialchars($email_sdu, ENT_QUOTES, 'UTF-8');
    }

    $body .= '
            </p>
            <p><strong>Metodo di spedizione:</strong> '.htmlspecialchars($email_metodo_sped ?? '', ENT_QUOTES, 'UTF-8').'</p>
            <p><strong>Metodo di pagamento:</strong> '.htmlspecialchars($email_metodo_pag ?? '', ENT_QUOTES, 'UTF-8').'</p>
        </div>
    </div>';
}

if (! empty($email_dati_bonifico)) {
    $body .= '
    <div class="content" style="padding-top:0;padding-bottom:0">
        <div class="order-info">
            <p><strong>DATI PER EFFETTUARE IL BONIFICO:</strong></p>
            <p>'.($beneficiario_bonifico ?? '').'</p>
        </div>
    </div>';
}

if (! empty($email_note)) {
    $body .= '
    <div class="content" style="padding-top:0;padding-bottom:0">
        <div class="order-info">
            <p><strong>Note:</strong></p>
            <p>'.nl2br(htmlspecialchars($email_note, ENT_QUOTES, 'UTF-8')).'</p>
        </div>
    </div>';
}

$body .= moruzzi_admin_email_footer_html($showPrivacy);
$body .= '</div></body></html>';

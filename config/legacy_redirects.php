<?php

/**
 * Redirect 301 da URL legacy www.moruzzi.it (.html root e cartelle lang*) verso il nuovo sito.
 *
 * Valori supportati per ogni file:
 * - ['route' => 'about.presentation']  → path da config/localized_slugs.php
 * - ['route' => 'home']
 * - ['path' => '/monete.html']         → path fisso (stessa lingua)
 * - opzionale 'anchor' => 'dove-siamo'
 */
return [
    'lang_folder_map' => [
        'lang1' => 'fr',
        'lang2' => 'en',
        'lang3' => 'es',
        'lang5' => 'de',
        'lang4' => 'en',
        'lang6' => 'en',
    ],

    'folder_roots' => [
        'lang1' => '/',
        'lang2' => '/en/',
        'lang3' => '/es/',
        'lang4' => '/en/',
        'lang5' => '/de/',
        'lang6' => '/fr/',
    ],

    'files' => [
        'index.html' => ['route' => 'home'],
        'home.html' => ['route' => 'home'],
        'home1.html' => ['route' => 'home'],

        'cipresentiamo.html' => ['route' => 'about.presentation'],
        'who_we_are.html' => ['route' => 'about.presentation'],
        'qui_sommes_nous.html' => ['route' => 'about.presentation'],
        'wer_wir_sind.html' => ['route' => 'about.presentation'],
        'quem-somos.html' => ['route' => 'about.presentation'],

        'lostaff.html' => ['route' => 'about.staff'],
        'the-staff.html' => ['route' => 'about.staff'],
        'le-personnel.html' => ['route' => 'about.staff'],
        'das-personal.html' => ['route' => 'about.staff'],
        'el-personal.html' => ['route' => 'about.staff'],
        'o-pessoal.html' => ['route' => 'about.staff'],

        'loredana_moruzzi.html' => ['route' => 'about.loredana'],
        'umberto_moruzzi.html' => ['route' => 'about.umberto'],
        'nicola_mecci.html' => ['route' => 'about.nicola'],
        'hiroko_blue_lynx.html' => ['route' => 'about.hiroko'],
        'francesca_barenghi.html' => ['route' => 'about.francesca'],
        'francesca-barenghi.html' => ['route' => 'about.francesca'],

        'le_nostre_pubblicazioni.html' => ['route' => 'about.publications'],
        'dicono_di_noi.html' => ['route' => 'about.press'],
        'memberships.html' => ['route' => 'about.memberships'],

        'certificato-online.html' => ['route' => 'certifications.online'],
        'online-certification.html' => ['route' => 'certifications.online'],
        'certification_en_ligne.html' => ['route' => 'certifications.online'],
        'online-zertifikat.html' => ['route' => 'certifications.online'],
        'certificacion-en-linea.html' => ['route' => 'certifications.online'],
        'certificacao-on-line.html' => ['route' => 'certifications.online'],
        'ricerca-certificato-online.html' => ['route' => 'certifications.online'],
        'ricerca-online-il-tuo-certificato.html' => ['route' => 'certifications.online'],

        'certificazione_di_qualita_moruzzi.html' => ['route' => 'certifications.quality'],
        'la_garanzia_moruzzi_numismatica.html' => ['route' => 'certifications.guarantee'],
        'gli_attestati_di_garanzia_e_provenienza.html' => ['route' => 'certifications.attestati'],
        'standard_qualitativo.html' => ['route' => 'certifications.standard'],
        'upgrade_della_qualita.html' => ['route' => 'certifications.upgrade'],
        'stime_perizie_monete.html' => ['route' => 'certifications.estimates_coins'],
        'stime_perizie_banconote.html' => ['route' => 'certifications.estimates_banknotes'],
        'perizie_monete.html' => ['route' => 'certifications.expertise_coins'],
        'perizie_banconote.html' => ['route' => 'certifications.expertise_banknotes'],
        'valutazione_monete_banconote.html' => ['route' => 'certifications.valuation'],
        'catalogazioni_monete_banconote.html' => ['route' => 'certifications.cataloguing'],

        'come_vendere.html' => ['route' => 'sell.how'],
        'how_to_sell.html' => ['route' => 'sell.how'],
        'comme_vendre.html' => ['route' => 'sell.how'],
        'wie_verkaufen.html' => ['route' => 'sell.how'],
        'como_vender.html' => ['route' => 'sell.how'],
        'como-vender.html' => ['route' => 'sell.how'],

        'vendita_moruzzi_numismatica.html' => ['route' => 'sell.to_moruzzi'],
        'oggi_compriamo.html' => ['route' => 'sell.today_buy'],
        'oggi_compriamo1.html' => ['route' => 'sell.today_buy'],

        'tutto_il_negozio.html' => ['route' => 'catalog.index'],
        'the_complete_shop.html' => ['route' => 'catalog.index'],
        'tout_le_magasin.html' => ['route' => 'catalog.index'],

        'condizioni_di_vendita.html' => ['route' => 'shop.terms'],
        'le_abbreviazioni_per_le_monete.html' => ['route' => 'shop.abbreviations'],
        'collezionare_monete_antiche_in_italia.html' => ['route' => 'shop.collecting'],

        'privacy.html' => ['route' => 'legal.privacy'],
        'privacy-policy.html' => ['route' => 'legal.privacy'],
        'privacy_policy.html' => ['route' => 'legal.privacy'],
        'note_legali.html' => ['route' => 'legal.privacy'],
        'cookie_policy.html' => ['route' => 'legal.cookie_policy'],

        'registrazione.html' => ['route' => 'account.register.page'],
        'dove_siamo.html' => ['route' => 'about.presentation', 'anchor' => 'dove-siamo'],
        'interagisci_con_noi.html' => ['route' => 'contact.form'],
        'imsitemap.html' => ['route' => 'sitemap'],

        'i_nostri_orari.html' => ['route' => 'contact.form', 'anchor' => 'orari'],
        'per_telefono.html' => ['route' => 'contact.form', 'anchor' => 'orari'],
        'our_business_hours.html' => ['route' => 'contact.form', 'anchor' => 'orari'],
        'nos_horaires.html' => ['route' => 'contact.form', 'anchor' => 'orari'],
        'nuestros_horarios.html' => ['route' => 'contact.form', 'anchor' => 'orari'],
        'os-nossos-horarios.html' => ['route' => 'contact.form', 'anchor' => 'orari'],

        'il_nostro_ebay.html' => ['route' => 'contact.form', 'anchor' => 'ebay'],
        'our_ebay.html' => ['route' => 'contact.form', 'anchor' => 'ebay'],
        'notre_ebay.html' => ['route' => 'contact.form', 'anchor' => 'ebay'],
        'nuestro_ebay.html' => ['route' => 'contact.form', 'anchor' => 'ebay'],
        'unser_ebay.html' => ['route' => 'contact.form', 'anchor' => 'ebay'],
        'o-nosso-ebay.html' => ['route' => 'contact.form', 'anchor' => 'ebay'],

        'offerte_speciali.html' => ['path' => 'offerte-speciali.html'],

        'tutto_citta.html' => ['route' => 'about.presentation', 'anchor' => 'dove-siamo'],
        'google_maps.html' => ['route' => 'about.presentation', 'anchor' => 'dove-siamo'],
        'rss_feed_news.html' => ['route' => 'home'],
        'registrazione_newsletter.html' => ['route' => 'home'],
        'registrazione_alla_newsletter.html' => ['route' => 'home'],
        'grazie_di_averci_contattato.html' => ['route' => 'contact.thankyou'],
        'moruzzi_numismatica_facebook_twitter.html' => ['route' => 'contact.form'],
        'moruzzi_numismatica_facebook.html' => ['route' => 'contact.form'],
        'determinazione-del-prezzo-di-vendita-di-monete-banconote-e-medaglie.html' => ['route' => 'certifications.valuation'],
    ],
];

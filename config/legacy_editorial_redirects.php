<?php

/**
 * Redirect editoriali legacy aggiuntivi (lang, staff, pagine puntuali).
 * I pattern IT generici sono in LegacyEditorialRedirectResolver.
 */
return [
    'files' => [
        // Staff legacy (GSC 404)
        'fabio_scatolini.html' => ['route' => 'about.staff'],
        'claudia_maresca.html' => ['route' => 'about.staff'],
        'alessia_costantino.html' => ['route' => 'about.staff'],
        'lieutenantsy.html' => ['route' => 'about.staff'],

        // Lang — guida / shop / contatti
        'state_of_preservation_of_coins.html' => ['route' => 'guide.conservation'],
        'el_estado_de_conservacion_de_las_monedas.html' => ['route' => 'guide.conservation'],
        'abbreviations_concerning_coins.html' => ['route' => 'shop.abbreviations'],
        'abreviaturas_para_monedas.html' => ['route' => 'shop.abbreviations'],
        'die_abkurzungen_der_munzen.html' => ['route' => 'shop.abbreviations'],
        'our_location.html' => ['route' => 'about.presentation', 'anchor' => 'dove-siamo'],
        'papal_medals.html' => ['paths' => ['en' => 'medals.html']],
        'el_marengo.html' => ['route' => 'guide.marengo'],
        'la_libra_esterlina_inglese.html' => ['route' => 'guide.sovereign'],
        'el_tetradracma_de_alejandro_magno.html' => ['route' => 'guide.tetradrachm_alexander'],
        'o-napoleao.html' => ['route' => 'guide.international_overview'],
        'victor-manuel-ii.html' => ['route' => 'guide.veii'],

        // Idee regalo / pagine varie
        'idee-regalo.html' => ['route' => 'catalog.index'],
        'faq__haufig_gestellte_fragen.html' => ['route' => 'guide.faq'],
        'monete-euro-rare-commemorative.html' => ['path' => 'monete/euro.html'],
        'monete-romane-imperiali.html' => ['path' => 'monete/monete-dellimpero-romano.html'],
        'monete_romane_imperiali.html' => ['path' => 'monete/monete-dellimpero-romano.html'],
        'monete-di-pupieno.html' => ['path' => 'monete/monete-dell-impero-romano/coniazioni-di-balbino-e-pupieno.html'],
        'monete-di-balbino.html' => ['path' => 'monete/monete-dell-impero-romano/coniazioni-di-balbino-e-pupieno.html'],
    ],
];

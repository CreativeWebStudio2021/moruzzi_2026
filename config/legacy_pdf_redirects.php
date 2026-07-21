<?php

/**
 * Redirect 301 per PDF legacy (cataloghi asta, articoli, pop-up).
 * Se il file esiste in public/, viene servito normalmente.
 */
return [
    'folders' => [
        'download/2006_pdf' => ['route' => 'guide.medals_collection_2006'],
        'download/2007_pdf' => ['route' => 'catalog.index'],
        'download/2008_pdf' => ['route' => 'catalog.index'],
        'download/2002_pdf' => ['route' => 'catalog.index'],
        'pop_up' => ['route' => 'about.publications'],
    ],

    'files' => [
        'la-moneta-che-riscrive-la-data-della-eruzione-del-vesuvio.pdf' => ['route' => 'about.publications'],
        'workshop numismatico_programma.pdf' => ['route' => 'about.publications'],
    ],

    'prefix_defaults' => [
        'download/' => ['route' => 'catalog.index'],
    ],
];

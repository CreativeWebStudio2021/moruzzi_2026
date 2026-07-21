<?php

/**
 * Collegamenti bidirezionali guida ↔ catalogo.
 *
 * - article_categories: articolo guida → entity_id categorie (carosello prodotti)
 * - article_catalog_category: categoria principale per il link «Vedi tutti in catalogo»
 * - category_guides: categoria catalogo → articoli guida (link informativi)
 *
 * Gli articoli in excluded_articles restano solo nel menu guida.
 */
$imperialGuides = ['imperial_titles', 'denarius_imperial', 'rome_in_coins'];

$imperialSubcategoryGuides = [
    1136 => $imperialGuides,
    1096 => $imperialGuides,
    1093 => $imperialGuides,
    1114 => $imperialGuides,
    1092 => $imperialGuides,
    1068 => $imperialGuides,
    1060 => $imperialGuides,
    1102 => $imperialGuides,
    1062 => $imperialGuides,
    1040 => ['ara_pacis', 'imperial_titles', 'denarius_imperial'],
    1042 => $imperialGuides,
    1041 => ['roman_women_augustae', 'imperial_titles', 'denarius_imperial'],
    1046 => $imperialGuides,
    1098 => $imperialGuides,
    1063 => $imperialGuides,
    1047 => $imperialGuides,
    1048 => $imperialGuides,
    1049 => $imperialGuides,
    1061 => $imperialGuides,
    1094 => $imperialGuides,
    1073 => $imperialGuides,
    1097 => $imperialGuides,
    1050 => $imperialGuides,
    1051 => $imperialGuides,
    1052 => $imperialGuides,
    1210 => $imperialGuides,
    1053 => $imperialGuides,
    1278 => $imperialGuides,
    1043 => $imperialGuides,
    1044 => $imperialGuides,
    1045 => $imperialGuides,
    1037 => $imperialGuides,
    1074 => $imperialGuides,
    1064 => $imperialGuides,
    1035 => $imperialGuides,
    1036 => $imperialGuides,
    1065 => $imperialGuides,
    1038 => $imperialGuides,
    1039 => $imperialGuides,
    1034 => $imperialGuides,
    1066 => $imperialGuides,
    1101 => $imperialGuides,
    1099 => $imperialGuides,
    1116 => $imperialGuides,
    1100 => $imperialGuides,
    1086 => $imperialGuides,
    1067 => ['domitianus', 'giovino_solidus', 'imperial_titles'],
    1287 => ['spintriae', 'imperial_titles', 'denarius_imperial'],
    1115 => ['rome_in_coins', 'byzantine_solidus', 'international_overview'],
];

$baseCategoryGuides = [    // Macro-aree
    963 => ['international_overview', 'rome_in_coins'],
    965 => ['banknote_history', 'paper_money_europe'],
    982 => ['republican_rome', 'denarius_republican', 'rome_in_coins'],
    979 => ['imperial_titles', 'denarius_imperial', 'aureus'],
    980 => ['tetradrachm_athens', 'tetradrachm_alexander', 'international_overview'],
    1008 => ['byzantine_solidus', 'international_overview'],
    1010 => ['rome_in_coins', 'international_overview'],
    978 => ['veiii', 'umberto_i', 'veii'],
    984 => ['repubblica_italiana'],
    977 => ['banknote_history', 'banca_romana', 'veiii'],
    993 => ['paper_money_europe'],
    976 => ['paper_money_overseas'],
    964 => ['birth_of_medal'],
    975 => ['birth_of_medal', 'medals_collection_2006'],
    987 => ['international_overview', 'florin', 'ducat'],
    992 => ['international_overview', 'dollar'],
    985 => ['euro', 'repubblica_italiana'],
    986 => ['veii', 'international_overview'],
    983 => ['veii', 'umberto_i'],
    972 => ['rome_in_coins', 'imperial_titles'],
    988 => ['repubblica_italiana'],
    991 => ['international_overview'],

    // Repubblica romana (sottocategorie)
    1075 => ['republican_rome', 'denarius_republican', 'rome_in_coins'],
    1057 => ['republican_rome', 'denarius_republican', 'aes_rude_signatum'],

    // Grecia
    1054 => ['tetradrachm_alexander', 'tetradrachm_athens', 'international_overview'],
    1089 => ['stater_corinth', 'tetradrachm_athens', 'international_overview'],
    1188 => ['international_overview'],

    // Regno d'Italia (monete)
    1069 => ['veii'],
    1070 => ['umberto_i'],
    1032 => ['veiii'],
    1183 => ['veiii', 'veii'],
    1397 => ['marengo'],

    // Banconote italiane per periodo
    1030 => ['veii', 'banknote_history'],
    1026 => ['umberto_i', 'banknote_history'],
    1027 => ['veiii', 'banknote_history'],
    1028 => ['rsi', 'banknote_history'],
    1103 => ['luogotenenza', 'banknote_history'],
    1029 => ['repubblica_italiana', 'banknote_history'],
    1237 => ['banknote_history', 'banca_romana'],
    1390 => ['banca_romana'],

    // Monete internazionali per area
    1079 => ['spanish_8_escudos', 'spanish_8_reales'],
    1123 => ['dollar'],
    1080 => ['pound_sterling'],
    1104 => ['five_franc_scudo'],
    1184 => ['leeuwenndaalder'],
    1131 => ['taler'],
    1081 => ['taler', 'florin'],
    1139 => ['taler', 'ducat'],
    1400 => ['marengo'],
];

return [
    'product_limit' => 8,
    'guide_link_limit' => 3,

    'excluded_articles' => [
        'index',
        'intro_numismatica',
        'investment',
        'bibliography',
        'faq',
        'conservation',
        'rarity',
        'fakes',
        'cork_coins',
        'watches',
        'banknote_conservation',
        'banknote_abbreviations',
        'abbreviations',
        'collecting_ancient',
    ],

    'article_categories' => [
        // Monete antiche romane
        'rome_in_coins' => [982, 979],
        'aes_rude_signatum' => [982, 979],
        'republican_rome' => [982],
        'imperial_titles' => [979],
        'roman_women_augustae' => [979],
        'spintriae' => [1287, 979],
        'ara_pacis' => [1040, 979],
        'temple_janus' => [979],
        'domitianus' => [1067, 979],
        'giovino_solidus' => [1067, 979],

        // Collezioni italiane
        'veii' => [1069, 1030],
        'umberto_i' => [1070, 1026],
        'veiii' => [1032, 1027],
        'rsi' => [1028],
        'luogotenenza' => [1103],
        'repubblica_italiana' => [984, 1029],

        // Monete internazionali
        'international_overview' => [987, 992],
        'tetradrachm_athens' => [1054, 980],
        'stater_corinth' => [1089, 980],
        'tetradrachm_alexander' => [1054, 980],
        'denarius_republican' => [982],
        'denarius_imperial' => [979],
        'aureus' => [979],
        'byzantine_solidus' => [1008],
        'florin' => [987],
        'ducat' => [987],
        'taler' => [1131, 987],
        'leeuwenndaalder' => [1184],
        'spanish_8_escudos' => [1079],
        'spanish_8_reales' => [1079],
        'dollar' => [1123],
        'marengo' => [1397, 978],
        'five_franc_scudo' => [1104],
        'pound_sterling' => [1080],
        'euro' => [985],

        // Banconote e medaglie
        'birth_of_medal' => [964, 975],
        'banknote_history' => [977],
        'banca_romana' => [1390, 977],
        'paper_money_europe' => [993],
        'paper_money_overseas' => [976],
        'medals_collection_2006' => [975],
    ],

    'article_catalog_category' => [
        'rome_in_coins' => 979,
        'aes_rude_signatum' => 982,
        'republican_rome' => 982,
        'imperial_titles' => 979,
        'roman_women_augustae' => 979,
        'spintriae' => 1287,
        'ara_pacis' => 1040,
        'temple_janus' => 979,
        'domitianus' => 1067,
        'giovino_solidus' => 1067,
        'veii' => 1069,
        'umberto_i' => 1070,
        'veiii' => 1032,
        'rsi' => 1028,
        'luogotenenza' => 1103,
        'repubblica_italiana' => 984,
        'tetradrachm_athens' => 1054,
        'stater_corinth' => 1089,
        'tetradrachm_alexander' => 1054,
        'marengo' => 1397,
        'banca_romana' => 1390,
        'birth_of_medal' => 964,
        'medals_collection_2006' => 975,
    ],

    'category_guides' => $baseCategoryGuides + $imperialSubcategoryGuides,
];
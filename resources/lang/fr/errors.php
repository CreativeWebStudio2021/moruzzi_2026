<?php

return [
    '404' => [
        'meta_title' => 'Page introuvable',
        'meta_description' => 'La page demandée n’existe pas ou n’est plus disponible.',
        'heading' => 'Page introuvable',
        'message' => 'La page que vous recherchez n’existe pas, a été supprimée ou l’adresse saisie est incorrecte.',
        'home' => 'Retour à l’accueil',
        'catalog' => 'Parcourir le catalogue',
        'contacts' => 'Contact',
    ],
    '500' => [
        'meta_title' => 'Erreur serveur',
        'meta_description' => 'Une erreur temporaire s’est produite. Veuillez réessayer dans un instant.',
        'heading' => 'Erreur serveur',
        'message' => 'Un problème est survenu sur notre site. Nous travaillons à le résoudre : réessayez dans un instant ou revenez à l’accueil.',
        'home' => 'Retour à l’accueil',
        'contact' => 'Nous contacter',
    ],
    '503' => [
        'meta_title' => 'Service indisponible',
        'meta_description' => 'Le site est temporairement indisponible. Veuillez réessayer plus tard.',
        'heading' => 'Service indisponible',
        'message' => 'Le site est momentanément inaccessible en raison d’une maintenance ou d’une forte affluence. Veuillez réessayer dans quelques minutes.',
        'home' => 'Retour à l’accueil',
        'retry' => 'Réessayer',
    ],
];

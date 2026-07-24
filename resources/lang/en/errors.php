<?php

return [
    '404' => [
        'meta_title' => 'Page not found',
        'meta_description' => 'The page you requested does not exist or is no longer available.',
        'heading' => 'Page not found',
        'message' => 'The page you are looking for does not exist, has been removed, or the address entered is incorrect.',
        'home' => 'Back to home',
        'catalog' => 'Browse the catalog',
        'contacts' => 'Contacts',
    ],
    '500' => [
        'meta_title' => 'Server error',
        'meta_description' => 'A temporary error occurred. Please try again in a moment.',
        'heading' => 'Server error',
        'message' => 'Something went wrong on our site. We are working to fix the issue: please try again shortly or return to the home page.',
        'home' => 'Back to home',
        'contact' => 'Contact us',
    ],
    '503' => [
        'meta_title' => 'Service unavailable',
        'meta_description' => 'The site is temporarily unavailable. Please try again later.',
        'heading' => 'Service unavailable',
        'message' => 'The site is temporarily unreachable due to maintenance or high traffic. Please try again in a few minutes.',
        'home' => 'Back to home',
        'retry' => 'Try again',
    ],
];

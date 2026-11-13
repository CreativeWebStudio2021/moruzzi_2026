<?php

namespace App\Services\Seo;

final class OrganizationJsonLdBuilder
{
    /**
     * @return array<string, mixed>
     */
    public function organization(): array
    {
        return [
            '@type' => 'Organization',
            'name' => 'Moruzzi Numismatica',
            'url' => url('/'),
            'logo' => url('images/logo_r.png'),
            'email' => 'info@moruzzi.it',
            'telephone' => '+39 0671510220',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Viale dei Salesiani 12a',
                'addressLocality' => 'Roma',
                'postalCode' => '00175',
                'addressCountry' => 'IT',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function websiteWithOrganization(): array
    {
        $organization = $this->organization();
        $organization['@id'] = rtrim(url('/'), '/').'#organization';

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                $organization,
                [
                    '@type' => 'WebSite',
                    '@id' => rtrim(url('/'), '/').'#website',
                    'name' => 'Moruzzi Numismatica',
                    'url' => url('/'),
                    'inLanguage' => ['it', 'en', 'es', 'fr', 'de'],
                    'publisher' => [
                        '@id' => $organization['@id'],
                    ],
                ],
            ],
        ];
    }
}

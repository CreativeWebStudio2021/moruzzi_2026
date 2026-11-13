<?php

namespace App\Services\Seo;

final class BreadcrumbJsonLdBuilder
{
    /**
     * @param  list<array{name: string, url: ?string}>  $items  Ordine dalla root alla leaf.
     *                                                          url null = pagina corrente.
     * @return array<string, mixed>|null
     */
    public function build(array $items, ?string $currentUrl = null): ?array
    {
        $list = [];
        $position = 1;

        $list[] = [
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __('catalog.home'),
            'item' => locale_route('home'),
        ];

        foreach ($items as $item) {
            $name = trim((string) ($item['name'] ?? ''));
            if ($name === '') {
                continue;
            }

            $entry = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $name,
            ];

            $url = $item['url'] ?? null;
            if (is_string($url) && $url !== '') {
                $entry['item'] = $url;
            } elseif ($currentUrl) {
                $entry['item'] = $currentUrl;
            }

            $list[] = $entry;
        }

        if (count($list) < 2) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $list,
        ];
    }
}

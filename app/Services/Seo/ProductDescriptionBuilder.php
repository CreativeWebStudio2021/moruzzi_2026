<?php

namespace App\Services\Seo;

use App\Models\Product;

/**
 * Compone paragrafi descrittivi nelle 5 lingue usando solo attributi estratti dal DB.
 * Non inventa dati mancanti.
 */
class ProductDescriptionBuilder
{
    public function __construct(
        private readonly ProductAttributeExtractor $extractor,
    ) {}

    /**
     * @return array<string, string> locale => HTML paragraph(s)
     */
    public function buildAllLocales(Product $product): array
    {
        $attrs = $this->extractor->extractAll(
            (string) ($product->name ?? ''),
            (string) ($product->short_description ?? ''),
            (string) ($product->description ?? '')
        );

        $filled = array_filter($attrs, fn (string $v) => $v !== '');
        // Serve almeno nome + 2 attributi per evitare testo troppo povero
        if (count($filled) < 2) {
            return [];
        }

        $name = trim((string) ($product->name ?? ''));
        if ($name === '') {
            return [];
        }

        $out = [];
        foreach (['it', 'en', 'fr', 'de', 'es'] as $locale) {
            $html = $this->compose($locale, $name, $attrs);
            if ($html !== '') {
                $out[$locale] = $html;
            }
        }

        return $out;
    }

    /**
     * @param  array<string, string>  $attrs
     */
    private function compose(string $locale, string $name, array $attrs): string
    {
        $parts = [];
        $parts[] = $this->intro($locale, $name, $attrs);
        $tech = $this->technical($locale, $attrs);
        if ($tech !== '') {
            $parts[] = $tech;
        }
        $refs = $this->references($locale, $attrs);
        if ($refs !== '') {
            $parts[] = $refs;
        }

        $parts = array_values(array_filter($parts));
        if ($parts === []) {
            return '';
        }

        return '<p>'.implode('</p><p>', array_map('e', $parts)).'</p>';
    }

    /**
     * @param  array<string, string>  $attrs
     */
    private function intro(string $locale, string $name, array $attrs): string
    {
        $emission = $attrs['emission'] ?? '';
        $mint = $attrs['mint'] ?? '';
        $metal = $attrs['metal'] ?? '';

        return match ($locale) {
            'en' => trim(sprintf(
                '%s%s%s%s.',
                $name,
                $emission !== '' ? ', issued '.$emission : '',
                $mint !== '' ? ', mint: '.$mint : '',
                $metal !== '' ? ', metal: '.$metal : ''
            ), ' .'),
            'fr' => trim(sprintf(
                '%s%s%s%s.',
                $name,
                $emission !== '' ? ', émission '.$emission : '',
                $mint !== '' ? ', atelier : '.$mint : '',
                $metal !== '' ? ', métal : '.$metal : ''
            ), ' .'),
            'de' => trim(sprintf(
                '%s%s%s%s.',
                $name,
                $emission !== '' ? ', Emission '.$emission : '',
                $mint !== '' ? ', Münzstätte: '.$mint : '',
                $metal !== '' ? ', Metall: '.$metal : ''
            ), ' .'),
            'es' => trim(sprintf(
                '%s%s%s%s.',
                $name,
                $emission !== '' ? ', emisión '.$emission : '',
                $mint !== '' ? ', ceca: '.$mint : '',
                $metal !== '' ? ', metal: '.$metal : ''
            ), ' .'),
            default => trim(sprintf(
                '%s%s%s%s.',
                $name,
                $emission !== '' ? ', emissione '.$emission : '',
                $mint !== '' ? ', zecca di '.$mint : '',
                $metal !== '' ? ', metallo: '.$metal : ''
            ), ' .'),
        };
    }

    /**
     * @param  array<string, string>  $attrs
     */
    private function technical(string $locale, array $attrs): string
    {
        $bits = [];
        if (($attrs['weight'] ?? '') !== '') {
            $bits[] = match ($locale) {
                'en' => 'weight '.$attrs['weight'],
                'fr' => 'poids '.$attrs['weight'],
                'de' => 'Gewicht '.$attrs['weight'],
                'es' => 'peso '.$attrs['weight'],
                default => 'peso '.$attrs['weight'],
            };
        }
        if (($attrs['diameter'] ?? '') !== '') {
            $bits[] = match ($locale) {
                'en' => 'diameter '.$attrs['diameter'],
                'fr' => 'diamètre '.$attrs['diameter'],
                'de' => 'Durchmesser '.$attrs['diameter'],
                'es' => 'diámetro '.$attrs['diameter'],
                default => 'diametro '.$attrs['diameter'],
            };
        }
        if (($attrs['mintage'] ?? '') !== '') {
            $bits[] = match ($locale) {
                'en' => 'mintage '.$attrs['mintage'],
                'fr' => 'tirage '.$attrs['mintage'],
                'de' => 'Auflage '.$attrs['mintage'],
                'es' => 'tirada '.$attrs['mintage'],
                default => 'tiratura '.$attrs['mintage'],
            };
        }
        if (($attrs['grade'] ?? '') !== '') {
            $bits[] = match ($locale) {
                'en' => 'grade '.$attrs['grade'],
                'fr' => 'conservation '.$attrs['grade'],
                'de' => 'Erhaltung '.$attrs['grade'],
                'es' => 'conservación '.$attrs['grade'],
                default => 'conservazione '.$attrs['grade'],
            };
        }

        if ($bits === []) {
            return '';
        }

        $joined = implode(', ', $bits);

        return match ($locale) {
            'en' => 'Technical data: '.$joined.'.',
            'fr' => 'Données techniques : '.$joined.'.',
            'de' => 'Technische Daten: '.$joined.'.',
            'es' => 'Datos técnicos: '.$joined.'.',
            default => 'Dati tecnici: '.$joined.'.',
        };
    }

    /**
     * @param  array<string, string>  $attrs
     */
    private function references(string $locale, array $attrs): string
    {
        if (($attrs['bibliography'] ?? '') === '') {
            return '';
        }

        return match ($locale) {
            'en' => 'Catalogue reference: '.$attrs['bibliography'].'.',
            'fr' => 'Référence de catalogue : '.$attrs['bibliography'].'.',
            'de' => 'Katalogreferenz: '.$attrs['bibliography'].'.',
            'es' => 'Referencia de catálogo: '.$attrs['bibliography'].'.',
            default => 'Riferimento di catalogo: '.$attrs['bibliography'].'.',
        };
    }
}

<?php

namespace App\Services\Seo;

/**
 * Estrae proprietà numismatiche dal testo editoriale (short_description / name).
 * Non inventa valori: se il pattern non matcha, la proprietà viene omessa.
 */
final class ProductAttributeExtractor
{
    /**
     * @return list<array{name: string, value: string}>
     */
    public function additionalProperties(string $name, string $shortDescription, string $description = ''): array
    {
        $attrs = $this->extractAll($name, $shortDescription, $description);
        $labels = [
            'emission' => 'Anno / emissione',
            'mint' => 'Zecca',
            'metal' => 'Metallo',
            'weight' => 'Peso',
            'diameter' => 'Diametro',
            'mintage' => 'Tiratura',
            'grade' => 'Conservazione',
            'bibliography' => 'Riferimento di catalogo',
        ];

        $props = [];
        foreach ($labels as $key => $label) {
            if (($attrs[$key] ?? '') !== '') {
                $props[] = ['name' => $label, 'value' => $attrs[$key]];
            }
        }

        return $props;
    }

    /**
     * Attributi grezzi estratti solo dal testo presente (nessun valore inventato).
     *
     * @return array{
     *   emission: string,
     *   mint: string,
     *   metal: string,
     *   weight: string,
     *   diameter: string,
     *   mintage: string,
     *   grade: string,
     *   bibliography: string
     * }
     */
    public function extractAll(string $name, string $shortDescription, string $description = ''): array
    {
        $plain = $this->plainText($shortDescription.' '.$description.' '.$name);

        return [
            'emission' => $this->extractEmission($plain),
            'mint' => $this->extractMint($plain),
            'metal' => $this->extractMetal($plain),
            'weight' => $this->extractWeight($plain),
            'diameter' => $this->extractDiameter($plain),
            'mintage' => $this->extractMintage($plain),
            'grade' => $this->extractGrade($plain),
            'bibliography' => $this->extractBibliography($plain),
        ];
    }

    private function plainText(string $html): string
    {
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', $text) ?? '';

        return trim($text);
    }

    private function extractEmission(string $text): string
    {
        if (preg_match('/Emissione:\s*([^;,\n]+)/i', $text, $m)) {
            return trim($m[1]);
        }

        return '';
    }

    private function extractMint(string $text): string
    {
        if (preg_match('/Zecca di\s*([^;,\n]+)/i', $text, $m)) {
            return trim($m[1]);
        }

        return '';
    }

    private function extractMetal(string $text): string
    {
        if (preg_match('/Metallo:\s*([A-Za-z]{1,10})/i', $text, $m)) {
            return $this->metalLabel(strtoupper($m[1]));
        }

        return '';
    }

    private function metalLabel(string $code): string
    {
        return match ($code) {
            'AE', 'BRONZO' => 'bronzo',
            'CU', 'RAME', 'RAMO' => 'rame',
            'AR', 'AG', 'ARGENTO' => 'argento',
            'AU', 'ORO' => 'oro',
            'NI', 'NIKEL' => 'nikel',
            default => strtolower($code),
        };
    }

    private function extractBibliography(string $text): string
    {
        if (preg_match('/Rif\.\s*bibl\.\s*([^;\n]+)/i', $text, $m)) {
            return trim(preg_replace('/\s+/', ' ', $m[1]) ?? '');
        }

        if (preg_match('/\((Pagani|Casolari|Muenzkatalog|Crapanzano|R\.?I\.?C\.?|Cohen|Montenegro)[^)]*\)/i', $text, $m)) {
            return trim(str_replace(['(', ')'], '', $m[0]));
        }

        return '';
    }

    private function extractGrade(string $text): string
    {
        if (preg_match('/\b(mSPL|qSPL|qFDC|qBB|SPL|BB|MB|FDS|FDC|UNC|AU|VF|EF)\b/i', $text, $m)) {
            return strtoupper($m[1]);
        }

        return '';
    }

    private function extractWeight(string $text): string
    {
        if (preg_match('/(?:gr\.?|g\.?)\s*([0-9]+(?:[.,][0-9]+)?)/i', $text, $m)) {
            return str_replace(',', '.', $m[1]).' g';
        }
        if (preg_match('/peso[:\s]+([0-9]+(?:[.,][0-9]+)?)\s*(?:gr|g)\b/i', $text, $m)) {
            return str_replace(',', '.', $m[1]).' g';
        }

        return '';
    }

    private function extractDiameter(string $text): string
    {
        if (preg_match('/(?:Diam\.?|diametro)[:\s]*mm\.?\s*([0-9]+(?:[.,][0-9]+)?)/i', $text, $m)) {
            return str_replace(',', '.', $m[1]).' mm';
        }
        if (preg_match('/\bmm\.?\s*([0-9]+(?:[.,][0-9]+)?)/i', $text, $m)) {
            return str_replace(',', '.', $m[1]).' mm';
        }

        return '';
    }

    private function extractMintage(string $text): string
    {
        if (preg_match('/[Tt]iratura[:\s]+([0-9][0-9\.\,\s]*[0-9]|[0-9]+)/u', $text, $m)) {
            return trim(preg_replace('/\s+/', ' ', $m[1]) ?? '');
        }

        return '';
    }
}

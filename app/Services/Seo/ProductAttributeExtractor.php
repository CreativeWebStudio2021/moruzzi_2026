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
        $plain = $this->plainText($shortDescription.' '.$description.' '.$name);
        $props = [];

        $year = $this->extractEmission($plain);
        if ($year !== '') {
            $props[] = ['name' => 'Anno / emissione', 'value' => $year];
        }

        $mint = $this->extractMint($plain);
        if ($mint !== '') {
            $props[] = ['name' => 'Zecca', 'value' => $mint];
        }

        $metal = $this->extractMetal($plain);
        if ($metal !== '') {
            $props[] = ['name' => 'Metallo', 'value' => $metal];
        }

        $grade = $this->extractGrade($plain);
        if ($grade !== '') {
            $props[] = ['name' => 'Conservazione', 'value' => $grade];
        }

        $biblio = $this->extractBibliography($plain);
        if ($biblio !== '') {
            $props[] = ['name' => 'Riferimento di catalogo', 'value' => $biblio];
        }

        return $props;
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
}

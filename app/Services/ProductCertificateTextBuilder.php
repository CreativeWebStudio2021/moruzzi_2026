<?php

namespace App\Services;

use App\Models\Product;

class ProductCertificateTextBuilder
{
    /**
     * Compone il testo descrittivo del certificato a partire dai dati prodotto.
     */
    public function build(Product $product): string
    {
        $plainDescription = $this->plainText((string) ($product->description ?? ''));
        $plainShort = $this->plainText((string) ($product->short_description ?? ''));
        $combined = trim($plainDescription."\n".$plainShort);

        $sku = trim((string) ($product->sku ?? ''));
        $type = $this->detectType((string) $product->name, $combined);
        $article = $this->articleForType($type);
        $gender = $type === 'banconota' ? 'o' : 'a';

        $identification = $this->buildIdentification((string) $product->name, $combined);
        $faces = $this->buildFacesClause($plainDescription);
        $metal = $this->extractMetal($combined);
        $weight = $this->extractWeight($combined);
        $diameter = $this->extractDiameter($combined);
        $mint = $this->extractMint($combined);
        $biblio = $this->extractBibliography($combined);
        $grade = $this->extractGrade($combined);
        $rarity = $this->extractRarity($combined);

        $parts = [];
        $parts[] = sprintf(
            '%s %s, identificat%s con codice %s, %s',
            $article,
            $type,
            $gender,
            $sku,
            rtrim($identification, '. ')
        );

        if ($faces !== '') {
            $parts[0] .= ', '.$faces;
        }

        if ($mint !== '' && $type === 'moneta') {
            $parts[0] .= ', della zecca di '.$mint;
        }

        if ($metal !== '') {
            $parts[0] .= ', è in '.$metal;
        } else {
            $parts[0] .= ', è';
        }

        if ($weight !== null) {
            $parts[0] .= ', del peso di grammi '.$this->formatDecimal($weight);
        }

        if ($diameter !== null && $type !== 'banconota') {
            $parts[0] .= ' e diametro di millimetri '.$this->formatDecimal($diameter);
        }

        $parts[0] .= '.';

        $specimenParts = [];
        if ($rarity !== '') {
            $specimenParts[] = $rarity;
        }
        if ($biblio !== '') {
            $specimenParts[] = 'con riferimenti bibliografici '.$biblio;
        }

        $specimen = 'L\'esemplare';
        if ($specimenParts !== []) {
            $specimen .= ', '.implode(', ', $specimenParts);
        }
        $specimen .= '; è garantito autentico e di conservazione '.$this->gradePhrase($grade).'.';

        $parts[] = $specimen;

        return implode(' ', $parts);
    }

    public function legalFooter(int $registryNumber, string $type): string
    {
        $subject = match ($type) {
            'medaglia' => 'La medaglia',
            'banconota' => 'Il biglietto',
            default => 'La moneta',
        };

        return sprintf(
            '%s è di lecita provenienza ai sensi del Decreto Legislativo 22 gennaio 2004, n. 42 \'Codice dei beni culturali e del paesaggio\'. La provenienza è iscritta al n. %d del Registro del Commercio di cui all\'articolo n. 242 del Regolamento di Pubblica Sicurezza R.D. n. 635 del 6 Maggio 1940.',
            $subject,
            $registryNumber
        );
    }

    public function stripLegalFooter(string $text): string
    {
        return trim((string) preg_replace(
            '/\s*(La\s+(?:moneta|medaglia)|Il\s+biglietto)\s+è\s+di\s+lecita\s+provenienza\s+ai\s+sensi\s+del\s+Decreto\s+Legislativo\s+22\s+gennaio\s+2004,\s*n\.\s*42.*$/iu',
            '',
            $text
        ));
    }

    /**
     * @return array{core_body: string, legal_footer: string, body_text: string}
     */
    public function composeBody(Product $product, ?string $editedBody, int $registryNumber): array
    {
        $combined = trim($this->plainText((string) ($product->description ?? '')));
        $type = $this->detectType((string) $product->name, $combined);
        $coreBody = $editedBody !== null && $editedBody !== ''
            ? $this->stripLegalFooter($editedBody)
            : trim($this->build($product));

        $legalFooter = $registryNumber > 0 ? $this->legalFooter($registryNumber, $type) : '';
        $bodyText = $legalFooter !== '' ? trim($coreBody.'  '.$legalFooter) : $coreBody;

        return [
            'core_body' => $coreBody,
            'legal_footer' => $legalFooter,
            'body_text' => $bodyText,
        ];
    }

    public function detectType(string $name, string $combined = ''): string
    {
        $haystack = strtoupper($name.' '.$combined);

        if (str_contains($haystack, 'MEDAGLIA')) {
            return 'medaglia';
        }

        if (str_contains($haystack, 'BANCONOT') || str_contains($haystack, 'BIGLIETTO') || str_contains($haystack, 'BANCA D\'ITALIA')) {
            return 'banconota';
        }

        return 'moneta';
    }

    private function articleForType(string $type): string
    {
        return match ($type) {
            'banconota' => 'Il biglietto',
            default => match ($type) {
                'medaglia' => 'La medaglia',
                default => 'La moneta',
            },
        };
    }

    private function buildIdentification(string $name, string $combined): string
    {
        $base = trim(explode('/', $name)[0] ?? $name);
        $base = preg_replace('/\s*,\s*(mSPL|SPL|BB|MB|FDS|UNC|AU|VF|EF|NC|R+|RRR+|C)\b/i', '', $base) ?? $base;
        $base = preg_replace('/\s*\([^)]*(Pagani|Casolari|Muenzkatalog|Crapanzano)[^)]*\)/i', '', $base) ?? $base;
        $base = preg_replace('/\s+/', ' ', trim($base)) ?? '';

        if (preg_match('/Emissione:\s*([^;,\n]+)/i', $combined, $m)) {
            $emission = trim($m[1]);
            if (! str_contains(strtolower($base), strtolower($emission))) {
                $base .= ', emissione del '.$emission;
            }
        }

        return $base;
    }

    private function buildFacesClause(string $description): string
    {
        if (! preg_match('/D\/\s*(.+?)\s*,\s*R\/\s*(.+?)(?:,|;|\n|$)/isu', $description, $m)) {
            return '';
        }

        $obverse = $this->normalizeFaceText($m[1]);
        $reverse = $this->normalizeFaceText($m[2]);

        if ($obverse === '' || $reverse === '') {
            return '';
        }

        return 'con al dritto: '.$obverse.', ed al rovescio: '.$reverse;
    }

    private function normalizeFaceText(string $text): string
    {
        $text = html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/', ' ', trim($text)) ?? '';

        return str_replace([' s.', ' s '], [' sx', ' sx '], $text);
    }

    private function extractMetal(string $text): string
    {
        if (preg_match('/Metallo:\s*([A-Z]{1,3})/i', $text, $m)) {
            return $this->metalLabel(strtoupper($m[1]));
        }

        if (preg_match('/\b(BRONZO|RAM[EO]|ARGENTO|ORO|NIKEL|ACMON|AE|AR|AG|AU|CU)\b/i', $text, $m)) {
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

    private function extractWeight(string $text): ?float
    {
        if (preg_match('/gr\.\s*([\d,\.]+)/i', $text, $m)) {
            return $this->parseDecimal($m[1]);
        }

        return null;
    }

    private function extractDiameter(string $text): ?float
    {
        if (preg_match('/Diam\.?:\s*mm\.?\s*([\d,\.]+)/i', $text, $m)) {
            return $this->parseDecimal($m[1]);
        }

        return null;
    }

    private function extractMint(string $text): string
    {
        if (preg_match('/Zecca di\s*([^;,\n]+)/i', $text, $m)) {
            return trim($m[1]);
        }

        return '';
    }

    private function extractBibliography(string $text): string
    {
        if (preg_match('/Rif\.\s*bibl\.\s*([^;,\n]+)/i', $text, $m)) {
            return trim(preg_replace('/\s+/', ' ', $m[1]) ?? '');
        }

        if (preg_match('/\((Pagani|Casolari|Muenzkatalog|Crapanzano)[^)]+\)/i', $text, $m)) {
            return trim(str_replace(['(', ')'], '', $m[0]));
        }

        return '';
    }

    private function extractGrade(string $text): string
    {
        if (preg_match('/\b(mSPL|SPL|BB|MB|B|FDS|FDC|UNC|AU|VF|EF|qSPL)\b/i', $text, $m)) {
            return strtoupper($m[1]);
        }

        return 'SPL';
    }

    private function extractRarity(string $text): string
    {
        if (preg_match('/\((R{1,5}|RRRRR|NC|C)\)/i', $text, $m)) {
            $code = strtoupper($m[1]);

            return match ($code) {
                'R', 'RR', 'RRR', 'RRRR', 'RRRRR' => 'raro ('.$code.')',
                'NC' => 'non comune (NC)',
                default => '',
            };
        }

        return '';
    }

    private function gradePhrase(string $grade): string
    {
        $grade = strtoupper($grade);

        return match ($grade) {
            'MSPL', 'MSPL.' => "migliore di 'splendida' (mSPL)",
            'SPL' => "migliore di 'splendida' (SPL)",
            'BB' => "bellissima (BB)",
            'MB' => "molto bella (MB)",
            'FDS', 'FDC' => "'fior di stampa' (FDS)",
            default => "'".$grade."'",
        };
    }

    private function plainText(string $html): string
    {
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return preg_replace('/\s+/u', ' ', trim($text)) ?? '';
    }

    private function parseDecimal(string $value): float
    {
        return (float) str_replace(',', '.', trim($value));
    }

    private function formatDecimal(float $value): string
    {
        return str_replace('.', ',', number_format($value, 2, '.', ''));
    }
}

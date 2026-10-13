<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductCertificate;
use Illuminate\Support\Carbon;
use RuntimeException;
use TCPDF;

class ProductCertificatePdfGenerator
{
    private const COLOR_BRAND = [139, 26, 26];

    private const COLOR_TITLE = [60, 60, 160];

    private const COLOR_TEXT = [30, 30, 30];

    private const COLOR_LINE = [120, 40, 40];

    public function generate(ProductCertificate $certificate, ?Product $product = null): ProductCertificate
    {
        $product ??= $certificate->product;
        $sku = $certificate->displaySku();
        if ($sku === '') {
            throw new RuntimeException('SKU mancante: impossibile generare il PDF.');
        }

        $this->snapshotScores($certificate, $product);
        if (! $certificate->issued_on) {
            $certificate->issued_on = Carbon::today();
        }

        $pdfDir = config('product_certificates.pdf_path');
        if (! is_dir($pdfDir) && ! mkdir($pdfDir, 0775, true) && ! is_dir($pdfDir)) {
            throw new RuntimeException('Impossibile creare la cartella PDF certificati.');
        }

        $filename = $sku.'.pdf';
        $absolute = rtrim($pdfDir, '/').'/'.$filename;

        $pdf = $this->buildPdf($certificate, $sku);
        $pdf->Output($absolute, 'F');

        if (! is_file($absolute)) {
            throw new RuntimeException('Generazione PDF fallita.');
        }

        $sha = hash_file('sha256', $absolute);
        $certificate->pdf_filename = $filename;
        $certificate->pdf_sha256 = $sha;
        $certificate->save();

        return $certificate->fresh();
    }

    private function snapshotScores(ProductCertificate $certificate, ?Product $product): void
    {
        if ($certificate->score_conservazione !== null) {
            return;
        }

        if (! $product) {
            return;
        }

        $certificate->score_conservazione = $this->intOrNull($product->conservazione ?? null);
        $certificate->score_rarita = $this->intOrNull($product->rarita ?? null);
        $certificate->score_battuta = $this->intOrNull($product->coniazione ?? $product->battuta ?? null);
        $certificate->score_metallo = $this->intOrNull($product->metallo ?? null);
        $certificate->score_stile = $this->intOrNull($product->stile ?? null);
        $certificate->score_provenienza = $this->intOrNull($product->provenienza ?? null);
    }

    private function intOrNull(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        return max(0, (int) $value);
    }

    private function buildPdf(ProductCertificate $certificate, string $sku): TCPDF
    {
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetCreator('Moruzzi Numismatica');
        $pdf->SetAuthor('Moruzzi Numismatica');
        $pdf->SetTitle('Certificato di Autenticità e Provenienza');
        $pdf->SetMargins(14, 10, 14);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->setFooterMargin(0);
        $pdf->AddPage();

        $brand = self::COLOR_BRAND;
        $titleColor = self::COLOR_TITLE;
        $text = self::COLOR_TEXT;
        $line = self::COLOR_LINE;

        // Header
        $pdf->SetTextColor(...$brand);
        $pdf->SetFont('times', 'B', 16);
        $pdf->SetXY(14, 10);
        $pdf->Cell(120, 7, 'MORVZZI NVMISMATICA', 0, 0, 'L');

        $pdf->SetFont('times', '', 11);
        $pdf->SetXY(150, 11);
        $pdf->Cell(133, 6, 'Viale dei Salesiani, 12A - 00175 ROMA', 0, 0, 'R');

        $pdf->SetDrawColor(...$line);
        $pdf->SetLineWidth(0.35);
        $pdf->Line(14, 19, 283, 19);

        $pdf->SetTextColor(...$titleColor);
        $pdf->SetFont('times', 'I', 16);
        $pdf->SetXY(14, 21);
        $pdf->Cell(269, 8, 'Certificato di Autenticità e Provenienza', 0, 0, 'C');
        $pdf->Line(70, 29.5, 227, 29.5);

        // Body text (giustificato, ultima riga di ogni paragrafo a sinistra)
        $pdf->SetTextColor(...$text);
        $pdf->SetFont('times', '', 9.5);
        $pdf->SetXY(18, 33);
        $this->writeJustifiedBody($pdf, (string) $certificate->body_text, 261.0, 4.3);

        $afterTextY = max($pdf->GetY() + 2, 70);

        // Score boxes agli estremi: spazio centrale libero per l'immagine
        $scoreY = $afterTextY;
        $this->drawScoreColumn($pdf, 16, $scoreY, [
            [$certificate->score_conservazione, 70, 'Conserv.'],
            [$certificate->score_rarita, 100, 'Rarità'],
            [$certificate->score_battuta, 100, 'Battuta'],
        ]);
        $this->drawScoreColumn($pdf, 226, $scoreY, [
            [$certificate->score_metallo, 100, 'Metallo'],
            [$certificate->score_stile, 100, 'Stile'],
            [$certificate->score_provenienza, 100, 'Proven.'],
        ]);

        // Immagine più in alto, centrata tra le due colonne score
        $visualY = $afterTextY + 2;

        // NIP seal (sotto colonna sinistra)
        $nip = resource_path('certificates/nip.png');
        if (is_file($nip)) {
            $pdf->Image($nip, 28, $scoreY + 28, 26, 26, 'PNG', '', '', false, 300);
        }

        // Coin image (as-is, proportional, as large as fits)
        $coinPath = $certificate->resolvedImagePathForPdf();
        if ($coinPath) {
            $info = @getimagesize($coinPath);
            if ($info) {
                $imgW = max(1, (float) $info[0]);
                $imgH = max(1, (float) $info[1]);
                // Tra le colonne score (~73..226) e fino al footer
                $maxW = 145.0;
                $maxH = max(42.0, 186.0 - $visualY - 12.0);
                $scale = min($maxW / $imgW, $maxH / $imgH);
                $drawW = $imgW * $scale;
                $drawH = $imgH * $scale;
                $drawX = (297.0 - $drawW) / 2.0;
                $drawY = $visualY;

                $pdf->SetTextColor(...$brand);
                $pdf->SetFont('times', 'B', 6);
                $pdf->SetXY($drawX, $drawY - 4);
                $pdf->Cell($drawW, 3, 'MORVZZI NVMISMATICA', 0, 0, 'C');

                $pdf->Image($coinPath, $drawX, $drawY, $drawW, $drawH, '', '', '', false, 300);
            }
            if (str_starts_with($coinPath, sys_get_temp_dir()) && is_file($coinPath)) {
                @unlink($coinPath);
            }
        } else {
            $pdf->SetTextColor(...$brand);
            $pdf->SetFont('times', 'B', 6);
            $pdf->SetXY(105, $visualY - 4);
            $pdf->Cell(85, 3, 'MORVZZI NVMISMATICA', 0, 0, 'C');
        }

        // QR → pagina pubblica certificato (sotto colonna destra)
        $publicUrl = $certificate->publicUrl();
        $style = [
            'border' => false,
            'padding' => 0,
            'fgcolor' => [0, 0, 0],
            'bgcolor' => false,
        ];
        $pdf->write2DBarcode($publicUrl, 'QRCODE,M', 240, $scoreY + 28, 30, 30, $style, 'N');

        // Footer
        $pdf->SetDrawColor(...$line);
        $pdf->Line(14, 195, 283, 195);

        $pdf->SetTextColor(...$text);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetXY(14, 198);
        $pdf->Cell(100, 5, $publicUrl, 0, 0, 'L');

        $pdf->SetXY(120, 198);
        $pdf->Cell(57, 5, 'www.moruzzi.it', 0, 0, 'C');

        $pdf->SetXY(180, 198);
        $pdf->Cell(103, 5, $this->formatIssuedDate($certificate), 0, 0, 'R');

        return $pdf;
    }

    /**
     * @param  list<array{0: ?int, 1: int, 2: string}>  $rows
     */
    private function drawScoreColumn(TCPDF $pdf, float $x, float $y, array $rows): void
    {
        $pdf->SetDrawColor(...self::COLOR_LINE);
        $pdf->SetTextColor(...self::COLOR_TEXT);
        $pdf->SetLineWidth(0.3);

        foreach ($rows as $i => [$value, $max, $label]) {
            $boxY = $y + ($i * 8);
            $pdf->Rect($x, $boxY, 55, 6.5);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->SetXY($x + 2, $boxY + 0.8);
            $display = $value !== null ? (string) $value : '—';
            $pdf->Cell(16, 5, $display, 0, 0, 'R');
            $pdf->SetFont('helvetica', '', 9);
            $pdf->Cell(34, 5, ' /'.$max.' '.$label, 0, 0, 'L');
        }
    }

    private function formatIssuedDate(ProductCertificate $certificate): string
    {
        $date = $certificate->issued_on
            ? Carbon::parse($certificate->issued_on)
            : Carbon::today();

        $months = [
            1 => 'gennaio', 2 => 'febbraio', 3 => 'marzo', 4 => 'aprile',
            5 => 'maggio', 6 => 'giugno', 7 => 'luglio', 8 => 'agosto',
            9 => 'settembre', 10 => 'ottobre', 11 => 'novembre', 12 => 'dicembre',
        ];

        return 'Roma, '.$date->day.' '.$months[(int) $date->month].' '.$date->year;
    }

    /**
     * Testo giustificato con ultima riga di ogni paragrafo allineata a sinistra
     * (evita spazi enormi tra poche parole).
     */
    private function writeJustifiedBody(TCPDF $pdf, string $text, float $maxWidth, float $lineHeight): void
    {
        $left = $pdf->GetX();
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        $paragraphs = explode("\n", $text);

        foreach ($paragraphs as $paragraph) {
            $paragraph = trim($paragraph);
            if ($paragraph === '') {
                $pdf->SetX($left);
                $pdf->Ln($lineHeight * 0.5);

                continue;
            }

            $words = preg_split('/\s+/u', $paragraph, -1, PREG_SPLIT_NO_EMPTY) ?: [];
            if ($words === []) {
                continue;
            }

            $lines = [];
            $current = [];
            foreach ($words as $word) {
                $trial = $current === [] ? $word : implode(' ', $current).' '.$word;
                if ($pdf->GetStringWidth($trial) <= $maxWidth) {
                    $current[] = $word;
                } else {
                    if ($current !== []) {
                        $lines[] = $current;
                    }
                    $current = [$word];
                }
            }
            if ($current !== []) {
                $lines[] = $current;
            }

            $last = count($lines) - 1;
            foreach ($lines as $i => $lineWords) {
                $y = $pdf->GetY();
                $pdf->SetXY($left, $y);

                if ($i === $last || count($lineWords) < 2) {
                    $pdf->Cell($maxWidth, $lineHeight, implode(' ', $lineWords), 0, 1, 'L');

                    continue;
                }

                $wordsWidth = 0.0;
                foreach ($lineWords as $word) {
                    $wordsWidth += $pdf->GetStringWidth($word);
                }
                $gaps = count($lineWords) - 1;
                $gap = $gaps > 0 ? max(0.0, ($maxWidth - $wordsWidth) / $gaps) : 0.0;
                $x = $left;
                foreach ($lineWords as $word) {
                    $w = $pdf->GetStringWidth($word);
                    $pdf->SetXY($x, $y);
                    $pdf->Cell($w, $lineHeight, $word, 0, 0, 'L');
                    $x += $w + $gap;
                }
                $pdf->SetXY($left, $y + $lineHeight);
            }
        }
    }

}

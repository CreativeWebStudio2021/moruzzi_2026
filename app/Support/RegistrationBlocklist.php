<?php

namespace App\Support;

class RegistrationBlocklist
{
    /**
     * Blocca se il nome è Giulio+Cameli oppure l'email è una variante giuliocameli/cameligiulio.
     */
    public static function matches(string $nome, string $cognome, string $email): bool
    {
        return self::isCameliGiulioName($nome, $cognome)
            || self::isBlockedEmail($email);
    }

    public static function isCameliGiulioName(string $nome, string $cognome): bool
    {
        $parts = array_values(array_filter([
            self::normalizePersonToken($nome),
            self::normalizePersonToken($cognome),
        ]));

        if (count($parts) < 2) {
            return false;
        }

        sort($parts);

        return $parts === ['cameli', 'giulio'];
    }

    public static function isBlockedEmail(string $email): bool
    {
        $email = strtolower(trim($email));
        if ($email === '' || ! str_contains($email, '@')) {
            return false;
        }

        [$local] = explode('@', $email, 2);
        // Gmail ignora i punti: g.iulio.cameli == giuliocameli
        $local = str_replace('.', '', $local);

        // Prefisso/suffisso alfanumerici opzionali; ordine giulio↔cameli; separatore opzionale.
        // Es. giuliocameli8, cameligiulio14, xx12giulio_cameli, cameli-giulio99
        return (bool) preg_match(
            '/^[a-z0-9]*(?:giulio[_-]?cameli|cameli[_-]?giulio)[a-z0-9]*$/',
            $local
        );
    }

    private static function normalizePersonToken(string $value): string
    {
        $value = trim(mb_strtolower($value, 'UTF-8'));
        if ($value === '') {
            return '';
        }

        $ascii = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
        if (is_string($ascii) && $ascii !== '') {
            $value = $ascii;
        }

        $value = strtolower($value);

        return preg_replace('/[^a-z]/', '', $value) ?? '';
    }
}

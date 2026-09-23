<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SiteAnnouncement extends Model
{
    public const LOCALES = ['it', 'en', 'fr', 'de', 'es'];

    /** Tag HTML ammessi nell’editor semplificato del banner. */
    public const ALLOWED_HTML_TAGS = '<p><br><strong><b><em><i><u><a><ul><ol><li>';

    protected $fillable = [
        'enabled',
        'outside_italy_only',
        'message',
        'messages',
        'reopen_label',
        'reopen_labels',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'outside_italy_only' => 'boolean',
        'messages' => 'array',
        'reopen_labels' => 'array',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public static function current(): ?self
    {
        return static::query()->orderBy('id')->first();
    }

    /**
     * Mappa locale => testo (solo valori non vuoti).
     *
     * @return array<string, string>
     */
    public function messagesMap(): array
    {
        $map = [];
        $raw = $this->messages;
        if (is_array($raw)) {
            foreach (self::LOCALES as $locale) {
                $text = (string) ($raw[$locale] ?? '');
                if (! self::isBlankHtml($text)) {
                    $map[$locale] = $text;
                }
            }
        }

        // Retrocompatibilità: colonna message monolitica = italiano
        if (! isset($map['it'])) {
            $legacy = (string) $this->message;
            if (! self::isBlankHtml($legacy)) {
                $map['it'] = $legacy;
            }
        }

        return $map;
    }

    public static function isBlankHtml(string $html): bool
    {
        $plain = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $plain = str_replace("\xc2\xa0", ' ', $plain);
        $plain = preg_replace('/\s+/u', '', $plain) ?? '';

        return $plain === '';
    }

    public static function sanitizeHtml(string $html): string
    {
        $html = strip_tags($html, self::ALLOWED_HTML_TAGS);
        // Rimuove attributi pericolosi lasciando href su <a>
        $html = preg_replace_callback(
            '/<a\b([^>]*)>/i',
            static function (array $m): string {
                $attrs = $m[1];
                $href = '';
                if (preg_match('/\bhref\s*=\s*(["\'])(.*?)\1/i', $attrs, $hm)) {
                    $href = trim($hm[2]);
                } elseif (preg_match('/\bhref\s*=\s*([^\s>]+)/i', $attrs, $hm)) {
                    $href = trim($hm[1]);
                }

                if ($href === '' || preg_match('/^\s*javascript:/i', $href)) {
                    return '<a>';
                }

                return '<a href="'.htmlspecialchars($href, ENT_QUOTES, 'UTF-8').'" target="_blank" rel="noopener noreferrer">';
            },
            $html
        ) ?? $html;

        return trim($html);
    }

    /**
     * HTML sicuro da stampare nel banner pubblico.
     * Se il contenuto è testo semplice (legacy), applica nl2br + escape.
     */
    public function localizedMessageHtml(?string $locale = null): string
    {
        $content = $this->localizedMessage($locale);
        if (self::isBlankHtml($content)) {
            return '';
        }

        if ($content === strip_tags($content)) {
            return nl2br(e($content), false);
        }

        return self::sanitizeHtml($content);
    }

    /**
     * Testo da mostrare per la lingua corrente (o indicata).
     *
     * Regole:
     * - IT: sempre il testo italiano
     * - Altre lingue: testo specifico se presente, altrimenti EN se presente, altrimenti IT
     */
    public function localizedMessage(?string $locale = null): string
    {
        return self::resolveLocalizedText($this->messagesMap(), $locale);
    }

    /**
     * @return array<string, string>
     */
    public function reopenLabelsMap(): array
    {
        $map = [];
        $raw = $this->reopen_labels;
        if (is_array($raw)) {
            foreach (self::LOCALES as $locale) {
                $text = trim((string) ($raw[$locale] ?? ''));
                if ($text !== '') {
                    $map[$locale] = mb_substr($text, 0, 120);
                }
            }
        }

        if (! isset($map['it'])) {
            $legacy = trim((string) $this->reopen_label);
            if ($legacy !== '') {
                $map['it'] = mb_substr($legacy, 0, 120);
            }
        }

        return $map;
    }

    public function reopenButtonLabel(?string $locale = null): string
    {
        $label = self::resolveLocalizedText($this->reopenLabelsMap(), $locale);
        if ($label !== '') {
            return $label;
        }

        // Default localizzati se nessun testo impostato
        $locale = $locale ?: app()->getLocale();
        $defaults = [
            'it' => 'Mostra avviso',
            'en' => 'Show notice',
            'fr' => 'Afficher l’avis',
            'de' => 'Hinweis anzeigen',
            'es' => 'Mostrar aviso',
        ];

        return $defaults[$locale] ?? $defaults['en'] ?? 'Mostra avviso';
    }

    /**
     * @param  array<string, string>  $map
     */
    public static function resolveLocalizedText(array $map, ?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale();
        if (! in_array($locale, self::LOCALES, true)) {
            $locale = 'it';
        }

        $it = trim((string) ($map['it'] ?? ''));
        $en = trim((string) ($map['en'] ?? ''));
        $specific = trim((string) ($map[$locale] ?? ''));

        if ($locale === 'it') {
            return $it;
        }

        if ($specific !== '') {
            return $specific;
        }

        if ($en !== '') {
            return $en;
        }

        return $it;
    }

    public function hasAnyMessage(): bool
    {
        return $this->messagesMap() !== [];
    }

    /**
     * Attivo per date/switch/testo (senza filtro geografico).
     */
    public function isActive(?Carbon $at = null): bool
    {
        if (! $this->enabled) {
            return false;
        }

        if (! $this->hasAnyMessage()) {
            return false;
        }

        $at ??= now();

        if ($this->starts_at && $at->lt($this->starts_at)) {
            return false;
        }

        if ($this->ends_at && $at->gt($this->ends_at)) {
            return false;
        }

        return true;
    }

    /**
     * Visibile al visitatore corrente (include filtro “solo fuori Italia”).
     */
    public function isVisibleToVisitor(?Request $request = null, ?Carbon $at = null): bool
    {
        if (! $this->isActive($at)) {
            return false;
        }

        if (! $this->outside_italy_only) {
            return true;
        }

        $request ??= request();
        $country = strtoupper(trim((string) $request->header('CF-IPCountry', '')));

        // Solo se conosciamo il paese e è Italia → nascondi.
        // Header assente/sconosciuto: non bloccare (dev locale, proxy senza CF).
        if ($country === 'IT') {
            return false;
        }

        return true;
    }

    public function dismissToken(): string
    {
        $payload = (string) $this->id
            .'|'.optional($this->updated_at)->timestamp
            .'|'.md5(json_encode($this->messagesMap(), JSON_UNESCAPED_UNICODE) ?: '');

        return sha1($payload);
    }

    /**
     * Motivo per cui non è attivo (admin), oppure null se attivo.
     */
    public function inactiveReason(?Carbon $at = null): ?string
    {
        if ($this->isActive($at)) {
            return null;
        }

        if (! $this->enabled) {
            return 'disattivato';
        }

        if (! $this->hasAnyMessage()) {
            return 'testo vuoto';
        }

        return 'fuori intervallo date';
    }
}

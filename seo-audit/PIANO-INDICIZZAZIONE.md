# Piano indicizzazione moruzzi.it

Aggiornato: 2026-11-13

## Contesto

- Pagine indicizzate GSC: da ~27.100 a ~23.150.
- Export in `seo-audit/gsc/`: scansionate non indicizzate (sample 999), rilevate (235), duplicate senza canonico (999).
- Decisioni ferme: prodotti venduti → **410** (esclusi da sitemap/elenchi); JSON-LD Product già presente **non duplicato**.

## Classificazione GSC (esclusi i 410)

Dettaglio: [`gsc/CLASSIFICAZIONE.md`](gsc/CLASSIFICAZIONE.md).

| Bucket | N (sample) | Nota |
|--------|------------|------|
| product_available | ~2023 | Maggioranza del problema (anche multi-lingua) |
| product_sold_410_exclude | ~104 | Comportamento voluto, ignorare |
| other / wrong_locale_static | ~48 | Path CMS nella lingua sbagliata |
| category | ~33 | Listing categoria |
| catalog_index / query / legacy | ~12 | Alias e parametri |

## Modifiche fatte (commit)

1. **Canonical / robots / redirect** (`eb528d2`)
   - `PageSeoService` + emissione in layout: canonical assoluto https, hreflang, robots.
   - `noindex,follow` su query (`q`, `order`, `category`, utm, …) e route private (cart/account/checkout).
   - Middleware `NormalizeSeoRequest`: strip trailing slash; alias catalogo → slug canonico lingua.
   - Categorie: 301 sempre verso `link_{locale}` se diverso dal path richiesto; hreflang solo con `link_xx` valorizzato.

2. **Sitemap** (`d0e56ca`)
   - Rimossi cart e registrazione da XML/HTML.
   - Alternates categoria solo con link localizzato; lastmod prodotti da `data_inserimento`.

3. **Descrizioni** (`df98867`)
   - `php artisan seo:generate-product-descriptions`
   - Output **non eseguito**: `seo-audit/sql/product-descriptions-{it,en,fr,de,es}.sql` (~4222 UPDATE / lingua).

4. **Verifica** (questo commit)
   - `php artisan seo:verify-staging --base=https://staging.moruzzi.it --insecure --resolve-ip=127.0.0.1`
   - Report: [`verify-staging-report.md`](verify-staging-report.md) — **0 problemi** su 50 disponibili + 10 venduti (410) + query noindex.

## Cosa resta

- Traduzione reale contenuti prodotto (oggi slug/testo IT su `/en|/fr|/de|/es`): hreflang resta sulle 5 URL prodotto; migliorare testi applicando SQL dopo revisione.
- Path CMS “lingua sbagliata” residui (es. `/de/qui-sommes-nous/…`): mappare 301 verso slug localizzato (estensione RedirectLegacy).
- Legacy static `.html` ancora in GSC performance (`/home.html`, …): già in parte redirect; completare copertura.
- Richiedere in GSC la **reindicizzazione** delle URL prioritarie (sotto), non bloccare in robots.txt le URL con noindex.
- Deploy/push GitHub e allineamento staging ufficiale: **attende OK** (codice già su tree prod locale + sync staging per test).

## URL da inviare a Search Console (richiedi indicizzazione)

Priorità alta (disponibili, traffico/impressions o representative):

1. `https://www.moruzzi.it/` (home — ora con canonical/hreflang)
2. `https://www.moruzzi.it/catalogo`
3. Una categoria forte, es. `https://www.moruzzi.it/monete/monete-della-citta-del-vaticano.html`
4–13. 10 schede disponibili dal sample “scansionata” IT/EN con testo ricco (es. id da GSC scansionata non 410), dopo aver verificato 200 + canonical self.
14. `https://www.moruzzi.it/sitemap.xml` (solo per far riscoprire; non è “URL pagina”)

Non inviare URL 410 / query `?q=` / alias `/catalog`.

## Comandi utili

```bash
# Rigenera SQL descrizioni (non esegue)
php artisan seo:generate-product-descriptions

# Verifica staging (basic auth da .env, origin locale)
php artisan seo:verify-staging --base=https://staging.moruzzi.it --insecure --resolve-ip=127.0.0.1
```

# SQL SEO

I file `product-descriptions-*.sql` del generatore automatico sono stati **rimossi**
(decisione: non usare il generatore; non sovrascrivere testi editoriali).

Il comando `seo:generate-product-descriptions` resta nel codice ma è **disabilitato**.

## Riparazione HTML (tag malformati)

Vedi `seo-audit/html-fix/`:

- `fix-product-description-html.sql`
- `backup-product-description-html.sql`
- `rollback-product-description-html.sql`

Non eseguiti di default: applicare solo dopo revisione.

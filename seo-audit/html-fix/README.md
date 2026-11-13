# Riparazione HTML descrizioni prodotto

SQL generati da `generate_fix.php` (**non eseguiti** automaticamente).

| File | Uso |
|------|-----|
| `fix-product-description-html.sql` | UPDATE che correggono solo la sintassi dei tag |
| `backup-product-description-html.sql` | Snapshot dei valori pre-fix (stesso contenuto del rollback) |
| `rollback-product-description-html.sql` | Ripristino valori originali |
| `report.json` | Conteggio, esempi, esito validazione |

Validazione offline per ogni riga: `smartPlain` invariato + bilanciamento tag + `DOMDocument`.

Prevenzione backoffice: `ripara_html_descrizione()` su save in `prodotti_ins` / `prodotti_mod`.

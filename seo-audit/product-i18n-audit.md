# Audit i18n schede prodotto

Generato: 2026-11-17T15:04:20+00:00

## Schema

Tabella `prodotti`: colonne testo `name`, `description`, `short_description`, `meta_title`, `meta_description`.
**Nessuna** colonna per lingua (`name_en`, `description_fr`, …).
`Product::localizedName()` fa fallback a `name` → su EN/DE/FR/ES il titolo è sempre IT.

## Numeri prodotti

| Metrica | Valore |
|---|---|
| Totale righe | 25718 |
| Pubblici (visibility 1\|4) | 22353 |
| Disponibili (pubblici + qty>0 + disponibili>0) | 4529 |
| Pubblici non disponibili / venduti | 17824 |
| Disponibili con `name` valorizzato | 4529 |
| Disponibili con `description` valorizzata | 4529 |
| Disponibili con `short_description` | 4529 |
| Disponibili con `meta_title` | 15 |
| Disponibili con `meta_description` | 15 |

## Impatto i18n (schede localizzate)

| Locale scheda | Titolo = IT | Descrizione = IT |
|---|---|---|
| EN | 100% (4529 disponibili) | 100% |
| DE | 100% | 100% |
| FR | 100% | 100% |
| ES | 100% | 100% |

Colonne locale presenti su `prodotti`: —.

Nessun cambio di indicizzazione in questo intervento: solo report.

## Contrasto categorie (`categorie_new`)

Totale categorie: 480

| Locale | name_* valorizzato | description_* valorizzato |
|---|---|---|
| en | 323 (67.3%) | 477 (99.4%) |
| de | 325 (67.7%) | 477 (99.4%) |
| fr | 337 (70.2%) | 477 (99.4%) |
| es | 328 (68.3%) | 477 (99.4%) |

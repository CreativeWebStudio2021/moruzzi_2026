#!/usr/bin/env python3
"""
Estrae descrizioni categorie dal backup Magento (bnmag2pu_moruzzi.sql),
le riadatta in ottica SEO, traduce e prepara l'aggiornamento di mor_categorie_new.
"""
import argparse
import html
import json
import os
import re
import shutil
import subprocess
import time
import urllib.parse
import urllib.request
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
SQL_FILE = ROOT / "bnmag2pu_moruzzi.sql"
OUTPUT_JSON = ROOT / "storage/app/category_descriptions_import.json"
IMAGES_SRC = ROOT / "public/images"
IMAGES_DEST = ROOT / "public/admin/img_up/categorie"

DESC_ATTR_ID = 47
STORE_LANG = {1: "it", 2: "en", 3: "de", 4: "fr", 5: "es"}

INTRO = {
    "it": (
        "Alla <strong>Moruzzi Numismatica</strong> di Roma trovi una selezione curata di "
        "<strong>{name}</strong> per collezionisti e appassionati. Ogni articolo è garantito "
        "autentico e accompagnato da certificazione fotografica."
    ),
    "en": (
        "At <strong>Moruzzi Numismatica</strong> in Rome you will find a curated selection of "
        "<strong>{name}</strong> for collectors and enthusiasts. Every item is guaranteed "
        "authentic and accompanied by photographic certification."
    ),
    "de": (
        "Bei <strong>Moruzzi Numismatica</strong> in Rom finden Sie eine kuratierte Auswahl an "
        "<strong>{name}</strong> für Sammler und Liebhaber. Jedes Stück ist als authentisch "
        "garantiert und mit fotografischer Zertifizierung begleitet."
    ),
    "fr": (
        "Chez <strong>Moruzzi Numismatica</strong> à Rome, découvrez une sélection de "
        "<strong>{name}</strong> pour collectionneurs et passionnés. Chaque article est "
        "garanti authentique et accompagné d'une certification photographique."
    ),
    "es": (
        "En <strong>Moruzzi Numismatica</strong> de Roma encontrará una selección de "
        "<strong>{name}</strong> para coleccionistas y aficionados. Cada artículo está "
        "garantizado como auténtico y acompañado de certificación fotográfica."
    ),
}

OUTRO = {
    "it": (
        "Sfoglia il catalogo online, ordina in sicurezza o contattaci per perizia, "
        "catalogazione e valutazione del tuo materiale numismatico."
    ),
    "en": (
        "Browse the online catalogue, order securely or contact us for expertise, "
        "cataloguing and valuation of your numismatic material."
    ),
    "de": (
        "Durchstöbern Sie den Online-Katalog, bestellen Sie sicher oder kontaktieren Sie uns "
        "für Begutachtung, Katalogisierung und Bewertung Ihres numismatischen Materials."
    ),
    "fr": (
        "Parcourez le catalogue en ligne, commandez en toute sécurité ou contactez-nous pour "
        "expertise, catalogage et évaluation de votre matériel numismatique."
    ),
    "es": (
        "Explore el catálogo en línea, ordene con seguridad o contáctenos para peritaje, "
        "catalogación y valoración de su material numismático."
    ),
}


def parse_sql_values(line: str) -> list:
    idx = line.find("VALUES ")
    if idx < 0:
        return []
    data = line[idx + 7:]
    rows = []
    i = 0
    n = len(data)
    while i < n:
        if data[i] != "(":
            i += 1
            continue
        i += 1
        fields = []
        cur = ""
        in_str = False
        esc = False
        while i < n:
            c = data[i]
            if in_str:
                if esc:
                    cur += c
                    esc = False
                elif c == "\\":
                    esc = True
                elif c == "'":
                    in_str = False
                else:
                    cur += c
            else:
                if c == "'":
                    in_str = True
                elif c == ",":
                    fields.append(cur)
                    cur = ""
                elif c == ")":
                    fields.append(cur)
                    rows.append(fields)
                    i += 1
                    break
                else:
                    cur += c
            i += 1
    return rows


def extract_backup_descriptions() -> dict:
    descriptions = {}
    pattern = "INSERT INTO `mg_catalog_category_entity_text` VALUES "
    with SQL_FILE.open("r", encoding="utf-8", errors="replace") as f:
        for line in f:
            if pattern not in line:
                continue
            for row in parse_sql_values(line):
                if len(row) < 5:
                    continue
                attr_id = int(row[1])
                store_id = int(row[2])
                entity_id = int(row[3])
                value = row[4]
                if attr_id != DESC_ATTR_ID or value == "NULL" or not value.strip():
                    continue
                lang = STORE_LANG.get(store_id)
                if not lang:
                    continue
                descriptions.setdefault(entity_id, {})[lang] = value
    return descriptions


def sanitize_text(text: str) -> str:
    if not text:
        return text
    # Rimuove zero-width e caratteri di controllo problematici per MySQL utf8
    text = text.replace("\u200b", "").replace("\u200c", "").replace("\u200d", "").replace("\ufeff", "")
    text = re.sub(r"[\x00-\x08\x0b\x0c\x0e-\x1f]", "", text)
    # Converte markup legacy <font> in HTML più pulito
    text = re.sub(r"<font[^>]*>", "<p>", text, flags=re.I)
    text = re.sub(r"</font>", "</p>", text, flags=re.I)
    return text


def strip_tags(text: str) -> str:
    text = sanitize_text(text)
    text = re.sub(r"<br\s*/?>", "\n", text, flags=re.I)
    text = re.sub(r"</p>", "\n\n", text, flags=re.I)
    text = re.sub(r"<[^>]+>", "", text)
    text = html.unescape(text)
    text = re.sub(r"\s+", " ", text).strip()
    return text


def normalize_html(content: str) -> str:
    content = sanitize_text(content)
    content = content.replace("\r\n", " ").replace("\r", " ").replace("\n", " ")
    content = re.sub(r"\s*rnrn\s*", " ", content, flags=re.I)
    content = re.sub(r"([a-zA-ZàèéìòùÀ-ÿ0-9])(<(?:b|strong|i|em|a)\b)", r"\1 \2", content)
    content = re.sub(r"(</(?:b|strong|i|em|a)>)([a-zA-ZàèéìòùÀ-ÿ0-9])", r"\1 \2", content)
    content = re.sub(r"\s{2,}", " ", content)
    content = re.sub(r"\n{3,}", "\n\n", content)
    content = re.sub(r"<p>\s*</p>", "", content, flags=re.I)
    content = re.sub(r"\s+<", "<", content)
    content = re.sub(r">\s+", ">", content)
    if not content.strip().startswith("<"):
        content = f"<p>{content.strip()}</p>"
    return content.strip()


def expand_seo(name: str, content: str, lang: str) -> str:
    content = normalize_html(content)
    plain = strip_tags(content)
    if len(plain) < 40:
        return content

    lower = content.lower()
    brand = "moruzzi" in lower[:250]

    intro = INTRO[lang].format(name=html.escape(name))
    outro = OUTRO[lang]

    parts = []
    if not brand:
        parts.append(f"<p>{intro}</p>")
    parts.append(content)
    # Outro rimosso: mostrato come blocco fisso nella pagina catalogo

    return "\n".join(parts)


def translate_text(text: str, source: str, target: str) -> str:
    plain = strip_tags(text)
    if len(plain) < 5:
        return text
    if len(plain) > 4500:
        plain = plain[:4500]

    url = (
        "https://translate.googleapis.com/translate_a/single?"
        + urllib.parse.urlencode(
            {
                "client": "gtx",
                "sl": source,
                "tl": target,
                "dt": "t",
                "q": plain,
            }
        )
    )
    try:
        with urllib.request.urlopen(url, timeout=20) as resp:
            data = json.loads(resp.read().decode("utf-8"))
        translated = "".join(part[0] for part in data[0] if part[0])
        return f"<p>{translated}</p>"
    except Exception as exc:
        print(f"  [warn] traduzione {source}->{target} fallita: {exc}")
        return text


def find_image_for_category(link_it: str, name: str) -> str | None:
    if not link_it:
        return None

    slug = link_it.replace(".html", "").split("/")[-1]
    slug_variants = [
        slug.replace("-", "_"),
        slug,
        re.sub(r"[^a-z0-9]+", "_", slug.lower()),
    ]

    name_slug = re.sub(r"[^a-z0-9]+", "_", name.lower()).strip("_")
    slug_variants.append(name_slug)

    for base in [IMAGES_DEST, IMAGES_SRC]:
        if not base.exists():
            continue
        for variant in slug_variants:
            for ext in (".png", ".jpg", ".jpeg", ".webp"):
                candidate = base / f"{variant}{ext}"
                if candidate.exists():
                    return candidate.name

    slug_key = slug.replace("-", "_")
    for f in list(IMAGES_SRC.glob("*.png")) + list(IMAGES_SRC.glob("*.jpg")):
        stem = f.stem.lower()
        if slug_key in stem or stem in slug_key:
            return f.name

    return None


def copy_image(filename: str) -> bool:
    src = IMAGES_SRC / filename
    if not src.exists():
        return False
    IMAGES_DEST.mkdir(parents=True, exist_ok=True)
    dest = IMAGES_DEST / filename
    if not dest.exists():
        shutil.copy2(src, dest)
    return True


def load_current_categories() -> dict:
    cmd = (
        "mysql -u moruzzi_staging -p'LD9SgCe@kv' moruzzi_staging -N -e "
        "\"SELECT c.entity_id, c.name, c.name_en, c.name_de, c.name_fr, c.name_es, "
        "c.link_it, c.description, c.description_en, c.description_de, c.description_fr, c.description_es, "
        "c.image, c.parent_id, p.name "
        "FROM mor_categorie_new c "
        "LEFT JOIN mor_categorie_new p ON p.entity_id = c.parent_id "
        "WHERE c.level >= 2\""
    )
    out = subprocess.check_output(cmd, shell=True).decode("utf-8", errors="replace")
    categories = {}
    for line in out.strip().split("\n"):
        if not line:
            continue
        parts = line.split("\t")
        if len(parts) < 15:
            continue
        eid = int(parts[0])
        categories[eid] = {
            "name": parts[1] or "",
            "name_en": parts[2] or "",
            "name_de": parts[3] or "",
            "name_fr": parts[4] or "",
            "name_es": parts[5] or "",
            "link_it": parts[6] or "",
            "description": parts[7] if parts[7] != "NULL" else "",
            "description_en": parts[8] if parts[8] != "NULL" else "",
            "description_de": parts[9] if parts[9] != "NULL" else "",
            "description_fr": parts[10] if parts[10] != "NULL" else "",
            "description_es": parts[11] if parts[11] != "NULL" else "",
            "image": parts[12] if parts[12] != "NULL" else "",
            "parent_id": int(parts[13]) if parts[13] and parts[13] != "NULL" else 0,
            "parent_name": parts[14] if parts[14] != "NULL" else "",
        }
    return categories


def should_replace(current: str, new: str, force: bool) -> bool:
    if force:
        return True
    if not current or not current.strip():
        return True
    # Mantieni contenuti manuali più lunghi
    if len(strip_tags(current)) > len(strip_tags(new)) * 1.3:
        return False
    return True


def infer_category_context(name: str, parent_name: str, link_it: str) -> str:
    ctx = f"{parent_name} {link_it} {name}".lower()
    if any(k in ctx for k in ("pubblicaz", "libri", "rivist", "catalogo", "libro")):
        return "pubblicazioni"
    if "banconot" in ctx:
        return "banconote"
    if "medagl" in ctx:
        return "medaglie"
    if "francoboll" in ctx or "antiquariato" in ctx:
        return "antiquariato"
    if "orolog" in ctx or "accessori" in ctx:
        return "accessori"
    if "offert" in ctx or "ultimi arrivi" in ctx:
        return "offerte"
    return "monete"


def generate_missing_description(name: str, parent_name: str, link_it: str, lang: str) -> str:
    kind = infer_category_context(name, parent_name, link_it)
    parent = html.escape(parent_name) if parent_name else ""
    cat = html.escape(name)

    bodies = {
        "monete": {
            "it": (
                f"<p>Scopri la sezione dedicata a <strong>{cat}</strong>"
                + (f", all'interno di <strong>{parent}</strong>," if parent else "")
                + f": monete da collezione selezionate da Moruzzi Numismatica per autenticità, conservazione e valore storico.</p>"
                f"<p>Ideale per collezionisti e investitori che cercano pezzi certificati, rari e documentati.</p>"
            ),
            "en": (
                f"<p>Discover the section dedicated to <strong>{cat}</strong>"
                + (f", within <strong>{parent}</strong>," if parent else "")
                + f": collectible coins selected by Moruzzi Numismatica for authenticity, condition and historical value.</p>"
                f"<p>Ideal for collectors and investors looking for certified, rare and documented pieces.</p>"
            ),
        },
        "banconote": {
            "it": (
                f"<p>In questa categoria trovi <strong>{cat}</strong>"
                + (f" nella sezione <strong>{parent}</strong>" if parent else "")
                + f": banconote da collezione, scelte per qualità, rarità e stato di conservazione.</p>"
                f"<p>Ogni esemplare è proposto con garanzia di autenticità Moruzzi Numismatica.</p>"
            ),
            "en": (
                f"<p>In this category you will find <strong>{cat}</strong>"
                + (f" in the <strong>{parent}</strong> section" if parent else "")
                + f": collectible banknotes selected for quality, rarity and condition.</p>"
                f"<p>Every item is offered with Moruzzi Numismatica authenticity guarantee.</p>"
            ),
        },
        "medaglie": {
            "it": (
                f"<p>Collezione di <strong>{cat}</strong>"
                + (f" nella categoria <strong>{parent}</strong>" if parent else "")
                + f": medaglie storiche, commemorative e religiose per appassionati e collezionisti esperti.</p>"
            ),
            "en": (
                f"<p>Collection of <strong>{cat}</strong>"
                + (f" in the <strong>{parent}</strong> category" if parent else "")
                + f": historical, commemorative and religious medals for enthusiasts and expert collectors.</p>"
            ),
        },
        "pubblicazioni": {
            "it": (
                f"<p><strong>{cat}</strong>: pubblicazioni numismatiche, cataloghi e volumi di riferimento "
                f"per approfondire storia, arte e collezionismo.</p>"
                f"<p>Disponibili presso Moruzzi Numismatica, punto di riferimento per studiosi e collezionisti.</p>"
            ),
            "en": (
                f"<p><strong>{cat}</strong>: numismatic publications, catalogues and reference volumes "
                f"to explore history, art and collecting.</p>"
                f"<p>Available at Moruzzi Numismatica, a reference point for scholars and collectors.</p>"
            ),
        },
        "antiquariato": {
            "it": (
                f"<p>Selezione di <strong>{cat}</strong> per collezionisti: pezzi autentici "
                f"scelti per qualità e interesse storico.</p>"
            ),
            "en": (
                f"<p>Selection of <strong>{cat}</strong> for collectors: authentic pieces "
                f"chosen for quality and historical interest.</p>"
            ),
        },
        "accessori": {
            "it": (
                f"<p><strong>{cat}</strong>: accessori utili per la conservazione, la catalogazione "
                f"e la presentazione del materiale numismatico.</p>"
            ),
            "en": (
                f"<p><strong>{cat}</strong>: useful accessories for storing, cataloguing "
                f"and presenting numismatic material.</p>"
            ),
        },
        "offerte": {
            "it": (
                f"<p><strong>{cat}</strong>: scopri le proposte in evidenza di Moruzzi Numismatica "
                f"con occasioni selezionate per collezionisti.</p>"
            ),
            "en": (
                f"<p><strong>{cat}</strong>: discover Moruzzi Numismatica featured offers "
                f"with selected opportunities for collectors.</p>"
            ),
        },
    }

    body = bodies.get(kind, bodies["monete"])
    text = body.get(lang, body["it"])
    return expand_seo(name, text, lang)


def build_missing_import(translate: bool) -> dict:
    current = load_current_categories()
    updates = []
    stats = {
        "missing_before": 0,
        "generated": 0,
        "images_assigned": 0,
        "translations": 0,
    }

    for eid, cat in sorted(current.items()):
        if cat["description"] and cat["description"].strip():
            continue
        stats["missing_before"] += 1

        names = {
            "it": cat["name"],
            "en": cat["name_en"] or cat["name"],
            "de": cat["name_de"] or cat["name"],
            "fr": cat["name_fr"] or cat["name"],
            "es": cat["name_es"] or cat["name"],
        }

        descriptions = {
            "it": generate_missing_description(
                names["it"], cat["parent_name"], cat["link_it"], "it"
            )
        }

        if translate:
            for lang in ("en", "de", "fr", "es"):
                src_lang = "it"
                translated = translate_text(descriptions["it"], src_lang, lang)
                descriptions[lang] = expand_seo(names[lang], translated, lang)
                stats["translations"] += 1
                time.sleep(0.12)
        else:
            descriptions["en"] = generate_missing_description(
                names["en"], cat["parent_name"], cat["link_it"], "en"
            )

        row = {
            "entity_id": eid,
            "name": cat["name"],
            "description": descriptions["it"],
            "description_en": descriptions.get("en", ""),
            "description_de": descriptions.get("de", ""),
            "description_fr": descriptions.get("fr", ""),
            "description_es": descriptions.get("es", ""),
        }

        image_name = find_image_for_category(cat["link_it"], cat["name"])
        if not image_name and cat["parent_id"]:
            parent = current.get(cat["parent_id"])
            if parent and parent.get("image"):
                image_name = parent["image"]
            elif parent:
                image_name = find_image_for_category(parent.get("link_it", ""), parent.get("name", ""))

        if image_name and copy_image(image_name) and not cat["image"]:
            row["image"] = image_name
            stats["images_assigned"] += 1

        updates.append(row)
        stats["generated"] += 1
        print(f"  [{eid}] {cat['name']}")

    return {"stats": stats, "updates": updates}


def build_import(translate: bool, force: bool) -> dict:
    backup = extract_backup_descriptions()
    current = load_current_categories()
    updates = []
    stats = {
        "total_categories": len(current),
        "with_backup_it": 0,
        "updated": 0,
        "skipped_manual": 0,
        "images_assigned": 0,
        "translations": 0,
    }

    for eid, cat in sorted(current.items()):
        backup_langs = backup.get(eid, {})
        if not backup_langs.get("it"):
            continue
        stats["with_backup_it"] += 1

        names = {
            "it": cat["name"] or backup_langs.get("it", "")[:50],
            "en": cat["name_en"] or cat["name"],
            "de": cat["name_de"] or cat["name"],
            "fr": cat["name_fr"] or cat["name"],
            "es": cat["name_es"] or cat["name"],
        }

        descriptions = {}
        for lang in ("it", "en", "de", "fr", "es"):
            source = backup_langs.get(lang)
            if source:
                descriptions[lang] = expand_seo(names[lang], source, lang)
            elif lang == "it":
                continue
            elif translate:
                base_lang = "en" if descriptions.get("en") else "it"
                base_text = descriptions.get(base_lang) or backup_langs["it"]
                if lang == "en" and not descriptions.get("en"):
                    translated = translate_text(base_text, "it", "en")
                    descriptions["en"] = expand_seo(names["en"], translated, "en")
                    stats["translations"] += 1
                    time.sleep(0.15)
                elif lang in ("de", "fr", "es"):
                    src = descriptions.get("en") or descriptions.get("it")
                    translated = translate_text(src, "en" if descriptions.get("en") else "it", lang)
                    descriptions[lang] = expand_seo(names[lang], translated, lang)
                    stats["translations"] += 1
                    time.sleep(0.15)

        if "it" not in descriptions:
            descriptions["it"] = expand_seo(names["it"], backup_langs["it"], "it")

        row = {"entity_id": eid, "name": cat["name"]}
        changed = False

        field_map = {
            "it": "description",
            "en": "description_en",
            "de": "description_de",
            "fr": "description_fr",
            "es": "description_es",
        }
        for lang, field in field_map.items():
            if lang not in descriptions:
                continue
            current_val = cat[field]
            if should_replace(current_val, descriptions[lang], force):
                row[field] = descriptions[lang]
                changed = True
            elif current_val and current_val.strip():
                stats["skipped_manual"] += 1

        image_name = find_image_for_category(cat["link_it"], cat["name"])
        if image_name and copy_image(image_name) and (not cat["image"] or force):
            row["image"] = image_name
            changed = True
            stats["images_assigned"] += 1

        if changed:
            updates.append(row)
            stats["updated"] += 1
            print(f"  [{eid}] {cat['name']}")

    return {"stats": stats, "updates": updates}


def apply_updates(updates: list) -> None:
    php_script = ROOT / "storage/app/_apply_category_updates.php"
    php_code = """<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\\Contracts\\Console\\Kernel::class)->bootstrap();
$data = json_decode(file_get_contents(__DIR__ . '/category_descriptions_import.json'), true);
foreach ($data['updates'] as $row) {
    $id = $row['entity_id'];
    $fields = array_diff_key($row, ['entity_id' => 1, 'name' => 1]);
  if (empty($fields)) continue;
    DB::table('categorie_new')->where('entity_id', $id)->update($fields);
}
echo count($data['updates']) . " categorie aggiornate\\n";
"""
    php_script.write_text(php_code)
    subprocess.check_call(["php", str(php_script)], cwd=str(ROOT))


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument("--apply", action="store_true", help="Applica gli aggiornamenti al database")
    parser.add_argument("--translate", action="store_true", help="Traduce lingue mancanti via Google Translate")
    parser.add_argument("--force", action="store_true", help="Sostituisce anche descrizioni esistenti")
    parser.add_argument(
        "--missing-only",
        action="store_true",
        help="Genera descrizioni SEO solo per categorie senza testo italiano",
    )
    args = parser.parse_args()

    if args.missing_only:
        print("Generazione descrizioni per categorie senza testo...")
        result = build_missing_import(translate=args.translate)
        output = ROOT / "storage/app/category_descriptions_missing.json"
    else:
        print("Estrazione descrizioni dal backup Magento...")
        result = build_import(translate=args.translate, force=args.force)
        output = OUTPUT_JSON

    output.parent.mkdir(parents=True, exist_ok=True)
    with output.open("w", encoding="utf-8") as f:
        json.dump(result, f, ensure_ascii=False, indent=2)

    # L'apply legge sempre dal path standard
    shutil.copy(output, OUTPUT_JSON)

    stats = result["stats"]
    print("\n=== Riepilogo ===")
    for k, v in stats.items():
        print(f"  {k}: {v}")
    print(f"\nJSON salvato in: {output}")

    if args.apply:
        print("\nApplicazione aggiornamenti al database...")
        apply_updates(result["updates"])
        print("Completato.")


if __name__ == "__main__":
    main()

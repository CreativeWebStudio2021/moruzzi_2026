#!/usr/bin/env python3
"""Pulisce le descrizioni categorie: rnrn, spazi mancanti, blocco perizie."""
import re
import subprocess

FIELDS = ("description", "description_en", "description_de", "description_fr", "description_es")

OUTRO_PATTERNS = [
    r"<p>\s*Sfoglia il catalogo online[\s\S]*?</p>",
    r"<p>\s*Browse the online catalogue[\s\S]*?</p>",
    r"<p>\s*Durchstöbern Sie den Online-Katalog[\s\S]*?</p>",
    r"<p>\s*Parcourez le catalogue en ligne[\s\S]*?</p>",
    r"<p>\s*Explore el catálogo en línea[\s\S]*?</p>",
    r"\\+\s*<p>\s*Sfoglia il catalogo[\s\S]*?</p>",
]

PERIZIE_PATTERNS = [
    # Italiano — solo blocco perizie, non articoli umbertomoruzzi
    r"<p>[^<]*Se vuoi far periziare[\s\S]*?</p>",
    r"Se vuoi far periziare[\s\S]*?perizie-numismatiche\.html[\s\S]*?</a>[^<]*",
    # Inglese
    r"<p>[^<]*If you want to have your[\s\S]*?perizie-numismatiche\.html[\s\S]*?</p>",
    r"If you want to have your[\s\S]*?perizie-numismatiche\.html[\s\S]*?</a>[^<]*",
    # Tedesco
    r"<p>[^<]*schätzen, katalogisieren und bewerten lassen[\s\S]*?perizie-numismatiche\.html[\s\S]*?</p>",
    r"Wenn Sie Ihre[\s\S]*?perizie-numismatiche\.html[\s\S]*?</a>[^<]*",
    # Francese
    r"<p>[^<]*expertiser, cataloguer[\s\S]*?perizie-numismatiche\.html[\s\S]*?</p>",
    r"Si vous souhaitez faire[\s\S]*?perizie-numismatiche\.html[\s\S]*?</a>[^<]*",
    # Spagnolo
    r"<p>[^<]*peritar, catalogar[\s\S]*?perizie-numismatiche\.html[\s\S]*?</p>",
    r"Si deseas[\s\S]*?perizie-numismatiche\.html[\s\S]*?</a>[^<]*",
]


def fix_unclosed_anchor_tags(text: str) -> str:
    changed = True
    while changed:
        changed = False
        for m in re.finditer(r"<a\s[^>]*>", text, flags=re.I):
            start = m.end()
            close_p = text.find("</p>", start)
            close_a = text.find("</a>", start)
            if close_p != -1 and (close_a == -1 or close_a > close_p):
                text = text[:close_p] + "</a>" + text[close_p:]
                changed = True
                break
    return text


def clean_html(text: str) -> str:
    if not text or not text.strip():
        return text

    # Artefatti \r\n dal backup Magento (solo sequenze esplicite, non "rn" dentro le parole)
    text = text.replace("\\r\\n", " ")
    text = text.replace("\\n", " ")
    text = text.replace("\r\n", " ")
    text = text.replace("\r", " ")
    text = text.replace("\n", " ")
    text = re.sub(r"\s*rnrn\s*", " ", text, flags=re.I)
    text = re.sub(r"(?:<br\s*/?>\s*){2,}", " ", text, flags=re.I)

    # Ripara danni da pulizia precedente
    text = text.replace("mode e", "moderne")

    # Rimuove blocchi perizie / link Umberto Moruzzi
    for pattern in PERIZIE_PATTERNS + OUTRO_PATTERNS:
        text = re.sub(pattern, "", text, flags=re.I)

    text = text.replace("\\", " ")

    text = re.sub(
        r"<p>[^<]*perizie-numismatiche\.html[\s\S]*?</p>",
        "",
        text,
        flags=re.I,
    )

    # Rimuove residui di markup rotto dal backup
    text = re.sub(r'</a>"\.\s*</p>', "</a>", text)
    text = re.sub(r'"\.\s*</p>', "", text)
    text = re.sub(r"</p></a></p>", "</p>", text)
    text = re.sub(r"</a></p>", "</p>", text)
    text = re.sub(r",<b>", r", <b>", text)
    text = re.sub(r":<b>", r": <b>", text)

    # <a><p>...</p></a> -> <a>...</a>
    text = re.sub(r"<a([^>]*)>\s*<p>([\s\S]*?)</p>\s*</a>", r"<a\1>\2</a>", text, flags=re.I)
    text = re.sub(r"<a([^>]*)>\s*<p><b>", r"<a\1><b>", text, flags=re.I)
    text = re.sub(r"</b></p></a>", r"</b></a>", text, flags=re.I)

    # Spazi mancanti attorno a tag inline
    text = re.sub(r"([a-zA-ZàèéìòùÀ-ÿ0-9])(<(?:b|strong|i|em|a)\b)", r"\1 \2", text)
    text = re.sub(r"(</(?:b|strong|i|em|a)>)([a-zA-ZàèéìòùÀ-ÿ0-9])", r"\1 \2", text)

    # Paragrafi vuoti, annidamenti e chiusure duplicate
    text = re.sub(r"<p>\s*</p>", "", text, flags=re.I)
    text = re.sub(r"</p>\s*</p>", "</p>", text, flags=re.I)
    text = re.sub(r"<p>\s*<p>", "<p>", text, flags=re.I)
    text = re.sub(r"<p>\s+(?=<p>)", "", text)
    text = re.sub(r"\s{2,}", " ", text)
    text = re.sub(r">\s+<", "><", text)
    # Ripara paragrafi annidati / non chiusi dal backup Magento
    text = re.sub(r"([.!?\"])\s*<p>", r"\1</p><p>", text)
    text = re.sub(r"(</a>)\s*<p>", r"\1</p><p>", text)
    open_p = len(re.findall(r"<p\b", text, flags=re.I))
    close_p = text.lower().count("</p>")
    if open_p > close_p:
        text += "</p>" * (open_p - close_p)

    text = fix_unclosed_anchor_tags(text)

    return text.strip()


def mysql_escape(s: str) -> str:
    return s.replace("\\", "\\\\").replace("'", "''")


def main():
    cmd = (
        "mysql -u moruzzi_staging -p'LD9SgCe@kv' moruzzi_staging -N -e "
        "\"SELECT entity_id, description, description_en, description_de, description_fr, description_es "
        "FROM mor_categorie_new WHERE level >= 2\""
    )
    out = subprocess.check_output(cmd, shell=True).decode("utf-8", errors="replace")
    updated = 0

    for line in out.strip().split("\n"):
        if not line:
            continue
        parts = line.split("\t")
        if len(parts) < 6:
            continue
        eid = parts[0]
        fields = dict(zip(FIELDS, parts[1:6]))
        sets = []
        for field, value in fields.items():
            if value == "NULL":
                value = ""
            cleaned = clean_html(value)
            if cleaned != value:
                sets.append(f"{field} = '{mysql_escape(cleaned)}'")
        if sets:
            sql = f"UPDATE mor_categorie_new SET {', '.join(sets)} WHERE entity_id = {eid};"
            subprocess.check_call(
                ["mysql", "-u", "moruzzi_staging", "-pLD9SgCe@kv", "moruzzi_staging", "-e", sql]
            )
            updated += 1

    print(f"Categorie aggiornate: {updated}")


if __name__ == "__main__":
    main()

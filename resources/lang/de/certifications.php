<?php

$certNote = 'Es ist möglich, zum Preis von € 8,00 eine Zertifizierung zu beantragen, die das Etikett mit QR-Code, das fotografische Zertifikat und die Online-Zugang für alle Münzen, Medaillen oder Banknoten umfasst, die ab 2009 bei Moruzzi Numismatica erworben wurden und noch nicht über diese Dokumentation verfügen.';

return [
    'common' => [
        'appointment_title' => 'Termin empfohlen',
        'appointment_text' => 'Bevor Sie ins Geschäft kommen, kontaktieren Sie uns unter +39 06 7151 0220, um einen Termin zu vereinbaren.',
        'pricing_note' => 'Die Honorare verstehen sich inklusive Steuern und Gebühren.',
        'perizia_detail' => 'Umfasst Anbringung von Siegeln auf dem Umschlag und dem beschreibenden Etikett, fotografische Zertifizierung und QR-Code für die digitale Einsicht.',
    ],

    'online' => [
        'title' => 'Online-Zertifikat',
        'lead' => 'Das Online-Zertifikat von Moruzzi Numismatica, verknüpft mit dem QR-Code auf dem Etikett, ermöglicht mit einem Klick die Überprüfung von Beschreibung, Abbildungen und Herkunft der erworbenen Münzen.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Die Münzen von Moruzzi Numismatica haben einen zusätzlichen Wert durch die Gesamtheit der Elemente im codierten Etikett, das sie begleitet. Dieses Dokument beschreibt das Exemplar, bescheinigt seine Qualität, garantiert seine Echtheit und rechtmäßige Herkunft.',
                    'Der angegebene Preis ist das Ergebnis einer korrekten Bewertung der Übereinstimmung zwischen Seltenheitsgrad, Erhaltungszustand und den anderen Variablen der Münze.',
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Überprüfung mit Ihrem Smartphone',
                'paragraphs' => [
                    'Zum weiteren Schutz unserer Kunden haben wir im Etikett und im Zertifikat auch den QR-Code eingefügt. Mit einem kostenlos auf allen Smartphones verfügbaren Reader oder über den exklusiven Link auf dem Papierzertifikat können Sie online die vollständige Beschreibung, Herkunftsangaben und Fotos von Vorder- und Rückseite einsehen.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                   ['file' => 'certificato_qr01.jpg', 'alt' => 'QR-Code-Detail auf dem Zertifikat', 'caption' => 'Sofortige digitale Einsicht'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'Moruzzi Numismatica ist das erste numismatische Unternehmen weltweit, das seine Münzen <strong>ohne Versiegelung</strong> in starrem Kunststoff (Slab) garantiert, wie es in den Vereinigten Staaten üblich ist. Italienische und europäische Sammler können so den direkten Kontakt mit den Münzen ihrer Sammlung pflegen.',
                    'Das Online-Zertifikat ermöglicht die Überprüfung, auch dank hochwertiger Fotos, der Herkunft und Qualität der Münzen aus unserem Haus: ein Schritt voran in Transparenz und Sicherheit beim Kauf. Die Zertifizierung ist nicht fälschbar, da sie durch eine spezielle und nicht veränderbare Webseite garantiert wird.',
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Bitte beachten',
                'paragraphs' => [
                    'Zu Ihrer Sicherheit, um Betrug oder Täuschung zu vermeiden, stellen Sie sicher, dass der Link auf dem fotografischen Zertifikat immer mit <strong>https://www.moruzzi.it/</strong> beginnt.',
                    'Das Papierzertifikat, das auch für Online-Käufe ausgestellt und versendet wird, enthält den QR-Code zur Überprüfung per Smartphone oder über die auf dem Dokument angegebene Internetadresse.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-QR01.jpg', 'alt' => 'Legende der Etikett-Elemente mit QR-Code'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'quality' => [
        'title' => 'Moruzzi Qualitätszertifizierung',
        'lead' => 'Die Moruzzi Qualitätszertifizierung fasst Erhaltungszustand, Seltenheit, Metall und Herkunft klar zusammen und bietet dem Sammler einen wichtigen Mehrwert.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Die Münzen von Moruzzi Numismatica haben einen Mehrwert auch durch die Gesamtheit der Elemente im begleitenden Etikett. Das Etikett erfüllt die doppelte Funktion, das Exemplar zu beschreiben und seine Originalität zu garantieren; der angegebene Preis ist das Ergebnis einer korrekten Übereinstimmung zwischen Erhaltungszustand, Seltenheitsgrad und anderen Variablen.',
                    'Heute enthält das Etikett auch einen <strong>QR-Code</strong>, ohne etwas gegenüber dem klassischen Etikett einzubüßen: Mit einem Reader in kostenlosen Apps für iPhone, iPad, iPod und Android-Smartphones kann das vollständige beschreibende Zertifikat mit Herkunft und Fotos von Vorder- und Rückseite gelesen werden.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-cartellino.jpg', 'alt' => 'Legende des Moruzzi Numismatica Etiketts', 'caption' => 'Das klassische Etikett, weiterhin gültig'],
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-QR01_p23l4f70.jpg', 'alt' => 'Etikett mit QR-Code', 'caption' => 'Die neue digitale Zertifizierung'],
                ],
            ],
            [
                'type' => 'features',
                'title' => 'Was das Etikett enthält',
                'items' => [
                    ['title' => 'Vollständige Beschreibung', 'text' => 'Ausgebende Behörde, historischer Zeitraum, Münztyp, Jahr und Münzstätte wenn bekannt, Legenden oder Beschreibungen von Vorder- und Rückseite.'],
                    ['title' => 'Bibliographie und Seltenheit', 'text' => 'Bis zu drei Referenzpublikationen mit Identifikationsnummern und oft dem von den Autoren angegebenen Seltenheitsgrad.'],
                    ['title' => 'Herkunft und Transparenz', 'text' => 'Angabe der Provenienz wenn öffentlich (renommierte Auktionen, bekannte Sammlungen) und alphanumerischer Code zur ständigen Überprüfung der Herkunft.'],
                    ['title' => 'Metall, Gewicht und Preis', 'text' => 'Metall, Gewicht auf Hundertstel Gramm, Seltenheitsskala von 1 bis 5 R und Erhaltungszustand klar hervorgehoben zusammen mit dem Preis.'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Garantie ohne Ablauf',
                'paragraphs' => [
                    'Gemäß Art. 64 des Gesetzesdekrets 42/2004 (Kulturgütergesetz) ist das Etikett eine Garantie absoluter Echtheit und für alles, was darauf angegeben ist. Die Moruzzi Numismatica Garantie für die Originalität der verkauften Münzen <strong>läuft niemals ab</strong> und gilt auch für die korrekte Katalogisierung und die genaue Angabe des Erhaltungszustands.',
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'guarantee' => [
        'title' => 'Moruzzi Numismatica Garantie',
        'lead' => 'Die Moruzzi Numismatica Garantie ist unbefristet: Sie schützt Echtheit, korrekte Katalogisierung und Erhaltungszustand jedes verkauften Exemplars.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Das erste Zeichen der Seriosität unseres Hauses ist das Vertrauen, das unsere Kunden uns seit über dreißig Jahren entgegenbringen. Dennoch bieten wir eine formale Garantie für die numismatischen Objekte, die wir verkaufen: die <strong>Moruzzi Numismatica Garantie</strong>.',
                    'Das Gesetz verlangt, wie in Art. 64 des Gesetzesdekrets 42/2004 festgelegt, die Übergabe eines Garantie- und Herkunftszertifikats an den Käufer. Moruzzi Numismatica geht weiter: Es gewährleistet den verkauften Münzen und Sammlerbanknoten eine unbegrenzte Garantie in der Zeit sowohl für die Echtheit als auch für alle im Etikett angegebenen Merkmale.',
                ],
            ],
            [
                'type' => 'images',
                'items' => [
                    ['file' => 'riempitivo_garanzia.jpg', 'alt' => 'Moruzzi Numismatica Garantie', 'caption' => 'Unbefristete Garantie'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Was die Garantie abdeckt',
                'paragraphs' => [
                    'Die Garantie für die Originalität der verkauften Münzen läuft niemals ab und gilt nicht nur für die Echtheit des Objekts, sondern auch für die korrekte Katalogisierung und vor allem für die genaue Angabe des Erhaltungszustands.',
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'Wer Kunstwerke, Antiquitäten oder historisch oder archäologisch bedeutsame Objekte an die Öffentlichkeit verkauft, muss dem Käufer die Dokumentation übergeben, die die Echtheit oder zumindest die wahrscheinliche Zuschreibung und Herkunft bescheinigt; andernfalls muss er eine Erklärung mit allen verfügbaren Informationen ausstellen, vorzugsweise auf einer Fotokopie des Objekts.',
                ],
            ],
        ],
    ],

    'attestati' => [
        'title' => 'Garantie- und Herkunftszertifikate',
        'lead' => 'Garantie- und Herkunftszertifikate begleiten antike Münzen mit vollständiger Dokumentation, Abbildungen und Verweisen auf die Inventarregister.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Die von Moruzzi Numismatica verkauften antiken Münzen werden von diesem wichtigen Dokument begleitet. Es handelt sich um eine Zertifizierung, die die gesetzlichen Anforderungen umfassend erfüllt und den Bedürfnissen des modernen Sammlers entspricht, der zusammen mit den Münzen eine möglichst vollständige Dokumentation bewahren möchte.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'cetificati_mn1.jpg', 'alt' => 'Moruzzi Garantie- und Herkunftszertifikat', 'caption' => 'Garantie- und Herkunftszertifikat'],
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'certificato_qr01_b4ubt21n.jpg', 'alt' => 'Zertifikat mit QR-Code', 'caption' => 'Online-Überprüfung per QR-Code'],
                ],
            ],
            [
                'type' => 'features',
                'title' => 'Inhalt des Zertifikats',
                'items' => [
                    ['title' => 'Beschreibung und Bibliographie', 'text' => 'Vollständige Beschreibung der Münze mit bibliographischen Referenzen und Fotos von Vorder- und Rückseite.'],
                    ['title' => 'Eindeutiger Code', 'text' => 'Identifikationscode, Seltenheit, Gewicht und Erhaltungszustand für eine schnelle und transparente Einsicht.'],
                    ['title' => 'Rechtmäßige Herkunft', 'text' => 'Garantie der Originalität und rechtmäßigen Herkunft mit Registernummern, in denen das Exemplar eingetragen ist.'],
                    ['title' => 'Digitale Überprüfung', 'text' => 'QR-Code zur Online-Einsicht des Zertifikats per Smartphone oder über einen speziellen Web-Code.'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'standard' => [
        'title' => 'Qualitätsstandard',
        'lead' => 'Jedes Angebot von Moruzzi Numismatica entspricht hohen Standards in Erhaltung, Ästhetik und Technik, dargestellt auch durch spezielle Balkendiagramme für die verschiedenen Parameter.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Unsere Münzen, Medaillen und Banknoten werden nach hohen Standards in Erhaltung, Ästhetik und Technik ausgewählt. Einige der interessantesten Angebote werden auf den E-Commerce-Seiten neben der Beschreibung, die alle unsere Angebote begleitet, auch durch Balkendiagramme ergänzt.',
                ],
            ],
            [
                'type' => 'images',
                'items' => [
                    ['file' => 'augusto_denario01.jpg', 'alt' => 'Denar des Augustus', 'caption' => 'Beispiel einer Münze von hoher Qualität'],
                    ['file' => '141943a.jpg', 'alt' => 'Detail Erhaltung antiker Münze'],
                ],
            ],
            [
                'type' => 'meters',
                'title' => 'Die sechs Bewertungsparameter',
                'items' => [
                    ['label' => 'Erhaltung', 'value' => '82%', 'hint' => 'Europäische Skala / Sheldon', 'text' => 'Von D (discreet) bis FDC (Fleur de Coin), auch in Siebzigsteln für amerikanische und asiatische Sammler ausgedrückt.'],
                    ['label' => 'Seltenheit', 'value' => '68%', 'hint' => 'Von C bis RRRRRR', 'text' => 'Prozentsatz von niedrigen Werten für gängige Münzen bis 100% für einzigartige oder nahezu einzigartige Exemplare.'],
                    ['label' => 'Metall und Patina', 'value' => '74%', 'hint' => 'Legierungsqualität', 'text' => 'Bewertung von Prägeschäden, Abnutzung im Laufe der Zeit und unsachgemäßer Reinigung; qualitativ hochwertige Patina ist ein Mehrwert.'],
                    ['label' => 'Stil', 'value' => '88%', 'hint' => 'Künstlerische Feinheit', 'text' => 'Der Stil der Stempel kann in den künstlerisch anspruchsvolleren numismatischen Produktionen wichtiger sein als der Erhaltungszustand.'],
                    ['label' => 'Prägung', 'value' => '76%', 'hint' => 'Produktionsqualität', 'text' => 'Untersuchung von Brüchen, Stempelverschiebungen und Qualität des Schlags, der die Reliefs hervorhebt.'],
                    ['label' => 'Herkunft', 'value' => '62%', 'hint' => 'Provenienz', 'text' => 'Auktionen, Geschäfte und renommierte Sammlungen erhöhen den Prozentsatz gegenüber Herkünften, die nur kürzlich nachverfolgt wurden.'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'Objekte, die diesen Qualitätsmerkmalen nicht entsprechen, werden unter besonders günstigen Bedingungen angeboten. Jede von Moruzzi Numismatica angebotene Münze hat eine absolut rechtmäßige Herkunft, die in den Registern der zuständigen Behörden verzeichnet ist.',
                ],
            ],
        ],
    ],

    'upgrade' => [
        'title' => 'Qualitäts-Upgrade',
        'lead' => 'Der Qualitäts-Upgrade-Service ermöglicht den Austausch bereits erworbener Exemplare gegen solche mit höherem Grad, wobei nur die Preisdifferenz zu zahlen ist.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Jeder Sammler begnügt sich zu Beginn seiner Sammlung oft mit Exemplaren, die nicht besonders teuer oder gut erhalten sind. Mit der Zeit verfeinert sich der Geschmack und die ersten erworbenen Münzen können nicht mehr genügen. Deshalb existiert die Upgrade-Aktion von Moruzzi Numismatica.',
                    'Nicht jeder kann sofort Top-Qualität leisten: Um eine „Lücke" in der Sammlung zu schließen, kann man sich mit einem weniger schönen Exemplar zufrieden geben, mit der Möglichkeit, es später durch eines mit höherem Grad zu ersetzen.',
                ],
            ],
            [
                'type' => 'upgrade_flow',
                'steps' => [
                    ['file' => 'promozionea.jpg', 'alt' => 'Exemplar geringerer Qualität', 'caption' => 'Exemplar bereits in der Sammlung'],
                    ['file' => 'promozione.jpg', 'alt' => 'Exemplar höherer Qualität', 'caption' => 'Upgrade im Geschäft verfügbar'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Wie es funktioniert',
                'paragraphs' => [
                    'Wer in den letzten zwei Jahren mindestens <strong>drei Käufe</strong> getätigt hat, erhält die Möglichkeit, bei Moruzzi Numismatica erworbene Münzen gegen bessere Exemplare zu tauschen und nur die Preisdifferenz zu zahlen; das zurückgegebene Exemplar wird mit dem gezahlten Preis bewertet.',
                    'Beispiel: Um eine 10-Lire-Münze von 1927 in BB, erworben für € 30,00, mit einer SPL für € 100,00 zu verbessern, genügt eine Zahlung von € 70,00. Die Aktion gilt für Münzen (antike, moderne und zeitgenössische) und Banknoten, nur wenn Ersatzexemplare verfügbar sind und die zurückgegebenen Münzen das Moruzzi-Etikett haben.',
                ],
            ],
        ],
    ],

    'estimates_coins' => [
        'title' => 'Münzschätzungen und Gutachten',
        'appointment' => true,
        'lead' => 'Umberto Moruzzi bietet Schätzungen und Gutachten antiker und moderner Münzen mit vollständiger Registrierung der Daten und hochauflösender Abbildungen.',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => [
                    'file' => 'stime-e-perizie-di-monete.jpg',
                    'alt' => 'Moruzzi Numismatica Münzschätzungen und Gutachten',
                ],
                'paragraphs' => [
                    'Für Schätzungen und Gutachten antiker, moderner Münzen und Medaillen können Sie sich an unser Büro in Rom wenden, an den numismatischen Gelehrten <strong>Umberto Moruzzi</strong>, Sachverständiger der Handelskammer und des Gerichts von Rom.',
                    'Die Gutachtendienstleistungen umfassen in jedem Fall die vollständige Registrierung der identifizierenden Elemente der untersuchten Exemplare und die Speicherung hochauflösender Abbildungen, um im Laufe der Zeit die Übereinstimmung mit ausgestellten Zertifizierungen und Katalogisierungen zu überprüfen.',
                    'Mit der gleichen Sorgfalt werden Schätzungen einzelner Exemplare und ganzer Münzsammlungen durchgeführt.',
                ],
            ],
            [
                'type' => 'links',
                'title' => 'Verwandte Dienstleistungen',
                'items' => [
                    ['route' => 'certifications.expertise_coins', 'label' => 'Münzgutachten'],
                    ['route' => 'certifications.estimates_banknotes', 'label' => 'Banknotenschätzungen und Gutachten'],
                    ['route' => 'certifications.cataloguing', 'label' => 'Katalogisierungen'],
                    ['route' => 'certifications.valuation', 'label' => 'Bewertung von Münzen und Banknoten'],
                ],
            ],
        ],
    ],

    'estimates_banknotes' => [
        'title' => 'Banknotenschätzungen und Gutachten',
        'appointment' => true,
        'lead' => 'Schätzungs- und Gutachtendienst für italienische und weltweite Banknoten mit Fokus auf korrekte Katalogisierung und Speicherung der Referenzabbildungen.',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => [
                    'file' => 'stime-e-perizie-di-banconote.jpg',
                    'alt' => 'Banknotenschätzungen und Gutachten',
                ],
                'paragraphs' => [
                    'Für Banknotengutachten können Sie sich an unser Büro in Rom wenden: <strong>Umberto Moruzzi</strong>, Sachverständiger der Handelskammer und des Gerichts von Rom, erstellt Banknotenzertifizierungen und Katalogisierungen.',
                    'Jede Dienstleistung umfasst die vollständige Registrierung der identifizierenden Elemente und die Speicherung hochauflösender Abbildungen, um im Laufe der Zeit die Übereinstimmung zwischen Exemplar und ausgestellter Dokumentation zu überprüfen.',
                    'Es werden auch Schätzungen einzelner Exemplare und ganzer Banknotensammlungen durchgeführt.',
                ],
            ],
            [
                'type' => 'links',
                'title' => 'Verwandte Dienstleistungen',
                'items' => [
                    ['route' => 'certifications.expertise_banknotes', 'label' => 'Banknotengutachten'],
                    ['route' => 'certifications.cataloguing', 'label' => 'Katalogisierungen'],
                    ['route' => 'certifications.valuation', 'label' => 'Bewertung von Münzen und Banknoten'],
                ],
            ],
        ],
    ],

    'expertise_coins' => [
        'title' => 'Münzgutachten',
        'appointment' => true,
        'lead' => 'Gutachten antiker, moderner Münzen und Medaillen mit Anbringung von Siegeln und fotografischem Zertifikat mit QR-Code für die digitale Einsicht.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi, Sachverständiger der Handelskammer und des Gerichts von Rom, führt in Rom Gutachten antiker, moderner Münzen und Medaillen durch. Alle Dienstleistungen umfassen die vollständige Registrierung der identifizierenden Elemente und die Speicherung hochauflösender Abbildungen.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarife Münzgutachten antike Münzen',
                'note' => 'Die Honorare verstehen sich inklusive Steuern und Gebühren. Umfasst Anbringung von Siegeln auf dem Umschlag und dem beschreibenden Etikett, fotografische Zertifizierung und QR-Code für die digitale Einsicht.',
                'rows' => [
                    ['label' => 'Antike Münzen mit Wert unter € 300', 'price' => '€ 30,00'],
                    ['label' => 'Antike Münzen mit Wert zwischen € 301 und € 1.000', 'price' => '€ 40,00'],
                    ['label' => 'Antike Münzen mit Wert zwischen € 1.001 und € 5.000', 'price' => '€ 70,00'],
                    ['label' => 'Antike Münzen mit Wert zwischen € 5.001 und € 10.000', 'price' => '€ 150,00'],
                    ['label' => 'Antike Münzen mit Wert zwischen € 10.001 und € 20.000', 'price' => '€ 300,00'],
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarife Münzgutachten moderne Münzen',
                'rows' => [
                    ['label' => 'Moderne Münzen mit Wert unter € 300', 'price' => '€ 20,00'],
                    ['label' => 'Moderne Münzen mit Wert zwischen € 301 und € 1.000', 'price' => '€ 25,00'],
                    ['label' => 'Moderne Münzen mit Wert zwischen € 1.001 und € 5.000', 'price' => '€ 50,00'],
                    ['label' => 'Moderne Münzen mit Wert zwischen € 5.001 und € 10.000', 'price' => '€ 100,00'],
                    ['label' => 'Moderne Münzen mit Wert zwischen € 10.001 und € 20.000', 'price' => '€ 200,00'],
                    ['label' => 'Medaillengutachten mit fotografischem Zertifikat und Angabe möglicher zeitgenössischer Produktion', 'price' => '€ 60,00'],
                    ['label' => 'Numismatische technische Beratung in gerichtlichen Verfahren', 'price' => 'Auf Anfrage'],
                ],
            ],
        ],
    ],

    'valuation' => [
        'title' => 'Bewertung von Münzen und Banknoten',
        'appointment' => true,
        'lead' => 'Bewertungen einzelner Exemplare und Sammlungen von Münzen und Banknoten mit Angabe des Ankauf- und Verkaufswerts.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi, Sachverständiger der Handelskammer und des Gerichts von Rom, führt in Rom Bewertungen antiker und moderner Münzen, Medaillen und Banknoten durch, mit Angabe des Ankauf- und Verkaufswerts auf Anfrage.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarife Bewertung',
                'note' => 'Die Honorare verstehen sich inklusive Steuern und Gebühren.',
                'rows' => [
                    ['label' => 'Numismatische technische Beratung unterschiedlicher Komplexität für Münzen, Medaillen und Papiergeld, auch in gerichtlichen Verfahren', 'price' => 'Auf Anfrage'],
                    ['label' => 'Schätzung von Sammlungen oder einzelnen Münzen bis € 6.000, mit Ankauf- und Verkaufswert', 'price' => '€ 378,00'],
                    ['label' => 'Schätzung von Sammlungen oder einzelnen Münzen über € 6.000, mit Ankauf- und Verkaufswert', 'price' => '6,3% des geschätzten Werts'],
                    ['label' => 'Schätzungen vor Ort (zusätzlich zum Prozentsatz, Fahrtkosten nach Vereinbarung)', 'price' => 'ab € 180,00'],
                ],
            ],
        ],
    ],

    'expertise_banknotes' => [
        'title' => 'Banknotengutachten',
        'appointment' => true,
        'lead' => 'Spezialisierte Gutachten italienischer und ausländischer Papiergeld mit Speicherung der Abbildungen und identifizierenden Daten für künftige Überprüfungen.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi führt in Rom Gutachten italienischer und ausländischer Banknoten sowie Katalogisierungen durch. Jede Dienstleistung umfasst die vollständige Registrierung der identifizierenden Elemente und die Speicherung hochauflösender Abbildungen.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarife Banknotengutachten',
                'note' => 'Die Honorare verstehen sich inklusive Steuern und Gebühren.',
                'rows' => [
                    ['label' => 'Italienisches Papiergeld (Staatsnoten, Schatzanweisungen, Banknoten der Banca d\'Italia) bis € 300', 'price' => '€ 20,00'],
                    ['label' => 'Wert zwischen € 301 und € 1.000', 'price' => '€ 25,00'],
                    ['label' => 'Wert zwischen € 1.001 und € 5.000', 'price' => '€ 50,00'],
                    ['label' => 'Wert zwischen € 5.001 und € 10.000', 'price' => '€ 100,00'],
                    ['label' => 'Wert zwischen € 10.001 und € 20.000', 'price' => '€ 200,00'],
                    ['label' => 'Numismatische technische Beratung in gerichtlichen Verfahren', 'price' => 'Auf Anfrage'],
                ],
            ],
        ],
    ],

    'cataloguing' => [
        'title' => 'Katalogisierung von Münzen und Banknoten',
        'appointment' => true,
        'lead' => 'Spezialisierte Katalogisierungsdienstleistung für Münzen, Medaillen und Banknoten mit Registrierung der identifizierenden Elemente und hochauflösender Abbildungen.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi führt in Rom die Katalogisierung von Münzen, Medaillen und Banknoten durch. Die Dienstleistung umfasst die vollständige Registrierung der identifizierenden Elemente und die Speicherung hochauflösender Abbildungen, um im Laufe der Zeit die Übereinstimmung zwischen Exemplaren und ausgestellten Katalogisierungen zu überprüfen.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarife Katalogisierung',
                'note' => 'Die Honorare verstehen sich inklusive Steuern und Gebühren.',
                'rows' => [
                    ['label' => 'Numismatische technische Beratung in gerichtlichen Verfahren', 'price' => 'Auf Anfrage'],
                    ['label' => 'Spezialisierte Katalogisierung republikanischer und kaiserzeitlicher römischer Münzen, Tesserae und Medaillons', 'price' => '€ 18,50'],
                    ['label' => 'Katalogisierung griechischer, kaiserzeitlicher griechischer, byzantinischer und italienischer und europäischer mittelalterlicher Münzen', 'price' => '€ 18,50'],
                    ['label' => 'Spezialisierte Katalogisierung einzelner Banknoten und ganzer Sammlungen', 'price' => '€ 18,50 pro Stück'],
                ],
            ],
        ],
    ],
];

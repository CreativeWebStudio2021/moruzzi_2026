<?php

return [
    'presentation' => [
        'title' => 'Wir stellen uns vor',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => ['file' => 'moruzzi_nello_new.jpg', 'alt' => 'Nello Moruzzi'],
                'paragraphs' => [
                    'Moruzzi Numismatica entstand aus der Leidenschaft und der beruflichen Erfahrung meines Vaters Nello Moruzzi, eines seit den 1960er Jahren bekannten und angesehenen italienischen Numismatikers.',
                    'Viele Jahre lang arbeitete er mit seinem Kollegen Federico Bartoli zusammen und trug zum Erfolg dessen Firma, A & B Numismatica, bei. Neben seinen Eigenschaften als großzügiger und ehrlicher Mensch vermittelte er uns seine Leidenschaft für die Numismatik sowie sein umfangreiches kulturelles und fachliches Wissen. Im Mai 1980 übergab er uns das Unternehmen, beriet und ermutigte uns jedoch weiterhin, damit diese wunderbare Tätigkeit immer professioneller und bedeutender wurde. Eine Kontinuität von über fünfzig Jahren machte unseren Laden zu einer historischen Institution, die im Laufe der Zeit zu einem Referenzpunkt des italienischen numismatischen Sammelwesens wurde.',
                ],
            ],
            [
                'type' => 'split_panel',
                'paragraphs' => [
                    'Er verließ uns 1996, doch seine Erinnerung und seine Ratschläge leben in uns weiter und prägen noch heute unsere Arbeit.',
                    'Heute ist unsere Tätigkeit vor allem der antiken und modernen Numismatik gewidmet: Wir beschaffen die besten Münzen nicht nur auf dem nationalen Markt, sondern auch – und vor allem – in Europa und weltweit sowie bei den wichtigsten Auktionen des Sektors. Unsere Angebote werden sorgfältig geprüft, um die Echtheit zu gewährleisten, den genauen Erhaltungszustand zu bestimmen und eine korrekte Bewertung vorzunehmen. Seit jeher widmet Moruzzi Numismatica der Banknotensammlung große Aufmerksamkeit, trotz eines gewissen Snobismus vieler Numismatiker, die diesen Bereich vor allem in der Vergangenheit mit einer gewissen Herablassung behandelten.',
                ],
                'carousel' => [
                    'prev_label' => 'Vorheriges Bild',
                    'next_label' => 'Nächstes Bild',
                    'items' => [
                        ['file' => 'moruzzi_oldshop2.jpg', 'alt' => 'Alter Laden Moruzzi Numismatica in Rom', 'caption' => 'Alter Laden der Moruzzi Numismatica in Rom'],
                        ['file' => 'moruzzi_newshop.png', 'alt' => 'Aktueller Laden Moruzzi Numismatica in Rom', 'caption' => 'Laden der Moruzzi Numismatica in Rom'],
                    ],
                ],
            ],
            [
                'type' => 'split_item',
                'anchor' => 'dove-siamo',
                'image' => ['file' => 'moruzzi_newshop.png', 'alt' => 'Moruzzi Numismatica Ladengeschäft in Rom, Stadtteil Cinecittà'],
                'title' => 'Wo wir sind',
                'paragraphs' => [
                    'Möchten Sie mit dem Sammeln beginnen? Haben Sie Münzen zu verkaufen? Dann sind Sie hier richtig! <strong>Moruzzi Numismatica</strong>, ein historisches numismatisches Geschäft in Rom, leicht mit allen Verkehrsmitteln erreichbar, bietet Ihnen maximale Transparenz und die große Professionalität seines <a href="/de/ueber-uns/unser-team">Teams</a>.',
                    '<strong>Moruzzi Numismatica</strong><br>Viale dei Salesiani, 12a<br>00175 Rom, Italien',
                    'Laden und Büros befinden sich im Stadtteil Cinecittà, gut angebunden an den öffentlichen Verkehr. Öffentliche Parkplätze und eine Garage in der Nähe. Die U-Bahn-Station <strong>Giulio Agricola</strong> (Linie A) ist etwa 250 Meter entfernt.',
                ],
            ],
            [
                'type' => 'cta',
                'url' => '/de/kontakt',
                'label' => 'Anfahrt und Kontakt',
                'title' => 'So erreichen Sie uns und nehmen Kontakt auf',
                'text' => 'Ausführliche Wegbeschreibungen (Auto, Zug, Flughäfen) und Kontaktformular finden Sie auf der Kontaktseite.',
            ],
        ],
    ],

    'staff' => [
        'title' => 'Das Team',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Ein Team qualifizierter Fachleute im Bereich der Numismatik steht Ihnen zur Verfügung, um Sie über die Münzen hinweg auf den Pfaden der Geschichte zu führen.',
                    'Die <strong>Moruzzi-Qualität</strong>, Ergebnis unserer beruflichen Ressourcen mit langjähriger internationaler Erfahrung, ermöglicht es uns, Ihnen die absolute Echtheit und Qualität der angebotenen Stücke zu garantieren, begleitet von einer vollständigen Zertifizierung. Auch alle anderen Dienstleistungen werden mit größter Sorgfalt für jedes Detail angeboten.',
                    'Die Stärke unseres qualifizierten Teams liegt in der gemeinsamen Leidenschaft für die Numismatik, die uns als Team in gegenseitigem Respekt und Vertrauen zusammenarbeiten lässt. Ein Beleg dafür ist die fast vierzigjährige Tätigkeit, die es uns ermöglicht hat, unsere Dienstleistungen auszubauen und neue Marktanteile zu erobern.',
                ],
            ],
            [
                'type' => 'staff_grid',
                'items' => [
                    ['route' => 'about.loredana', 'file' => 'Loredana-Moruzzi02_9a6e3sk4.jpg', 'alt' => 'Loredana Moruzzi', 'name' => 'Loredana Moruzzi', 'role' => '<em>Administratorin / Verkaufsleitung</em><br>CEO / Showroom Manager'],
                    ['route' => 'about.umberto', 'file' => 'Umberto-Moruzzi02.jpg', 'alt' => 'Umberto Moruzzi', 'name' => 'Umberto Moruzzi', 'role' => '<em>Leiter der Numismatik-Abteilung</em><br>Senior Numismatist'],
                    ['route' => 'about.francesca', 'file' => 'Barenghi_Francesca2_8ltw71wn.jpg', 'alt' => 'Francesca Barenghi', 'name' => 'Francesca Barenghi', 'role' => '<em>Abteilung griechische und römische Münzen</em><br>Numismatist (Greek and Roman Coins Department)'],
                    ['route' => 'about.nicola', 'file' => 'Nicola-Mecci02.jpg', 'alt' => 'Nicola Mecci', 'name' => 'Nicola Mecci', 'role' => '<em>Online-Verkauf und Marketing</em><br>Web Sales and Marketing'],
                    ['file' => 'EmanuelaPittola02.jpg', 'alt' => 'Emanuela Pittola', 'name' => 'Emanuela Pittola', 'role' => '<em>Verwaltung</em><br>Administration'],
                    ['file' => 'Daniela-franchi02.jpg', 'alt' => 'Daniela Franchi', 'name' => 'Daniela Franchi', 'role' => '<em>Verwaltung</em><br>Administration'],
                    ['route' => 'about.hiroko', 'file' => 'hiroko02.jpg', 'alt' => 'Hiroko Blue Lynx', 'name' => 'Hiroko Blue Lynx', 'role' => 'Verkaufsassistentin<br>Sales assistant'],
                ],
            ],
        ],
    ],

    'loredana' => [
        'title' => 'Loredana Moruzzi',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => ['file' => 'Loredana-Moruzzi01_40j7x2h4.jpg', 'alt' => 'Loredana Moruzzi - Moruzzi Numismatica'],
                'paragraphs' => [
                    'Ihr tiefgreifendes Branchenwissen hat sie durch fast vierzigjährige Erfahrung im Familienunternehmen erworben. Neben der Verwaltung ist sie für den Verkauf verantwortlich. Kunden aus aller Welt finden in ihr eine Ansprechpartnerin, die bereit ist, ihre Bedürfnisse zu erfüllen.',
                    'Dafür zeugen zahlreiche Kunden, mit denen sie seit Jahren freundschaftliche Beziehungen pflegt, die auf gegenseitigem Respekt beruhen. Sie betreut die Phase nach dem Verkauf mit großer Sorgfalt und begleitet die Rechnungsstellung sowie den Versand bis zum Bestimmungsort.',
                    'Sie kümmert sich um die Kontaktaufnahme mit Kunden, die ihr ihre Suchlisten anvertrauen. Mit Freundlichkeit und Professionalität beantwortet sie die meisten Fragen der Besucher dieser Website.',
                ],
            ],
        ],
    ],

    'umberto' => [
        'title' => 'Umberto Moruzzi',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => ['file' => 'Umberto-Moruzzi01_08hsgn2j.jpg', 'alt' => 'Umberto Moruzzi - Numismatischer Sachverständiger in Rom'],
                'paragraphs' => [
                    'Umberto Moruzzi, numismatischer Gelehrter, setzte die väterliche Tradition fort und spezialisierte sich insbesondere auf die römische und italienische Münzprägung. Er betreute Moruzzi Numismatica bereits ab 1980 und führte sie zu der heutigen Bekanntheit als eines der renommiertesten numismatischen Häuser Italiens.',
                    'Derzeit widmet er sich vor allem seiner beruflichen Tätigkeit als numismatischer Berater, begleitet jedoch weiterhin das Familienunternehmen, das noch heute im Besitz der Familie Moruzzi ist, wo er die erworbenen Münzen prüft und besondere Objekte bewertet. Als beim Handelskammer eingetragener numismatischer Sachverständiger ist er seit 1993 zudem Prüfer für Numismatik und Sphragistik bei der Prüfungskommission derselben Handelskammer von Rom.',
                    'Als Mitglied des Journalistenverbandes des Latiums schreibt er über Numismatik in Fachzeitschriften und überregionalen Tageszeitungen. Er ist Mitgründer der NIP, der Vereinigung der Italienischen Professionellen Numismatiker, deren Sekretär er von 1999 bis 2001 war. Er war auch für die FENAP, die Europäische Föderation der Vereinigungen und Gesellschaften Professioneller Numismatiker, tätig, deren Sekretär er von 2000 bis 2001 war. Außerdem ist er Mitglied der Royal Numismatic Society, der Società Numismatica Italiana, der NIA und des deutschen numismatischen Berufsverbandes Berufsverband des Deutschen Münzenfachhandels e.V.',
                    'Er ist Sachverständiger beim Gericht von Rom und hat verschiedene Aufträge als technischer Berater für mehrere italienische Staatsanwaltschaften wahrgenommen, darunter Rom und Mailand, und einige der bedeutendsten numismatischen Gutachten der Nachkriegszeit in Italien erstellt.',
                    'Er hat verschiedene Ausstellungen organisiert, darunter die großen Erfolg feiernde Wanderausstellung «Il Vero e il Falso» der Guardia di Finanza.',
                    'Er war wissenschaftlich-historischer Kurator für die offizielle Prägung der Expo Milano 2015.',
                    'Er ist derzeit numismatischer Kurator im Historischen Museum der Guardia di Finanza.',
                    'Er ist derzeit Vizepräsident des Berufsverbandes N.I.P. (Numismatici Italiani Professionisti).',
                ],
            ],
            [
                'type' => 'cta',
                'url' => 'https://www.umbertomoruzzi.it/',
                'label' => 'Offizielle Website',
                'title' => 'Besuchen Sie die offizielle Website des numismatischen Sachverständigen Umberto Moruzzi',
                'text' => 'Für vertiefende Informationen, Artikel und die berufliche Tätigkeit von Umberto Moruzzi steht eine eigene Website zur Verfügung.',
            ],
        ],
    ],

    'nicola' => [
        'title' => 'Nicola Mecci',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => ['file' => 'Nicola-Mecci01_bu8l0fda.jpg', 'alt' => 'Nicola Mecci - Online-Verkauf'],
                'paragraphs' => [
                    'Seit jeher begeistert von antiker und moderner Numismatik, kam er durch die Lehren eines älteren sizilianischen Sammlers in diese Welt.',
                    'Verantwortlich für den Online-Verkauf auf den verschiedenen digitalen Plattformen (E-Commerce-Website, Shops auf eBay, VCoins und Ma-Shops) und für die Beziehungen zur italienischen und internationalen Kundschaft.',
                    'Er bekleidet die Position des SEO- und Social-Media-Managers für Moruzzi Numismatica.',
                ],
            ],
        ],
    ],

    'hiroko' => [
        'title' => 'Hiroko Blue Lynx',
        'blocks' => [
            [
                'type' => 'masonry',
                'items' => [
                    ['file' => 'hiroko03.jpg', 'alt' => 'Hiroko Blue Lynx'],
                    ['file' => 'hiroko10.jpg', 'alt' => 'Hiroko Blue Lynx'],
                    ['file' => 'hiroko05.jpg', 'alt' => 'Hiroko Blue Lynx'],
                    ['file' => 'hiroko06.jpg', 'alt' => 'Hiroko Blue Lynx'],
                    ['file' => 'hiroko11.jpg', 'alt' => 'Hiroko Blue Lynx'],
                    ['file' => 'hiroko07.jpg', 'alt' => 'Hiroko Blue Lynx'],
                ],
            ],
        ],
    ],

    'francesca' => [
        'title' => 'Francesca Barenghi',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => ['file' => 'Barenghi_Francesca2_8ltw71wn.jpg', 'alt' => 'Francesca Barenghi - Moruzzi Numismatica'],
                'paragraphs' => [
                    'Von Kindesalter an in klassische Antiquitäten interessiert, begann sie ihre akademische Ausbildung in klassischer Archäologie an der Universität. Sie studierte Numismatik an der Università di Roma « La Sapienza », unter anderem bei Professorin Breglia sowie Professoren Panvini Rosati und Parise. Sie schloss ihr Studium der klassischen Philologie mit Höchstnote und Auszeichnung ab, mit einer These über keltisch-padanische Numismatik.',
                    'Im Spezialisierungsdiplom Archäologie, ebenfalls mit Höchstnote, behandelte sie die quantitative Analyse der Abnutzung kaiserlicher Münzen und Medaillen. Als Referentin nahm sie an vielen internationalen numismatischen Kongressen teil und veröffentlichte zahlreiche wissenschaftliche Artikel.',
                    'Mit einem Stipendium der französischen Regierung arbeitete sie am Projekt von Prof. J. P. Callu an der Ecole des Hautes Etudes und besuchte numismatische Doktorandenkurse von Prof. J. B. Giard an der Ecole Normale Supérieure. Sie promovierte in Archäologie mit Arbeiten zu römischen kaiserlichen Medaillons in den bedeutendsten europäischen Münzsammlungen.',
                    'Neben Italienisch spricht sie fließend Französisch, ist mit Deutsch vertraut und hat gute Englischkenntnisse. Sie klassifiziert antike und moderne Münzen und betreut den kulturellen Teil der Website. Für Moruzzi Numismatica ist sie Expertin für römische Münzprägung.',
                ],
            ],
        ],
    ],

    'publications' => [
        'title' => 'Unsere Publikationen',
        'lead' => 'Moruzzi Numismatica hat die folgenden Werke veröffentlicht oder maßgeblich zu deren Herausgabe beigetragen:',
        'blocks' => [
            ['type' => 'split_item', 'image' => ['file' => '1988.jpg', 'alt' => 'Titelseite des Katalogs Monete e medaglie, Roma 1988'], 'title' => 'Monete e medaglie, Roma 1988', 'paragraphs' => ['Es war der erste von Moruzzi Numismatica vorgestellte Katalog, der sich bereits durch die Sorgfalt seiner Ausführung und die Auswahl der angebotenen Münzen auszeichnete. Der Katalog bot griechische, römische, italienische (sowohl mittelalterliche als auch moderne), päpstliche und andere Münzen zum Verkauf an.']],
            ['type' => 'split_item', 'image' => ['file' => '1992.jpg', 'alt' => 'Titelseite des Katalogs der öffentlichen Auktion, Roma 28 febbraio 1992'], 'title' => 'Monete, medaglie e banconote. Asta pubblica, Roma 28 febbraio 1992', 'paragraphs' => ['Der Auktionskatalog von Moruzzi Arte Roma mit antiken und modernen Münzen erzielte einen bemerkenswerten Verkaufs- und Publikumserfolg.']],
            ['type' => 'split_item', 'image' => ['file' => '1994.jpg', 'alt' => 'Titelseite Le banconote del mondo, Roma 1994'], 'title' => 'Le banconote del mondo, Roma 1994', 'paragraphs' => ['Verkaufsliste weltweiter Banknoten. In den 1990er Jahren wurden Banknoten von einer großen Zahl italienischer Sammler «entdeckt».']],
            ['type' => 'split_item', 'image' => ['file' => '1995a.jpg', 'alt' => 'Titelseite Argent, Le banconote d\'Italia, Roma 1995'], 'title' => 'Argent, Le banconote d\'Italia, Roma 1995', 'paragraphs' => ['Die Nachfrage nach italienischen Banknoten war besonders hoch, und Moruzzi Numismatica, aufmerksam gegenüber den Wünschen der Sammler, bot eine Sammlung von Banknoten bemerkenswerten Niveaus in Qualität und Seltenheit an.']],
            ['type' => 'split_item', 'image' => ['file' => '1995.jpg', 'alt' => 'Titelseite Excellence, Roma 1995'], 'title' => 'Excellence, Roma 1995', 'paragraphs' => ['Ein Katalog mit besonders sorgfältig ausgewählten griechischen, römischen, byzantinischen, italienischen und ausländischen Münzen. In der Mitte des Katalogs war eine Doppelseite mit Farbbildern der besten präsentierten Exemplare gedruckt.']],
            ['type' => 'split_item', 'image' => ['file' => '1997.jpg', 'alt' => 'Titelseite Jvlia, Roma 1997'], 'title' => 'Jvlia, Roma 1997', 'paragraphs' => ['Der Katalog eröffnete eine Reihe von Publikationen, die die Namen der ältesten römischen Gentes tragen. Als Erstes wurde die gens Julia gewählt. Der Katalog internationalen Standards bot antike, moderne italienische und ausländische Münzen von hervorragender Qualität an.']],
            ['type' => 'split_item', 'image' => ['file' => '1998.jpg', 'alt' => 'Titelseite Claudia, Roma 1998'], 'title' => 'Claudia, Roma 1998', 'paragraphs' => ['Der Katalog zum Festpreis setzte die mit Jvlia begonnene Publikationsreihe fort und bot antike Münzen von seltener Schönheit und Erhaltung, aber auch Sammlungen von Münzen italienischer, päpstlicher und des Königreichs Italien Prägestätten an.']],
            ['type' => 'split_item', 'image' => ['file' => '1990.jpg', 'alt' => 'Titelseite Una collezione di antoniniani, Roma 1990'], 'title' => 'Una collezione di antoniniani. Vendita generale di monete e medaglie, Roma 1990', 'paragraphs' => ['Der Katalog bot eine äußerst reiche Sammlung von 1.000 verschiedenen Antoninianen, vorangestellt von einer interessanten historischen Einführung. Auch heute noch ist es eine von Gelehrten gesuchte Publikation.']],
            ['type' => 'split_item', 'image' => ['file' => '1992cassettas.jpg', 'alt' => 'Videokatalog der öffentlichen Auktion vom 28. Februar 1992'], 'title' => 'Videocatalogo dell\'asta pubblica del 28 febbraio 1992', 'paragraphs' => ['Der Videokatalog der Auktion von Moruzzi Arte Roma mit antiken und modernen Münzen. Die Kassette mit klassischer Hintergrundmusik war damals einzigartig und ermöglichte es, die vergrößerten Bilder der zum Verkauf stehenden Münzen im Video zu sehen.']],
            ['type' => 'split_item', 'image' => ['file' => '2002.jpg', 'alt' => 'Titelseite Addio alla Lira, Roma 2002'], 'title' => 'Addio alla Lira. Tre secoli di storia italiana attraverso le banconote, Roma 2002', 'paragraphs' => ['Mit diesem Katalog haben wir der alten Lira einen nostalgischen Abschied gewidmet: einen nur formellen Abschied von ihrer Umlaufswährung, denn sie bleibt in der Geschichte aller Italiener, im kollektiven Gedächtnis und in dem jedes Einzelnen.']],
            ['type' => 'split_item', 'image' => ['file' => '2006es.jpg', 'alt' => 'Titelseite Una collezione di Medaglie - Estate 2006'], 'title' => 'Una collezione di Medaglie - Estate 2006, Roma', 'paragraphs' => ['Katalog in Zusammenarbeit mit dem numismatischen Haus A&B. Eine schöne Auswahl an Medaillen, fast ausschließlich päpstliche, mit seltenen Exemplaren und einigen interessanten Anmerkungen.']],
            ['type' => 'split_item', 'image' => ['file' => '2007s.jpg', 'alt' => 'Titelseite FLAVIA 2007'], 'title' => 'FLAVIA 2007, Roma 2007', 'paragraphs' => ['Ein prächtiger kleiner Katalog, der großen Erfolg hatte mit ausgesucht selektierten Münzen, nach Themen gegliedert: Porträts der Augustae, mittlere kaiserliche Bronzen, gallisches Imperium, kaiserliche Denare, Silber der römischen Republik sowie Münzen des Imperiums und der römischen Provinzen.']],
            ['type' => 'split_item', 'image' => ['file' => 'il-vero-e-il-falso_1.jpg', 'alt' => 'Titelseite IL VERO e IL FALSO, Roma 2008'], 'title' => 'IL VERO e IL FALSO, Roma 2008', 'paragraphs' => ['Katalog der gleichnamigen Wanderausstellung, die bereits in Rom, Florenz, Vicenza und Perugia stattfand. Er zeichnet die Entwicklung des Fälschungsphänomens anhand antiker, mittelalterlicher und moderner Münzen sowie Banknoten der Banca d\'Italia nach.']],
            ['type' => 'split_item', 'image' => ['file' => '2006as.jpg', 'alt' => 'Titelseite Una collezione di Medaglie - Autunno 2006'], 'title' => 'Una collezione di Medaglie - Autunno 2006, Roma', 'paragraphs' => ['Katalog in Zusammenarbeit mit A&B. Unter den Medaillen stach eine bedeutende Sede-Vacante-Sammlung hervor sowie die italienische Goldmedaille zum zweitausendjährigen Todestag Vergils, das einzige bekannte Exemplar.']],
            ['type' => 'split_item', 'image' => ['file' => '2008s.jpg', 'alt' => 'Titelseite CLAVDIA 2008'], 'title' => 'CLAVDIA 2008, Roma 2008', 'paragraphs' => ['Ein Katalog in Moruzzi-Tradition, weltweit begehrt allein schon zum Lesevergnügen. Es wurden zwei bedeutende Sammlungen präsentiert: Prägungen des Nero und Bronzemünzen der griechischen Welt.']],
            ['type' => 'split_item', 'image' => ['file' => 'il-vero-e-il-falso_2.jpg', 'alt' => 'Titelseite IL VERO e IL FALSO, Milano 2013'], 'title' => 'IL VERO e IL FALSO, La Guardia di Finanza in Lombardia, Milano 2013', 'paragraphs' => ['Katalog der Wanderausstellung, kuratiert von Umberto Moruzzi in Zusammenarbeit mit der GDF. «Menschen produzieren oft falsches Geld, aber viel häufiger produziert Geld falsche Menschen» (J. Harris). Echte Münzen, ausgestellt neben ihren nahezu perfekten Fälschungen.']],
        ],
    ],

    'press' => [
        'title' => 'Man schreibt über uns',
        'blocks' => [
            [
                'type' => 'split_item',
                'image' => ['file' => 'lire500000.jpg', 'alt' => '500.000-Lire-Banknote Typ Raffaello'],
                'title' => 'In giro ancora 2550 miliardi di lire',
                'meta' => 'Il Messaggero — 14. Juli 2010, Rom',
                'paragraphs' => [
                    '... <strong>Umberto Moruzzi</strong>, Gelehrter des Papiergeldes und Inhaber eines der erfolgreichsten numismatischen Geschäfte Italiens in Rom, im Viertel Cinecittà, berichtet von einem «weit verbreiteten und wachsenden, oft amateurhaften Interesse an der Sammlung alter Lire, vor allem aus republikanischer Zeit». Eine echte «Lira-Manie», in der die Nostalgie für eine Währung, die nie zurückkehren wird, sich mit der Fähigkeit von Banknoten und Münzen verbindet, große und kleine Momente der Biografie eines jeden hervorzurufen. — ROBERTO FABEN',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'lire-500-medusas.jpg', 'alt' => '500-Lire-Banknote der Banca d\'Italia'],
                'title' => 'Rarità e biglietti integri meritano una perizia',
                'meta' => 'Il Sole 24 Ore — 21. September 2009',
                'paragraphs' => [
                    '«Mit dem Ausscheiden der alten Lira ist eine Armee neuer Sammler entstanden...» So erklärt der «Lira-Strang» Umberto Moruzzi, numismatischer Sachverständiger und Inhaber, zusammen mit seiner Schwester Loredana, des Geschäfts Moruzzi Numismatica in Cinecittà. «Banknoten und Münzen in Lire können eine Investition sein...» Wer zu Hause alte Banknoten hat, kann sie in einem numismatischen Geschäft bewerten lassen: In Italien gibt es etwa 350, doch die Mitglieder des Verbandes NIP bieten größere Garantien. Unter den neueren Banknoten ist die 500-Lire-«Barbetti»-Banknote mit dem Kontrollzeichen «Medusa» vom 14. November 1950 hervorzuheben: in gutem Zustand ist sie etwa 20.000 Euro wert. — ROBERTO FABEN',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'lamoneta_1.jpg', 'alt' => 'Numismatisches Forum Lamoneta'],
                'title' => 'Le porte del tempio di Giano — Significato sulle monete',
                'meta' => 'Lamoneta.it — 26. November 2008',
                'paragraphs' => [
                    'Bei der Suche nach Texten über den Ursprung der Bedeutung der Legende <em>CLAVSO IANI TEMPLO GAVDIVM SECVLI</em> stieß ich auf eine schöne Arbeit von Francesca Barenghi, Mitarbeiterin von Moruzzi. Ich veröffentliche sie hier vollständig, da ich sie für diesen Zweck äußerst nützlich halte.',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'premio_moruzzi_numismatica.jpg', 'alt' => 'Ben-Hur-Preis - Cinecittà 2006'],
                'title' => 'Premio Ben Hur — Cinecittà 2006',
                'meta' => 'Comune di Roma X Municipio — 21. Juli 2006',
                'paragraphs' => [
                    'Bei einem Fest wurden Preise an römische Einzelhändler des kleinen Handels verliehen, die sich durch ihre Langlebigkeit im Municipio ausgezeichnet hatten. Der Ben-Hur-Preis wurde auch an Moruzzi Numismatica verliehen, ein Unternehmen mit 26 Jahren Tätigkeit, eines der ältesten Roms in diesem Sektor. Moruzzi Numismatica verdankt ihre Anerkennung einer unbestrittenen Professionalität, die es ihr ermöglicht hat, bis heute am Markt zu bestehen und im Laufe der Jahre eine Vielzahl von Sammler-Touristen nach Rom zu bringen.',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'vetrina.jpg', 'alt' => 'Schaufenster der Moruzzi Numismatica in Rom'],
                'title' => 'Il cielo più grande del mondo sopra i palazzoni di Cinecittà',
                'meta' => 'La Repubblica — 27. Februar 2002, Rom',
                'paragraphs' => [
                    '... Unter den Arkaden des Platzes, vor den Schaufenstern eines numismatischen Geschäfts, halte ich an, um die Namen der ausgestellten Münzen zu lesen... Gibt es ein solches Geschäft, können wir uns einen glücklichen Sammler vorstellen... wir können behaupten, dass es Leben in Cinecittà gibt, ja, dass es sogar Leben auf der Erde gibt. — FULVIO ABBATE',
                ],
            ],
        ],
    ],

    'memberships' => [
        'title' => 'Memberships',
        'lead' => 'Moruzzi Numismatica, ihre Gesellschafter und Mitarbeiter sind Mitglied in mehreren namhaften Vereinigungen.',
        'blocks' => [
            ['type' => 'split_item', 'title' => 'IAPN-AINP', 'image' => ['file' => 'IAPN01.jpg', 'alt' => 'IAPN AINP'], 'paragraphs' => ['Der <strong>Internationale Verband Professioneller Numismatiker</strong> ist eine der wichtigsten gemeinnützigen Organisationen der Welt, insbesondere wegen seiner Rolle bei der Gewährleistung und Koordination zum Schutz des Marktes und des ethischen Sammelwesens. 1951 in Genf gegründet, zählt er heute mehr als 114 numismatische Unternehmen in dreiundzwanzig Ländern.']],
            ['type' => 'split_item', 'title' => 'NIP — Numismatici Italiani Professionisti', 'image' => ['file' => 'nip.png', 'alt' => 'NIP'], 'paragraphs' => ['Die NIP setzen sich dafür ein, einen numismatischen Markt zu fördern, der von den besten Grundsätzen beruflicher und geschäftlicher Ethik geprägt ist; sie fördern die wissenschaftliche Erforschung und Verbreitung der Numismatik und bekämpfen Fälschungen.']],
            ['type' => 'split_item', 'title' => 'Berufsverband des Deutschen Münzenfachhandels e.V.', 'image' => ['file' => 'Berufsverband-des-Deutschen-Muenzenfachhandels-e.V.png', 'alt' => 'Berufsverband'], 'paragraphs' => ['Wichtiger deutscher Berufsverband numismatischer Fachleute, dem Moruzzi Numismatica seit 2012 angehört. Die Mitglieder garantieren die Echtheit der zum Verkauf stehenden Münzen, Medaillen und Banknoten.']],
            ['type' => 'split_item', 'title' => 'FENAP', 'image' => ['file' => 'fenap.png', 'alt' => 'FENAP'], 'paragraphs' => ['Die <strong>Europäische Föderation Professioneller Numismatischer Vereinigungen</strong> koordiniert die nationalen europäischen Verbände professioneller Numismatiker und ist Ansprechpartner gegenüber den Gemeinschaftsinstitutionen.']],
            ['type' => 'split_item', 'title' => 'Società Numismatica Italiana', 'image' => ['file' => 'societa_numismatica_1.png', 'alt' => 'Società Numismatica Italiana'], 'paragraphs' => ['1892 gegründeter Kulturverein, der unter seinen Mitgliedern die bedeutendsten italienischen Gelehrten und Sammler jener Zeit vereinte.']],
            ['type' => 'split_item', 'title' => 'N.I.A.', 'image' => ['file' => 'nia.png', 'alt' => 'NIA'], 'paragraphs' => ['Die <strong>Numismatici Italiani Associati</strong> vereinen professionelle Numismatiker, Sammler, Gelehrte und Sachverständige im gemeinsamen Interesse, die Numismatik in all ihren Aspekten zu fördern.']],
            ['type' => 'split_item', 'title' => 'CINOA', 'image' => ['file' => 'cinoa.png', 'alt' => 'CINOA'], 'paragraphs' => ['Internationale Föderation gemeinnütziger Vereinigungen, die mehr als 5.000 Händler für Antiquitäten und Kunst in 22 Ländern vertritt. Die Mitgliedschaft verpflichtet die Mitglieder zur Einhaltung hoher Qualitäts- und Kompetenzstandards.']],
            ['type' => 'split_item', 'title' => 'A.F.I.P.', 'image' => ['file' => 'afip.png', 'alt' => 'AFIP'], 'paragraphs' => ['Die <strong>Associazione Filatelisti Italiani Professionisti</strong> vereint die Mehrheit der Berufstätigen des Sektors und garantiert Sammlern Arbeitsregeln und eine strenge Satzung.']],
            ['type' => 'split_item', 'title' => 'IFISDA', 'image' => ['file' => 'ifisda_1.png', 'alt' => 'IFISDA'], 'paragraphs' => ['Die <strong>International Federation Of Stamp Dealers Associations</strong> koordiniert die nationalen Verbände der Briefmarkenhändler.']],
            ['type' => 'split_item', 'title' => 'Royal Numismatic Society', 'image' => ['file' => 'royal_numismatic_society_2fp0zp4l.png', 'alt' => 'Royal Numismatic Society'], 'paragraphs' => ['Britische Vereinigung, 1836 für numismatische Studien zu Münzen, Medaillen und münzbezogenen Gegenständen gegründet, mit internationalem Interesse und Mitgliedern.']],
            ['type' => 'split_item', 'title' => 'Confesercenti', 'image' => ['file' => 'confesercenti.png', 'alt' => 'Confesercenti'], 'paragraphs' => ['1971 in Rom gegründet, ist sie eine der wichtigsten Unternehmerverbände Italiens. Sie vertritt Handel, Tourismus, Dienstleistungen, Handwerk und KMU mit über 350.000 angeschlossenen Unternehmen.']],
        ],
    ],
];

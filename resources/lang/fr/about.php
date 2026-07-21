<?php

return [
    'presentation' => [
        'title' => 'Nous nous présentons',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => ['file' => 'moruzzi_nello_new.jpg', 'alt' => 'Nello Moruzzi'],
                'paragraphs' => [
                    'Moruzzi Numismatica est née de la passion et de l\'expérience professionnelle de mon père Nello Moruzzi, numismate italien connu et estimé depuis les années 1960.',
                    'Pendant de nombreuses années, il a collaboré avec son collègue Federico Bartoli, contribuant au succès de sa société, A & B Numismatica. Au-delà de ses qualités d\'homme généreux et honnête, il nous a transmis sa passion pour la numismatique ainsi que son immense bagage culturel et professionnel. En mai 1980, il nous a confié l\'entreprise, mais il a continué à nous conseiller et à nous encourager afin que cette merveilleuse activité devienne toujours plus professionnelle et importante. Une continuité de plus de cinquante ans a fait de notre boutique une réalité historique, devenue au fil du temps un point de référence pour le collectionnisme numismatique italien.',
                ],
            ],
            [
                'type' => 'split_panel',
                'paragraphs' => [
                    'Il nous a quittés en 1996, mais son souvenir et ses conseils sont encore bien présents en nous et animent toujours notre travail.',
                    'Aujourd\'hui, notre activité est principalement orientée vers la numismatique ancienne et moderne : nous recherchons les meilleures pièces non seulement sur le marché national, mais aussi – et surtout – en Europe et dans le monde, ainsi que dans les ventes aux enchères les plus importantes du secteur. Nos propositions sont soigneusement examinées afin de garantir l\'authenticité, de déterminer l\'état de conservation exact et d\'en établir une évaluation correcte. Historiquement, Moruzzi Numismatica accorde une grande attention au collectionnisme des billets de banque, malgré un certain snobisme de la part de nombreux professionnels de la numismatique qui, surtout par le passé, ont traité ce domaine avec une certaine désinvolture.',
                ],
                'carousel' => [
                    'prev_label' => 'Image précédente',
                    'next_label' => 'Image suivante',
                    'items' => [
                        ['file' => 'moruzzi_oldshop2.jpg', 'alt' => 'Ancienne boutique Moruzzi Numismatica à Rome', 'caption' => 'Ancienne boutique Moruzzi Numismatica à Rome'],
                        ['file' => 'moruzzi_newshop.png', 'alt' => 'Boutique actuelle Moruzzi Numismatica à Rome', 'caption' => 'Boutique Moruzzi Numismatica à Rome'],
                    ],
                ],
            ],
            [
                'type' => 'split_item',
                'anchor' => 'dove-siamo',
                'image' => ['file' => 'moruzzi_newshop.png', 'alt' => 'Boutique Moruzzi Numismatica à Rome, quartier Cinecittà'],
                'title' => 'Où nous trouver',
                'paragraphs' => [
                    'Vous souhaitez commencer une collection ? Vous avez des monnaies à vendre ? Vous êtes au bon endroit ! <strong>Moruzzi Numismatica</strong>, boutique numismatique historique de Rome facilement accessible, vous offre transparence et le grand professionnalisme de son <a href="/fr/qui-sommes-nous/notre-equipe">équipe</a>.',
                    '<strong>Moruzzi Numismatica</strong><br>Viale dei Salesiani, 12a<br>00175 Rome, Italie',
                    'La boutique et les bureaux sont situés dans le quartier Cinecittà, zone bien desservie par les transports. Des parkings publics et un garage sont à proximité. La station de métro <strong>Giulio Agricola</strong> (ligne A) est à environ 250 mètres.',
                ],
            ],
            [
                'type' => 'cta',
                'url' => '/fr/contact',
                'label' => 'Itinéraire et contact',
                'title' => 'Comment nous rejoindre et nous contacter',
                'text' => 'Pour des indications détaillées (voiture, train, aéroports) et pour nous écrire, consultez la page contact.',
            ],
        ],
    ],

    'staff' => [
        'title' => 'L\'équipe',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Une équipe de professionnels qualifiés dans le domaine de la numismatique est à votre service pour vous conduire, à travers les monnaies, sur les sentiers de l\'histoire.',
                    'La <strong>Qualité Moruzzi</strong>, fruit de nos ressources professionnelles bénéficiant d\'une longue expérience internationale, nous permet de vous garantir l\'authenticité absolue et la qualité des pièces proposées, accompagnées d\'une certification complète. Tous nos autres services sont également offerts en prenant soin du moindre détail.',
                    'La force de notre équipe qualifiée réside dans le partage d\'une même passion pour la numismatique, qui nous fait travailler comme une véritable équipe, dans un climat d\'estime et de confiance réciproques. En témoigne une activité de près de quarante ans, qui nous a permis d\'élargir nos services et de conquérir de nouvelles parts de marché.',
                ],
            ],
            [
                'type' => 'staff_grid',
                'items' => [
                    ['route' => 'about.loredana', 'file' => 'Loredana-Moruzzi02_9a6e3sk4.jpg', 'alt' => 'Loredana Moruzzi', 'name' => 'Loredana Moruzzi', 'role' => '<em>Administratrice / Responsable des ventes</em><br>CEO / Gestionnaire du showroom'],
                    ['route' => 'about.umberto', 'file' => 'Umberto-Moruzzi02.jpg', 'alt' => 'Umberto Moruzzi', 'name' => 'Umberto Moruzzi', 'role' => '<em>Directeur du département numismatique</em><br>Numismate senior'],
                    ['route' => 'about.francesca', 'file' => 'Barenghi_Francesca2_8ltw71wn.jpg', 'alt' => 'Francesca Barenghi', 'name' => 'Francesca Barenghi', 'role' => '<em>Département monnaies grecques et romaines</em><br>Numismate (Greek and Roman Coins Department)'],
                    ['route' => 'about.nicola', 'file' => 'Nicola-Mecci02.jpg', 'alt' => 'Nicola Mecci', 'name' => 'Nicola Mecci', 'role' => '<em>Ventes en ligne et marketing</em><br>Web Sales and Marketing'],
                    ['file' => 'EmanuelaPittola02.jpg', 'alt' => 'Emanuela Pittola', 'name' => 'Emanuela Pittola', 'role' => '<em>Administration</em><br>Administration'],
                    ['file' => 'Daniela-franchi02.jpg', 'alt' => 'Daniela Franchi', 'name' => 'Daniela Franchi', 'role' => '<em>Administration</em><br>Administration'],
                    ['route' => 'about.hiroko', 'file' => 'hiroko02.jpg', 'alt' => 'Hiroko Blue Lynx', 'name' => 'Hiroko Blue Lynx', 'role' => 'Assistante aux ventes<br>Sales assistant'],
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
                    'Sa profonde connaissance du secteur s\'est construite grâce à près de quarante ans d\'expérience au sein de l\'entreprise familiale. Outre l\'administration, elle est responsable des ventes. Les clients du monde entier la trouvent disponible pour répondre à leurs besoins.',
                    'De nombreux clients avec lesquels elle entretient depuis des années des relations amicales, fondées sur l\'estime mutuelle, en témoignent. Elle suit avec une grande attention la phase post-vente, en supervisant la facturation et le processus d\'expédition jusqu\'à destination.',
                    'Elle prend soin de contacter les clients qui lui confient leurs listes de recherche. Avec courtoisie et professionnalisme, elle répond à la majorité des questions des visiteurs de ce site.',
                ],
            ],
        ],
    ],

    'umberto' => [
        'title' => 'Umberto Moruzzi',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => ['file' => 'Umberto-Moruzzi01_08hsgn2j.jpg', 'alt' => 'Umberto Moruzzi - Expert numismatique à Rome'],
                'paragraphs' => [
                    'Umberto Moruzzi, chercheur en numismatique, a perpétué la tradition paternelle en se spécialisant notamment dans la monnaie romaine et italienne. Il s\'est occupé de Moruzzi Numismatica dès 1980, la conduisant à la notoriété d\'aujourd\'hui, l\'une des maisons numismatiques les plus réputées d\'Italie.',
                    'Il se consacre aujourd\'hui principalement à son activité professionnelle de consultant numismatique, tout en suivant l\'entreprise familiale, encore aujourd\'hui propriété de la famille Moruzzi, où il vérifie les monnaies acquises et évalue les pièces les plus particulières. Inscrit à la Chambre de commerce en tant qu\'expert numismatique, il est également membre examinateur pour la numismatique et la sphragistique auprès de la commission d\'examen de la Chambre de commerce de Rome depuis 1993.',
                    'Inscrit à l\'ordre des journalistes du Latium, il écrit sur la numismatique dans les journaux spécialisés et dans la presse nationale. Il est cofondateur de la NIP, Association des Numismates Italiens Professionnels, dont il a été secrétaire de 1999 à 2001. Il s\'est également occupé de la FENAP, Fédération européenne des sociétés et associations des numismates professionnels, dont il a été secrétaire de 2000 à 2001. Il est également membre de la Royal Numismatic Society, de la Società Numismatica Italiana, de la NIA et de l\'association numismatique allemande Berufsverband des Deutschen Münzenfachhandels e.V.',
                    'Il est expert près le Tribunal de Rome et a rempli diverses missions de consultant technique pour plusieurs parquets italiens, dont ceux de Rome et de Milan, en réalisant certaines des expertises numismatiques les plus importantes de l\'après-guerre en Italie.',
                    'Il a organisé diverses expositions, dont la tournée « Il Vero e il Falso » de la Guardia di Finanza, qui a connu un grand succès.',
                    'Il a été curateur historique et scientifique pour la frappe officielle d\'Expo Milano 2015.',
                    'Il est actuellement curateur numismatique au Musée historique de la Guardia di Finanza.',
                    'Il est actuellement vice-président de l\'association professionnelle N.I.P. (Numismatici Italiani Professionisti).',
                ],
            ],
            [
                'type' => 'cta',
                'url' => 'https://www.umbertomoruzzi.it/',
                'label' => 'Site officiel',
                'title' => 'Visitez le site officiel de l\'expert numismatique Umberto Moruzzi',
                'text' => 'Pour approfondir, consulter des articles et découvrir l\'activité professionnelle d\'Umberto Moruzzi, un site dédié est disponible.',
            ],
        ],
    ],

    'nicola' => [
        'title' => 'Nicola Mecci',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => ['file' => 'Nicola-Mecci01_bu8l0fda.jpg', 'alt' => 'Nicola Mecci - Ventes en ligne'],
                'paragraphs' => [
                    'Passionné de numismatique ancienne et moderne depuis toujours, il s\'est rapproché de ce monde grâce aux enseignements d\'un collectionneur sicilien âgé.',
                    'Responsable de la vente en ligne sur les différentes plateformes informatiques (site e-commerce, boutiques sur eBay, VCoins et Ma-Shops) et des relations avec la clientèle italienne et internationale.',
                    'Il occupe le poste de responsable SEO et social media manager pour Moruzzi Numismatica.',
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
                    'Passionnée depuis son enfance par les antiquités classiques, elle a entrepris à l\'université la formation académique d\'archéologie classique. Elle a étudié la numismatique à l\'Université de Rome « Sapienza », en suivant les cours de la professeure Breglia et des professeurs Panvini Rosati et Parise. Elle a obtenu sa licence en lettres classiques avec les maximum et la louange en présentant une thèse de numismatique celto-padane.',
                    'Elle a obtenu le diplôme de spécialisation en archéologie avec les maximum et la louange, en discutant une thèse sur l\'analyse quantitative de l\'usure des monnaies et des médaillons impériaux. Elle a participé à de nombreux congrès internationaux de numismatique et publié de nombreux articles scientifiques.',
                    'Elle a obtenu une bourse d\'étude du gouvernement français, participant à une étude dirigée par le professeur J. P. Callu de l\'Ecole des Hautes Etudes, et a fréquenté les cours de numismatique à l\'Ecole Normale Supérieure tenus par le professeur J. B. Giard. Elle a obtenu un doctorat de recherche en archéologie, travaillant sur les médaillons romains impériaux dans les plus prestigieux cabinets européens.',
                    'Elle parle couramment le français et l\'italien, a une bonne familiarité avec l\'allemand et une connaissance de l\'anglais. Elle s\'occupe de la classification des monnaies anciennes et modernes et de la partie culturelle du site. Pour Moruzzi Numismatica, elle est l\'experte de la monétisation romaine.',
                ],
            ],
        ],
    ],

    'publications' => [
        'title' => 'Nos publications',
        'lead' => 'Moruzzi Numismatica a publié ou apporté une importante contribution à la publication des ouvrages suivants :',
        'blocks' => [
            ['type' => 'split_item', 'image' => ['file' => '1988.jpg', 'alt' => 'Couverture du catalogue Monete e medaglie, Roma 1988'], 'title' => 'Monete e medaglie, Roma 1988', 'paragraphs' => ['C\'était le premier catalogue présenté par Moruzzi Numismatica, qui se distinguait déjà par le soin apporté à sa réalisation et par la sélection des monnaies proposées. Le catalogue mettait en vente des monnaies grecques, romaines, italiennes (médiévales et modernes), pontificales et autres.']],
            ['type' => 'split_item', 'image' => ['file' => '1992.jpg', 'alt' => 'Couverture du catalogue de vente aux enchères publiques, Roma 28 febbraio 1992'], 'title' => 'Monete, medaglie e banconote. Asta pubblica, Roma 28 febbraio 1992', 'paragraphs' => ['Le catalogue de vente aux enchères de Moruzzi Arte Roma, avec monnaies anciennes et modernes, a connu un notable succès commercial et public.']],
            ['type' => 'split_item', 'image' => ['file' => '1994.jpg', 'alt' => 'Couverture Le banconote del mondo, Roma 1994'], 'title' => 'Le banconote del mondo, Roma 1994', 'paragraphs' => ['Liste de vente de billets de banque du monde entier. Dans les années 1990, les billets de banque ont été « découverts » par un grand nombre de collectionneurs italiens.']],
            ['type' => 'split_item', 'image' => ['file' => '1995a.jpg', 'alt' => 'Couverture Argent, Le banconote d\'Italia, Roma 1995'], 'title' => 'Argent, Le banconote d\'Italia, Roma 1995', 'paragraphs' => ['La demande de billets italiens était particulièrement élevée et Moruzzi Numismatica, attentive à la demande des collectionneurs, proposait une collection de billets de niveau remarquable, tant par la qualité que par la rareté.']],
            ['type' => 'split_item', 'image' => ['file' => '1995.jpg', 'alt' => 'Couverture Excellence, Roma 1995'], 'title' => 'Excellence, Roma 1995', 'paragraphs' => ['Un catalogue proposant des monnaies grecques, romaines, byzantines, italiennes et étrangères particulièrement sélectionnées. Au centre du catalogue figurait une double page imprimée avec les images en couleur des meilleurs exemplaires présentés.']],
            ['type' => 'split_item', 'image' => ['file' => '1997.jpg', 'alt' => 'Couverture Jvlia, Roma 1997'], 'title' => 'Jvlia, Roma 1997', 'paragraphs' => ['Le catalogue inaugurait une série de publications portant les noms des plus anciennes gentes romaines. La gens Julia fut choisie en premier. De standard international, le catalogue proposait des monnaies anciennes, modernes italiennes et étrangères de très bonne qualité.']],
            ['type' => 'split_item', 'image' => ['file' => '1998.jpg', 'alt' => 'Couverture Claudia, Roma 1998'], 'title' => 'Claudia, Roma 1998', 'paragraphs' => ['Le catalogue de vente à prix nets poursuivait la série de publications inaugurée avec Jvlia, proposant des monnaies anciennes d\'une rare beauté et conservation, mais aussi des collections de monnaies des ateliers italiens, papaux et du Royaume d\'Italie.']],
            ['type' => 'split_item', 'image' => ['file' => '1990.jpg', 'alt' => 'Couverture Una collezione di antoniniani, Roma 1990'], 'title' => 'Una collezione di antoniniani. Vendita generale di monete e medaglie, Roma 1990', 'paragraphs' => ['Le catalogue proposait une très riche collection de 1 000 antoniniens différents, précédée d\'une intéressante introduction historique. C\'est encore aujourd\'hui une publication recherchée par les chercheurs.']],
            ['type' => 'split_item', 'image' => ['file' => '1992cassettas.jpg', 'alt' => 'Vidéocatalogue de la vente aux enchères publiques du 28 février 1992'], 'title' => 'Videocatalogo dell\'asta pubblica del 28 febbraio 1992', 'paragraphs' => ['Le vidéocatalogue de la vente aux enchères de Moruzzi Arte Roma avec monnaies anciennes et modernes. La cassette avec musique classique en fond sonore était à l\'époque unique en son genre et permettait de voir en vidéo les images agrandies des monnaies mises en vente.']],
            ['type' => 'split_item', 'image' => ['file' => '2002.jpg', 'alt' => 'Couverture Addio alla Lira, Roma 2002'], 'title' => 'Addio alla Lira. Tre secoli di storia italiana attraverso le banconote, Roma 2002', 'paragraphs' => ['Avec ce catalogue, nous avons adressé un nostalgique adieu à l\'ancienne lire : un adieu seulement formel à sa circulation comme monnaie, car elle reste dans l\'histoire de tous les Italiens, dans la mémoire collective et dans celle de chaque individu.']],
            ['type' => 'split_item', 'image' => ['file' => '2006es.jpg', 'alt' => 'Couverture Una collezione di Medaglie - Estate 2006'], 'title' => 'Una collezione di Medaglie - Estate 2006, Roma', 'paragraphs' => ['Catalogue réalisé en collaboration avec la maison numismatique A&B. Une belle sélection de médailles, pour la quasi-totalité pontificales, avec des exemplaires rares et quelques notes intéressantes.']],
            ['type' => 'split_item', 'image' => ['file' => '2007s.jpg', 'alt' => 'Couverture FLAVIA 2007'], 'title' => 'FLAVIA 2007, Roma 2007', 'paragraphs' => ['Un splendide petit catalogue qui a connu un grand succès avec des monnaies très sélectionnées, classées par thèmes : portraits des augustes, moyens bronzes impériaux, empire gaulois, deniers impériaux, argent de la Rome républicaine et monnaies de l\'empire et des provinces romaines.']],
            ['type' => 'split_item', 'image' => ['file' => 'il-vero-e-il-falso_1.jpg', 'alt' => 'Couverture IL VERO e IL FALSO, Roma 2008'], 'title' => 'IL VERO e IL FALSO, Roma 2008', 'paragraphs' => ['Catalogue de l\'exposition itinérante éponyme déjà présentée à Rome, Florence, Vicence et Pérouse. Il retrace l\'évolution du phénomène de la contrefaçon à travers des monnaies anciennes, médiévales et modernes, ainsi que des billets de la Banque d\'Italie.']],
            ['type' => 'split_item', 'image' => ['file' => '2006as.jpg', 'alt' => 'Couverture Una collezione di Medaglie - Autunno 2006'], 'title' => 'Una collezione di Medaglie - Autunno 2006, Roma', 'paragraphs' => ['Catalogue réalisé en collaboration avec A&B. Parmi les médailles figurait une importante collection de la Sede Vacante et la médaille italienne en or commémorant le bimillénaire de la mort de Virgile, unique exemplaire connu.']],
            ['type' => 'split_item', 'image' => ['file' => '2008s.jpg', 'alt' => 'Couverture CLAVDIA 2008'], 'title' => 'CLAVDIA 2008, Roma 2008', 'paragraphs' => ['Un catalogue dans la tradition Moruzzi, très recherché dans le monde entier rien que pour le plaisir de le lire. Deux importantes collections y étaient présentées : les frappes de Néron et les monnaies en bronze du monde grec.']],
            ['type' => 'split_item', 'image' => ['file' => 'il-vero-e-il-falso_2.jpg', 'alt' => 'Couverture IL VERO e IL FALSO, Milano 2013'], 'title' => 'IL VERO e IL FALSO, La Guardia di Finanza in Lombardia, Milano 2013', 'paragraphs' => ['Catalogue de l\'exposition itinérante organisée par Umberto Moruzzi en collaboration avec la GDF. « Les hommes produisent souvent de la fausse monnaie, mais bien plus souvent la monnaie produit de faux hommes » (J. Harris). Monnaies authentiques exposées aux côtés de leurs contrefaçons, presque parfaites.']],
        ],
    ],

    'press' => [
        'title' => 'On parle de nous',
        'blocks' => [
            [
                'type' => 'split_item',
                'image' => ['file' => 'lire500000.jpg', 'alt' => 'Billet de 500 000 lires type Raffaello'],
                'title' => 'In giro ancora 2550 miliardi di lire',
                'meta' => 'Il Messaggero — 14 juillet 2010, Rome',
                'paragraphs' => [
                    '... <strong>Umberto Moruzzi</strong>, spécialiste du papier-monnaie et propriétaire de l\'une des boutiques numismatiques les plus établies d\'Italie, à Rome, dans le quartier de Cinecittà, parle d\'un « intérêt diffus et croissant, souvent amateur, pour la collection des anciennes lires, surtout de l\'époque républicaine ». Une véritable « lira-mania », où la nostalgie pour une monnaie qui ne reviendra jamais se combine à la capacité des billets et des monnaies d\'évoquer les grands et petits moments de la biographie de chacun. — ROBERTO FABEN',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'lire-500-medusas.jpg', 'alt' => 'Billet de 500 lires de la Banque d\'Italie'],
                'title' => 'Rarità e biglietti integri meritano una perizia',
                'meta' => 'Il Sole 24 Ore — 21 septembre 2009',
                'paragraphs' => [
                    '« Avec la mise à la retraite de l\'ancienne lire, une armée de nouveaux collectionneurs est née... » Ainsi explique le « filon lire » Umberto Moruzzi, expert numismatique et propriétaire, avec sa sœur Loredana, de la boutique Moruzzi Numismatica à Cinecittà. « Les billets et monnaies en lires peuvent constituer un investissement... » Quiconque possède chez lui d\'anciens billets peut les faire évaluer dans une boutique numismatique : en Italie, il en existe environ 350, mais les adhérents à l\'association NIP offrent de plus grandes garanties. Parmi les billets les plus récents, on signale le billet de 500 lires « Barbetti » avec le contrôle « Medusa » du 14 novembre 1950 : en bon état, il vaut environ 20 000 euros. — ROBERTO FABEN',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'lamoneta_1.jpg', 'alt' => 'Forum numismatique Lamoneta'],
                'title' => 'Le porte del tempio di Giano — Significato sulle monete',
                'meta' => 'Lamoneta.it — 26 novembre 2008',
                'paragraphs' => [
                    'En recherchant des textes sur l\'origine du sens de la légende <em>CLAVSO IANI TEMPLO GAVDIVM SECVLI</em>, je suis tombé sur un bel article de Francesca Barenghi, collaboratrice de Moruzzi. Je le reproduis intégralement ici, car je le juge très utile à cette fin.',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'premio_moruzzi_numismatica.jpg', 'alt' => 'Prix Ben Hur - Cinecittà 2006'],
                'title' => 'Premio Ben Hur — Cinecittà 2006',
                'meta' => 'Comune di Roma X Municipio — 21 juillet 2006',
                'paragraphs' => [
                    'Lors d\'une fête, des prix ont été remis aux commerçants romains du petit commerce qui se sont distingués par leur longévité dans le municipio. Le prix Ben Hur a également été décerné à Moruzzi Numismatica, entreprise comptant 26 ans d\'activité, l\'une des plus anciennes de Rome dans le secteur. Moruzzi Numismatica doit sa reconnaissance à une indiscutable professionnalité qui lui a permis de rester sur le marché et d\'attirer à Rome, au fil des années, une multitude de collectionneurs-touristes.',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'vetrina.jpg', 'alt' => 'Vitrine de Moruzzi Numismatica à Rome'],
                'title' => 'Il cielo più grande del mondo sopra i palazzoni di Cinecittà',
                'meta' => 'La Repubblica — 27 février 2002, Rome',
                'paragraphs' => [
                    '... Sous les portiques de la place, devant les vitrines d\'une boutique numismatique, je m\'arrête pour lire les noms des monnaies exposées... S\'il existe une boutique de ce type, on peut imaginer un collectionneur heureux... on peut affirmer qu\'il y a de la vie à Cinecittà, et même qu\'il y a de la vie sur Terre. — FULVIO ABBATE',
                ],
            ],
        ],
    ],

    'memberships' => [
        'title' => 'Memberships',
        'lead' => 'Moruzzi Numismatica, ses associés et ses collaborateurs sont inscrits à plusieurs associations de premier plan.',
        'blocks' => [
            ['type' => 'split_item', 'title' => 'IAPN-AINP', 'image' => ['file' => 'IAPN01.jpg', 'alt' => 'IAPN AINP'], 'paragraphs' => ['L\'<strong>Association internationale des numismates professionnels</strong> est l\'une des organisations à but non lucratif les plus importantes au monde, notamment pour son rôle dans la garantie et la coordination visant à protéger le marché et le collectionnisme éthique. Fondée en 1951 à Genève, elle compte aujourd\'hui plus de 114 entreprises numismatiques dans vingt-trois pays.']],
            ['type' => 'split_item', 'title' => 'NIP — Numismatici Italiani Professionisti', 'image' => ['file' => 'nip.png', 'alt' => 'NIP'], 'paragraphs' => ['Les NIP visent à promouvoir un marché numismatique animé par les meilleurs principes d\'éthique professionnelle et commerciale ; ils encouragent l\'étude scientifique et la diffusion de la numismatique et luttent contre les contrefaçons.']],
            ['type' => 'split_item', 'title' => 'Berufsverband des Deutschen Münzenfachhandels e.V.', 'image' => ['file' => 'Berufsverband-des-Deutschen-Muenzenfachhandels-e.V.png', 'alt' => 'Berufsverband'], 'paragraphs' => ['Importante association professionnelle allemande de numismates dont Moruzzi Numismatica est membre depuis 2012. Les adhérents garantissent l\'authenticité des monnaies, médailles et billets mis en vente.']],
            ['type' => 'split_item', 'title' => 'FENAP', 'image' => ['file' => 'fenap.png', 'alt' => 'FENAP'], 'paragraphs' => ['La <strong>Fédération européenne des associations numismatiques professionnelles</strong> coordonne les associations nationales européennes des numismates professionnels et fait office de référent auprès des institutions communautaires.']],
            ['type' => 'split_item', 'title' => 'Società Numismatica Italiana', 'image' => ['file' => 'societa_numismatica_1.png', 'alt' => 'Società Numismatica Italiana'], 'paragraphs' => ['Association culturelle fondée en 1892 qui a accueilli parmi ses membres les plus grands chercheurs et collectionneurs italiens de l\'époque.']],
            ['type' => 'split_item', 'title' => 'N.I.A.', 'image' => ['file' => 'nia.png', 'alt' => 'NIA'], 'paragraphs' => ['Les <strong>Numismatici Italiani Associati</strong> réunissent numismates professionnels, collectionneurs, chercheurs et experts autour de l\'intérêt commun de promouvoir la numismatique sous tous ses aspects.']],
            ['type' => 'split_item', 'title' => 'CINOA', 'image' => ['file' => 'cinoa.png', 'alt' => 'CINOA'], 'paragraphs' => ['Fédération internationale d\'associations à but non lucratif représentant plus de 5 000 marchands d\'antiquités et d\'art dans 22 pays. L\'adhésion engage les membres à respecter des normes élevées de qualité et de compétence.']],
            ['type' => 'split_item', 'title' => 'A.F.I.P.', 'image' => ['file' => 'afip.png', 'alt' => 'AFIP'], 'paragraphs' => ['L\'<strong>Associazione Filatelisti Italiani Professionisti</strong> regroupe la majorité des professionnels du secteur, garantissant aux collectionneurs des règles de travail et un statut rigoureux.']],
            ['type' => 'split_item', 'title' => 'IFISDA', 'image' => ['file' => 'ifisda_1.png', 'alt' => 'IFISDA'], 'paragraphs' => ['L\'<strong>International Federation Of Stamp Dealers Associations</strong> coordonne les associations nationales des marchands de timbres.']],
            ['type' => 'split_item', 'title' => 'Royal Numismatic Society', 'image' => ['file' => 'royal_numismatic_society_2fp0zp4l.png', 'alt' => 'Royal Numismatic Society'], 'paragraphs' => ['Association britannique fondée en 1836 pour les études numismatiques sur les monnaies, médailles et éléments associés à la monnaie, avec un intérêt et des membres internationaux.']],
            ['type' => 'split_item', 'title' => 'Confesercenti', 'image' => ['file' => 'confesercenti.png', 'alt' => 'Confesercenti'], 'paragraphs' => ['Fondée à Rome en 1971, c\'est l\'une des principales associations d\'entreprises en Italie. Elle représente le commerce, le tourisme, les services, l\'artisanat et les PME, avec plus de 350 000 entreprises adhérentes.']],
        ],
    ],
];

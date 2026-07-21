<?php

$certNote = 'Il est possible de demander, au coût de € 8,00, la certification comprenant l\'étiquette avec QR code, le certificat photographique et en ligne pour toutes les pièces, médailles ou billets achetés chez Moruzzi Numismatica à partir de 2009, qui ne disposent pas encore de cette documentation.';

return [
    'common' => [
        'appointment_title' => 'Rendez-vous recommandé',
        'appointment_text' => 'Avant de vous rendre en boutique, contactez-nous au +39 06 7151 0220 pour prendre rendez-vous.',
        'pricing_note' => 'Les honoraires comprennent les taxes et frais.',
        'perizia_detail' => 'Comprend l\'apposition de sceaux sur la pochette et sur l\'étiquette descriptive, la certification photographique et le QR code pour la consultation numérique.',
    ],

    'online' => [
        'title' => 'Certificat en ligne',
        'lead' => 'Le certificat en ligne Moruzzi Numismatica, relié au QR code présent sur l\'étiquette, permet de vérifier d\'un simple clic la description, les images et la provenance des pièces achetées.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Les pièces de Moruzzi Numismatica bénéficient d\'une valeur ajoutée supplémentaire grâce à l\'ensemble des éléments contenus dans l\'étiquette codifiée qui les accompagne. Ce document sert à décrire l\'exemplaire, à attester sa qualité, à garantir son authenticité et sa provenance licite.',
                    'Le prix indiqué est le résultat d\'une évaluation correcte de la correspondance entre le degré de rareté, l\'état de conservation et les autres variables de la pièce.',
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Vérification avec votre smartphone',
                'paragraphs' => [
                    'Pour une protection accrue de notre clientèle, nous avons également intégré le QR code dans l\'étiquette et le certificat. Avec un lecteur téléchargeable gratuitement sur tous les smartphones, ou via le lien exclusif indiqué sur le certificat papier, il est possible de consulter en ligne la description complète, les références de provenance et les photos de l\'avers et du revers.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                   ['file' => 'certificato_qr01.jpg', 'alt' => 'Détail du QR code sur le certificat', 'caption' => 'Consultation numérique immédiate'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'Moruzzi Numismatica est la première entreprise numismatique au monde à garantir ses pièces <strong>sans avoir à les sceller</strong> dans du plastique rigide (slab), comme cela se pratique aux États-Unis. Les collectionneurs italiens et européens peuvent ainsi conserver un contact direct avec les pièces de leur collection.',
                    'Le certificat en ligne permet de vérifier, également grâce aux photos haute qualité, l\'origine et la qualité des pièces provenant de notre maison : une avancée en matière de transparence et de sécurité des achats. La certification est infalsifiable car garantie par une page web dédiée et non modifiable.',
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Note importante',
                'paragraphs' => [
                    'Par précaution, afin d\'éviter les arnaques ou les fraudes, assurez-vous que le lien indiqué sur le certificat photographique commence toujours par <strong>https://www.moruzzi.it/</strong>.',
                    'Le certificat papier, délivré et expédié également pour les achats en ligne, présente le QR code pour la vérification via smartphone ou via l\'adresse internet indiquée sur le document.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-QR01.jpg', 'alt' => 'Légende des éléments de l\'étiquette avec QR code'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'quality' => [
        'title' => 'Certification de qualité Moruzzi',
        'lead' => 'La certification de qualité Moruzzi résume clairement l\'état de conservation, la rareté, le métal et la provenance, en apportant une valeur ajoutée importante au collectionneur.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Les pièces de Moruzzi Numismatica bénéficient également d\'une valeur ajoutée grâce à l\'ensemble des éléments contenus dans l\'étiquette qui les accompagne. L\'étiquette remplit la double fonction de décrire l\'exemplaire et d\'en garantir l\'originalité ; le prix indiqué est le résultat d\'une correspondance correcte entre l\'état de conservation, le degré de rareté et les autres variables.',
                    'Aujourd\'hui, l\'étiquette comprend également un <strong>QR code</strong>, sans rien perdre par rapport à l\'étiquette classique : avec un lecteur disponible dans des applications gratuites pour iPhone, iPad, iPod et smartphones Android, il est possible de lire le certificat descriptif complet avec provenance et photos de l\'avers et du revers.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-cartellino.jpg', 'alt' => 'Légende de l\'étiquette Moruzzi Numismatica', 'caption' => 'L\'étiquette classique, toujours valable'],
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-QR01_p23l4f70.jpg', 'alt' => 'Étiquette avec QR code', 'caption' => 'La nouvelle certification numérique'],
                ],
            ],
            [
                'type' => 'features',
                'title' => 'Contenu de l\'étiquette',
                'items' => [
                    ['title' => 'Description complète', 'text' => 'Autorité émettrice, période historique, type de pièce, année et atelier lorsqu\'ils sont connus, légendes ou descriptions de l\'avers et du revers.'],
                    ['title' => 'Bibliographie et rareté', 'text' => 'Jusqu\'à trois publications de référence avec numéros identificatifs et, souvent, le degré de rareté indiqué par les auteurs.'],
                    ['title' => 'Provenance et transparence', 'text' => 'Indication du pedigree lorsqu\'il est public (ventes prestigieuses, collections connues) et code alphanumérique pour en vérifier la provenance à tout moment.'],
                    ['title' => 'Métal, poids et prix', 'text' => 'Métal, poids au centième de gramme, échelle de rareté de 1 à 5 R et état de conservation clairement indiqué avec le prix.'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Garantie sans expiration',
                'paragraphs' => [
                    'Conformément à l\'art. 64 du D.Lgs. 42/2004 (Code des biens culturels), l\'étiquette est garantie d\'authenticité absolue et de tout ce qui y est indiqué. La Garantie Moruzzi Numismatica sur l\'originalité des pièces vendues <strong>n\'expire jamais</strong> et vaut également pour la catalogation correcte et l\'indication exacte de l\'état de conservation.',
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'guarantee' => [
        'title' => 'Garantie Moruzzi Numismatica',
        'lead' => 'La Garantie Moruzzi Numismatica est à durée indéterminée : elle protège l\'authenticité, la catalogation correcte et l\'état de conservation de chaque exemplaire vendu.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Le premier indice de sérieux de notre maison est la confiance que nos clients nous accordent depuis plus de trente ans. Néanmoins, nous offrons une garantie formelle sur les objets numismatiques que nous mettons en vente : la <strong>Garantie Moruzzi Numismatica</strong>.',
                    'La loi prévoit, comme le stipule l\'art. 64 du D.Lgs. 42/2004, de remettre à l\'acheteur un certificat de garantie et de provenance. Moruzzi Numismatica va plus loin : elle assure aux pièces et billets de collection vendus une garantie illimitée dans le temps, tant sur l\'authenticité que sur toutes les caractéristiques indiquées sur l\'étiquette.',
                ],
            ],
            [
                'type' => 'images',
                'items' => [
                    ['file' => 'riempitivo_garanzia.jpg', 'alt' => 'Garantie Moruzzi Numismatica', 'caption' => 'Garantie à durée indéterminée'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Ce que couvre la garantie',
                'paragraphs' => [
                    'La garantie sur l\'originalité des pièces vendues n\'expire jamais et vaut non seulement pour l\'authenticité du bien, mais aussi pour la catalogation correcte et surtout pour l\'indication exacte de l\'état de conservation.',
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'Toute personne exerçant l\'activité de vente au public d\'œuvres d\'art, d\'objets d\'antiquité ou d\'intérêt historique ou archéologique a l\'obligation de remettre à l\'acheteur la documentation attestant l\'authenticité ou au moins la probable attribution et la provenance ; à défaut, elle doit délivrer une déclaration avec toutes les informations disponibles, de préférence apposée sur une copie photographique de l\'objet.',
                ],
            ],
        ],
    ],

    'attestati' => [
        'title' => 'Certificats de garantie et de provenance',
        'lead' => 'Les certificats de garantie et de provenance accompagnent les monnaies anciennes avec une documentation complète, des images et des références aux registres d\'entrée.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Les monnaies anciennes vendues par Moruzzi Numismatica sont accompagnées de ce document important. Il s\'agit d\'une certification qui intègre largement les obligations légales et répond aux exigences du collectionneur moderne, qui souhaite conserver avec les pièces une documentation aussi complète que possible.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'cetificati_mn1.jpg', 'alt' => 'Certificat de garantie et de provenance Moruzzi', 'caption' => 'Certificat de garantie et de provenance'],
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'certificato_qr01_b4ubt21n.jpg', 'alt' => 'Certificat avec QR code', 'caption' => 'Vérification en ligne via QR code'],
                ],
            ],
            [
                'type' => 'features',
                'title' => 'Contenu du certificat',
                'items' => [
                    ['title' => 'Description et bibliographie', 'text' => 'Description complète de la pièce avec références bibliographiques et photos de l\'avers et du revers.'],
                    ['title' => 'Code unique', 'text' => 'Code identificatif, rareté, poids et état de conservation pour une consultation rapide et transparente.'],
                    ['title' => 'Provenance licite', 'text' => 'Garantie d\'originalité et de provenance licite avec numéros des registres où l\'exemplaire est inscrit.'],
                    ['title' => 'Vérification numérique', 'text' => 'QR code pour consulter le certificat en ligne depuis un smartphone ou via un code web dédié.'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'standard' => [
        'title' => 'Standard qualitatif',
        'lead' => 'Chaque proposition Moruzzi Numismatica respecte des standards élevés de conservation, d\'esthétique et de technique, illustrés également par des histogrammes dédiés aux différents paramètres.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Nos pièces, médailles et billets sont sélectionnés selon des standards élevés de conservation, d\'esthétique et de technique. Certaines des propositions les plus intéressantes sont accompagnées dans les fiches de l\'e-commerce par des histogrammes, en plus de la description qui accompagne toutes nos propositions.',
                ],
            ],
            [
                'type' => 'images',
                'items' => [
                    ['file' => 'augusto_denario01.jpg', 'alt' => 'Denier d\'Auguste', 'caption' => 'Exemple de pièce de haute qualité'],
                    ['file' => '141943a.jpg', 'alt' => 'Détail de conservation d\'une monnaie antique'],
                ],
            ],
            [
                'type' => 'meters',
                'title' => 'Les six paramètres d\'évaluation',
                'items' => [
                    ['label' => 'Conservation', 'value' => '82%', 'hint' => 'Échelle européenne / Sheldon', 'text' => 'De D (discret) à FDC (fleur de coin), exprimée également en soixante-dixièmes pour les collectionneurs américains et asiatiques.'],
                    ['label' => 'Rareté', 'value' => '68%', 'hint' => 'De C à RRRRRR', 'text' => 'Pourcentage allant de valeurs basses pour les pièces communes jusqu\'à 100 % pour les exemplaires uniques ou quasi uniques.'],
                    ['label' => 'Métal et patine', 'value' => '74%', 'hint' => 'Qualité de l\'alliage', 'text' => 'Évaluation des dommages dus à la frappe, à l\'usure dans le temps et aux nettoyages inappropriés ; une patine de qualité constitue une valeur ajoutée.'],
                    ['label' => 'Style', 'value' => '88%', 'hint' => 'Finesse artistique', 'text' => 'Le style des coins peut être plus important que l\'état de conservation dans les productions numismatiques les plus artistiques.'],
                    ['label' => 'Frappe', 'value' => '76%', 'hint' => 'Qualité de production', 'text' => 'Examen des fractures, des glissements de coin et de la qualité du coup de matrice qui met en relief les reliefs.'],
                    ['label' => 'Provenance', 'value' => '62%', 'hint' => 'Pedigree', 'text' => 'Ventes aux enchères, boutiques et collections prestigieuses augmentent le pourcentage par rapport aux provenances tracées seulement récemment.'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'Les objets qui ne répondent pas à ces caractéristiques de qualité sont proposés à des conditions particulièrement avantageuses. Chaque pièce proposée par Moruzzi Numismatica a une provenance absolument licite et est inscrite dans les registres des autorités compétentes.',
                ],
            ],
        ],
    ],

    'upgrade' => [
        'title' => 'Upgrade de la qualité',
        'lead' => 'Le service d\'upgrade de la qualité permet de remplacer des exemplaires déjà achetés par d\'autres de qualité supérieure, en ne payant que la différence de prix.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Chaque collectionneur, au début de sa collection, se contente souvent d\'exemplaires peu coûteux et peu bien conservés. Avec le temps, le goût s\'affine et les premières pièces achetées peuvent ne plus satisfaire. C\'est pourquoi existe la promotion upgrade de Moruzzi Numismatica.',
                    'Tout le monde ne peut pas se permettre immédiatement la qualité top : pour « combler un trou » dans la collection, on peut se contenter d\'un exemplaire moins beau, avec la possibilité de le remplacer ultérieurement par un exemplaire de qualité supérieure.',
                ],
            ],
            [
                'type' => 'upgrade_flow',
                'steps' => [
                    ['file' => 'promozionea.jpg', 'alt' => 'Exemplaire de qualité inférieure', 'caption' => 'Exemplaire déjà en collection'],
                    ['file' => 'promozione.jpg', 'alt' => 'Exemplaire de qualité supérieure', 'caption' => 'Upgrade disponible en boutique'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Comment ça fonctionne',
                'paragraphs' => [
                    'À ceux qui ont effectué au moins <strong>trois achats au cours des deux dernières années</strong> est reconnue la possibilité de remplacer les pièces achetées chez Moruzzi Numismatica par des exemplaires de meilleure qualité, en ne versant que la différence de prix ; l\'exemplaire restitué est évalué au prix payé.',
                    'Exemple : pour améliorer une pièce de 10 lires de 1927 en BB achetée à € 30,00 avec une SPL à € 100,00, il suffit de verser € 70,00. La promotion vaut pour les pièces (anciennes, modernes et contemporaines) et les billets, uniquement si les exemplaires de remplacement sont disponibles et si les pièces restituées portent l\'étiquette Moruzzi.',
                ],
            ],
        ],
    ],

    'estimates_coins' => [
        'title' => 'Estimations et expertises de monnaies',
        'appointment' => true,
        'lead' => 'Umberto Moruzzi propose des estimations et expertises de monnaies anciennes et modernes, avec enregistrement complet des données et images haute résolution.',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => [
                    'file' => 'stime-e-perizie-di-monete.jpg',
                    'alt' => 'Estimations et expertises de monnaies Moruzzi Numismatica',
                ],
                'paragraphs' => [
                    'Pour les estimations et expertises de monnaies anciennes, modernes et médailles, vous pouvez vous adresser à notre bureau de Rome, au numismate <strong>Umberto Moruzzi</strong>, expert de la Chambre de Commerce et du Tribunal de Rome.',
                    'Les services d\'expertise prévoient, dans tous les cas, l\'enregistrement complet des éléments identificatifs des exemplaires examinés et la conservation des images haute résolution, afin d\'en vérifier dans le temps la correspondance avec les certifications et catalogations délivrées.',
                    'Avec la même rigueur, nous réalisons des estimations d\'exemplaires individuels et de collections entières de pièces de collection.',
                ],
            ],
            [
                'type' => 'links',
                'title' => 'Services connexes',
                'items' => [
                    ['route' => 'certifications.expertise_coins', 'label' => 'Expertises de monnaies'],
                    ['route' => 'certifications.estimates_banknotes', 'label' => 'Estimations et expertises de billets'],
                    ['route' => 'certifications.cataloguing', 'label' => 'Catalogations'],
                    ['route' => 'certifications.valuation', 'label' => 'Évaluation de monnaies et billets'],
                ],
            ],
        ],
    ],

    'estimates_banknotes' => [
        'title' => 'Estimations et expertises de billets',
        'appointment' => true,
        'lead' => 'Service d\'estimation et d\'expertise pour billets italiens et internationaux, avec attention à la catalogation correcte et à la conservation des images de référence.',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => [
                    'file' => 'stime-e-perizie-di-banconote.jpg',
                    'alt' => 'Estimations et expertises de billets',
                ],
                'paragraphs' => [
                    'Pour les expertises de billets, vous pouvez vous adresser à notre bureau de Rome : <strong>Umberto Moruzzi</strong>, expert de la Chambre de Commerce et du Tribunal de Rome, rédige des certifications de billets et des catalogations.',
                    'Chaque service comprend l\'enregistrement complet des éléments identificatifs et la conservation des images haute résolution, pour vérifier dans le temps la correspondance entre l\'exemplaire et la documentation délivrée.',
                    'Nous réalisons également des estimations d\'exemplaires individuels et de collections entières de billets.',
                ],
            ],
            [
                'type' => 'links',
                'title' => 'Services connexes',
                'items' => [
                    ['route' => 'certifications.expertise_banknotes', 'label' => 'Expertises de billets'],
                    ['route' => 'certifications.cataloguing', 'label' => 'Catalogations'],
                    ['route' => 'certifications.valuation', 'label' => 'Évaluation de monnaies et billets'],
                ],
            ],
        ],
    ],

    'expertise_coins' => [
        'title' => 'Expertises de monnaies',
        'appointment' => true,
        'lead' => 'Expertises de monnaies anciennes, modernes et médailles, avec apposition de sceaux et certificat photographique doté de QR code pour la consultation numérique.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi, expert de la Chambre de Commerce et du Tribunal de Rome, réalise des expertises de monnaies anciennes, modernes et médailles à Rome. Tous les services comprennent l\'enregistrement complet des éléments identificatifs et la conservation des images haute résolution.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarifs expertises monnaies anciennes',
                'note' => 'Les honoraires comprennent les taxes et frais. Comprend l\'apposition de sceaux sur la pochette et sur l\'étiquette descriptive, la certification photographique et le QR code pour la consultation numérique.',
                'rows' => [
                    ['label' => 'Monnaies anciennes d\'une valeur inférieure à € 300', 'price' => '€ 30,00'],
                    ['label' => 'Monnaies anciennes d\'une valeur entre € 301 et € 1.000', 'price' => '€ 40,00'],
                    ['label' => 'Monnaies anciennes d\'une valeur entre € 1.001 et € 5.000', 'price' => '€ 70,00'],
                    ['label' => 'Monnaies anciennes d\'une valeur entre € 5.001 et € 10.000', 'price' => '€ 150,00'],
                    ['label' => 'Monnaies anciennes d\'une valeur entre € 10.001 et € 20.000', 'price' => '€ 300,00'],
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarifs expertises monnaies modernes',
                'rows' => [
                    ['label' => 'Monnaies modernes d\'une valeur inférieure à € 300', 'price' => '€ 20,00'],
                    ['label' => 'Monnaies modernes d\'une valeur entre € 301 et € 1.000', 'price' => '€ 25,00'],
                    ['label' => 'Monnaies modernes d\'une valeur entre € 1.001 et € 5.000', 'price' => '€ 50,00'],
                    ['label' => 'Monnaies modernes d\'une valeur entre € 5.001 et € 10.000', 'price' => '€ 100,00'],
                    ['label' => 'Monnaies modernes d\'une valeur entre € 10.001 et € 20.000', 'price' => '€ 200,00'],
                    ['label' => 'Expertise de médailles avec certificat photographique et indication de l\'éventuelle production contemporaine', 'price' => '€ 60,00'],
                    ['label' => 'Consultation technique numismatique en justice', 'price' => 'Sur devis'],
                ],
            ],
        ],
    ],

    'valuation' => [
        'title' => 'Évaluation de monnaies et billets',
        'appointment' => true,
        'lead' => 'Évaluations d\'exemplaires individuels et de collections de monnaies et billets, avec indication de la valeur d\'achat et de vente.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi, expert de la Chambre de Commerce et du Tribunal de Rome, réalise des évaluations de monnaies anciennes et modernes, médailles et billets à Rome, avec indication de la valeur d\'achat et de vente lorsque demandé.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarifs évaluation',
                'note' => 'Les honoraires comprennent les taxes et frais.',
                'rows' => [
                    ['label' => 'Consultation technique numismatique de complexité variable pour monnaies, médailles et papier-monnaie, également en justice', 'price' => 'Sur devis'],
                    ['label' => 'Estimation de collections ou de monnaies individuelles jusqu\'à € 6.000, avec valeur d\'achat et de vente', 'price' => '€ 378,00'],
                    ['label' => 'Estimation de collections ou de monnaies individuelles au-delà de € 6.000, avec valeur d\'achat et de vente', 'price' => '6,3% de la valeur estimée'],
                    ['label' => 'Estimations à domicile (en plus du pourcentage, déplacement à convenir)', 'price' => 'à partir de € 180,00'],
                ],
            ],
        ],
    ],

    'expertise_banknotes' => [
        'title' => 'Expertises de billets',
        'appointment' => true,
        'lead' => 'Expertises spécialisées de papier-monnaie italien et étranger, avec conservation des images et des données identificatives pour des vérifications futures.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi réalise des expertises de billets italiens et étrangers à Rome, ainsi que des catalogations. Chaque service comprend l\'enregistrement complet des éléments identificatifs et la conservation des images haute résolution.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarifs expertises billets',
                'note' => 'Les honoraires comprennent les taxes et frais.',
                'rows' => [
                    ['label' => 'Papier-monnaie italien (Billets d\'État, Bons de Caisse, Billets Banque d\'Italie) jusqu\'à € 300', 'price' => '€ 20,00'],
                    ['label' => 'Valeur entre € 301 et € 1.000', 'price' => '€ 25,00'],
                    ['label' => 'Valeur entre € 1.001 et € 5.000', 'price' => '€ 50,00'],
                    ['label' => 'Valeur entre € 5.001 et € 10.000', 'price' => '€ 100,00'],
                    ['label' => 'Valeur entre € 10.001 et € 20.000', 'price' => '€ 200,00'],
                    ['label' => 'Consultation technique numismatique en justice', 'price' => 'Sur devis'],
                ],
            ],
        ],
    ],

    'cataloguing' => [
        'title' => 'Catalogations de monnaies et billets',
        'appointment' => true,
        'lead' => 'Service de catalogation spécialisée de monnaies, médailles et billets, avec enregistrement des éléments identificatifs et images haute définition.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi réalise la catalogation de monnaies, médailles et billets à Rome. Le service comprend l\'enregistrement complet des éléments identificatifs et la conservation des images haute résolution, pour vérifier dans le temps la correspondance entre les exemplaires et les catalogations délivrées.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarifs catalogation',
                'note' => 'Les honoraires comprennent les taxes et frais.',
                'rows' => [
                    ['label' => 'Consultation technique numismatique en justice', 'price' => 'Sur devis'],
                    ['label' => 'Catalogation spécialisée de monnaies romaines républicaines et impériales, tessères et médaillons', 'price' => '€ 18,50'],
                    ['label' => 'Catalogation de monnaies grecques, grecques impériales, byzantines et médiévales italiennes et européennes', 'price' => '€ 18,50'],
                    ['label' => 'Catalogation spécialisée de billets individuels et de collections entières', 'price' => '€ 18,50 l\'unité'],
                ],
            ],
        ],
    ],
];

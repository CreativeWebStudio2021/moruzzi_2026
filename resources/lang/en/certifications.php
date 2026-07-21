<?php

$certNote = 'It is possible to request, at a cost of € 8,00, certification comprising the label with QR code, the photographic certificate and online access for all coins, medals or banknotes purchased from Moruzzi Numismatica starting from 2009 that do not yet have this documentation.';

return [
    'common' => [
        'appointment_title' => 'Appointment recommended',
        'appointment_text' => 'Before visiting the shop, please contact us at +39 06 7151 0220 to schedule an appointment.',
        'pricing_note' => 'Fees include tax and charges.',
        'perizia_detail' => 'Includes application of seals on the envelope and descriptive label, photographic certification and QR code for digital consultation.',
    ],

    'online' => [
        'title' => 'Online certificate',
        'lead' => 'The Moruzzi Numismatica online certificate, linked to the QR code on the label, allows you to verify with one click the description, images and provenance of purchased coins.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Moruzzi Numismatica coins have an added value conferred by the set of elements contained in the coded label that accompanies them. This document serves to describe the specimen, attest its quality, guarantee its authenticity and lawful provenance.',
                    'The price indicated is the result of a correct assessment of the correspondence between the degree of rarity, the state of preservation and the other variables of the coin.',
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Verify with your smartphone',
                'paragraphs' => [
                    'To further protect our customers, we have included a QR code on the label and certificate. With a reader available free on all smartphones, or via the exclusive link on the paper certificate, you can consult online the full description, provenance references and photos of the obverse and reverse.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                   ['file' => 'certificato_qr01.jpg', 'alt' => 'QR code detail on the certificate', 'caption' => 'Immediate digital consultation'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'Moruzzi Numismatica is the first numismatic company in the world to guarantee its coins <strong>without having to seal them</strong> in rigid plastic (slab), as is done in the United States. Italian and European collectors can thus maintain direct contact with the coins in their collection.',
                    'The online certificate allows verification, also thanks to high-quality photos, of the origin and quality of coins from our firm: a step forward in transparency and security of purchases. The certification cannot be forged because it is guaranteed by a dedicated web page that cannot be modified.',
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Please note',
                'paragraphs' => [
                    'For your safety, to avoid fraud or scams, make sure that the link on the photographic certificate always begins with <strong>https://www.moruzzi.it/</strong>.',
                    'The paper certificate, issued and shipped also for online purchases, features the QR code for verification via smartphone or via the internet address indicated on the document.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-QR01.jpg', 'alt' => 'Legend of label elements with QR code'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'quality' => [
        'title' => 'Moruzzi quality certification',
        'lead' => 'Moruzzi quality certification clearly summarises state of preservation, rarity, metal and provenance, offering the collector an important added value.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Moruzzi Numismatica coins have added value also for the set of elements contained in the label that accompanies them. The label serves the dual function of describing the specimen and guaranteeing its originality; the price indicated is the result of a correct correspondence between state of preservation, degree of rarity and other variables.',
                    'Today the label also includes a <strong>QR code</strong>, without losing anything compared to the classic one: with a reader available in free apps for iPhone, iPad, iPod and Android smartphones, you can read the full descriptive certificate with provenance and photos of the obverse and reverse.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-cartellino.jpg', 'alt' => 'Moruzzi Numismatica label legend', 'caption' => 'The classic label, still valid'],
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-QR01_p23l4f70.jpg', 'alt' => 'Label with QR code', 'caption' => 'The new digital certification'],
                ],
            ],
            [
                'type' => 'features',
                'title' => 'What the label contains',
                'items' => [
                    ['title' => 'Full description', 'text' => 'Issuing authority, historical period, coin type, year and mint when known, legends or descriptions of obverse and reverse.'],
                    ['title' => 'Bibliography and rarity', 'text' => 'Up to three reference publications with identification numbers and, often, the degree of rarity indicated by the authors.'],
                    ['title' => 'Provenance and transparency', 'text' => 'Indication of pedigree when public (prestigious auctions, well-known collections) and alphanumeric code to always verify provenance.'],
                    ['title' => 'Metal, weight and price', 'text' => 'Metal, weight to the hundredth of a gram, rarity scale from 1 to 5 R and state of preservation clearly highlighted together with the price.'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Guarantee without expiry',
                'paragraphs' => [
                    'Pursuant to art. 64 of Legislative Decree 42/2004 (Cultural Heritage Code), the label is a guarantee of absolute authenticity and of everything indicated on it. The Moruzzi Numismatica Guarantee on the originality of sold coins <strong>never expires</strong> and also applies to correct cataloguing and accurate indication of the state of preservation.',
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'guarantee' => [
        'title' => 'Moruzzi Numismatica Guarantee',
        'lead' => 'The Moruzzi Numismatica Guarantee is indefinite: it protects authenticity, correct cataloguing and state of preservation of every sold specimen.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'The first sign of seriousness of our firm is the trust our customers have placed in us for over thirty years. Nevertheless, we offer a formal guarantee on the numismatic items we sell: the <strong>Moruzzi Numismatica Guarantee</strong>.',
                    'The law requires, as stated in art. 64 of Legislative Decree 42/2004, delivery to the buyer of a guarantee and provenance certificate. Moruzzi Numismatica goes further: it assures coins and collectible banknotes sold an unlimited guarantee in time both on authenticity and on all characteristics indicated on the label.',
                ],
            ],
            [
                'type' => 'images',
                'items' => [
                    ['file' => 'riempitivo_garanzia.jpg', 'alt' => 'Moruzzi Numismatica Guarantee', 'caption' => 'Indefinite guarantee'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'What the guarantee covers',
                'paragraphs' => [
                    'The guarantee on the originality of sold coins never expires and applies not only to the authenticity of the item, but also to correct cataloguing and especially to the accurate indication of the state of preservation.',
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'Anyone who sells works of art, antiques or items of historical or archaeological interest to the public must deliver to the buyer documentation attesting authenticity or at least probable attribution and provenance; otherwise, they must issue a declaration with all available information, preferably affixed to a photographic copy of the item.',
                ],
            ],
        ],
    ],

    'attestati' => [
        'title' => 'Guarantee and provenance certificates',
        'lead' => 'Guarantee and provenance certificates accompany ancient coins with complete documentation, images and references to inventory registers.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Ancient coins sold by Moruzzi Numismatica are accompanied by this important document. It is a certification that fully meets legal requirements and responds to the needs of the modern collector, who wishes to preserve together with the coins documentation that is as complete as possible.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'cetificati_mn1.jpg', 'alt' => 'Moruzzi guarantee and provenance certificate', 'caption' => 'Guarantee and provenance certificate'],
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'certificato_qr01_b4ubt21n.jpg', 'alt' => 'Certificate with QR code', 'caption' => 'Online verification via QR code'],
                ],
            ],
            [
                'type' => 'features',
                'title' => 'Certificate contents',
                'items' => [
                    ['title' => 'Description and bibliography', 'text' => 'Full description of the coin with bibliographic references and photos of the obverse and reverse.'],
                    ['title' => 'Unique code', 'text' => 'Identification code, rarity, weight and state of preservation for quick and transparent consultation.'],
                    ['title' => 'Lawful provenance', 'text' => 'Guarantee of originality and lawful provenance with register numbers where the specimen is recorded.'],
                    ['title' => 'Digital verification', 'text' => 'QR code to consult the certificate online from a smartphone or via dedicated web code.'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'standard' => [
        'title' => 'Quality standard',
        'lead' => 'Every Moruzzi Numismatica offering meets high standards of preservation, aesthetics and technique, illustrated also through dedicated bar charts for the various parameters.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Our coins, medals and banknotes are selected according to high standards of preservation, aesthetics and technique. Some of the most interesting offerings are accompanied on the e-commerce pages by bar charts, in addition to the description that accompanies all our offerings.',
                ],
            ],
            [
                'type' => 'images',
                'items' => [
                    ['file' => 'augusto_denario01.jpg', 'alt' => 'Denarius of Augustus', 'caption' => 'Example of a coin of high quality'],
                    ['file' => '141943a.jpg', 'alt' => 'Ancient coin preservation detail'],
                ],
            ],
            [
                'type' => 'meters',
                'title' => 'The six evaluation parameters',
                'items' => [
                    ['label' => 'Preservation', 'value' => '82%', 'hint' => 'European scale / Sheldon', 'text' => 'From D (fair) to FDC (fleur de coin), also expressed in seventieths for American and Asian collectors.'],
                    ['label' => 'Rarity', 'value' => '68%', 'hint' => 'From C to RRRRRR', 'text' => 'Percentage from low values for common coins up to 100% for unique or nearly unique specimens.'],
                    ['label' => 'Metal and patina', 'value' => '74%', 'hint' => 'Alloy quality', 'text' => 'Assessment of minting damage, wear over time and improper cleaning; quality patina is an added value.'],
                    ['label' => 'Style', 'value' => '88%', 'hint' => 'Artistic fineness', 'text' => 'The style of the dies can be more important than preservation in the most artistic numismatic productions.'],
                    ['label' => 'Strike', 'value' => '76%', 'hint' => 'Production quality', 'text' => 'Examination of fractures, die shifts and quality of the strike that highlights the reliefs.'],
                    ['label' => 'Provenance', 'value' => '62%', 'hint' => 'Pedigree', 'text' => 'Auctions, shops and prestigious collections increase the percentage compared to provenances traced only recently.'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'Items that do not meet these characteristics of quality are offered at particularly advantageous conditions. Every coin offered by Moruzzi Numismatica has absolutely lawful provenance recorded in the registers of the competent authorities.',
                ],
            ],
        ],
    ],

    'upgrade' => [
        'title' => 'Quality upgrade',
        'lead' => 'The quality upgrade service allows replacement of already purchased specimens with others of higher grade, paying only the price difference.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Every collector, at the beginning of their collection, often settles for specimens that are not particularly expensive or well preserved. Over time taste refines and the first coins purchased may no longer satisfy. For this reason the Moruzzi Numismatica upgrade promotion exists.',
                    'Not everyone can afford top quality right away: to "fill a gap" in the collection one may settle for a less attractive specimen, with the possibility of replacing it later with one of higher grade.',
                ],
            ],
            [
                'type' => 'upgrade_flow',
                'steps' => [
                    ['file' => 'promozionea.jpg', 'alt' => 'Lower quality specimen', 'caption' => 'Specimen already in collection'],
                    ['file' => 'promozione.jpg', 'alt' => 'Higher quality specimen', 'caption' => 'Upgrade available in shop'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'How it works',
                'paragraphs' => [
                    'Those who have made at least <strong>three purchases in the last two years</strong> are granted the possibility of replacing coins purchased from Moruzzi Numismatica with better specimens, paying only the price difference; the returned specimen is valued at the price paid.',
                    'Example: to upgrade a 1927 10 lire in BB purchased at € 30,00 with a SPL at € 100,00, you only pay € 70,00. The promotion applies to coins (ancient, modern and contemporary) and banknotes, only if replacement specimens are available and returned coins have the Moruzzi label.',
                ],
            ],
        ],
    ],

    'estimates_coins' => [
        'title' => 'Coin estimates and appraisals',
        'appointment' => true,
        'lead' => 'Umberto Moruzzi offers estimates and appraisals of ancient and modern coins, with complete registration of data and high-resolution images.',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => [
                    'file' => 'stime-e-perizie-di-monete.jpg',
                    'alt' => 'Moruzzi Numismatica coin estimates and appraisals',
                ],
                'paragraphs' => [
                    'For estimates and appraisals of ancient, modern coins and medals you can contact our Rome office, numismatic scholar <strong>Umberto Moruzzi</strong>, expert of the Chamber of Commerce and the Court of Rome.',
                    'Appraisal services always include complete registration of identifying elements of examined specimens and preservation of high-resolution images, so as to verify over time correspondence with certifications and cataloguing issued.',
                    'With the same care, estimates of individual specimens and entire coin collections are carried out.',
                ],
            ],
            [
                'type' => 'links',
                'title' => 'Related services',
                'items' => [
                    ['route' => 'certifications.expertise_coins', 'label' => 'Coin appraisals'],
                    ['route' => 'certifications.estimates_banknotes', 'label' => 'Banknote estimates and appraisals'],
                    ['route' => 'certifications.cataloguing', 'label' => 'Cataloguing'],
                    ['route' => 'certifications.valuation', 'label' => 'Coin and banknote valuation'],
                ],
            ],
        ],
    ],

    'estimates_banknotes' => [
        'title' => 'Banknote estimates and appraisals',
        'appointment' => true,
        'lead' => 'Estimate and appraisal service for Italian and world banknotes, with attention to correct cataloguing and preservation of reference images.',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => [
                    'file' => 'stime-e-perizie-di-banconote.jpg',
                    'alt' => 'Banknote estimates and appraisals',
                ],
                'paragraphs' => [
                    'For banknote appraisals you can contact our Rome office: <strong>Umberto Moruzzi</strong>, expert of the Chamber of Commerce and the Court of Rome, prepares banknote certifications and cataloguing.',
                    'Every service includes complete registration of identifying elements and preservation of high-resolution images, to verify over time correspondence between specimen and issued documentation.',
                    'Estimates of individual specimens and entire banknote collections are also carried out.',
                ],
            ],
            [
                'type' => 'links',
                'title' => 'Related services',
                'items' => [
                    ['route' => 'certifications.expertise_banknotes', 'label' => 'Banknote appraisals'],
                    ['route' => 'certifications.cataloguing', 'label' => 'Cataloguing'],
                    ['route' => 'certifications.valuation', 'label' => 'Coin and banknote valuation'],
                ],
            ],
        ],
    ],

    'expertise_coins' => [
        'title' => 'Coin appraisals',
        'appointment' => true,
        'lead' => 'Appraisals of ancient, modern coins and medals, with application of seals and photographic certificate with QR code for digital consultation.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi, expert of the Chamber of Commerce and the Court of Rome, carries out appraisals of ancient, modern coins and medals in Rome. All services include complete registration of identifying elements and preservation of high-resolution images.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Ancient coin appraisal fees',
                'note' => 'Fees include tax and charges. Includes application of seals on the envelope and descriptive label, photographic certification and QR code for digital consultation.',
                'rows' => [
                    ['label' => 'Ancient coins valued below € 300', 'price' => '€ 30,00'],
                    ['label' => 'Ancient coins valued between € 301 and € 1.000', 'price' => '€ 40,00'],
                    ['label' => 'Ancient coins valued between € 1.001 and € 5.000', 'price' => '€ 70,00'],
                    ['label' => 'Ancient coins valued between € 5.001 and € 10.000', 'price' => '€ 150,00'],
                    ['label' => 'Ancient coins valued between € 10.001 and € 20.000', 'price' => '€ 300,00'],
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Modern coin appraisal fees',
                'rows' => [
                    ['label' => 'Modern coins valued below € 300', 'price' => '€ 20,00'],
                    ['label' => 'Modern coins valued between € 301 and € 1.000', 'price' => '€ 25,00'],
                    ['label' => 'Modern coins valued between € 1.001 and € 5.000', 'price' => '€ 50,00'],
                    ['label' => 'Modern coins valued between € 5.001 and € 10.000', 'price' => '€ 100,00'],
                    ['label' => 'Modern coins valued between € 10.001 and € 20.000', 'price' => '€ 200,00'],
                    ['label' => 'Medal appraisal with photographic certificate and indication of any contemporary production', 'price' => '€ 60,00'],
                    ['label' => 'Numismatic technical consultancy in judicial proceedings', 'price' => 'Upon estimate'],
                ],
            ],
        ],
    ],

    'valuation' => [
        'title' => 'Coin and banknote valuation',
        'appointment' => true,
        'lead' => 'Valuations of individual specimens and collections of coins and banknotes, with indication of purchase and sale value.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi, expert of the Chamber of Commerce and the Court of Rome, carries out valuations of ancient and modern coins, medals and banknotes in Rome, with indication of purchase and sale value when requested.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Valuation fees',
                'note' => 'Fees include tax and charges.',
                'rows' => [
                    ['label' => 'Numismatic technical consultancy of varying complexity for coins, medals and paper money, also in judicial proceedings', 'price' => 'Upon estimate'],
                    ['label' => 'Estimate of collections or individual coins up to € 6.000, with purchase and sale value', 'price' => '€ 378,00'],
                    ['label' => 'Estimate of collections or individual coins over € 6.000, with purchase and sale value', 'price' => '6,3% of estimated value'],
                    ['label' => 'On-site estimates (in addition to percentage, travel to be agreed)', 'price' => 'from € 180,00'],
                ],
            ],
        ],
    ],

    'expertise_banknotes' => [
        'title' => 'Banknote appraisals',
        'appointment' => true,
        'lead' => 'Specialist appraisals of Italian and foreign paper money, with preservation of images and identifying data for future verification.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi carries out appraisals of Italian and foreign banknotes in Rome, as well as cataloguing. Every service includes complete registration of identifying elements and preservation of high-resolution images.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Banknote appraisal fees',
                'note' => 'Fees include tax and charges.',
                'rows' => [
                    ['label' => 'Italian paper money (State Notes, Treasury Bonds, Bank of Italy banknotes) up to € 300', 'price' => '€ 20,00'],
                    ['label' => 'Value between € 301 and € 1.000', 'price' => '€ 25,00'],
                    ['label' => 'Value between € 1.001 and € 5.000', 'price' => '€ 50,00'],
                    ['label' => 'Value between € 5.001 and € 10.000', 'price' => '€ 100,00'],
                    ['label' => 'Value between € 10.001 and € 20.000', 'price' => '€ 200,00'],
                    ['label' => 'Numismatic technical consultancy in judicial proceedings', 'price' => 'Upon estimate'],
                ],
            ],
        ],
    ],

    'cataloguing' => [
        'title' => 'Coin and banknote cataloguing',
        'appointment' => true,
        'lead' => 'Specialist cataloguing service for coins, medals and banknotes, with registration of identifying elements and high-definition images.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi carries out cataloguing of coins, medals and banknotes in Rome. The service includes complete registration of identifying elements and preservation of high-resolution images, to verify over time correspondence between specimens and issued cataloguing.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Cataloguing fees',
                'note' => 'Fees include tax and charges.',
                'rows' => [
                    ['label' => 'Numismatic technical consultancy in judicial proceedings', 'price' => 'Upon estimate'],
                    ['label' => 'Specialist cataloguing of Republican and Imperial Roman coins, tesserae and medallions', 'price' => '€ 18,50'],
                    ['label' => 'Cataloguing of Greek, Imperial Greek, Byzantine and Italian and European medieval coins', 'price' => '€ 18,50'],
                    ['label' => 'Specialist cataloguing of individual banknotes and entire collections', 'price' => '€ 18,50 each'],
                ],
            ],
        ],
    ],
];

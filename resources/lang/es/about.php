<?php

return [
    'presentation' => [
        'title' => 'Nos presentamos',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => ['file' => 'moruzzi_nello_new.jpg', 'alt' => 'Nello Moruzzi'],
                'paragraphs' => [
                    'Moruzzi Numismatica nació de la pasión y de la experiencia profesional de mi padre Nello Moruzzi, numismático italiano conocido y estimado desde la década de 1960.',
                    'Durante muchos años colaboró con su colega Federico Bartoli, contribuyendo al éxito de su empresa, A & B Numismatica. Además de sus valores como hombre generoso y honesto, nos transmitió la pasión por la numismática, así como su gran bagaje cultural y profesional. En mayo de 1980 nos confió la empresa, pero siguió aconsejándonos y animándonos para que esta magnífica actividad se volviera cada vez más profesional e importante. Una continuidad de más de cincuenta años convirtió nuestra tienda en una realidad histórica, que con el tiempo se convirtió en un punto de referencia del coleccionismo numismático italiano.',
                ],
            ],
            [
                'type' => 'split_panel',
                'paragraphs' => [
                    'Nos dejó en 1996, pero su recuerdo y sus consejos siguen vivos en nosotros y aún animan nuestro trabajo.',
                    'Hoy nuestra actividad se orienta principalmente a la numismática antigua y moderna: buscamos las mejores monedas no solo en el mercado nacional, sino también —y sobre todo— en Europa y en el mundo, y en las subastas más importantes del sector. Nuestras propuestas se examinan con atención para garantizar la autenticidad, determinar el exacto estado de conservación y realizar una valoración correcta. Históricamente, Moruzzi Numismatica dedica gran atención al coleccionismo de billetes, a pesar de cierto esnobismo de los profesionales numismáticos que, sobre todo en el pasado, trataron este sector con cierta suficiencia.',
                ],
                'carousel' => [
                    'prev_label' => 'Imagen anterior',
                    'next_label' => 'Imagen siguiente',
                    'items' => [
                        ['file' => 'moruzzi_oldshop2.jpg', 'alt' => 'Antigua tienda Moruzzi Numismatica en Roma', 'caption' => 'Antigua tienda de Moruzzi Numismatica en Roma'],
                        ['file' => 'moruzzi_newshop.png', 'alt' => 'Tienda actual Moruzzi Numismatica en Roma', 'caption' => 'Tienda de Moruzzi Numismatica en Roma'],
                    ],
                ],
            ],
            [
                'type' => 'split_item',
                'anchor' => 'dove-siamo',
                'image' => ['file' => 'moruzzi_newshop.png', 'alt' => 'Tienda Moruzzi Numismatica en Roma, barrio Cinecittà'],
                'title' => 'Dónde estamos',
                'paragraphs' => [
                    '¿Quieres empezar a coleccionar? ¿Tienes monedas que vender? ¡Has llegado al lugar adecuado! <strong>Moruzzi Numismatica</strong>, histórica tienda numismática de Roma fácilmente accesible, te ofrece la máxima transparencia y la gran profesionalidad de su <a href="/es/quienes-somos/nuestro-equipo">equipo</a>.',
                    '<strong>Moruzzi Numismatica</strong><br>Viale dei Salesiani, 12a<br>00175 Roma, Italia',
                    'La tienda y las oficinas están en el barrio Cinecittà, bien comunicado con todos los medios de transporte. Hay aparcamientos públicos y un garaje cercano. La estación de metro <strong>Giulio Agricola</strong> (línea A) está a unos 250 metros.',
                ],
            ],
            [
                'type' => 'cta',
                'url' => '/es/contacto',
                'label' => 'Indicaciones y contacto',
                'title' => 'Cómo llegar y contactarnos',
                'text' => 'Para indicaciones detalladas (coche, tren, aeropuertos) y para escribirnos, visita la página de contacto.',
            ],
        ],
    ],

    'staff' => [
        'title' => 'El equipo',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Un equipo de profesionales cualificados en el sector de la numismática está a su servicio para conducirle, a través de las monedas, por los senderos de la historia.',
                    'La <strong>Calidad Moruzzi</strong>, fruto de nuestros recursos profesionales con una dilatada experiencia internacional, nos permite garantizarle la absoluta autenticidad y calidad de los ejemplares propuestos, acompañados de una certificación completa. También todos los demás servicios se ofrecen cuidando cada mínimo detalle.',
                    'La fortaleza de nuestro cualificado equipo reside en compartir la común pasión por la numismática, que nos hace trabajar como un equipo con mutuo respeto y confianza. Prueba de ello es la actividad de casi cuarenta años, que nos ha permitido ampliar nuestros servicios y conquistar nuevas cuotas de mercado.',
                ],
            ],
            [
                'type' => 'staff_grid',
                'items' => [
                    ['route' => 'about.loredana', 'file' => 'Loredana-Moruzzi02_9a6e3sk4.jpg', 'alt' => 'Loredana Moruzzi', 'name' => 'Loredana Moruzzi', 'role' => '<em>Administradora / Responsable de ventas</em><br>CEO / Showroom Manager'],
                    ['route' => 'about.umberto', 'file' => 'Umberto-Moruzzi02.jpg', 'alt' => 'Umberto Moruzzi', 'name' => 'Umberto Moruzzi', 'role' => '<em>Director del Departamento Numismático</em><br>Senior Numismatist'],
                    ['route' => 'about.francesca', 'file' => 'Barenghi_Francesca2_8ltw71wn.jpg', 'alt' => 'Francesca Barenghi', 'name' => 'Francesca Barenghi', 'role' => '<em>Departamento de monedas griegas y romanas</em><br>Numismatist (Greek and Roman Coins Department)'],
                    ['route' => 'about.nicola', 'file' => 'Nicola-Mecci02.jpg', 'alt' => 'Nicola Mecci', 'name' => 'Nicola Mecci', 'role' => '<em>Ventas online y marketing</em><br>Web Sales and Marketing'],
                    ['file' => 'EmanuelaPittola02.jpg', 'alt' => 'Emanuela Pittola', 'name' => 'Emanuela Pittola', 'role' => '<em>Administración</em><br>Administration'],
                    ['file' => 'Daniela-franchi02.jpg', 'alt' => 'Daniela Franchi', 'name' => 'Daniela Franchi', 'role' => '<em>Administración</em><br>Administration'],
                    ['route' => 'about.hiroko', 'file' => 'hiroko02.jpg', 'alt' => 'Hiroko Blue Lynx', 'name' => 'Hiroko Blue Lynx', 'role' => 'Asistente de ventas<br>Sales assistant'],
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
                    'Su profundo conocimiento del sector se ha formado gracias a casi cuarenta años de experiencia dentro de la empresa familiar. Además de ocuparse de la administración, es responsable de las ventas. Clientes de todo el mundo la encuentran como referente dispuesta a satisfacer sus necesidades.',
                    'Lo testimonian numerosos clientes con los que mantiene desde hace años relaciones amistosas, basadas en el mutuo respeto. Cuida con mucha atención la fase postventa, siguiendo la facturación y el proceso de envío hasta destino.',
                    'Se encarga de contactar a los clientes que le confían sus listas de búsqueda. Con amabilidad y profesionalidad responde a la mayoría de las consultas de los visitantes de este sitio.',
                ],
            ],
        ],
    ],

    'umberto' => [
        'title' => 'Umberto Moruzzi',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => ['file' => 'Umberto-Moruzzi01_08hsgn2j.jpg', 'alt' => 'Umberto Moruzzi - Perito numismático en Roma'],
                'paragraphs' => [
                    'Umberto Moruzzi, estudioso numismático, retomó la tradición paterna especializándose en particular en la acuñación romana e italiana. Se ocupó de Moruzzi Numismatica ya desde 1980, llevándola a la notoriedad actual como una de las casas numismáticas más renombradas de Italia.',
                    'Actualmente se dedica principalmente a su actividad profesional como consultor numismático, aunque sigue la empresa familiar, aún hoy propiedad de la familia Moruzzi, donde verifica las monedas adquiridas y valora los objetos más particulares. Inscrito en la Cámara de Comercio como perito numismático, es también miembro examinador de Numismática y Sfragística en la comisión examinadora de la misma Cámara de Comercio de Roma desde 1993.',
                    'Inscrito en el colegio de periodistas del Lacio, escribe sobre numismática en los periódicos del sector y en diarios nacionales. Es socio fundador de la NIP, Asociación de Numismáticos Italianos Profesionales, de la que fue secretario de 1999 a 2001. También se ocupó de la FENAP, Federación Europea de Sociedades y Asociaciones de Numismáticos Profesionales, de la que fue secretario de 2000 a 2001. Es además miembro de la Royal Numismatic Society, de la Società Numismatica Italiana, de la NIA y de la asociación numismática alemana Berufsverband des Deutschen Münzenfachhandels e.V.',
                    'Es perito del Tribunal de Roma y ha desempeñado diversos encargos como consultor técnico para varias fiscalías italianas, entre ellas Roma y Milán, realizando algunas de las pericias numismáticas más importantes de la posguerra en Italia.',
                    'Ha organizado varias exposiciones, entre las cuales tuvo notable éxito la muestra itinerante «Il Vero e il Falso» de la Guardia di Finanza.',
                    'Fue curador histórico-científico para la acuñación oficial de Expo Milano 2015.',
                    'Es actualmente curador numismático en el Museo Histórico de la Guardia di Finanza.',
                    'Es actualmente vicepresidente de la asociación profesional N.I.P. (Numismatici Italiani Professionisti).',
                ],
            ],
            [
                'type' => 'cta',
                'url' => 'https://www.umbertomoruzzi.it/',
                'label' => 'Sitio oficial',
                'title' => 'Visite el sitio oficial del perito numismático Umberto Moruzzi',
                'text' => 'Para profundizar, consultar artículos y conocer la actividad profesional de Umberto Moruzzi, está disponible el sitio dedicado.',
            ],
        ],
    ],

    'nicola' => [
        'title' => 'Nicola Mecci',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => ['file' => 'Nicola-Mecci01_bu8l0fda.jpg', 'alt' => 'Nicola Mecci - Ventas online'],
                'paragraphs' => [
                    'Siempre apasionado de la numismática antigua y moderna, se acercó a este mundo gracias a las enseñanzas de un anciano coleccionista siciliano.',
                    'Responsable de la venta online en las distintas plataformas informáticas (sitio e-commerce, tiendas en eBay, VCoins y Ma-Shops) y de las relaciones con la clientela italiana e internacional.',
                    'Desempeña el cargo de responsable SEO y social media manager para Moruzzi Numismatica.',
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
                    'Apasionada desde niña por las antigüedades clásicas, emprendió en la universidad la formación académica de arqueóloga clásica. Estudió numismática en la Universidad de Roma « La Sapienza », frecuentando los cursos de la profesora Breglia y de los profesores Panvini Rosati y Parise. Se graduó en literatura clásica con honores cum laude con una tesis sobre numismática celto-padana.',
                    'Obtuvo un diploma de posgrado en arqueología con las máximas calificaciones, discutiendo una tesis sobre el análisis cuantitativo del desgaste de monedas y medallones imperiales. Ha participado como ponente en muchos congresos internacionales de numismática y ha publicado numerosos artículos científicos.',
                    'Recibió una beca del gobierno francés participando en el proyecto dirigido por el prof. J. P. Callu de la Ecole des Hautes Etudes y frecuentó cursos de numismática en la Ecole Normale Supérieure impartidos por el prof. J. B. Giard. Obtuvo un doctorado de investigación en arqueología trabajando sobre medallones romanos imperiales en los más prestigiosos gabinetes europeos.',
                    'Habla con fluidez italiano y francés, tiene buena familiaridad con el alemán y conocimientos de inglés. Se ocupa de la clasificación de monedas antiguas y modernas y de la parte cultural del sitio web. Para Moruzzi Numismatica es la experta en acuñación romana.',
                ],
            ],
        ],
    ],

    'publications' => [
        'title' => 'Nuestras publicaciones',
        'lead' => 'Moruzzi Numismatica ha publicado o ha aportado una importante colaboración a la publicación de los siguientes trabajos:',
        'blocks' => [
            ['type' => 'split_item', 'image' => ['file' => '1988.jpg', 'alt' => 'Portada del catálogo Monete e medaglie, Roma 1988'], 'title' => 'Monete e medaglie, Roma 1988', 'paragraphs' => ['Era el primer catálogo presentado por Moruzzi Numismatica, que ya se distinguía por el cuidado con que estaba realizado y por la selección de las monedas propuestas. El catálogo ofrecía a la venta monedas griegas, romanas, italianas (tanto medievales como modernas), pontificias y otras.']],
            ['type' => 'split_item', 'image' => ['file' => '1992.jpg', 'alt' => 'Portada del catálogo de subasta pública, Roma 28 febbraio 1992'], 'title' => 'Monete, medaglie e banconote. Asta pubblica, Roma 28 febbraio 1992', 'paragraphs' => ['El catálogo de subasta de Moruzzi Arte Roma con monedas antiguas y modernas tuvo un notable éxito de ventas y de público.']],
            ['type' => 'split_item', 'image' => ['file' => '1994.jpg', 'alt' => 'Portada Le banconote del mondo, Roma 1994'], 'title' => 'Le banconote del mondo, Roma 1994', 'paragraphs' => ['Listado de venta de billetes mundiales. En los años noventa, los billetes fueron «descubiertos» por un gran número de coleccionistas italianos.']],
            ['type' => 'split_item', 'image' => ['file' => '1995a.jpg', 'alt' => 'Portada Argent, Le banconote d\'Italia, Roma 1995'], 'title' => 'Argent, Le banconote d\'Italia, Roma 1995', 'paragraphs' => ['La demanda de billetes italianos era particularmente elevada y Moruzzi Numismatica, atenta a la demanda de los coleccionistas, proponía una colección de billetes de notable nivel, por calidad y rareza.']],
            ['type' => 'split_item', 'image' => ['file' => '1995.jpg', 'alt' => 'Portada Excellence, Roma 1995'], 'title' => 'Excellence, Roma 1995', 'paragraphs' => ['Un catálogo con monedas griegas, romanas, bizantinas, italianas y extranjeras particularmente seleccionadas. En el centro del catálogo se imprimía una doble página con las imágenes en color de los mejores ejemplares presentados.']],
            ['type' => 'split_item', 'image' => ['file' => '1997.jpg', 'alt' => 'Portada Jvlia, Roma 1997'], 'title' => 'Jvlia, Roma 1997', 'paragraphs' => ['El catálogo inauguraba una serie de publicaciones que llevan los nombres de las gentes romanas más antiguas. En primer lugar se eligió la gens Julia. El catálogo, de estándar internacional, proponía monedas antiguas, modernas italianas y extranjeras de excelente calidad.']],
            ['type' => 'split_item', 'image' => ['file' => '1998.jpg', 'alt' => 'Portada Claudia, Roma 1998'], 'title' => 'Claudia, Roma 1998', 'paragraphs' => ['El catálogo de venta a precios netos continuaba la serie de publicaciones inaugurada con Jvlia, ofreciendo monedas antiguas de rara belleza y conservación, pero también colecciones de monedas de las cecas italianas, papales y del Reino de Italia.']],
            ['type' => 'split_item', 'image' => ['file' => '1990.jpg', 'alt' => 'Portada Una collezione di antoniniani, Roma 1990'], 'title' => 'Una collezione di antoniniani. Vendita generale di monete e medaglie, Roma 1990', 'paragraphs' => ['El catálogo proponía una riquísima colección de 1.000 antoninianos diferentes, precedida por una interesante introducción histórica. Aún hoy es una publicación buscada por los estudiosos.']],
            ['type' => 'split_item', 'image' => ['file' => '1992cassettas.jpg', 'alt' => 'Videocatálogo de la subasta pública del 28 de febrero de 1992'], 'title' => 'Videocatalogo dell\'asta pubblica del 28 febbraio 1992', 'paragraphs' => ['El videocatálogo de la subasta de Moruzzi Arte Roma con monedas antiguas y modernas. La cinta con música clásica de fondo era en su época única en su género y permitía ver en vídeo las imágenes ampliadas de las monedas puestas a la venta.']],
            ['type' => 'split_item', 'image' => ['file' => '2002.jpg', 'alt' => 'Portada Addio alla Lira, Roma 2002'], 'title' => 'Addio alla Lira. Tre secoli di storia italiana attraverso le banconote, Roma 2002', 'paragraphs' => ['Con este catálogo dimos una despedida nostálgica a la antigua lira: una despedida solo formal a su circulación como moneda, puesto que permanece en la historia de todos los italianos, en la memoria colectiva y en la de cada individuo.']],
            ['type' => 'split_item', 'image' => ['file' => '2006es.jpg', 'alt' => 'Portada Una collezione di Medaglie - Estate 2006'], 'title' => 'Una collezione di Medaglie - Estate 2006, Roma', 'paragraphs' => ['Catálogo en colaboración con la casa numismática A&B. Una bella selección de medallas, casi en su totalidad pontificias, con ejemplares raros y algunas notas interesantes.']],
            ['type' => 'split_item', 'image' => ['file' => '2007s.jpg', 'alt' => 'Portada FLAVIA 2007'], 'title' => 'FLAVIA 2007, Roma 2007', 'paragraphs' => ['Un espléndido pequeño catálogo que tuvo gran éxito con monedas muy seleccionadas, divididas por temas: retratos de las augustas, bronces medios imperiales, imperio galo, denarios imperiales, plata de la Roma republicana y monedas del imperio y de las provincias romanas.']],
            ['type' => 'split_item', 'image' => ['file' => 'il-vero-e-il-falso_1.jpg', 'alt' => 'Portada IL VERO e IL FALSO, Roma 2008'], 'title' => 'IL VERO e IL FALSO, Roma 2008', 'paragraphs' => ['Catálogo de la exposición itinerante homónima ya celebrada en Roma, Florencia, Vicenza y Perugia. Recorre la evolución del fenómeno de la falsificación a través de monedas antiguas, medievales y modernas, además de billetes del Banco de Italia.']],
            ['type' => 'split_item', 'image' => ['file' => '2006as.jpg', 'alt' => 'Portada Una collezione di Medaglie - Autunno 2006'], 'title' => 'Una collezione di Medaglie - Autunno 2006, Roma', 'paragraphs' => ['Catálogo en colaboración con A&B. Entre las medallas destacaba una importante colección de la Sede Vacante y la medalla italiana en oro conmemorativa del bimilenario de la muerte de Virgilio, único ejemplar conocido.']],
            ['type' => 'split_item', 'image' => ['file' => '2008s.jpg', 'alt' => 'Portada CLAVDIA 2008'], 'title' => 'CLAVDIA 2008, Roma 2008', 'paragraphs' => ['Un catálogo en la tradición Moruzzi, muy solicitado en todo el mundo incluso solo por el placer de leerlo. Se presentaron dos importantes colecciones: acuñaciones de Nerón y monedas de bronce del Mundo Griego.']],
            ['type' => 'split_item', 'image' => ['file' => 'il-vero-e-il-falso_2.jpg', 'alt' => 'Portada IL VERO e IL FALSO, Milano 2013'], 'title' => 'IL VERO e IL FALSO, La Guardia di Finanza in Lombardia, Milano 2013', 'paragraphs' => ['Catálogo de la exposición itinerante organizada por Umberto Moruzzi en colaboración con la GDF. «Los hombres a menudo producen dinero falso, pero mucho más a menudo el dinero produce hombres falsos» (J. Harris). Monedas auténticas expuestas junto a sus falsificaciones, casi perfectas.']],
        ],
    ],

    'press' => [
        'title' => 'Hablan de nosotros',
        'blocks' => [
            [
                'type' => 'split_item',
                'image' => ['file' => 'lire500000.jpg', 'alt' => 'Billete de 500.000 liras tipo Raffaello'],
                'title' => 'In giro ancora 2550 miliardi di lire',
                'meta' => 'Il Messaggero — 14 de julio de 2010, Roma',
                'paragraphs' => [
                    '... <strong>Umberto Moruzzi</strong>, estudioso del papel moneda y titular de una de las tiendas numismáticas más consolidadas de Italia, en Roma, en la zona de Cinecittà, habla de un «difuso y creciente interés, a menudo amateur, en la colección de viejas liras, sobre todo de época republicana». Una auténtica «lira-manía», donde la nostalgia por una moneda que no volverá jamás se une a la capacidad de billetes y monedas de evocar momentos grandes y pequeños de la biografía de cada uno. — ROBERTO FABEN',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'lire-500-medusas.jpg', 'alt' => 'Billete de 500 liras del Banco de Italia'],
                'title' => 'Rarità e biglietti integri meritano una perizia',
                'meta' => 'Il Sole 24 Ore — 21 de septiembre de 2009',
                'paragraphs' => [
                    '«Con la retirada de la antigua lira, nació un ejército de nuevos coleccionistas...» Así explica el «hilo lira» Umberto Moruzzi, perito numismático y titular, junto con su hermana Loredana, de la tienda Moruzzi Numismatica en Cinecittà. «Los billetes y monedas en liras pueden ser una inversión...» Quien tenga en casa algún billete antiguo puede hacerlo valorar en una tienda numismática: en Italia hay unas 350, pero los adherentes a la asociación NIP ofrecen mayores garantías. Entre los billetes más recientes destaca el billete de 500 liras «Barbetti» con el contraseña «Medusa» del 14 de noviembre de 1950: en buenas condiciones vale unos 20.000 euros. — ROBERTO FABEN',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'lamoneta_1.jpg', 'alt' => 'Foro numismático Lamoneta'],
                'title' => 'Le porte del tempio di Giano — Significato sulle monete',
                'meta' => 'Lamoneta.it — 26 de noviembre de 2008',
                'paragraphs' => [
                    'Buscando textos sobre el origen del significado de la leyenda <em>CLAVSO IANI TEMPLO GAVDIVM SECVLI</em>, me topé con un buen trabajo de Francesca Barenghi, colaboradora de Moruzzi. Lo reproduzco íntegramente aquí, pues lo considero muy útil para este propósito.',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'premio_moruzzi_numismatica.jpg', 'alt' => 'Premio Ben Hur - Cinecittà 2006'],
                'title' => 'Premio Ben Hur — Cinecittà 2006',
                'meta' => 'Comune di Roma X Municipio — 21 de julio de 2006',
                'paragraphs' => [
                    'En una fiesta se entregaron premios a los comerciantes romanos del pequeño comercio que se distinguieron por su longevidad en el municipio. El premio Ben Hur también fue concedido a Moruzzi Numismatica, empresa con 26 años de actividad, una de las más antiguas de Roma en el sector. Moruzzi Numismatica debe su reconocimiento a una indiscutible profesionalidad que le ha permitido seguir en el mercado y haber traído a Roma, a lo largo de los años, una multitud de coleccionistas-turistas.',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'vetrina.jpg', 'alt' => 'Escaparate de Moruzzi Numismatica en Roma'],
                'title' => 'Il cielo più grande del mondo sopra i palazzoni di Cinecittà',
                'meta' => 'La Repubblica — 27 de febrero de 2002, Roma',
                'paragraphs' => [
                    '... Bajo los pórticos de la plaza, frente a los escaparates de una tienda numismática, me detengo a leer los nombres de las monedas expuestas... Si existe una tienda así, podemos imaginar a un coleccionista feliz... podemos afirmar que hay vida en Cinecittà, e incluso que hay vida en la Tierra. — FULVIO ABBATE',
                ],
            ],
        ],
    ],

    'memberships' => [
        'title' => 'Memberships',
        'lead' => 'Moruzzi Numismatica, sus socios y colaboradores están inscritos en diversas asociaciones de notable relevancia.',
        'blocks' => [
            ['type' => 'split_item', 'title' => 'IAPN-AINP', 'image' => ['file' => 'IAPN01.jpg', 'alt' => 'IAPN AINP'], 'paragraphs' => ['La <strong>Asociación Internacional de Numismáticos Profesionales</strong> es una de las organizaciones sin ánimo de lucro más importantes del mundo, especialmente por su papel en la garantía y la coordinación en defensa del mercado y del coleccionismo ético. Fundada en 1951 en Ginebra, hoy cuenta con más de 114 empresas numismáticas en veintitrés países.']],
            ['type' => 'split_item', 'title' => 'NIP — Numismatici Italiani Professionisti', 'image' => ['file' => 'nip.png', 'alt' => 'NIP'], 'paragraphs' => ['Los NIP se proponen promover un mercado numismático animado por los mejores principios de ética profesional y comercial; fomentan el estudio científico y la difusión de la numismática y combaten las falsificaciones.']],
            ['type' => 'split_item', 'title' => 'Berufsverband des Deutschen Münzenfachhandels e.V.', 'image' => ['file' => 'Berufsverband-des-Deutschen-Muenzenfachhandels-e.V.png', 'alt' => 'Berufsverband'], 'paragraphs' => ['Importante asociación profesional alemana de numismáticos de la que Moruzzi Numismatica forma parte desde 2012. Los inscritos garantizan la autenticidad de monedas, medallas y billetes en venta.']],
            ['type' => 'split_item', 'title' => 'FENAP', 'image' => ['file' => 'fenap.png', 'alt' => 'FENAP'], 'paragraphs' => ['La <strong>Federación Europea de Asociaciones Numismáticas Profesionales</strong> coordina las asociaciones nacionales europeas de numismáticos profesionales y es referente ante las instituciones comunitarias.']],
            ['type' => 'split_item', 'title' => 'Società Numismatica Italiana', 'image' => ['file' => 'societa_numismatica_1.png', 'alt' => 'Società Numismatica Italiana'], 'paragraphs' => ['Asociación cultural fundada en 1892 que acogió entre sus socios a los mayores estudiosos y coleccionistas italianos de la época.']],
            ['type' => 'split_item', 'title' => 'N.I.A.', 'image' => ['file' => 'nia.png', 'alt' => 'NIA'], 'paragraphs' => ['Los <strong>Numismatici Italiani Associati</strong> reúnen a numismáticos profesionales, coleccionistas, estudiosos y peritos con el interés común de promover la numismática en todos sus aspectos.']],
            ['type' => 'split_item', 'title' => 'CINOA', 'image' => ['file' => 'cinoa.png', 'alt' => 'CINOA'], 'paragraphs' => ['Federación internacional de asociaciones sin ánimo de lucro que representa a más de 5.000 comerciantes de antigüedades y arte en 22 países. La adhesión compromete a los miembros a respetar altos estándares de calidad y competencia.']],
            ['type' => 'split_item', 'title' => 'A.F.I.P.', 'image' => ['file' => 'afip.png', 'alt' => 'AFIP'], 'paragraphs' => ['La <strong>Associazione Filatelisti Italiani Professionisti</strong> reúne a la mayoría de los profesionales del sector, garantizando a los coleccionistas normas de trabajo y un estatuto riguroso.']],
            ['type' => 'split_item', 'title' => 'IFISDA', 'image' => ['file' => 'ifisda_1.png', 'alt' => 'IFISDA'], 'paragraphs' => ['La <strong>International Federation Of Stamp Dealers Associations</strong> coordina las asociaciones nacionales de comerciantes filatélicos.']],
            ['type' => 'split_item', 'title' => 'Royal Numismatic Society', 'image' => ['file' => 'royal_numismatic_society_2fp0zp4l.png', 'alt' => 'Royal Numismatic Society'], 'paragraphs' => ['Asociación británica fundada en 1836 para los estudios numismáticos sobre monedas, medallas y elementos asociados a la moneda, con interés y socios internacionales.']],
            ['type' => 'split_item', 'title' => 'Confesercenti', 'image' => ['file' => 'confesercenti.png', 'alt' => 'Confesercenti'], 'paragraphs' => ['Fundada en Roma en 1971, es una de las principales asociaciones empresariales de Italia. Representa comercio, turismo, servicios, artesanía y pymes, con más de 350.000 empresas asociadas.']],
        ],
    ],
];

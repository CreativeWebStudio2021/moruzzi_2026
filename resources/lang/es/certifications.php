<?php

$certNote = 'Es posible solicitar, por un coste de € 8,00, la certificación que comprende la etiqueta con código QR, el certificado fotográfico y en línea para todas las monedas, medallas o billetes adquiridos en Moruzzi Numismatica a partir de 2009, que aún no dispongan de esta documentación.';

return [
    'common' => [
        'appointment_title' => 'Cita recomendada',
        'appointment_text' => 'Antes de acudir a la tienda, contáctenos al +39 06 7151 0220 para concertar una cita.',
        'pricing_note' => 'Los honorarios incluyen impuestos y tasas.',
        'perizia_detail' => 'Incluye la colocación de sellos sobre la funda y la etiqueta descriptiva, certificación fotográfica y código QR para la consulta digital.',
    ],

    'online' => [
        'title' => 'Certificado online',
        'lead' => 'El certificado online de Moruzzi Numismatica, vinculado al código QR presente en la etiqueta, permite comprobar con un solo clic la descripción, las imágenes y la procedencia de las monedas adquiridas.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Las monedas de Moruzzi Numismatica tienen un valor añadido adicional conferido por el conjunto de elementos contenidos en la etiqueta codificada que las acompaña. Este documento cumple la función de describir el ejemplar, de certificar su calidad, de garantizar su autenticidad y su procedencia lícita.',
                    'El precio indicado es el resultado de una correcta elaboración de la correspondencia entre el grado de rareza, el estado de conservación y las demás variables de la moneda.',
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Verificación con su smartphone',
                'paragraphs' => [
                    'Para una mayor protección de nuestra clientela, hemos incluido en la etiqueta y en el certificado también el código QR. Con un lector descargable gratuitamente en todos los smartphones, o mediante el enlace exclusivo indicado en el certificado en papel, es posible consultar online la descripción completa, las referencias de procedencia y las fotos del anverso y del reverso.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                   ['file' => 'certificato_qr01.jpg', 'alt' => 'Detalle del código QR en el certificado', 'caption' => 'Consulta digital inmediata'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'Moruzzi Numismatica es la primera empresa numismática del mundo en garantizar sus monedas <strong>sin tener que sellarlas</strong> en plástico rígido (slab), como ocurre en los Estados Unidos. Los coleccionistas italianos y europeos pueden así mantener un contacto directo con las monedas de su colección.',
                    'El certificado online permite verificar, también gracias a las fotos de alta calidad, el origen y la calidad de las monedas procedentes de nuestra casa: un paso adelante en transparencia y seguridad de las compras. La certificación no es falsificable porque está garantizada por una página web dedicada e inalterable.',
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Nota importante',
                'paragraphs' => [
                    'Por precaución, para evitar estafas o fraudes, asegúrese de que el enlace indicado en el certificado fotográfico comience siempre por <strong>https://www.moruzzi.it/</strong>.',
                    'El certificado en papel, emitido y enviado también para las compras online, presenta el código QR para la verificación mediante smartphone o mediante la dirección de internet indicada en el documento.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-QR01.jpg', 'alt' => 'Leyenda de los elementos de la etiqueta con código QR'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'quality' => [
        'title' => 'Certificación de calidad Moruzzi',
        'lead' => 'La certificación de calidad Moruzzi resume de forma clara el estado de conservación, la rareza, el metal y la procedencia, aportando un importante valor añadido al coleccionista.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Las monedas de Moruzzi Numismatica tienen un valor añadido también por el conjunto de elementos contenidos en la etiqueta que las acompaña. La etiqueta cumple la doble función de describir el ejemplar y de garantizar su originalidad; el precio indicado es el resultado de una correcta correspondencia entre el estado de conservación, el grado de rareza y otras variables.',
                    'Hoy la etiqueta incluye también un <strong>código QR</strong>, sin perder nada respecto a la clásica: con un lector presente en aplicaciones gratuitas para iPhone, iPad, iPod y smartphones Android es posible leer el certificado descriptivo completo con procedencia y fotos del anverso y del reverso.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-cartellino.jpg', 'alt' => 'Leyenda de la etiqueta Moruzzi Numismatica', 'caption' => 'La etiqueta clásica, aún válida'],
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-QR01_p23l4f70.jpg', 'alt' => 'Etiqueta con código QR', 'caption' => 'La nueva certificación digital'],
                ],
            ],
            [
                'type' => 'features',
                'title' => 'Contenido de la etiqueta',
                'items' => [
                    ['title' => 'Descripción completa', 'text' => 'Autoridad emisora, periodo histórico, tipo de moneda, año y ceca cuando se conocen, leyendas o descripciones del anverso y del reverso.'],
                    ['title' => 'Bibliografía y rareza', 'text' => 'Hasta tres publicaciones de referencia con números identificativos y, a menudo, el grado de rareza indicado por los autores.'],
                    ['title' => 'Procedencia y transparencia', 'text' => 'Indicación del pedigree cuando es público (subastas prestigiosas, colecciones conocidas) y código alfanumérico para verificar siempre su procedencia.'],
                    ['title' => 'Metal, peso y precio', 'text' => 'Metal, peso al centésimo de gramo, escala de rareza de 1 a 5 R y estado de conservación claramente indicado junto con el precio.'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Garantía sin caducidad',
                'paragraphs' => [
                    'Conforme al art. 64 del D.Lgs. 42/2004 (Código de los bienes culturales), la etiqueta es garantía de absoluta autenticidad y de todo lo que en ella se indica. La Garantía Moruzzi Numismatica sobre la originalidad de las monedas vendidas <strong>nunca caduca</strong> y vale también para la correcta catalogación y la exacta indicación del estado de conservación.',
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'guarantee' => [
        'title' => 'Garantía Moruzzi Numismatica',
        'lead' => 'La Garantía Moruzzi Numismatica es por tiempo indefinido: protege la autenticidad, la correcta catalogación y el estado de conservación de cada ejemplar vendido.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'El primer indicio de seriedad de nuestra casa es la confianza que nuestros clientes nos reconocen desde hace más de treinta años. No obstante, ofrecemos una garantía formal sobre los objetos numismáticos que ponemos a la venta: la <strong>Garantía Moruzzi Numismatica</strong>.',
                    'La ley prevé, como establece el art. 64 del D.Lgs. 42/2004, entregar al comprador un certificado de garantía y procedencia. Moruzzi Numismatica va más allá: asegura a las monedas y billetes de colección vendidos una garantía ilimitada en el tiempo tanto sobre la autenticidad como sobre todas las características indicadas en la etiqueta.',
                ],
            ],
            [
                'type' => 'images',
                'items' => [
                    ['file' => 'riempitivo_garanzia.jpg', 'alt' => 'Garantía Moruzzi Numismatica', 'caption' => 'Garantía por tiempo indefinido'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Qué cubre la garantía',
                'paragraphs' => [
                    'La garantía sobre la originalidad de las monedas vendidas nunca caduca y vale no solo para la autenticidad del bien, sino también para la correcta catalogación y, sobre todo, para la exacta indicación del estado de conservación.',
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'Quien ejerza la actividad de venta al público de obras de arte, objetos de antigüedad o de interés histórico o arqueológico tiene la obligación de entregar al comprador la documentación que acredite la autenticidad o al menos la probable atribución y la procedencia; en su defecto, debe emitir una declaración con toda la información disponible, preferiblemente estampada sobre una copia fotográfica del objeto.',
                ],
            ],
        ],
    ],

    'attestati' => [
        'title' => 'Certificados de garantía y procedencia',
        'lead' => 'Los certificados de garantía y procedencia acompañan las monedas antiguas con documentación completa, imágenes y referencias a los registros de entrada.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Las monedas antiguas vendidas por Moruzzi Numismatica van acompañadas de este importante documento. Se trata de una certificación que recoge ampliamente las obligaciones legales y responde a las exigencias del coleccionista moderno, que desea conservar junto a las monedas una documentación lo más completa posible.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'cetificati_mn1.jpg', 'alt' => 'Certificado de garantía y procedencia Moruzzi', 'caption' => 'Certificado de garantía y procedencia'],
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'certificato_qr01_b4ubt21n.jpg', 'alt' => 'Certificado con código QR', 'caption' => 'Verificación online mediante código QR'],
                ],
            ],
            [
                'type' => 'features',
                'title' => 'Contenido del certificado',
                'items' => [
                    ['title' => 'Descripción y bibliografía', 'text' => 'Descripción completa de la moneda con referencias bibliográficas y fotos del anverso y del reverso.'],
                    ['title' => 'Código único', 'text' => 'Código identificativo, rareza, peso y estado de conservación para una consulta rápida y transparente.'],
                    ['title' => 'Procedencia lícita', 'text' => 'Garantía de originalidad y procedencia lícita con numeraciones de los registros donde el ejemplar está inscrito.'],
                    ['title' => 'Verificación digital', 'text' => 'Código QR para consultar el certificado online desde el smartphone o mediante un código web dedicado.'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'standard' => [
        'title' => 'Estándar de calidad',
        'lead' => 'Cada propuesta de Moruzzi Numismatica respeta elevados estándares de conservación, estética y técnica, ilustrados también mediante histogramas dedicados a los distintos parámetros.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Nuestras monedas, medallas y billetes se seleccionan en relación con elevados estándares de conservación, estética y técnica. Algunas de las propuestas más interesantes van acompañadas en las fichas del e-commerce por histogramas, además de la descripción que acompaña a todas nuestras propuestas.',
                ],
            ],
            [
                'type' => 'images',
                'items' => [
                    ['file' => 'augusto_denario01.jpg', 'alt' => 'Denario de Augusto', 'caption' => 'Ejemplo de moneda de elevada calidad'],
                    ['file' => '141943a.jpg', 'alt' => 'Detalle de conservación de moneda antigua'],
                ],
            ],
            [
                'type' => 'meters',
                'title' => 'Los seis parámetros de evaluación',
                'items' => [
                    ['label' => 'Conservación', 'value' => '82%', 'hint' => 'Escala europea / Sheldon', 'text' => 'De D (discreto) a FDC (flor de cuño), expresada también en setentaavos para los coleccionistas americanos y asiáticos.'],
                    ['label' => 'Rareza', 'value' => '68%', 'hint' => 'De C a RRRRRR', 'text' => 'Porcentaje que va desde valores bajos para monedas comunes hasta el 100 % para ejemplares únicos o casi únicos.'],
                    ['label' => 'Metal y pátina', 'value' => '74%', 'hint' => 'Calidad de la aleación', 'text' => 'Evaluación de daños por acuñación, desgaste a lo largo del tiempo y limpiezas inadecuadas; la pátina de calidad es un valor añadido.'],
                    ['label' => 'Estilo', 'value' => '88%', 'hint' => 'Fineza artística', 'text' => 'El estilo de los cuños puede ser más importante que la conservación en las producciones numismáticas más artísticas.'],
                    ['label' => 'Acuñación', 'value' => '76%', 'hint' => 'Calidad productiva', 'text' => 'Examen de fracturas, deslizamientos de cuño y calidad del golpe que resalta los relieves.'],
                    ['label' => 'Procedencia', 'value' => '62%', 'hint' => 'Pedigree', 'text' => 'Subastas, tiendas y colecciones prestigiosas aumentan el porcentaje respecto a procedencias rastreadas solo recientemente.'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'Los objetos que no responden a estas características de calidad se proponen en condiciones particularmente ventajosas. Cada moneda propuesta por Moruzzi Numismatica tiene una procedencia absolutamente lícita y consta en los registros de las autoridades competentes.',
                ],
            ],
        ],
    ],

    'upgrade' => [
        'title' => 'Upgrade de calidad',
        'lead' => 'El servicio de upgrade de calidad permite sustituir ejemplares ya adquiridos por otros de grado superior, abonando únicamente la diferencia de precio.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Cada coleccionista, al inicio de su colección, a menudo se conforma con ejemplares poco costosos y poco bien conservados. Con el tiempo el gusto se afina y las primeras monedas adquiridas pueden dejar de satisfacer. Por ello existe la promoción upgrade de Moruzzi Numismatica.',
                    'No todos pueden permitirse de inmediato la calidad top: para «cerrar un hueco» de la colección se puede conformar con un ejemplar menos bello, con la posibilidad de sustituirlo posteriormente por uno de grado superior.',
                ],
            ],
            [
                'type' => 'upgrade_flow',
                'steps' => [
                    ['file' => 'promozionea.jpg', 'alt' => 'Ejemplar de calidad inferior', 'caption' => 'Ejemplar ya en colección'],
                    ['file' => 'promozione.jpg', 'alt' => 'Ejemplar de calidad superior', 'caption' => 'Upgrade disponible en tienda'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Cómo funciona',
                'paragraphs' => [
                    'A quien haya realizado al menos <strong>tres compras en los últimos dos años</strong> se le reconoce la posibilidad de sustituir las monedas adquiridas en Moruzzi Numismatica por ejemplares de mejor calidad, abonando únicamente la diferencia de precio; el ejemplar devuelto se valora al precio pagado.',
                    'Ejemplo: para mejorar una moneda de 10 liras de 1927 en BB adquirida a € 30,00 con una SPL de € 100,00 basta abonar € 70,00. La promoción vale para monedas (antiguas, modernas y contemporáneas) y billetes, solo si los ejemplares sustitutivos están disponibles y las monedas devueltas tienen la etiqueta Moruzzi.',
                ],
            ],
        ],
    ],

    'estimates_coins' => [
        'title' => 'Tasaciones y peritajes de monedas',
        'appointment' => true,
        'lead' => 'Umberto Moruzzi ofrece tasaciones y peritajes de monedas antiguas y modernas, con registro completo de datos e imágenes en alta resolución.',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => [
                    'file' => 'stime-e-perizie-di-monete.jpg',
                    'alt' => 'Tasaciones y peritajes de monedas Moruzzi Numismatica',
                ],
                'paragraphs' => [
                    'Para tasaciones y peritajes de monedas antiguas, modernas y medallas puede dirigirse a nuestra oficina de Roma, al numismático <strong>Umberto Moruzzi</strong>, perito de la Cámara de Comercio y del Tribunal de Roma.',
                    'Los servicios periciales prevén, en todo caso, el registro completo de los elementos identificativos de los ejemplares examinados y la conservación de las imágenes en alta resolución, para verificar a lo largo del tiempo la correspondencia con las certificaciones y catalogaciones emitidas.',
                    'Con el mismo rigor se realizan tasaciones de ejemplares individuales y de colecciones enteras de monedas de colección.',
                ],
            ],
            [
                'type' => 'links',
                'title' => 'Servicios relacionados',
                'items' => [
                    ['route' => 'certifications.expertise_coins', 'label' => 'Peritajes de monedas'],
                    ['route' => 'certifications.estimates_banknotes', 'label' => 'Tasaciones y peritajes de billetes'],
                    ['route' => 'certifications.cataloguing', 'label' => 'Catalogaciones'],
                    ['route' => 'certifications.valuation', 'label' => 'Valoración de monedas y billetes'],
                ],
            ],
        ],
    ],

    'estimates_banknotes' => [
        'title' => 'Tasaciones y peritajes de billetes',
        'appointment' => true,
        'lead' => 'Servicio de tasación y peritaje para billetes italianos y mundiales, con atención a la correcta catalogación y conservación de las imágenes de referencia.',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => [
                    'file' => 'stime-e-perizie-di-banconote.jpg',
                    'alt' => 'Tasaciones y peritajes de billetes',
                ],
                'paragraphs' => [
                    'Para peritajes de billetes puede dirigirse a nuestra oficina de Roma: <strong>Umberto Moruzzi</strong>, perito de la Cámara de Comercio y del Tribunal de Roma, redacta certificaciones de billetes y catalogaciones.',
                    'Cada servicio incluye el registro completo de los elementos identificativos y la conservación de las imágenes en alta resolución, para verificar a lo largo del tiempo la correspondencia entre el ejemplar y la documentación emitida.',
                    'También se realizan tasaciones de ejemplares individuales y de colecciones enteras de billetes.',
                ],
            ],
            [
                'type' => 'links',
                'title' => 'Servicios relacionados',
                'items' => [
                    ['route' => 'certifications.expertise_banknotes', 'label' => 'Peritajes de billetes'],
                    ['route' => 'certifications.cataloguing', 'label' => 'Catalogaciones'],
                    ['route' => 'certifications.valuation', 'label' => 'Valoración de monedas y billetes'],
                ],
            ],
        ],
    ],

    'expertise_coins' => [
        'title' => 'Peritajes de monedas',
        'appointment' => true,
        'lead' => 'Peritajes de monedas antiguas, modernas y medallas, con colocación de sellos y certificado fotográfico dotado de código QR para la consulta digital.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi, perito de la Cámara de Comercio y del Tribunal de Roma, realiza peritajes de monedas antiguas, modernas y medallas en Roma. Todos los servicios comprenden el registro completo de los elementos identificativos y la conservación de las imágenes en alta resolución.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarifas peritajes monedas antiguas',
                'note' => 'Los honorarios incluyen impuestos y tasas. Incluye la colocación de sellos sobre la funda y la etiqueta descriptiva, certificación fotográfica y código QR para la consulta digital.',
                'rows' => [
                    ['label' => 'Monedas antiguas de valor inferior a € 300', 'price' => '€ 30,00'],
                    ['label' => 'Monedas antiguas de valor entre € 301 y € 1.000', 'price' => '€ 40,00'],
                    ['label' => 'Monedas antiguas de valor entre € 1.001 y € 5.000', 'price' => '€ 70,00'],
                    ['label' => 'Monedas antiguas de valor entre € 5.001 y € 10.000', 'price' => '€ 150,00'],
                    ['label' => 'Monedas antiguas de valor entre € 10.001 y € 20.000', 'price' => '€ 300,00'],
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarifas peritajes monedas modernas',
                'rows' => [
                    ['label' => 'Monedas modernas de valor inferior a € 300', 'price' => '€ 20,00'],
                    ['label' => 'Monedas modernas de valor entre € 301 y € 1.000', 'price' => '€ 25,00'],
                    ['label' => 'Monedas modernas de valor entre € 1.001 y € 5.000', 'price' => '€ 50,00'],
                    ['label' => 'Monedas modernas de valor entre € 5.001 y € 10.000', 'price' => '€ 100,00'],
                    ['label' => 'Monedas modernas de valor entre € 10.001 y € 20.000', 'price' => '€ 200,00'],
                    ['label' => 'Peritaje de medallas con certificado fotográfico e indicación de la eventual producción coetánea', 'price' => '€ 60,00'],
                    ['label' => 'Consultoría técnica numismática en sede judicial', 'price' => 'Bajo presupuesto'],
                ],
            ],
        ],
    ],

    'valuation' => [
        'title' => 'Valoración de monedas y billetes',
        'appointment' => true,
        'lead' => 'Valoraciones de ejemplares individuales y colecciones de monedas y billetes, con indicación del valor de compra y de venta.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi, perito de la Cámara de Comercio y del Tribunal de Roma, realiza valoraciones de monedas antiguas y modernas, medallas y billetes en Roma, con indicación del valor de compra y de venta cuando se solicite.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarifas valoración',
                'note' => 'Los honorarios incluyen impuestos y tasas.',
                'rows' => [
                    ['label' => 'Consultoría técnica numismática de distinta complejidad para monedas, medallas y papel moneda, también en sede judicial', 'price' => 'Bajo presupuesto'],
                    ['label' => 'Tasación de colecciones o monedas individuales hasta € 6.000, con valor de compra y de venta', 'price' => '€ 378,00'],
                    ['label' => 'Tasación de colecciones o monedas individuales por encima de € 6.000, con valor de compra y de venta', 'price' => '6,3% del valor tasado'],
                    ['label' => 'Tasaciones a domicilio (además del porcentaje, desplazamiento a convenir)', 'price' => 'desde € 180,00'],
                ],
            ],
        ],
    ],

    'expertise_banknotes' => [
        'title' => 'Peritajes de billetes',
        'appointment' => true,
        'lead' => 'Peritajes especializados de papel moneda italiano y extranjero, con conservación de las imágenes y de los datos identificativos para verificaciones futuras.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi realiza peritajes de billetes italianos y extranjeros en Roma, además de catalogaciones. Cada servicio incluye el registro completo de los elementos identificativos y la conservación de las imágenes en alta resolución.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarifas peritajes billetes',
                'note' => 'Los honorarios incluyen impuestos y tasas.',
                'rows' => [
                    ['label' => 'Papel moneda italiano (Billetes de Estado, Bonos de Caja, Billetes del Banco de Italia) hasta € 300', 'price' => '€ 20,00'],
                    ['label' => 'Valor entre € 301 y € 1.000', 'price' => '€ 25,00'],
                    ['label' => 'Valor entre € 1.001 y € 5.000', 'price' => '€ 50,00'],
                    ['label' => 'Valor entre € 5.001 y € 10.000', 'price' => '€ 100,00'],
                    ['label' => 'Valor entre € 10.001 y € 20.000', 'price' => '€ 200,00'],
                    ['label' => 'Consultoría técnica numismática en sede judicial', 'price' => 'Bajo presupuesto'],
                ],
            ],
        ],
    ],

    'cataloguing' => [
        'title' => 'Catalogaciones de monedas y billetes',
        'appointment' => true,
        'lead' => 'Servicio de catalogación especializada de monedas, medallas y billetes, con registro de los elementos identificativos e imágenes en alta definición.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi realiza la catalogación de monedas, medallas y billetes en Roma. El servicio comprende el registro completo de los elementos identificativos y la conservación de las imágenes en alta resolución, para verificar a lo largo del tiempo la correspondencia entre los ejemplares y las catalogaciones emitidas.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tarifas catalogación',
                'note' => 'Los honorarios incluyen impuestos y tasas.',
                'rows' => [
                    ['label' => 'Consultoría técnica numismática en sede judicial', 'price' => 'Bajo presupuesto'],
                    ['label' => 'Catalogación especializada de monedas romanas republicanas e imperiales, teseras y medallones', 'price' => '€ 18,50'],
                    ['label' => 'Catalogación de monedas griegas, griegas imperiales, bizantinas y medievales italianas y europeas', 'price' => '€ 18,50'],
                    ['label' => 'Catalogación especializada de billetes individuales y colecciones enteras', 'price' => '€ 18,50 c/u'],
                ],
            ],
        ],
    ],
];

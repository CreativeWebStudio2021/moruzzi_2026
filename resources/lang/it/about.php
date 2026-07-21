<?php

return [
    'presentation' => [
        'title' => 'Ci presentiamo',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => ['file' => 'moruzzi_nello_new.jpg', 'alt' => 'Nello Moruzzi'],
                'paragraphs' => [
                    'La Moruzzi Numismatica nasce dalla passione e dall\'esperienza professionale di mio padre Nello Moruzzi, noto e stimato numismatico italiano fin dagli anni \'60.',
                    'Per molti anni collaborò con il collega Federico Bartoli, contribuendo al successo della Sua ditta, la A & B Numismatica. Oltre ai suoi valori di uomo generoso ed onesto, ci ha trasmesso la passione per la numismatica nonché il suo grande bagaglio culturale e professionale. Dal maggio 1980 ci ha affidato l\'impresa, ma ha continuato a consigliarci e spronarci affinché questa nostra splendida attività diventasse sempre più professionale ed importante. Una continuità di oltre 50 anni, che ha reso storico il nostro negozio, divenuto nel tempo punto di riferimento del collezionismo numismatico italiano.',
                ],
            ],
            [
                'type' => 'split_panel',
                'paragraphs' => [
                    'Lui ci ha lasciati nel 1996, ma il suo ricordo ed i suoi consigli sono ancora vivi in noi ed animano ancora il nostro lavoro.',
                    'Oggi la nostra attività è principalmente indirizzata alla numismatica antica e moderna; reperiamo le migliori monete non solo sul mercato nazionale, ma anche e soprattutto in Europa e nel mondo, e nelle più importanti vendite all\'asta del settore. Le nostre proposte vengono attentamente esaminate per assicurare l\'originalità e determinarne l\'esatto stato di conservazione ed una corretta valutazione. Storicamente la Moruzzi Numismatica dedica grande attenzione al collezionismo delle banconote nonostante un certo snobismo dei professionisti numismatici che, soprattutto nel passato, ha trattato con una certa sufficienza questo settore.',
                ],
                'carousel' => [
                    'prev_label' => 'Immagine precedente',
                    'next_label' => 'Immagine successiva',
                    'items' => [
                        ['file' => 'moruzzi_oldshop2.jpg', 'alt' => 'Vecchio negozio Moruzzi Numismatica a Roma', 'caption' => 'Vecchio negozio della Moruzzi Numismatica a Roma'],
                        ['file' => 'moruzzi_newshop.png', 'alt' => 'Attuale negozio Moruzzi Numismatica a Roma', 'caption' => 'Negozio della Moruzzi Numismatica a Roma'],
                    ],
                ],
            ],
            [
                'type' => 'split_item',
                'anchor' => 'dove-siamo',
                'image' => ['file' => 'moruzzi_newshop.png', 'alt' => 'Negozio Moruzzi Numismatica a Roma, quartiere Cinecittà'],
                'title' => 'Dove siamo',
                'paragraphs' => [
                    'Vuoi iniziare a collezionare? Hai delle monete da vendere? Sei capitato nel posto giusto! <strong>La Moruzzi Numismatica</strong>, storico negozio numismatico di Roma facilmente raggiungibile con ogni tipo di mezzo, ti offre la massima trasparenza e la grande professionalità del suo <a href="/chi-siamo/lo-staff">staff</a>.',
                    '<strong>Moruzzi Numismatica</strong><br>Viale dei Salesiani, 12a<br>00175 Roma',
                    'Il negozio e gli uffici sono situati nel quartiere Cinecittà, una zona di Roma ben collegata praticamente con tutti i mezzi di trasporto. Nelle vicinanze sono presenti grandi parcheggi pubblici e anche un comodo garage a ore. La fermata metro <strong>Giulio Agricola</strong> (linea A) dista circa 250 metri.',
                ],
            ],
            [
                'type' => 'cta',
                'url' => '/contatti',
                'label' => 'Indicazioni e contatti',
                'title' => 'Scopri come raggiungerci e contattaci',
                'text' => 'Per indicazioni stradali dettagliate (auto, treno, aeroporti) e per scriverci, visita la pagina contatti.',
            ],
        ],
    ],

    'staff' => [
        'title' => 'Lo staff',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Uno staff di qualificati professionisti nel settore della numismatica è al vostro servizio per condurvi, attraverso le monete, sui sentieri della storia.',
                    'La <strong>Qualità Moruzzi</strong>, prodotto delle nostre risorse professionali con pluriennale esperienza internazionale, ci permette di garantirvi l’assoluta genuinità e qualità degli esemplari proposti, accompagnati da una completa certificazione. Anche tutti gli altri servizi vengono offerti curando ogni minimo dettaglio.',
                    'La forza del nostro qualificato staff risiede nella condivisione della comune passione per la numismatica, che ci fa lavorare come una squadra con reciproca stima e fiducia. Prova ne è la quasi quarantennale attività, che ci ha permesso di ampliare i nostri servizi conquistando nuove quote di mercato.',
                ],
            ],
            [
                'type' => 'staff_grid',
                'items' => [
                    ['route' => 'about.loredana', 'file' => 'Loredana-Moruzzi02_9a6e3sk4.jpg', 'alt' => 'Loredana Moruzzi', 'name' => 'Loredana Moruzzi', 'role' => '<em>Amministratore / Responsabile Vendite</em><br>CEO / Showroom Manager'],
                    ['route' => 'about.umberto', 'file' => 'Umberto-Moruzzi02.jpg', 'alt' => 'Umberto Moruzzi', 'name' => 'Umberto Moruzzi', 'role' => '<em>Direttore Dipartimento Numismatico</em><br>Senior Numismatist'],
                    ['route' => 'about.francesca', 'file' => 'Barenghi_Francesca2_8ltw71wn.jpg', 'alt' => 'Francesca Barenghi', 'name' => 'Francesca Barenghi', 'role' => '<em>Dipartimento monete greche e romane</em><br>Numismatist (Greek and Roman Coins Department)'],
                    ['route' => 'about.nicola', 'file' => 'Nicola-Mecci02.jpg', 'alt' => 'Nicola Mecci', 'name' => 'Nicola Mecci', 'role' => '<em>Vendite Online e Marketing</em><br>Web Sales and Marketing'],
                    ['file' => 'EmanuelaPittola02.jpg', 'alt' => 'Emanuela Pittola', 'name' => 'Emanuela Pittola', 'role' => '<em>Amministrazione</em><br>Administration'],
                    ['file' => 'Daniela-franchi02.jpg', 'alt' => 'Daniela Franchi', 'name' => 'Daniela Franchi', 'role' => '<em>Amministrazione</em><br>Administration'],
                    ['route' => 'about.hiroko', 'file' => 'hiroko02.jpg', 'alt' => 'Hiroko Blue Lynx', 'name' => 'Hiroko Blue Lynx', 'role' => 'Assistente alle vendite<br>Sales assistant'],
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
                    'La sua profonda conoscenza del settore si è formata grazie alla quasi quarantennale esperienza all\'interno dell\'azienda di famiglia. Oltre ad occuparsi dell\'amministrazione è il responsabile delle vendite. I clienti di tutto il mondo trovano in lei un referente disponibile a soddisfare le loro esigenze.',
                    'Ne sono testimonianza i numerosi clienti con cui da anni intrattiene rapporti amichevoli, basati sulla stima reciproca. Cura con molta attenzione la fase post-vendita, seguendo la fatturazione ed il processo di spedizione fino a destinazione.',
                    'È sua cura contattare i clienti che le affidano le proprie mancoliste. Con gentilezza e professionalità risponde alla maggior parte dei quesiti dei visitatori di questo sito.',
                ],
            ],
        ],
    ],

    'umberto' => [
        'title' => 'Umberto Moruzzi',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => ['file' => 'Umberto-Moruzzi01_08hsgn2j.jpg', 'alt' => 'Umberto Moruzzi - Perito numismatico a Roma'],
                'paragraphs' => [
                    'Umberto Moruzzi, studioso numismatico, ha ripreso la tradizione paterna specializzandosi in particolare nella monetazione romana ed italiana. Si è occupato della Moruzzi Numismatica già dal 1980 portandola alla notorietà di oggi, una delle più rinomate ditte numismatiche italiane.',
                    'Attualmente si dedica prevalentemente alla propria attività professionale, quale consulente numismatico, seguendo comunque l\'azienda di famiglia, ancor oggi proprietà della famiglia Moruzzi, dove verifica le monete acquistate e valuta gli oggetti più particolari. Iscritto alla Camera di Commercio come Perito Numismatico, è anche membro esaminatore per la Numismatica e la Sfragistica presso la commissione esaminatrice della stessa Camera di Commercio di Roma sin dal 1993.',
                    'Iscritto all\'ordine dei giornalisti del Lazio scrive di numismatica sui giornali del settore e su quotidiani nazionali. È socio fondatore della NIP, Associazione dei Numismatici Italiani Professionisti di cui è stato il segretario dal 1999 al 2001. Si è occupato anche della FENAP, Federazione Europea delle Società e Associazioni dei Numismatici Professionisti di cui è stato segretario dal 2000 al 2001. È socio inoltre della Royal Numismatic Society, della Società Numismatica Italiana, della NIA e della associazione numismatica tedesca Berufsverband des Deutschen Münzenfachhandels e.V.',
                    'È perito del Tribunale di Roma ed ha svolto vari incarichi come Consulente Tecnico per diverse Procure italiane, tra cui Roma e Milano, eseguendo alcune tra le più importanti perizie numismatiche del dopoguerra in Italia.',
                    'Ha organizzato varie esposizioni tra le quali ha riscosso notevole successo la mostra itinerante «Il Vero e il Falso» della Guardia di Finanza.',
                    'È stato curatore storico scientifico per la coniazione ufficiale di Expo Milano 2015.',
                    'È attualmente curatore numismatico presso il Museo Storico della Guardia di Finanza.',
                    'È attualmente vicepresidente dell\'associazione professionale N.I.P. (Numismatica Italiani Professionisti).',
                ],
            ],
            [
                'type' => 'cta',
                'url' => 'https://www.umbertomoruzzi.it/',
                'label' => 'Sito ufficiale',
                'title' => 'Visita il sito ufficiale del perito numismatico Umberto Moruzzi',
                'text' => 'Per approfondimenti, articoli e attività professionali di Umberto Moruzzi è disponibile il sito dedicato.',
            ],
        ],
    ],

    'nicola' => [
        'title' => 'Nicola Mecci',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => ['file' => 'Nicola-Mecci01_bu8l0fda.jpg', 'alt' => 'Nicola Mecci - Vendite online'],
                'paragraphs' => [
                    'Da sempre appassionato di numismatica antica e moderna, si è avvicinato a questo mondo grazie agli insegnamenti di un anziano collezionista siciliano.',
                    'Responsabile della vendita online sulle varie piattaforme informatiche (sito e-commerce, negozi su eBay, VCoins e Ma-Shops) e dei rapporti con la clientela italiana ed internazionale.',
                    'Ricopre la carica di SEO e social media manager per la Moruzzi Numismatica.',
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
                    'Appassionata fin da bambina alle antichità classiche, ha intrapreso all\'università la formazione accademica di archeologa classica. Ha studiato numismatica all\'Università di Roma "La Sapienza", frequentando i corsi della professoressa Breglia, e dei professori Panvini Rosati e Parise. Si è laureata in lettere classiche con il massimo dei voti e lode presentando una tesi di numismatica celto-padana.',
                    'Ha conseguito il diploma di Specializzazione in Archeologia con il massimo dei voti e lode, discutendo una tesi sull\'analisi quantitativa dell\'usura delle monete e dei medaglioni imperiali. Ha partecipato come relatrice a molti congressi internazionali di numismatica, pubblicando numerosi articoli scientifici su riviste accademiche e su periodici del settore numismatico.',
                    'Ha ottenuto una borsa di studio dal Governo francese, partecipando al progetto di studio diretto dal Prof. J. P. Callu de l\'Ecole des Hautes Etudes, e ha frequentato i corsi di numismatica per dottorandi all\'Ecole Normale Supérieure tenuti dal Prof. J. B. Giard. Ha conseguito un Dottorato di Ricerca in Archeologia, lavorando sui medaglioni romani imperiali presso i più prestigiosi medaglieri europei.',
                    'Parla correntemente, oltre all\'italiano, il francese; ha una buona familiarità con il tedesco e una conoscenza dell\'inglese. Si occupa della classificazione delle monete sia antiche che moderne e cura la parte culturale del sito, preparando relazioni ed articoli. Per la Moruzzi Numismatica è l\'esperta della monetazione romana.',
                ],
            ],
        ],
    ],

    'publications' => [
        'title' => 'Le nostre pubblicazioni',
        'lead' => 'La Moruzzi Numismatica ha pubblicato o ha fornito un\'importante collaborazione alla pubblicazione dei seguenti lavori:',
        'blocks' => [
            ['type' => 'split_item', 'image' => ['file' => '1988.jpg', 'alt' => 'Copertina catalogo Monete e medaglie, Roma 1988'], 'title' => 'Monete e medaglie, Roma 1988', 'paragraphs' => ['Era il primo catalogo presentato dalla Moruzzi Numismatica, che già si distingueva per la cura con cui era realizzato e per la selezione delle monete proposte. Il catalogo proponeva alla vendita monete greche, romane, italiane (sia medievali che moderne), pontificie e altre.']],
            ['type' => 'split_item', 'image' => ['file' => '1992.jpg', 'alt' => 'Copertina catalogo asta pubblica, Roma 28 febbraio 1992'], 'title' => 'Monete, medaglie e banconote. Asta pubblica, Roma 28 febbraio 1992', 'paragraphs' => ['Il catalogo di vendita all\'asta della Moruzzi Arte Roma con monete antiche e moderne ebbe notevole successo di vendita e di pubblico.']],
            ['type' => 'split_item', 'image' => ['file' => '1994.jpg', 'alt' => 'Copertina Le banconote del mondo, Roma 1994'], 'title' => 'Le banconote del mondo, Roma 1994', 'paragraphs' => ['Listino di vendita di banconote mondiali. Le banconote negli anni \'90 furono «scoperte» da un grande numero di collezionisti italiani.']],
            ['type' => 'split_item', 'image' => ['file' => '1995a.jpg', 'alt' => 'Copertina Argent, Le banconote d\'Italia, Roma 1995'], 'title' => 'Argent, Le banconote d\'Italia, Roma 1995', 'paragraphs' => ['La richiesta di banconote italiane era particolarmente elevata e la Moruzzi Numismatica, attenta alla domanda dei collezionisti, proponeva una collezione di biglietti di notevole livello, per qualità e rarità.']],
            ['type' => 'split_item', 'image' => ['file' => '1995.jpg', 'alt' => 'Copertina Excellence, Roma 1995'], 'title' => 'Excellence, Roma 1995', 'paragraphs' => ['Un catalogo con monete greche, romane, bizantine, italiane ed estere particolarmente selezionate. Al centro del catalogo era stampata una doppia pagina con le immagini a colori dei migliori esemplari presentati.']],
            ['type' => 'split_item', 'image' => ['file' => '1997.jpg', 'alt' => 'Copertina Jvlia, Roma 1997'], 'title' => 'Jvlia, Roma 1997', 'paragraphs' => ['Il catalogo inaugurava una serie di pubblicazioni che riportano i nomi delle più antiche gentes romane. Per prima fu scelto quello della gens Julia. Il catalogo, di standard internazionale, proponeva monete antiche, moderne italiane e straniere di ottima qualità.']],
            ['type' => 'split_item', 'image' => ['file' => '1998.jpg', 'alt' => 'Copertina Claudia, Roma 1998'], 'title' => 'Claudia, Roma 1998', 'paragraphs' => ['Il catalogo di vendita a prezzi netti continuava la serie di pubblicazioni inaugurata con Jvlia, offrendo monete antiche di rara bellezza e conservazione, ma anche collezioni di monete delle zecche italiane, papali e del Regno d\'Italia.']],
            ['type' => 'split_item', 'image' => ['file' => '1990.jpg', 'alt' => 'Copertina Una collezione di antoniniani, Roma 1990'], 'title' => 'Una collezione di antoniniani. Vendita generale di monete e medaglie, Roma 1990', 'paragraphs' => ['Il catalogo proponeva una ricchissima collezione di ben 1.000 antoniniani differenti, preceduta da un\'interessante introduzione storica. Ancora oggi è una pubblicazione ricercata dagli studiosi.']],
            ['type' => 'split_item', 'image' => ['file' => '1992cassettas.jpg', 'alt' => 'Videocatalogo asta pubblica del 28 febbraio 1992'], 'title' => 'Videocatalogo dell\'asta pubblica del 28 febbraio 1992', 'paragraphs' => ['Il videocatalogo della vendita all\'asta della Moruzzi Arte Roma con monete antiche e moderne. Il nastro con musica classica di sottofondo era all\'epoca unico nel suo genere e permetteva di vedere in video le immagini ingrandite delle monete poste in vendita.']],
            ['type' => 'split_item', 'image' => ['file' => '2002.jpg', 'alt' => 'Copertina Addio alla Lira, Roma 2002'], 'title' => 'Addio alla Lira. Tre secoli di storia italiana attraverso le banconote, Roma 2002', 'paragraphs' => ['Con questo catalogo abbiamo dato un nostalgico saluto alla vecchia Lira: un addio solo formale alla sua circolazione come valuta, poiché questa rimane nella storia di tutti gli italiani, nella memoria collettiva ed in quella di ogni individuo.']],
            ['type' => 'split_item', 'image' => ['file' => '2006es.jpg', 'alt' => 'Copertina Una collezione di Medaglie - Estate 2006'], 'title' => 'Una collezione di Medaglie - Estate 2006, Roma', 'paragraphs' => ['Catalogo in collaborazione con la ditta numismatica A&B. Una bella selezione di medaglie, la quasi totalità pontificie, con rari esemplari ed alcune interessanti note.']],
            ['type' => 'split_item', 'image' => ['file' => '2007s.jpg', 'alt' => 'Copertina FLAVIA 2007'], 'title' => 'FLAVIA 2007, Roma 2007', 'paragraphs' => ['Uno splendido piccolo catalogo che ha riscosso grande successo con selezionatissime monete, suddivise per temi: ritratti delle auguste, medi bronzi imperiali, impero gallico, denari imperiali, argento della Roma repubblicana e monete dell\'impero e delle province romane.']],
            ['type' => 'split_item', 'image' => ['file' => 'il-vero-e-il-falso_1.jpg', 'alt' => 'Copertina IL VERO e IL FALSO, Roma 2008'], 'title' => 'IL VERO e IL FALSO, Roma 2008', 'paragraphs' => ['Catalogo della mostra itinerante omonima già tenutasi a Roma, Firenze, Vicenza e Perugia. Ripercorre l\'evoluzione del fenomeno della falsificazione attraverso monete antiche, medievali e moderne, oltre a banconote della Banca d\'Italia.']],
            ['type' => 'split_item', 'image' => ['file' => '2006as.jpg', 'alt' => 'Copertina Una collezione di Medaglie - Autunno 2006'], 'title' => 'Una collezione di Medaglie - Autunno 2006, Roma', 'paragraphs' => ['Catalogo in collaborazione con A&B. Tra le medaglie spiccava una importante collezione della Sede Vacante e la medaglia italiana in oro a ricordo del bimillenario della morte di Virgilio, unico esemplare conosciuto.']],
            ['type' => 'split_item', 'image' => ['file' => '2008s.jpg', 'alt' => 'Copertina CLAVDIA 2008'], 'title' => 'CLAVDIA 2008, Roma 2008', 'paragraphs' => ['Un catalogo nella tradizione Moruzzi, molto richiesto in tutto il mondo anche solo per il piacere di leggerlo. Presentate due importanti collezioni: coniazioni di Nerone e monete in bronzo del Mondo Greco.']],
            ['type' => 'split_item', 'image' => ['file' => 'il-vero-e-il-falso_2.jpg', 'alt' => 'Copertina IL VERO e IL FALSO, Milano 2013'], 'title' => 'IL VERO e IL FALSO, La Guardia di Finanza in Lombardia, Milano 2013', 'paragraphs' => ['Catalogo della mostra itinerante curata da Umberto Moruzzi in collaborazione con la GDF. «Gli uomini spesso producono denaro falso, ma molto più spesso il denaro produce uomini falsi» (J. Harris). Monete autentiche esposte accanto ai loro falsi, quasi perfetti.']],
        ],
    ],

    'press' => [
        'title' => 'Dicono di noi',
        'blocks' => [
            [
                'type' => 'split_item',
                'image' => ['file' => 'lire500000.jpg', 'alt' => 'Banconota da 500000 lire tipo Raffaello'],
                'title' => 'In giro ancora 2550 miliardi di lire',
                'meta' => 'Il Messaggero — 14 luglio 2010, Roma',
                'paragraphs' => [
                    '... <strong>Umberto Moruzzi</strong>, studioso di cartamoneta e titolare di uno dei più avviati negozi di numismatica in Italia, a Roma, in zona Cinecittà, racconta di un «diffuso e crescente interesse, spesso amatoriale, nella collezione di vecchie lire, soprattutto di epoca repubblicana». Una vera e propria «lira-mania», dove la nostalgia per una valuta che non tornerà mai più si unisce alla capacità di banconote e monete di evocare momenti piccoli e grandi della biografia di ognuno di noi. — ROBERTO FABEN',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'lire-500-medusas.jpg', 'alt' => 'Banconota da 500 lire della Banca d\'Italia'],
                'title' => 'Rarità e biglietti integri meritano una perizia',
                'meta' => 'Il Sole 24 Ore — 21 settembre 2009',
                'paragraphs' => [
                    '«Con il pensionamento della vecchia lira, è nato un esercito di nuovi collezionisti...» Così spiega il «filone lira» Umberto Moruzzi, perito numismatico e titolare, con la sorella Loredana, del negozio Moruzzi Numismatica a Cinecittà. «Banconote e monete in lire possono essere un investimento...» Chi avesse in casa qualche vecchia banconota può farla valutare da un negozio di numismatica: in Italia sono circa 350, ma gli aderenti all\'associazione NIP offrono maggiori garanzie. Fra i biglietti più recenti si segnala la banconota da 500 lire «Barbetti» con contrassegno «Medusa» del 14 novembre 1950: in buone condizioni vale circa 20.000 euro. — ROBERTO FABEN',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'lamoneta_1.jpg', 'alt' => 'Forum di numismatica Lamoneta'],
                'title' => 'Le porte del tempio di Giano — Significato sulle monete',
                'meta' => 'Lamoneta.it — 26 novembre 2008',
                'paragraphs' => [
                    'Cercando testi sull\'origine del significato della legenda <em>CLAVSO IANI TEMPLO GAVDIVM SECVLI</em> mi sono imbattuto in un bel lavoro di Francesca Barenghi, collaboratrice di Moruzzi. Lavoro che riporto integralmente e che ritengo utilissimo allo scopo.',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'premio_moruzzi_numismatica.jpg', 'alt' => 'Premio Ben Hur - Cinecittà 2006'],
                'title' => 'Premio Ben Hur — Cinecittà 2006',
                'meta' => 'Comune di Roma X Municipio — 21 luglio 2006',
                'paragraphs' => [
                    'In una festa sono stati consegnati i premi agli esercenti romani del piccolo commercio che si sono distinti per la loro longevità nel municipio. Il premio Ben Hur è stato assegnato anche alla Moruzzi Numismatica, azienda con 26 anni di attività alle spalle, tra le più antiche di Roma nel settore. Merito della Moruzzi Numismatica è l\'indiscussa professionalità che le ha permesso di essere ancor oggi sul mercato e di aver portato negli anni a Roma una moltitudine di collezionisti-turisti.',
                ],
            ],
            [
                'type' => 'split_item',
                'image' => ['file' => 'vetrina.jpg', 'alt' => 'Vetrina della Moruzzi Numismatica di Roma'],
                'title' => 'Il cielo più grande del mondo sopra i palazzoni di Cinecittà',
                'meta' => 'La Repubblica — 27 febbraio 2002, Roma',
                'paragraphs' => [
                    '... Sotto i portici della piazza, davanti alle vetrine di un negozio di numismatica, mi soffermo a leggere i nomi delle monete esposte... Se c\'è un negozio simile, possiamo figurarci un collezionista felice... possiamo affermare che c\'è vita a Cinecittà, anzi, c\'è addirittura vita sulla Terra. — FULVIO ABBATE',
                ],
            ],
        ],
    ],

    'memberships' => [
        'title' => 'Memberships',
        'lead' => 'La Moruzzi Numismatica, i suoi soci ed i suoi collaboratori sono iscritti a diverse associazioni di notevole rilievo.',
        'blocks' => [
            ['type' => 'split_item', 'title' => 'IAPN-AINP', 'image' => ['file' => 'IAPN01.jpg', 'alt' => 'IAPN AINP'], 'paragraphs' => ['L\'<strong>Associazione Internazionale dei Numismatici Professionisti</strong> è un sodalizio non-profit tra i più importanti al mondo, in speciale modo per il suo ruolo nella garanzia e nel coordinamento a tutela del mercato e del collezionismo etico. Fondata nel 1951 a Ginevra, oggi ne fanno parte più di 114 aziende numismatiche in ventitré paesi.']],
            ['type' => 'split_item', 'title' => 'NIP — Numismatici Italiani Professionisti', 'image' => ['file' => 'nip.png', 'alt' => 'NIP'], 'paragraphs' => ['I NIP si prefiggono di promuovere un mercato numismatico animato dai migliori principi di etica professionale e commerciale; incoraggiano lo studio scientifico e la diffusione della numismatica e combattono le falsificazioni.']],
            ['type' => 'split_item', 'title' => 'Berufsverband des Deutschen Münzenfachhandels e.V.', 'image' => ['file' => 'Berufsverband-des-Deutschen-Muenzenfachhandels-e.V.png', 'alt' => 'Berufsverband'], 'paragraphs' => ['Importante associazione professionale tedesca di numismatici di cui la Moruzzi Numismatica fa parte dal 2012. Gli iscritti garantiscono l\'autenticità di monete, medaglie e banconote in vendita.']],
            ['type' => 'split_item', 'title' => 'FENAP', 'image' => ['file' => 'fenap.png', 'alt' => 'FENAP'], 'paragraphs' => ['La <strong>Federazione Europea delle Associazioni Numismatiche Professionali</strong> svolge attività di coordinamento tra le associazioni nazionali europee dei numismatici professionisti ed è referente con le istituzioni comunitarie.']],
            ['type' => 'split_item', 'title' => 'Società Numismatica Italiana', 'image' => ['file' => 'societa_numismatica_1.png', 'alt' => 'Società Numismatica Italiana'], 'paragraphs' => ['Associazione culturale fondata nel 1892 che ha accolto tra i suoi soci i maggiori studiosi e collezionisti italiani dell\'epoca.']],
            ['type' => 'split_item', 'title' => 'N.I.A.', 'image' => ['file' => 'nia.png', 'alt' => 'NIA'], 'paragraphs' => ['I <strong>Numismatici Italiani Associati</strong> riuniscono numismatici professionisti, collezionisti, studiosi e periti con il comune interesse di promuovere la numismatica in tutti i suoi aspetti.']],
            ['type' => 'split_item', 'title' => 'CINOA', 'image' => ['file' => 'cinoa.png', 'alt' => 'CINOA'], 'paragraphs' => ['Federazione internazionale di associazioni senza scopo di lucro che rappresenta più di 5.000 rivenditori di antiquariato e arte in 22 paesi. L\'adesione impegna i membri a rispettare alti standard di qualità e competenza.']],
            ['type' => 'split_item', 'title' => 'A.F.I.P.', 'image' => ['file' => 'afip.png', 'alt' => 'AFIP'], 'paragraphs' => ['L\'<strong>Associazione Filatelisti Italiani Professionisti</strong> raccoglie la maggioranza delle professionalità del settore, garantendo ai collezionisti regole di lavoro e uno statuto rigoroso.']],
            ['type' => 'split_item', 'title' => 'IFISDA', 'image' => ['file' => 'ifisda_1.png', 'alt' => 'IFISDA'], 'paragraphs' => ['L\'<strong>International Federation Of Stamp Dealers Associations</strong> raccorda le associazioni nazionali dei commercianti filatelici.']],
            ['type' => 'split_item', 'title' => 'Royal Numismatic Society', 'image' => ['file' => 'royal_numismatic_society_2fp0zp4l.png', 'alt' => 'Royal Numismatic Society'], 'paragraphs' => ['Associazione britannica fondata nel 1836 per gli studi numismatici su monete, medaglie e elementi associati alla moneta, con interesse e soci internazionali.']],
            ['type' => 'split_item', 'title' => 'Confesercenti', 'image' => ['file' => 'confesercenti.png', 'alt' => 'Confesercenti'], 'paragraphs' => ['Fondata a Roma nel 1971, è una delle principali associazioni delle imprese in Italia. Rappresenta commercio, turismo, servizi, artigianato e PMI, con oltre 350.000 imprese associate.']],
        ],
    ],
];

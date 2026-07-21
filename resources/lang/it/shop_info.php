<?php

return [
    'sidebar_title' => 'Informazioni',

    'open_full_page' => 'Apri a pagina intera',

    'links' => [
        'terms' => 'Condizioni di vendita',
        'attestati' => "L'attestato di garanzia e provenienza",
        'abbreviations' => 'Le abbreviazioni',
        'guarantee' => 'La garanzia Moruzzi Numismatica',
        'collecting' => 'Collezionare monete antiche in Italia',
    ],

    'terms' => [
        'title' => 'Le condizioni di vendita per gli acquisti online',
        'lead' => 'Leggi le condizioni di vendita della Moruzzi Numismatica di Roma.',
        'blocks' => [
            [
                'type' => 'list',
                'items' => [
                    'La registrazione e l\'invio del modulo d\'ordine implica la conoscenza e l\'accettazione delle seguenti Condizioni di Vendita.',
                    'Nel modulo di registrazione è assolutamente vietato inserire dati falsi.',
                    'Il cliente, compilando la scheda anagrafica necessaria per il compimento del presente contratto, autorizza la Moruzzi Numismatica a comunicare i dati anagrafici non sensibili (nome, cognome, residenza e recapito telefonico) ai corrieri per la consegna dei beni acquistati, in modo da permettere le procedure necessarie al loro recapito.',
                    'I dati personali saranno trattati nel rispetto della legge sulla privacy. Se la Moruzzi Numismatica riterrà necessario, il cliente si impegna a fornire copia dei documenti di identità. La mancata osservanza della predetta richiesta autorizza la Moruzzi Numismatica a risolvere il contratto per inadempimento.',
                    'Tutti gli oggetti presentati in questo sito sono garantiti autentici senza limiti di tempo.',
                    'Le descrizioni degli oggetti proposti, lo stato di conservazione e le rarità sono indicate con la massima cura possibile.',
                    'In riguardo ai punti precedenti, qualsiasi reclamo sarà preso in considerazione solo se presentato entro 10 giorni dalla data della vendita e in base al parere di un perito qualificato.',
                    'I prezzi si intendono comprensivi di I.V.A. Nella maggioranza degli oggetti proposti, in particolare quelli con codice numerico di cinque cifre, l\'I.V.A. è assolta nel regime del margine ai sensi del D.L. 41/1995 art. 38 comma 1, primo periodo; quindi in questo caso la fattura non costituisce un titolo per la rivalsa né per la detrazione dell\'imposta, anche se chi acquista lo fa nell\'esercizio d\'impresa.',
                    'L\'ordine d\'acquisto è da considerarsi valido anche in mancanza di uno o più oggetti richiesti e sarà evaso con il materiale disponibile.',
                    'Le eventuali spese doganali sono a carico degli acquirenti.',
                    'La merce viaggia a rischio e pericolo del committente. Gli invii verranno effettuati secondo la modalità prescelta.',
                    'Le spese di spedizione sono variabili in relazione alla modalità prescelta e al peso degli oggetti acquistati. L\'assicurazione è selezionabile unitamente al sistema di spedizione. In ogni caso le spese di spedizione e assicurazione sono evidenziate nel modulo informatico dell\'ordine. Nel caso di richiesta di consegna presso i nostri uffici nulla sarà dovuto.',
                    'Nel caso sia selezionata la consegna e il pagamento presso i nostri uffici sarà possibile pagare in contanti (fino ai limiti di legge), con Bancomat o con carte di credito senza alcun aggravo di costi, né per il pagamento né per la consegna.',
                    'Diritto di recesso (ai sensi del D.Lgs. 6 settembre 2005, n. 206). Il cliente che non si ritenesse soddisfatto dell\'acquisto effettuato ha diritto di recedere dal contratto stipulato entro il termine di 10 giorni lavorativi che decorre dal giorno della ricezione dei beni. Tale diritto è riservato ai soli consumatori finali, non a rivenditori e/o comunque titolari di partita IVA. Il consumatore potrà esercitare questo diritto inviando comunicazione scritta per mezzo di e-mail o fax. Qualunque comunicazione dovrà essere seguita entro 48 ore, pena la decadenza, da una lettera raccomandata con ricevuta di ritorno. Tutti i costi di restituzione degli oggetti sono espressamente a carico del consumatore, che provvederà all\'invio tramite proprio spedizioniere. Anche i rischi di tale trasporto sono integralmente a carico dell\'acquirente. Tutti gli articoli oggetto di tale diritto di recesso dovranno pervenire nelle medesime condizioni di ricezione e nelle confezioni originali; in caso contrario il recesso decade. Soddisfatte queste condizioni la Moruzzi Numismatica provvederà ad accreditare l\'importo versato dal consumatore entro i termini di legge previsti, 30 giorni dalla data in cui il consumatore ha comunicato la sua volontà di recedere dal contratto. La Moruzzi Numismatica verserà la somma mediante bonifico bancario; il cliente dovrà comunicare le proprie coordinate bancarie (codice IBAN, ABI, CAB, conto corrente). Per ricevere il rimborso il conto bancario comunicato dovrà essere intestato all\'intestatario della fattura.',
                    'Per ogni operazione verrà emessa regolare fattura; i clienti italiani dovranno comunicare il codice fiscale, le aziende se italiane o comunitarie anche la partita IVA.',
                    'Per ogni controversia, il foro competente è quello di Roma.',
                ],
            ],
        ],
    ],

    'abbreviations' => [
        'title' => 'Le abbreviazioni in uso per le monete pubblicate',
        'lead' => 'Riferimento rapido per rarità, sigle tecniche, leghe metalliche e gradi di conservazione usati nelle schede prodotto.',
        'blocks' => [
            [
                'type' => 'tables',
                'tables' => [
                    [
                        'title' => 'Le rarità',
                        'headers' => ['Sigla', 'Italiano', 'English'],
                        'rows' => [
                            ['<em>nessun simbolo</em>', 'Comune', 'Common'],
                            ['NC', 'Non comune', 'Not common'],
                            ['R', 'Rara', 'Rare'],
                            ['RR', 'Molto rara', 'Very rare'],
                            ['RRR', 'Rarissima', 'Particularly rare'],
                            ['RRRR', 'Estremamente rara', 'Extremely rare'],
                            ['RRRRR', 'Solo alcuni esemplari conosciuti', 'Of the greatest rarity'],
                        ],
                    ],
                    [
                        'title' => 'Abbreviazioni generali',
                        'headers' => ['Sigla', 'Italiano', 'English'],
                        'rows' => [
                            ['a.C.', 'avanti Cristo', 'BC'],
                            ['D/', 'dritto', 'Obverse'],
                            ['d.', 'destra', 'Right'],
                            ['d.C.', 'dopo Cristo', 'AD'],
                            ['Diam.', 'diametro', 'Diameter'],
                            ['gr.', 'grammi', 'Grams'],
                            ['m', 'migliore di', 'Better than'],
                            ['mm', 'millimetri', 'Millimetres'],
                            ['q', 'quasi', 'Near'],
                            ['R/', 'rovescio', 'Reverse'],
                            ['Rif. bibl.', 'riferimenti bibliografici', 'References'],
                            ['s.', 'sinistra', 'Left'],
                        ],
                    ],
                    [
                        'title' => 'Leghe e metalli',
                        'headers' => ['Sigla', 'Italiano', 'English'],
                        'rows' => [
                            ['AA', 'Acciaio', 'Steel'],
                            ['AC', 'Acmonital', 'Acmonital'],
                            ['AE', 'Bronzo', 'Bronze'],
                            ['AG', 'Argento', 'Silver'],
                            ['AL', 'Alluminio', 'Aluminium'],
                            ['AR', 'Argento', 'Silver'],
                            ['AU', 'Oro', 'Gold'],
                            ['AV', 'Oro', 'Gold'],
                            ['BA', 'Bronzital', 'Bronzital'],
                            ['CN', 'Cupronichel', 'Copper nickel'],
                            ['CU', 'Rame', 'Copper'],
                            ['IT', 'Italma', 'Italma'],
                            ['MI', 'Mistura', 'Mixture'],
                            ['NI', 'Nichelio', 'Nickel'],
                            ['PB', 'Piombo', 'Lead'],
                            ['SN', 'Stagno', 'Tin'],
                            ['WM', 'Metallo bianco', 'White metal'],
                            ['ZN', 'Zinco', 'Zinc'],
                        ],
                    ],
                    [
                        'title' => 'Stato di conservazione delle monete',
                        'headers' => ['Sigla', 'Italiano', 'English', 'Français', 'Deutsch', 'Español'],
                        'rows' => [
                            ['FS', 'Fondo specchio', 'Proof', 'Flan Bruni', 'Polierte Platte', 'Proof'],
                            ['FDC', 'Fior di conio', 'Uncirculated', 'Fleur de Coin', 'Stempelglanz', 'Flor de Cuño'],
                            ['SPL', 'Splendida', 'Extremely Fine', 'Superbe', 'Vorzüglich', 'Extraord. bien conservada'],
                            ['BB', 'Bellissima', 'Very Fine', 'Très Très Beau', 'Sehr Schön', 'Muy bien conservada'],
                            ['MB', 'Molto bella', 'Fine', 'Très Beau', 'Schön', 'Bien conservada'],
                            ['B', 'Bella', 'Very Good', 'Très Bien Conservé', 'Sehr Gut Erhalten', 'Regular conservada'],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'collecting' => [
        'title' => 'Collezionare monete antiche in Italia',
        'lead' => 'Note sul testo unico sui beni culturali in relazione alle monete da collezione, con alcune precauzioni utili.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Il collezionismo di monete antiche è legale ed è riconosciuto dal Codice dei Beni Culturali del 22 gennaio 2004 e successive modificazioni. Il D.Lgs. 42/2004 ha specificato l\'interesse numismatico e ha sancito che le monete possono liberamente formare oggetto di collezioni private e che solo alcune di esse, o alcune collezioni, devono essere considerate beni culturali e dunque assoggettate a tutela dalla legge.',
                    'Questa distinzione vale per le monete di ogni epoca storica: le monete antiche, greche, romane, medievali o rinascimentali non sono per loro stessa natura beni culturali sottoposti alla tutela di questa legge e sottratte al libero collezionismo privato. La tutela è sancita in casi ben determinati (art. 10 comma 4 lettera b con riferimento al comma 1; art. 91; art. 10 comma 3 lettera a con riferimento al comma 4).',
                    'Raccogliere monete antiche è uno splendido modo di approfondire la storia, arricchendo la propria cultura personale. Attraverso lo studio delle monete è possibile accrescere la cultura dell\'individuo e, di conseguenza, la cultura nazionale. Il Codice considera correttamente tra i beni culturali quelle collezioni numismatiche per le quali sia già intervenuta la dichiarazione prevista dall\'art. 13 e tale dichiarazione può intervenire esclusivamente per le collezioni che presentano interesse artistico, storico e archeologico particolarmente importante (art. 10 capo 1 comma 3a).',
                    'Le collezioni numismatiche, vale a dire le monete al di fuori del contesto archeologico, sono prese in considerazione, ai fini della tutela, dal Codice (ai sensi dell\'art. 10 capo 1 comma 4b) soltanto se di eccezionale interesse artistico, storico e numismatico. Il legislatore ha definitivamente identificato l\'interesse numismatico precisando che l\'eccezionale interesse artistico, storico e numismatico per una moneta è in rapporto all\'epoca, alle tecniche e ai materiali di produzione, nonché al contesto di riferimento, e che tali oggetti abbiano carattere di rarità o di pregio, anche storico.',
                    'Tra l\'altro, non è considerabile bene culturale (e dunque non disciplinato da questa legge) una collezione numismatica che abbia un valore commerciale inferiore a € 46.598,00 (Allegato A, comma 13b e allegato B comma 4).',
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Monete da collezione e precauzioni',
                'paragraphs' => [
                    'Nell\'organizzare una raccolta di monete antiche è bene usare delle precauzioni. In caso di controlli, spetta alla magistratura e alle forze dell\'ordine provare l\'esistenza di un eventuale illecito, ma è bene che chi è in buona fede organizzi per la propria collezione un piccolo archivio che permetta di risalire alla provenienza dei vari esemplari.',
                    'Oggi molti software, anche semplici e non costosi, permettono di farlo in modo informatico. Questo, tra l\'altro, permetterà in futuro di ricordare momenti felici, regali ricevuti e viaggi interessanti legati agli acquisti di monete.',
                    'Negli acquisti da privati è bene accertarsi della legittima provenienza del bene e farsi firmare una dichiarazione di ricevuta. Se si compra all\'estero fuori dall\'UE è bene conservare la ricevuta o la fattura dell\'acquisto e il bollettino doganale che attesti il pagamento della tassa sull\'importazione.',
                    'Se si compra all\'interno dell\'UE da un professionista numismatico o da una casa d\'aste è bene conservare la relativa fattura o ricevuta di acquisto con, se possibile, riferimenti univoci all\'esemplare.',
                    'Organizzare una raccolta fotografica della propria collezione apre nuovi interessi agli aspetti artistici delle monete raccolte; le foto sono un importante contributo all\'identificazione delle monete per qualsiasi futura attività, dalla pubblicazione della raccolta alla verifica delle provenienze e, in caso di furto, alla segnalazione alle autorità competenti.',
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    '<strong>Per chi vuole saperne di più sul nuovo Codice dei Beni Culturali</strong>, la Moruzzi Numismatica mette a disposizione approfondimenti e consulenza. In caso di dubbi sulla provenienza o sulla documentazione di un esemplare, il nostro staff è a disposizione.',
                ],
            ],
        ],
    ],
];

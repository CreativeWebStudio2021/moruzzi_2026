<?php

$certNote = 'È possibile richiedere, al costo di € 8,00, la certificazione comprendente il cartellino con QR code, il certificato fotografico e online per tutte le monete, medaglie o banconote acquistate presso la Moruzzi Numismatica a partire dal 2009, che non dispongono ancora di questa documentazione.';

return [
    'common' => [
        'appointment_title' => 'Appuntamento consigliato',
        'appointment_text' => 'Prima di venire in negozio, contattaci al +39 06 7151 0220 per fissare un appuntamento.',
        'pricing_note' => 'Gli onorari sono comprensivi di imposta e oneri.',
        'perizia_detail' => 'Include apposizione di sigilli sulla bustina e sul cartellino descrittivo, certificazione fotografica e QR code per la consultazione digitale.',
    ],

    'online' => [
        'title' => 'Certificato online',
        'lead' => 'Il certificato online Moruzzi Numismatica, collegato al QR code presente sul cartellino, consente di verificare con un clic descrizione, immagini e provenienza delle monete acquistate.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Le monete della Moruzzi Numismatica hanno un ulteriore valore aggiunto conferito dall’insieme degli elementi racchiusi nel cartellino codificato che le accompagna. Questo documento svolge la funzione di descrivere l’esemplare, di attestarne la qualità, di garantirne l’autenticità e la lecita provenienza.',
                    'Il prezzo indicato è il risultato di una corretta elaborazione della corrispondenza tra il grado di rarità, lo stato di conservazione e le altre variabili della moneta.',
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Verifica con il tuo smartphone',
                'paragraphs' => [
                    'A maggior tutela della nostra clientela abbiamo inserito nel cartellino e nel certificato anche il QR code. Con un lettore scaricabile gratuitamente su tutti gli smartphone, oppure tramite il link esclusivo riportato sul certificato cartaceo, è possibile consultare online la descrizione completa, i riferimenti di provenienza e le foto del dritto e del rovescio.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                   ['file' => 'certificato_qr01.jpg', 'alt' => 'Dettaglio QR code sul certificato', 'caption' => 'Consultazione digitale immediata'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'La Moruzzi Numismatica è la prima azienda numismatica al mondo a garantire le proprie monete <strong>senza doverle sigillare</strong> nella plastica rigida (slab), come accade negli Stati Uniti. I collezionisti italiani ed europei possono così mantenere un contatto diretto con le monete della propria collezione.',
                    'Il certificato online permette di verificare, anche grazie alle foto ad alta qualità, l’origine e la bontà delle monete provenienti dalla nostra ditta: un passo avanti nella trasparenza e nella sicurezza degli acquisti. La certificazione non è falsificabile perché garantita da una pagina web dedicata e non modificabile.',
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Nota bene',
                'paragraphs' => [
                    'Per tua cautela, al fine di evitare truffe o raggiri, assicurati che il link riportato sul certificato fotografico inizi sempre da <strong>https://www.moruzzi.it/</strong>.',
                    'Il certificato cartaceo, rilasciato e spedito anche per gli acquisti online, presenta il QR code per la verifica tramite smartphone o tramite l’indirizzo internet indicato sul documento.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-QR01.jpg', 'alt' => 'Legenda elementi del cartellino con QR code'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'quality' => [
        'title' => 'Certificazione di qualità Moruzzi',
        'lead' => 'La certificazione di qualità Moruzzi riassume in modo chiaro stato di conservazione, rarità, metallo e provenienza, offrendo al collezionista un importante valore aggiunto.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Le monete della Moruzzi Numismatica hanno un valore aggiunto anche per l’insieme degli elementi racchiusi nel cartellino che le accompagna. Il cartellino svolge la duplice funzione di descrivere l’esemplare e di garantirne l’originalità; il prezzo indicato è il risultato di una corretta corrispondenza tra stato di conservazione, grado di rarità e altre variabili.',
                    'Oggi il cartellino include anche un <strong>QR code</strong>, senza nulla perdere rispetto a quello classico: con un lettore presente in applicativi gratuiti per iPhone, iPad, iPod e smartphone Android è possibile leggere il certificato descrittivo completo di provenienza e foto del dritto e del rovesco.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-cartellino.jpg', 'alt' => 'Legenda del cartellino Moruzzi Numismatica', 'caption' => 'Il cartellino classico, ancora valido'],
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'legenda-QR01_p23l4f70.jpg', 'alt' => 'Cartellino con QR code', 'caption' => 'La nuova certificazione digitale'],
                ],
            ],
            [
                'type' => 'features',
                'title' => 'Cosa contiene il cartellino',
                'items' => [
                    ['title' => 'Descrizione completa', 'text' => 'Autorità emittente, periodo storico, tipo di moneta, anno e zecca quando noti, leggende o descrizioni di dritto e rovescio.'],
                    ['title' => 'Bibliografia e rarità', 'text' => 'Fino a tre pubblicazioni di riferimento con numeri identificativi e, spesso, il grado di rarità indicato dagli autori.'],
                    ['title' => 'Provenienza e trasparenza', 'text' => 'Indicazione del pedigree quando pubblico (aste prestigiose, collezioni note) e codice alfanumerico per verificarne sempre la provenienza.'],
                    ['title' => 'Metallo, peso e prezzo', 'text' => 'Metallo, peso al centesimo di grammo, scala di rarità da 1 a 5 R e stato di conservazione chiaramente evidenziato insieme al prezzo.'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Garanzia senza scadenza',
                'paragraphs' => [
                    'Ai sensi dell’art. 64 del D.Lgs. 42/2004 (Codice dei beni culturali), il cartellino è garanzia di assoluta autenticità e di tutto ciò che vi è indicato. La Garanzia Moruzzi Numismatica sull’originalità delle monete vendute <strong>non scade mai</strong> e vale anche per la corretta catalogazione e l’esatta indicazione dello stato di conservazione.',
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'guarantee' => [
        'title' => 'Garanzia Moruzzi Numismatica',
        'lead' => 'La Garanzia Moruzzi Numismatica è a tempo indeterminato: tutela autenticità, corretta catalogazione e stato di conservazione di ogni esemplare venduto.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Il primo indice di serietà della nostra ditta è la fiducia che i nostri clienti ci riconoscono da oltre trent’anni. Nonostante ciò offriamo una garanzia formale sugli oggetti numismatici che mettiamo in vendita: la <strong>Garanzia Moruzzi Numismatica</strong>.',
                    'La legge prevede, come recita l’art. 64 del D.Lgs. 42/2004, di consegnare all’acquirente un certificato di garanzia e provenienza. La Moruzzi Numismatica va oltre: assicura alle monete e alle banconote da collezione vendute una garanzia illimitata nel tempo sia sull’autenticità sia su tutte le caratteristiche indicate nel cartellino.',
                ],
            ],
            [
                'type' => 'images',
                'items' => [
                    ['file' => 'riempitivo_garanzia.jpg', 'alt' => 'Garanzia Moruzzi Numismatica', 'caption' => 'Garanzia a tempo indeterminato'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Cosa copre la garanzia',
                'paragraphs' => [
                    'La garanzia sull’originalità delle monete vendute non scade mai e vale non solo per l’autenticità del bene, ma anche per la corretta catalogazione e soprattutto per l’esatta indicazione dello stato di conservazione.',
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'Chiunque esercita l’attività di vendita al pubblico di opere d’arte, oggetti d’antichità o di interesse storico od archeologico ha l’obbligo di consegnare all’acquirente la documentazione attestante l’autenticità o almeno la probabile attribuzione e la provenienza; in mancanza, deve rilasciare una dichiarazione con tutte le informazioni disponibili, preferibilmente apposta su copia fotografica dell’oggetto.',
                ],
            ],
        ],
    ],

    'attestati' => [
        'title' => 'Attestati di garanzia e provenienza',
        'lead' => 'Gli attestati di garanzia e provenienza accompagnano le monete antiche con documentazione completa, immagini e riferimenti ai registri di carico.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Le monete antiche vendute dalla Moruzzi Numismatica sono accompagnate da questo importante documento. Si tratta di una certificazione che recepisce ampiamente gli obblighi di legge e risponde alle esigenze del collezionista moderno, che desidera conservare insieme alle monete una documentazione il più completa possibile.',
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'cetificati_mn1.jpg', 'alt' => 'Attestato di garanzia e provenienza Moruzzi', 'caption' => 'Certificato di garanzia e provenienza'],
                ],
            ],
            [
                'type' => 'images',
                'layout' => 'full',
                'items' => [
                    ['file' => 'certificato_qr01_b4ubt21n.jpg', 'alt' => 'Attestato con QR code', 'caption' => 'Verifica online tramite QR code'],
                ],
            ],
            [
                'type' => 'features',
                'title' => 'Contenuti dell’attestato',
                'items' => [
                    ['title' => 'Descrizione e bibliografia', 'text' => 'Descrizione completa della moneta con riferimenti bibliografici e foto del dritto e del rovesco.'],
                    ['title' => 'Codice univoco', 'text' => 'Codice identificativo, rarità, peso e stato di conservazione per una consultazione rapida e trasparente.'],
                    ['title' => 'Provenienza legale', 'text' => 'Garanzia di originalità e lecita provenienza con numerazioni dei registri dove l’esemplare è iscritto.'],
                    ['title' => 'Verifica digitale', 'text' => 'QR code per consultare il certificato online da smartphone o tramite codice web dedicato.'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [$certNote],
            ],
        ],
    ],

    'standard' => [
        'title' => 'Standard qualitativo',
        'lead' => 'Ogni proposta Moruzzi Numismatica rispetta elevati standard di conservazione, estetica e tecnica, illustrati anche tramite istogrammi dedicati ai diversi parametri.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Le nostre monete, medaglie e banconote sono selezionate in relazione ad elevati standard di conservazione, di estetica e tecnica. Alcune delle proposte più interessanti sono accompagnate nelle schede dell’e-commerce da istogrammi, oltre che dalla descrizione che accompagna tutte le nostre proposte.',
                ],
            ],
            [
                'type' => 'images',
                'items' => [
                    ['file' => 'augusto_denario01.jpg', 'alt' => 'Denario di Augusto', 'caption' => 'Esempio di moneta di elevata qualità'],
                    ['file' => '141943a.jpg', 'alt' => 'Dettaglio conservazione moneta antica'],
                ],
            ],
            [
                'type' => 'meters',
                'title' => 'I sei parametri di valutazione',
                'items' => [
                    ['label' => 'Conservazione', 'value' => '82%', 'hint' => 'Scala europea / Sheldon', 'text' => 'Dalla D (discreto) al FDC (fior di conio), espressa anche in settantesimi per i collezionisti americani e asiatici.'],
                    ['label' => 'Rarità', 'value' => '68%', 'hint' => 'Da C a RRRRRR', 'text' => 'Percentuale da valori bassi per monete comuni fino al 100% per esemplari unici o quasi unici.'],
                    ['label' => 'Metallo e patina', 'value' => '74%', 'hint' => 'Qualità della lega', 'text' => 'Valutazione di danni da coniazione, usura nel tempo e pulizie improprie; la patina di qualità è un valore aggiunto.'],
                    ['label' => 'Stile', 'value' => '88%', 'hint' => 'Finezza artistica', 'text' => 'Lo stile dei conii può essere più importante della conservazione nelle produzioni numismatiche più artistiche.'],
                    ['label' => 'Coniazione', 'value' => '76%', 'hint' => 'Qualità produttiva', 'text' => 'Esame di fratture, scivolamenti di conio e qualità della battuta che evidenzia i rilievi.'],
                    ['label' => 'Provenienza', 'value' => '62%', 'hint' => 'Pedigree', 'text' => 'Aste, negozi e collezioni prestigiose aumentano la percentuale rispetto a provenienze tracciate solo di recente.'],
                ],
            ],
            [
                'type' => 'text',
                'paragraphs' => [
                    'Gli oggetti che non rispondono a queste caratteristiche di pregio vengono proposti a condizioni particolarmente vantaggiose. Ogni moneta proposta dalla Moruzzi Numismatica ha una provenienza assolutamente legale e riportata nei registri delle autorità competenti.',
                ],
            ],
        ],
    ],

    'upgrade' => [
        'title' => 'Upgrade della qualità',
        'lead' => 'Il servizio di upgrade della qualità permette di sostituire esemplari già acquistati con altri di grado superiore, versando solo la differenza di prezzo.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Ogni collezionista, all’inizio della propria raccolta, spesso si accontenta di esemplari non particolarmente costosi né ben conservati. Col passare del tempo il gusto si affina e le prime monete acquistate possono non soddisfare più. Per questo esiste la promozione upgrade della Moruzzi Numismatica.',
                    'Non tutti possono permettersi subito la qualità top: per “chiudere un buco” della raccolta ci si può accontentare di un esemplare meno bello, con la possibilità di sostituirlo in seguito con uno di grado superiore.',
                ],
            ],
            [
                'type' => 'upgrade_flow',
                'steps' => [
                    ['file' => 'promozionea.jpg', 'alt' => 'Esemplare di qualità inferiore', 'caption' => 'Esemplare già in collezione'],
                    ['file' => 'promozione.jpg', 'alt' => 'Esemplare di qualità superiore', 'caption' => 'Upgrade disponibile in negozio'],
                ],
            ],
            [
                'type' => 'callout',
                'title' => 'Come funziona',
                'paragraphs' => [
                    'A chi ha effettuato almeno <strong>tre acquisti negli ultimi due anni</strong> è riconosciuta la possibilità di sostituire le monete acquistate dalla Moruzzi Numismatica con esemplari migliori, versando solo la differenza di prezzo; l’esemplare restituito viene valutato al prezzo pagato.',
                    'Esempio: per migliorare una 10 lire del 1927 in BB acquistata a € 30,00 con una SPL da € 100,00 basta versare € 70,00. La promozione vale per monete (antiche, moderne e contemporanee) e banconote, solo se gli esemplari sostitutivi sono disponibili e le monete restituite hanno il cartellino Moruzzi.',
                ],
            ],
        ],
    ],

    'estimates_coins' => [
        'title' => 'Stime e perizie di monete',
        'appointment' => true,
        'lead' => 'Umberto Moruzzi offre stime e perizie di monete antiche e moderne, con registrazione completa dei dati e immagini ad alta risoluzione.',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => [
                    'file' => 'stime-e-perizie-di-monete.jpg',
                    'alt' => 'Stime e perizie di monete Moruzzi Numismatica',
                ],
                'paragraphs' => [
                    'Per stime e perizie di monete antiche, moderne e medaglie puoi rivolgerti al nostro ufficio di Roma, allo studioso numismatico <strong>Umberto Moruzzi</strong>, perito della Camera di Commercio e del Tribunale di Roma.',
                    'I servizi peritali prevedono, in ogni caso, la completa registrazione degli elementi identificativi degli esemplari esaminati e la conservazione delle immagini ad alta risoluzione, così da verificarne nel tempo la corrispondenza con certificazioni e catalogazioni rilasciate.',
                    'Con la stessa cura si eseguono stime di singoli esemplari e di intere collezioni di monete da collezione.',
                ],
            ],
            [
                'type' => 'links',
                'title' => 'Servizi correlati',
                'items' => [
                    ['route' => 'certifications.expertise_coins', 'label' => 'Perizie di monete'],
                    ['route' => 'certifications.estimates_banknotes', 'label' => 'Stime e perizie di banconote'],
                    ['route' => 'certifications.cataloguing', 'label' => 'Catalogazioni'],
                    ['route' => 'certifications.valuation', 'label' => 'Valutazione di monete e banconote'],
                ],
            ],
        ],
    ],

    'estimates_banknotes' => [
        'title' => 'Stime e perizie di banconote',
        'appointment' => true,
        'lead' => 'Servizio di stima e perizia per banconote italiane e mondiali, con attenzione alla corretta catalogazione e conservazione delle immagini di riferimento.',
        'blocks' => [
            [
                'type' => 'media_text',
                'image' => [
                    'file' => 'stime-e-perizie-di-banconote.jpg',
                    'alt' => 'Stime e perizie di banconote',
                ],
                'paragraphs' => [
                    'Per perizie di banconote puoi rivolgerti al nostro ufficio di Roma: <strong>Umberto Moruzzi</strong>, perito della Camera di Commercio e del Tribunale di Roma, redige certificazioni di banconote e catalogazioni.',
                    'Ogni servizio include la registrazione completa degli elementi identificativi e la conservazione delle immagini ad alta risoluzione, per verificare nel tempo la corrispondenza tra esemplare e documentazione rilasciata.',
                    'Si eseguono anche stime di singoli esemplari e di intere collezioni di banconote.',
                ],
            ],
            [
                'type' => 'links',
                'title' => 'Servizi correlati',
                'items' => [
                    ['route' => 'certifications.expertise_banknotes', 'label' => 'Perizie di banconote'],
                    ['route' => 'certifications.cataloguing', 'label' => 'Catalogazioni'],
                    ['route' => 'certifications.valuation', 'label' => 'Valutazione di monete e banconote'],
                ],
            ],
        ],
    ],

    'expertise_coins' => [
        'title' => 'Perizie di monete',
        'appointment' => true,
        'lead' => 'Perizie di monete antiche, moderne e medaglie, con apposizione di sigilli e certificato fotografico dotato di QR code per la consultazione digitale.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi, perito della Camera di Commercio e del Tribunale di Roma, esegue perizie di monete antiche, moderne e medaglie a Roma. Tutti i servizi comprendono la registrazione completa degli elementi identificativi e la conservazione delle immagini ad alta risoluzione.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tariffe perizie monete antiche',
                'note' => 'Gli onorari sono comprensivi di imposta e oneri. Include apposizione di sigilli sulla bustina e sul cartellino descrittivo, certificazione fotografica e QR code per la consultazione digitale.',
                'rows' => [
                    ['label' => 'Monete antiche di valore inferiore a € 300', 'price' => '€ 30,00'],
                    ['label' => 'Monete antiche di valore tra € 301 e € 1.000', 'price' => '€ 40,00'],
                    ['label' => 'Monete antiche di valore tra € 1.001 e € 5.000', 'price' => '€ 70,00'],
                    ['label' => 'Monete antiche di valore tra € 5.001 e € 10.000', 'price' => '€ 150,00'],
                    ['label' => 'Monete antiche di valore tra € 10.001 e € 20.000', 'price' => '€ 300,00'],
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tariffe perizie monete moderne',
                'rows' => [
                    ['label' => 'Monete moderne di valore inferiore a € 300', 'price' => '€ 20,00'],
                    ['label' => 'Monete moderne di valore tra € 301 e € 1.000', 'price' => '€ 25,00'],
                    ['label' => 'Monete moderne di valore tra € 1.001 e € 5.000', 'price' => '€ 50,00'],
                    ['label' => 'Monete moderne di valore tra € 5.001 e € 10.000', 'price' => '€ 100,00'],
                    ['label' => 'Monete moderne di valore tra € 10.001 e € 20.000', 'price' => '€ 200,00'],
                    ['label' => 'Perizia di medaglie con certificato fotografico e indicazione dell’eventuale produzione coeva', 'price' => '€ 60,00'],
                    ['label' => 'Consulenza tecnica numismatica in sede giudiziaria', 'price' => 'Su preventivo'],
                ],
            ],
        ],
    ],

    'valuation' => [
        'title' => 'Valutazione di monete e banconote',
        'appointment' => true,
        'lead' => 'Valutazioni di singoli esemplari e collezioni di monete e banconote, con indicazione del valore di acquisto e di vendita.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi, perito della Camera di Commercio e del Tribunale di Roma, esegue valutazioni di monete antiche e moderne, medaglie e banconote a Roma, con indicazione del valore di acquisto e di vendita quando richiesto.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tariffe valutazione',
                'note' => 'Gli onorari sono comprensivi di imposta e oneri.',
                'rows' => [
                    ['label' => 'Consulenza tecnica numismatica di diversa complessità per monete, medaglie e cartamoneta, anche in sede giudiziaria', 'price' => 'Su preventivo'],
                    ['label' => 'Stima di collezioni o singole monete fino a € 6.000, con valore di acquisto e di vendita', 'price' => '€ 378,00'],
                    ['label' => 'Stima di collezioni o singole monete oltre € 6.000, con valore di acquisto e di vendita', 'price' => '6,3% del valore stimato'],
                    ['label' => 'Stime a domicilio (oltre alla percentuale, trasferta da concordare)', 'price' => 'da € 180,00'],
                ],
            ],
        ],
    ],

    'expertise_banknotes' => [
        'title' => 'Perizie di banconote',
        'appointment' => true,
        'lead' => 'Perizie specialistiche di cartamoneta italiana e straniera, con conservazione delle immagini e dei dati identificativi per verifiche future.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi esegue perizie di banconote italiane e straniere a Roma, oltre a catalogazioni. Ogni servizio include la registrazione completa degli elementi identificativi e la conservazione delle immagini ad alta risoluzione.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tariffe perizie banconote',
                'note' => 'Gli onorari sono comprensivi di imposta e oneri.',
                'rows' => [
                    ['label' => 'Cartamoneta italiana (Biglietti di Stato, Buoni di Cassa, Banconote Banca d’Italia) fino a € 300', 'price' => '€ 20,00'],
                    ['label' => 'Valore tra € 301 e € 1.000', 'price' => '€ 25,00'],
                    ['label' => 'Valore tra € 1.001 e € 5.000', 'price' => '€ 50,00'],
                    ['label' => 'Valore tra € 5.001 e € 10.000', 'price' => '€ 100,00'],
                    ['label' => 'Valore tra € 10.001 e € 20.000', 'price' => '€ 200,00'],
                    ['label' => 'Consulenza tecnica numismatica in sede giudiziaria', 'price' => 'Su preventivo'],
                ],
            ],
        ],
    ],

    'cataloguing' => [
        'title' => 'Catalogazioni di monete e banconote',
        'appointment' => true,
        'lead' => 'Servizio di catalogazione specialistica di monete, medaglie e banconote, con registrazione degli elementi identificativi e immagini ad alta definizione.',
        'blocks' => [
            [
                'type' => 'text',
                'paragraphs' => [
                    'Umberto Moruzzi esegue la catalogazione di monete, medaglie e banconote a Roma. Il servizio comprende la registrazione completa degli elementi identificativi e la conservazione delle immagini ad alta risoluzione, per verificare nel tempo la corrispondenza tra esemplari e catalogazioni rilasciate.',
                ],
            ],
            [
                'type' => 'pricing',
                'title' => 'Tariffe catalogazione',
                'note' => 'Gli onorari sono comprensivi di imposta e oneri.',
                'rows' => [
                    ['label' => 'Consulenza tecnica numismatica in sede giudiziaria', 'price' => 'Su preventivo'],
                    ['label' => 'Catalogazione specialistica di monete romane repubblicane ed imperiali, tessere e medaglioni', 'price' => '€ 18,50'],
                    ['label' => 'Catalogazione di monete greche, greche imperiali, bizantine e medievali italiane ed europee', 'price' => '€ 18,50'],
                    ['label' => 'Catalogazione specialistica di singole banconote e intere collezioni', 'price' => '€ 18,50 cad.'],
                ],
            ],
        ],
    ],
];

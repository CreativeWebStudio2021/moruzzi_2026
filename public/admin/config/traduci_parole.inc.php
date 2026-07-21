<?
function traduci($testo){
    global $lingua;

    // INDIRIZZI
    if($testo == "ospite.html"){
        $trad_it = "ospite.html";
        $trad_en = "ospite.html";
        $trad_de = "ospite.html";
        $trad_fr = "ospite.html";
        $trad_es = "ospite.html";
    }	
    if($testo == "registrati.html"){
        $trad_it = "registrati.html";
        $trad_en = "registration.html";
        $trad_de = "registrierung.html";
        $trad_fr = "inscription.html";
        $trad_es = "registro.html";
    }
    if($testo == "registrati-conferma.html"){
        $trad_it = "registrati-conferma.html";
        $trad_en = "registration-confirm.html";
        $trad_de = "registrierung-bestätigen.html";
        $trad_fr = "inscription-confirmer.html";
        $trad_es = "registro-confirmar.html";
    }
    if($testo == "il_mio_account.html"){
        $trad_it = "il_mio_account.html";
        $trad_en = "my_account.html";
        $trad_de = "mein_konto.html";
        $trad_fr = "mon_compte.html";
        $trad_es = "mi_cuenta.html";
    }
    if($testo == "i_miei_ordini.html"){
        $trad_it = "i_miei_ordini.html";
        $trad_en = "my_orders.html";
        $trad_de = "mein_konto.html";
        $trad_fr = "mes_commandes.html";
        $trad_es = "mis_pedidos.html";
    }
    if($testo == "i_miei_dati_di_spedizione.html"){
        $trad_it = "i_miei_dati_di_spedizione.html";
        $trad_en = "my_shipping_data.html";
        $trad_de = "meine_versanddaten.html";
        $trad_fr = "mes_informations_de_livraison.html";
        $trad_es = "mis_datos_de_envio.html";
    } 
    if($testo == "recupero-password.html"){
        $trad_it = "recupero-password.html";
        $trad_en = "password-recovery.html";
        $trad_de = "password-recovery.html";
        $trad_fr = "password-recovery.html";
        $trad_es = "password-recovery.html";
    }
    if($testo == "cambia-password"){
        $trad_it = "cambia-password";
        $trad_en = "change-password";
        $trad_de = "passwort-andern";
        $trad_fr = "changer-le-mot-de-passe";
        $trad_es = "cambiar-contrasena";
    }
		
		
    if($testo == "ordini-in-corso.html"){
        $trad_it = "ordini-in-corso.html";
        $trad_en = "ongoing-orders.html";
        $trad_de = "laufende-bestellungen.html";
        $trad_fr = "commandes-en-cours.html";
        $trad_es = "pedidos-en-curso.html";
    }
    if($testo == "ordini-evasi.html"){
        $trad_it = "ordini-evasi.html";
        $trad_en = "completed-orders.html";
        $trad_de = "abgeschlossene-bestellungen.html";
        $trad_fr = "commandes-exécutées.html";
        $trad_es = "pedidos-completados.html";
    }
    if($testo == "ordini-annullati.html"){
        $trad_it = "ordini-annullati.html";
        $trad_en = "cancelled-orders.html";
        $trad_de = "stornierte-bestellungen.html";
        $trad_fr = "commandes-annulées.html";
        $trad_es = "pedidos-cancelados.html";
    }
    if($testo == "i-miei-ordini-tutti.html"){
        $trad_it = "i-miei-ordini-tutti.html";
        $trad_en = "my-orders-all.html";
        $trad_de = "mein-konto-alle.html";
        $trad_fr = "mes-commandes-tous.html";
        $trad_es = "mis-pedidos-todos.html";
    }
    if($testo == "carrello.html"){
        $trad_it = "carrello.html";
        $trad_en = "cart.html";
        $trad_de = "warenkorb.html";
        $trad_fr = "panier.html";
        $trad_es = "carrito.html";
    }
    if($testo == "recupero-password.html"){
        $trad_it = "recupero-password.html";
        $trad_en = "password-recovery.html";
        $trad_de = "password-recovery.html";
        $trad_fr = "password-recovery.html";
        $trad_es = "password-recovery.html";
    }
    if($testo == "condizioni_di_vendita.html"){
        $trad_it = "condizioni_di_vendita.html";
        $trad_en = "lang2/conditions_of_sale.html";
        $trad_de = "lang5/verkaufsbedingungen.html";
        $trad_fr = "lang1/conditions_de_vente.html";
        $trad_es = "lang3/condiciones_de_venta.html";
    }
    if($testo == "gli_attestati_di_garanzia_e_provenienza.html"){
        $trad_it = "gli_attestati_di_garanzia_e_provenienza.html";
        $trad_en = "lang2/attestation_of_guarantee_and_provenance.html";
        $trad_de = "lang5/garantie-_und_herkunftsbescheinigungen.html";
        $trad_fr = "lang1/attestations_de_garantie_et_provenance.html";
        $trad_es = "lang3/certificados_de_garantia_y_de_origen.html";
    }
    if($testo == "le_abbreviazioni_per_le_monete.html"){
        $trad_it = "le_abbreviazioni_per_le_monete.html";
        $trad_en = "lang2/abbreviations_concerning_banknotes.html";
        $trad_de = "lang5/abkurzungen_fur_die_banknoten.html";
        $trad_fr = "lang1/les_abréviations_des_papiers_monnaies.html";
        $trad_es = "lang3/la_abreviatura_de_los_billetes.html";
    }
    if($testo == "la_garanzia_moruzzi_numismatica.html"){
        $trad_it = "la_garanzia_moruzzi_numismatica.html";
        $trad_en = "lang2/guarantee_moruzzi_numismatica.html";
        $trad_de = "lang5/die_garantie_moruzzi_numismatik.html";
        $trad_fr = "lang1/garantie_moruzzi_numismatica.html";
        $trad_es = "lang3/la_garantia_moruzzi_numismatica.html";
    }
    if($testo == "collezionare_monete_antiche_in_italia.html"){
        $trad_it = "collezionare_monete_antiche_in_italia.html";
        $trad_en = "lang2/collecting_ancient_coins_in_italy.html";
        $trad_de = "lang5/antike_munzsammlungen_in_italien.html";
        $trad_fr = "lang1/collectionner_monnaies_antiques_en_italie.html";
        $trad_es = "lang3/coleccionar_monedas_antiguas_en_italia.html";
    }

    // PAROLE E FRASI
	if($testo=="Acquista come ospite"){
		$trad_it="Acquista come ospite";
		$trad_en="Purchase as a guest";
		$trad_de="Kauf als Gast";
		$trad_fr="Acheter en tant qu'invité";
		$trad_es="Compra como invitado";
	}		
	if($testo=="Prosegui"){
		$trad_it="Prosegui";
		$trad_en="Continue";
		$trad_de="Weitermachen";
		$trad_fr="Continuer";
		$trad_es="Continuar";
	}	
	if($testo=="Registrati"){
		$trad_it="Registrati";
		$trad_en="Register";
		$trad_de="Registrieren";
		$trad_fr="Inscrivez-vous";
		$trad_es="Regístrate";
	}	
	if($testo=="nel nostro negozio online"){
		$trad_it="nel nostro negozio online";
		$trad_en="in our online store";
		$trad_de="sie sich in unserem Online-Shop";
		$trad_fr="dans notre boutique en lign";
		$trad_es="en nuestra tienda en línea";
	}
	
	if($testo == "Il Mio Account"){
        $trad_it = "Il Mio Account";
        $trad_en = "My Account";
        $trad_de = "Mein Konto";
        $trad_fr = "Mon Compte";
        $trad_es = "Mi Cuenta";
    }
	 
	if($testo == "I Miei Ordini"){
        $trad_it = "I Miei Ordini";
        $trad_en = "My Orders";
        $trad_de = "Meine Bestellungen";
        $trad_fr = "Mes Commandes";
        $trad_es = "Mis Pedidos";
    }
	
	if($testo == "Cambia Password"){
        $trad_it = "Cambia Password";
        $trad_en = "Change Password";
        $trad_de = "Passwort ändern";
        $trad_fr = "Changer le mot de passe";
        $trad_es = "Cambiar contraseña";
    }
	
	if($testo == "Ordini in Corso"){
        $trad_it = "Ordini in Corso";
        $trad_en = "Ongoing Orders";
        $trad_de = "Laufende Bestellungen";
        $trad_fr = "Commandes en Cours";
        $trad_es = "Pedidos en Curso";
    }
	
	if($testo == "Ordini Evasi"){
        $trad_it = "Ordini Evasi";
        $trad_en = "Completed Orders";
        $trad_de = "Abgeschlossene Bestellungen";
        $trad_fr = "Commandes Exécutées";
        $trad_es = "Pedidos Completados";
    }
	
	if($testo == "Ordini Annullati"){
        $trad_it = "Ordini Annullati";
        $trad_en = "Cancelled Orders";
        $trad_de = "Stornierte Bestellungen";
        $trad_fr = "Commandes Annulées";
        $trad_es = "Pedidos Cancelados";
    }
	
	if($testo == "Tutti"){
        $trad_it = "Tutti";
        $trad_en = "All";
        $trad_de = "Alle";
        $trad_fr = "Tous";
        $trad_es = "Todos";
    }
	
	if($testo == "Ultimi Arrivi"){
        $trad_it = "Ultimi Arrivi";
        $trad_en = "New Additions";
        $trad_de = "Neuzugange";
        $trad_fr = "Dernieres Entrees";
        $trad_es = "Nuevas Articulos";
    }
	
	if($testo == "Filtri"){
        $trad_it = "Filtri";
        $trad_en = "Filters";
        $trad_de = "Filter";
        $trad_fr = "Filtres";
        $trad_es = "Filtros";
    }
	
	if($testo == "cerca prodotto"){
        $trad_it = "cerca prodotto";
        $trad_en = "search your product";
        $trad_de = "Produkt suchen";
        $trad_fr = "rechercher un produit";
        $trad_es = "buscar producto";
    }
	
	if($testo == "Ordina per"){
        $trad_it = "Ordina per";
        $trad_en = "Sort by";
        $trad_de = "Nach ";
        $trad_fr = "Trier par";
        $trad_es = "Ordenar por";
    }
	
	if($testo == "elenco ordini effettuati"){
        $trad_it = "
			Di seguito l'elenco degli ordini da te effettuati:
		";
        $trad_en = "
			Below is the list of orders you have placed:
		";
        $trad_de = "
			Nachfolgend finden Sie die Liste der von Ihnen getätigten Bestellungen:
		";
        $trad_fr = "
			Ci-dessous la liste des commandes que vous avez passées :
		";
        $trad_es = "
			A continuación se muestra la lista de los pedidos que has realizado:
		";
    }
	
	

    if($testo == "Inserisci Nome"){
		$trad_it = "Inserisci Nome";
		$trad_en = "Enter First Name";
		$trad_de = "Vorname eingeben";
		$trad_fr = "Entrez le prénom";
		$trad_es = "Ingrese Nombre";
	}

	if($testo == "Inserisci Cognome"){
		$trad_it = "Inserisci Cognome";
		$trad_en = "Enter Last Name";
		$trad_de = "Nachname eingeben";
		$trad_fr = "Entrez le nom de famille";
		$trad_es = "Ingrese Apellido";
	}

    if($testo == "Inserisci Indirizzo"){
		$trad_it = "Inserisci Indirizzo";
		$trad_en = "Enter Address";
		$trad_de = "Adresse eingeben";
		$trad_fr = "Entrez l'adresse";
		$trad_es = "Ingrese Dirección";
	}

	if($testo == "Inserisci Città"){
		$trad_it = "Inserisci Città";
		$trad_en = "Enter City";
		$trad_de = "Stadt eingeben";
		$trad_fr = "Entrez la ville";
		$trad_es = "Ingrese Ciudad";
	}

	if($testo == "Inserisci Provincia"){
		$trad_it = "Inserisci Provincia";
		$trad_en = "Enter Province";
		$trad_de = "Provinz eingeben";
		$trad_fr = "Entrez la province";
		$trad_es = "Ingrese Provincia";
	}

	if($testo == 'ORDINE DEL'){
		$trad_it = 'ORDINE DEL';
		$trad_en = 'ORDER OF';
		$trad_de = 'BESTELLUNG VOM';
		$trad_fr = 'COMMANDE DU';
		$trad_es = 'PEDIDO DEL';
	}

	if($testo == 'TOTALE'){
		$trad_it = 'TOTALE';
		$trad_en = 'TOTAL';
		$trad_de = 'GESAMT';
		$trad_fr = 'TOTAL';
		$trad_es = 'TOTAL';
	}

	if($testo == 'INVIATO A'){
		$trad_it = 'INVIATO A';
		$trad_en = 'SENT TO';
		$trad_de = 'GESENDET AN';
		$trad_fr = 'ENVOYÉ À';
		$trad_es = 'ENVIADO A';
	}

	if($testo == 'Vedi Dettaglio Ordine'){
		$trad_it = 'Vedi Dettaglio Ordine';
		$trad_en = 'View Order Details';
		$trad_de = 'Bestelldetails anzeigen';
		$trad_fr = 'Voir les détails de la commande';
		$trad_es = 'Ver detalles del pedido';
	}

	if($testo == 'Ordine'){
		$trad_it = 'Ordine';
		$trad_en = 'Order';
		$trad_de = 'Bestellung';
		$trad_fr = 'Commande';
		$trad_es = 'Pedido';
	}

	if($testo == 'Peso'){
		$trad_it = 'Peso';
		$trad_en = 'Weight';
		$trad_de = 'Gewicht';
		$trad_fr = 'Poids';
		$trad_es = 'Peso';
	}

	if($testo == 'Articolo'){
		$trad_it = 'Articolo';
		$trad_en = 'Item';
		$trad_de = 'Artikel';
		$trad_fr = 'Article';
		$trad_es = 'Artículo';
	}

	if($testo == 'Immagine'){
		$trad_it = 'Immagine';
		$trad_en = 'Image';
		$trad_de = 'Bild';
		$trad_fr = 'Image';
		$trad_es = 'Imagen';
	}

	if($testo == 'Qta'){
		$trad_it = 'Qta';
		$trad_en = 'Qty';
		$trad_de = 'Menge';
		$trad_fr = 'Qté';
		$trad_es = 'Cant.';
	}

	if($testo == 'Prezzo'){
		$trad_it = 'Prezzo';
		$trad_en = 'Price';
		$trad_de = 'Preis';
		$trad_fr = 'Prix';
		$trad_es = 'Precio';
	}

	if($testo == 'Prezzo Singolo'){
		$trad_it = 'Prezzo Singolo';
		$trad_en = 'Unit Price';
		$trad_de = 'Einzelpreis';
		$trad_fr = 'Prix Unitaire';
		$trad_es = 'Precio Unitario';
	}

	if($testo == 'Prezzo Totale'){
		$trad_it = 'Prezzo Totale';
		$trad_en = 'Total Price';
		$trad_de = 'Gesamtpreis';
		$trad_fr = 'Prix Total';
		$trad_es = 'Precio Total';
	}

	if($testo == 'Peso Singolo'){
		$trad_it = 'Peso Singolo';
		$trad_en = 'Price';
		$trad_de = 'Einzelgewicht';
		$trad_fr = 'Prix';
		$trad_es = 'Peso Unitario';
	}

	if($testo == 'Peso Totale'){
		$trad_it = 'Peso Totale';
		$trad_en = 'Unit Weight';
		$trad_de = 'Gesamtgewicht';
		$trad_fr = 'Poids Unitaire';
		$trad_es = 'Peso Total';
	}

	if($testo == 'Totale'){
		$trad_it = 'Totale';
		$trad_en = 'Total Weight';
		$trad_de = 'Gesamt';
		$trad_fr = 'Poids Total';
		$trad_es = 'Total';
	}

	if($testo == 'Sub-Totale'){
		$trad_it = 'Sub-Totale';
		$trad_en = 'Sub-Total';
		$trad_de = 'Zwischensumme';
		$trad_fr = 'Sous-Total';
		$trad_es = 'Subtotal';
	}

	if($testo == 'Spedizione'){
		$trad_it = 'Spedizione';
		$trad_en = 'Shipping';
		$trad_de = 'Versand';
		$trad_fr = 'Expédition';
		$trad_es = 'Envío';
	}

	if($testo == 'Puoi procedere al pagamento'){
		$trad_it = 'Puoi procedere al pagamento.<br/>I dati per effettuare il <b>bonifico bancario</b> sono i seguenti:';
		$trad_en = 'You can now proceed to payment.<br/>The details for making the <b>bank transfer</b> are as follows:';
		$trad_de = 'Sie können nun mit der Zahlung fortfahren.<br/>Die Details für die Durchführung der <b>Banküberweisung</b> sind wie folgt:';
		$trad_fr = 'Vous pouvez maintenant procéder au paiement.<br/>Les détails pour effectuer le <b>virement bancaire</b> sont les suivants :';
		$trad_es = 'Ahora puede proceder al pago.<br/>Los detalles para realizar la <b>transferencia bancaria</b> son los siguientes:';
	}

	if($testo == 'ordine pagato'){
		$trad_it = "L'ordine risulta <b>pagato</b> il";
		$trad_en = 'The order was <b>paid</b> on';
		$trad_de = 'Die Bestellung wurde am <b>bezahlt</b>';
		$trad_fr = 'La commande a été <b>payée</b> le';
		$trad_es = 'El pedido fue <b>pagado</b> el';
	}

	if($testo == 'Pagato il'){
		$trad_it = "Pagato il";
		$trad_en = 'Paid on';
		$trad_de = 'Bezahlt am';
		$trad_fr = 'Payé le';
		$trad_es = 'Pagado el';
	}

	if($testo == 'Nessun ordine'){
		$trad_it = "Nessun ordine presente nella categoria selezionata";
		$trad_en = 'No orders found in the selected category';
		$trad_de = 'Keine Bestellungen in der ausgewählten Kategorie gefunden';
		$trad_fr = 'Aucune commande trouvée dans la catégorie sélectionnée';
		$trad_es = 'No se encontraron pedidos en la categoría seleccionada';
	}

	if($testo == 'Descrizione'){
		$trad_it = "Descrizione";
		$trad_en = 'Description';
		$trad_de = 'Beschreibung';
		$trad_fr = 'Description';
		$trad_es = 'Descripción';
	}

	if($testo == 'Quantità'){
		$trad_it = "Quantità";
		$trad_en = 'Quantity';
		$trad_de = 'Menge';
		$trad_fr = 'Quantité';
		$trad_es = 'Cantidad';
	}

	if($testo == 'QUANTITÀ'){
		$trad_it = "QUANTITÀ";
		$trad_en = 'QUANTITY';
		$trad_de = 'MENGE';
		$trad_fr = 'QUANTITÉ';
		$trad_es = 'CANTIDAD';
	}

	if($testo == 'Aggiungi al Carrello'){
		$trad_it = "Aggiungi al Carrello";
		$trad_en = 'Add to Cart';
		$trad_de = 'In den Warenkorb';
		$trad_fr = 'Ajouter au panier';
		$trad_es = 'Añadir al carrito';
	}

	if($testo == 'vedi dettagli'){
		$trad_it = "vedi dettagli";
		$trad_en = 'see details';
		$trad_de = 'Details anzeigen';
		$trad_fr = 'voir les détails';
		$trad_es = 'ver detalles';
	}

	if($testo == 'Vedi tutti'){
		$trad_it = "Vedi tutti";
		$trad_en = 'See All';
		$trad_de = 'Alle ansehen';
		$trad_fr = 'Voir tout';
		$trad_es = 'Ver todo';
	}

	if($testo == 'Carica Altro'){
		$trad_it = "Carica Altro";
		$trad_en = 'See More';
		$trad_de = 'Mehr sehen';
		$trad_fr = 'Voir plus';
		$trad_es = 'Ver más';
	}

	if($testo == 'Già nel tuo carrello'){
		$trad_it = "Già nel tuo carrello";
		$trad_en = 'Already in your cart';
		$trad_de = 'Bereits in Ihrem Warenkorb';
		$trad_fr = 'Déjà dans votre panier';
		$trad_es = 'Ya en tu carrito';
	}


		if($testo == 'Prodotto inserito nel carrello'){
		$trad_it = "Prodotto inserito nel carrello";
		$trad_en = 'Product added to cart';
		$trad_de = 'Produkt in den Warenkorb gelegt';
		$trad_fr = 'Produit ajouté au panier';
		$trad_es = 'Producto añadido al carrito';
	}

	if($testo == 'Il prodotto è stato inserito nel carrello nella quantità di:'){
		$trad_it = "Il prodotto è stato inserito nel carrello nella quantità di:";
		$trad_en = 'The product has been added to the cart. Quantity:';
		$trad_de = 'Das Produkt wurde dem Warenkorb hinzugefügt. Menge:';
		$trad_fr = 'Le produit a été ajouté au panier. Quantité:';
		$trad_es = 'El producto ha sido añadido al carrito. Cantidad:';
	}

	if($testo == 'La quantità del prodotto è stata modificata a:'){
		$trad_it = "La quantità del prodotto è stata modificata a:";
		$trad_en = 'The quantity of the product has been changed to:';
		$trad_de = 'Die Menge des Produkts wurde geändert auf:';
		$trad_fr = 'La quantité du produit a été modifiée à:';
		$trad_es = 'La cantidad del producto ha sido cambiada a:';
	}

	if($testo == 'SOLD OUT'){
		$trad_it = "SOLD OUT";
		$trad_en = 'SOLD OUT';
		$trad_de = 'AUSVERKAUFT';
		$trad_fr = 'ÉPUISÉ';
		$trad_es = 'AGOTADO';
	}

	if($testo == 'Elimina Ordine'){
		$trad_it = 'Elimina Ordine';
		$trad_en = 'Delete Order';
		$trad_de = 'Bestellung löschen';
		$trad_fr = 'Supprimer la commande';
		$trad_es = 'Eliminar pedido';
	}

	if($testo == "Procedi all'acquisto"){
		$trad_it = "Procedi all'acquisto";
		$trad_en = 'Proceed to Purchase';
		$trad_de = 'Zum Kauf fortfahren';
		$trad_fr = 'Procéder à l\'achat';
		$trad_es = 'Proceder a la compra';
	}

	if($testo == "Totale parziale"){
		$trad_it = "Totale parziale";
		$trad_en = 'Subtotal';
		$trad_de = 'Zwischensumme';
		$trad_fr = 'Sous-total';
		$trad_es = 'Subtotal';
	}

	if($testo == "Rimuovere il prodotto?"){
		$trad_it = "Rimuovere il prodotto?";
		$trad_en = 'Remove the product?';
		$trad_de = 'Das Produkt entfernen?';
		$trad_fr = 'Retirer le produit?';
		$trad_es = '¿Eliminar el producto?';
	}

	if($testo == "Pezzi Conf"){
		$trad_it = "Pezzi Conf";
		$trad_en = 'Pieces Pkg';
		$trad_de = 'Stück Pkg';
		$trad_fr = 'Pièces Emb';
		$trad_es = 'Piezas Paq';
	}

	if($testo == "Cod. Articolo"){
		$trad_it = "Cod. Articolo";
		$trad_en = 'Item Code';
		$trad_de = 'Artikel-Nr';
		$trad_fr = 'Code Article';
		$trad_es = 'Código Artículo';
	}

	if($testo == "elimina"){
		$trad_it = "elimina";
		$trad_en = 'delete';
		$trad_de = 'löschen';
		$trad_fr = 'supprimer';
		$trad_es = 'eliminar';
	}

	if($testo == "Eliminare ordine"){
		$trad_it = "Eliminare ordine";
		$trad_en = 'Delete order';
		$trad_de = 'Bestellung löschen';
		$trad_fr = 'Supprimer la commande';
		$trad_es = 'Eliminar pedido';
	}

	if($testo == "Il carrello è vuoto o la sessione è scaduta"){
		$trad_it = "Il carrello è vuoto o la sessione è scaduta!";
		$trad_en = 'The cart is empty or the session has expired!';
		$trad_de = 'Der Warenkorb ist leer oder die Sitzung ist abgelaufen!';
		$trad_fr = 'Le panier est vide ou la session a expiré!';
		$trad_es = '¡El carrito está vacío o la sesión ha expirado!';
	}
	
	if($testo == "ESCI"){
		$trad_it = "ESCI";
		$trad_en = 'LOG OUT';
		$trad_de = 'AUSLOGGEN';
		$trad_fr = 'DÉCONNECTER';
		$trad_es = 'CERRAR SESIÓN';
	}

	if($testo == "Se sei un utente già registrato, inserisci il tuo username e la password"){
		$trad_it = "Se sei un utente già registrato, inserisci il tuo username e la password";
		$trad_en = 'If you are already a registered user, enter your username and password';
		$trad_de = 'Wenn Sie bereits registriert sind, geben Sie Ihren Benutzernamen und Ihr Passwort ein';
		$trad_fr = 'Si vous êtes déjà inscrit, entrez votre nom d\'utilisateur et votre mot de passe';
		$trad_es = 'Si ya estás registrado, introduce tu nombre de usuario y contraseña';
	}

	if($testo == "Memorizza dati"){
		$trad_it = "Memorizza dati";
		$trad_en = 'Remember me';
		$trad_de = 'Daten speichern';
		$trad_fr = 'Enregistrer les données';
		$trad_es = 'Recordar datos';
	}

	if($testo == "Password dimenticata?"){
		$trad_it = "Password dimenticata?";
		$trad_en = 'Forgot password?';
		$trad_de = 'Passwort vergessen?';
		$trad_fr = 'Mot de passe oublié?';
		$trad_es = '¿Olvidaste tu contraseña?';
	}

	if($testo == "Non hai un account?"){
		$trad_it = "Non hai un account?";
		$trad_en = 'Don\'t have an account?';
		$trad_de = 'Kein Konto?';
		$trad_fr = 'Vous n\'avez pas de compte?';
		$trad_es = '¿No tienes una cuenta?';
	}

	if($testo == "Registrati ora!"){
		$trad_it = "Registrati ora!";
		$trad_en = 'Sign up now!';
		$trad_de = 'Jetzt registrieren!';
		$trad_fr = 'Inscrivez-vous maintenant!';
		$trad_es = '¡Regístrate ahora!';
	}

	if($testo == "Inserire username"){
		$trad_it = "Inserire username";
		$trad_en = 'Enter username';
		$trad_de = 'Benutzernamen eingeben';
		$trad_fr = 'Entrez le nom d\'utilisateur';
		$trad_es = 'Introduce tu nombre de usuario';
	}

	if($testo == "Inserire password"){
		$trad_it = "Inserire password";
		$trad_en = 'Enter password';
		$trad_de = 'Passwort eingeben';
		$trad_fr = 'Entrez le mot de passe';
		$trad_es = 'Introduce tu contraseña';
	}

	if($testo == "Recupera dati"){
		$trad_it = "Recupera dati";
		$trad_en = 'Recover data';
		$trad_de = 'Daten wiederherstellen';
		$trad_fr = 'Récupérer les données';
		$trad_es = 'Recuperar datos';
	}

	if($testo == "Invia"){
		$trad_it = "Invia";
		$trad_en = 'Send';
		$trad_de = 'Senden';
		$trad_fr = 'Envoyer';
		$trad_es = 'Enviar';
	}

	if($testo == "Se hai perso i dati per accedere all'area riservata"){
		$trad_it = "Se hai perso i dati per accedere all'area riservata, inserisci il tuo indirizzo e-mail nell'apposito campo, così riceverai una e-mail contenente il link per accedere alla procedura di cambio password:";
		$trad_en = 'If you have lost the data to access the reserved area, enter your email address in the appropriate field, and you will receive an email with the link to access the password change procedure:';
		$trad_de = 'Wenn Sie die Daten zum Zugriff auf den reservierten Bereich verloren haben, geben Sie Ihre E-Mail-Adresse in das entsprechende Feld ein, und Sie erhalten eine E-Mail mit dem Link, um auf das Passwortänderungsverfahren zuzugreifen:';
		$trad_fr = 'Si vous avez perdu les données pour accéder à la zone réservée, saisissez votre adresse e-mail dans le champ approprié, et vous recevrez un e-mail avec le lien pour accéder à la procédure de changement de mot de passe:';
		$trad_es = 'Si has perdido los datos para acceder al área reservada, ingresa tu dirección de correo electrónico en el campo correspondiente, y recibirás un correo electrónico con el enlace para acceder al procedimiento de cambio de contraseña:';
	}

	if($testo == 'Gentile Cliente qui di seguito troverà'){
		$trad_it = "Gentile Cliente, qui di seguito trover&agrave; l'elenco degli articoli da Lei inseriti nel carrello (con la possibilit&agrave; di modificare le quantit&agrave; e/o di eliminare articoli).<br />
					Le ricordiamo che tutti i prezzi citati sono IVA inclusa.<br /><br />
					Clicchi sul bottone <b>'Procedi All'Acquisto'</b> per procedere con l'ordine-";
		$trad_en = 'Dear Customer, below you will find the list of items you have added to the cart (with the possibility of modifying quantities and/or removing items).<br />
					Please note that all mentioned prices include VAT.<br /><br />
					Click on the <b>"Proceed to Purchase"</b> button to proceed with the order-';
		$trad_de = 'Sehr geehrter Kunde, unten finden Sie die Liste der Artikel, die Sie in den Warenkorb gelegt haben (mit der Möglichkeit, Mengen zu ändern und/oder Artikel zu entfernen).<br />
					Bitte beachten Sie, dass alle genannten Preise die Mehrwertsteuer enthalten.<br /><br />
					Klicken Sie auf die Schaltfläche <b>"Zum Kauf fortfahren"</b>, um mit der Bestellung fortzufahren-';
		$trad_fr = 'Cher client, vous trouverez ci-dessous la liste des articles que vous avez ajoutés au panier (avec la possibilité de modifier les quantités et/ou de supprimer des articles).<br />
					Veuillez noter que tous les prix mentionnés incluent la TVA.<br /><br />
					Cliquez sur le bouton <b>"Procéder à l\'achat"</b> pour continuer votre commande-';
		$trad_es = 'Estimado cliente, a continuación encontrará la lista de artículos que ha añadido al carrito (con la posibilidad de modificar cantidades y/o eliminar artículos).<br />
					Tenga en cuenta que todos los precios mencionados incluyen el IVA.<br /><br />
					Haga clic en el botón <b>"Proceder a la compra"</b> para continuar con el pedido-';
	}

	if($testo == "Metodo di pagamento"){
		$trad_it = "Metodo di pagamento";
		$trad_en = 'Payment Method';
		$trad_de = 'Zahlungsmethode';
		$trad_fr = 'Méthode de paiement';
		$trad_es = 'Método de pago';
	}

	if($testo == "Metodo di spedizione"){
		$trad_it = "Metodo di spedizione";
		$trad_en = 'Shipping Method';
		$trad_de = 'Versandart';
		$trad_fr = 'Mode de livraison';
		$trad_es = 'Método de envío';
	}

	if($testo == "Totale parziale"){
		$trad_it = "Totale parziale";
		$trad_en = 'Subtotal';
		$trad_de = 'Zwischensumme';
		$trad_fr = 'Sous-total';
		$trad_es = 'Subtotal';
	}

	if($testo == "iva inclusa"){
		$trad_it = "iva inclusa";
		$trad_en = 'VAT included';
		$trad_de = 'inkl. MwSt';
		$trad_fr = 'TVA incluse';
		$trad_es = 'IVA incluido';
	}

	if($testo == "Note per l'ordine"){
		$trad_it = "Note per l'ordine";
		$trad_en = 'Order Notes';
		$trad_de = 'Bestellnotizen';
		$trad_fr = 'Notes de commande';
		$trad_es = 'Notas del pedido';
	}

	if($testo == "Max. 500 caratteri"){
		$trad_it = "Max. 500 caratteri";
		$trad_en = 'Max. 500 characters';
		$trad_de = 'Max. 500 Zeichen';
		$trad_fr = 'Max. 500 caractères';
		$trad_es = 'Máx. 500 caracteres';
	}

	if($testo == "Inserisci Note"){
		$trad_it = "Inserisci Note";
		$trad_en = 'Enter Notes';
		$trad_de = 'Notizen eingeben';
		$trad_fr = 'Entrez les notes';
		$trad_es = 'Introduce Notas';
	}

	if($testo == "Seleziona"){
		$trad_it = "Seleziona";
		$trad_en = 'Select';
		$trad_de = 'Wählen';
		$trad_fr = 'Sélectionner';
		$trad_es = 'Seleccionar';
	}

	if($testo == "Ritiro in negozio"){
		$trad_it = "Ritiro in negozio";
		$trad_en = 'In-store Pickup';
		$trad_de = 'Im Geschäft abholen';
		$trad_fr = 'Retrait en magasin';
		$trad_es = 'Recogida en tienda';
	}

	if($testo == "Pagamento in sede"){
		$trad_it = "Pagamento in sede";
		$trad_en = 'Payment on site';
		$trad_de = 'Zahlung vor Ort';
		$trad_fr = 'Paiement sur place';
		$trad_es = 'Pago en el sitio';
	}

	if($testo == "Raccomandata"){
		$trad_it = "Raccomandata";
		$trad_en = 'Registered Mail';
		$trad_de = 'Einschreiben';
		$trad_fr = 'Courrier recommandé';
		$trad_es = 'Correo certificado';
	}

	if($testo == "Assicurata"){
		$trad_it = "Assicurata";
		$trad_en = 'Insured Mail';
		$trad_de = 'Versichert';
		$trad_fr = 'Assuré';
		$trad_es = 'Asegurado';
	}

	if($testo == "Carta di credito/PayPal"){
		$trad_it = "Carta di credito/PayPal";
		$trad_en = 'Credit Card/PayPal';
		$trad_de = 'Kreditkarte/PayPal';
		$trad_fr = 'Carte de crédit/PayPal';
		$trad_es = 'Tarjeta de crédito/PayPal';
	}

	if($testo == "Bonifico bancario"){
		$trad_it = "Bonifico bancario";
		$trad_en = 'Bank Transfer';
		$trad_de = 'Banküberweisung';
		$trad_fr = 'Virement bancaire';
		$trad_es = 'Transferencia bancaria';
	}

	if($testo == "Accetto le"){
		$trad_it = "Accetto le";
		$trad_en = 'I accept the';
		$trad_de = 'Ich akzeptiere die';
		$trad_fr = 'J\'accepte les';
		$trad_es = 'Acepto los';
	}

	if($testo == "Leggi le condizioni di vendita"){
		$trad_it = "Leggi le condizioni di vendita";
		$trad_en = 'Read the terms of sale';
		$trad_de = 'Lesen Sie die Verkaufsbedingungen';
		$trad_fr = 'Lire les conditions de vente';
		$trad_es = 'Leer las condiciones de venta';
	}

	if($testo == "Attenzione: non è stato selezionato il metodo di spedizione!"){
		$trad_it = "Attenzione: non è stato selezionato il metodo di spedizione!";
		$trad_en = 'Warning: no shipping method selected!';
		$trad_de = 'Achtung: keine Versandart ausgewählt!';
		$trad_fr = 'Attention: aucune méthode de livraison sélectionnée!';
		$trad_es = 'Atención: ¡no se ha seleccionado el método de envío!';
	}

		if($testo == "Attenzione: non è stato selezionato il metodo di pagamento!"){
		$trad_it = "Attenzione: non è stato selezionato il metodo di pagamento!";
		$trad_en = 'Warning: no payment method selected!';
		$trad_de = 'Achtung: keine Zahlungsmethode ausgewählt!';
		$trad_fr = 'Attention: aucune méthode de paiement sélectionnée!';
		$trad_es = 'Atención: ¡no se ha seleccionado el método de pago!';
	}

	if($testo == "Attenzione: Confermare la lettura delle condizioni di vendita!"){
		$trad_it = "Attenzione: Confermare la lettura delle condizioni di vendita!";
		$trad_en = 'Warning: Confirm that you have read the terms of sale!';
		$trad_de = 'Achtung: Bestätigen Sie, dass Sie die Verkaufsbedingungen gelesen haben!';
		$trad_fr = 'Attention: Confirmez que vous avez lu les conditions de vente!';
		$trad_es = 'Atención: ¡Confirme que ha leído los términos de venta!';
	}

	if($testo == "Torna indietro"){
		$trad_it = "Torna indietro";
		$trad_en = 'Go back';
		$trad_de = 'Geh zurück';
		$trad_fr = 'Retourner';
		$trad_es = 'Volver';
	}

	if($testo == "INVIA ORDINE"){
		$trad_it = "INVIA ORDINE";
		$trad_en = 'SUBMIT ORDER';
		$trad_de = 'BESTELLUNG ABSCHICKEN';
		$trad_fr = 'ENVOYER LA COMMANDE';
		$trad_es = 'ENVIAR PEDIDO';
	}

	if($testo == "Numero di telefono"){
		$trad_it = "Numero di telefono";
		$trad_en = 'Phone number';
		$trad_de = 'Telefonnummer';
		$trad_fr = 'Numéro de téléphone';
		$trad_es = 'Número de teléfono';
	}

	if($testo == "Inserisci Telefono"){
		$trad_it = "Inserisci Telefono";
		$trad_en = 'Enter Phone';
		$trad_de = 'Telefon eingeben';
		$trad_fr = 'Entrez le téléphone';
		$trad_es = 'Introduce el teléfono';
	}

	if($testo == "Conservazione"){
		$trad_it = "Conservazione";
		$trad_en = 'Grading';
		$trad_de = 'Erhaltung';
		$trad_fr = 'Conservation';
		$trad_es = 'Conservación';
	}

	if($testo == "Rarità"){
		$trad_it = "Rarità";
		$trad_en = 'Rarity';
		$trad_de = 'Seltenheit';
		$trad_fr = 'Rareté';
		$trad_es = 'Rareza';
	}

	if($testo == "Metallo e Patina"){
		$trad_it = "Metallo e Patina";
		$trad_en = 'Metal and Patina';
		$trad_de = 'Metall und Patina';
		$trad_fr = 'Métal et Patine';
		$trad_es = 'Metal y Pátina';
	}

	if($testo == "Stile"){
		$trad_it = "Stile";
		$trad_en = 'Style';
		$trad_de = 'Stil';
		$trad_fr = 'Style';
		$trad_es = 'Estilo';
	}

	if($testo == "Coniazione"){
		$trad_it = "Coniazione";
		$trad_en = 'Coinage';
		$trad_de = 'Prägung';
		$trad_fr = 'Monnayage';
		$trad_es = 'Acuñación';
	}

	if($testo == "Provenienza"){
		$trad_it = "Provenienza";
		$trad_en = 'Provenance';
		$trad_de = 'Herkunft';
		$trad_fr = 'Provenance';
		$trad_es = 'Proveniencia';
	}

	if($testo == "Recupero Password"){
		$trad_it = "Recupero Password";
		$trad_en = 'Password Recovery';
		$trad_de = 'Passwort-Wiederherstellung';
		$trad_fr = 'Récupération de mot de passe';
		$trad_es = 'Recuperación de contraseña';
	}

	if($testo == "La tua E-mail non risulta tra quelle degli utenti registrati"){
		$trad_it = "
			ATTENZIONE!
			<br /><br />
			La tua <b>E-mail</b> non risulta tra quelle degli utenti registrati, probabilmente non sei ancora registrato!
		";
		$trad_en = "
			WARNING!
			<br /><br />
			Your <b>Email</b> is not among the registered users, you are probably not yet registered!
		";
		$trad_de = "
			ACHTUNG!
			<br /><br />
			Ihre <b>E-Mail</b> ist nicht unter den registrierten Benutzern, Sie sind wahrscheinlich noch nicht registriert!
		";
		$trad_fr = "
			ATTENTION!
			<br /><br />
			Votre <b>Email</b> n'est pas parmi les utilisateurs enregistrés, vous n'êtes probablement pas encore inscrit!
		";
		$trad_es = "
			¡ATENCIÓN!
			<br /><br />
			Su <b>Email</b> no está entre los usuarios registrados, probablemente aún no esté registrado.
		";
	}

	if($testo == "CODICE DI VERIFICA ERRATO"){
		$trad_it = "
			ATTENZIONE!<i><br /><br /><b>CODICE DI VERIFICA ERRATO</b>
		";
		$trad_en = "
			WARNING!<i><br /><br /><b>INCORRECT VERIFICATION CODE</b>
		";
		$trad_de = "
			ACHTUNG!<i><br /><br /><b>FALSCHER VERIFIZIERUNGSCODE</b>
		";
		$trad_fr = "
			ATTENTION!<i><br /><br /><b>CODE DE VÉRIFICATION INCORRECT</b>
		";
		$trad_es = "
			¡ATENCIÓN!<i><br /><br /><b>CÓDIGO DE VERIFICACIÓN INCORRECTO</b>
		";
	}

	if($testo == "Se hai perso i dati per accedere all'area riservata"){
		$trad_it = "
			Se hai perso i dati per accedere all'area riservata o vuoi semplicemente cambiarli, inserisci la tua 
			E-mail nell'apposito campo, cos&igrave; riceverai una email con i tuoi dati di accesso:
		";
		$trad_en = "
			If you have lost the data to access the reserved area or simply want to change it, enter your 
			Email in the appropriate field, and you will receive an email with your access data:
		";
		$trad_de = "
			Wenn Sie die Daten für den Zugriff auf den reservierten Bereich verloren haben oder diese einfach ändern möchten, geben Sie Ihre 
			E-Mail in das entsprechende Feld ein, und Sie erhalten eine E-Mail mit Ihren Zugangsdaten:
		";
		$trad_fr = "
			Si vous avez perdu les données pour accéder à la zone réservée ou si vous souhaitez simplement les changer, entrez votre 
			E-mail dans le champ approprié, et vous recevrez un e-mail avec vos données d'accès:
		";
		$trad_es = "
			Si ha perdido los datos para acceder al área reservada o simplemente desea cambiarlos, ingrese su 
			Correo electrónico en el campo correspondiente, y recibirá un correo electrónico con sus datos de acceso:
		";
	}

		
	if($testo == "Scopri tutti i nostri prodotti"){
		$trad_it = "Scopri tutti i nostri prodotti";
		$trad_en = 'Discover all our products';
		$trad_de = 'Entdecken Sie alle unsere Produkte';
		$trad_fr = 'Découvrez tous nos produits';
		$trad_es = 'Descubre todos nuestros productos';
	}
		
	if($testo == "Scopri tutti i nostri prodotti in"){
		$trad_it = "Scopri tutti i nostri prodotti in";
		$trad_en = 'Discover all our products in';
		$trad_de = 'Entdecken Sie alle unsere Produkte in';
		$trad_fr = 'Découvrez tous nos produits en';
		$trad_es = 'Descubre todos nuestros productos en';
	}

	if($testo == "Prodotti da xxx a yyy di zzz risultati"){
		$trad_it = "Prodotti da xxx a yyy di zzz risultati";
		$trad_en = 'Products from xxx to yyy of zzz results';
		$trad_de = 'Produkte von xxx bis yyy von zzz Ergebnissen';
		$trad_fr = 'Produits de xxx à yyy sur zzz résultats';
		$trad_es = 'Productos de xxx a yyy de zzz resultados';
	}

	if($testo == "Prodotti da"){
		$trad_it = "Prodotti da";
		$trad_en = 'Products from';
		$trad_de = 'Produkte vonn';
		$trad_fr = 'Produits de';
		$trad_es = 'Productos de';
	}

	if($testo == "a"){
		$trad_it = "a";
		$trad_en = 'to';
		$trad_de = 'bis';
		$trad_fr = 'à';
		$trad_es = 'a';
	}

	if($testo == "di"){
		$trad_it = "di";
		$trad_en = 'of';
		$trad_de = 'von';
		$trad_fr = 'sur';
		$trad_es = 'de';
	}

	if($testo == "risultati"){
		$trad_it = "risultati";
		$trad_en = 'results';
		$trad_de = 'Ergebnissen';
		$trad_fr = 'résultats';
		$trad_es = 'resultados';
	}

	if($testo == "Prodotti Per Pagina"){
		$trad_it = "Prodotti Per Pagina";
		$trad_en = 'Products Per Page';
		$trad_de = 'Produkte pro Seite';
		$trad_fr = 'Produits par page';
		$trad_es = 'Productos por página';
	}

	if($testo == "Data"){
		$trad_it = "Data";
		$trad_en = 'Date';
		$trad_de = 'Datum';
		$trad_fr = 'Date';
		$trad_es = 'Fecha';
	}

	if($testo == "Nome Prodotto"){
		$trad_it = "Nome Prodotto";
		$trad_en = 'Product Name';
		$trad_de = 'Produktname';
		$trad_fr = 'Nom du produit';
		$trad_es = 'Nombre del producto';
	}

	if($testo == "Lingue"){
		$trad_it = "Lingue";
		$trad_en = 'Languages';
		$trad_de = 'Sprachen';
		$trad_fr = 'Langues';
		$trad_es = 'Idiomas';
	}

	if($testo == "vedi tutte"){
		$trad_it = "vedi tutte";
		$trad_en = 'see all';
		$trad_de = 'alle anzeigen';
		$trad_fr = 'voir tout';
		$trad_es = 'ver todo';
	}

	if($testo == "registrazione avvenuta con successo"){
		$trad_it = "La registrazione è avvenuta con successo!";
		$trad_en = 'Registration successful!';
		$trad_de = 'Registrierung erfolgreich!';
		$trad_fr = 'Inscription réussie!';
		$trad_es = '¡Registro exitoso!';
	}

	if($testo == "puoi ora accedere"){
		$trad_it = "Puoi ora accedere con i dati da te inseriti.";
		$trad_en = 'You can now log in with the data you entered.';
		$trad_de = 'Sie können sich jetzt mit den eingegebenen Daten anmelden.';
		$trad_fr = 'Vous pouvez maintenant vous connecter avec les données que vous avez saisies.';
		$trad_es = 'Ahora puede iniciar sesión con los datos que ingresó.';
	}

	if($testo == "Accedi"){
		$trad_it = "Accedi";
		$trad_en = 'Login';
		$trad_de = 'Anmelden';
		$trad_fr = 'Connexion';
		$trad_es = 'Iniciar sesión';
	}

	if($testo == "Login / Registrati"){
		$trad_it = "Login / Registrati";
		$trad_en = 'Login / Register';
		$trad_de = 'Anmelden / Registrieren';
		$trad_fr = 'Connexion / Inscription';
		$trad_es = 'Iniciar sesión / Registrarse';
	}

	if($testo == "Accesso effettuato!"){
		$trad_it = "Accesso effettuato!";
		$trad_en = 'Login successful!';
		$trad_de = 'Erfolgreich eingeloggt!';
		$trad_fr = 'Connexion réussie !';
		$trad_es = '¡Acceso exitoso!';
	}

	if($testo == "Attenzione: utente disabilitato"){
		$trad_it = "Attenzione: utente disabilitato!<br/>Inviare una mail a <a href=\'mailto:$mail_sito_def\' style=\'color:#fff !important\'>$mail_sito_def</a>";
		$trad_en = 'Attention: User disabled!<br/>Send an email to <a href=\'mailto:$mail_sito_def\' style=\'color:#fff !important\'>$mail_sito_def</a>';
		$trad_de = 'Achtung: Benutzer deaktiviert!<br/>Senden Sie eine E-Mail an <a href=\'mailto:$mail_sito_def\' style=\'color:#fff !important\'>$mail_sito_def</a>';
		$trad_fr = 'Attention : Utilisateur désactivé !<br/>Envoyez un e-mail à <a href=\'mailto:$mail_sito_def\' style=\'color:#fff !important\'>$mail_sito_def</a>';
		$trad_es = 'Atención: ¡Usuario deshabilitado!<br/>Envíe un correo electrónico a <a href=\'mailto:$mail_sito_def\' style=\'color:#fff !important\'>$mail_sito_def</a>';
	}
	

	if($testo == "Attenzione: la username o la password non corrispondono!"){
		$trad_it = "Attenzione: la username o la password non corrispondono!";
		$trad_en = 'Attention: the username or password does not match!';
		$trad_de = 'Achtung: Der Benutzername oder das Passwort stimmt nicht überein!';
		$trad_fr = 'Attention : le nom d\'utilisateur ou le mot de passe ne correspond pas !';
		$trad_es = 'Atención: ¡el nombre de usuario o la contraseña no coinciden!';
	}
	

	if($testo == "A causa del recente aggiornamento del sito"){
		$trad_it = "<br/>A causa del recente aggiornamento del sito potrebbe essere necessario efferruare il <a href='it/recupero-password.html'>RECUPERO PASSWORD</a>";
		$trad_en = "<br/>Due to the recent website update, it may be necessary to perform a <a href='en/password-recovery.html'>PASSWORD RECOVERY</a>";
		$trad_de = "<br/>Aufgrund des kürzlichen Website-Updates kann es erforderlich sein, eine <a href='de/password-recovery.html'>PASSWORT-WIEDERHERSTELLUNG</a> durchzuführen";
		$trad_fr = "<br/>En raison de la récente mise à jour du site, il peut être nécessaire d'effectuer une <a href='fr/password-recovery.html'>RÉCUPÉRATION DE MOT DE PASSE</a>";
		$trad_es = "<br/>Debido a la reciente actualización del sitio, puede ser necesario realizar una <a href='es/password-recovery.html'>RECUPERACIÓN DE CONTRASEÑA</a>";
	}

	if($testo == "Causa problemi registrazione non avvenuta"){
		$trad_it = "Causa problemi tecnici la tua registrazione non è potuta avvenire!";
		$trad_en = 'Due to technical issues, your registration could not be completed!';
		$trad_de = 'Aufgrund technischer Probleme konnte Ihre Registrierung nicht abgeschlossen werden!';
		$trad_fr = 'En raison de problèmes techniques, votre inscription n\'a pas pu être complétée!';
		$trad_es = 'Debido a problemas técnicos, no se pudo completar su registro!';
	}

	if($testo == "email già inserita"){
		$trad_it = "Attenzione la tua <b>E-mail</b> risulta gi&agrave; inserita tra quelle dei nostri utenti registrati,<br/>probabilmente sei gi&agrave; registrato!";
		$trad_en = 'Attention, your <b>Email</b> is already registered among our users,<br/>you are probably already registered!';
		$trad_de = 'Achtung, Ihre <b>E-Mail</b> ist bereits bei unseren Benutzern registriert,<br/>Sie sind wahrscheinlich schon registriert!';
		$trad_fr = 'Attention, votre <b>Email</b> est déjà enregistrée parmi nos utilisateurs,<br/>vous êtes probablement déjà inscrit!';
		$trad_es = 'Atención, su <b>Email</b> ya está registrada entre nuestros usuarios,<br/>¡probablemente ya está registrado!';
	}

	if($testo == "Sei già registrato"){
		$trad_it = "Sei già registrato?";
		$trad_en = 'Already registered?';
		$trad_de = 'Schon registriert?';
		$trad_fr = 'Déjà inscrit?';
		$trad_es = '¿Ya registrado?';
	}

	if($testo == "Se non sei registrato"){
		$trad_it = "Se non sei registrato compila il form di registrazione per accedere al nostro catalogo completo, usufruire delle numerose offerte ed essere sempre aggiornato sulle ultime novità.";
		$trad_en = 'If you are not registered, fill out the form below to access our complete catalog, take advantage of numerous offers, and stay updated on the latest news.';
		$trad_de = 'Wenn Sie nicht registriert sind, füllen Sie das untenstehende Formular aus, um auf unseren vollständigen Katalog zuzugreifen, zahlreiche Angebote zu nutzen und über die neuesten Nachrichten informiert zu bleiben.';
		$trad_fr = 'Si vous n\'êtes pas inscrit, remplissez le formulaire ci-dessous pour accéder à notre catalogue complet, profiter de nombreuses offres et rester informé des dernières nouveautés.';
		$trad_es = 'Si no está registrado, complete el formulario a continuación para acceder a nuestro catálogo completo, aprovechar numerosas ofertas y mantenerse actualizado sobre las últimas novedades.';
	}

	if($testo == "Nome"){
		$trad_it = "Nome";
		$trad_en = 'First Name';
		$trad_de = 'Vorname';
		$trad_fr = 'Prénom';
		$trad_es = 'Nombre';
	}

	if($testo == "Inserisci Nome"){
		$trad_it = "Inserisci Nome";
		$trad_en = 'Enter First Name';
		$trad_de = 'Vorname eingeben';
		$trad_fr = 'Entrez le prénom';
		$trad_es = 'Ingrese Nombre';
	}

	if($testo == "Cognome"){
		$trad_it = "Cognome";
		$trad_en = 'Last Name';
		$trad_de = 'Nachname';
		$trad_fr = 'Nom de famille';
		$trad_es = 'Apellido';
	}

	if($testo == "Inserisci Cognome"){
		$trad_it = "Inserisci Cognome";
		$trad_en = 'Enter Last Name';
		$trad_de = 'Nachname eingeben';
		$trad_fr = 'Entrez le nom de famille';
		$trad_es = 'Ingrese Apellido';
	}

	if($testo == "Inserisci E-mail"){
		$trad_it = "Inserisci E-mail";
		$trad_en = 'Enter Email';
		$trad_de = 'E-Mail eingeben';
		$trad_fr = 'Entrez l\'Email';
		$trad_es = 'Ingrese Correo Electrónico';
	}

	if($testo == "Iscriviti alla Newsletter"){
		$trad_it = "Iscriviti alla Newsletter";
		$trad_en = 'Subscribe to the Newsletter';
		$trad_de = 'Abonnieren Sie den Newsletter';
		$trad_fr = 'Abonnez-vous à la newsletter';
		$trad_es = 'Suscríbete al boletín';
	}

	if($testo == "Ripeti"){
		$trad_it = "Ripeti";
		$trad_en = 'Repeat';
		$trad_de = 'Wiederholen';
		$trad_fr = 'Répéter';
		$trad_es = 'Repetir';
	}

		if($testo == "I dati personali"){
		$trad_it = "I dati personali e l'indirizzo email forniti saranno trattati nel pieno rispetto della";
		$trad_en = 'The personal data and email address provided will be processed in full compliance with the';
		$trad_de = 'Die angegebenen personenbezogenen Daten und die E-Mail-Adresse werden in voller Übereinstimmung mit den';
		$trad_fr = 'Les données personnelles et l\'adresse e-mail fournies seront traitées dans le plein respect de la';
		$trad_es = 'Los datos personales y la dirección de correo electrónico proporcionados serán tratados en pleno cumplimiento de la';
	}

	if($testo == "impiegati allo scopo"){
		$trad_it = "e impiegati allo scopo strettamente legato alle finalità della registrazione.";
		$trad_en = 'and used for the purpose strictly related to the purposes of registration.';
		$trad_de = 'und ausschließlich für Zwecke im Zusammenhang mit der Registrierung verwendet.';
		$trad_fr = 'et utilisés à des fins strictement liées aux objectifs de l\'inscription.';
		$trad_es = 'y utilizados para fines estrictamente relacionados con los propósitos del registro.';
	}

	if($testo == "Autorizzo al trattamento dei dati personali"){
		$trad_it = "Autorizzo al trattamento dei dati personali";
		$trad_en = 'I authorize the processing of personal data';
		$trad_de = 'Ich erlaube die Verarbeitung personenbezogener Daten';
		$trad_fr = 'J\'autorise le traitement des données personnelles';
		$trad_es = 'Autorizo el tratamiento de datos personales';
	}

	if($testo == 'Campo "Nome" obbigatorio'){
		$trad_it = 'Campo "Nome" obbligatorio';
		$trad_en = '"First Name" field is required';
		$trad_de = 'Feld "Vorname" ist erforderlich';
		$trad_fr = 'Le champ "Prénom" est obligatoire';
		$trad_es = 'El campo "Nombre" es obligatorio';
	}

	if($testo == 'Campo "Cognome" obbigatorio'){
		$trad_it = 'Campo "Cognome" obbligatorio';
		$trad_en = '"Last Name" field is required';
		$trad_de = 'Feld "Nachname" ist erforderlich';
		$trad_fr = 'Le champ "Nom de famille" est obligatoire';
		$trad_es = 'El campo "Apellido" es obligatorio';
	}

	if($testo == 'Campo "E-mail" obbigatorio'){
		$trad_it = 'Campo "E-mail" obbligatorio';
		$trad_en = '"Email" field is required';
		$trad_de = 'Feld "E-Mail" ist erforderlich';
		$trad_fr = 'Le champ "Email" est obligatoire';
		$trad_es = 'El campo "Correo Electrónico" es obligatorio';
	}

	if($testo == 'Campo "Telefono" obbligatorio'){
		$trad_it = 'Campo "Telefono" obbligatorio';
		$trad_en = '"Phone" field is required';
		$trad_de = 'Feld "Telefon" ist erforderlich';
		$trad_fr = 'Le champ "Téléphone" est obligatoire';
		$trad_es = 'El campo "Teléfono" es obligatorio';
	}

	if($testo == 'Inserire un indirizzo email corretto'){
		$trad_it = 'Inserire un indirizzo email corretto';
		$trad_en = 'Enter a valid email address';
		$trad_de = 'Geben Sie eine gültige E-Mail-Adresse ein';
		$trad_fr = 'Entrez une adresse e-mail valide';
		$trad_es = 'Introduzca una dirección de correo electrónico válida';
	}

	if($testo == 'Campo "Password" obbigatorio'){
		$trad_it = 'Campo "Password" obbligatorio';
		$trad_en = '"Password" field is required';
		$trad_de = 'Feld "Passwort" ist erforderlich';
		$trad_fr = 'Le champ "Mot de passe" est obligatoire';
		$trad_es = 'El campo "Contraseña" es obligatorio';
	}

	if($testo == 'Campo "Ripeti password" obbigatorio'){
		$trad_it = 'Campo "Ripeti password" obbligatorio';
		$trad_en = '"Repeat Password" field is required';
		$trad_de = 'Feld "Passwort wiederholen" ist erforderlich';
		$trad_fr = 'Le champ "Répétez le mot de passe" est obligatoire';
		$trad_es = 'El campo "Repetir Contraseña" es obligatorio';
	}

	if($testo == 'I campi "Password" e "Ripeti password" non coincidono'){
		$trad_it = 'I campi "Password" e "Ripeti password" non coincidono';
		$trad_en = 'The "Password" and "Repeat Password" fields do not match';
		$trad_de = 'Die Felder "Passwort" und "Passwort wiederholen" stimmen nicht überein';
		$trad_fr = 'Les champs "Mot de passe" et "Répétez le mot de passe" ne correspondent pas';
		$trad_es = 'Los campos "Contraseña" y "Repetir Contraseña" no coinciden';
	}

	if($testo == 'Campo "Autorizzo al trattamento dei dati personali" obbigatorio'){
		$trad_it = 'Campo "Autorizzo al trattamento dei dati personali" obbligatorio';
		$trad_en = '"I authorize the processing of personal data" field is required';
		$trad_de = 'Feld "Ich erlaube die Verarbeitung personenbezogener Daten" ist erforderlich';
		$trad_fr = 'Le champ "J\'autorise le traitement des données personnelles" est obligatoire';
		$trad_es = 'El campo "Autorizo el tratamiento de datos personales" es obligatorio';
	}

		if($testo == "Attenzione"){
		$trad_it = 'ATTENZIONE!';
		$trad_en = 'WARNING!';
		$trad_de = 'ACHTUNG!';
		$trad_fr = 'ATTENTION!';
		$trad_es = '¡ATENCIÓN!';
	}

	if($testo == "Codice di verifica errato"){
		$trad_it = 'CODICE DI VERIFICA ERRATO!';
		$trad_en = 'INCORRECT VERIFICATION CODE!';
		$trad_de = 'FALSCHER VERIFIZIERUNGSCODE!';
		$trad_fr = 'CODE DE VÉRIFICATION INCORRECT!';
		$trad_es = '¡CÓDIGO DE VERIFICACIÓN INCORRECTO!';
	}

	if($testo == "La password è stata aggiornata con successo"){
		$trad_it = 'La password è stata aggiornata con successo.<br/>Ora potrai accedere alla tua area riservata con la nuova password,<br/>ed acquistare i nostri prodotti.';
		$trad_en = 'The password has been successfully updated.<br/>You can now access your reserved area with the new password,<br/>and purchase our products.';
		$trad_de = 'Das Passwort wurde erfolgreich aktualisiert.<br/>Sie können nun mit dem neuen Passwort auf Ihren geschützten Bereich zugreifen,<br/>und unsere Produkte kaufen.';
		$trad_fr = 'Le mot de passe a été mis à jour avec succès.<br/>Vous pouvez maintenant accéder à votre espace réservé avec le nouveau mot de passe,<br/>et acheter nos produits.';
		$trad_es = 'La contraseña se ha actualizado con éxito.<br/>Ahora puedes acceder a tu área reservada con la nueva contraseña,<br/>y comprar nuestros productos.';
	}

	if($testo == "Non è possibile procedere con il cambio password"){
		$trad_it = '<b>ATTENZIONE!!<br/>
					Non è possibile procedere con il cambio password.<br/><br/>
					La mail inserita non corrisponde all\'account di cui si vuole cambiare la password.</b>';
		$trad_en = '<b>WARNING!!<br/>
					Unable to proceed with the password change.<br/><br/>
					The email entered does not match the account for which you want to change the password.</b>';
		$trad_de = '<b>ACHTUNG!!<br/>
					Passwortänderung nicht möglich.<br/><br/>
					Die eingegebene E-Mail-Adresse stimmt nicht mit dem Konto überein, dessen Passwort Sie ändern möchten.</b>';
		$trad_fr = '<b>ATTENTION!!<br/>
					Impossible de procéder au changement de mot de passe.<br/><br/>
					L\'e-mail saisie ne correspond pas au compte pour lequel vous souhaitez changer le mot de passe.</b>';
		$trad_es = '<b>¡ATENCIÓN!!<br/>
					No es posible proceder con el cambio de contraseña.<br/><br/>
					El correo electrónico ingresado no coincide con la cuenta para la que desea cambiar la contraseña.</b>';
	}

	if($testo == "Per poter aggiornare le tue credenziali di accesso"){
		$trad_it = 'Per poter aggiornare le tue credenziali di accesso, inserisci l\'E-mail per la quale hai chiesto il cambio password e inserisci quella nuova:';
		$trad_en = 'To update your login credentials, enter the email for which you requested the password change and enter the new one:';
		$trad_de = 'Um Ihre Anmeldedaten zu aktualisieren, geben Sie die E-Mail-Adresse ein, für die Sie die Passwortänderung angefordert haben, und geben Sie die neue ein:';
		$trad_fr = 'Pour mettre à jour vos identifiants de connexion, entrez l\'e-mail pour laquelle vous avez demandé le changement de mot de passe et entrez le nouveau :';
		$trad_es = 'Para actualizar sus credenciales de acceso, ingrese el correo electrónico para el cual solicitó el cambio de contraseña e ingrese el nuevo:';
	}

	if($testo == "Si prega di controllare il link ricevuto tramite email"){
		$trad_it = 'Errore!!<br/>
					Si prega di controllare il link ricevuto tramite email e riprovare<br/>o contattarci all\'indirizzo email ';
		$trad_en = 'Error!!<br/>
					Please check the link received via email and try again<br/>or contact us at the email address ';
		$trad_de = 'Fehler!!<br/>
					Bitte überprüfen Sie den per E-Mail erhaltenen Link und versuchen Sie es erneut<br/>oder kontaktieren Sie uns unter der E-Mail-Adresse ';
		$trad_fr = 'Erreur!!<br/>
					Veuillez vérifier le lien reçu par e-mail et réessayer<br/>ou contactez-nous à l\'adresse e-mail ';
		$trad_es = '¡Error!!<br/>
					Por favor, verifique el enlace recibido por correo electrónico e inténtelo de nuevo<br/>o contáctenos en la dirección de correo electrónico ';
	}

	if($testo == "Sei un Azienda"){
		$trad_it = "Sei un Azienda";
		$trad_en = 'Are you a company?';
		$trad_de = 'Sind Sie ein Unternehmen?';
		$trad_fr = 'Êtes-vous une entreprise?';
		$trad_es = '¿Es usted una empresa?';
	}

	if($testo == "No"){
		$trad_it = "No";
		$trad_en = 'No';
		$trad_de = 'Nein';
		$trad_fr = 'Non';
		$trad_es = 'No';
	}

	if($testo == "Sì"){
		$trad_it = "Sì";
		$trad_en = 'Yes';
		$trad_de = 'Ja';
		$trad_fr = 'Oui';
		$trad_es = 'Sí';
	}

	if($testo == "Rag. sociale **"){
		$trad_it = "Rag. sociale **";
		$trad_en = 'Company Name **';
		$trad_de = 'Firmenname **';
		$trad_fr = 'Nom de l\'entreprise **';
		$trad_es = 'Nombre de la empresa **';
	}

	if($testo == "Rag. sociale"){
		$trad_it = "Rag. sociale";
		$trad_en = 'Company Name';
		$trad_de = 'Firmenname';
		$trad_fr = 'Nom de l\'entreprise';
		$trad_es = 'Nombre de la empresa';
	}

	if($testo == "Partita IVA ***"){
		$trad_it = "Partita IVA ***";
		$trad_en = 'VAT Number ***';
		$trad_de = 'Umsatzsteuer-ID ***';
		$trad_fr = 'Numéro de TVA ***';
		$trad_es = 'Número de IVA ***';
	}

	if($testo == "Codice Fiscale"){
		$trad_it = "Codice Fiscale";
		$trad_en = 'Tax Code';
		$trad_de = 'Steueridentifikationsnummer';
		$trad_fr = 'Code Fiscal';
		$trad_es = 'Código Fiscal';
	}

	if($testo == "Inserisci Codice Fiscale"){
		$trad_it = "Inserisci Codice Fiscale";
		$trad_en = 'Enter Tax Code';
		$trad_de = 'Steueridentifikationsnummer eingeben';
		$trad_fr = 'Entrez le code fiscal';
		$trad_es = 'Ingrese el código fiscal';
	}


		if($testo == "Nome Azienda"){
		$trad_it = "Nome Azienda";
		$trad_en = "Company Name";
		$trad_de = "Firmenname";
		$trad_fr = "Nom de l'entreprise";
		$trad_es = "Nombre de la Empresa";
	}

	if($testo == "Inserisci Nome Azienda"){
		$trad_it = "Inserisci Nome Azienda";
		$trad_en = "Enter Company Name";
		$trad_de = "Firmenname eingeben";
		$trad_fr = "Entrez le nom de l'entreprise";
		$trad_es = "Ingrese el nombre de la empresa";
	}

	if($testo == "Partita IVA"){
		$trad_it = "Partita IVA";
		$trad_en = "VAT Number";
		$trad_de = "Umsatzsteuer-ID";
		$trad_fr = "Numéro de TVA";
		$trad_es = "Número de IVA";
	}

	if($testo == "Inserisci Partita IVA"){
		$trad_it = "Inserisci Partita IVA";
		$trad_en = "Enter VAT Number";
		$trad_de = "Umsatzsteuer-ID eingeben";
		$trad_fr = "Entrez le numéro de TVA";
		$trad_es = "Ingrese el número de IVA";
	}

	if($testo == "Codice SDI o PEC"){
		$trad_it = "Codice SDI o PEC";
		$trad_en = "SDI Code or PEC Email";
		$trad_de = "SDI-Code oder PEC-E-Mail";
		$trad_fr = "Code SDI ou Email PEC";
		$trad_es = "Código SDI o Correo Electrónico PEC";
	}

	if($testo == "Inserisci Codice SDI o PEC"){
		$trad_it = "Inserisci Codice SDI o PEC";
		$trad_en = "Enter SDI Code or PEC Email";
		$trad_de = "SDI-Code oder PEC-E-Mail eingeben";
		$trad_fr = "Entrez le code SDI ou l'email PEC";
		$trad_es = "Ingrese el código SDI o el correo electrónico PEC";
	}

	if($testo == "Cod. Fiscale *"){
		$trad_it = "Cod. Fiscale *";
		$trad_en = "Tax Code *";
		$trad_de = "Steueridentifikationsnummer *";
		$trad_fr = "Code Fiscal *";
		$trad_es = "Código Fiscal *";
	}

	if($testo == "Cod. Fiscale"){
		$trad_it = "Cod. Fiscale";
		$trad_en = "Tax Code";
		$trad_de = "Steueridentifikationsnummer";
		$trad_fr = "Code Fiscal";
		$trad_es = "Código Fiscal";
	}

	if($testo == "Cap *"){
		$trad_it = "Cap *";
		$trad_en = "Postal Code *";
		$trad_de = "Postleitzahl *";
		$trad_fr = "Code Postal *";
		$trad_es = "Código Postal *";
	}

	if($testo == "Cap"){
		$trad_it = "Cap";
		$trad_en = "Postal Code";
		$trad_de = "Postleitzahl";
		$trad_fr = "Code Postal";
		$trad_es = "Código Postal";
	}

	if($testo == "(*** campo obbligatorio, se presente la Ragione Sociale)"){
		$trad_it = "(*** campo obbligatorio, se presente la Ragione Sociale)";
		$trad_en = "(*** mandatory field if the Company Name is present)";
		$trad_de = "(*** Pflichtfeld, wenn der Firmenname vorhanden ist)";
		$trad_fr = "(*** champ obligatoire si le nom de l'entreprise est présent)";
		$trad_es = "(*** campo obligatorio si está presente el nombre de la empresa)";
	}

	if($testo == "Usa Dati Spedizione"){
		$trad_it = "Usa Dati Spedizione";
		$trad_en = "Use Shipping Data";
		$trad_de = "Versanddaten verwenden";
		$trad_fr = "Utiliser les données d'expédition";
		$trad_es = "Usar datos de envío";
	}

	if($testo == "Dati di fatturazione:"){
		$trad_it = "Dati di fatturazione:";
		$trad_en = "Billing Information:";
		$trad_de = "Rechnungsinformationen:";
		$trad_fr = "Informations de facturation:";
		$trad_es = "Información de facturación:";
	}
	
		
    if($testo == "Modifica dei dati avvenuta correttamente!"){
        $trad_it = "Modifica dei dati avvenuta correttamente!";
        $trad_en = "Data modification successful!";
        $trad_de = "Datenänderung erfolgreich!";
        $trad_fr = "Modification des données réussie!";
        $trad_es = "Modificación de datos exitosa!";
    }

    if($testo == "Attenzione! Modifica non riuscita! Riprovare più tardi."){
        $trad_it = "Attenzione! Modifica non riuscita! Riprovare più tardi.";
        $trad_en = "Warning! Modification failed! Try again later.";
        $trad_de = "Achtung! Änderung fehlgeschlagen! Versuchen Sie es später noch einmal.";
        $trad_fr = "Attention! Modification échouée! Réessayez plus tard.";
        $trad_es = "¡Atención! Modificación fallida! Inténtelo de nuevo más tarde.";
    }

    if($testo == "Utilizza il seguente form per modificare i tuoi dati:"){
        $trad_it = "Utilizza il seguente form per modificare i tuoi dati:";
        $trad_en = "Use the following form to update your data:";
        $trad_de = "Verwenden Sie das folgende Formular, um Ihre Daten zu aktualisieren:";
        $trad_fr = "Utilisez le formulaire suivant pour mettre à jour vos données :";
        $trad_es = "Utilice el siguiente formulario para actualizar sus datos:";
    }

    if($testo == "Nome: *"){
        $trad_it = "Nome: *";
        $trad_en = "Name: *";
        $trad_de = "Name: *";
        $trad_fr = "Nom: *";
        $trad_es = "Nombre: *";
    }

    if($testo == "Cognome: *"){
        $trad_it = "Cognome: *";
        $trad_en = "Surname: *";
        $trad_de = "Nachname: *";
        $trad_fr = "Prénom: *";
        $trad_es = "Apellido: *";
    }

    if($testo == "Inserisci Nome"){
        $trad_it = "Inserisci Nome";
        $trad_en = "Enter Name";
        $trad_de = "Namen eingeben";
        $trad_fr = "Entrez le nom";
        $trad_es = "Introduzca el nombre";
    }

    if($testo == "Inserisci Cognome"){
        $trad_it = "Inserisci Cognome";
        $trad_en = "Enter Surname";
        $trad_de = "Nachnamen eingeben";
        $trad_fr = "Entrez le prénom";
        $trad_es = "Introduzca el apellido";
    }

    if($testo == "E-mail: *"){
        $trad_it = "E-mail: *";
        $trad_en = "E-mail: *";
        $trad_de = "E-Mail: *";
        $trad_fr = "E-mail: *";
        $trad_es = "Correo electrónico: *";
    }

    if($testo == "Inserisci E-mail"){
        $trad_it = "Inserisci E-mail";
        $trad_en = "Enter E-mail";
        $trad_de = "E-Mail eingeben";
        $trad_fr = "Entrez l'e-mail";
        $trad_es = "Introduzca el correo electrónico";
    }

    if($testo == "Iscriviti alla Newsletter"){
        $trad_it = "Iscriviti alla Newsletter";
        $trad_en = "Subscribe to the Newsletter";
        $trad_de = "Abonnieren Sie den Newsletter";
        $trad_fr = "Abonnez-vous à la newsletter";
        $trad_es = "Suscribirse al boletín";
    }

    if($testo == "Modifica"){
        $trad_it = "Modifica";
        $trad_en = "Modify";
        $trad_de = "Ändern";
        $trad_fr = "Modifier";
        $trad_es = "Modificar";
    }

    if($testo == 'Campo "Nome" obbligatorio'){
        $trad_it = 'Campo "Nome" obbligatorio';
        $trad_en = '"Name" field is mandatory';
        $trad_de = '"Name"-Feld ist obligatorisch';
        $trad_fr = 'Le champ "Nom" est obligatoire';
        $trad_es = 'El campo "Nombre" es obligatorio';
    }

    if($testo == 'Campo "Cognome" obbligatorio'){
        $trad_it = 'Campo "Cognome" obbligatorio';
        $trad_en = '"Surname" field is mandatory';
        $trad_de = '"Nachname"-Feld ist obligatorisch';
        $trad_fr = 'Le champ "Prénom" est obligatoire';
        $trad_es = 'El campo "Apellido" es obligatorio';
    }

    if($testo == 'Campo "E-mail" obbligatorio'){
        $trad_it = 'Campo "E-mail" obbligatorio';
        $trad_en = '"E-mail" field is mandatory';
        $trad_de = '"E-Mail"-Feld ist obligatorisch';
        $trad_fr = 'Le champ "E-mail" est obligatoire';
        $trad_es = 'El campo "Correo electrónico" es obligatorio';
    }

    if($testo == "Inserire un indirizzo email corretto"){
        $trad_it = "Inserire un indirizzo email corretto";
        $trad_en = "Enter a valid email address";
        $trad_de = "Geben Sie eine gültige E-Mail-Adresse ein";
        $trad_fr = "Entrez une adresse e-mail valide";
        $trad_es = "Introduzca una dirección de correo electrónico válida";
    }

    if($testo == "campi obbligatori"){
        $trad_it = "campi obbligatori";
        $trad_en = "mandatory fields";
        $trad_de = "Pflichtfelder";
        $trad_fr = "champs obligatoires";
        $trad_es = "campos obligatorios";
    }

    if($testo == "campo obbligatorio solo se la nazione selezionata è Italia"){
        $trad_it = "campo obbligatorio solo se la nazione selezionata è Italia";
        $trad_en = "field required only if the selected country is Italy";
        $trad_de = "Pflichtfeld nur, wenn das ausgewählte Land Italien ist";
        $trad_fr = "champ obligatoire uniquement si le pays sélectionné est l'Italie";
        $trad_es = "campo obligatorio solo si el país seleccionado es Italia";
    }
	
	if($testo == "I miei Dati di Spedizione"){
        $trad_it = "I miei Dati di Spedizione";
        $trad_en = "My Shipping Data";
        $trad_de = "Meine Versanddaten";
        $trad_fr = "Mes Données de Livraison";
        $trad_es = "Mis Datos de Envío";
    }

    if($testo == "Il Mio Account"){
        $trad_it = "Il Mio Account";
        $trad_en = "My Account";
        $trad_de = "Mein Konto";
        $trad_fr = "Mon Compte";
        $trad_es = "Mi Cuenta";
    }

    if($testo == "Modifica dei dati di fatturazione avvenuta correttamente!"){
        $trad_it = "Modifica dei dati di fatturazione avvenuta correttamente!";
        $trad_en = "Billing data modification successful!";
        $trad_de = "Rechnungsdaten erfolgreich geändert!";
        $trad_fr = "Modification des données de facturation réussie!";
        $trad_es = "¡Modificación de datos de facturación exitosa!";
    }

    if($testo == "Modifica dati di fatturazione non riuscita! Riprovare più tardi."){
        $trad_it = "Modifica dati di fatturazione non riuscita! Riprovare più tardi.";
        $trad_en = "Billing data modification failed! Try again later.";
        $trad_de = "Änderung der Rechnungsdaten fehlgeschlagen! Versuchen Sie es später noch einmal.";
        $trad_fr = "Échec de la modification des données de facturation ! Réessayez plus tard.";
        $trad_es = "¡Modificación de datos de facturación fallida! Inténtalo de nuevo más tarde.";
    }

    if($testo == "Modifica dei dati di spedizione avvenuta correttamente!"){
        $trad_it = "Modifica dei dati di spedizione avvenuta correttamente!";
        $trad_en = "Shipping data modification successful!";
        $trad_de = "Versanddaten erfolgreich geändert!";
        $trad_fr = "Modification des données de livraison réussie!";
        $trad_es = "¡Modificación de datos de envío exitosa!";
    }

    if($testo == "Modifica dati di spedizione non riuscita! Riprovare più tardi."){
        $trad_it = "Modifica dati di spedizione non riuscita! Riprovare più tardi.";
        $trad_en = "Shipping data modification failed! Try again later.";
        $trad_de = "Änderung der Versanddaten fehlgeschlagen! Versuchen Sie es später noch einmal.";
        $trad_fr = "Échec de la modification des données de livraison ! Réessayez plus tard.";
        $trad_es = "¡Modificación de datos de envío fallida! Inténtalo de nuevo más tarde.";
    }

    if($testo == "I Miei Dati di Spedizione e Fatturazione"){
        $trad_it = "I Miei Dati di Spedizione e Fatturazione";
        $trad_en = "My Shipping and Billing Data";
        $trad_de = "Meine Versand- und Rechnungsdaten";
        $trad_fr = "Mes Données de Livraison et de Facturation";
        $trad_es = "Mis Datos de Envío y Facturación";
    }
	
	if($testo == "Nome **"){
        $trad_it = "Nome **";
        $trad_en = "Name: **";
        $trad_de = "Name: **";
        $trad_fr = "Nom: **";
        $trad_es = "Nombre: **";
    }

    if($testo == "Cognome: *"){
        $trad_it = "Cognome: *";
        $trad_en = "Surname: *";
        $trad_de = "Nachname: *";
        $trad_fr = "Prénom: *";
        $trad_es = "Apellido: *";
    }
	
    if($testo == "Utilizza il seguente form per modificare i tuoi dati di spedizione e/o fatturazione:"){
        $trad_it = "Utilizza il seguente form per modificare i tuoi dati di spedizione e/o fatturazione:";
        $trad_en = "Use the following form to update your shipping and/or billing data:";
        $trad_de = "Verwenden Sie das folgende Formular, um Ihre Versand- und/oder Rechnungsdaten zu aktualisieren:";
        $trad_fr = "Utilisez le formulaire suivant pour mettre à jour vos données de livraison et/ou de facturation :";
        $trad_es = "Utilice el siguiente formulario para actualizar sus datos de envío y/o facturación:";
    }

    if($testo == "Dati di spedizione:"){
        $trad_it = "Dati di spedizione:";
        $trad_en = "Shipping Data:";
        $trad_de = "Versanddaten:";
        $trad_fr = "Données de Livraison :";
        $trad_es = "Datos de Envío:";
    }

    if($testo == "Dati spedizione"){
        $trad_it = "Dati spedizione";
        $trad_en = "Shipping Data";
        $trad_de = "Versanddaten";
        $trad_fr = "Données de Livraison";
        $trad_es = "Datos de Envío";
    }

    if($testo == "Nome *"){
        $trad_it = "Nome *";
        $trad_en = "Name *";
        $trad_de = "Name *";
        $trad_fr = "Nom *";
        $trad_es = "Nombre *";
    }

    if($testo == "Nome"){
        $trad_it = "Nome";
        $trad_en = "Name";
        $trad_de = "Name";
        $trad_fr = "Nom";
        $trad_es = "Nombre";
    }

    if($testo == "Cognome *"){
        $trad_it = "Cognome *";
        $trad_en = "Surname *";
        $trad_de = "Nachname *";
        $trad_fr = "Prénom *";
        $trad_es = "Apellido *";
    }

    if($testo == "Cognome"){
        $trad_it = "Cognome";
        $trad_en = "Surname";
        $trad_de = "Nachname";
        $trad_fr = "Prénom";
        $trad_es = "Apellidp";
    }

    if($testo == "Indirizzo *"){
        $trad_it = "Indirizzo *";
        $trad_en = "Address *";
        $trad_de = "Adresse *";
        $trad_fr = "Adresse *";
        $trad_es = "Dirección *";
    }

    if($testo == "Indirizzo"){
        $trad_it = "Indirizzo";
        $trad_en = "Address";
        $trad_de = "Adresse";
        $trad_fr = "Adresse";
        $trad_es = "Dirección";
    }

    if($testo == "CAP *"){
        $trad_it = "CAP *";
        $trad_en = "ZIP Code *";
        $trad_de = "PLZ *";
        $trad_fr = "Code Postal *";
        $trad_es = "Código Postal *";
    }

    if($testo == "Città *"){
        $trad_it = "Città *";
        $trad_en = "City *";
        $trad_de = "Stadt *";
        $trad_fr = "Ville *";
        $trad_es = "Ciudad *";
    }

    if($testo == "Città"){
        $trad_it = "Città";
        $trad_en = "City";
        $trad_de = "Stadt";
        $trad_fr = "Ville";
        $trad_es = "Ciudad";
    }

    if($testo == "Provincia *"){
        $trad_it = "Provincia *";
        $trad_en = "Province *";
        $trad_de = "Provinz *";
        $trad_fr = "Province *";
        $trad_es = "Provincia *";
    }

    if($testo == "Provincia"){
        $trad_it = "Provincia";
        $trad_en = "Province";
        $trad_de = "Provinz";
        $trad_fr = "Province";
        $trad_es = "Provincia";
    }

    if($testo == "Nazione *"){
        $trad_it = "Nazione *";
        $trad_en = "Country *";
        $trad_de = "Land *";
        $trad_fr = "Pays *";
        $trad_es = "País *";
    }

    if($testo == "Nazione"){
        $trad_it = "Nazione";
        $trad_en = "Country";
        $trad_de = "Land";
        $trad_fr = "Pays";
        $trad_es = "País";
    }

    if($testo == "Telefono"){
        $trad_it = "Telefono";
        $trad_en = "Phone";
        $trad_de = "Telefon";
        $trad_fr = "Téléphone";
        $trad_es = "Teléfono";
    }

    if($testo == "Email"){
        $trad_it = "Email";
        $trad_en = "Email";
        $trad_de = "E-Mail";
        $trad_fr = "E-mail";
        $trad_es = "Correo Electrónico";
    }

    if($testo == "(* campi obbligatori)"){
        $trad_it = "(* campi obbligatori)";
        $trad_en = "(* mandatory fields)";
        $trad_de = "(* Pflichtfelder)";
        $trad_fr = "(* champs obligatoires)";
        $trad_es = "(* campos obligatorios)";
    }

    if($testo == "Usa Dati Account"){
        $trad_it = "Usa Dati Account";
        $trad_en = "Use Account Data";
        $trad_de = "Kontodaten verwenden";
        $trad_fr = "Utiliser les Données du Compte";
        $trad_es = "Usar Datos de la Cuenta";
    }

    if($testo == "Modifica dati"){
        $trad_it = "Modifica dati";
        $trad_en = "Modify Data";
        $trad_de = "Daten ändern";
        $trad_fr = "Modifier les Données";
        $trad_es = "Modificar Datos";
    }

    if($testo == '"Nome" o "Rag. sociale" obbligatori'){
        $trad_it = '"Nome" o "Rag. sociale" obbligatori';
        $trad_en = '"Name" or "Company Name" mandatory';
        $trad_de = '"Name" oder "Firma" erforderlich';
        $trad_fr = '"Nom" ou "Raison sociale" obligatoires';
        $trad_es = '"Nombre" o "Nombre de la empresa" obligatorios';
    }

    if($testo == '"Cognome" obbligatorio'){
        $trad_it = '"Cognome" obbligatorio';
        $trad_en = '"Surname" mandatory';
        $trad_de = '"Nachname" erforderlich';
        $trad_fr = '"Prénom" obligatoire';
        $trad_es = '"Apellido" obligatorio';
    }

    if($testo == 'Se presente la Ragione Sociale inserire una Partita IVA'){
        $trad_it = 'Se presente la Ragione Sociale inserire una Partita IVA';
        $trad_en = 'If the Company Name is present, enter a VAT Number';
        $trad_de = 'Wenn der Firmenname vorhanden ist, geben Sie eine Umsatzsteuer-Identifikationsnummer ein';
        $trad_fr = 'Si la Raison sociale est présente, entrez un numéro de TVA';
        $trad_es = 'Si está presente el Nombre de la empresa, ingrese un número de IVA';
    }

    if($testo == 'Campo "Codice fiscale" obbligatorio'){
        $trad_it = 'Campo "Codice fiscale" obbligatorio';
        $trad_en = '"Tax Code" field mandatory';
        $trad_de = 'Feld "Steueridentifikationsnummer" erforderlich';
        $trad_fr = 'Champ "Code fiscal" obligatoire';
        $trad_es = 'Campo "Código fiscal" obligatorio';
    }

    if($testo == 'Campo "Indirizzo" obbligatorio'){
        $trad_it = 'Campo "Indirizzo" obbligatorio';
        $trad_en = '"Address" field mandatory';
        $trad_de = 'Feld "Adresse" erforderlich';
        $trad_fr = 'Champ "Adresse" obligatoire';
        $trad_es = 'Campo "Dirección" obligatorio';
    }

    if($testo == 'Campo "Cap" obbligatorio'){
        $trad_it = 'Campo "Cap" obbligatorio';
        $trad_en = '"ZIP Code" field mandatory';
        $trad_de = 'Feld "PLZ" erforderlich';
        $trad_fr = 'Champ "Code postal" obligatoire';
        $trad_es = 'Campo "Código postal" obligatorio';
    }

    if($testo == 'Campo "Città" obbligatorio'){
        $trad_it = 'Campo "Città" obbligatorio';
        $trad_en = '"City" field mandatory';
        $trad_de = 'Feld "Stadt" erforderlich';
        $trad_fr = 'Champ "Ville" obligatoire';
        $trad_es = 'Campo "Ciudad" obligatorio';
    }

    if($testo == 'Campo "Provincia" obbligatorio'){
        $trad_it = 'Campo "Provincia" obbligatorio';
        $trad_en = '"Province" field mandatory';
        $trad_de = 'Feld "Provinz" erforderlich';
        $trad_fr = 'Champ "Province" obligatoire';
        $trad_es = 'Campo "Provincia" obligatorio';
    }

    if($testo == 'Campo "Nazione" obbligatorio'){
        $trad_it = 'Campo "Nazione" obbligatorio';
        $trad_en = '"Country" field mandatory';
        $trad_de = 'Feld "Land" erforderlich';
        $trad_fr = 'Champ "Pays" obligatoire';
        $trad_es = 'Campo "País" obligatorio';
    }

    if($testo == 'Inserire un numero telefonico corretto (solo numeri)'){
        $trad_it = 'Inserire un numero telefonico corretto (solo numeri)';
        $trad_en = 'Enter a valid phone number (numbers only)';
        $trad_de = 'Geben Sie eine gültige Telefonnummer ein (nur Zahlen)';
        $trad_fr = 'Entrez un numéro de téléphone valide (chiffres uniquement)';
        $trad_es = 'Ingrese un número de teléfono válido (solo números)';
    }

    if($testo == 'Inserire un indirizzo email corretto'){
        $trad_it = 'Inserire un indirizzo email corretto';
        $trad_en = 'Enter a valid email address';
        $trad_de = 'Geben Sie eine gültige E-Mail-Adresse ein';
        $trad_fr = 'Entrez une adresse e-mail valide';
        $trad_es = 'Ingrese una dirección de correo electrónico válida';
    }

    if($testo == '(** uno dei due campi è obbligatorio)'){
        $trad_it = '(** uno dei due campi è obbligatorio)';
        $trad_en = '(** one of the two fields is mandatory)';
        $trad_de = '(** eines der beiden Felder ist obligatorisch)';
        $trad_fr = '(** l\'un des deux champs est obligatoire)';
        $trad_es = '(** uno de los dos campos es obligatorio)';
    }

    if($testo == '(***) campo obbligatorio, se presente la Ragione Sociale'){
        $trad_it = '(***) campo obbligatorio, se presente la Ragione Sociale';
        $trad_en = '(***) mandatory field, if Company Name is present';
        $trad_de = '(***) Pflichtfeld, wenn Firmenname vorhanden ist';
        $trad_fr = '(***) champ obligatoire, si la Raison sociale est présente';
        $trad_es = '(***) campo obligatorio, si está presente el Nombre de la empresa';
    }

    if($testo == 'IN EVIDENZA'){
        $trad_it = "IN EVIDENZA";
        $trad_en = 'FEATURED PRODUCTS';
        $trad_de = 'AUSGEWÄHLTE PRODUKTE';
        $trad_fr = 'PRODUITS POPULAIRES';
        $trad_es = 'PRODUCTOS DESTACADOS';
    }

    if($testo == 'OFFERTE SPECIALI'){
        $trad_it = "OFFERTE SPECIALI";
        $trad_en = 'TIMED OFFERS';
        $trad_de = 'ANGEBOTE';
        $trad_fr = 'NOS OFFRES';
        $trad_es = 'OFERTAS';
    }

    if($testo == 'Categorie'){
        $trad_it = "Categorie";
        $trad_en = 'Categories';
        $trad_de = 'Kategorien';
        $trad_fr = 'Catégories';
        $trad_es = 'Categorías';
    }

    if($testo == 'CATEGORIE'){
        $trad_it = "CATEGORIE";
        $trad_en = 'CATEGORIES';
        $trad_de = 'KATEGORIEN';
        $trad_fr = 'CATÉGORIES';
        $trad_es = 'CATEGORÍAS';
    }

    if($testo == 'Categorie Prodotti'){
        $trad_it = "Categorie Prodotti";
        $trad_en = 'Product Categories';
        $trad_de = 'Produktkategorien';
        $trad_fr = 'Catégories de Produits';
        $trad_es = 'Categorías de Productos';
    }

    if($testo == 'Ricerca'){
        $trad_it = "Ricerca";
        $trad_en = 'Search';
        $trad_de = 'Suche';
        $trad_fr = 'Recherche';
        $trad_es = 'Búsqueda';
    }

    if($testo == 'Chi Siamo'){
        $trad_it = "Chi Siamo";
        $trad_en = 'About Us';
        $trad_de = 'Über uns';
        $trad_fr = 'À propos de nous';
        $trad_es = 'Quiénes somos';
    }
	
	if($testo == "Account"){
        $trad_it = "Account";
        $trad_en = "Account";
        $trad_de = "Konto";
        $trad_fr = "Compte";
        $trad_es = "Cuenta";
    }

    if($testo == 'CERTIFICATO ONLINE'){
        $trad_it = "CERTIFICATO ONLINE";
        $trad_en = 'ONLINE CERTIFICATE';
        $trad_de = 'ONLINE-ZERTIFIKAT';
        $trad_fr = 'CERTIFICAT EN LIGNE';
        $trad_es = 'CERTIFICADO EN LÍNEA';
    }

    if($testo == 'Per monete, medaglie e cartamoneta'){
        $trad_it = "Per monete, medaglie e cartamoneta";
        $trad_en = 'For coins, medals, and banknotes';
        $trad_de = 'Für Münzen, Medaillen und Banknoten';
        $trad_fr = 'Pour les pièces, médailles et billets';
        $trad_es = 'Para monedas, medallas y billetes';
    }

    if($testo == 'SEGUICI'){
        $trad_it = "SEGUICI";
        $trad_en = 'FOLLOW US';
        $trad_de = 'FOLGEN SIE UNS';
        $trad_fr = 'SUIVEZ-NOUS';
        $trad_es = 'SÍGUENOS';
    }

    if($testo == 'Seguici su'){
        $trad_it = "Seguici su";
        $trad_en = 'Follow us on';
        $trad_de = 'Folgen Sie uns auf';
        $trad_fr = 'Suivez-nous sur';
        $trad_es = 'Síguenos en';
    }

    if($testo == 'sulle nostre pagine social'){
        $trad_it = "sulle nostre pagine social";
        $trad_en = 'on our social pages';
        $trad_de = 'uns auf unseren Social-Media-Seiten';
        $trad_fr = 'suivez-nous sur nos pages sociales';
        $trad_es = 'síguenos en nuestras páginas sociales';
    }

    if($testo == 'dettagli'){
        $trad_it = "dettagli";
        $trad_en = 'details';
        $trad_de = 'details';
        $trad_fr = 'détails';
        $trad_es = 'detalles';
    }

    if($testo == 'NEWSLETTER'){
        $trad_it = "NEWSLETTER";
        $trad_en = 'NEWSLETTER';
        $trad_de = 'NEWSLETTER';
        $trad_fr = 'NEWSLETTER';
        $trad_es = 'NEWSLETTER';
    }

    if($testo == 'Iscriviti alla nostra newsletter per essere sempre aggiornato sulle nostre novità'){
        $trad_it = "Iscriviti alla nostra newsletter per essere sempre aggiornato sulle nostre novità";
        $trad_en = 'Subscribe to our newsletter to stay updated on our latest news';
        $trad_de = 'Abonnieren Sie unseren Newsletter, um über unsere neuesten Nachrichten informiert zu bleiben';
        $trad_fr = 'Inscrivez-vous à notre newsletter pour rester informé de nos nouveautés';
        $trad_es = 'Suscríbete a nuestro boletín para estar siempre al tanto de nuestras novedades';
    }

    if($testo == 'ISCRIVITI'){
        $trad_it = "ISCRIVITI";
        $trad_en = 'SUBSCRIBE';
        $trad_de = 'ABONNIEREN';
        $trad_fr = "S'INSCRIRE";
        $trad_es = 'SUSCRIBIRSE';
    }

    if($testo == 'offerta'){
        $trad_it = "offerta";
        $trad_en = 'offer';
        $trad_de = 'angebot';
        $trad_fr = "offre";
        $trad_es = 'oferta';
    }

    if($testo == 'Condividi'){
        $trad_it = "Condividi";
        $trad_en = 'Share';
        $trad_de = 'Teilen';
        $trad_fr = "Partager";
        $trad_es = 'Compartir';
    }

    if($testo == 'Prodotti'){
        $trad_it = "Prodotti";
        $trad_en = 'Products';
        $trad_de = 'Produkte';
        $trad_fr = "Produits";
        $trad_es = 'Productos';
    }

    if($testo == 'Prodotti correlati'){
        $trad_it = "Prodotti correlati";
        $trad_en = 'Related Products';
        $trad_de = 'Verwandte Produkte';
        $trad_fr = "Produits Connexes";
        $trad_es = 'Productos Relacionados';
    }

    if($testo == 'DISPONIBILITÀ'){
        $trad_it = "DISPONIBILITÀ";
        $trad_en = 'AVAILABILITY';
        $trad_de = 'VERFÜGBARKEIT';
        $trad_fr = "DISPONIBILITÉ";
        $trad_es = 'DISPONIBILIDAD';
    }

    if($testo == 'DISPONIBILE'){
        $trad_it = "DISPONIBILE";
        $trad_en = 'AVAILABLE';
        $trad_de = 'VERFÜGBAR';
        $trad_fr = "DISPONIBLE";
        $trad_es = 'DISPONIBLE';
    }

    if($testo == 'NON DISPONIBILE'){
        $trad_it = "NON DISPONIBILE";
        $trad_en = 'NOT AVAILABLE';
        $trad_de = 'NICHT VERFÜGBAR';
        $trad_fr = "NON DISPONIBLE";
        $trad_es = 'NO DISPONIBLE';
    }

    if($testo == 'Lingua'){
        $trad_it = "Lingua";
        $trad_en = 'Language';
        $trad_de = 'Sprache';
        $trad_fr = 'Langue';
        $trad_es = 'Idioma';
    }

    if($testo == 'Carrello'){
        $trad_it = "Carrello";
        $trad_en = 'Cart';
        $trad_de = 'Warenkorb';
        $trad_fr = 'Panier';
        $trad_es = 'Carrito';
    }

    if($testo == "CLIENTE REGISTRATO"){
        $trad_it = "CLIENTE REGISTRATO";
        $trad_en = 'Registered Customers';
        $trad_de = 'Registrierte Kunden';
        $trad_fr = 'Clients enregistrés';
        $trad_es = 'Clientes registrados';
    }

    if($testo == "NUOVO CLIENTE"){
        $trad_it = "NUOVO CLIENTE";
        $trad_en = 'New Customers';
        $trad_de = 'Neue Kunden';
        $trad_fr = 'Nouveaux clients';
        $trad_es = 'Nuevos clientes';
    }

    if($testo == "riepilogo"){
        $trad_it = "riepilogo";
        $trad_en = 'summary';
        $trad_de = 'zusammenfassung';
        $trad_fr = 'résumé';
        $trad_es = 'resumen';
    }

    if($testo == "checkout/riepilogo"){
        $trad_it = "checkout/riepilogo";
        $trad_en = 'checkout/summary';
        $trad_de = 'checkout/zusammenfassung';
        $trad_fr = 'checkout/resume';
        $trad_es = 'checkout/resumen';
    }

    if($testo == "esito"){
        $trad_it = "esito";
        $trad_en = 'outcome';
        $trad_de = 'ergebnis';
        $trad_fr = 'resultat';
        $trad_es = 'resultado';
    }

    if($testo == "Il tuo ordine è stato correttamente registrato"){
        $trad_it = "Il tuo ordine è stato correttamente registrato";
        $trad_en = 'Your order has been successfully recorded';
        $trad_de = 'Ihre Bestellung wurde erfolgreich registriert';
        $trad_fr = 'Votre commande a été enregistrée avec succès';
        $trad_es = ' pedido ha sido registrado correctamente';
    }

    if($testo == "ordine n."){
        $trad_it = "ordine n.";
        $trad_en = 'order no.';
        $trad_de = 'Bestellung Nr.';
        $trad_fr = 'commande n°';
        $trad_es = 'pedido n.º';
    }

    if($testo == "Ora puoi procedere al pagamento"){
        $trad_it = "Ora puoi procedere al pagamento";
        $trad_en = 'You can now proceed to payment';
        $trad_de = 'Sie können jetzt mit der Zahlung fortfahren';
        $trad_fr = 'Vous pouvez maintenant procéder au paiement';
        $trad_es = 'Ahora puedes proceder al pago';
    }

    if($testo == "Ti aspettiamo presso la nostra sede"){
        $trad_it = "Ti aspettiamo presso la nostra sede";
        $trad_en = 'We look forward to seeing you at our headquarters';
        $trad_de = 'Wir erwarten Sie in unserer Zentrale';
        $trad_fr = 'Nous vous attendons dans nos locaux';
        $trad_es = 'Te esperamos en nuestra sede';
    }

    if($testo == "I dati per effettuare il bonifico bancario sono i seguenti"){
        $trad_it = "I dati per effettuare il <b>bonifico bancario</b> sono i seguenti";
        $trad_en = 'The details for making the <b>bank transfer</b> are as follows';
        $trad_de = 'Die Daten für die <b>Banküberweisung</b> sind wie folgt';
        $trad_fr = 'Les détails pour effectuer le <b>virement bancaire</b> sont les suivants';
        $trad_es = 'Los datos para realizar la <b>transferencia bancaria</b> son los siguientes';
    }

    if($testo == "ATTENDERE PREGO"){
        $trad_it = "ATTENDERE PREGO";
        $trad_en = 'PLEASE WAIT';
        $trad_de = 'BITTE WARTEN';
        $trad_fr = 'VEUILLEZ PATIENTER';
        $trad_es = 'POR FAVOR, ESPERE';
    }

    if($testo == "tra qualche secondo verrà reindirizzato alla pagina contenente il modulo di pagamento di Paypal"){
        $trad_it = "tra qualche secondo verrà reindirizzato alla pagina contenente il modulo di pagamento di Paypal";
        $trad_en = 'You will be redirected to the page containing the PayPal payment form in a few seconds';
        $trad_de = 'Sie werden in wenigen Sekunden zur Seite mit dem PayPal-Zahlungsformular weitergeleitet';
        $trad_fr = 'Vous serez redirigé vers la page contenant le formulaire de paiement PayPal dans quelques secondes';
        $trad_es = 'En unos segundos será redirigido a la página con el formulario de pago de PayPal.';
    }

    if($testo == "ATTENZIONE"){
        $trad_it = "ATTENZIONE";
        $trad_en = 'ATTENTION';
        $trad_de = 'ACHTUNG';
        $trad_fr = 'ATTENTION ';
        $trad_es = '¡ATENCIÓN';
    }

    if($testo == "Per problemi tecnici non è stato possibile registrare il suo ordine"){
        $trad_it = "Per problemi tecnici non è stato possibile registrare il suo ordine";
        $trad_en = 'Due to technical issues, it was not possible to record your order.';
        $trad_de = 'Aufgrund technischer Probleme konnte Ihre Bestellung nicht registriert werden.';
        $trad_fr = "En raison de problèmes techniques, il n'a pas été possible d'enregistrer votre commande.";
        $trad_es = 'Debido a problemas técnicos, no fue posible registrar su pedido.';
    }

    if($testo == "La preghiamo di riprovare"){
        $trad_it = "La preghiamo di riprovare";
        $trad_en = 'Please try again';
        $trad_de = 'Bitte versuchen Sie es erneut';
        $trad_fr = 'Veuillez réessayer';
        $trad_es = '¡Por favor, inténtelo de nuevo';
    }

    if($testo == "Condizioni di Vendita"){
        $trad_it = "Condizioni di Vendita";
        $trad_en = 'Terms and conditions of sale';
        $trad_de = 'Verkaufsbedingungen';
        $trad_fr = 'Conditions de vente';
        $trad_es = 'Condiciones de venta';
    }

    if($testo == "L'attestato di garanzia e provenienza"){
        $trad_it = "L'attestato di garanzia e provenienza";
        $trad_en = 'Attestation of guarantee and provenance';
        $trad_de = 'Garantie- und Herkunftsbescheinigungen';
        $trad_fr = 'Attestations de garantie et provenance';
        $trad_es = 'Certificados de garantía y de origen';
    }

    if($testo == "Le abbreviazioni"){
        $trad_it = "Le abbreviazioni";
        $trad_en = 'Abbreviations concerning banknotes';
        $trad_de = 'Abkürzungen für die Banknoten';
        $trad_fr = 'Les abréviations des papiers monnaies';
        $trad_es = 'La abreviatura de los billetes';
    }

    if($testo == "La garanzia Moruzzi Numismatica"){
        $trad_it = "La garanzia Moruzzi Numismatica";
        $trad_en = 'Guarantee Moruzzi Numismatica';
        $trad_de = 'Die Garantie Moruzzi Numismatik';
        $trad_fr = 'Garantie Moruzzi Numismatica';
        $trad_es = 'La Garantía Moruzzi Numismatica';
    }

    if($testo == "Collezionare monete antiche in Italia"){
        $trad_it = "Collezionare monete antiche in Italia";
        $trad_en = 'Collecting ancient coins in Italy';
        $trad_de = 'Antike Münzsammlungen in Italien';
        $trad_fr = 'Collectionner monnaies antiques en Italie';
        $trad_es = 'Coleccionar monedas antiguas en Italia';
    }

    if($testo == "Iscriviti alla Newsletter"){
        $trad_it = "Iscriviti alla Newsletter";
        $trad_en = 'Subscribe to the Newsletter';
        $trad_de = 'Abonnieren Sie den Newsletter';
        $trad_fr = 'Abonnez-vous à la Newsletter';
        $trad_es = 'Suscríbete al boletín';
    }

    if($testo == "Rimani aggiornato su tutte le ultime novità"){
        $trad_it = "Rimani aggiornato su tutte le ultime novità";
        $trad_en = 'Stay updated on all the latest news';
        $trad_de = 'Bleiben Sie über alle Neuigkeiten informiert';
        $trad_fr = 'Restez informé de toutes les dernières nouveautés';
        $trad_es = '¡Mantente al tanto de todas las últimas novedades';
    }

    if($testo == "Sei stato iscritto alla nostra newsletter"){
        $trad_it = "Sei stato iscritto alla nostra newsletter!";
        $trad_en = 'You have been subscribed to our newsletter!';
        $trad_de = 'Sie wurden in unseren Newsletter eingetragen!';
        $trad_fr = 'Vous avez été inscrit à notre newsletter!';
        $trad_es = '¡Te has suscrito a nuestro boletín!';
    }

    if($testo == "ATTENZIONE! Email già iscritta alla nostra newsletter"){
        $trad_it = "ATTENZIONE! Email già iscritta alla nostra newsletter";
        $trad_en = 'ATTENTION! Email already subscribed to our newsletter';
        $trad_de = 'ACHTUNG! Diese E-Mail-Adresse ist bereits für unseren Newsletter registriert';
        $trad_fr = 'ATTENTION ! Cette adresse email est déjà inscrite à notre newsletter';
        $trad_es = '¡ATENCIÓN! Este correo electrónico ya está suscrito a nuestro boletín';
    }

    if($testo == "Benvenuto"){
        $trad_it = "Benvenuto";
        $trad_en = 'Welcome';
        $trad_de = 'Willkommen';
        $trad_fr = 'Bienvenue';
        $trad_es = 'Bienvenido';
    }

    if($testo == "Menu"){
        $trad_it = "Menu";
        $trad_en = 'Menu';
        $trad_de = 'Menü';
        $trad_fr = 'Menu';
        $trad_es = 'Menú';
    }

    if($testo == "Sito Ufficiale"){
        $trad_it = "Sito Ufficiale";
        $trad_en = 'Official Website';
        $trad_de = 'Offizielle Webseite';
        $trad_fr = 'Site Officiel';
        $trad_es = 'Sitio Oficial';
    }

    if($testo == "Contatti"){
        $trad_it = "Contatti";
        $trad_en = 'Contacts';
        $trad_de = 'Kontakte';
        $trad_fr = 'Contacts';
        $trad_es = 'Contactos';
    }

    if($testo == "CONTATTACI"){
        $trad_it = "CONTATTACI";
        $trad_en = 'CONTACT US';
        $trad_de = 'KONTAKTIEREN SIE UNS';
        $trad_fr = 'CONTACTEZ-NOUS';
        $trad_es = 'CONTÁCTANOS';
    }

    if($testo == "FAQ"){
        $trad_it = "FAQ";
        $trad_en = 'FAQ';
        $trad_de = 'FAQ';
        $trad_fr = 'FAQ';
        $trad_es = 'FAQ';
    }

    if($testo == "Condizioni di Vendita"){
        $trad_it = "Condizioni di Vendita";
        $trad_en = 'Terms of Sale';
        $trad_de = 'Verkaufsbedingungen';
        $trad_fr = 'Conditions de Vente';
        $trad_es = 'Condiciones de Venta';
    }

    if($testo == "Ampia selezione di monete da collezione"){
        $trad_it = "Ampia selezione di monete da collezione antiche e moderne, medaglie papali, italiane e straniere, cartamoneta italiana e straniera, libri e pubblicazioni numismatiche, accessori, servizi peritali e certificazioni numismatiche.";
        $trad_en = 'Wide selection of ancient and modern collectible coins, papal, Italian, and foreign medals, Italian and foreign banknotes, numismatic books and publications, accessories, expert services, and numismatic certifications.';
        $trad_de = 'Große Auswahl an antiken und modernen Sammlermünzen, päpstlichen, italienischen und ausländischen Medaillen, italienischen und ausländischen Banknoten, numismatischen Büchern und Veröffentlichungen, Zubehör, Gutachterdiensten und numismatischen Zertifizierungen.';
        $trad_fr = 'Large sélection de pièces de monnaie de collection anciennes et modernes, médailles papales, italiennes et étrangères, billets italiens et étrangers, livres et publications numismatiques, accessoires, services d\'experts et certifications numismatiques.';
        $trad_es = 'Amplia selección de monedas de colección antiguas y modernas, medallas papales, italianas y extranjeras, billetes italianos y extranjeros, libros y publicaciones numismáticas, accesorios, servicios periciales y certificaciones numismáticas.';
    }
	
    if($testo == "testo home 1"){
        $trad_it = '
			Ampia selezione di <b>monete da collezione</b> antiche e moderne, <b>medaglie</b> papali, italiane e straniere, <b>cartamoneta</b> italiana e straniera, <b>libri</b> e <b>pubblicazioni</b> numismatiche, <b>accessori, servizi peritali e certificazioni numismatiche</b>.
			<br/><br/>
			<span style="color:#fff"><b>IMPORTANTE</b></span>: siamo membri della <b>IAPN-AINP</b> (Associazione Internazionale dei Numismatici Professionisti), dei <b>NIP</b> (Numismatici Italiani Professionisti) e della <b>Berufsverband des Deutschen Münzenfachhandels e.V</b> (associazione tedesca di numismatici).			
		';
        $trad_en = '
			Wide selection of ancient and modern <b>collectible coins</b>, papal, Italian and foreign <b>medals</b>, Italian and foreign <b>banknotes</b>, numismatic <b>books</b> and <b>publications</b>, <b>accessories, expert services, and numismatic certifications</b>.
			<br/><br/>
			<span style="color:#fff"><b>IMPORTANT</b></span>: we are members of the <b>IAPN-AINP</b> (International Association of Professional Numismatists), <b>NIP</b> (Professional Italian Numismatists), and the <b>Berufsverband des Deutschen Münzenfachhandels e.V</b> (German Association of Numismatists).
		';
        $trad_de = '
			Große Auswahl an antiken und modernen <b>Sammlermünzen</b>, päpstlichen, italienischen und ausländischen <b>Medaillen</b>, italienischen und ausländischen <b>Banknoten</b>, numismatischen <b>Büchern</b> und <b>Veröffentlichungen</b>, <b>Zubehör, Gutachterdiensten und numismatischen Zertifizierungen</b>.
			<br/><br/>
			<span style="color:#fff"><b>WICHTIG</b></span>: Wir sind Mitglieder der <b>IAPN-AINP</b> (Internationale Vereinigung der Berufsnumismatiker), der <b>NIP</b> (Berufsnumismatiker Italiens) und des <b>Berufsverband des Deutschen Münzenfachhandels e.V</b> (Deutscher Berufsverband der Numismatiker).
		';
        $trad_fr = '
			Large sélection de <b>pièces de monnaie de collection</b> anciennes et modernes, <b>médailles</b> papales, italiennes et étrangères, <b>billets</b> italiens et étrangers, <b>livres</b> et <b>publications</b> numismatiques, <b>accessoires, services d\'expertise et certifications numismatiques</b>.
			<br/><br/>
			<span style="color:#fff"><b>IMPORTANT</b></span> : nous sommes membres de l\'<b>IAPN-AINP</b> (Association Internationale des Numismates Professionnels), des <b>NIP</b> (Numismates Professionnels Italiens) et de la <b>Berufsverband des Deutschen Münzenfachhandels e.V</b> (association allemande des numismates).
		';
        $trad_es = '
			Amplia selección de <b>monedas de colección</b> antiguas y modernas, <b>medallas</b> papales, italianas y extranjeras, <b>billetes</b> italianos y extranjeros, <b>libros</b> y <b>publicaciones</b> numismáticas, <b>accesorios, servicios periciales y certificaciones numismáticas</b>.
			<br/><br/>
			<span style="color:#fff"><b>IMPORTANTE</b></span>: somos miembros de la <b>IAPN-AINP</b> (Asociación Internacional de Numismáticos Profesionales), de los <b>NIP</b> (Numismáticos Profesionales Italianos) y de la <b>Berufsverband des Deutschen Münzenfachhandels e.V</b> (asociación alemana de numismáticos).
		';
    }

    if($testo == "testo home 2"){
        $trad_it = '
			Se hai<b> monete, banconote</b> e medaglie da proporci, <a href="https://www.moruzzi.it/come_vendere.html" style="color:#fff !important; text-decoration:underline" target="_blank"><b>clicca qui per vedere cosa cerchiamo e come contattarci</b></a>.
			<br/><br/><br/>
			Se vuoi far <b>periziare, catalogare</b> e <b>valutare</b> le tue <b>monete, banconote</b> e <b>medaglie</b> da collezione visita il "<a href="https://www.umbertomoruzzi.it/perizie-numismatiche.html" style="color:#fff !important; text-decoration:underline" target="_blank"><b>sito ufficiale del perito e studioso numismatico Umberto Moruzzi</b></a>".
		';
        $trad_en = '
			If you have <b>coins, banknotes</b> and medals to offer us, <a href="https://www.moruzzi.it/come_vendere.html" style="color:#fff !important; text-decoration:underline" target="_blank"><b>click here to see what we are looking for and how to contact us</b></a>.
			<br/><br/><br/>
			If you want to have your <b>coins, banknotes</b> and <b>medals</b> appraised, cataloged, and evaluated, visit the "<a href="https://www.umbertomoruzzi.it/perizie-numismatiche.html" style="color:#fff !important; text-decoration:underline" target="_blank"><b>official website of the numismatic expert and scholar Umberto Moruzzi</b></a>".
		';
        $trad_de = '
			Wenn Sie uns <b>Münzen, Banknoten</b> und Medaillen anbieten möchten, <a href="https://www.moruzzi.it/come_vendere.html" style="color:#fff !important; text-decoration:underline" target="_blank"><b>klicken Sie hier, um zu sehen, was wir suchen und wie Sie uns kontaktieren können</b></a>.
			<br/><br/><br/>
			Wenn Sie Ihre <b>Münzen, Banknoten</b> und <b>Medaillen</b> schätzen, katalogisieren und bewerten lassen möchten, besuchen Sie die "<a href="https://www.umbertomoruzzi.it/perizie-numismatiche.html" style="color:#fff !important; text-decoration:underline" target="_blank"><b>offizielle Website des Numismatik-Experten und -Gelehrten Umberto Moruzzi</b></a>".
		';
        $trad_fr = '
			Si vous avez des <b>pièces de monnaie, billets</b> et médailles à nous proposer, <a href="https://www.moruzzi.it/come_vendere.html" style="color:#fff !important; text-decoration:underline" target="_blank"><b>cliquez ici pour voir ce que nous recherchons et comment nous contacter</b></a>.
			<br/><br/><br/>
			Si vous souhaitez faire <b>expertiser, cataloguer</b> et <b>évaluer</b> vos <b>pièces de monnaie, billets</b> et <b>médailles</b> de collection, visitez le "<a href="https://www.umbertomoruzzi.it/perizie-numismatiche.html" style="color:#fff !important; text-decoration:underline" target="_blank"><b>site officiel de l\'expert et érudit numismatique Umberto Moruzzi</b></a>".
		';
        $trad_es = '
			Si tienes <b>monedas, billetes</b> y medallas para ofrecernos, <a href="https://www.moruzzi.it/come_vendere.html" style="color:#fff !important; text-decoration:underline" target="_blank"><b>haz clic aquí para ver qué buscamos y cómo contactarnos</b></a>.
			<br/><br/><br/>
			Si deseas <b>peritar, catalogar</b> y <b>valorar</b> tus <b>monedas, billetes</b> y <b>medallas</b> de colección, visita el "<a href="https://www.umbertomoruzzi.it/perizie-numismatiche.html" style="color:#fff !important; text-decoration:underline" target="_blank"><b>sitio oficial del perito y estudioso numismático Umberto Moruzzi</b></a>".
		';
    }

    if($testo == "Panel Coniazione"){
        $trad_it = '
			<b>La coniazione</b>
			<br/><br/>
			<p>Nel valutare una moneta è molto importante, soprattutto per le più antiche, in particolare per quelle coniate a martello, esaminare la qualità del processo produttivo e dei materiali usati per la coniazione.</p>
			<br/>
			<p>Esemplari che presentano un largo tondello esente da fratture, dove la coniazione è centrata sia al dritto che al rovescio, riceveranno un\'alta valutazione.</p>
			<br/>
			<p>Monete che evidenziano una coniazione con forte battuta tale da produrre alti rilievi, riceveranno una quotazione elevata, riportata sull\'istogramma.</p>
			<br/>
			<p>Al contrario, esemplari realizzati con una battuta insufficiente o che presentano scivolature di conio otterranno una valutazione più bassa.</p>
			<br/>
			<p>Uguale importanza è riservata alla produzione con conii non usurati e non arrugginiti.</p>
			<br/>
		';       
        $trad_en = '
			<b>The coinage</b>
			<br/><br/>
			<p>In the evaluation of the coins, especially the hammered ancient ones, it is very important to examine deeply the process of production and the materials used.</p>
			<br/>
			<p>Exemplars minted in a large, not fractured flan and well centered will receive a high rating.</p>
			<br/>
			<p>Coins with high reliefs will receive a high evaluation reported in the histogram.</p>
			<br/>
			<p>On the contrary, exemplars with damaged flan, not centered and with low reliefs will receive a lower rating.</p>
			<br/>
			<p>The same importance is reserved for the production with not worn out or not rusted coin dies.</p>
			<br/>
		';
        $trad_de = '
			<b>Die Prägung</b>
			<br/><br/>
			<p>Bei der Bewertung von Münzen, insbesondere der gehämmerten antiken Münzen, ist es sehr wichtig, den Herstellungsprozess und die verwendeten Materialien genau zu untersuchen.</p>
			<br/>
			<p>Exemplare, die auf einem großen, nicht gebrochenen Schrötling geprägt und gut zentriert sind, erhalten eine hohe Bewertung.</p>
			<br/>
			<p>Münzen mit hohem Relief erhalten eine hohe Bewertung, die im Histogramm angegeben ist.</p>
			<br/>
			<p>Im Gegensatz dazu erhalten Exemplare mit beschädigtem Schrötling, die nicht zentriert sind und ein niedriges Relief aufweisen, eine niedrigere Bewertung.</p>
			<br/>
			<p>Die gleiche Bedeutung wird der Produktion mit nicht abgenutzten oder nicht verrosteten Münzstempeln beigemessen.</p>
			<br/>
		';
        $trad_fr = '
			<b>La frappe</b>
			<br/><br/>
			<p>Dans l\'évaluation d\'une monnaie, il est très important, surtout pour les plus anciennes, en particulier pour celles qui sont frappées à marteau, d\'examiner la qualité du processus de production et les matériaux utilisés pour la frappe.</p>
			<br/>
			<p>Les exemplaires avec un grand flan sans fractures, où la frappe est centrée à la fois sur le droit et le revers, recevront une évaluation élevée.</p>			
			<br/>
			<p>Les pièces qui mettent en évidence une forte frappe telle pour produire des hauts-reliefs, recevront une note élevée, indiquée sur l\'histogramme.</p>
			<br/>
			<p>Au contraire, les exemplaires fabriqués avec une frappe insuffisante ou avec des glissements de frappe obtiendront une note inférieure.</p>
			<br/>
			<p>Une importance égale est réservée à la production avec des cônes non usés et non rouillés.</p>
			<br/>
		';
        $trad_es = '
			<b>La acuñación</b>
			<br/><br/>
			<p>En la evaluación de las monedas, especialmente las antiguas acuñadas a martillo, es muy importante examinar profundamente el proceso de producción y los materiales utilizados.</p>
			<br/>
			<p>Los ejemplares acuñados en un flan grande, no fracturado y bien centrado recibirán una alta calificación.</p>
			<br/>
			<p>Las monedas con altos relieves recibirán una alta evaluación informada en el histograma.</p>
			<br/>
			<p>Por el contrario, los ejemplares con flan dañado, no centrado y con bajos relieves recibirán una calificación más baja.</p>
			<br/>
			<p>La misma importancia se reserva para la producción con troqueles no desgastados o no oxidados.</p>
			<br/>
		';
    }

    if($testo == "Panel Conservazione"){
        $trad_it = '
			<b>Lo stato di conservazione delle monete</b>
			<br/><br/>
			<p>Un aspetto importante nella determinazione del valore di ogni singola moneta è la corretta ed oggettiva attribuzione dello suo stato di conservazione.</p>
			<br/>
			<p>Per questo motivo, studiamo le tecniche di produzione ed analizziamo con la massima cura ogni esemplare, anche con l\'ausilio di potenti lenti e, qualora necessario, anche con un microscopio.</p>
			<br/>
			<p>La scala da noi utilizzata è quella riconosciuta in tutta Europa, che va da D (Discreto) fino a FDC (Fior di Conio).</p>
			<br/>
			<p>Di seguito la scala utilizzata con una breve descrizione dei vari stati di conservazione.</p>
			<br/>
			<div style="padding:15px">
				<b>D - Discreto</b>
				<br/>
				<p>La moneta è quasi completamente liscia: i suoi rilievi si intuiscono appena oppure forti segni ne deturpano la superficie.</p>
			</div>
			<div style="padding:15px">
				<b>B - Bello</b>
				<br/>
				<p>La moneta è liscia e poco leggibile.</p>
			</div>
			<div style="padding:15px">
				<b>MB - Molto Bello</b>
				<br/>
				<p>La moneta è molto usurata e, se i rilievi originariamente erano poco rilevati, alcune parti dell’esemplare possono non essere leggibili.</p>
			</div>
			<div style="padding:15px">
				<b>BB - Bellissimo</b>
				<br/>
				<p>La moneta in questo caso ha circolato e ha evidenti tracce d’usura, che ne hanno già intaccato il bordo, il rilievo ed il disegno. Può avere colpi sul bordo, ma non deturpanti.</p>
			</div>
			<div style="padding:15px">
				<b>SPL - Splendido</b>
				<br/>
				<p>Si tratta di una moneta che ha circolato pochissimo e presenta leggere tracce di circolazione. Tutti i rilievi sono ancora nitidi, ma può avere piccoli colpetti sul bordo dovuti al contatto con altre monete.</p>
			</div>
			<div style="padding:15px">
				<b>FDC - Fior di Conio</b>
				<br/>
				<p>È da considerarsi il più alto grado di conservazione. La moneta in questo caso non presenta alcun segno di circolazione e conserva la sua brillantezza originale, anche se è possibile ritrovare su di essa un esiguo numero di piccoli segni dovuti al contatto con le altre monete durante le fasi della produzione. Va detto che ancora oggi, solitamente nelle officine di zecca, le monete appena coniate cadono una sull\'altra e vengono poi raccolte in sacchetti o in contenitori metallici.</p>
			</div>
			<br/>
			<p>Il Fondo Specchio (in sigla FS o Proof) non è da considerarsi uno stato di conservazione in senso stretto, ma uno speciale processo produttivo in cui si usano tondelli selezionati e lucidati e conii di particolare qualità, molto spesso cromati, che creano, dopo un\'accurata lavorazione, monete con fondi speculari e rilievi satinati.</p>
			<br/>
			<p>Nell\'istogramma riportato nella scheda dell\'esemplare viene riportato graficamente il livello dello stato di conservazione.</p>
			<br/>
			<p>È stata scelta una scala in settantesimi per facilitare i collezionisti asiatici e americani che generalmente utilizzano per lo stato di conservazione la Scala Sheldon.</p>
			<br/>
			<p>Eventuali ulteriori particolari difetti verranno indicati nelle note della stessa scheda.</p>
			<br/>
			<p>Da sottolineare che poniamo grande attenzione nello scoprire l\'eventuale presenza di restauri invasivi soprattutto sui grandi bronzi romani, volti ad aumentarne la conservazione e, quindi, l\'appetibilità.</p>
			<br/>
		';
        $trad_en = '
			<b>The grading of the coins</b>
			<br/><br/>
			<p>One important aspect that determines the value of a coin is the correct grading of it.</p>
			<br/>
			<p>For this reason we study the techniques of production, carefully analyzing each exemplar by powerful lenses and microscope if necessary.</p>
			<br/>
			<p>We use the European system of grading for our coins, ranging from VG (Very Good) to BU (Brilliant Uncirculated).</p>
			<br/>
			<p>Shown below is the system adopted with a brief description for each grade.</p>
			<br/>
			<div style="padding:15px">
				<b>VG - Very Good</b>
				<br/>
				<p>Heavy wear on all the coin with about 25% of original detail visible.</p>
			</div>
			<div style="padding:15px">
				<b>F - Fine</b>
				<br/>
				<p>Heavy wear on all the coin with about 50% of original detail visible.</p>
			</div>
			<div style="padding:15px">
				<b>VF - Very Fine</b>
				<br/>
				<p>Moderate wear with about 75% of detail visible.</p>
			</div>
			<div style="padding:15px">
				<b>EF - Extremely Fine</b>
				<br/>
				<p>Little wear with about 95% of original detail visible.</p>
			</div>
			<div style="padding:15px">
				<b>BU - Brilliant Uncirculated</b>
				<br/>
				<p>No sign of wear, not even under a powerful microscope, with full mint lustre.</p>
			</div>
			<br/>
			<p>Proof isn\'t properly a grade but a special method of production using especially prepared polished coin dies and planchets. Proofs are usually struck twice, with slower speed but more pressure. The resulting coins usually have a mirror field and raised areas are frosted in appearance.</p>
			<br/>
			<p>In the histogram present in the data sheet of each exemplar is graphically reported the level of the grade.</p>
			<br/>
			<p>It\'s adopted a grading in seventieths to help the Asian and American collectors accustomed to the Sheldon Grading System.</p>
			<br/>
			<p>Other eventual defects will be reported among the notes in the data sheet.</p>
			<br/>
			<p>We want to underline that we carefully analyze the coins to discover possible invasive restorations, especially for the Roman bronze coins, aimed to increase the grade and therefore the charm of a coin.</p>
			<br/>
		';
        $trad_de = '
			<b>Der Erhaltungszustand von Münzen</b>
			<br/><br/>
			<p>Ein wichtiger Aspekt bei der Bestimmung des Wertes einer einzelnen Münze ist die korrekte und objektive Zuordnung des Erhaltungszustands.</p>
			<br/>
			<p>Aus diesem Grund studieren wir die Produktionstechniken und analysieren jedes Exemplar mit größter Sorgfalt, auch mit Hilfe leistungsstarker Linsen und, falls erforderlich, auch mit einem Mikroskop.</p>
			<br/>
			<p>Die von uns verwendete Skala ist die in ganz Europa anerkannte, die von D (Discret) bis BU (Brilliant Uncirculated) reicht.</p>
			<br/>
			<p>Nachfolgend die verwendete Skala mit einer kurzen Beschreibung der verschiedenen Erhaltungszustände.</p>
			<br/>
			<div style="padding:15px">
				<b>D - Discret</b>
				<br/>
				<p>Die Münze ist fast vollständig glatt: Ihre Reliefs sind kaum erkennbar oder starke Kratzer verunstalten die Oberfläche.</p>
			</div>
			<div style="padding:15px">
				<b>B - Gut</b>
				<br/>
				<p>Die Münze ist glatt und wenig lesbar.</p>
			</div>
			<div style="padding:15px">
				<b>MB - Sehr gut</b>
				<br/>
				<p>Die Münze ist stark abgenutzt und wenn die Reliefs ursprünglich wenig ausgeprägt waren, können einige Teile des Exemplars nicht lesbar sein.</p>
			</div>
			<div style="padding:15px">
				<b>BB - Schön</b>
				<br/>
				<p>Die Münze hat in diesem Fall zirkuliert und weist deutliche Abnutzungsspuren auf, die bereits den Rand, das Relief und das Design beeinträchtigt haben. Sie kann Kerben am Rand haben, aber nicht entstellend.</p>
			</div>
			<div style="padding:15px">
				<b>SPL - Vorzüglich</b>
				<br/>
				<p>Es handelt sich um eine Münze, die kaum im Umlauf war und leichte Umlaufspuren aufweist. Alle Reliefs sind noch scharf, aber es können kleine Kerben am Rand durch den Kontakt mit anderen Münzen vorhanden sein.</p>
			</div>
			<div style="padding:15px">
				<b>BU - Stempelglanz</b>
				<br/>
				<p>Dies ist als der höchste Erhaltungsgrad zu betrachten. In diesem Fall zeigt die Münze keinerlei Umlaufspuren und behält ihren ursprünglichen Glanz, auch wenn auf ihr eine geringe Anzahl kleinerer Kratzer durch den Kontakt mit anderen Münzen während der Produktion zu finden sein können. Es sei darauf hingewiesen, dass selbst heute frisch geprägte Münzen in der Regel in Münzstätten übereinander fallen und dann in Säcken oder Metallbehältern gesammelt werden.</p>
			</div>
			<br/>
			<p>Spiegelglanz (in der Abkürzung FS oder Proof) ist nicht als Erhaltungszustand im engeren Sinne zu betrachten, sondern als spezielles Produktionsverfahren, bei dem ausgewählte und polierte Schrötlinge sowie besondere, oft verchromte Stempel verwendet werden, die nach sorgfältiger Bearbeitung Münzen mit spiegelnden Flächen und mattierten Reliefs erzeugen.</p>
			<br/>
			<p>Im Histogramm, das im Datenblatt des Exemplars enthalten ist, wird der Erhaltungsgrad grafisch dargestellt.</p>
			<br/>
			<p>Es wurde eine Skala in Siebzigstel gewählt, um asiatischen und amerikanischen Sammlern zu helfen, die in der Regel die Sheldon-Skala zur Bewertung des Erhaltungszustands verwenden.</p>
			<br/>
			<p>Weitere mögliche Mängel werden in den Anmerkungen des Datenblattes angegeben.</p>
			<br/>
			<p>Es sei darauf hingewiesen, dass wir großen Wert darauf legen, mögliche invasive Restaurierungen zu entdecken, insbesondere bei großen römischen Bronzen, um deren Erhaltungszustand und somit deren Attraktivität zu erhöhen.</p>
			<br/>
		';
        $trad_fr = '
			<b>L\'état de conservation des pièces</b>
			<br/><br/>
			<p>Un aspect important dans la détermination de la valeur de chaque monnaie est l\'attribution correcte et objective de son état de conservation.</p>
			<br/>
			<p>Pour cette raison, nous étudions les techniques de production et analysons chaque spécimen avec le plus grand soin, à l\'aide de puissantes lentilles et, si nécessaire, même avec un microscope.</p>
			<br/>
			<p>L\'échelle que nous utilisons est celle reconnue dans toute l\'Europe, allant de D (Discret) à FDC (Fleur de coin).</p>
			<br/>
			<p>Voici l\'échelle utilisée avec une brève description des différents états de conservation.</p>
			<br/>
			<div style="padding:15px">
				<b>D - Discret</b>
				<br/>
				<p>La pièce est presque complètement lisse: ses reliefs sont à peine perceptibles ou des fortes rayures défigurent la surface.</p>
			</div>
			<div style="padding:15px">
				<b>B - Beau</b>
				<br/>
				<p>La pièce est lisse et peu lisible.</p>
			</div>
			<div style="padding:15px">
				<b>MB - Très beau</b>
				<br/>
				<p>a pièce est très usée et, si les reliefs ne sont pas relevés à l\'origine, certaines parties de l\'exemplaire ne peuvent pas être lisibles.</p>
			</div>
			<div style="padding:15px">
				<b>BB - Très très beau<</b>
				<br/>
				<p>La pièce dans ce cas a circulé et a des traces évidentes d\'usure, qui ont déjà affecté le bord, le relief et le dessin. Elle peut avoir des coups sur le bord, mais pas défigurants.</p>
			</div>
			<div style="padding:15px">
				<b>SPL - Superbe</b>
				<br/>
				<p>Il s’agit d’une monnaie qui a très peu circulé et qui a de légères traces de circulation. Tous les reliefs sont encore vifs, mais peuvent avoir de petits coups sur le bord en raison du contact avec d\'autres pièces.</p>
			</div>
			<div style="padding:15px">
				<b>FDC - Fleur de Coin</b>
				<br/>
				<p>Il faut le considérer comme le plus haut degré de conservation. Dans ce cas, la pièce ne montre aucun signe de circulation et conserve son éclat d\'origine, même s\'il est possible de trouver sur celle-ci un petit nombre de petits signes dus au contact avec les autres pièces durant les phases de production. Il faut dire que même aujourd\'hui, habituellement dans les ateliers de la Monnaie, les pièces nouvellement frappées tombent l\'une sur l\'autre et sont ensuite rassemblées dans des sacs ou dans des récipients en métal.</p>
			</div>
			<br/>
			<p>Le Flan Bruni (dans l\'abréviation FS ou Proof) n\'est pas considéré comme un état de conservation <i>stricto sensu</i>, mais comme un processus de production spécial dans lequel des flans sélectionnées et polies sont utilisées, ainsi que des cônes spéciaux, souvent chromés, qui, après un travail soigné, créent des pièces de monnaie avec des fonds spéculaires et reliefs satinés.</p>
			<br/>
			<p>Dans l\'histogramme présente dans la fiche de la monnaie on a représenté graphiquement le niveau de l\'état de conservation.</p>
			<br/>
			<p>On a choisie une échelle en soixante-dixièmes pour faciliter les collectionneurs asiatiques et américains qui utilisent généralement l\'Échelle Sheldon pour l\'état de conservation.</p>
			<br/>
			<p>Des autres possibles défauts seront indiqués dans les notes de la même fiche.</p>
			<br/>
			<p>Il faut souligner que nous accordons une grande attention à la découverte de la présence possible de restaurations invasives, en particulier sur les grands bronzes romains, visant à augmenter leur conservation et, par conséquent, leur appétibilité.</p>
			<br/>
		';
        $trad_es = '
			<b>El estado de conservación de las monedas</b>
			<br/><br/>
			<p>Un aspecto importante en la determinación del valor de cada moneda es la correcta y objetiva atribución del estado de conservación.</p>
			<br/>
			<p>Por esta razón, estudiamos las técnicas de producción y analizamos cada ejemplar con el máximo cuidado, también con la ayuda de potentes lentes y, si es necesario, también con un microscopio.</p>
			<br/>
			<p>La escala que utilizamos es la reconocida en toda Europa, que va desde D (Discreto) hasta FDC (Flor de Cuño).</p>
			<br/>
			<p>A continuación, la escala utilizada con una breve descripción de los diversos estados de conservación.</p>
			<br/>
			<div style="padding:15px">
				<b>D - Discreto</b>
				<br/>
				<p>La moneda es casi completamente lisa: sus relieves apenas se perciben o fuertes marcas desfiguran la superficie.</p>
			</div>
			<div style="padding:15px">
				<b>B - Bueno</b>
				<br/>
				<p>La moneda es lisa y poco legible.</p>
			</div>
			<div style="padding:15px">
				<b>MB - Muy Bueno</b>
				<br/>
				<p>La moneda está muy desgastada y, si los relieves originalmente no eran muy pronunciados, algunas partes del ejemplar pueden no ser legibles.</p>
			</div>
			<div style="padding:15px">
				<b>BB - Bellísimo</b>
				<br/>
				<p>La moneda en este caso ha circulado y presenta evidentes signos de desgaste, que ya han afectado el borde, el relieve y el diseño. Puede tener golpes en el borde, pero no desfigurantes.</p>
			</div>
			<div style="padding:15px">
				<b>SPL - Excelente</b>
				<br/>
				<p>Se trata de una moneda que ha circulado muy poco y presenta ligeros rastros de circulación. Todos los relieves aún son nítidos, pero puede tener pequeños golpes en el borde debido al contacto con otras monedas.</p>
			</div>
			<div style="padding:15px">
				<b>FDC - Flor de Cuño</b>
				<br/>
				<p>Se considera el grado más alto de conservación. En este caso, la moneda no muestra signos de circulación y conserva su brillo original, aunque es posible encontrar en ella un pequeño número de marcas pequeñas debido al contacto con otras monedas durante las fases de producción. Cabe señalar que todavía hoy, normalmente en las casas de moneda, las monedas recién acuñadas caen una sobre otra y luego se recogen en bolsas o en recipientes metálicos.</p>
			</div>
			<br/>
			<p>El Fondo Espejo (con la abreviatura FS o Proof) no se considera un estado de conservación en sentido estricto, sino un proceso de producción especial en el que se utilizan flanes seleccionados y pulidos y matrices de calidad especial, muy a menudo cromadas, que crean, después de un trabajo cuidadoso, monedas con fondos espejados y relieves satinados.</p>
			<br/>
			<p>En el histograma presente en la ficha del ejemplar se representa gráficamente el nivel del estado de conservación.</p>
			<br/>
			<p>Se ha elegido una escala en setentaavos para facilitar a los coleccionistas asiáticos y americanos que generalmente utilizan la escala Sheldon para el estado de conservación.</p>
			<br/>
			<p>Cualesquiera otros defectos se indicarán en las notas de la misma ficha.</p>
			<br/>
			<p>Es importante destacar que prestamos gran atención a la detección de posibles restauraciones invasivas, especialmente en los grandes bronces romanos, destinadas a aumentar su conservación y, por lo tanto, su atractivo.</p>
			<br/>
		';
    }

    if($testo == "Panel Metallo e Patina"){
        $trad_it = '
			<b>Il metallo e la patina</b>
			<br/><br/>
			<p>Anche la qualità e l\'aspetto del metallo di un esemplare sono un fattore molto importante nella valutazione.</p>
			<br/>
			<p>Ogni moneta, nel corso della sua più o meno lunga esistenza, può avere subito i danni del tempo alla lega con cui è realizzata.</p>
			<br/>
			<p>Tali difetti potrebbero esistere sin dalla sua produzione se il metallo utilizzato non era di qualità.</p>			
			<br/>
			<p>Questi danni potrebbero essere causati anche una non corretta pulizia o restauro.</p>
			<br/>
			<p>Altro aspetto esaminato in questo parametro è la patina, quando presente.</p>
			<br/>
			<p>Col trascorrere del tempo sulle monete può formarsi una sorta di velatura, spesso un oscuramento dello strato superficiale delle stesse, per l\'azione della luce, dei processi chimici, degli agenti atmosferici ma anche a seconda di come sono state conservate nelle collezioni stesse.</p>
			<br/>
			<p>Infatti una patina cosiddetta "da vecchia collezione" può rendere più gradevole un esemplare, metterne in maggiore risalto i rilievi ed aumentarne, di conseguenza, il pregio.</p>
			<br/>
			<p>Le vere patine antiche, come quella verde sulle monete in bronzo romane o la cosiddetta "patina Tevere" non possono che aumentare l\'attenzione dei collezionisti.</p>
			<br/>
			<p>Sottolineiamo l\'aggettivo "vera" da noi utilizzato, in quanto è tutt\'altro che raro trovarsi di fronte a monete con patine o colorazioni artificiali create al fine di aumentarne il valore economico.</p>
			<br/>
			<p>Quando queste antiche e belle patine sono presenti vengono indicate nella scheda stessa e sono anche oggetto di valutazione in questo parametro, come anche le patine di vecchia collezione, in particolare per l\'argento.</p>
			<br/>
			<p>Quando sono presenti colorazioni o moderne ossidazioni create artificialmente per confondere il mercato antiquario queste deprimono il parametro.</p>
			<br/>
			<p>Potremmo avere una bassa percentuale anche per monete che presentano sgradevoli ossidazioni, corrosioni che producono una porosità più o meno accentuata, cristallizzazioni, cancro del bronzo (cloruri di rame) per i casi più gravi etc.</p>
			<br/>
			<p>Al contrario si potrà arrivare ad una alta percentuale per monete integre con metallo esente da particolari problemi.</p>
			<br/>
			<p>Anche una non corretta pulizia e una lucidatura aggressiva possono danneggiare il metallo; tali aspetti sono evidenziati nella scheda dell\'esemplare ma rientrano nella valutazione di questo parametro.</p>
			<br/>
		';
        $trad_en = '
			<b>The metal and the patina</b>
			<br/><br/>
			<p>Also the quality and the visual aspect of a coin\'s metal is a key factor in rating it.</p>
			<br/>
			<p>The metal of a coin can be damaged by the time goes on.</p>
			<br/>
			<p>Sometimes the defects can be caused by the low quality metal used during the minting process.</p>
			<br/>
			<p>The damages could be caused by an improper cleaning or a bad restoration too.</p>
			<br/>
			<p>Another aspect examined in this parameter is the patina, if present.</p>
			<br/>
			<p>With time, a thin layer can appear on the surface of a coin due to exposure to light, chemical compounds, or atmospheric elements. Relevant is also the way the collectors kept it.</p>
			<br/>
			<p>An old collection patina can increase the charm of a coin and its value, especially for a silver one.</p>
			<br/>
			<p>The original old patinas, like the green or riverine ones on the Roman bronze coins, attract the collectors.</p>
			<br/>
			<p>We remark the adjective original because in many cases the patinas are artificial, created to increase the value of a coin.</p>
			<br/>
			<p>If an original patina is present on a coin, we\'ll report it in the data sheet resulting in a high rating in the histogram too.</p>
			<br/>
			<p>Artificial patinas or modern oxidations, detected during the examination, will result in a lower rating in the histogram.</p>
			<br/>
			<p>A low rating will be reserved for coins with porosity, excessive oxidations, crystallizations, et al.</p>
			<br/>
			<p>On the contrary, coins with a metal without particular issues will receive a really high rating in the histogram.</p>
			<br/>
			<p>Also aggressive polishing can damage the metal of a coin causing a low rating.</p>
			<br/>
		';
        $trad_de = '
			<b>Das Metall und die Patina</b>
			<br/><br/>
			<p>Auch die Qualität und das Erscheinungsbild des Metalls einer Münze sind ein wichtiger Faktor bei der Bewertung.</p>
			<br/>
			<p>Das Metall einer Münze kann im Laufe der Zeit beschädigt werden.</p>
			<br/>
			<p>Manchmal können die Mängel durch das minderwertige Metall verursacht werden, das während des Prägeprozesses verwendet wurde.</p>
			<br/>
			<p>Die Schäden könnten auch durch unsachgemäße Reinigung oder schlechte Restaurierung verursacht werden.</p>
			<br/>
			<p>Ein weiterer Aspekt, der in diesem Parameter untersucht wird, ist die Patina, falls vorhanden.</p>
			<br/>
			<p>Mit der Zeit kann sich eine dünne Schicht auf der Oberfläche einer Münze bilden, die durch Licht, chemische Verbindungen oder atmosphärische Elemente verursacht wird. Relevant ist auch, wie die Sammler sie aufbewahrt haben.</p>
			<br/>
			<p>Eine alte Sammlungspatina kann den Reiz einer Münze und ihren Wert steigern, insbesondere bei einer Silbermünze.</p>
			<br/>
			<p>Die originalen alten Patinas, wie die grüne oder die Flusspatina auf den römischen Bronzemünzen, ziehen die Sammler an.</p>
			<br/>
			<p>Wir betonen das Adjektiv original, weil in vielen Fällen die Patinas künstlich sind und geschaffen wurden, um den Wert einer Münze zu erhöhen.</p>
			<br/>
			<p>Wenn eine originale Patina auf einer Münze vorhanden ist, wird dies im Datenblatt angegeben, was auch in einem hohen Rating im Histogramm resultiert.</p>
			<br/>
			<p>Künstliche Patinas oder moderne Oxidationen, die während der Untersuchung festgestellt werden, führen zu einer niedrigeren Bewertung im Histogramm.</p>
			<br/>
			<p>Eine niedrige Bewertung wird für Münzen mit Porosität, übermäßigen Oxidationen, Kristallisationen usw. reserviert.</p>
			<br/>
			<p>Im Gegensatz dazu erhalten Münzen mit Metall ohne besondere Probleme eine sehr hohe Bewertung im Histogramm.</p>
			<br/>
			<p>Auch eine aggressive Politur kann das Metall einer Münze beschädigen und zu einer niedrigen Bewertung führen.</p>
			<br/>
		';
        $trad_fr = '
			<b>Le métal et la patine</b>
			<br/>
			<br/>
			<p>La qualité et l\'apparence du métal d\'un modèle sont également un facteur très important dans l\'évaluation.</p>
			<br/>
			<p>Chaque monnaie, au cours de son existence plus ou moins longue, peut avoir subi les dommages du temps dans l\'alliage avec laquelle elle est faite.</p>
			<br/>
			<p>De tels défauts pourraient exister depuis la fabrication si le métal utilisé n\'était pas de qualité. Ces dégâts peuvent également être causés par un nettoyage ou une restauration incorrects.</p>
			<br/>
			<p>Un autre aspect examiné dans ce paramètre est la patine, lorsqu\'elle est présente.</p>
			<br/>
			<p>Avec le temps, sur les monnaies peut se former une sorte de voilage, souvent un assombrissement de la couche de surface, dû à l\'action de la lumière, aux processus chimiques, aux agents atmosphériques, mais aussi en fonction de la façon dont elles ont été conservées dans les collections mêmes.</p>
			<br/>
			<p>En effet, une patine dite «d\'ancienne collection» peut rendre un exemplaire plus agréable, souligner les reliefs et augmenter de conséquence sa valeur.</p>
			<br/>
			<p>Les vraies patines anciennes, comme la verte sur les pièces de bronze romaines ou la "patine Tibre" ne peuvent qu\'accroître l\'attention des collectionneurs.</p>
			<br/>
			<p>Nous insistons sur l\'adjectif "vrai" que nous utilisons, car il est loin d\'être rare de trouver des pièces de monnaie avec des patines ou des couleurs artificielles créées pour augmenter leur valeur économique.</p>
			<br/>
			<p>Lorsque ces patines anciennes et belles sont présentes, elles sont indiquées dans la même fiche et sont également sujettes à évaluation dans ce paramètre, ainsi que les patines de l\'ancienne collection, notamment pour l\'argent.</p>
			<br/>
			<p>Quand il y a des couleurs artificielles ou des oxydations modernes créées pour confondre le marché des antiquaires, elles dépriment le paramètre.</p>
			<br/>
			<p>Nous pourrions avoir un faible pourcentage également pour les pièces qui présentent des oxydations désagréables, des corrosions qui produisent une porosité plus ou moins accentuée, des cristallisations, un cancer du bronze (chlorures de cuivre) pour les cas les plus graves, etc.</p>
			<br/>
			<p>Au contraire, on pourra arriver à un pourcentage élevé pour les pièces qui sont complètes avec du métal sans problèmes particuliers.</p>
			<br/>
			<p>Même un nettoyage incorrect et un polissage agressif peuvent endommager le métal; ces aspects sont mis en évidence dans la fiche de l\'exemplaire, mais ils font partie de l\'évaluation de ce paramètre.</p>
			<br/>
		';
        $trad_es = '
			<b>El metal y la pátina</b>
			<br/><br/>
			<p>La calidad y el aspecto visual del metal de una moneda también son factores clave para su evaluación.</p>
			<br/>
			<p>El metal de una moneda puede dañarse con el paso del tiempo.</p>
			<br/>
			<p>A veces, los defectos pueden ser causados por el metal de baja calidad utilizado durante el proceso de acuñación.</p>
			<br/>
			<p>Los daños también pueden ser causados por una limpieza incorrecta o una mala restauración.</p>
			<br/>
			<p>Otro aspecto examinado en este parámetro es la pátina, si está presente.</p>
			<br/>
			<p>Con el tiempo, puede aparecer una fina capa en la superficie de una moneda debido a la exposición a la luz, compuestos químicos o elementos atmosféricos. También es relevante la forma en que los coleccionistas la han conservado.</p>
			<br/>
			<p>Una pátina de antigua colección puede aumentar el encanto de una moneda y su valor, especialmente en el caso de una moneda de plata.</p>
			<br/>
			<p>Las pátinas antiguas originales, como las verdes o fluviales en las monedas de bronce romanas, atraen a los coleccionistas.</p>
			<br/>
			<p>Enfatizamos el adjetivo original porque en muchos casos las pátinas son artificiales, creadas para aumentar el valor de una moneda.</p>
			<br/>
			<p>Si una pátina original está presente en una moneda, lo indicaremos en la ficha técnica, lo que también resultará en una alta calificación en el histograma.</p>
			<br/>
			<p>Las pátinas artificiales u oxidaciones modernas, detectadas durante el examen, resultarán en una calificación más baja en el histograma.</p>
			<br/>
			<p>Una baja calificación estará reservada para monedas con porosidad, oxidaciones excesivas, cristalizaciones, etc.</p>
			<br/>
			<p>Por el contrario, las monedas con metal sin problemas particulares recibirán una calificación muy alta en el histograma.</p>
			<br/>
			<p>Un pulido agresivo también puede dañar el metal de una moneda, causando una baja calificación.</p>
			<br/>
		';
    }

    if($testo == "Panel Provenienza"){
        $trad_it = '
			<b>La provenienza</b>
			<br/><br/>
			<p>Altro elemento di grande importanza per la valutazione complessiva di una moneta antica è la provenienza o pedigree, ovvero la certificazione dei vari passaggi della stessa nel mercato numismatico o la passata presenza nelle varie collezioni.</p>
			<br/>
			<p>Una moneta con un pedigree datato, passata in aste numismatiche prestigiose (ad esempio Santamaria, Leu, Frank Sternberg) o che ha fatto parte di collezioni di grande importanza (ad esempio collezioni A. Moretti, A. Magnaguti, S. Pozzi) avrà una percentuale più elevata su questo istogramma rispetto ad una con una tracciatura soltanto recente o meno pregiata.</p>
			<br/>
			<p>Naturalmente, non è sempre possibile riportare la provenienza di un esemplare per motivi di Privacy, ma ricordiamo che ogni moneta proposta dalla Moruzzi Numismatica ha una provenienza assolutamente legale e riportata nei registri delle autorità competenti.</p>
			<br/>
		';
        $trad_en = '
			<b>The provenance</b>
			<br/><br/>
			<p>Another significant element to take in consideration when determining the value of a coin is the provenance or pedigree, that is the certification of the various passages of the coin in the numismatic market and collections.</p>
			<br/>
			<p>A coin with an old provenance, sold in prestigious auctions (Santamaria, Leu, Frank Sternberg et al.) or displayed in important collections (A. Moretti, A. Magnaguti, S. Pozzi etc.), will receive a higher percentage in the histogram than another one with a more recent or less prestigious pedigree.</p>
			<br/>
			<p>Naturally, it\'s not always possible to report the provenance of a coin due to the Privacy Laws, but we remark that all the coins offered by Moruzzi Numismatica have an absolutely legal provenance registered in the Italian authorities\' lists.</p>
			<br/>
		';
        $trad_de = '
			<b>Die Herkunft</b>
			<br/><br/>
			<p>Ein weiteres bedeutendes Element bei der Bestimmung des Wertes einer Münze ist die Herkunft oder der Stammbaum, also die Zertifizierung der verschiedenen Stationen der Münze im numismatischen Markt und in Sammlungen.</p>
			<br/>
			<p>Eine Münze mit einer alten Herkunft, die in prestigeträchtigen Auktionen (Santamaria, Leu, Frank Sternberg usw.) verkauft wurde oder in wichtigen Sammlungen (A. Moretti, A. Magnaguti, S. Pozzi usw.) ausgestellt ist, erhält einen höheren Prozentsatz im Histogramm als eine andere mit einer neueren oder weniger prestigeträchtigen Herkunft.</p>
			<br/>
			<p>Natürlich ist es aufgrund der Datenschutzgesetze nicht immer möglich, die Herkunft einer Münze anzugeben, aber wir betonen, dass alle von Moruzzi Numismatica angebotenen Münzen eine absolut legale Herkunft haben, die in den Listen der italienischen Behörden registriert ist.</p>
			<br/>
		';
        $trad_fr = '
			<b>La provenance</b>
			<br/><br/>
			<p>Un autre élément de grande importance pour l\'évaluation globale d\'une monnaie ancienne est la provenance ou le pedigree, ou la certification des différents passages de la même dans le marché numismatique ou sa présence dans les différentes collections.</p>
			<br/>
			<p>Une monnaie avec un pedigree daté, passée dans des ventes aux enchères prestigieuses numismatiques (par exemple Santamaria, Leu, Frank Sternberg) ou qui a fait partie de collections de grande importance (par exemple collection A. Moretti, A. Magnaguti, S. Pozzi) aura un pourcentage plus élevé sur cet histogramme comparé à celle avec un suivi seulement récent ou moins précieux.</p>
			<br/>
			<p>Bien sûr, il n\'est pas toujours possible de nommer l\'origine d\'un exemplaire pour des raisons de confidentialité, mais rappelez-vous que chaque pièce proposée par Moruzzi Numismatica a une origine absolument légale et est enregistrée dans les registres des autorités compétentes.</p>
			<br/>
		';
        $trad_es = '
			<b>La procedencia</b>
			<br/><br/>
			<p>Otro elemento significativo a tener en cuenta al determinar el valor de una moneda es la procedencia o pedigree, es decir, la certificación de los diversos pasos de la moneda en el mercado numismático y las colecciones.</p>
			<br/>
			<p>Una moneda con una procedencia antigua, vendida en subastas prestigiosas (Santamaria, Leu, Frank Sternberg, etc.) o expuesta en importantes colecciones (A. Moretti, A. Magnaguti, S. Pozzi, etc.), recibirá un porcentaje más alto en el histograma que otra con una procedencia más reciente o menos prestigiosa.</p>
			<br/>
			<p>Naturalmente, no siempre es posible informar sobre la procedencia de una moneda debido a las leyes de privacidad, pero destacamos que todas las monedas ofrecidas por Moruzzi Numismatica tienen una procedencia absolutamente legal registrada en las listas de las autoridades italianas.</p>
			<br/>
		';
    }

    if($testo == "Panel Stile"){
        $trad_it = '
			<b>Lo stile</b>
			<br/><br/>
			<p>Per le monete antiche un elemento fondamentale, spesso più importante della stessa conservazione, è la qualità estetica dei conii con cui sono state realizzate.</p>
			<br/>
			<p>Monete con uno stile grossolano, poco curato avranno una valutazione bassa sull\'istogramma. Mentre monete con uno stile più fine e ricercato avranno una valutazione superiore, fino ad arrivare al massimo grado per le produzioni numismatiche più artistiche.</p>
			<br/>
		';
        $trad_en = '
			<b>The style</b>
			<br/><br/>
			<p>For the ancient coins, the style of the coin dies used for the minting is really important.</p>
			<br/>
			<p>Coins with a coarse style will receive a low rating in the histogram. Otherwise, coins with a fine style will receive a higher evaluation up to the maximum for the most artistic ones.</p>
			<br/>
		';
        $trad_de = '
			<b>Der Stil</b>
			<br/><br/>
			<p>Für antike Münzen ist der Stil der verwendeten Münzstempel von großer Bedeutung.</p>
			<br/>
			<p>Münzen mit einem groben Stil erhalten eine niedrige Bewertung im Histogramm. Münzen mit einem feinen Stil hingegen erhalten eine höhere Bewertung bis zum Maximum für die künstlerisch wertvollsten.</p>
			<br/>
		';
        $trad_fr = '
			<b>Le style</b>
			<br/><br/>
			<p>Pour les monnaies anciennes, un élément fondamental, souvent plus important que la conservation elle-même, est la qualité esthétique des cônes avec lesquels elles ont été fabriquées. Les pièces avec un style grossier et peu soigné auront une note faible sur l\'histogramme. Alors que les pièces avec un style plus raffiné et recherché auront une note plus élevée, jusqu\'au plus haut degré pour les productions numismatiques les plus artistiques.</p>
			<br/>
		';
        $trad_es = '
			<b>El estilo</b>
			<br/><br/>
			<p>Para las monedas antiguas, un elemento fundamental, a menudo más importante que la propia conservación, es la calidad estética de los troqueles con los que se han realizado.</p>
			<br/>
			<p>Las monedas con un estilo tosco y poco cuidado tendrán una valoración baja en el histograma. Mientras que las monedas con un estilo más fino y elaborado tendrán una valoración superior, hasta llegar al grado máximo para las producciones numismáticas más artísticas.</p>
			<br/>
		';
    }

    if($testo == "Panel Rarità"){
        $trad_it = '
			<b>La rarit&agrave;</b>
			<br/><br/>
			Altro elemento importante ai fini della determinazione del valore di una moneta &egrave; la rarit&agrave;. Le monete sono prodotte sin dall\'antichit&agrave; in moltissimi esemplari e, in quanto "prodotti industriali", sono spesso oggetti comuni.
			<br/><br/>
			Ma non &egrave; sempre cos&igrave;.
			<br/><br/>
			A volte ci sono esemplari veramente difficili da trovare, spesso praticamente introvabili; in alcuni casi la rarit&agrave; &egrave; subordinata alla grande domanda dei collezionisti numismatici per determinate monete simboliche o evocative (ad esempio le monete di Giulio Cesare). Sull\'istogramma ne &egrave; riportato graficamente in percentuale il grado di rarit&agrave; dell\'esemplare in oggetto. Si passa da una percentuale molto bassa per monete comunissime o comuni (C) fino ad arrivare al 100% per monete della massima rarit&agrave;, uniche o conosciute in alcuni esemplari (grado RRRRR). Segue la tabella delle rarit&agrave; con una breve descrizione.
			<br/><br/>
			
			<table border="0">
				<tbody>
					<tr>
						<td>
						<div>
						<p class="Contenutotabella"><i>Sigla</i></p>
						</div>
						</td>
						<td>
						<div>
						<p class="Contenutotabella"><i>Descrizione</i></p>
						</div>
						</td>
					</tr>
					<tr>
						<td>
						<div>
						<p class="Contenutotabella"><b>C</b></p>
						</div>
						</td>
						<td>
						<div>
						<p class="Contenutotabella">Comune o comunissimo</p>
						</div>
						</td>
					</tr>
					<tr>
					<td>
						<div>
						<p class="Contenutotabella"><b>NC</b></p>
						</div>
						</td>
						<td>
						<div>
						<p class="Contenutotabella">Non comune</p>
						</div>
						</td>
					</tr>
					<tr>
					<td>
						<div>
						<p class="Contenutotabella"><b>R</b></p>
						</div>
						</td>
						<td>
						<div>
						<p class="Contenutotabella">Raro</p>
						</div>
						</td>
					</tr>
					<tr>
					<td>
						<div>
						<p class="Contenutotabella"><b>RR</b></p>
						</div>
					</td>
					<td>
						<div>
						<p class="Contenutotabella">Molto raro</p>
						</div>
					</td>
					</tr>
					<tr>
					<td>
						<div>
						<p class="Contenutotabella"><b>RRR</b></p>
						</div>
						</td>
						<td>
						<div>
						<p class="Contenutotabella">Rarissimo</p>
						</div>
						</td>
					</tr>
					<tr>
					<td>
						<div>
						<p class="Contenutotabella"><b>RRRR</b></p>
						</div>
						</td>
						<td>
						<div>
						<p class="Contenutotabella">Estremamente raro</p>
						</div>
						</td>
					</tr>
					<tr>
						<td>
						<div>
						<p class="Contenutotabella"><b>RRRRR</b>&nbsp;&nbsp;&nbsp;</p>
						</div>
						</td>
						<td>
						<div>
						<p class="Contenutotabella">Unico o soltanto alcuni esemplari noti</p>
						</div>
						</td>
					</tr>
				</tbody>
			</table>
		';
        $trad_en = '
			<b>The rarity</b>
			<br/><br/>
			<p>Another notable aspect in determining the value of a coin is the rarity. Coins have been produced in great quantity since ancient times and, being “industrial products”, they\'re often common objects.</p>
			<br/>
			<p>But in many cases, this isn\'t true.</p>
			<br/>
			<p>There are exemplars very difficult to find, sometimes practically unavailable; in some cases, the rarity is subordinated to the big demand of collectors for certain symbolical issues (for example, the coins of Julius Caesar). In the histogram, the level of rarity of the item is graphically reported in percentage, spanning from a low percentage for very common or common coins (C) to 100% for extremely rare ones, unique or known in few specimens (RRRRR).</p>
			<br/>
			<p>Shown below is the table of rarity with a brief description for each level.</p>
			<br/><br/>
			<table border="1">
				<thead>
					<tr>
						<th>Abbreviation</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>C</b></td>
						<td>Common</td>
					</tr>
					<tr>
						<td><b>NC</b></td>
						<td>Not common</td>
					</tr>
					<tr>
						<td><b>R</b></td>
						<td>Rare</td>
					</tr>
					<tr>
						<td><b>RR</b></td>
						<td>Very rare</td>
					</tr>
					<tr>
						<td><b>RRR</b></td>
						<td>Particularly rare</td>
					</tr>
					<tr>
						<td><b>RRRR</b></td>
						<td>Extremely rare</td>
					</tr>
					<tr>
						<td><b>RRRRR</b></td>
						<td>Of the greatest rarity</td>
					</tr>
				</tbody>
			</table>
		';
        $trad_de = '
			<b>Die Seltenheit</b>
			<br/><br/>
			<p>Ein weiteres bemerkenswertes Element zur Bestimmung des Wertes einer Münze ist die Seltenheit. Münzen wurden seit der Antike in großen Mengen produziert und sind als „Industrieprodukte“ oft gewöhnliche Gegenstände.</p>
			<br/><br/>
			<p>Aber in vielen Fällen ist dies nicht wahr.</p>
			<br/><br/>
			<p>Es gibt Exemplare, die sehr schwer zu finden sind, manchmal praktisch nicht verfügbar; in einigen Fällen ist die Seltenheit der großen Nachfrage der Sammler nach bestimmten symbolischen Münzen untergeordnet (zum Beispiel die Münzen von Julius Caesar). Im Histogramm wird der Seltenheitsgrad des Artikels grafisch in Prozent angegeben, wobei der niedrige Prozentsatz für sehr häufige oder häufige Münzen (C) bis zu 100% für äußerst seltene, einzigartige oder in wenigen Exemplaren bekannte Münzen (RRRRR) reicht.</p>
			<br/><br/>
			<p>Unten ist die Seltenheitstabelle mit einer kurzen Beschreibung für jede Stufe dargestellt.</p>
			<br/><br/>
			<table border="1">
				<thead>
					<tr>
						<th>Abkürzung</th>
						<th>Beschreibung</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>C</b></td>
						<td>Häufig</td>
					</tr>
					<tr>
						<td><b>NC</b></td>
						<td>Nicht häufig</td>
					</tr>
					<tr>
						<td><b>R</b></td>
						<td>Selten</td>
					</tr>
					<tr>
						<td><b>RR</b></td>
						<td>Sehr selten</td>
					</tr>
					<tr>
						<td><b>RRR</b></td>
						<td>Besonders selten</td>
					</tr>
					<tr>
						<td><b>RRRR</b></td>
						<td>Äußerst selten</td>
					</tr>
					<tr>
						<td><b>RRRRR</b></td>
						<td>Von größter Seltenheit</td>
					</tr>
				</tbody>
			</table>
		';
        $trad_fr = '
			<b>La rareté</b>
			<br/><br/>
			<p>Un autre élément important dans la détermination de la valeur d\'une monnaie est la rareté. Les pièces ont été produites depuis l\'antiquité dans de nombreux exemplaires et, en tant que «produits industriels», elles sont souvent des objets communs.</p>
			<br/>
			<p>Mais ce n\'est pas toujours pareil.</p>
			<br/>
			<p>Parfois, il y a des exemplaires qui sont vraiment difficiles à trouver, souvent pratiquement impossibles à trouver; dans certains cas, la rareté est subordonnée à la grande demande des collectionneurs numismatiques pour certaines pièces symboliques ou évocatrices (par exemple les monnaies de Jules César). Le degré de rareté de l\'objet en question est représenté graphiquement en pourcentage sur l\'histogramme.</p>
			<br/>
			<p>On va d\'un très faible pourcentage pour les pièces très courantes ou communes (C) jusqu\'à 100% pour les pièces de la plus haute rareté, uniques ou connues seulement dans un petit nombre d\'exemplaires (grade RRRRR). Voici le tableau de rareté avec une brève description.</p>
			<br/><br/>
			<table border="1">
				<thead>
					<tr>
						<th>Abréviation</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>C</b></td>
						<td>Commun ou très commun</td>
					</tr>
					<tr>
						<td><b>NC</b></td>
						<td>Pas commun</td>
					</tr>
					<tr>
						<td><b>R</b></td>
						<td>Rare</td>
					</tr>
					<tr>
						<td><b>RR</b></td>
						<td>Très rare</td>
					</tr>
					<tr>
						<td><b>RRR</b></td>
						<td>Très très rare</td>
					</tr>
					<tr>
						<td><b>RRRR</b></td>
						<td>Extrêmement rare</td>
					</tr>
					<tr>
						<td><b>RRRRR</b></td>
						<td>Unique ou seulement quelques exemples connus</td>
					</tr>
				</tbody>
			</table>
		';
        $trad_es = '
			<b>La rareza</b>
			<br/><br/>
			<p>Otro aspecto notable para determinar el valor de una moneda es la rareza. Las monedas se han producido en grandes cantidades desde tiempos antiguos y, al ser “productos industriales”, a menudo son objetos comunes.</p>
			<br/><br/>
			<p>Pero en muchos casos, esto no es cierto.</p>
			<br/><br/>
			<p>Existen ejemplares muy difíciles de encontrar, a veces prácticamente inexistentes; en algunos casos, la rareza está subordinada a la gran demanda de los coleccionistas por ciertas emisiones simbólicas (por ejemplo, las monedas de Julio César). En el histograma, el nivel de rareza del objeto se informa gráficamente en porcentaje, desde un bajo porcentaje para las monedas muy comunes o comunes (C) hasta el 100% para las extremadamente raras, únicas o conocidas en pocos ejemplares (RRRRR).</p>
			<br/><br/>
			<p>A continuación se muestra la tabla de rarezas con una breve descripción para cada nivel.</p>
			<br/><br/>
			<table border="1">
				<thead>
					<tr>
						<th>Abreviatura</th>
						<th>Descripción</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>C</b></td>
						<td>Común</td>
					</tr>
					<tr>
						<td><b>NC</b></td>
						<td>No común</td>
					</tr>
					<tr>
						<td><b>R</b></td>
						<td>Rara</td>
					</tr>
					<tr>
						<td><b>RR</b></td>
						<td>Muy rara</td>
					</tr>
					<tr>
						<td><b>RRR</b></td>
						<td>Particularmente rara</td>
					</tr>
					<tr>
						<td><b>RRRR</b></td>
						<td>Extremadamente rara</td>
					</tr>
					<tr>
						<td><b>RRRRR</b></td>
						<td>De la mayor rareza</td>
					</tr>
				</tbody>
			</table>
		';
    }
	
	//include("config/traduci_parole2.inc.php");

    $traduzione = "trad_" . $lingua;
    if(!isset($$traduzione) || $$traduzione == "") {
		if(isset($trad_en) && $trad_en != "") {
			$traduzione = "trad_en";
		}else $traduzione = "trad_it";
	}
    return $$traduzione;
}
?>
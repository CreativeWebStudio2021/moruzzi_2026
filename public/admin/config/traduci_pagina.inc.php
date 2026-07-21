<?
if($cmd=="home"){
	$link_trad_it = "it/home.html";
	$link_trad_en = "en/home.html";
	$link_trad_de = "de/home.html";
	$link_trad_fr = "fr/home.html";
	$link_trad_es = "es/home.html";
}
if($cmd=="i_miei_ordini"){
	$link_trad_it = "it/i_miei_ordini.html";
	$link_trad_en = "en/my_orders.html";
	$link_trad_de = "de/meine_bestellungen.html";
	$link_trad_fr = "fr/mes_commandes.html";
	$link_trad_es = "es/mis_pedidos.html";
}
if($cmd=="il_mio_account"){
	$link_trad_it = "it/il_mio_account.html";
	$link_trad_en = "en/my_account.html";
	$link_trad_de = "de/mein_konto.html";
	$link_trad_fr = "fr/mon_compte.html";
	$link_trad_es = "es/mi_cuenta.html";
}
if($cmd=="prodotti_dett"){
	if(isset($_GET['path_dett'])) $path_dett=$_GET['path_dett']; else $path_dett="";
	$link_trad_it = "it/".$path_dett.".html";
	$link_trad_en = "en/".$path_dett.".html";
	$link_trad_de = "de/".$path_dett.".html";
	$link_trad_fr = "fr/".$path_dett.".html";
	$link_trad_es = "es/".$path_dett.".html";
	
}
if($cmd=="prodotti"){
	if(isset($_GET['path_cat1'])) $path_cat1=$_GET['path_cat1']; else $path_cat1="";
	if(isset($_GET['path_cat2'])) $path_cat2=$_GET['path_cat2']; else $path_cat2="";
	if(isset($_GET['path_cat3'])) $path_cat3=$_GET['path_cat3']; else $path_cat3="";
	if(isset($_GET['path_cat4'])) $path_cat4=$_GET['path_cat4']; else $path_cat4="";
	
	if($path_cat1!=""){
		$path_cat = $path_cat1;
		if($path_cat2!="") $path_cat .= "/".$path_cat2;
		if($path_cat3!="") $path_cat .= "/".$path_cat3;
		if($path_cat4!="") $path_cat .= "/".$path_cat4;
		$path_cat .= ".html";
		
		$query_path="SELECT * FROM ".$prefix."categorie_new WHERE (link_it='".$path_cat."' OR link_en='".$path_cat."' OR link_de='".$path_cat."' OR link_fr='".$path_cat."' OR link_es='".$path_cat."')";
		$risu_path = $open_connection->connection->query($query_path);
		$arr_path = $risu_path->fetch();
		
		if(isset($arr_path['link_it'])) $link_trad_it = "it/".$arr_path['link_it'];
		if(isset($arr_path['link_en'])) $link_trad_en = "en/".$arr_path['link_en'];
		if(isset($arr_path['link_de'])) $link_trad_de = "de/".$arr_path['link_de'];
		if(isset($arr_path['link_fr'])) $link_trad_fr = "fr/".$arr_path['link_fr'];
		if(isset($arr_path['link_es'])) $link_trad_es = "es/".$arr_path['link_es'];
		
	}else{
		$link_trad_it = "it/prodotti.html";
		$link_trad_en = "en/products.html";
		$link_trad_de = "de/produkte.html";
		$link_trad_fr = "fr/produits.html";
		$link_trad_es = "es/productos.html";
	}
	/*$link_trad_it = "it/".$path_dett.".html";
	$link_trad_en = "en/".$path_dett.".html";
	$link_trad_de = "de/".$path_dett.".html";
	$link_trad_fr = "fr/".$path_dett.".html";
	$link_trad_es = "es/".$path_dett.".html";*/
	
}
if($cmd=="il-mio-account"){
	$link_trad_it = "it/il-mio-account.html";
	$link_trad_en = "en/my-account.html";
	$link_trad_de = "de/";
	$link_trad_fr = "fr/";
	$link_trad_es = "es/";
}
if($cmd=="i_miei_dati_di_spedizione"){
	$link_trad_it = "it/i_miei_dati_di_spedizione.html";
	$link_trad_en ="en/my_shipping_data.html";
	$link_trad_de = "de/meine_versanddaten.html";
	$link_trad_fr = "fr/mes_informations_de_livraison.html";
	$link_trad_es = "es/mis_datos_de_envio.html";
}
if($cmd=="i-miei-ordini"){
	$link_trad_it = "it/i-miei-ordini.html";
	$link_trad_en = "en/my-orders.html";
	$link_trad_de = "de/";
	$link_trad_fr = "fr/";
	$link_trad_es = "es/";
}
if($cmd=="recupero-password"){
	$link_trad_it = "it/recupero-password.html";
	$link_trad_en = "en/password-recovery.html";
	$link_trad_de = "de/password-recovery.html";
	$link_trad_fr = "fr/password-recovery.html";
	$link_trad_es = "es/password-recovery.html";
}
if($cmd=="registrati"){
	$link_trad_it = "it/registrati.html";
	$link_trad_en ="en/registration.html";
	$link_trad_de = "de/registrierung.html";
	$link_trad_fr = "fr/inscription.html";
	$link_trad_es = "es/registro.html";
	
	if(isset($_GET['stato_reg']) && $_GET['stato_reg']==1){
		$link_trad_it = "it/registrati-conferma.html";
		$link_trad_en ="en/registration-confirm.html";
		$link_trad_de = "de/registrierung-bestätigen.html";
		$link_trad_fr = "fr/inscription-confirmer.html";
		$link_trad_es = "es/registro-confirmar.html";
	}
}
if($cmd=="condizioni-di-vendita"){
	$link_trad_it = "it/condizioni-di-vendita.html";
	$link_trad_en ="en/terms_of_sale.html";
	$link_trad_de = "de/";
	$link_trad_fr = "fr/";
	$link_trad_es = "es/";
}
if($cmd=="carrello"){
	$link_trad_it = "it/carrello.html";
	$link_trad_en = "en/cart.html";
	$link_trad_de = "de/warenkorb.html";
	$link_trad_fr = "fr/panier.html";
	$link_trad_es = "es/carrito.html";
}
if($cmd=="checkout"){
	$link_trad_it = "it/carrello.html";
	$link_trad_en = "en/checkout.html";
	$link_trad_de = "de/checkout.html";
	$link_trad_fr = "fr/checkout.html";
	$link_trad_es = "es/checkout.html";
	
	if(isset($_GET['step'])) $step=$_GET['step']; else $step="";
	if($step=="riepiplogo"){
		$link_trad_it = "it/checkout/riepilogo";
		$link_trad_en = "en/checkout/summary";
		$link_trad_de = "de/checkout/zusammenfassung";
		$link_trad_fr = "fr/checkout/resume";
		$link_trad_es = "es/checkout/resumen";
	}
	if($step=="esito"){
		$link_trad_it = "it/checkout/esito";
		$link_trad_en = "en/checkout/outcome";
		$link_trad_de = "de/checkout/ergebnis";
		$link_trad_fr = "fr/checkout/resultat";
		$link_trad_es = "es/checkout/resultado";
	}
}
if($cmd=="cambia-password"){
	if(isset($_GET['codice'])) $codice_cliente=$_GET['codice']; else $codice_cliente="";
	
	$link_trad_it = "it/cambia-password-".$codice_cliente.".html";
	$link_trad_en = "en/change-password-".$codice_cliente.".html";
	$link_trad_de = "de/passwort-andern-".$codice_cliente.".html";
	$link_trad_fr = "fr/changer-le-mot-de-passe-".$codice_cliente.".html";
	$link_trad_es = "es/cambiar-contrasena-".$codice_cliente.".html";
}
if($cmd=="privacy_policy" || $cmd=="cookie_policy" || $cmd=="sitemap" || $cmd=="404"){
	$link_trad_it = "it/$cmd.html";
	$link_trad_en = "en/$cmd.html";
	$link_trad_de = "de/$cmd.html";
	$link_trad_fr = "fr/$cmd.html";
	$link_trad_es = "es/$cmd.html";
}
?>
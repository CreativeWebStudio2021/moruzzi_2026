<?php 
$table=$prec_db."ordini";
$pagina="ordini";

$pdo = $open_connection->connection;

$criterio = "1=1"; // Evita problemi con AND iniziale
$params = [];
$rif = "";

$pag_att = $_GET['pag_att'] ?? 1;
$num_ric = $_GET['num_ric'] ?? '';
$stato_ric = $_GET['stato_ric'] ?? '';
$cognome_ric = $_GET['cognome_ric'] ?? '';
$email_ric = $_GET['email_ric'] ?? '';
$dal_ric = $_GET['dal_ric'] ?? '';
$al_ric = $_GET['al_ric'] ?? '';

// Filtri per nome/cognome/azienda
if ($cognome_ric !== "") {
    $criterio .= " AND (nome LIKE ? OR cognome LIKE ? OR azienda LIKE ?)";
    $params[] = "%$cognome_ric%";
    $params[] = "%$cognome_ric%";
    $params[] = "%$cognome_ric%";
    $rif .= "&cognome_ric=" . urlencode($cognome_ric);
}

// Filtro per email
if ($email_ric !== "") {
    $criterio .= " AND email LIKE ?";
    $params[] = "%$email_ric%";
    $rif .= "&email_ric=" . urlencode($email_ric);
}

// Filtro per data ordine dal
if ($dal_ric !== "") {
    $temp = explode("-", $dal_ric);
    if (count($temp) == 3) {
        $data_dal = "{$temp[2]}-{$temp[1]}-{$temp[0]}";
        $criterio .= " AND data_ord >= ?";
        $params[] = $data_dal;
        $rif .= "&dal_ric=" . urlencode($dal_ric);
    }
}

// Filtro per data ordine fino a
if ($al_ric !== "") {
    $temp = explode("-", $al_ric);
    if (count($temp) == 3) {
        $data_al = "{$temp[2]}-{$temp[1]}-{$temp[0]} 23:59:59";
        $criterio .= " AND data_ord <= ?";
        $params[] = $data_al;
        $rif .= "&al_ric=" . urlencode($al_ric);
    }
}

if ($stato_ric != "") { 
	if($stato_ric=="aperti") $criterio.=" AND ( status = 'nuovo' OR status = 'pagato'  OR status='pending' OR status='processing' OR status='holded' OR status='payment_review')"; 
	if($stato_ric=="evasi") $criterio.=" AND ( status = 'spedito'  OR status='complete' OR status='closed' )"; 
	if($stato_ric=="annullati") $criterio.=" AND ( status = 'annullato'  OR status='canceled'  OR status='annullato-negozio' )"; 
	if($stato_ric=="cancellati") $criterio.=" AND status = 'cancellato'"; 
	$rif.="&stato_ric=$stato_ric"; 
}
/*
$criterio="";
$rif="";
if(isset($_GET['pag_att'])) $pag_att=$_GET['pag_att']; else $pag_att=1;
if(isset($_GET['num_ric'])) $num_ric=$_GET['num_ric']; else $num_ric='';
if(isset($_GET['stato_ric'])) $stato_ric=$_GET['stato_ric']; else $stato_ric='';
if(isset($_GET['cognome_ric'])) $cognome_ric=$_GET['cognome_ric']; else $cognome_ric='';
if(isset($_GET['email_ric'])) $email_ric=$_GET['email_ric']; else $email_ric='';
if(isset($_GET['dal_ric'])) $dal_ric=$_GET['dal_ric']; else $dal_ric='';
if(isset($_GET['al_ric'])) $al_ric=$_GET['al_ric']; else $al_ric='';

if($stato_ric!="") { 
	if($stato_ric=="aperti") $criterio.=" AND ( status = 'nuovo' OR status = 'pagato'  OR status='pending' OR status='processing' OR status='holded' OR status='payment_review')"; 
	if($stato_ric=="evasi") $criterio.=" AND ( status = 'spedito'  OR status='complete' OR status='closed' )"; 
	if($stato_ric=="annullati") $criterio.=" AND ( status = 'annullato'  OR status='canceled' )"; 
	if($stato_ric=="cancellati") $criterio.=" AND status = 'cancellato'"; 
	$rif.="&stato_ric=$stato_ric"; 
}
if($num_ric!="") { $criterio.=" AND id='%$num_ric%'"; $rif.="&num_ric=$num_ric"; }
if($cognome_ric!="") { $criterio.=" AND (nome LIKE '%$cognome_ric%' OR cognome LIKE '%$cognome_ric%' OR azienda LIKE '%$cognome_ric%' )"; $rif.="&cognome_ric=$cognome_ric"; }
if($email_ric!="") { $criterio.=" AND email LIKE '%$email_ric%'"; $rif.="&email_ric=$email_ric"; }
if($dal_ric!="") { 
	$temp=explode("-",$dal_ric);
	$data_dal=$temp[2]."-".$temp[1]."-".$temp[0];
	$criterio.=" AND data_ord >= '$data_dal'"; 
	$rif.="&dal_ric=$dal_ric"; 
}
if($al_ric!="") {
	$temp=explode("-",$al_ric);
	$data_al=$temp[2]."-".$temp[1]."-".$temp[0];
	$criterio.=" AND data_ord <= '$data_al : 23:59:59'"; 
	$rif.="&al_ric=$al_ric"; 
}*/
//$rif.="&pag_att=$pag_att";

if(isset($_SESSION['num_elem_ord'])) $num_elem_ord = $_SESSION['num_elem_ord']; else $num_elem_ord = $_SESSION['num_elem_ord'] = "20";
//echo $num_elem_ord;

if($_SESSION["acl_login"]<300)
	$criterio.=" AND status <> 'cancellato'";

if($azione=="cancella" && $id_canc!="")
{	
	$query_canc_prod = "delete from ".$prec_db."ordini_prod where id_ord='$id_canc'";
	$risu_canc_prod = $open_connection->connection->query($query_canc_prod);
	
	$query_canc = "delete from $table where id='$id_canc'";
	$risu_canc = $open_connection->connection->query($query_canc);
	
?>
	<script language="javascript">		
		window.location="admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>";
	</script>
<?php 
} 

if ($id_canc) {
	if ($azione=="attivaf") $query_nov = $open_connection->connection->query("update ".$prec_db."ordini set fatturato='1' where id='$id_canc'");
	if ($azione=="disattivaf") $query_nov = $open_connection->connection->query("update ".$prec_db."ordini set fatturato='0' where id='$id_canc'");	
}

if($azione=="cancella_sel") {
	$stato_orig = "cancellato";
	$stati_con_qty_scalata = ['spedito', 'complete', 'closed', 'annullato-negozio'];

	if(isset($_GET['lista'])) $lista=$_GET['lista']; else $lista="";
	$temp=explode(";",$lista);
	for($z=0; $z<count($temp)-1; $z++){
		$order_id = (int) $temp[$z];
		if ($order_id <= 0) {
			continue;
		}

		$query_stato = "SELECT status FROM ".$prec_db."ordini WHERE id='".$order_id."'";
		$resu_stato = $open_connection->connection->query($query_stato);
		$row_stato = $resu_stato ? $resu_stato->fetch(PDO::FETCH_ASSOC) : false;
		$status_before = $row_stato['status'] ?? '';

		$query_disev = "update ".$prec_db."ordini set status='$stato_orig', data_mod=NOW() where id='".$order_id."'";
		$open_connection->connection->query($query_disev);

		// Ordini aperti: la qty fisica non è mai stata scalata (solo riservata virtualmente dal frontend).
		if (!in_array($status_before, $stati_con_qty_scalata, true)) {
			continue;
		}

		$query_prod="SELECT id_prod, quantita FROM ".$prec_db."ordini_prod WHERE id_ord='".$order_id."'";
		$resu_prod=$open_connection->connection->query($query_prod);
		while($risu_prod=$resu_prod->fetch(PDO::FETCH_ASSOC)){
			$query_quant="SELECT qty FROM ".$prec_db."prodotti WHERE entity_id='".$risu_prod['id_prod']."'";
			$resu_quant=$open_connection->connection->query($query_quant);
			$row_quant = $resu_quant ? $resu_quant->fetch(PDO::FETCH_ASSOC) : false;
			$quant = (int) ($row_quant['qty'] ?? 0);

			$qty_new = ($quant + $risu_prod['quantita']);
			$query_up = "UPDATE " . $prec_db . "prodotti SET qty='" . $qty_new . "', disponibili='" . $qty_new . "'";
			if($qty_new > 0){
				$query_up .= " , status = '1', visibility = '1'";
			}
			$query_up .= " WHERE entity_id='" . $risu_prod['id_prod'] . "'";
			$risu_up=$open_connection->connection->query($query_up);
		}
	}?>
		<script type="text/javascript">
			window.location='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>';
		</script>
	<?php 	
}

if($azione=="annulla_sel") {
	$stato_orig = "annullato";
	$data_pagato = "";
	
	if(isset($_GET['lista'])) $lista=$_GET['lista']; else $lista="";
	$temp=explode(";",$lista);
	for($z=0; $z<count($temp)-1; $z++){		
		$query_disev = "update ".$prec_db."ordini set status='$stato_orig', data_pagato= NULL , data_mod='".date('Y-m-d H:i:s')."' where id='".$temp[$z]."'";
		$open_connection->connection->query($query_disev);
	}?>
		<script type="text/javascript">
			window.location='admin.php?cmd=<?php echo $table;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>';
		</script>
	<?php 	
}

if($azione=="evadi")
{
	$query_ev = "update ".$prec_db."ordini set status='spedito',data_mod='".date('Y-m-d H:i:s')."' where id=$id_rec";
	$risu_ev = $open_connection->connection->query($query_ev);	
	
	$query_cli = "
		SELECT 
			o.nome, 
			o.cognome, 
			o.azienda, 
			o.piva, 
			o.pec_sdu, 
			o.cod_fiscale, 
			o.telefono, 
			o.email,
			o.nome_spe, 
			o.cognome_spe, 
			o.azienda_spe, 
			o.indirizzo_spe, 
			o.citta_spe, 
			o.cap_spe, 
			o.prov_spe, 
			o.paese_spe, 
			o.telefono_spe, 
			o.email_spe, 
			o.totale, 
			o.spese, 
			o.spedizione, 
			o.pagamento, 
			o.data_ord, 
			o.vettore, 
			o.tracciamento,
			o.note_spe 
		FROM 
			".$prefix."ordini as o 
		WHERE 
			o.id ='$id_rec'
		";
	//echo $query_cli."<br/>";
	$risu_cli = $open_connection->connection->query($query_cli);
	$row_cli = $risu_cli ? $risu_cli->fetch(PDO::FETCH_ASSOC) : [];
	$nome = $row_cli['nome'] ?? '';
	$cognome = $row_cli['cognome'] ?? '';
	$rag_sociale = $row_cli['azienda'] ?? '';
	$partita_iva = $row_cli['piva'] ?? '';
	$pec_sdu = $row_cli['pec_sdu'] ?? '';
	$cod_fiscale = $row_cli['cod_fiscale'] ?? '';
	$telefono = $row_cli['telefono'] ?? '';
	$email = $row_cli['email'] ?? '';
	$nome_spe = $row_cli['nome_spe'] ?? '';
	$cognome_spe = $row_cli['cognome_spe'] ?? '';
	$azienda_spe = $row_cli['azienda_spe'] ?? '';
	$indirizzo_spe = $row_cli['indirizzo_spe'] ?? '';
	$citta_spe = $row_cli['citta_spe'] ?? '';
	$cap_spe = $row_cli['cap_spe'] ?? '';
	$prov_spe = $row_cli['prov_spe'] ?? '';
	$paese_spe = $row_cli['paese_spe'] ?? '';
	$telefono_spe = $row_cli['telefono_spe'] ?? '';
	$email_spe = $row_cli['email_spe'] ?? '';
	$totale = $row_cli['totale'] ?? 0;
	$spese = $row_cli['spese'] ?? 0;
	$spedizione = $row_cli['spedizione'] ?? '';
	$pagamento = $row_cli['pagamento'] ?? '';
	$data_ord = $row_cli['data_ord'] ?? '';
	$vettore = $row_cli['vettore'] ?? '';
	$tracciamento = $row_cli['tracciamento'] ?? '';
	$note = $row_cli['note_spe'] ?? '';
	
	$arr_data_ord  = explode(" ",$data_ord);
	$data_ord = date_to_data($arr_data_ord[0]);
	
	$tot_parziale = 0;
	$tot_peso = 0;
	$risu_pro = $open_connection->connection->query("select * from ".$prefix."ordini_prod where id_ord='$id_rec' ");
	$num_pro = $risu_pro->rowCount();
	$lista_prodotti = "";
	for ($p=0; $p<$num_pro; $p++) {
		$arr_dati = $risu_pro->fetch(PDO::FETCH_ASSOC);
		if (!$arr_dati) {
			continue;
		}
		$nomep = $arr_dati['nome'];
		$cod_prod = $arr_dati['cod_prod'];
		$prezzo_uni = $arr_dati['prezzo'];
		$prezzo_parz = $arr_dati['prezzo_f'];
		$peso_uni = $arr_dati['peso'];
		$peso_parz = $arr_dati['peso_f'];
		$pezzi = $arr_dati['quantita'];
		$id_prod = $arr_dati['id_prod'];
																																															
		$tot_parziale += $prezzo_parz;
		$tot_peso += $peso_parz;
		
		$query_dati = "select image from ".$prefix."prodotti where entity_id='$id_prod' ";
		$risu_dati = $open_connection->connection->query($query_dati);
		$row_dati = $risu_dati ? $risu_dati->fetch(PDO::FETCH_ASSOC) : false;
		$image = $row_dati['image'] ?? '';
		
		$lista_prodotti .= "
							<tr>
								<td style='width:56px'>
									<img src='".productImageUrl($image, 'thumb')."' style='width:48px;height:auto;display:block;border-radius:4px;' alt='".htmlspecialchars(substr($nomep, 0, 80), ENT_QUOTES, 'UTF-8')."'>
								</td>
								<td>
									".htmlspecialchars(substr($nomep, 0, 80), ENT_QUOTES, 'UTF-8')."...<br>
									<span style='font-size:12px;color:#666;'>SKU: ".htmlspecialchars($cod_prod, ENT_QUOTES, 'UTF-8')."</span>
								</td>
								<td class='qty'>".$pezzi."</td>
								<td class='price'>€".number_format($prezzo_uni, 2, ',', '.')."</td>
							</tr>
		";
		
		$query_p="SELECT qty FROM ".$prefix."prodotti WHERE entity_id='".$arr_dati['id_prod']."'";
		//echo $query_p."<br/>";
		$risu_p = $open_connection->connection->query($query_p);
		$row_p = $risu_p ? $risu_p->fetch(PDO::FETCH_ASSOC) : false;
		$qty_p = (int) ($row_p['qty'] ?? 0);
		$new_qty = $qty_p - $pezzi;
		if($new_qty<0) $new_qty=0;
		$query_up="UPDATE ".$prefix."prodotti SET qty='".$new_qty."' WHERE entity_id='".$arr_dati['id_prod']."'";
		//echo $query_up."<br/>";
		$risu_up = $open_connection->connection->query($query_up);
	}	
	
	// EMAIL CLIENTE
	$email_body = "../fissi/body_mail_new.css.php";
	$email_oggetto = "Comunicazione evasione ordine num. $id_rec";
	$email_invio = $email;
	$email_cognome = $cognome;
	$email_nome = $nome;
	$emailImg = "notifica-evasione.jpg";
	$emailImgAlt = "Notifica di Evasione Ordine";
	$testo1 = "
				<p>
				Gentile <b>$nome</b> <b>$cognome</b>,
				<br><br>le comunichiamo che il suo ordine num. <b>$id_rec</b> è stato evaso e la relativa merce spedita o ritirata.
	";
	if(isset($vettore) && $vettore!="" && isset($tracciamento) && $tracciamento!=""){
		$testo1 .= "
					<br/>
					<br/>
					<div style='background:#f3ede4;border-radius:8px;padding:16px;'>
							La spedizione avverrà tramite <b>".$vettore."</b>.<br/>
							Per tracciare il pacco seguire il seguente link:<br/>
							<a href='".htmlspecialchars($tracciamento, ENT_QUOTES, 'UTF-8')."'>".htmlspecialchars($tracciamento, ENT_QUOTES, 'UTF-8')."</a>
						</div>
		";
	}
	$testo1 .= "
				<br/>Segue riepilogo dei suoi dati e dettaglio degli articoli ordinati.
				</p>
	";
	
	$riepilogo_ordine = 1;
	$email_lista_prodotti = $lista_prodotti;
	$email_peso = $tot_peso;
	$email_tot_parziale = number_format($tot_parziale, 2, ',', '.');
	$email_spedizione = number_format($spese, 2, ',', '.');
	$email_totale = number_format($tot_parziale+$spese, 2, ',', '.');

	$email_dati_cliente = 1;
		$email_nome = $nome_spe;
		$email_cognome = $cognome_spe;
		$email_indirizzo = $indirizzo_spe;
		$email_cap = $cap_spe;
		$email_citta = $citta_spe." (".$prov_spe.")";
		$email_nazione = $paese_spe;
		$email_telefono = $telefono_spe;
		$email_email = $email;
		$email_cod_fiscale = $cod_fiscale;
		$email_azienda = $azienda_spe;
		$email_piva = $partita_iva;
		$email_sdu = $pec_sdu;

	$email_metodo_sped = $spedizione;
	$email_metodo_pag = ucfirst($pagamento);

	$email_note = $note;
									
	$email_nome_destinatario = $nome_spe;
	$email_cognome_destinatario = $cognome_spe;

	include __DIR__.'/../fissi/send_mail.inc.php';
		
	//include("fissi/mail_evadi.inc.php");
}

if($azione=="disevadi")
{
	$stato_orig = "nuovo";
	
	$data_pagato = "";
	$query_pagato = "select data_pagato from ".$prefix."ordini where id='$id_rec'";
	$risu_pagato = $open_connection->connection->query($query_pagato);
	$row_pagato = $risu_pagato ? $risu_pagato->fetch(PDO::FETCH_ASSOC) : false;
	$data_pagato = $row_pagato['data_pagato'] ?? '';
	
	if ($data_pagato!="") $stato_orig = "pagato";
	
	$query_disev = "update ".$prefix."ordini set status='$stato_orig',data_mod='".date('Y-m-d H:i:s')."' where id='$id_rec'";
	$open_connection->connection->query($query_disev);	
	
	/* ripristino le quantità del prodotto */
	$query_prod="SELECT id_prod, quantita FROM ".$prefix."ordini_prod WHERE id_ord='$id_rec'";
	$resu_prod=$open_connection->connection->query($query_prod);
	while($risu_prod=$resu_prod->fetch(PDO::FETCH_ASSOC)){
		$query_quant="SELECT qty FROM ".$prefix."prodotti WHERE entity_id='".$risu_prod['id_prod']."'";
		$resu_quant=$open_connection->connection->query($query_quant);
		$row_quant = $resu_quant ? $resu_quant->fetch(PDO::FETCH_ASSOC) : false;
		$quant = (int) ($row_quant['qty'] ?? 0);
		
		$query_up="UPDATE ".$prefix."prodotti SET qty='".($quant + $risu_prod['quantita'])."',disponibili='".($quant + $risu_prod['quantita'])."' WHERE entity_id='".$risu_prod['id_prod']."'";
		$risu_up=$open_connection->connection->query($query_up);
	}
}

if($azione=="disannulla")
{
	$stato_orig = "nuovo";
	
	$data_pagato = "";
	$query_pagato = "select data_pagato from ".$prefix."ordini where id='$id_rec'";
	$risu_pagato = $open_connection->connection->query($query_pagato);
	$row_pagato = $risu_pagato ? $risu_pagato->fetch(PDO::FETCH_ASSOC) : false;
	$data_pagato = $row_pagato['data_pagato'] ?? '';
	
	if ($data_pagato!="") $stato_orig = "pagato";
	
	$query_disev = "update ".$prefix."ordini set status='$stato_orig',data_mod='".date('Y-m-d H:i:s')."' where id='$id_rec'";
	$open_connection->connection->query($query_disev);	
}

if($azione=="annulla")
{
	$stato_orig = "annullato";
	
	$data_pagato = "";
	
	$query_disev = "update ".$prefix."ordini set status='$stato_orig',data_pagato= NULL,data_mod='".date('Y-m-d H:i:s')."' where id='$id_rec'";
	/*echo $query_disev;*/
	$open_connection->connection->query($query_disev);	
}

if($azione=="annulla-negozio")
{
	$stato_orig = "annullato-negozio";
	$query_disev = "update ".$prefix."ordini set status='$stato_orig', data_pagato= NULL, data_mod=NOW() where id='$id_rec'";
	$open_connection->connection->query($query_disev);

	/* scalo la quantità del prodotto come fosse un'evasione */
	$query_prod = "SELECT id_prod, quantita FROM ".$prefix."ordini_prod WHERE id_ord='$id_rec'";
	$resu_prod = $open_connection->connection->query($query_prod);
	while($risu_prod = $resu_prod->fetch(PDO::FETCH_ASSOC)){
		$query_up = "UPDATE ".$prefix."prodotti SET `qty` = (`qty` - " . (int)$risu_prod['quantita'] . "),  `disponibili` = (`disponibili` - " . (int)$risu_prod['quantita'] . ")  WHERE entity_id='" . (int)$risu_prod['id_prod'] . "'";
		$risu_up=$open_connection->connection->query($query_up);
	}
}

if($azione=="canc")
{
	$stato_orig = "cancellato";
	$stati_con_qty_scalata = ['spedito', 'complete', 'closed', 'annullato-negozio'];

	$query_stato = "SELECT status FROM ".$prefix."ordini WHERE id='$id_rec'";
	$resu_stato = $open_connection->connection->query($query_stato);
	$row_stato = $resu_stato ? $resu_stato->fetch(PDO::FETCH_ASSOC) : false;
	$status_before = $row_stato['status'] ?? '';

	$query_disev = "update ".$prefix."ordini set status='$stato_orig', data_mod=NOW() where id='$id_rec'";
	$open_connection->connection->query($query_disev);

	if (in_array($status_before, $stati_con_qty_scalata, true)) {
		$query_prod="SELECT id_prod, quantita FROM ".$prefix."ordini_prod WHERE id_ord='$id_rec'";
		$resu_prod=$open_connection->connection->query($query_prod);
		while($risu_prod=$resu_prod->fetch(PDO::FETCH_ASSOC)){
			$query_quant="SELECT qty FROM ".$prefix."prodotti WHERE entity_id='".$risu_prod['id_prod']."'";
			$resu_quant=$open_connection->connection->query($query_quant);
			$row_quant = $resu_quant ? $resu_quant->fetch(PDO::FETCH_ASSOC) : false;
			$quant = (int) ($row_quant['qty'] ?? 0);

			$query_up="UPDATE ".$prefix."prodotti SET qty='".($quant + $risu_prod['quantita'])."',disponibili='".($quant + $risu_prod['quantita'])."' WHERE entity_id='".$risu_prod['id_prod']."'";
			$risu_up=$open_connection->connection->query($query_up);
		}
	}
}

?>
<script type="text/javascript">
	var lista_ind=new Array();
	var lista_del="";
	var lista_tutti="";
	function aggiungi_lista(id_check, id_campo){
		if(document.getElementById('check_'+id_check).checked) {
			lista_del+=id_campo+";";
		} else {
			lista_del = lista_del.replace(id_campo+";", "");
		}
		if(lista_del!=""){
			document.getElementById('cancella_sel').style.display="block";
			document.getElementById('cancella_sel').href='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>&azione=cancella_sel&lista='+lista_del;
			
			document.getElementById('annulla_sel').style.display="block";
			document.getElementById('annulla_sel').href='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>&azione=annulla_sel&lista='+lista_del;
		}else{
			document.getElementById('cancella_sel').style.display="none";
			document.getElementById('annulla_sel').style.display="none";
		}
	}
	
	function aggiugni_tutti(){
		start = document.getElementById('start').innerHTML;
		end = document.getElementById('end').innerHTML;
		total = document.getElementById('total').innerHTML;

		if(document.getElementById('check_tutti').checked){
			for(i=start-1; i<end; i++){
				lista_tutti+=lista_ind[i]+";";
			}
			for(i=start; i<=end; i++){
				document.getElementById('check_'+i).checked=true;
			}
			document.getElementById('cancella_sel').style.display="block";
			document.getElementById('cancella_sel').href='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>&azione=cancella_sel&lista='+lista_tutti;
			document.getElementById('annulla_sel').style.display="block";
			document.getElementById('annulla_sel').href='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>&azione=annulla_sel&lista='+lista_tutti;
		}else{
			lista_tutti="";
			for(i=start; i<=total; i++){
				document.getElementById('check_'+i).checked=false;
			}
			document.getElementById('cancella_sel').style.display="none";
			document.getElementById('annulla_sel').style.display="none";
		}	
	}
	
	function cambiaSessionVarAdmin(nomeVar, valoreVar){
		$.ajax({
			url: 'ajax/cambiaSessionVarAdmin.php', // URL del file PHP che gestisce la richiesta
			type: 'GET', // Tipo di richiesta (GET o POST)
			data: {
				nomeVar: nomeVar,
				valoreVar: valoreVar
			},
			//dataType: 'json', // Tipo di dati che ci aspettiamo di ricevere
			success: function(response) {
				// Gestisci la risposta ricevuta dal server
				$("#result").html(response);
			},
			error: function(xhr, status, error) {
				// Gestisci eventuali errori
				$("#result").html("Si è verificato un errore: " + error);
			},
			complete: function() {
				// Ricarica la pagina dopo il completamento della chiamata AJAX
				window.location.reload();
			}
		});
	}
</script>
<div class="mws-panel grid_8">
	<div style="height:50px;font-size:1.2em;padding-top:10px"><b><?php echo ucfirst($pagina)." ".$stato_ric;?></b></div>
	
	<div id="start" style="display:none"></div>
	<div id="end" style="display:none"></div>
	<div id="total" style="display:none"></div>
	
	<iframe src="" style="display:none" id="frame_action"></iframe>
	<iframe src="" style="display:none" id="frame_action2"></iframe>
	
	<script type="text/javascript">
		var open=0;
		function apri_ricerca(){
			if(open==0){
				open=1;
				$("#searchPanel").animate({height:"260px"});
				document.getElementById('searchHeader').innerHTML='<span><i class="fa fa-search-minus" style="color:#fff"></i> Ricerca</span>';
			} else {
				open=0;
				$("#searchPanel").animate({height:"0px"});
				document.getElementById('searchHeader').innerHTML='<span><i class="fa fa-search-plus" style="color:#fff"></i> Ricerca</span>';
			}
		}
	</script>
	
	<div class="mws-panel-header" style="cursor:pointer;" onclick="apri_ricerca();" id="searchHeader">
		<span><i class="fa fa-search-plus" style="color:#fff"></i> Ricerca</span>
	</div>
	<div class="mws-panel-body no-padding" style="height:0px; overflow:hidden" id="searchPanel">
		<form name="ricerca" class="mws-form" action="admin.php" method="GET" enctype="multipart/form-data">
			<input type="hidden" name="ric_stato" value="inviato">
			<input type="hidden" name="cmd" value="<?php echo $pagina;?>">
			
			<div class="mws-form-inline">
				
				<div class="mws-form-row">
					<div style="float:left; width:15%;">
						<label class="mws-form-label">Stato Ordine</label>						
					</div>
					<div style="float:left; width:35%;">
						<select name="stato_ric" class="small" style="width:90%">
							<option value="">Tutti</option>		
							<option value="aperti" <?php if($stato_ric=="aperti"){?>selected="selected"<?php }?>>Ordini Aperti</option>		
							<option value="evasi" <?php if($stato_ric=="evasi"){?>selected="selected"<?php }?>>Ordini Evasi</option>		
							<option value="annullati" <?php if($stato_ric=="annullati"){?>selected="selected"<?php }?>>Ordini Annullati</option>
							<?php if($_SESSION["acl_login"]>200){?>
								<option value="cancellati" <?php if($stato_ric=="cancellati"){?>selected="selected"<?php }?>>Ordini Cancellati (solo Admin)</option>	
							<?php }?>
						</select>
					</div>
					
					<div style="float:left; width:15%;">
						<label class="mws-form-label">Cod. Ordine</label>						
					</div>
					<div style="float:left; width:35%;">
						<input type="text" name="num_ric" value="<?php echo $num_ric;?>"  style="width:20%"/>
					</div>
					<div style="clear:both;"></div>
				</div>				
				
				<div class="mws-form-row">
					<div style="float:left; width:15%;">
						<label class="mws-form-label">Dal</label>						
					</div>
					<div style="float:left; width:35%;">
						<input type="text" name="dal_ric" class="mws-datepicker large"  value="<?php echo $dal_ric;?>" readonly="readonly" style="width:90%">
					</div>
					<div style="float:left; width:15%;">
						<label class="mws-form-label">Al</label>						
					</div>
					<div style="float:left; width:35%;">
						<input type="text" name="al_ric" class="mws-datepicker large"  value="<?php echo $al_ric;?>" readonly="readonly" style="width:90%">
					</div>
					<div style="clear:both;"></div>
				</div>		
				
				<div class="mws-form-row">
					<div style="float:left; width:15%;">
						<label class="mws-form-label">Cliente</label>						
					</div>
					<div style="float:left; width:35%;">
						<input type="text" name="cognome_ric" value="<?php echo $cognome_ric;?>"  style="width:90%"/>
					</div>
					<div style="float:left; width:15%;">
						<label class="mws-form-label">Email</label>						
					</div>
					<div style="float:left; width:35%;">
						<input type="text" name="email_ric" value="<?php echo $email_ric;?>"  style="width:90%"/>
					</div>
					<div style="clear:both;"></div>
				</div>
				
			</div>
			<div class="mws-button-row">
				<input type="submit" value="Cerca" class="btn btn-danger">
				<input type="button" value="Annulla" class="btn" onclick="window.location='admin.php?cmd=<?php echo $pagina;?>'">
			</div>
		</form>
	</div>
	<div style="height:30px;width:100%;text-align:right; margin-top:15px"></div>
	
	<div class="product-page-per-view">
		<select onchange="cambiaSessionVarAdmin('num_elem_ord',this.value);" class="pt-sans-bold">
		  <option value="20" <?php if($num_elem_ord == 20){?>selected="selected"<?php }?>>20 Elementi Per Pagina</option>
		  <option value="50" <?php if($num_elem_ord == 50){?>selected="selected"<?php }?>>50 Elementi Per Pagina</option>
		  <option value="100" <?php if($num_elem_ord == 100){?>selected="selected"<?php }?>>100 Elementi Per Pagina</option>
		  <option value="200" <?php if($num_elem_ord == 200){?>selected="selected"<?php }?>>200 Elementi Per Pagina</option>
		  <option value="500" <?php if($num_elem_ord == 200){?>selected="selected"<?php }?>>500 Elementi Per Pagina</option>
		</select>
	</div>
		
	<div style="clear:both;height:20px">&nbsp;</div>
	<?php 
	$query_ele = "SELECT * FROM $table WHERE $criterio ORDER BY data_ord DESC";
	$stmt = $pdo->prepare($query_ele);
	$stmt->execute($params);
	$num_ele = $stmt->rowCount();

	if ($num_ele > 0) {
	
	/*$query_ele = "SELECT * FROM $table WHERE 1 $criterio ORDER BY data_ord desc";	
	$risu_ele = $open_connection->connection->query($query_ele);
		
	$num_ele = 0;
	if($risu_ele){*/
		$num_ord=0;
		$tot_ord=0;
		while($risu_tot=$stmt->fetch()){
			$totale = $risu_tot['totale'];
			$tot_ord=$tot_ord + $totale;
		}
	}
	?>
	<?php if($stato_ric=="aperti" || $stato_ric=="evasi"){?>
		<div style="float:left;" id="num_ord"><b>Numero ordini</b>: <?php echo $num_ele;?></div>
		<!--<div style="float:left;width:50%;text-align:right;height:30px"><a style="color:#000" href="admin.php?cmd=<?php echo $table;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>&azione=scarica_ordini">Scarica il file degli ordini</a></div>-->
		<div style="float:left;margin-left:20px;" id="tot_ord"><b>Totale</b>: <?php echo number_format($tot_ord, 2, ',', '.');?></div>
		<div style="clear:both"></div>
	<?php }?>
	
	<div class="mws-panel-header" style="position:relative;">
		<span><i class="icon-table"></i> Elenco <?php echo $pagina;?></span>
		<div style="position:absolute; top:13px; right:20px; z-index:11">
			
		</div>
	</div>
	<div class="mws-panel-body no-padding">
		<table class="mws-datatable-fn mws-table">
			<thead>
				<tr>
					<th style="width:20px"><input type="checkbox" id="check_tutti" onclick="aggiugni_tutti()"/></th>
					<th style="width:20px"></th>
					<th style="text-align:left;width:20px">Cod.</th>			
					<th style="width:150px">Data</th>
					<th style="min-width:30px">Cliente</th>
					<th style="width:70px">Totale</th>
					<th style="width:50px">Stato</th>
					<th style="width:70px">Pagato il</th>
					<!--<th style="min-width:30px">Fatturato</th>-->
					<th style="text-align:left;">Azioni</th>
				</tr>
			</thead>
			<tbody>
			<?php 			
				//$rec_pag=20;
				$rec_pag=$num_elem_ord;
				$start=0;
				$pag_tot=0;
				
				if($num_ele>0)
				{				
					//$rec_pag=20;
					$rec_pag=$num_elem_ord;					
					$pag_tot=ceil($num_ele/$rec_pag);					
					$start=($pag_att-1)*$rec_pag;
					
					$query_ele = "SELECT * FROM $table WHERE $criterio ORDER BY data_ord DESC  LIMIT $start, $rec_pag";
					$stmt = $pdo->prepare($query_ele);
					
					$stmt->execute($params);
					$num_item = $stmt->rowCount();
					
					/*$query_ele = "SELECT * FROM $table WHERE 1 $criterio ORDER BY data_ord DESC LIMIT $start,$rec_pag";
					$risu_ele = $open_connection->connection->query($query_ele);
					$num_item=$risu_ele->rowCount();	*/
					for($x=0;$x<$num_item;$x++)
					{						
						$arr_ele = $stmt->fetch();
						$temp=explode(" ",$arr_ele['data_ord']);
						$temp2=explode("-",$temp[0]);
						$data_ord = $temp2[2]."-".$temp2[1]."-".$temp2[0];
						$nome = $arr_ele['nome'];
						$cognome = $arr_ele['cognome'];
						$rag_sociale = ucfirst($arr_ele['azienda']);
						$totale = $arr_ele['totale'];
						$spese = $arr_ele['spese'];
						$status = $arr_ele['status'];
						$vettore = $arr_ele['vettore'];
						$tracciamento = $arr_ele['tracciamento'];
						/*$fatturato = $arr_ele['fatturato'];*/
						$pagamento = $arr_ele['pagamento'];
						if($arr_ele['data_pagato'] && $arr_ele['data_pagato']!=""){
							$temp=explode(" ",$arr_ele['data_pagato']);
							$temp2=explode("-",$temp[0]);
							$data_pagato = $temp2[2]."-".$temp2[1]."-".$temp2[0];
						}else $data_pagato = "";
						$id_campo = $arr_ele['id'];
						
						$str_nome = "";
						if ($nome!="") {
							$str_nome = ucwords($nome)." ".ucwords($cognome);
							if ($rag_sociale!="" && $rag_sociale!=" ")  $str_nome .= "<br /><i>($rag_sociale)</i>";
						} else $str_nome = ucwords($rag_sociale);
						
						?>
						<script type="text/javascript">
							lista_ind[<?php echo $x;?>]="<?php echo $id_campo;?>";
						</script>
						<tr class="riga_<?php if($x % 2){?>pari<?php }else{?>dispari<?php }?>">
							<td align="center" valign="center">
								<input type="checkbox" id="check_<?php echo $x+1;?>" onclick="aggiungi_lista('<?php echo $x+1;?>','<?php echo $id_campo;?>')"/>
							</td>
							<td align="center" valign="center"><?php  echo $start+$x+1; ?></td>
							<td valign="center" style="line-height:14px">
								<b><?php echo $id_campo;?></b>
							</td>
							
							<td  align="center" valign="center" id="vis_<?php echo $id_campo;?>">
								<?php echo $data_ord;?>
							</td>
							
							<td  align="left" valign="center" id="vis_<?php echo $id_campo;?>">
								<?php if ((int) $arr_ele['id_cliente'] > 0) { ?>
									<a href="admin.php?cmd=clienti_mod&id_rec=<?php echo $arr_ele['id_cliente'];?>" style="text-decoration:underline; color:#333333"><?php echo $str_nome;?></a>
								<?php } else { ?>
									<?php echo $str_nome; ?>
								<?php } ?>
							</td>
							
							<td  align="right" valign="center" id="vis_ing_<?php echo $id_campo;?>">
								<?php echo number_format($totale, 2, ',', '.');?> &euro;
							</td>
							
							<td  align="center" valign="center" id="vis_ing_<?php echo $id_campo;?>" style="<?php if($status=="annullato" || $status=="cancellato"){?>color:red;<?php }elseif($status=="pagato" || $status=="spedito"){?>color:green;<?php }?> <?php if($status=="cancellato" || $status=="spedito"){?>font-weight:bold;<?php }?>">
								<?php echo $status;?>
							</td>
							
							<td  align="center" valign="center" id="vis_ing_<?php echo $id_campo;?>">
								<?php echo $data_pagato;?>
							</td>	

							<td style="width:10%" valign="center">
								<span class="btn-group">
									<a href="admin.php?cmd=<?php echo $pagina;?>-dett&id_rec=<?php  echo $id_campo; ?><?php echo $rif;?>" class="btn btn-small"><i class="fa fa-search"></i></a>
									<?php if($status!='cancellato'){?>
										<?php if($status!='spedito' && $status!='annullato' && $status!='annullato-negozio'){
											if ($status=="pagato"){?>
												<a OnClick="return confirm('Sei sicuro di voler evedere questo ordine?');" href="admin.php?cmd=ordini&azione=evadi&id_rec=<?php  echo $id_campo; ?><?php echo $rif;?>" class="btn btn-small" title="Evadi" <?php if(isset($vettore) && $vettore!="" && isset($tracciamento) && $tracciamento!=""){?>style="color:green"<?php }?>><i class="fa fa-paper-plane"></i></a>
											<?php }else{?>
												<a href="" style="pointer-events: none; cursor: default;" class="btn btn-small">&nbsp;&nbsp;&nbsp;</a>
											<?php }?>
										<?php }elseif($status=='spedito'){?>									
											<a  OnClick="return confirm('Sei sicuro di voler ripristinare questo ordine?');"href="admin.php?cmd=ordini&azione=disevadi&id_rec=<?php  echo $id_campo; ?><?php echo $rif;?>" class="btn btn-small" title="Riporta tra gli ordini aperti"><i class="fa fa-refresh"></i></a>
										<?php }else{?>
											<a href="" style="pointer-events: none; cursor: default;" class="btn btn-small">&nbsp;&nbsp;&nbsp;</a>
										<?php }?>
										
										<?php if($status !='annullato' && $status!='canceled' && $status != 'annullato-negozio'){?>
											<a href="admin.php?cmd=<?php echo $pagina;?>&azione=annulla-negozio&id_rec=<?php  echo $id_campo; ?><?php echo $rif;?>" class="btn btn-small" title="Annulla da Negozio" onclick="return confirm('L\'ordine verrà spostato nella sezione \'Ordini Annullati\' e verranno persi eventuali riferimenti a pagamenti effettuati. Confermi l\'annullamento?');"><i class="icon-trash"></i></a>
										<?php }else{?>
											<a  OnClick="return confirm('Sei sicuro di voler ripristinare questo ordine?');"href="admin.php?cmd=ordini&azione=disannulla&id_rec=<?php  echo $id_campo; ?><?php echo $rif;?>" class="btn btn-small" title="Riporta tra gli ordini aperti"><i class="fa fa-refresh"></i></a>
										<?php }?>
										
										<!--
										<?php if($status != 'annullato' && $status != 'canceled' && $status != 'annullato-negozio' ){?>
											<a href="admin.php?cmd=<?php echo $pagina;?>&azione=annulla-negozio&id_rec=<?php  echo $id_campo; ?><?php echo $rif;?>" class="btn btn-small" title="Annulla da Negozio" onclick="return confirm('L\'ordine verrà spostato nella sezione \'Ordini Annullati\' e verranno persi eventuali riferimenti a pagamenti effettuati. Confermi l\'annullamento?');"><i class="icon-home"></i></a>
										<?php }?>
										-->									
										<?php /*<a href="admin.php?cmd=<?php echo $pagina;?>&azione=canc&id_rec=<?php  echo $id_campo; ?><?php echo $rif;?>" class="btn btn-small" title="Cancella" onclick="return confirm('L\'ordine verrà definitivamente cancellato e le quantità di magazzino dei prodotti verranno ripristinate. Confermi la cancellazione?');"><i class="icon-trash"></i></a>*/?>
									<?php }else{?>
										<a href="" style="pointer-events: none; cursor: default;" class="btn btn-small">&nbsp;&nbsp;&nbsp;</a>
										<a href="" style="pointer-events: none; cursor: default;" class="btn btn-small">&nbsp;&nbsp;&nbsp;</a>
										<a href="" style="pointer-events: none; cursor: default;" class="btn btn-small">&nbsp;&nbsp;&nbsp;</a>
									<?php }?>
								</span>
							</td>
						</tr>
						<?php /*$num_ord++; $tot_ord=$tot_ord + $totale;*/
					}
				}?>
				<?php /*if($stato_ric=="aperti" || $stato_ric=="evasi"){?>
					<script type="text/javascript">
						document.getElementById('num_ord').innerHTML='<b>Numero ordini</b>: <?php echo $num_ord;?>';
						document.getElementById('tot_ord').innerHTML='<b>Totale</b>: <?php echo  number_format($tot_ord, 2, ',', '.');?> &euro;';
					</script>
				<?php }*/?>
			</tbody>
		</table>		
		<?php include("fissi/multipagina.inc.php");?>

		<!-- <a href=""  onClick="return confirm('Gli ordini verranno spostati nella sezione \'Ordini Annullati\' e verranno persi eventuali riferimenti a pagamenti effettuati. Confermi l\'annullamento?')" id="annulla_sel" style="display:none;"><div style="padding:5px"><input type="button" value="ANNULLA SELEZIONATI"/></div></a> -->

		<a href=""  onClick="return confirm('Gli ordini verranno definitivamente cancellati e le quantità di magazzino dei prodotti verranno ripristinate. Confermi la cancellazione?')" id="cancella_sel" style="display:none;"><div style="padding:5px"><input type="button" value="CANCELLA SELEZIONATI"/></div></a>
	</div>
</div>
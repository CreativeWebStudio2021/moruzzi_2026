<?php 
$table=$prec_db."prodotti";
$pagina="prodotti";

$criterio="1";
$rif="";
$params = [];

if(isset($_GET['cat_ric'])) $cat_ric=$_GET['cat_ric']; else $cat_ric='';
if($cat_ric!="") {
	$criterio.=" AND categorie LIKE '%@$cat_ric@%'";
	$rif.="&cat_ric=$cat_ric";
}
if(isset($_GET['nome_ric'])) $nome_ric=$_GET['nome_ric']; else $nome_ric='';
if($nome_ric!="") {
	$criterio.=" AND (name LIKE ? OR sku LIKE ?)";
	$rif.="&nome_ric=$nome_ric";
	$params[] = "%$nome_ric%";
    $params[] = "%$nome_ric%";
}
if(isset($_GET['visibilita_ric'])) $visibilita_ric=$_GET['visibilita_ric']; else $visibilita_ric="";
if($visibilita_ric!="") {
	if($visibilita_ric==1){
		$criterio.=" AND (visibility='1' OR visibility='4') ";
	}else{
		$criterio.=" AND visibility='0'";
	}
	$rif.="&visibilita_ric=$visibilita_ric";
}
if(isset($_GET['evidenza_ric'])) $evidenza_ric=$_GET['evidenza_ric']; else $evidenza_ric="";
if($evidenza_ric!="") {
	if($evidenza_ric=="1")
		$criterio.=" AND categorie LIKE '%@1435@%'";
	else
		$criterio.=" AND categorie NOT LIKE '%@1435@%'";
	$rif.="&evidenza_ric=$evidenza_ric";
}
if(isset($_GET['offerta_ric'])) $offerta_ric=$_GET['offerta_ric']; else $offerta_ric="";
if($offerta_ric!="") {
	if($offerta_ric=="1")
		$criterio.=" AND categorie LIKE '%@969@%'";
	else
		$criterio.=" AND categorie NOT LIKE '%@969@%'";
	$rif.="&offerta_ric=$offerta_ric";
}
if(isset($_GET['qty_ric'])) $qty_ric=$_GET['qty_ric']; else $qty_ric="";
if($qty_ric!="") {
	if($qty_ric==0){
		$criterio.=" AND qty=0";
	}else{
		$criterio.=" AND qty>0";
	}
	$rif.="&qty_ric=$qty_ric";
}
if(isset($_GET['novita_ric'])) $novita_ric=$_GET['novita_ric']; else $novita_ric="";
if($novita_ric!="") {
	$criterio.=" AND novita='$novita_ric'";
	$rif.="&novita_ric=$novita_ric";
}

if(isset($_GET['pag_att'])) $pag_att=$_GET['pag_att']; else $pag_att=1;
//$rif.="&pag_att=$pag_att";

if(isset($_SESSION['num_elem_prod'])) $num_elem_prod = $_SESSION['num_elem_prod']; else $num_elem_prod = $_SESSION['num_elem_prod'] = "20";
//echo $num_elem_prod;

if($azione=="cancella" && $id_canc!="")
{	
	$query_canc_img = "select image from $table where entity_id='$id_canc'";
	$risu_canc_img = $open_connection->connection->query($query_canc_img);
	if ($risu_canc_img) {
		$row_img = $risu_canc_img->fetch(PDO::FETCH_ASSOC);
		productImageDeleteR2($row_img['image'] ?? null);
	}
	
	$query_canc = "delete from $table where entity_id='$id_canc'";
	$risu_canc = $open_connection->connection->query($query_canc);

?>
	<script language="javascript">		
		//window.alert("Il campo e' stato cancellato con successo");
		window.location="admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>";
	</script>
<?php 
} 
if($azione=="duplica" && $id_canc!="")
{	
	$query = "SELECT * FROM ".$prefix."prodotti WHERE entity_id = '".$id_canc."'";
    $risu = $open_connection->connection->query($query);
    $arr = $risu->fetch();
	
	if (isset($arr)) {
		$newImagePath = !empty($arr['image']) ? productImageDuplicateR2($arr['image']) : null;

		$new_url_key = $arr['url_key'];
		$new_url_key = str_replace("-".$arr['entity_id'],"",$new_url_key);		
		
		unset($arr['entity_id']);
		
		foreach($arr AS $key=>$value){
			if(is_numeric($key))
				unset($arr[$key]);
		}
		
		$arr['qty'] = 1;
        $arr['disponibili'] = 1;
        $arr['visibility'] = '0';
        $arr['image'] = $newImagePath ?: $arr['image'];
				        
        // Costruisci la query di inserimento
        $columns = implode(", ", array_keys($arr));
        $values = ":" . implode(", :", array_keys($arr));
        $sql = "INSERT INTO ".$prefix."prodotti ($columns) VALUES ($values)";
        //echo $sql."<br/>";
		//print_r($arr);
		//echo "<br/>";
        $stmt = $open_connection->connection->prepare($sql);
        $stmt->execute($arr);
		
		$last_id = $open_connection->connection->lastInsertId();
		$new_url_key = $new_url_key."-".$last_id;
		
		$query_up="UPDATE ".$prefix."prodotti SET url_key='".$new_url_key."' WHERE entity_id='".$last_id."'";
		//echo $query_up."<br/>";
		$risu_up = $open_connection->connection->query($query_up);
		?>
		<script language="javascript">		
			window.location="admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>";
		</script>
		<?php 
	}
}
/*
if ($id_canc) {	
	if ($macro_ric!="" && $cat_ric!="") {
		if($azione=="sali") $oggetto_admin->sali("$table", "$id_canc", "id_macro", "$macro_ric", "id_cat", "$cat_ric") ;
		if($azione=="scendi") $oggetto_admin->scendi("$table", "$id_canc", "id_macro", "$macro_ric", "id_cat", "$cat_ric") ;
		if($azione=="primo") $oggetto_admin->primo("$table", "$id_canc", "id_macro", "$macro_ric", "id_cat", "$cat_ric") ;
		if($azione=="ultimo") $oggetto_admin->ultimo("$table", "$id_canc", "id_macro", "$macro_ric", "id_cat", "$cat_ric") ;
		if($azione=="cambia") {
			if(isset($_GET['new_pos'])) $new_pos=$_GET['new_pos']; else $new_pos="";
			if($new_pos!="") $oggetto_admin->cambia("$table", "$id_canc", "$new_pos", "id_macro", "$macro_ric", "id_cat", "$cat_ric") ;	
		}
	} elseif ($macro_ric!="") {
		if($azione=="sali") $oggetto_admin->sali("$table", "$id_canc", "id_macro", "$macro_ric") ;
		if($azione=="scendi") $oggetto_admin->scendi("$table", "$id_canc", "id_macro", "$macro_ric") ;
		if($azione=="primo") $oggetto_admin->primo("$table", "$id_canc", "id_macro", "$macro_ric") ;
		if($azione=="ultimo") $oggetto_admin->ultimo("$table", "$id_canc", "id_macro", "$macro_ric") ;
		if($azione=="cambia") {
			if(isset($_GET['new_pos'])) $new_pos=$_GET['new_pos']; else $new_pos="";
			if($new_pos!="") $oggetto_admin->cambia("$table", "$id_canc", "$new_pos", "id_macro", "$macro_ric") ;	
		}
	} else {
		if($azione=="sali") $oggetto_admin->sali("$table", "$id_canc") ;
		if($azione=="scendi") $oggetto_admin->scendi("$table", "$id_canc") ;
		if($azione=="primo") $oggetto_admin->primo("$table", "$id_canc") ;
		if($azione=="ultimo") $oggetto_admin->ultimo("$table", "$id_canc") ;
		if($azione=="cambia") {
			if(isset($_GET['new_pos'])) $new_pos=$_GET['new_pos']; else $new_pos="";
			if($new_pos!="") $oggetto_admin->cambia("$table", "$id_canc", "$new_pos") ;	
		}
	}
	
	if($azione=="sali" || $azione=="scendi" || $azione=="primo" || $azione=="ultimo" || $azione=="cambia"){?>
		<script type="text/javascript">
			window.location='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>';
		</script>
	<?php }
	
	if ($azione=="attiva") $query_agg = $open_connection->connection->query("update $table set visibile='1' where id='$id_canc'");
	if ($azione=="disattiva") $query_agg = $open_connection->connection->query("update $table set visibile='0' where id='$id_canc'");
	
	if ($azione=="attivan") $query_nov = $open_connection->connection->query("update $table set novita='1' where id='$id_canc'");
	if ($azione=="disattivan") $query_nov = $open_connection->connection->query("update $table set novita='0' where id='$id_canc'");

	if ($azione=="attivah") $query_home = $open_connection->connection->query("update $table set home='1' where id='$id_canc'");
	if ($azione=="disattivah") $query_home = $open_connection->connection->query("update $table set home='0' where id='$id_canc'");
}*/

if($azione=="cancella_sel") {
	if(isset($_GET['lista'])) $lista=$_GET['lista']; else $lista="";
	$temp=explode(";",$lista);
	for($z=0; $z<count($temp)-1; $z++){
		$query_canc_img = "select image from $table where entity_id='".$temp[$z]."'";
		$risu_canc_img = $open_connection->connection->query($query_canc_img);
		if ($risu_canc_img) {
			$row_img = $risu_canc_img->fetch(PDO::FETCH_ASSOC);
			productImageDeleteR2($row_img['image'] ?? null);
		}
		
		$query_canc = "delete from $table where entity_id='".$temp[$z]."'";
		$risu_canc = $open_connection->connection->query($query_canc);
	}?>
		<script type="text/javascript">
			window.location='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>';
		</script>
	<?php 	
}
?>
<script type="text/javascript">
	var lista_ind=new Array();
	var lista_del="";
	var lista_tutti="";
	function aggiungi_lista(id_check, id_campo){
		if(document.getElementById('check_'+id_check).checked){
			lista_del+=""+id_campo+";";
		} else {
			lista_del = lista_del.replace(id_campo+";", "");
		}
		if(lista_del!=""){
			document.getElementById('cancella_sel').style.display="block";
			document.getElementById('cancella_sel').href='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>&azione=cancella_sel&lista='+lista_del;
		}else{
			document.getElementById('cancella_sel').style.display="none";
		}
	}
	
	function aggiugni_tutti(){
		start = document.getElementById('start').innerHTML;
		end = document.getElementById('end').innerHTML;
		total = document.getElementById('total').innerHTML;
		
		if(document.getElementById('check_tutti').checked){
			ind_lista = 0;
			ind_check = 1;
			for(i=start-1; i<end; i++){
				lista_tutti+=lista_ind[ind_lista]+";";
				ind_lista++;
			}
			for(i=start; i<=end; i++){
				if(document.getElementById('check_'+ind_check))
					document.getElementById('check_'+ind_check).checked=true;
				ind_check++;
			}
			document.getElementById('cancella_sel').style.display="block";
			document.getElementById('cancella_sel').href='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>&azione=cancella_sel&lista='+lista_tutti;
		}else{
			lista_tutti="";
			ind_check = 1;
			for(i=start; i<=total; i++){
				if(document.getElementById('check_'+ind_check))
					document.getElementById('check_'+ind_check).checked=false;
				ind_check++;
			}
			document.getElementById('cancella_sel').style.display="none";
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
	<div style="height:50px;font-size:1.2em;padding-top:10px"><b><?php echo ucfirst($pagina);?></b></div>
		
	<div id="start" style="display:none"></div>
	<div id="end" style="display:none"></div>
	<div id="total" style="display:none"></div>
	
	<div class="mws-panel-header" style="cursor:pointer;" onclick="apri_ricerca();" id="searchHeader">
		<span><i class="fa fa-search-plus" style="color:#fff"></i> Ricerca prodotti</span>
	</div>
	<div class="mws-panel-body no-padding" id="searchPanel">
		<form name="ricerca" class="mws-form" action="admin.php" method="GET" enctype="multipart/form-data">
			<input type="hidden" name="cmd" value="<?php echo $pagina;?>">
			<input type="hidden" name="pag_att" value="<?php echo $pag_att;?>">
			
			<div class="mws-form-inline">					
				<div class="mws-form-row">
					<div style="float:left; width:15%;">
						<label class="mws-form-label">Categoria</label>						
					</div>
					<div style="float:left; width:85%;">
						<select name="cat_ric" class="small" style="width:90%">
							<option value="">- Seleziona -</option>
							<?php printCategoryTreeSelect(2,$open_connection, $cat_ric);?>				
						</select>
					</div>
					
					<div style="clear:both;"></div>
				</div>
								
				<div class="mws-form-row">					
					<div style="float:left; width:15%;">
						<label class="mws-form-label">Nome/Codice art.</label>
					</div>
					<div style="float:left; width:35%;">
						<input type="text" name="nome_ric" value="<?php echo $nome_ric;?>" style="width:95%"/>
					</div>	
					
					<div style="float:left; width:15%;">
						<label class="mws-form-label">Visibili</label>
					</div>
					<div style="float:left; width:18%;">
						<select name="visibilita_ric" class="small" style="width:90%">
							<option value="">Tutti</option>
							<option value="1" <?php if($visibilita_ric=="1"){?>selected="selected"<?php }?>>Si</option>
							<option value="0" <?php if($visibilita_ric=="0"){?>selected="selected"<?php }?>>No</option>		
						</select>
					</div>
					<div style="clear:both;"></div>
				</div>
				
				<div class="mws-form-row">			
					<div style="float:left; width:10%;">
						<label class="mws-form-label">Offerta Speciale</label>
					</div>
					<div style="float:left; width:15%;">
						<select name="offerta_ric" class="small" style="width:90%">
							<option value="">Tutti</option>
							<option value="1" <?php if($offerta_ric=="1"){?>selected="selected"<?php }?>>Si</option>
							<option value="0" <?php if($offerta_ric=="0"){?>selected="selected"<?php }?>>No</option>	
						</select>
					</div>	
					
					<div style="float:left; width:10%;">
						<label class="mws-form-label">In evidenza</label>
					</div>
					<div style="float:left; width:15%;">
						<select name="evidenza_ric" class="small" style="width:90%">
							<option value="">Tutti</option>
							<option value="1" <?php if($evidenza_ric=="1"){?>selected="selected"<?php }?>>Si</option>
							<option value="0" <?php if($evidenza_ric=="0"){?>selected="selected"<?php }?>>No</option>
						</select>
					</div>
					
					<div style="float:left; width:10%;">
						<label class="mws-form-label">Novità</label>
					</div>
					<div style="float:left; width:15%;">
						<select name="novita_ric" class="small" style="width:90%">
							<option value="">Tutti</option>
							<option value="1" <?php if($novita_ric=="1"){?>selected="selected"<?php }?>>Si</option>
							<option value="0" <?php if($novita_ric=="0"){?>selected="selected"<?php }?>>No</option>
						</select>
					</div>
					
					<div style="float:left; width:10%;">
						<label class="mws-form-label">Quantità</label>
					</div>
					<div style="float:left; width:15%;">
						<select name="qty_ric" class="small" style="width:90%">
							<option value="">Tutti</option>
							<option value="1" <?php if($qty_ric=="1"){?>selected="selected"<?php }?>>Maggiore di 0</option>
							<option value="0" <?php if($qty_ric=="0"){?>selected="selected"<?php }?>>0</option>
						</select>
					</div>
					<div style="clear:both;"></div>
				</div>				
				
			</div>
			<div class="mws-button-row">
				<input type="submit" value="Cerca" class="btn btn-danger">
				<input type="button" value="Annulla" class="btn" onclick="window.location='admin.php?cmd=prodotti'">
			</div>
		</form>
	</div>
	
	<div style="clear:both;height:30px">&nbsp;</div>
	
	<div style="float:left;width:50%" class="product-page-per-view">
		<select onchange="cambiaSessionVarAdmin('num_elem_prod',this.value);" class="pt-sans-bold">
		  <option value="20" <?php if($num_elem_prod == 20){?>selected="selected"<?php }?>>20 Elementi Per Pagina</option>
		  <option value="50" <?php if($num_elem_prod == 50){?>selected="selected"<?php }?>>50 Elementi Per Pagina</option>
		  <option value="100" <?php if($num_elem_prod == 100){?>selected="selected"<?php }?>>100 Elementi Per Pagina</option>
		  <option value="200" <?php if($num_elem_prod == 200){?>selected="selected"<?php }?>>200 Elementi Per Pagina</option>
		  <option value="500" <?php if($num_elem_prod == 200){?>selected="selected"<?php }?>>500 Elementi Per Pagina</option>
		</select>
	</div>
	<div style="float:left;width:50%;height:40px;text-align:right">
		<a  class="btn" href="admin.php?cmd=<?php echo $pagina;?>_ins<?php echo $rif;?>&pag_att=<?php echo $pag_att;?>" style="color:#7a7a7a"><b>Aggiungi prodotto</b></a> &nbsp; 
	</div>	
	<div style="clear:both;height:0px">&nbsp;</div>
	
	<div class="mws-panel-header">
		<span><i class="icon-table"></i> Elenco <?php echo $pagina;?></span>
	</div>
	
	<style>
		.catList{
			padding: 3px 10px; /* padding interno */
			text-align: center; /* testo centrato */
			display: inline-block;
			white-space: nowrap; /* impedisce al testo di andare a capo */
			background-color: #EFEFEF; /* colore di sfondo */
			border-radius: 5px; /* angoli arrotondati */
			transition: background-color 0.3s, color 0.3s; /* transizione per l'effetto hover */
			text-decoration: none; /* rimuove la sottolineatura del link */
			color: black; /* colore del testo */
		}
		.catList:hover {
			background-color: #ccc; /* colore di sfondo al passaggio del mouse */
			color: <?php echo $color1;?>; /* colore del testo al passaggio del mouse */
		}
	</style>
	
	<div class="mws-panel-body no-padding">
		<table class="mws-datatable-fn mws-table">
			<thead>
				<tr>
					<th style="width:20px"><input type="checkbox" id="check_tutti" onclick="aggiugni_tutti()"/></th>
					<th style="width:120px;">Immagine</th>
					<?php /*<th>Codice art.</th>*/?>
					<th style="text-align:left;">Prodotto</th>
					<th style="text-align:left;">Categorie</th>
					<th style="text-align:left;">Prezzo</th>
					<th>Qty</th>
					<th  style="width:20px">Gallery</th>
					<th style="width:50px;">Visibile</th>
					<th style="width:50px;">In evidenza</th>
					<th style="width:50px;">OFFERTA</th>
					<th style="width:50px;">Novità</th>
					<th style="text-align:left;">Azioni</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				$query_ele = "SELECT * FROM $table WHERE $criterio ORDER BY entity_id DESC";
				$risu_ele = $open_connection->connection->prepare($query_ele);
				foreach ($params as $index => $val) {
					$risu_ele->bindValue($index + 1, $val, PDO::PARAM_STR);
				}
				$risu_ele->execute();
				
				//$rec_pag=0;
				$rec_pag=$num_elem_prod;
				$pag_tot=0;					
				$start=0;
				
				$num_ele = 0;
				if($risu_ele)
					$num_ele = $risu_ele->rowCount();		
				
				if($num_ele>0)
				{					  
					//$rec_pag=20;					
					$pag_tot=ceil($num_ele/$rec_pag);					
					$start=($pag_att-1)*$rec_pag;
					$query_ele = "SELECT * FROM $table WHERE $criterio ORDER BY entity_id DESC LIMIT $start,$rec_pag";
					//echo $query_ele;
					$risu_ele = $open_connection->connection->prepare($query_ele);
					foreach ($params as $index => $val) {
						$risu_ele->bindValue($index + 1, $val, PDO::PARAM_STR);
					}
					$risu_ele->execute();
					$num_item=$risu_ele->rowCount();	
					
					for($x=0;$x<$num_item;$x++)
					{		
						$arr_ele = $risu_ele->fetch();
						$nome = ucfirst($arr_ele['name']);
						$id_campo = $arr_ele['entity_id'];
						$img = $arr_ele['image'];
						
						$vis = $arr_ele['visibility'];
						$cod = $arr_ele['sku'];
						$categorie = $arr_ele['categorie'];
						$prezzo = $arr_ele['price'];
						$prezzo_offerta = $arr_ele['special_price'];
						$qty = $arr_ele['qty'];
						
						$evidenza = 0;
						if(str_contains($categorie, '@1435@')) $evidenza = 1;
						
						$offerta = 0;
						if(str_contains($categorie, '@969@')) $offerta = 1;
						
						$novita = $arr_ele['novita'];
												
						$link_prod="";		
			?>
				<script type="text/javascript">
					lista_ind[<?php echo $x;?>]="<?php echo $id_campo;?>";               
				</script>
				<tr class="riga_<?php if($x % 2){?>pari<?php }else{?>dispari<?php }?>">
					<td align="center" valign="center">
						<input type="checkbox" id="check_<?php echo $x+1;?>" onclick="aggiungi_lista('<?php echo $x+1;?>','<?php echo $id_campo;?>')"/>
					</td>
					<td align="center" valign="center">
						<?php if(isset($video) && $video!=""){?>
							<img src="https://i3.ytimg.com/vi/<?php echo $video;?>/maxresdefault.jpg" alt="<?php echo $nome;?>" style="width:150px"/>
						<?php }else{
							if(isset($img) && $img!=""){?>
								<img src="<?php echo productImageUrl($img, 'thumb'); ?>" alt="<?php echo $nome;?>" width="150px"/>
							<?php }
						}?>
					</td>
					<!--<td><?php  echo $cod; ?></td>-->
					<td >
						<div>
							<b><?php  echo $nome;?></b>
							<?php if ($cod!="") echo "<br/>Codice art: <b>$cod</b>"; ?>
						</div>
					</td>
					<td style="text-align:left">
						<div style="margin-top:5px">
							<div style="display: flex; gap: 5px; flex-wrap: wrap;">							
								<?php 
								$criterio_cat = "";
								$temp = explode("@@",$categorie);
								for($i=0; $i<count($temp); $i++){
									$criterio_cat .= " entity_id='".str_replace("@","",$temp[$i])."' OR";
								}
								$criterio_cat = substr($criterio_cat,0,-3);
								$query_cat = "SELECT * FROM ".$prefix."categorie_new WHERE 1 AND ($criterio_cat) ORDER BY level ASC, position DESC";
								$risu_cat = $open_connection->connection->query($query_cat);
								while($arr_cat=$risu_cat->fetch()){
									$name = $arr_cat['name'];									
									$link = $arr_cat['link_it'];
									?>
									 <a href="<?php echo $link;?>" title="<?php echo $name;?> | <?php echo $nome_del_sito;?>">
										<div class="catList"><?php echo $name;?></div>
									</a>
									<?php 
								}
								?>
							</div>
						</div>
					</td>
					<td style="text-align:left">
						<div style="font-weight:<?php if(isset($prezzo_offerta) && $prezzo_offerta!="" && $prezzo_offerta!="0.00"){?>normal; text-decoration: line-through; font-size:0.9em;<?php }else{?>bold<?php }?>">
							<?php echo number_format($prezzo,2, ',', '.');?>&euro;
						</div>
						<?php if(isset($prezzo_offerta) && $prezzo_offerta!="" && $prezzo_offerta!="0.00"){?>
							<div><b><?php echo number_format($prezzo_offerta,2, ',', '.');?>&euro;</b></div>
						<?php }?>
					</td>
					<td style="text-align:center; <?php if($qty==0){?>background:rgba(255,0,0,0.7); color:#fff; font-weight:bold<?php }?>">
						<?php echo $qty;?>
					</td>
					<td align="center" valign="center">
						<?php 
						$query_plan="SELECT id FROM  ".$prec_db."prodotti_gallery WHERE id_product='$id_campo'";
						$resu_plan=$open_connection->connection->query($query_plan);
						$num_plan = $resu_plan->rowCount();
						?>
						<div style="width:30px; height:30px; border-radius:15px; bottom:2px; right:2px; text-align:center; background:#000;  cursor:pointer;" onclick="document.getElementById('framePage').src='frame/foto_prodotto.php?id_rife=<?php echo $id_campo;?>'; $('#mask').fadeIn();">						
							<div style="color:#fff; padding-top:5px; font-weight:bold;"><?php echo $num_plan;?></div>
						</div>
					</td>
					<td  align="center" valign="center">
						<a style="cursor:pointer" onclick="gestisci_vis('<?php echo $id_campo;?>')">
							<div style="width:30px; height:30px" id="visibilita_<?php echo $id_campo;?>">
								<?php  if ($vis=='1' || $vis=='4'){?>
									<i class="fa-solid fa-circle-check fa-2x" style="color:#99D000"></i>
								<?php }else{?>
									<i class="fa-regular fa-circle fa-2x" style="color:red"></i>
								<?php }?>
							</div>
						</a>
					</td>
					<td align="center" valign="center">
						<a style="cursor:pointer" onclick="gestisci_evid('<?php echo $id_campo;?>')">
							<div style="width:30px; height:30px" id="evidenza_<?php echo $id_campo;?>">
								<?php  if ($evidenza=='1'){?>
									<i class="fa-solid fa-circle-check fa-2x" style="color:#99D000"></i>
								<?php }else{?>
									<i class="fa-regular fa-circle fa-2x" style="color:red"></i>
								<?php }?>
							</div>
						</a>
					</td>
					<?php /*<td style="text-align:center">
						<a style="cursor:pointer" onclick="gestisci_nov('<?php echo $id_campo;?>')">
							<img id="novita_<?php echo $id_campo;?>" src="<?php  if ($nov=='1') echo "css/icons/icol32/accept_22.png"; else echo "css/icons/icol32/accept_22_off.png" ?>" alt=""/>
						</a>
					</td>*/?>
					<td align="center" valign="center">
						<a style="cursor:pointer" onclick="gestisci_off('<?php echo $id_campo;?>')">
							<div style="width:30px; height:30px" id="offerta_<?php echo $id_campo;?>">
								<?php  if ($offerta=='1'){?>
									<i class="fa-solid fa-circle-check fa-2x" style="color:#99D000"></i>
								<?php }else{?>
									<i class="fa-regular fa-circle fa-2x" style="color:red"></i>
								<?php }?>
							</div>
						</a>
					</td>
					<td align="center" valign="center">
						<a style="cursor:pointer" onclick="gestisci_nov('<?php echo $id_campo;?>')">
							<div style="width:30px; height:30px" id="novita_<?php echo $id_campo;?>">
								<?php  if ($novita=='1'){?>
									<i class="fa-solid fa-circle-check fa-2x" style="color:#99D000"></i>
								<?php }else{?>
									<i class="fa-regular fa-circle fa-2x" style="color:red"></i>
								<?php }?>
							</div>
						</a>
					</td>
					<td style="width:10%">
						<span class="btn-group">
							<?php /*<a href="admin.php?cmd=<?php echo $pagina;?>&id_canc=<?php  echo $id_campo; ?>&azione=primo<?php echo $rif;?>&pag_att=<?php echo $pag_att;?>" class="btn btn-small"><i class="icon-arrow-up-2"></i></a>
							<a href="admin.php?cmd=<?php echo $pagina;?>&id_canc=<?php  echo $id_campo; ?>&azione=sali<?php echo $rif;?>&pag_att=<?php echo $pag_att;?>" class="btn btn-small"><i class="icon-arrow-up"></i></a>
							<a href="admin.php?cmd=<?php echo $pagina;?>&id_canc=<?php  echo $id_campo; ?>&azione=scendi<?php echo $rif;?>&pag_att=<?php echo $pag_att;?>" class="btn btn-small"><i class="icon-arrow-down"></i></a>
							<a href="admin.php?cmd=<?php echo $pagina;?>&id_canc=<?php  echo $id_campo; ?>&azione=ultimo<?php echo $rif;?>&pag_att=<?php echo $pag_att;?>" class="btn btn-small"><i class="icon-arrow-down-2"></i></a>
							<div class="btn btn-small" style="position:relative; width:15px; height:20px; ">
								<div style="position:absolute; width:20px; height:20px; top:2px; left:7px; border:solid:#000; background:#fff; z-index:99"></div>
								<div style="position:absolute; width:20px; height:20px; top:-2px; left:7px; z-index:100">
									<form action="admin.php" method="GET">
										<input type="hidden" name="cmd" value="<?php echo $pagina;?>"/>
										<input type="hidden" name="id_canc" value="<?php  echo $id_campo; ?>"/>
										<input type="hidden" name="azione" value="cambia"/>
										<input type="hidden" name="pag_att" value="<?php echo $pag_att;?>"/>
										<input type="text" name="new_pos" value="<?php  echo $start+$x+1; ?>" style="width:15px; height:10px; padding:0; margin:0; border:0; text-align:center; background:none"/>
									</form>
								</div>
							</div>*/?>
							<a href="admin.php?cmd=<?php echo $pagina;?>_mod&id_rec=<?php  echo $id_campo; ?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>" class="btn btn-small" title="Modifica Prodotto"><i class="icon-pencil"></i></a>
							<a OnClick="return confirm('Sei sicuro di voler duplicare questo elemento?');" href="admin.php?cmd=<?php echo $pagina;?>&azione=duplica&id_canc=<?php  echo $id_campo; ?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>" class="btn btn-small" title="Duplica Prodotto"><i class="fa-regular fa-copy"></i></a>
							<a OnClick="return confirm('Sei sicuro di voler cancellare questo elemento?');" href="admin.php?cmd=<?php echo $pagina;?>&azione=cancella&id_canc=<?php  echo $id_campo; ?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>" class="btn btn-small" title="Cancella Prodotto"><i class="icon-trash"></i></a>
						</span>
					</td>
				</tr>
			<?php 
					}
				}
			?>
			</tbody>
		</table>	
		<?php  include("fissi/multipagina.inc.php"); ?>
		<a href=""  onClick="return confirm('Cancellare gli elementi selezionati?')" id="cancella_sel" style="display:none;"><div style="padding:5px"><input type="button" value="CANCELLA SELEZIONATI"/></div></a>
	</div>
</div>
<iframe id="hiddenFrame" style="display:none"></iframe>
<script type="text/javascript">
  function gestisci_vis(id){
	var curSrc = $("#visibilita_"+id).html();
	
	if (curSrc.includes('99D000')) { 
		$("#visibilita_"+id).html('<i class="fa-regular fa-circle fa-2x" style="color:red"></i>')
	}else{
		$("#visibilita_"+id).html('<i class="fa-solid fa-circle-check fa-2x" style="color:#99D000"></i>')
	}
		
	$("#hiddenFrame").attr("src", "frame/visibileProdotti.php?id_prod="+id);
  }
  
  function gestisci_evid(id){
	var curSrc = $("#evidenza_"+id).html();
	
	if (curSrc.includes('99D000')) { 
		$("#evidenza_"+id).html('<i class="fa-regular fa-circle fa-2x" style="color:red"></i>')
	}else{
		$("#evidenza_"+id).html('<i class="fa-solid fa-circle-check fa-2x" style="color:#99D000"></i>')
	}
	$("#hiddenFrame").attr("src", "frame/evidenzaProdotti.php?id_prod="+id);
  }
  
  function gestisci_off(id){
	var curSrc = $("#offerta_"+id).html();
	
	if (curSrc.includes('99D000')) { 
		$("#offerta_"+id).html('<i class="fa-regular fa-circle fa-2x" style="color:red"></i>')
	}else{
		$("#offerta_"+id).html('<i class="fa-solid fa-circle-check fa-2x" style="color:#99D000"></i>')
	}
	$("#hiddenFrame").attr("src", "frame/offertaProdotti.php?id_prod="+id);
  }
  
  function gestisci_nov(id){
	var curSrc = $("#novita_"+id).html();
	
	if (curSrc.includes('99D000')) { 
		$("#novita_"+id).html('<i class="fa-regular fa-circle fa-2x" style="color:red"></i>')
	}else{
		$("#novita_"+id).html('<i class="fa-solid fa-circle-check fa-2x" style="color:#99D000"></i>')
	}
	
	$("#hiddenFrame").attr("src", "frame/novitaProdotti.php?id_prod="+id);
  }
</script>

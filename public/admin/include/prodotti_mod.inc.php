<?php 
$table=$prec_db."prodotti";
$pagina="prodotti";

$rif="";
$criterio="";

if(isset($_GET['macro_ric'])) $macro_ric=$_GET['macro_ric']; else $macro_ric='';
if($macro_ric!="") {
	$criterio.=" AND id_macro='$macro_ric'";
	$rif.="&macro_ric=$macro_ric";
}
if(isset($_GET['cat_ric'])) $cat_ric=$_GET['cat_ric']; else $cat_ric='';
if($cat_ric!="") {
	$criterio.=" AND id_cat='$cat_ric'";
	$rif.="&cat_ric=$cat_ric";
}
if(isset($_GET['nome_ric'])) $nome_ric=$_GET['nome_ric']; else $nome_ric='';
if($nome_ric!="") {
	$criterio.=" AND (nome like '%$nome_ric%' OR codice like '%$nome_ric%'";
	$rif.="&nome_ric=$nome_ric";
}
if(isset($_GET['visibilita_ric'])) $visibilita_ric=$_GET['visibilita_ric']; else $visibilita_ric="";
if($visibilita_ric!="") {
	$criterio.=" AND visibile='$visibilita_ric'";
	$rif.="&visibilita_ric=$visibilita_ric";
}
/*if(isset($_GET['quantita_ric'])) $quantita_ric=$_GET['quantita_ric']; else $quantita_ric="";
if($quantita_ric=="1") {
	$criterio.=" AND quantita>'0'";
	$rif.="&quantita_ric=$quantita_ric";
}*/
if(isset($_GET['offerta_ric'])) $offerta_ric=$_GET['offerta_ric']; else $offerta_ric="";
if($offerta_ric=="1") {
	$criterio.=" AND prezzo_offerta is not null AND prezzo_offerta<>'0.00')";
	$rif.="&offerta_ric=$offerta_ric";
}
if(isset($_GET['home_ric'])) $home_ric=$_GET['home_ric']; else $home_ric="";
if($home_ric!="") {
	$criterio.=" AND home='$home_ric'";
	$rif.="&home_ric=$home_ric";
}
if(isset($_GET['novita_ric'])) $novita_ric=$_GET['novita_ric']; else $novita_ric="";
if($novita_ric!="") {
	$criterio.=" AND novita='$novita_ric'";
	$rif.="&novita_ric=$novita_ric";
}

if(isset($_GET['pag_att'])) $pag_att=$_GET['pag_att']; else $pag_att=1;
$rif.="&pag_att=$pag_att";

$query_rec = "select * from $table where entity_id='$id_rec'";
$risu_rec = $open_connection->connection->query($query_rec);
$arr_rec = $risu_rec->fetch();

$n_name = $arr_rec['name'];
$n_foto = $arr_rec['image'];	
$n_categorie = $arr_rec['categorie'];	
$n_sku = $arr_rec['sku'];	
$n_short_description = $arr_rec['short_description'];	
$n_description = $arr_rec['description'];	
$n_price = $arr_rec['price'];	
$n_special_price = $arr_rec['special_price'];	
$n_weight = $arr_rec['weight'];	
$n_qty = $arr_rec['qty'];	
$n_conservazione = $arr_rec['conservazione'];	
$n_metallo = $arr_rec['metallo'];	
$n_rarita = $arr_rec['rarita'];		
$n_coniazione = $arr_rec['coniazione'];	
$n_stile = $arr_rec['stile'];	
$n_provenienza = $arr_rec['provenienza'];	
$n_correlati = $arr_rec['correlati'];
$n_novita = $arr_rec['novita'];
$n_video = $arr_rec['video'];
$data_fine_novita = $arr_rec['data_fine_novita'];
$meta_title = $arr_rec['meta_title'];
$meta_description = $arr_rec['meta_description'];
$data_inizio_evidenza = $arr_rec['data_inizio_evidenza'];
$data_fine_evidenza = $arr_rec['data_fine_evidenza'];
$url_key = $arr_rec['url_key'];
?>
<script language="javascript">
	function annulla(){
		window.location='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>';
	}
</script>

<script language="javascript">
	function verifica(){
		if (document.inserimento.categorie.value=="") alert('Categorie obbigatorie');
		else if (checkSku=="ko") alert('ATTENZIONE! Il codice inserito è già stato utilizzato!');
		else if (document.inserimento.name.value=="") alert('Nome obbigatorio');
		<?php if(!isset($n_foto) || $n_foto==""){?>else if (document.inserimento.image.value=="") alert('Immagine obbigatoria');<?php }?>
		else if (document.inserimento.price.value=="") alert('Prezzo obbigatorio');
		else if (document.inserimento.qty.value=="") alert('Quantita obbigatoria');
		else if (document.inserimento.weight.value=="") alert('Peso obbigatoria');
		else document.inserimento.submit();
	}
</script>
<?php 

if($campocanc!="")
{
	$risu_img = $open_connection->connection->query("select $campocanc from $table where entity_id='$id_rec'");
	$row_img = $risu_img->fetch(PDO::FETCH_ASSOC);
	$cancimg = $row_img[$campocanc] ?? null;
	
	productImageDeleteR2($cancimg);
	$query_canc_img = "update $table set $campocanc=NULL where entity_id='$id_rec'";
	$risu_canc_img = $open_connection->connection->query($query_canc_img);
	?>
	<script language="javascript">
		window.location='admin.php?cmd=<?php echo $pagina;?>_mod&id_rec=<?php echo $id_rec;?>';
	</script>
	<?php 
}

if($stato=="inviato")
{
	$arr_no['stato']=1;
	$arr_no['box']=1;
	$arr_no['cmd']=1;
	$arr_no['lista_prodotti']=1;
	$arr_thumb['image']=400;
		
	$data_cartella = date("Y")."/".date("m");
	$directoryPath = 'img_up/prodotti/'.$data_cartella;
	$hasImageUpload = isset($_FILES['image']['name']) && $_FILES['image']['name'] !== '';
	if ($hasImageUpload && !is_dir($directoryPath)) {
		mkdir($directoryPath, 0775, true);
	}
	
	$_POST['name'] = str_replace("`","'",$_POST['name']);
	$_POST['url_key'] = str_replace(" ","-",$_POST['url_key']);

	unset($_POST['selected']);
	
	$oggetto_admin->modifica_campi ("$table", $id_rec, $arr_no, $arr_thumb, $directoryPath, "", "1920", "entity_id");
	
	if(isset($_FILES['image']['name']) && $_FILES['image']['name']!=""){ 
		$old_foto = $n_foto;
		$query_i="SELECT image FROM ".$prefix."prodotti WHERE entity_id='$id_rec'";
		$risu_i = $open_connection->connection->query($query_i);
		$row_i = $risu_i->fetch(PDO::FETCH_ASSOC);
		$nome_img = $row_i['image'] ?? '';
		$nome_img = $data_cartella."/".$nome_img;
		
		$query_up = "UPDATE ".$prefix."prodotti SET image='$nome_img' WHERE entity_id='$id_rec'";
		$risu_up = $open_connection->connection->query($query_up);
		
		$oggetto_admin->creaImmagineRidimensionata("img_up/prodotti/".$nome_img);
		productImageUploadFromLocalDir('img_up/prodotti/'.$data_cartella, $nome_img);
		if ($old_foto && $old_foto !== $nome_img) {
			productImageDeleteR2($old_foto);
		}
	}
	
?>
	<script language="javascript">
		window.location = "admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>" ;
	</script>
<?php 
}
else
{		
?>
<div class="mws-panel grid_8">
	<div style="height:50px;font-size:1.2em;padding-top:10px"><b>Modifica prodotto</b></div>
	<div class="mws-panel-header">
		<span>Dati richiesti</span>
	</div>
	<div class="mws-panel-body no-padding">
		<form name="inserimento" class="mws-form" action="admin.php?cmd=<?php echo $pagina;?>_mod&id_rec=<?php  echo $id_rec; ?><?php echo $rif;?>" method="post" enctype="multipart/form-data">
			<!--<div id="mws-validate-error" class="mws-form-message error" style="display:none;"></div>-->
			<input type="hidden" name="stato" value="inviato">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label class="mws-form-label">Categoria</label>
					<input type="hidden" name="categorie" id="categorie" value="<?php echo $n_categorie;?>"/>
					<div class="mws-form-item" id="select_cat">
						<div style="position:relative; cursor:pointer; width:75%; height:30px; background:#fff; border:solid 1px #C5C5C5; border-radius:5px"  onclick="vediCatList();">
							<div style="float:left; width:calc(100% - 35px);">
								<?php 
								$lista_cat = "";
								if(isset($n_categorie) && $n_categorie!=""){
									$temp = explode("@@",$n_categorie);
									for($i=0; $i<count($temp); $i++){
										$id_cat = str_replace("@","",$temp[$i]);
										if ($id_cat === '') {
											continue;
										}
										$query_c="SELECT name FROM ".$prefix."categorie_new WHERE entity_id='$id_cat'";
										$risu_c = $open_connection->connection->query($query_c);
										$row_c = $risu_c->fetch(PDO::FETCH_ASSOC);
										if ($row_c) {
											$lista_cat .= $row_c['name'].", ";
										}
									}
								}
								if($lista_cat!="") $lista_cat = substr($lista_cat,0,-2);
								?>
								<div style="padding: 5px 10px;" id="selectedCatList"><?php echo $lista_cat;?></div>
							</div>
							<div style="float:right; width:30px; height:30px; background:#E3E3E3">
								<div style="width:100%; height:100%; display: flex; justify-content: center; align-items: center;">
									<i class="fa-solid fa-caret-down"></i>
								</div>
							</div>
							<div style="clear:both"></div>
						</div>
					</div>
				</div>
				<script>
					function vediCatList(){
						document.getElementById('framePage').src="frame/lista_categorie.php?catList="+document.getElementById('categorie').value; 
						$('#mask').fadeIn();
					}
				</script>
				<div class="mws-form-row">
					<label class="mws-form-label">Codice art.<br /><a href="admin.php?cmd=<?php echo $pagina;?>_mod&id_rec=<?php echo $id_rec;?>&campocanc=sku" style="color:#333"><i class="fa fa-eraser" aria-hidden="true"></i></a></label>
					<div class="mws-form-item">
						<input type="text" name="sku" id="sku" class="small" value="<?php echo $n_sku;?>">
						<div style="width:310px; margin-top:2px; height:30px;" id="alertSku">
							
						</div>
					</div>
				</div>
				
				<script>
					let checkSku = "ok";
					
					$(document).ready(function() {
						$('#sku').on('input', function() {
							let query = $(this).val(); // Ottiene il valore dell'input
							
							// Esegui la richiesta AJAX solo se l'input non è vuoto
							if (query.length > 0) {
								$.ajax({
									url: 'ajax/testSku.php', // URL dello script PHP
									method: 'GET', // Metodo HTTP
									data: { search: query, sku: '<?php echo $n_sku;?>' }, // Parametri della richiesta
									success: function(response) {
										// Mostra la risposta nel div #alertSku
										$('#alertSku').html(response);
										if (response.includes("ATTENZIONE!")) checkSku = "ko";
										else checkSku = "ok";
									},
									error: function() {
										// Gestione degli errori
										$('#alertSku').html('<p>Errore durante la richiesta.</p>');
									}
								});
							} else {
								$('#alertSku').html(''); // Pulisci il risultato se l'input è vuoto
								checkSku = "ok";
							}
						});
					});
				</script>
				
				<div class="mws-form-row">
					<label class="mws-form-label">Nome *</label>
					<div class="mws-form-item">
						<input name="name" type="text" class="medium" value="<?php echo  htmlspecialchars($n_name, ENT_QUOTES, 'UTF-8'); ?>" id="name" >
						<a href="admin.php?cmd=prodotti_mod&id_rec=<?php echo $id_rec;?>&campocanc=name" class="testo10" style="color:#333; text-decortion:none;"> <i class="fa fa-eraser" aria-hidden="true"></i></a>
					</div>
				</div>
				<?php 
				//$oggetto_admin->campo_mod("Nome *" , "name" , "$n_name"  , "1", 'no', "$cmd", "$id_rec");			
				$oggetto_admin->campo_mod("Immagine" , "image" , "$n_foto"  , "4", 'no', "$cmd", "$id_rec", "", "", "img_up/$pagina");
				?>
				<div class="mws-form-row">
					<label class="mws-form-label">Video<br /><i>(link video canale YouTube, a partire da https://)</i><br/><a href="admin.php?cmd=<?php echo $pagina;?>_mod&id_rec=<?php echo $id_rec;?>&campocanc=video" style="color:#333"><i class="fa fa-eraser" aria-hidden="true"></i></a></label>
					<div class="mws-form-item">
						<input name="video" type="text" class="small" value="<?php  echo $n_video; ?>" id="video">
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">Descrizione Breve<br/><a href="admin.php?cmd=<?php echo $pagina;?>_mod&id_rec=<?php echo $id_rec;?>&campocanc=short_description" style="color:#333"><i class="fa fa-eraser" aria-hidden="true"></i></a></label>
					<div class="mws-form-item">
						<textarea class="ckeditor" name="short_description"><?php  echo $n_short_description; ?></textarea>
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">Descrizione<br/><a href="admin.php?cmd=<?php echo $pagina;?>_mod&id_rec=<?php echo $id_rec;?>&campocanc=description" style="color:#333"><i class="fa fa-eraser" aria-hidden="true"></i></a></label>
					<div class="mws-form-item">
						<textarea class="ckeditor" name="description"><?php  echo $n_description; ?></textarea>
					</div>
				</div>				
				<?php 
				$oggetto_admin->campo_mod("Prezzo *<br /><i>(in euro, usando il punto solo per i centesimi)</i>" , "price" , $n_price , "2", 'no', $cmd, $id_rec, "width:80px");
				$oggetto_admin->campo_mod("Prezzo in offerta <br /><i>(in euro, usando il punto solo per i centesimi)</i>" , "special_price" , $n_special_price , "2", 'no', $cmd, $id_rec, "width:80px","","","","0");				
				$oggetto_admin->campo_mod("Peso *<br /><i>(in Kg)</i>" , "weight" , $n_weight  , "2", 'no', $cmd, "$id_rec", "width:80px","","","","1");
				$oggetto_admin->campo_mod("Quantità *<br /><i>(num. di articoli disponibili)</i>" , "qty" , $n_qty  , "2", 'no', $cmd, "$id_rec", "width:80px","","","","1");
				$oggetto_admin->campo_mod("Conservazione<br/>(xx/70)" , "conservazione" , $n_conservazione  , "2", 'no', $cmd, "$id_rec", "width:50px","","","","0");
				$oggetto_admin->campo_mod("Rarità<br/>(xx/100)" , "rarita" , $n_rarita  , "2", 'no', $cmd, "$id_rec", "width:50px","","","","0");
				$oggetto_admin->campo_mod("Metallo<br/>(xx/100)" , "metallo" , $n_metallo  , "2", 'no', $cmd, "$id_rec", "width:50px","","","","0");
				$oggetto_admin->campo_mod("Coniazione<br/>(xx/100)" , "coniazione" , $n_coniazione  , "2", 'no', $cmd, "$id_rec", "width:50px","","","","0");
				$oggetto_admin->campo_mod("Stile<br/>(xx/100)" , "stile" , $n_stile  , "2", 'no', $cmd, "$id_rec", "width:50px","","","","0");
				$oggetto_admin->campo_mod("Provenienza<br/>(xx/100)" , "provenienza" , $n_provenienza  , "2", 'no', $cmd, "$id_rec", "width:50px","","","","0");
				?>
				<div class="mws-form-row">
					<label class="mws-form-label">NOVITA'</label>
					<div class="mws-form-item">
						<select name="novita" class="form-control" id="novita">
							<option>-- Seleziona --</option>
							<option value="1" <?php if($n_novita=='1'){?>selected="selected"<?php }?>>Sì</option>
							<option value="0" <?php if($n_novita=='0'){?>selected="selected"<?php }?>>No</option>
						</select>
					</div>
				</div>				
				<div class="mws-form-row">
					<label class="mws-form-label">Novità fino al</label>
					<div class="mws-form-item">
						<input name="data_fine_novita" type="date" class="small" value="<?php  echo $data_fine_novita; ?>" id="data_fine_novita">
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">Meta Tag Title</label>
					<div class="mws-form-item">
						<input type="text" class="small" name="meta_title" value="<?php  echo $meta_title; ?>" />
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">Meta Tag Description</label>
					<div class="mws-form-item">
						<textarea name="meta_description" class="small"><?php  echo $meta_description; ?></textarea>
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">In evidenza (Dal - Al)</label>
					<div class="mws-form-item large">
						<div class="mws-form-cols clearfix">
							<div class="mws-form-col-2-8 alpha">
								<div class="mws-form-item">
									<input name="data_inizio_evidenza" type="date" class="mws-textinput" value="<?php  echo $data_inizio_evidenza; ?>" id="data_inizio_evidenza">
								</div>
							</div>
							<div class="mws-form-col-2-8 alpha">
								<div class="mws-form-item">
									<input name="data_fine_evidenza" type="date" class="mws-textinput" value="<?php  echo $data_fine_evidenza; ?>" id="data_fine_evidenza">
								</div>
							</div>
						</div>
					</div>				
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">URL prodotto</label>
					<div class="mws-form-item">
						<input type="text" class="small" name="url_key" value="<?php  echo $url_key; ?>" />
						<small>Caratteri consentiti  a-z, 0-9, - _ !</small>
					</div>
				</div>
				<input type="hidden" name="correlati" id="correlati" value="<?php echo $n_correlati;?>"/>
				<div style="margin-top:20px">
					<?php include __DIR__.'/../fissi/prodotti_correlati.inc.php'; ?>
				</div>
				
				<br/><br/>
				<div style="margin-left:20px; padding-bottom:10px;">* <i>campi obbligatori</i></div>
				<div style="margin-left:20px; padding-bottom:10px;"><i class="fa fa-eraser" aria-hidden="true"></i> <i>clicca sulla gomma a fianco dei campi non obbligatori per cancellarne il contenuto</i></div>
			</div>
			<div style="position:fixed; width:100%; bottom:0" class="mws-button-row">
				<input type="button" value="Modifica" class="btn btn-danger" onclick="verifica()">
				<input type="button" value="Annulla" class="btn" onclick="annulla()">
			</div>
		</form>
	</div>
</div>
<?php 
}
?>
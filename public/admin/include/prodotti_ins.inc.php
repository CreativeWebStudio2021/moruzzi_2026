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
		else if (document.inserimento.image.value=="") alert('Immagine obbigatoria');
		else if (document.inserimento.price.value=="") alert('Prezzo obbigatorio');
		else if (document.inserimento.qty.value=="") alert('Quantita obbigatoria');
		else if (document.inserimento.weight.value=="") alert('Peso obbigatoria');
		else document.inserimento.submit();
	}
</script>
<?php 
if($stato=="inviato")
{
	$arr_no['stato']=1;
	$arr_no['box']=1;
	$arr_thumb['image']=400;
	
	$_POST['url_key'] = str_replace("_","-",to_htaccess_url($_POST['name'],""));
	$_POST['name'] = str_replace("`","'",$_POST['name']);
	$_POST['disponibili'] = $_POST['qty'];
	$_POST['visibility'] = '1';
	$_POST['status'] = '1';
	$_POST['stock_status'] = '1';
	$_POST['data_inserimento'] = date('Y-m-d H:i:s');

	$data_cartella = date("Y")."/".date("m");
	$directoryPath = 'img_up/prodotti/'.$data_cartella;
	$hasImageUpload = isset($_FILES['image']['name']) && $_FILES['image']['name'] !== '';
	if ($hasImageUpload && !is_dir($directoryPath)) {
		mkdir($directoryPath, 0775, true);
	}
	
	$last_id = $oggetto_admin->inserisci_campi ("$table" , $arr_no ,  $arr_thumb, $directoryPath);
	
	$query_i="SELECT image FROM ".$prefix."prodotti WHERE entity_id='$last_id'";
	$risu_i = $open_connection->connection->query($query_i);
	$row_i = $risu_i->fetch(PDO::FETCH_ASSOC);
	$nome_img = $row_i['image'] ?? '';
	$nome_img = $data_cartella."/".$nome_img;
	
	$query_up = "UPDATE ".$prefix."prodotti SET image='$nome_img', url_key='".str_replace("_","-",to_htaccess_url($_POST['name'],""))."-".$last_id."' WHERE entity_id='$last_id'";
	$risu_up = $open_connection->connection->query($query_up);
	
	$oggetto_admin->creaImmagineRidimensionata("img_up/prodotti/".$nome_img);
	productImageUploadFromLocalDir('img_up/prodotti/'.$data_cartella, $nome_img);
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
	<div style="height:50px;font-size:1.2em;padding-top:10px"><b>Inserisci prodotto</b></div>
	<div class="mws-panel-header">
		<span>Dati richiesti</span>
	</div>
	<div class="mws-panel-body no-padding">
		<form name="inserimento" class="mws-form" action="admin.php?cmd=<?php echo $pagina;?>_ins<?php echo $rif;?>" method="post" enctype="multipart/form-data">
			<!--<div id="mws-validate-error" class="mws-form-message error" style="display:none;"></div>-->
			<input type="hidden" name="stato" value="inviato">		
<?php 
			//$ord = $oggetto_admin->trova_ordine("$table");
			//echo "<input type=hidden name=ordine value=$ord>";	
?>
			<div class="mws-form-inline">				
				<div class="mws-form-row">
					<label class="mws-form-label">Categorie *</label>
					<input type="hidden" name="categorie" id="categorie"/>
					<div class="mws-form-item" id="select_cat">
						<div style="position:relative; cursor:pointer; width:75%; height:30px; background:#fff; border:solid 1px #C5C5C5; border-radius:5px"  onclick="vediCatList();">
							<div style="float:left; width:calc(100% - 35px);">
								<div style="padding: 5px 10px;" id="selectedCatList">Seleziona...</div>
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
					<label class="mws-form-label">Codice art.</label>
					<div class="mws-form-item">
						<input name="sku" type="text" class="small" style="" value="" id="sku">
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
									data: { search: query }, // Parametri della richiesta
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
				
				<?php 
				$oggetto_admin->campo_ins("Nome *" , "name" , "1", 'no');				
				$oggetto_admin->campo_ins("Immagine *" , "image" , "4", 'no');
				?>
				<div class="mws-form-row">
					<label class="mws-form-label">Video<br /><i>(link video canale YouTube, a partire da https://)</i></label>
					<div class="mws-form-item">
						<input name="video" type="text" class="small" value="" id="video">
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">Descrizione Breve</label>
					<div class="mws-form-item">
						<textarea class="ckeditor" name="short_description"></textarea>
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">Descrizione</label>
					<div class="mws-form-item">
						<textarea class="ckeditor" name="description"></textarea>
					</div>
				</div>
				<?php 
				$oggetto_admin->campo_ins("Prezzo *<br /><i>(in euro, usando il punto solo per i centesimi)</i>" , "price" , "2", 'no', "width:80px");
				$oggetto_admin->campo_ins("Prezzo offerta<br /><i>(in euro, usando il punto solo per i centesimi)</i>" , "special_price" , "2", 'no', "width:80px");
				$oggetto_admin->campo_ins("Peso *<br /><i>(in Kg)</i>" , "weight" , "2", 'no', "width:80px");
				$oggetto_admin->campo_ins("Quantita *<br /><i>(num. di articoli disponibili)</i>" , "qty" , "2", 'no', "width:80px");
				?>
				<div class="mws-form-row">
					<label class="mws-form-label">Conservazione</label>
					<div class="mws-form-item">
						<input name="conservazione" type="text" class="small" style="width:50px" value="" id="conservazione"> / 70
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">Rarità</label>
					<div class="mws-form-item">
						<input name="rarita" type="text" class="small" style="width:50px" value="" id="rarita"> / 100
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">Metallo</label>
					<div class="mws-form-item">
						<input name="metallo" type="text" class="small" style="width:50px" value="" id="metallo"> / 100
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">Coniazione</label>
					<div class="mws-form-item">
						<input name="coniazione" type="text" class="small" style="width:50px" value="" id="coniazione"> / 100
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">Stile</label>
					<div class="mws-form-item">
						<input name="stile" type="text" class="small" style="width:50px" value="" id="stile"> / 100
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">Provenienza</label>
					<div class="mws-form-item">
						<input name="provenienza" type="text" class="small" style="width:50px" value="" id="provenienza"> / 100
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">NOVITA'</label>
					<div class="mws-form-item">
						<select name="novita" class="form-control" id="novita">
							<option>-- Seleziona --</option>
							<option value="1" selected>Sì</option>
							<option value="0">No</option>
						</select>
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">Novità fino al</label>
					<div class="mws-form-item">
						<input name="data_fine_novita" type="date" class="small" value="<?php echo date( "Y-m-d", strtotime( "+7 days" ) ); ?>" id="data_fine_novita">
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">Meta Tag Title</label>
					<div class="mws-form-item">
						<input type="text" class="small" name="meta_title" />
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">Meta Tag Description</label>
					<div class="mws-form-item">
						<textarea name="meta_description" class="small"></textarea>
					</div>
				</div>
				<div class="mws-form-row">
					<label class="mws-form-label">In evidenza (Dal - Al)</label>
					<div class="mws-form-item large">
						<div class="mws-form-cols clearfix">
							<div class="mws-form-col-2-8 alpha">
								<div class="mws-form-item">
									<input name="data_inizio_evidenza" type="date" class="mws-textinput" value="" id="data_inizio_evidenza">
								</div>
							</div>
							<div class="mws-form-col-2-8 alpha">
								<div class="mws-form-item">
									<input name="data_fine_evidenza" type="date" class="mws-textinput" value="" id="data_fine_evidenza">
								</div>
							</div>
						</div>
					</div>				
				</div>						
				<input type="hidden" name="correlati" id="correlati" value=""/>
				<div style="margin-top:20px">
					<?php include("fissi/prodotti_correlati.inc.php");?>
				</div>
				
				<script>
					function listaCorrelati(val){
						if(val=="1"){
							document.getElementById('boxCorrelatiProdotti').style.display='block';
						}else{
							document.getElementById('boxCorrelatiProdotti').style.display='none';
							document.getElementById('lista_prodotti_correlati').value="";
						}
					}
				</script>
				
				<br/><br/>
				<div style="margin-left:20px; padding-bottom:10px;">* <i>campi obbligatori</i></div>
			</div>
			<div style="position:fixed; width:100%; bottom:0" class="mws-button-row">
				<input type="button" value="Inserisci" class="btn btn-danger" onclick="verifica()">
				<input type="button" value="Annulla" class="btn" onclick="annulla()">
			</div>
		</form>
	</div>
</div>
<?php 
}
?>

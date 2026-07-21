<?php 
$table=$prec_db."newsletter_subscriber";
$pagina="newsletter";

//$criterio="confermato='1'";
$criterio=" 1 ";
$rif="";

if(isset($_GET['email_ric'])) $email_ric=$_GET['email_ric']; else $email_ric='';
if(isset($_GET['stato_ric'])) $stato_ric=$_GET['stato_ric']; else $stato_ric='';
if(isset($_GET['pag_att'])) $pag_att=$_GET['pag_att']; else $pag_att=1;

if($email_ric!="") { $criterio.=" AND subscriber_email LIKE '%$email_ric%'"; $rif.="&email_ric=$email_ric"; }

if($stato_ric!="") { 
	if($stato_ric==1)
		$criterio.=" AND subscriber_status = '1'"; 
	else
		$criterio.=" AND subscriber_status <> '1'"; 
	$rif.="&stato_ric=$stato_ric"; 
}

/* Questa è la parte che effettua l'ordinamento */
if(isset($_GET['ascdesc'])){
	$ascdesc = $_GET['ascdesc'];
 }else{
	$ascdesc="desc";
 }
 
if(isset($_GET['ordinato']))
	$ordinato = $_GET['ordinato'];
else $ordinato = 0;

if(isset($_GET['neword'])){
	$neword = $_GET['neword'];
	if ($ordinato==1) {
		$ord = $ascdesc;
	}
	else {
		if($ascdesc=="asc"){$ascdesc="desc";}else{$ascdesc="asc";}
	}
	$pezzo_ord = "order by $neword $ascdesc";
}else{
	$ord = "desc";
	$neword = "id";
	$pezzo_ord="order by change_status_at desc";
}
/* fine ordinamento */

if(isset($_SESSION['num_elem_news'])) $num_elem_news = $_SESSION['num_elem_news']; else $num_elem_news = $_SESSION['num_elem_news'] = "20";
//echo $num_elem_news;

if($azione=="cancella" && $id_canc!="")
{	
	$query_canc = "delete from $table where id='$id_canc'";
	$risu_canc = $open_connection->connection->query($query_canc);
		
?>
	<script language="javascript">		
		window.location="admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>";
	</script>
<?php 
} 

/*if ($id_canc) {
	if($azione=="sali") $oggetto_admin->sali("$table", "$id_canc") ;
	if($azione=="scendi") $oggetto_admin->scendi("$table", "$id_canc") ;
	if($azione=="primo") $oggetto_admin->primo("$table", "$id_canc") ;
	if($azione=="ultimo") $oggetto_admin->ultimo("$table", "$id_canc") ;
	if($azione=="cambia") {
		if(isset($_GET['new_pos'])) $new_pos=$_GET['new_pos']; else $new_pos="";
		if($new_pos!="") $oggetto_admin->cambia("$table", "$id_canc", "$new_pos") ;	
	}
	
	if($azione=="sali" || $azione=="scendi" || $azione=="primo" || $azione=="ultimo" || $azione=="cambia"){?>
		<script type="text/javascript">
			window.location='admin.php?cmd=<?php echo $table;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>';
		</script>
	<?php }
}*/

if($azione=="cancella_sel") {
	if(isset($_GET['lista'])) $lista=$_GET['lista']; else $lista="";
	$temp=explode(";",$lista);
	for($z=0; $z<count($temp)-1; $z++){
		/*$query_canc_img = "select img from $table where id='".$temp[$z]."'";
		$risu_canc_img = $open_connection->connection->query($query_canc_img);
		if ($risu_canc_img) {
			list($img) = $risu_canc_img->fetch();
			if (is_file("img_up/$img")) @unlink("img_up/$img");
		}*/
		
		$query_canc = "delete from $table where id='".$temp[$z]."'";
		$risu_canc = $open_connection->connection->query($query_canc);
		
	}?>
		<script type="text/javascript">
			window.location='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>';
		</script>
	<?php 	
}

/*if ($azione=="scarica_clienti") {
	$data_f = $oggetto_admin->date_to_data($data_att);
	include("include/scarica_clienti.inc.php");
?>
	<script type="text/javascript">
		window.location='http://<?php  echo $ind_sito; ?>/csv/clienti/clienti_<?php echo $data_f;?>.csv';
		
		function loc(){
			window.location = "admin.php?cmd=<?php echo $table;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>";
		}
		window.setTimeout('loc()' , 2000);
	</script>
<?php 
}*/
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
	
	<iframe src="" style="display:none" id="frame_action"></iframe>
	<iframe src="" style="display:none" id="frame_action2"></iframe>
	
	<!--<script type="text/javascript">
		var open=0;
		function apri_ricerca(){
			if(open==0){
				open=1;
				$("#searchPanel").animate({height:"195px"});
				document.getElementById('searchHeader').innerHTML='<span><i class="fa fa-search-minus" style="color:#fff"></i> Ricerca</span>';
			} else {
				open=0;
				$("#searchPanel").animate({height:"0px"});
				document.getElementById('searchHeader').innerHTML='<span><i class="fa fa-search-plus" style="color:#fff"></i> Ricerca</span>';
			}
		}
	</script>-->
	
	<div class="mws-panel-header" style="cursor:pointer;" onclick="apri_ricerca();" id="searchHeader">
		<span><i class="fa fa-search-plus" style="color:#fff"></i> Ricerca clienti</span>
	</div>
	<div class="mws-panel-body no-padding" id="searchPanel">
		<form name="ricerca" class="mws-form" action="admin.php" method="GET" enctype="multipart/form-data">
			<input type="hidden" name="cmd" value="<?php echo $pagina;?>">
			
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<div style="float:left; width:15%;">
						<label class="mws-form-label">Email</label>									
					</div>
					<div style="float:left; width:35%;">
						<input type="text" name="email_ric" value="<?php echo $email_ric;?>"  style="width:90%"/>
					</div>
					
					<div style="float:left; width:15%;">
						<label class="mws-form-label">Attivo</label>						
					</div>
					<div style="float:left; width:35%;">
						<select name="stato_ric">
							<option value="">Tutti</option>
							<option value='1' <?php if($stato_ric=="1"){?>selected="selected"<?php }?>>Sì</option>
							<option value='0' <?php if($stato_ric=="0"){?>selected="selected"<?php }?>>No</option>
						</select>
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
	<div style="clear:both;height:30px">&nbsp;</div>
	
	<div class="pull-left">
		<div class="product-page-per-view">
			<select onchange="cambiaSessionVarAdmin('num_elem_news',this.value);" class="pt-sans-bold">
			<option value="20" <?php if($num_elem_news == 20){?>selected="selected"<?php }?>>20 Elementi Per Pagina</option>
			<option value="50" <?php if($num_elem_news == 50){?>selected="selected"<?php }?>>50 Elementi Per Pagina</option>
			<option value="100" <?php if($num_elem_news == 100){?>selected="selected"<?php }?>>100 Elementi Per Pagina</option>
			<option value="200" <?php if($num_elem_news == 200){?>selected="selected"<?php }?>>200 Elementi Per Pagina</option>
			<option value="500" <?php if($num_elem_news == 200){?>selected="selected"<?php }?>>500 Elementi Per Pagina</option>
			</select>
		</div>
	</div>

	<div class="pull-right">
		<a  class="btn" href="include/esporta_newsletter.php" style="color:#7a7a7a"><b>Esporta</b></a>
	</div>

	<div style="clear:both;height:20px">&nbsp;</div>
	<?php 
		$query_ele = "SELECT * FROM $table WHERE $criterio $pezzo_ord";			
		//echo $query_ele;
		$risu_ele = $open_connection->connection->query($query_ele);
		
		$num_ele = 0;
		if($risu_ele)
			$num_ele = $risu_ele->rowCount();		
	?>
	<?php /*<div style="float:left;width:50%;text-align:left;height:30px"><!--<a style="color:#000" href="admin.php?cmd=<?php echo $table;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>&azione=scarica_clienti">Scarica il file dei clienti</a>--></div>
	<div style="float:left;height:40px;width:50%;text-align:right"><a class="btn" href="admin.php?cmd=<?php echo $pagina;?>_ins<?php echo $rif;?>&pag_att=<?php echo $pag_att;?>" style="color:#7a7a7a"><b>Aggiungi cliente</b></a> &nbsp; </div>*/?>
	<div style="clear:both;height:0px">&nbsp;</div>
	<div class="mws-panel-header" style="position:relative;">
		<span><i class="icon-table"></i> Elenco <?php echo $pagina;?>  (<?php  echo $num_ele; ?>)</span>
	</div>
	<div class="mws-panel-body no-padding">
		<table class="mws-datatable-fn mws-table">
			<thead>
				<tr>
					<th style="width:20px"><input type="checkbox" id="check_tutti" onclick="aggiugni_tutti()"/></th>
					<th style="width:20px"></th>
					<th style="width:80px"><a style="color:#333;text-decoration:none" href="admin.php?cmd=<?php echo $pagina;?>&neword=change_status_at&ascdesc=<?php  echo $ascdesc; ?><?php echo $rif;?>">Data iscr.</a><?php  if ($neword=="data_iscr" && $ascdesc=="asc") echo "&nbsp; <img src=\"images/core/sort_desc.png\">"; elseif ($neword=="data_iscr" && $ascdesc=="desc") echo "&nbsp; <img src=\"images/core/sort_asc.png\">"; else echo "&nbsp; <img src=\"images/core/sort.png\">"; ?></th>
					<th style="text-align:left"><a style="color:#333;text-decoration:none" href="admin.php?cmd=<?php echo $pagina;?>&neword=subscriber_email&ascdesc=<?php  echo $ascdesc; ?><?php echo $rif;?>">Email</a><?php  if ($neword=="email" && $ascdesc=="asc") echo "&nbsp; <img src=\"images/core/sort_desc.png\">"; elseif ($neword=="email" && $ascdesc=="desc") echo "&nbsp; <img src=\"images/core/sort_asc.png\">"; else echo "&nbsp; <img src=\"images/core/sort.png\">"; ?></th>
					<th style="text-align:left">Cognome e Nome</th>								
					<th>Attivo</th>
					<th style="text-align:left">Azioni</th>
				</tr>
			</thead>
			<tbody>
			<?php 	
				//$rec_pag=20;
				$rec_pag=$num_elem_news;
				$start=0;
				$pag_tot=0;
				if($num_ele>0)
				{		
					$pag_tot=ceil($num_ele/$rec_pag);					
					$start=($pag_att-1)*$rec_pag;
					$query_ele = "SELECT * FROM $table WHERE $criterio $pezzo_ord LIMIT $start,$rec_pag";
					$risu_ele = $open_connection->connection->query($query_ele);
					$num_item=$risu_ele->rowCount();		
					for($x=0;$x<$num_item;$x++)
					{						
						$arr_ele = $risu_ele->fetch();
						//$nome = ucwords(trim($arr_ele['nome']));
						//$cognome = ucwords(trim($arr_ele['cognome']));
						$email = trim($arr_ele['subscriber_email']);
						
						$id_campo = $arr_ele['subscriber_id'];
						$status = $arr_ele['subscriber_status'];
						
						$temp = explode(" ",$arr_ele['change_status_at']);
						
						$data = $oggetto_admin->date_to_data($temp['0'])."<br/>".$temp[1];
						
						$risu_ords = $open_connection->connection->query("select * from ".$prec_db."ordini where id_cliente='$id_campo'");
						$ha_ordini = $risu_ords->rowCount();
		
						/*$num_visite = 0;
						$query_visite = "select * from visite_prod where id_cli='$id_campo'";
						$risu_visite = $open_connection->connection->query($query_visite);
						if ($risu_visite) $num_visite = mysql_num_rows($risu_visite);*/
			?>
						<script type="text/javascript">
							lista_ind[<?php echo $x;?>]="<?php echo $id_campo;?>";
						</script>
						<tr class="riga_<?php if($x % 2){?>pari<?php }else{?>dispari<?php }?>">
							<td align="center" valign="center">
								<input type="checkbox" id="check_<?php echo $x+1;?>" onclick="aggiungi_lista('<?php echo $x+1;?>','<?php echo $id_campo;?>')"/>
							</td>
							<td align="center" valign="center"><?php  echo $start+$x+1; ?></td>
							<td valign="center"><?php  echo $data;?></td>
							<td valign="center" style="line-height:14px"><?php echo $email;?></td>
														
							<td  valign="center">
								<?php 
								$query_c="SELECT id, nome, cognome FROM ".$prefix."clienti_new WHERE email='".$email."'";
								$risu_c = $open_connection->connection->query($query_c);
								$num_c=$risu_c->rowCount();
								if($num_c>0){
									$row_c = $risu_c->fetch(PDO::FETCH_ASSOC);
									if ($row_c) {
										$id_c = $row_c['id'];
										$nome_c = $row_c['nome'];
										$cognome_c = $row_c['cognome'];
									}?>
									<a href="admin.php?cmd=clienti_mod&id_rec=<?php echo $id_c;?>" target="_blank" style="color:#333333; text-decoration:underline"><?php echo $nome_c;?> <?php echo $cognome_c;?></a>
								<?php }?>
							</td>	

							<td  align="center" valign="center">
								<a style="cursor:pointer" onclick="gestisci_vis('<?php echo $id_campo;?>')">
									<?php /*<img id="visibilita_<?php echo $id_campo;?>" src="<?php  if ($status=='1') echo "css/icons/icol32/accept_22.png"; else echo "css/icons/icol32/accept_22_off.png" ?>" alt=""/>*/?>
									<div style="width:30px; height:30px" id="visibilita_<?php echo $id_campo;?>">
										<?php  if ($status=='1'){?>
											<i class="fa-solid fa-circle-check fa-2x" style="color:#99D000"></i>
										<?php }else{?>
											<i class="fa-regular fa-circle fa-2x" style="color:red"></i>
										<?php }?>
									</div>
								</a>
							</td>
							
							<td style="width:10%" valign="center">
								<span class="btn-group">
									<a href="admin.php?cmd=<?php echo $pagina;?>_mod&id_rec=<?php  echo $id_campo; ?><?php echo $rif;?>" class="btn btn-small"><i class="icon-search"></i></a>
									<?php /*<a OnClick="return confirm('Sei sicuro di voler cancellare questo elemento?');" href="admin.php?cmd=<?php echo $pagina;?>&azione=cancella&id_canc=<?php  echo $id_campo; ?><?php echo $rif;?>" class="btn btn-small"><i class="icon-trash"></i></a>*/?>
								</span>
							</td>
						</tr>
					<?php }
				}?>
			</tbody>
		</table>		
		<?php include("fissi/multipagina.inc.php");?>
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
		
	$("#hiddenFrame").attr("src", "frame/iscrittoNewsletter.php?id_cli="+id);
  }
</script>

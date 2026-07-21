<?php 
$table=$prec_db."clienti_new";
$pagina="clienti";

$pdo = $open_connection->connection;

$criterio = "1=1"; // Evita problemi con AND iniziale
$params = [];
$rif = "";
$pag_att = $_GET['pag_att'] ?? 1;

// Campi da filtrare
$filtri = [
    'nome_ric' => 'nome',
    'cognome_ric' => 'cognome',
    'ragsoc_ric' => 'rag_sociale',
    'email_ric' => 'email',
    'stato_ric' => 'confermato'
];
foreach ($filtri as $key => $colonna) {
    if (!empty($_GET[$key])) {
        $criterio .= " AND $colonna LIKE :$key";
        $params[$key] = "%{$_GET[$key]}%";
        $rif .= "&$key=" . urlencode($_GET[$key]);
		$$key = $_GET[$key];
    }else $$key = "";
}

// Gestione ordinamento
$ascdesc = $_GET['ascdesc'] ?? 'desc';
$rif .= "&ascdesc=$ascdesc";

$neword = $_GET['neword'] ?? 'id';
$pezzo_ord = "ORDER BY $neword $ascdesc";

if(isset($_SESSION['num_elem_cli'])) $num_elem_cli = $_SESSION['num_elem_cli']; else $num_elem_cli = $_SESSION['num_elem_cli'] = "20";
//echo $num_elem_cli;

/*
if(isset($_GET['nome_ric'])) $nome_ric=$_GET['nome_ric']; else $nome_ric='';
if(isset($_GET['cognome_ric'])) $cognome_ric=$_GET['cognome_ric']; else $cognome_ric='';
if(isset($_GET['ragsoc_ric'])) $ragsoc_ric=$_GET['ragsoc_ric']; else $ragsoc_ric='';
if(isset($_GET['email_ric'])) $email_ric=$_GET['email_ric']; else $email_ric='';
if(isset($_GET['stato_ric'])) $stato_ric=$_GET['stato_ric']; else $stato_ric='';
if(isset($_GET['pag_att'])) $pag_att=$_GET['pag_att']; else $pag_att=1;

if($nome_ric!="") { $criterio.=" AND nome LIKE '%$nome_ric%'"; $rif.="&nome_ric=$nome_ric"; }
if($cognome_ric) { $criterio.=" AND cognome LIKE '%$cognome_ric%'"; $rif.="&cognome_ric=$cognome_ric"; }
if($ragsoc_ric) { $criterio.=" AND rag_sociale LIKE '%$ragsoc_ric%'"; $rif.="&ragsoc_ric=$ragsoc_ric"; }
if($email_ric!="") { $criterio.=" AND email LIKE '%$email_ric%'"; $rif.="&email_ric=$email_ric"; }
if($stato_ric!="") { $criterio.=" AND confermato LIKE '%$stato_ric%'"; $rif.="&stato_ric=$stato_ric"; }

// Questa è la parte che effettua l'ordinamento 
if(isset($_GET['ascdesc'])){
	$ascdesc = $_GET['ascdesc'];
 }else{
	$ascdesc="desc";
 }
$rif.="&ascdesc=$ascdesc";
 
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
	$rif.="&neword=$neword";
	$pezzo_ord = "order by $neword $ascdesc";
}else{
	$ord = "desc";
	$neword = "id";
	$pezzo_ord="order by id desc";
}


// fine ordinamento  */

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
						<label class="mws-form-label">Cognome</label>						
					</div>
					<div style="float:left; width:35%;">
						<input type="text" name="cognome_ric" value="<?php echo $cognome_ric;?>"  style="width:90%"/>
					</div>
					
					<div style="float:left; width:15%;">
						<label class="mws-form-label">Nome</label>									
					</div>
					<div style="float:left; width:35%;">
						<input type="text" name="nome_ric" value="<?php echo $nome_ric;?>"  style="width:90%"/>
					</div>
					<div style="clear:both;"></div>
				</div>	
			
				<div class="mws-form-row">
					<div style="float:left; width:15%;">
						<label class="mws-form-label">Rag. sociale</label>						
					</div>
					<div style="float:left; width:35%;">
						<input type="text" name="ragsoc_ric" value="<?php echo $ragsoc_ric;?>"  style="width:90%"/>
					</div>
					
					<div style="float:left; width:15%;">
						<label class="mws-form-label">Email</label>									
					</div>
					<div style="float:left; width:35%;">
						<input type="text" name="email_ric" value="<?php echo $email_ric;?>"  style="width:90%"/>
					</div>
					<div style="clear:both;"></div>
				</div>
			
				<div class="mws-form-row">
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
				<input type="button" value="Annulla" class="btn" onclick="window.location='admin.php?cmd=clienti'">
			</div>
		</form>
	</div>
	<div style="clear:both;height:30px">&nbsp;</div>
	<?php 
		$query_ele = "SELECT * FROM $table WHERE $criterio $pezzo_ord";
		$stmt = $pdo->prepare($query_ele);
		// Bind dei parametri per la ricerca
		foreach ($params as $key => $val) {
			$stmt->bindValue(":$key", $val, PDO::PARAM_STR);
		}

		$stmt->execute();
		$num_ele = $stmt->rowCount();
		
		/*$query_ele = "SELECT * FROM $table WHERE $criterio $pezzo_ord";			
		//echo $query_ele;
		$risu_ele = $open_connection->connection->query($query_ele);
		
		$num_ele = 0;
		if($risu_ele)
			$num_ele = $risu_ele->rowCount();	*/	
	?>
	<?php /*<div style="float:left;width:50%;text-align:left;height:30px"><!--<a style="color:#000" href="admin.php?cmd=<?php echo $table;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>&azione=scarica_clienti">Scarica il file dei clienti</a>--></div>
	<div style="float:left;height:40px;width:50%;text-align:right"><a class="btn" href="admin.php?cmd=<?php echo $pagina;?>_ins<?php echo $rif;?>&pag_att=<?php echo $pag_att;?>" style="color:#7a7a7a"><b>Aggiungi cliente</b></a> &nbsp; </div>*/?>
		
	<div class="product-page-per-view">
		<select onchange="cambiaSessionVarAdmin('num_elem_cli',this.value);" class="pt-sans-bold">
		  <option value="20" <?php if($num_elem_cli == 20){?>selected="selected"<?php }?>>20 Elementi Per Pagina</option>
		  <option value="50" <?php if($num_elem_cli == 50){?>selected="selected"<?php }?>>50 Elementi Per Pagina</option>
		  <option value="100" <?php if($num_elem_cli == 100){?>selected="selected"<?php }?>>100 Elementi Per Pagina</option>
		  <option value="200" <?php if($num_elem_cli == 200){?>selected="selected"<?php }?>>200 Elementi Per Pagina</option>
		  <option value="500" <?php if($num_elem_cli == 200){?>selected="selected"<?php }?>>500 Elementi Per Pagina</option>
		</select>
	</div>
		
	<div style="clear:both;height:20px">&nbsp;</div>
	<div class="mws-panel-header" style="position:relative;">
		<span><i class="icon-table"></i> Elenco <?php echo $pagina;?>  (<?php  echo $num_ele; ?>)</span>
	</div>
	<div class="mws-panel-body no-padding">
		<table class="mws-datatable-fn mws-table">
			<thead>
				<tr>
				<?php  
				$link = "admin.php?cmd=clienti".$rif;
				if($neword!=""){
					$link=str_replace("&neword=".$neword,"",$link);
				}
				if($ascdesc!=""){
					$link=str_replace("&ascdesc=asc","",$link);
					$link=str_replace("&ascdesc=desc","",$link);
				}
				?>
					<th style="width:20px"><input type="checkbox" id="check_tutti" onclick="aggiugni_tutti()"/></th>
					<th style="width:20px"></th>
					<th style="width:80px"><a style="color:#333;text-decoration:none" href="<?php echo $link;?>&neword=data_iscr&ascdesc=<?php  echo $ascdesc; ?>">Data iscr.</a><?php  if ($neword=="data_iscr" && $ascdesc=="asc") echo "&nbsp; <img src=\"images/core/sort_desc.png\">"; elseif ($neword=="data_iscr" && $ascdesc=="desc") echo "&nbsp; <img src=\"images/core/sort_asc.png\">"; else echo "&nbsp; <img src=\"images/core/sort.png\">"; ?></th>
					<th style="text-align:left"><a style="color:#333;text-decoration:none" href="<?php echo $link;?>&neword=cognome&ascdesc=<?php  echo $ascdesc; ?>">Cognome e Nome</a><?php  if ($neword=="cognome" && $ascdesc=="asc") echo "&nbsp; <img src=\"images/core/sort_desc.png\">"; elseif ($neword=="cognome" && $ascdesc=="desc") echo "&nbsp; <img src=\"images/core/sort_asc.png\">"; else echo "&nbsp; <img src=\"images/core/sort.png\">"; ?></th>			
					<th style="text-align:left"><a style="color:#333;text-decoration:none" href="<?php echo $link;?>&neword=rag_sociale&ascdesc=<?php  echo $ascdesc; ?>">Rag. sociale</a><?php  if ($neword=="rag_sociale" && $ascdesc=="asc") echo "&nbsp; <img src=\"images/core/sort_desc.png\">"; elseif ($neword=="rag_sociale" && $ascdesc=="desc") echo "&nbsp; <img src=\"images/core/sort_asc.png\">"; else echo "&nbsp; <img src=\"images/core/sort.png\">"; ?></th>			
					<th style="text-align:left"><a style="color:#333;text-decoration:none" href="<?php echo $link;?>&neword=email&ascdesc=<?php  echo $ascdesc; ?>">Email</a><?php  if ($neword=="email" && $ascdesc=="asc") echo "&nbsp; <img src=\"images/core/sort_desc.png\">"; elseif ($neword=="email" && $ascdesc=="desc") echo "&nbsp; <img src=\"images/core/sort_asc.png\">"; else echo "&nbsp; <img src=\"images/core/sort.png\">"; ?></th>
					<th>Ordini</th>
					<th>Attivo</th>
					<th style="text-align:left">Azioni</th>
				</tr>
			</thead>
			<tbody>
			<?php 	
				//$rec_pag=20;
				$rec_pag=$num_elem_cli;
				$start=0;
				$pag_tot=0;
				if($num_ele>0)
				{		
					$pag_tot=ceil($num_ele/$rec_pag);					
					$start=($pag_att-1)*$rec_pag;
					
					$query_ele = "SELECT * FROM $table WHERE $criterio $pezzo_ord LIMIT :start, :rec_pag";
					$stmt = $pdo->prepare($query_ele);
					$stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
					$stmt->bindValue(':rec_pag', (int)$rec_pag, PDO::PARAM_INT);

					// Bind dei parametri per la ricerca
					foreach ($params as $key => $val) {
						$stmt->bindValue(":$key", $val, PDO::PARAM_STR);
					}

					$stmt->execute();				
					while ($arr_ele = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$rag_soc = ucfirst(trim($arr_ele['rag_sociale']));
						$nome = ucwords(trim($arr_ele['nome']));
						$cognome = ucwords(trim($arr_ele['cognome']));
						$email = trim($arr_ele['email']);
						$news = 0;
					
						// Controllo iscrizione newsletter
						$query_n = "SELECT COUNT(*) FROM {$prefix}newsletter_subscriber WHERE subscriber_email = :email AND subscriber_status = 1";
						$stmt_n = $pdo->prepare($query_n);
						$stmt_n->bindValue(':email', $email, PDO::PARAM_STR);
						$stmt_n->execute();
						$num_n = $stmt_n->fetchColumn();
						if ($num_n != 0) $news = 1;

						$status = $arr_ele['confermato'];
						$id_campo = $arr_ele['id'];
						
						// Formattazione data
						$temp = explode(" ", $arr_ele['data_iscr']);
						$data = $oggetto_admin->date_to_data($temp[0]) . "<br/>" . $temp[1];
						
						// Controllo ordini del cliente
						$query_ords = "SELECT COUNT(*) FROM {$prec_db}ordini WHERE id_cliente = :id_cliente";
						$stmt_ords = $pdo->prepare($query_ords);
						$stmt_ords->bindValue(':id_cliente', $id_campo, PDO::PARAM_INT);
						$stmt_ords->execute();
						$ha_ordini = $stmt_ords->fetchColumn();
						$x=0;
					
					/*$query_ele = "SELECT * FROM $table WHERE $criterio $pezzo_ord LIMIT $start,$rec_pag";
					$risu_ele = $open_connection->connection->query($query_ele);
					$num_item=$risu_ele->rowCount();		
					for($x=0;$x<$num_item;$x++)
					{						
						$arr_ele = $risu_ele->fetch();
						$rag_soc = ucfirst(trim($arr_ele['rag_sociale']));
						$nome = ucwords(trim($arr_ele['nome']));
						$cognome = ucwords(trim($arr_ele['cognome']));
						$email = trim($arr_ele['email']);
						$news = $arr_ele['news'];
						$news = 0;
						$query_n="SELECT * FROM ".$prefix."newsletter_subscriber WHERE subscriber_email='".$email."' AND subscriber_status='1'";
						$risu_n = $open_connection->connection->query($query_n);
						$num_n = $risu_n->rowCount();
						if($num_n!=0) $news=1;
						$status = $arr_ele['confermato'];
						$id_campo = $arr_ele['id'];
						
						$temp = explode(" ",$arr_ele['data_iscr']);
						
						$data = $oggetto_admin->date_to_data($temp['0'])."<br/>".$temp[1];
						
						$risu_ords = $open_connection->connection->query("select * from ".$prec_db."ordini where id_cliente='$id_campo'");
						$ha_ordini = $risu_ords->rowCount();*/
		
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
							<td valign="center" style="line-height:14px"><?php  echo $cognome;?> <?php  echo $nome;?></td>
							<td valign="center" style="line-height:14px"><?php  echo $rag_soc;?></td>
														
							<td  valign="center">
								<a style="color:#000" href="mailto:<?php echo $email;?>"><?php echo $email;?></a>
								<?php if($news==1){?>
									<br/><span style="font-size:0.9em">(Inserito in Newsletter)</span>
								<?php }?>
							</td>
							
							<td  align="center" valign="center">
								<?php  if ($ha_ordini>0) { ?>
									<a href="admin.php?cmd=ordini&cognome_ric=<?php echo $cognome;?>&email_ric=<?php echo $email;?>" style="color:#333333">
										<div style="width:30px; height:30px; border-radius:15px; bottom:2px; right:2px; text-align:center; background:#000;">						
											<div style="color:#fff; padding-top:5px; font-weight:bold;"><?php echo $ha_ordini;?></div>
										</div>
									</a>
								<?php  } ?>
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
						<?php $x++;
					}
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
		
	$("#hiddenFrame").attr("src", "frame/visibileClienti.php?id_cli="+id);
  }
</script>

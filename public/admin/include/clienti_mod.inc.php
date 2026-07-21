<?php 
$table=$prec_db."clienti_new";
$pagina="clienti";
$rif="";

if(isset($_GET['nome_ric'])) $nome_ric=$_GET['nome_ric']; else $nome_ric='';
if(isset($_GET['cognome_ric'])) $cognome_ric=$_GET['cognome_ric']; else $cognome_ric='';
if(isset($_GET['ragsoc_ric'])) $ragsoc_ric=$_GET['ragsoc_ric']; else $ragsoc_ric='';
if(isset($_GET['email_ric'])) $email_ric=$_GET['email_ric']; else $email_ric='';
if(isset($_GET['pag_att'])) $pag_att=$_GET['pag_att']; else $pag_att=1;
if(isset($_GET['prov'])) $prov=$_GET['prov']; else $prov="";

if($nome_ric!="") { $rif.="&nome_ric=$nome_ric"; }
if($cognome_ric) { $rif.="&cognome_ric=$cognome_ric"; }
if($ragsoc_ric) { $rif.="&ragsoc_ric=$ragsoc_ric"; }
if($email_ric!="") { $rif.="&email_ric=$email_ric"; }

if($campocanc!="")
{
	/*$risu_img = mysql_query("select $campocanc from $table where id='$id_rec'");
	list($cancimg) = mysql_fetch_array($risu_img);
	
	if(is_file("img_up/$cancimg")){unlink("img_up/$cancimg");}
	if(is_file("img_up/s_$cancimg")){unlink("img_up/s_$cancimg");}
	$query_canc_img = "update $table set $campocanc='' where id='$id_rec'";
	echo $query_canc_img;*/
	$query_canc_img = "update $table set $campocanc=NULL where id='$id_rec'";
	$risu_canc_img = $open_connection->connection->query($query_canc_img);
}

$query_rec = "select * from $table where id='$id_rec'";
$risu_rec = $open_connection->connection->query($query_rec);
$arr_rec = $risu_rec->fetch();

$n_nome = $arr_rec['nome'];
$n_cognome = $arr_rec['cognome'];
$n_ragsoc = $arr_rec['rag_sociale'];
$n_partita = $arr_rec['partita_iva'];
$n_codice = $arr_rec['cod_fiscale'];
$n_email = $arr_rec['email'];
$n_password = $arr_rec['password'];
$n_indirizzo = $arr_rec['indirizzo'];
$n_citta = $arr_rec['citta'];
$n_cap = $arr_rec['cap'];
$n_provincia = $arr_rec['provincia'];
/*$n_regione = $arr_rec['regione'];*/
$n_nazione = $arr_rec['nazione'];
$n_tel = $arr_rec['telefono'];

$n_nome_sped = $arr_rec['nome_sped'];
$n_cognome_sped = $arr_rec['cognome_sped'];
$n_confermato = $arr_rec['confermato'];
?>

<script language="javascript">
	function annulla(){
		<?php if($prov!=""){?>
			window.location='admin.php?cmd=<?php echo $prov;?><?php echo $rif;?>';
		<?php }else{?>
			window.location='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>';
		<?php }?>
	}
</script>

<script language="javascript">
	function controllaPIVA( piva )
	{
		if ( piva.length == 11 )
		{
			var codiceUFFICIOiva = parseInt( piva.substr( 0, 3 ) ) ;
			if ( codiceUFFICIOiva <= 0 || codiceUFFICIOiva > 121 ) return false ;
		
			var X = 0 ;
			var Y = 0 ;
			var Z = 0 ;
		
			// cifre posto dispari ... ma per un array indicizzato a zero, la prima cifra ha indice zero ... appunto !
			X += parseInt( piva.charAt(0) ) ;
			X += parseInt( piva.charAt(2) ) ;
			X += parseInt( piva.charAt(4) ) ;
			X += parseInt( piva.charAt(6) ) ;
			X += parseInt( piva.charAt(8) ) ;

			// cifre posto pari ... ma per un array indicizzato a zero, la prima cifra ha indice uno ...
			Y += 2 * parseInt( piva.charAt(1) ) ;    if ( parseInt( piva.charAt(1) ) >= 5 ) Z++ ;
			Y += 2 * parseInt( piva.charAt(3) ) ;    if ( parseInt( piva.charAt(3) ) >= 5 ) Z++ ;
			Y += 2 * parseInt( piva.charAt(5) ) ;    if ( parseInt( piva.charAt(5) ) >= 5 ) Z++ ;
			Y += 2 * parseInt( piva.charAt(7) ) ;    if ( parseInt( piva.charAt(7) ) >= 5 ) Z++ ;
			Y += 2 * parseInt( piva.charAt(9) ) ;    if ( parseInt( piva.charAt(9) ) >= 5 ) Z++ ;
			
			var T = ( X + Y + Z ) % 10 ;

			var C = ( 10 - T ) % 10 ;

			return ( piva.charAt( piva.length - 1 ) == C ) ? true : false ;
		}
		else return false ;
	}
	
	Filtro = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{2,})+\.)+([a-zA-Z0-9]{2,})+$/;
	Filtro_piva = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-]{2,})+\.)+([a-zA-Z0-9]{2,})+$/;
	function verifica(){
		if (document.inserimento.nome.value=="") alert('Nome o Rag. sociale obbigatori');
		else if (document.inserimento.cognome.value=="") alert('Cognome obbigatorio');
		//else if(document.inserimento.partita_iva.value!="" && controllaPIVA(document.inserimento.partita_iva.value)==false) alert('Inserire una partita iva corretta');	
		else if (document.inserimento.email.value=="") alert('Email obbigatoria');	
		else if (Filtro.test(document.inserimento.email.value)==false) alert("Inserire un indirizzo email corretto");	
		/*else if (document.inserimento.password.value=="") alert('Password obbigatoria');*/
		else document.inserimento.submit();
	}
</script>
<?php 
if($stato=="inviato")
{
	$arr_no['stato']=1;
	
	/*$_POST['nome']=str_replace('"','\"',$_POST['nome']);
	$_POST['nome'] = str_replace("è", "&egrave;", $_POST['nome']);
	$_POST['nome'] = str_replace("é", "&eacute;", $_POST['nome']);
	$_POST['nome'] = str_replace("à", "&agrave;", $_POST['nome']);
	$_POST['nome'] = str_replace("ì", "&igrave;", $_POST['nome']);
	$_POST['nome'] = str_replace("ò", "&ograve;", $_POST['nome']);
	$_POST['nome'] = str_replace("ù", "&ugrave;", $_POST['nome']);	
	
	$_POST['cognome']=str_replace('"','\"',$_POST['cognome']);
	$_POST['cognome'] = str_replace("è", "&egrave;", $_POST['cognome']);
	$_POST['cognome'] = str_replace("é", "&eacute;", $_POST['cognome']);
	$_POST['cognome'] = str_replace("à", "&agrave;", $_POST['cognome']);
	$_POST['cognome'] = str_replace("ì", "&igrave;", $_POST['cognome']);
	$_POST['cognome'] = str_replace("ò", "&ograve;", $_POST['cognome']);
	$_POST['cognome'] = str_replace("ù", "&ugrave;", $_POST['cognome']);*/		
	
	$oggetto_admin->modifica_campi("$table" ,$id_rec , $arr_no ,  $arr_thumb="no" );
?>
	<script language="javascript">
		<?php if($prov!=""){?>
			window.location='admin.php?cmd=<?php echo $prov;?><?php echo $rif;?>';
		<?php }else{?>
			window.location='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>';
		<?php }?>
	</script>	
<?php 
}
else
{		
?>
<div class="mws-panel grid_8">
	<div style="height:50px;font-size:1.2em;padding-top:10px">
		<div style="float:left"><b>Modifica cliente</b></div>
		<!--<div style="float:right"><a href="admin.php?ric_stato=inviato&cmd=ordini&cognome_ric=<?php echo $n_cognome;?>&email_ric=<?php echo $n_email;?>" style="color:#333333"><b>Vedi Ordini</b></a></div>-->
		<div style="clear:both"></div>
	</div>
	<div class="mws-panel-header">
		<span>Dati richiesti</span>
	</div>
	<div class="mws-panel-body no-padding">
		<form name="inserimento" class="mws-form" action="admin.php?cmd=<?php echo $pagina;?>_mod&id_rec=<?php  echo $id_rec; ?><?php echo $rif;?>" method="post" enctype="multipart/form-data">
			<div class="mws-form-row">
				<label class="mws-form-label"><b>DATI ACCOUNT</b></label>
			</div>
			<input type="hidden" name="stato" value="inviato">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label class="mws-form-label">ATTIVO</label>
					<div class="mws-form-item">
						<select name="confermato" class="form-control" id="nazione">
							<option>-- Seleziona --</option>
							<option value="1" <?php if($n_confermato=='1'){?>selected="selected"<?php }?>>Sì</option>
							<option value="0" <?php if($n_confermato=='0'){?>selected="selected"<?php }?>>No</option>
						</select>
					</div>
				</div>
				<?php 
				$oggetto_admin->campo_mod("Nome *" , "nome" , "$n_nome"  , "1", 'no', "$cmd", "$id_rec","","","","","1");
				$oggetto_admin->campo_mod("Cognome *" , "cognome" , $n_cognome  , "1", 'no', $cmd, "$id_rec","","","","","1");
				$oggetto_admin->campo_mod("Email *" , "email" , $n_email  , "1", 'no', $cmd, "$id_rec","","","","","1","1");
				?>
				<div class="mws-form-row">
					<label class="mws-form-label"><b>DATI SPEDIZIONE</b></label>
				</div>
				<?php 
				$oggetto_admin->campo_mod("Nome" , "nome_sped" , "$n_nome_sped"  , "1", 'no', "$cmd", "$id_rec");
				$oggetto_admin->campo_mod("Cognome" , "cognome_sped" , $n_cognome_sped  , "1", 'no', $cmd, "$id_rec");
				$oggetto_admin->campo_mod("Rag. sociale" , "rag_sociale" , $n_ragsoc  , "1", 'no', $cmd, "$id_rec");
				$oggetto_admin->campo_mod("Partita IVA" , "partita_iva" , $n_partita  , "2", 'no', $cmd, "$id_rec");
				$oggetto_admin->campo_mod("Cod. Fiscale" , "cod_fiscale" , $n_codice  , "2", 'no', $cmd, "$id_rec");
				$oggetto_admin->campo_mod("Indirizzo" , "indirizzo" , $n_indirizzo  , "1", 'no', $cmd, "$id_rec");
				$oggetto_admin->campo_mod("CAP" , "cap" , $n_cap  , "2", 'no', $cmd, "$id_rec","width:100px");
				$oggetto_admin->campo_mod("Città" , "citta" , $n_citta  , "1", 'no', $cmd, "$id_rec");
				$oggetto_admin->campo_mod("Provincia" , "provincia" , $n_provincia  , "1", 'no', $cmd, "$id_rec");
				?>
				<div class="mws-form-row">
					<label class="mws-form-label">Nazione</label>
					<div class="mws-form-item">
						<select name="nazione" class="form-control" id="nazione">
							<option>-- Seleziona --</option>
							<?php 
							$query_naz="SELECT nome FROM ".$prefix."nazioni ORDER BY nome ASC";
							$risu_naz=$open_connection->connection->query($query_naz);
							while($arr_naz=$risu_naz->fetch()){?>
								<option value="<?php echo $arr_naz['nome'];?>" <?php if($n_nazione==$arr_naz['nome']){?>selected="selected"<?php }?>><?php echo $arr_naz['nome'];?></option>						
							<?php }?>
						</select>
					</div>
				</div>
				<?php 
				$oggetto_admin->campo_mod("Telefono" , "telefono" , $n_tel  , "2", 'no', $cmd, "$id_rec");
				?>
				
				<br/><br/>
				<div style="margin-left:20px; padding-bottom:10px;">* <i>campi obbligatori</i></div>
				<div style="margin-left:20px; padding-bottom:10px;">** <i>uno dei due campi &egrave; obbligatorio</i></div>
			</div>
			<div class="mws-button-row">
				<input type="button" value="Modifica" class="btn btn-danger" onclick="verifica();">
				<input type="button" value="Annulla" class="btn" onclick="annulla()">
			</div>
		</form>
	</div>
</div>
<?php 
}
?>

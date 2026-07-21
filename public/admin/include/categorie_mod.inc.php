<?php 
$table=$prec_db."categorie";
$pagina="categorie";
$directory="categorie";

$rif="";
if(isset($_GET['id_rife'])) $id_rife=$_GET['id_rife']; else $id_rife='';
if($id_rife!="") $rif="&id_rife=$id_rife";
if(isset($_GET['pag_att'])) $pag_att=$_GET['pag_att']; else $pag_att=1;
$rif.="&pag_att=$pag_att";

$query_rec = "select * from $table where id='$id_rec'";
$risu_rec    = $open_connection->connection->query($query_rec);
$arr_rec = $risu_rec->fetch();

$n_nome = $arr_rec['nome'];
$n_nome_eng = $arr_rec['nome_eng'];
$n_macro = $arr_rec['id_rife'];
?>
<script language="javascript">
	function annulla(){
		window.location='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>';
	}
</script>

<script language="javascript">
	function verifica(){
		/*var foto_old = "<?php echo $n_foto;?>";*/
		
		if (document.inserimento.id_rife.value=="") alert('Macrocategoria obbigatoria');
		else if (document.inserimento.nome.value=="") alert('Nome obbigatorio');
		/*else if (foto_old=="" && document.inserimento.img.value=="") alert('Immagine obbigatoria');*/
		else document.inserimento.submit();
	}
</script>
<?php 

/*if($campocanc!="")
{
	$risu_img = $open_connection->connection->query("select $campocanc from $table where id='$id_rec'");
	list($cancimg) = $risu_img->fetch();
	
	if(is_file("img_up/prodotti/categorie/$cancimg")){unlink("img_up/prodotti/categorie/$cancimg");}
	if(is_file("img_up/prodotti/categorie/s_$cancimg")){unlink("img_up/prodotti/categorie/s_$cancimg");}
	$query_canc_img = "update $table set $campocanc='' where id='$id_rec'";
	$open_connection->connection->query($query_canc_img);
}*/

if($stato=="inviato")
{
	$arr_no['stato']=1;
		
	$_POST['nome']=str_replace('"','\"',$_POST['nome']);
	$_POST['nome'] = str_replace("è", "&egrave;", $_POST['nome']);
	$_POST['nome'] = str_replace("é", "&eacute;", $_POST['nome']);
	$_POST['nome'] = str_replace("à", "&agrave;", $_POST['nome']);
	$_POST['nome'] = str_replace("ì", "&igrave;", $_POST['nome']);
	$_POST['nome'] = str_replace("ò", "&ograve;", $_POST['nome']);
	$_POST['nome'] = str_replace("ù", "&ugrave;", $_POST['nome']);	
	
	
	$oggetto_admin->modifica_campi ("$table", $id_rec, $arr_no, $arr_thumb="no");
	
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
	<div style="height:50px;font-size:1.2em;padding-top:10px"><b>Modifica categoria</b></div>
	<div class="mws-panel-header">
		<span>Dati richiesti</span>
	</div>
	<div class="mws-panel-body no-padding">
		<form name="inserimento" class="mws-form" action="admin.php?cmd=<?php echo $pagina;?>_mod&id_rec=<?php  echo $id_rec; ?><?php echo $rif;?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="stato" value="inviato">
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label class="mws-form-label">Macrocategoria *</label>
					<div class="mws-form-item">
						<select name="id_rife" class="small">
							<option value="">Seleziona</option>
							<?php 
							$query_m="SELECT * FROM ".$prec_db."macrocategorie ORDER BY nome";
							$resu_m=$open_connection->connection->query($query_m);
							while($risu_m=$resu_m->fetch()){?>
								<option value="<?php echo $risu_m['id'];?>" <?php if($risu_m['id']==$n_macro) echo "selected=\"selected\"";?>><?php echo $risu_m['nome'];?></option>
							<?php }?>					
						</select>
					</div>
				</div>
				<?php 
				$oggetto_admin->campo_mod("Nome *" , "nome" , "$n_nome"  , "1", 'no', "$cmd", "$id_rec");
				$oggetto_admin->campo_mod("Nome (inglese)" , "nome_eng" , "$n_nome_eng"  , "1", 'no', "$cmd", "$id_rec");
				?>
				
				<br/><br/>
				<div style="margin-left:20px; padding-bottom:10px;">* <i>campi obbligatori</i></div>				
			</div>
			<div class="mws-button-row">
				<input type="button" value="Modifica" class="btn btn-danger" onclick="verifica()">
				<input type="button" value="Annulla" class="btn" onclick="annulla()">
			</div>
		</form>
	</div>
</div>
<?php 
}
?>

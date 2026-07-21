<?php 
$table=$prec_db."users";
$pagina="utenti";

if($azione=="cancella" && $id_canc!="") {
	$quer_canc = "delete from $table where id='$id_canc' ";
	$risu_del = $open_connection->connection->query($quer_canc);
?>
	<script language="javascript">
		/*window.alert("Il campo e' stato cancellato con successo");
		window.location="admin.php?cmd=utenti";*/
		window.location="admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>&pag_att=<?php echo $pag_att;?>";
	</script>
<?php 	
}

if($azione=="attiva"){
	$quer_canc = "update $table set attivo='1' where id='$id_ute' ";
	$risu_del = $open_connection->connection->query($quer_canc);
}

if($azione=="disattiva"){
	$quer_canc = "update $table set attivo='0' where id='$id_ute' ";
	$risu_del = $open_connection->connection->query($quer_canc);
}
?>
<div class="mws-panel grid_8">
	<div style="height:50px;font-size:1.2em;padding-top:10px"><b>Gestione Utenti</b></div>
	<div style="height:30px;width:100%;text-align:right"><a href="admin.php?cmd=utenti_ins" style="color:#7a7a7a"><b>Aggiungi utente</b></a> &nbsp; </div>
	<div class="mws-panel-header">
		<span><i class="icon-table"></i> Elenco utenti</span>
	</div>
	<div class="mws-panel-body no-padding">
		<table class="mws-datatable-fn mws-table">
			<thead>
				<tr>
					<th>Nome</th>
					<th>Username</th>
					<th>Password</th>
					<th>Livello</th>
					<th>Azioni</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				$quer = "select * from $table";
				$risu = $open_connection->connection->query($quer);
				$num_ele = $risu->rowCount();
				
				$rec_pag=20;					
				$pag_tot=ceil($num_ele/$rec_pag);					
				$start=($pag_att-1)*$rec_pag;
				
				for ($x=0;$x<$num_ele;$x++){
					$arr_ding 	= $risu->fetch();
					$nome_ute	= $arr_ding['identificativo'];
					$user_adm_ute 	= $arr_ding['user_adm'];
					$pass_adm_ute 	= $arr_ding['pass_adm'];
					$level_ute 	= $arr_ding['livello'];
					$stato_ute 	= $arr_ding['attivo'];
					$id_ute  		= $arr_ding['id'];
					if($level_ute=="300")$stringa_lev = "CWS";
					if($level_ute=="200")$stringa_lev = "Amministratore";
			?>
				<tr>
					<td><?php  echo $nome_ute; ?></td>
					<td><?php  echo $user_adm_ute; ?></td>
					<td><?php  echo $pass_adm_ute; ?></td>
					<td><?php  echo $level_ute; ?></td>
					<td style="width:15%">
						<span class="btn-group">
							<?php  if ($stato_ute==1) { ?><a href="admin.php?cmd=utenti&azione=disattiva&id_ute=<?php  echo $id_ute; ?>" class="btn btn-small"><i class="icol-shape-square"></i></a><?php  } else { ?><a href="admin.php?cmd=utenti&azione=attiva&id_ute=<?php  echo $id_ute; ?>" class="btn btn-small"><i class="icol-stop"></i></a><?php  } ?>
							<a href="admin.php?cmd=utenti_mod&id_ute=<?php  echo $id_ute; ?>" class="btn btn-small"><i class="icon-pencil"></i></a>
							<a href="admin.php?cmd=utenti&azione=cancella&id_canc=<?php  echo $id_ute; ?>" class="btn btn-small"><i class="icon-trash"></i></a>
						</span>
					</td>
				</tr>
			<?php 
				}
			?>
			</tbody>
		</table>
		<?php include("fissi/multipagina.inc.php");?>
	</div>
</div>
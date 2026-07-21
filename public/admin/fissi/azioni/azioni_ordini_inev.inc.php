<?php if($coupon==""){?>
	<a class="btn btn-small" style="color:#111; cursor:default" title="Nessun Coupon Sconto"><i class="fa fa-percent" aria-hidden="true"></i></a>
<?php }else{?>
	<a class="btn btn-small" style="color:green; cursor:default" title="Coupon Sconto Applicato"><i class="fa fa-percent" aria-hidden="true"></i></a>
<?php }?>
<a href="admin.php?cmd=ordine-dett&id_rec=<?php echo $id_campo;?>&id_rife=<?php echo $id_rife;?>" title="Dettaglio" class="btn btn-small"><i class="icon-search"></i></a>
<?php if ($stato_ordine=="sospeso"){?>
	<a OnClick="return confirm('Confermi lo sblocco di questo ordine?');" href="admin.php?cmd=ordini-inev&azione=sblocca&id_rec=<?php echo $id_campo;?>&id_rife=<?php echo $id_rife;?>" title="Sblocca ordine e invia conferma disponibilità" class="btn btn-small"><i class="fa fa-unlock" aria-hidden="true"></i></a>
<?php }elseif ($stato_ordine=="pagato" || $arr_ele['Contrassegno']>'0'){?>
	<a OnClick="return confirm('Confermi che questo ordine è stato evaso?');" href="admin.php?cmd=ordini-inev&azione=evadi&id_rec=<?php echo $id_campo;?>&id_rife=<?php echo $id_rife;?>" title="Evadi" class="btn btn-small"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
<?php }else{?>
	<a class="btn btn-small" href="https://wa.me/<?php echo $telefono;?>/?text=<?php echo $testo_wa;?>" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
<?php }?>
<a OnClick="return confirm('Sei sicuro di voler cancellare questo elemento?');" href="admin.php?cmd=<?php echo $pagina;?>&azione=cancella&id_canc=<?php  echo $id_campo; ?>&id_rife=$id_rife" title="Cancella" class="btn btn-small"><i class="icon-trash"></i></a>

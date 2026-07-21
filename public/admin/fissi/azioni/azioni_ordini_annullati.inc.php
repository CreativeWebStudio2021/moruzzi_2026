<?php if($coupon==""){?>
	<a class="btn btn-small" style="color:#111; cursor:default" title="Nessun Coupon Sconto"><i class="fa fa-percent" aria-hidden="true"></i></a>
<?php }else{?>
	<a class="btn btn-small" style="color:green; cursor:default" title="Coupon Sconto Applicato"><i class="fa fa-percent" aria-hidden="true"></i></a>
<?php }?>
<a href="admin.php?cmd=ordine-dett&id_rec=<?php echo $id_campo;?>&id_rife=<?php echo $id_rife;?>" title="Dettaglio" class="btn btn-small"><i class="icon-search"></i></a>
<a OnClick="return confirm('Sei sicuro di voler cancellare questo elemento?');" href="admin.php?cmd=<?php echo $pagina;?>&azione=cancella&id_canc=<?php  echo $id_campo; ?>" title="Cancella" class="btn btn-small"><i class="icon-trash"></i></a>

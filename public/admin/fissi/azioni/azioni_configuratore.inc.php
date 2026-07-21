<a href="frame/configuratore.php<?php echo $rif;?>&id_canc=<?php  echo $id_campo; ?>&azione=primo" class="btn btn-small"><i class="icon-arrow-up-2"></i></a>
<a href="frame/configuratore.php<?php echo $rif;?>&id_canc=<?php  echo $id_campo; ?>&azione=sali" class="btn btn-small"><i class="icon-arrow-up"></i></a>
<a href="frame/configuratore.php<?php echo $rif;?>&id_canc=<?php  echo $id_campo; ?>&azione=scendi" class="btn btn-small"><i class="icon-arrow-down"></i></a>
<a href="frame/configuratore.php<?php echo $rif;?>&id_canc=<?php  echo $id_campo; ?>&azione=ultimo" class="btn btn-small"><i class="icon-arrow-down-2"></i></a>
<a href="frame/<?php echo $table;?>_mod.php<?php echo $rif;?>&id_rec=<?php  echo $id_campo; ?>" class="btn btn-small"><i class="icon-pencil"></i></a>
<a onclick="return confirm('Cancellare questo elemento?')" href="<?php echo $http;?>://<?php echo $ind_sito;?>/admin/frame/configuratore.php<?php echo $rif;?>&azione=cancella&id_canc=<?php  echo $id_campo; ?>" class="btn btn-small"><i class="icon-trash"></i></a>

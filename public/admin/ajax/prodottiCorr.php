<?php 
require_once '../config/db.php';	

if(isset($_GET['ric_cat'])) $ric_cat=$_GET['ric_cat']; else $ric_cat="";
if(isset($_GET['lista_prodotti_correlati'])) $lista_prodotti_correlati=$_GET['lista_prodotti_correlati']; else $lista_prodotti_correlati="";
?>
<?php if($ric_cat!=""){?>
	<table class="table table-correlati">
		<thead>
			<tr>
				<td><input type="checkbox" id="checkboxSelectAll" class="form-check-input"/></td>
				<td><strong>Nome</strong></td>
			</tr>
		</thead>
		<tbody>
		<?php 
		$query="SELECT * FROM ".$prec_db."prodotti WHERE categorie LIKE '%$ric_cat%'";
		$query.=" ORDER BY entity_id DESC";
		$risu=$open_connection->connection->query($query);
		$num = $risu->rowCount();
		if($num>0){
			while($arr=$risu->fetch()){?>
				<tr>
					<td><input id="correlato-<?php echo $arr['entity_id'];?>" class="checkboxCorrelati" type="checkbox" name="selected[]" value="<?php echo $arr['entity_id'];?>" class="form-check-input"></td>
					<td><?php echo $arr['name'];?></td>
				</tr>
			<?php }
		}else{?>
			<div style="text-align:center">
				<i>Nessun risultato</i>
			</div>
		<?php }?>
		<?php $risu->closeCursor(); ?>
		</tbody>
	</table>
<?php }?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.table-correlati').DataTable({
			 "paging":   false,
			 "info":     false
        });

		$('#checkboxSelectAll').change(function() {
			$('.checkboxCorrelati').prop('checked', this.checked).change();
		});

		$('.checkboxCorrelati').change(function() {
			var idProdCorr = $(this).val();
			var lista_prodotti_correlati = $("#correlati").val();
			if(this.checked) {
				lista_prodotti_correlati+="@"+idProdCorr+"@";
				$(this).closest('tr').attr('style', 'background-color: #ddd');
			}else{
				lista_prodotti_correlati = lista_prodotti_correlati.replace("@"+idProdCorr+"@", "");
				$(this).closest('tr').attr('style', 'background-color: #fff');
			}

			prodottiCorrelatiSelezionati(lista_prodotti_correlati);
			$("#correlati").val(lista_prodotti_correlati);
		});
    });
</script>
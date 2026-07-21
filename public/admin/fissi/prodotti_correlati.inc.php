<div class="mws-panel-header">
	<span>SELEZIONA <strong style="color:#fff; font-size:1.3em">PRODOTTI CORRELATI</strong></span>
</div>
	
<?php 
$macro_ric_corr=$cat_ric_corr="";
?>
<div style="padding:20px">
	<div class="mws-form-row">
		<div style="float:left; width:10%;">
			<label class="mws-form-label">Categoria</label>						
		</div>
		<div style="float:left; width:90%;">
			<select id="macro_corr" class="small" style="width:90%" onchange="listaProdottiCorrelati(this.value);">
				<option>Seleziona..</option>
				<?php printCategoryTreeSelect(2,$open_connection);?>
			</select>
		</div>
		<div style="clear:both;"></div>
	</div>
</div>

<div id="listaProdottiCorrelati"></div>

<div class="mws-panel-header">
	<span>LISTA <strong style="color:#fff; font-size:1.3em">PRODOTTI CORRELATI</strong> SELEZIONATI</span>
</div>
<div class="mws-panel-body no-padding" id="prodottiCorrelatiSelezionati"></div>				

<script>
	var lista_prodotti_correlati=document.getElementById('correlati').value;
	function listaProdottiCorrelati(ric_cat=""){
		$.ajax({
			url: "ajax/prodottiCorr.php", 
			type: "GET",
			data: {ric_cat : ric_cat}, 
			success: function(result){
				$("#listaProdottiCorrelati").html(result);
			}
		});
	}
	function prodottiCorrelatiSelezionati(lista=""){
		$.ajax({
			url: "ajax/prodottiCorrSelezionati.php", 
			type: "GET",
			data: {lista : lista}, 
			success: function(result){
				$("#prodottiCorrelatiSelezionati").html(result);
			}
		});
	}

	$('body').on('click', 'a.deleteCorrelati', function() {
		var idProdCorr = $(this).data("id");
		$("#correlato-" + idProdCorr).prop("checked", false);
		$("#correlato-" + idProdCorr).closest('tr').attr('style', 'background-color: #fff');
		var lista_prodotti_correlati = $("#correlati").val();
		lista_prodotti_correlati = lista_prodotti_correlati.replace("@"+idProdCorr+"@", "");
		prodottiCorrelatiSelezionati(lista_prodotti_correlati);
		$("#correlati").val(lista_prodotti_correlati);
	});

	listaProdottiCorrelati();
	prodottiCorrelatiSelezionati(document.getElementById('correlati').value);
</script>
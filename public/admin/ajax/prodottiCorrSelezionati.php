<?php
require_once '../config/db.php';
require_once '../include/product_image_r2.php';

if (isset($_GET['lista'])) {
	$lista = (string) $_GET['lista'];
} else {
	$lista = '';
}

$ids = [];
if ($lista !== '') {
	preg_match_all('/@(\d+)@/', $lista, $matches);
	$ids = array_values(array_unique($matches[1] ?? []));
}
?>
<table class="mws-datatable-fn mws-table">
	<thead>
		<tr>
			<th style="width:100px;">Immagine</th>
			<th style="text-align:left;">Prodotto</th>
			<th>Azioni</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($ids === []) { ?>
			<tr>
				<td colspan="3" style="text-align:center">
					<br/><br/>Nessun prodotto selezionato<br/><br/><br/>
				</td>
			</tr>
		<?php } else {
			foreach ($ids as $i => $id_p) {
				$query_p = 'SELECT * FROM '.$prec_db.'prodotti WHERE entity_id='.$id_p;
				$risu_p = $open_connection->connection->query($query_p);
				$arr_ele = $risu_p ? $risu_p->fetch(PDO::FETCH_ASSOC) : false;
				if ($risu_p) {
					$risu_p->closeCursor();
				}
				if (! $arr_ele) {
					continue;
				}

				$nome = ucfirst((string) ($arr_ele['name'] ?? ''));
				$id_campo = (int) $arr_ele['entity_id'];
				?>
				<tr class="riga_<?php echo ($i % 2) ? 'pari' : 'dispari'; ?>">
					<td align="center" valign="center">
						<img src="<?php echo productImageUrl($arr_ele['image'] ?? null, 'thumb'); ?>" alt="<?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?>" width="100px"/>
					</td>
					<td>
						<div>
							<b><?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?></b>
						</div>
					</td>
					<td style="width:10%">
						<span class="btn-group">
							<a data-id="<?php echo $id_campo; ?>" class="btn btn-small deleteCorrelati"><i class="icon-trash"></i></a>
						</span>
					</td>
				</tr>
			<?php }
		} ?>
	</tbody>
</table>

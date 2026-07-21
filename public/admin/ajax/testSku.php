<?php 
require_once '../config/db.php';	
$table=$prec_db."prodotti";

if(isset($_GET['search'])) $search=$_GET['search']; else $search="";
if(isset($_GET['sku'])) $sku=$_GET['sku']; else $sku="";

$query = "SELECT entity_id FROM $table WHERE sku='".$search."'";
if($sku!="") $query .= " AND sku<>'".$sku."'";

$risu = $open_connection->connection->query($query);
$num = $risu->rowCount();
if($num>0){?>
	<div style="width:100%; height:100%; background:red; color:#fff">
		<div style="padding:5px">
			<b>ATTENZIONE! Il codice inserito è già stato utilizzato!</b>
		</div>
	</div>
<?php }?>
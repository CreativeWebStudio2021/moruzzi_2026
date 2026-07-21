<?
require_once '../config/db.php';	

if(isset($_GET['id_prod'])) $id_prod=$_GET['id_prod']; else $id_prod="";

$query="SELECT visibility FROM ".$prec_db."prodotti WHERE entity_id='$id_prod'";
$resu = $open_connection->connection->query($query);
$row = $resu->fetch(PDO::FETCH_ASSOC);
$visibile = $row['visibility'] ?? 0;

if($visibile==0) $query2="UPDATE ".$prec_db."prodotti SET visibility='1' WHERE entity_id='$id_prod'";
else  $query2="UPDATE ".$prec_db."prodotti SET visibility='0' WHERE entity_id='$id_prod'";
$risu = $open_connection->connection->query($query2);
?>
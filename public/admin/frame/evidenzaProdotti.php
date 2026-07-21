<?
require_once '../config/db.php';	

if(isset($_GET['id_prod'])) $id_prod=$_GET['id_prod']; else $id_prod="";

$query="SELECT categorie FROM ".$prec_db."prodotti WHERE entity_id='$id_prod'";
$resu = $open_connection->connection->query($query);
$row = $resu->fetch(PDO::FETCH_ASSOC);
$categorie = $row['categorie'] ?? '';

if(str_contains($categorie, '@1435@'))
	$query2="UPDATE ".$prec_db."prodotti SET categorie='".str_replace("@1435@","",$categorie)."' WHERE entity_id='$id_prod'";
else  
	$query2="UPDATE ".$prec_db."prodotti SET categorie='@1435@".$categorie."' WHERE entity_id='$id_prod'";

$risu = $open_connection->connection->query($query2);
?>
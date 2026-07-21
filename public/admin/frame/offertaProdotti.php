<?
require_once '../config/db.php';	
if(isset($_GET['id_prod'])) $id_prod=$_GET['id_prod']; else $id_prod="";

$query="SELECT categorie FROM ".$prec_db."prodotti WHERE entity_id='$id_prod'";
$resu = $open_connection->connection->query($query);
$row = $resu->fetch(PDO::FETCH_ASSOC);
$categorie = $row['categorie'] ?? '';
echo $categorie."<br/>";

if(str_contains($categorie, '@969@'))
	$query2="UPDATE ".$prec_db."prodotti SET categorie='".str_replace("@969@","",$categorie)."' WHERE entity_id='$id_prod'";
else  
	$query2="UPDATE ".$prec_db."prodotti SET categorie='@969@".$categorie."' WHERE entity_id='$id_prod'";
echo $query2;
$risu = $open_connection->connection->query($query2);
?>
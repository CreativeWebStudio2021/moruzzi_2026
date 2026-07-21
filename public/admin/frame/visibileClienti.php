<?
require_once '../config/db.php';	

if(isset($_GET['id_cli'])) $id_cli=$_GET['id_cli']; else $id_cli="";

$query="SELECT confermato FROM ".$prec_db."clienti_new WHERE id='$id_cli'";
$resu = $open_connection->connection->query($query);
$row = $resu ? $resu->fetch(PDO::FETCH_ASSOC) : false;
$visibile = $row['confermato'] ?? 0;

if($visibile==0) $query2="UPDATE ".$prec_db."clienti_new SET confermato='1' WHERE id='$id_cli'";
else  $query2="UPDATE ".$prec_db."clienti_new SET confermato='0' WHERE id='$id_cli'";
$risu = $open_connection->connection->query($query2);
?>
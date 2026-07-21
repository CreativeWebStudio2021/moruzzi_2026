<?
require_once '../config/db.php';	

if(isset($_GET['id_cli'])) $id_cli=$_GET['id_cli']; else $id_cli="";

$query="SELECT subscriber_status FROM ".$prec_db."newsletter_subscriber WHERE subscriber_id='$id_cli'";
$resu = $open_connection->connection->query($query);
$row = $resu->fetch(PDO::FETCH_ASSOC);
$visibile = $row ? $row['subscriber_status'] : 0;

if($visibile==1) $query2="UPDATE ".$prec_db."newsletter_subscriber SET subscriber_status='0' WHERE subscriber_id='$id_cli'";
else  $query2="UPDATE ".$prec_db."newsletter_subscriber SET subscriber_status='1' WHERE subscriber_id='$id_cli'";
$risu = $open_connection->connection->query($query2);
?>
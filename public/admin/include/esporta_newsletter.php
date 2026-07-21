<?php
session_start();
require_once '../config/db.php';

if(isset($_SESSION["loggato"]) && $_SESSION["loggato"]=="si"){
    header('Pragma: public');
    header('Expires: 0');
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=iscritti_newsletter_' . date('dmYHis') . '.csv');

    $output =  fopen('php://output', 'w');
    $riga = array("Data iscrizione","Email","Cognome","Nome","Attivo");
    fputcsv($output,$riga,";");

    $query_ele = "SELECT n.*, c.cognome, c.nome FROM ".$prec_db."newsletter_subscriber n LEFT JOIN ".$prec_db."clienti_new c ON(n.customer_id=c.id) ORDER BY change_status_at DESC";
    $risu_ele = $open_connection->connection->query($query_ele);

    foreach($risu_ele as $r){
        $subscriber_status =  ($r['subscriber_status']) ? 'SI' : 'NO';
        $riga = [$r['change_status_at'], $r['subscriber_email'], $r['cognome'], $r['nome'], $subscriber_status];
        fputcsv($output, $riga,";");
    }
    
    exit();
}
?>
<?php 
	include(__DIR__.'/body_mail.css.php');
	
	$rag_sociale = stripslashes($rag_sociale);
	$email = stripslashes($email);
	
	$intestazioni  = "From:  $nome_del_sito <$mail_sito>\n";
	$intestazioni .= "MIME-Version: 1.0\n";
	$intestazioni .= "Content-type: text/html; \n charset=iso-8859-1\n";
	
	$oggetto_ut    = "Comunicazione sblocco ordine num. $id_rec";
	
	$testo_cliente ="<br><br><br>Gentile <b>$nome</b> <b>$cognome</b>,
		<br><br>le comunichiamo che il suo ordine num. $id_rec è stato sbloccato dal venditore in quanto la merce ordinata risulta disponibile, quindi ora può procedere ad effettuare il pagamento accedendo alla sua area riservata sul sito.";
	if($Contrassegno==0) $testo_cliente .="<br/>Le ricordiamo inoltre che il pagamento dovra essere evaso entro e non oltro 3 giorni dalla data di conferma dell'ordine. ";
	$testo_cliente .="<br/><br/><a href='".$link_sblocco."'><div style='padding:10px 20px; width:180px; text-align:center; background:#F3889D; color:#fff'>VAL AL DETTAGLIO ORDINE</div></a>";
	$testo_cliente .="<br/>Segue riepilogo dei suoi dati e dettaglio degli articoli ordinati:
		<br><br>
		$dati_ordine
		<br><br>";
	
	$body_cli = str_replace("CONTENUTO_DA_SOSTITUIRE", $testo_cliente, $body);
	
	//invioMail($send_mail, $from_email, $from_name, $to_email, $to_name, $subject, $body, $reply_to_email="", $reply_to_name="", $file="")
	invioMail($send_mail_azi, $mail_sito, $nome_del_sito, $email, $nome, $oggetto_ut, $body_cli, $mail_sito, $nome_del_sito, "", $SMTP_host, $SMTP_user, $SMTP_psw);
?>
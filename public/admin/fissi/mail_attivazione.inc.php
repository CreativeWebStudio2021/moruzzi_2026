<?php 
include("../../fissi/body_mail.css.php");

$nome_cliente = ucfirst($nome1);
$cognome_cliente = ucfirst($cognome1);

$intestazioni  = "From:  $nome_del_sito <$mail_sito>\n";
$intestazioni .= "MIME-Version: 1.0\n";
$intestazioni .= "Content-type: text/html; \n charset=iso-8859-1\n";

$oggetto_ut    = "Comunicazione attivazione account ingrosso";

$testo_cliente ="<br><br><br>Gentile <b>$nome_cliente</b> <b>$cognome_cliente</b>,
			<br><br>ti comunichiamo che il tuo account è stato attivato, quindi ora potrai iniziare ad uitlizzare i tuoi dati di accesso:
			<br><br>
			<b>Username:</b> $email1<br>
			<b>Password:</b> password inserita
			<br><br>";

$body_cli = str_replace("CONTENUTO_DA_SOSTITUIRE", $testo_cliente, $body);

//invioMail($send_mail, $from_email, $from_name, $to_email, $to_name, $subject, $body, $reply_to_email="", $reply_to_name="", $file="")
invioMail($send_mail_azi, $mail_sito, $nome_del_sito, $email1, $nome_cliente." ".$cognome_cliente, $oggetto_ut, $body_cli, $mail_sito, $nome_del_sito, "", $SMTP_host, $SMTP_user, $SMTP_psw);
?>
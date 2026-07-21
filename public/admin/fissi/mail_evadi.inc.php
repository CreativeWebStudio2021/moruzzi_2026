<?php 
if($email && trim($email)!=""){
	include(__DIR__.'/body_mail.css.php');

	$nome_cliente = ucwords($nome);
	$cognome_cliente = ucwords($cognome);

	$oggetto_ut    = "Comunicazione evasione ordine num. $id_rec";

	$testo_cli ="<br><br><br>Gentile <b>$nome</b> <b>$cognome</b>,
				<br><br>le comunichiamo che il suo ordine num. <b>$id_rec</b> è stato evaso e la relativa merce spedita o ritirata.";
	if(isset($vettore) && $vettore!="" && isset($tracciamento) && $tracciamento!=""){
		$testo_cli .='
			<br/>
			<br/>
			<div style="background:#f5f5f5">
				<div style="padding:20px;">
					La spedizione avverrà tramite <b>'.$vettore.'</b>.<br/>
					Per tracciare il pacco seguire il seguente link:<br/>
					<a href="'.$tracciamento.'" target="_blank">'.$tracciamento.'</a>
				</div>
			</div>
		';
	}
	$testo_cli .="<br/>Segue riepilogo dei suoi dati e dettaglio degli articoli ordinati:
				<br><br>
				$dati_ordine
				<br><br>";

	$body_cli = str_replace("CONTENUTO_DA_SOSTITUIRE", $testo_cli, $body);
	
	$body_cli = str_replace("CONTENUTO_DA_SOSTITUIRE", $testo_cli, $body);
	
	/* mail inviata alla persona*/
		
	$send_mail_cli->CharSet = "UTF-8";
	try {
		$send_mail_cli->IsSMTP();
		$send_mail_cli->SMTPDebug = 0;
		$send_mail_cli->SMTPAuth = true;
		$send_mail_cli->SMTPSecure = 'ssl';
		$send_mail_cli->Host = $SMTP_host;
		$send_mail_cli->Port = 465;
		$send_mail_cli->Username = $SMTP_user;
		$send_mail_cli->Password = $SMTP_psw;
		
		//Content
		$send_mail_cli->setFrom($mail_sito, $nome_del_sito);
		$send_mail_cli->addAddress($email, $cognome." ".$nome);
		//$send_mail_cli->addAddress("test-bxkyek56u@srv1.mail-tester.com", $nome." ".$cognome);
		//$send_mail_cli->addAddress('recipient2@yourdomain_name.com');
		$send_mail_cli->addReplyTo($mail_sito, $nome_del_sito);
		//$send_mail_cli->addCC('cc@yourdomain_name.com');
		//$send_mail_cli->addBCC('bcc@yourdomain_name.com');
				
		$send_mail_cli->isHTML(true); 
		$send_mail_cli->Subject = $oggetto_ut;
		$send_mail_cli->Body    = $body_cli; 
		$send_mail_cli->send();
		
	} catch (Exception $e) {
		echo 'Sorry Dear, Message could not be sent.';
		echo 'Mailer Error: ' . $send_mail_cli->ErrorInfo;
	}
}?>
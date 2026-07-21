<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	if (! isset($email_body)) {
		$email_body = __DIR__.'/body_mail_new.css.php';
	} else {
		$email_body = __DIR__.'/'.basename($email_body);
	}
	include $email_body;
	
			
	if(!isset($email_oggetto)) $email_oggetto = "";
	if(!isset($email_nome_destinatario)) $email_nome_destinatario = "";
	if(!isset($email_cognome_destinatario)) $email_cognome_destinatario = "";
	if(!isset($email_invio)) $email_invio = "";
	if(!isset($email_replay)) $email_replay = $mail_sito;
	if(!isset($email_replay_nome)) $email_replay_nome = $nome_del_sito;
	
	/* mail inviata alla persona*/
		
	$send_mail = new PHPMailer(TRUE);
	$send_mail->CharSet = "UTF-8";
	try {
		$send_mail->IsSMTP();
		$send_mail->SMTPDebug = 0;
		$send_mail->SMTPAuth = true;
		$send_mail->SMTPSecure = 'ssl';
		$send_mail->Host = $SMTP_host;
		$send_mail->Port = 465;
		$send_mail->Username = $SMTP_user;
		$send_mail->Password = $SMTP_psw;
		
		//Content
		$send_mail->setFrom($mail_sito, $nome_del_sito);
		if($email_cognome_destinatario!="" && $email_nome_destinatario!=""){
			$send_mail->addAddress($email_invio, $email_cognome_destinatario." ".$email_nome_destinatario);			
		}else{
			$send_mail->addAddress($email_invio);
		}
		//$send_mail->addAddress("aa@yourdomain_name.com", "nome cognome");
		$send_mail->addReplyTo($email_replay, $email_replay_nome);
		//$send_mail->addCC('cc@yourdomain_name.com');
		//$send_mail->addBCC('bcc@yourdomain_name.com');
				
		$send_mail->isHTML(true); 
		$send_mail->Subject = $email_oggetto;
		$send_mail->Body    = $body; 
		$send_mail->send();
		//echo $email_invio." ".$email_cognome_destinatario." ".$email_nome_destinatario;
	} catch (Exception $e) {
		echo 'Sorry Dear, Message could not be sent.';
		echo 'Mailer Error: ' . $send_mail->ErrorInfo;
	}

			
?>
			
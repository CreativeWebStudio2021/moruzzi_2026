<?php
function invioMail($send_mail, $from_email, $from_name, $to_email, $to_name, $subject, $body, $reply_to_email="", $reply_to_name="", $file="", $SMTP_host="", $SMTP_user="", $SMTP_psw=""){
	//$send_mail = new PHPMailer(TRUE);
	$send_mail->CharSet = "UTF-8";
	try {
		//PHP Simple Server settings
		/**/$send_mail->IsSMTP();
		$send_mail->SMTPDebug = 0;
		$send_mail->SMTPAuth = true;
		$send_mail->SMTPSecure = 'ssl';
		$send_mail->Host = $SMTP_host;
		$send_mail->Port = 465;
		$send_mail->Username = $SMTP_user;
		$send_mail->Password = $SMTP_psw;
		
	 
		//PHP Files Attachments
		if ($file!="" && is_file($file)){
			$send_mail->addAttachment($file);
		}
		 
		//Content
		$send_mail->setFrom($from_email, $from_name);
		$send_mail->addAddress($to_email, $to_name);
		//$send_mail->addAddress('recipient2@yourdomain_name.com');
		if($reply_to_email!="" && $reply_to_name!=""){
			$send_mail->addReplyTo($reply_to_email, $reply_to_name);
		}
		//$send_mail->addCC('cc@yourdomain_name.com');
		//$send_mail->addBCC('bcc@yourdomain_name.com');
		$send_mail->isHTML(true); 
		$send_mail->Subject = $subject;
		$send_mail->Body    = $body; 
		$send_mail->send();
		//echo 'Good Luck Your Message has been sent';
		return "OK";
	} catch (Exception $e) {
		/*echo 'Sorry Dear, Message could not be sent.';
		echo 'Mailer Error: ' . $send_mail->ErrorInfo;*/
		return "KO";
	}
}
?>
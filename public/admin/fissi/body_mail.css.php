<?php
$body = $body1 = "
<html><head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\"/>
<meta http-equiv=\"content-language\" content=\"IT\"/>

<style type=\"text/css\">
	body{ 
		padding: 30px 20px;
		margin:0px;
		width:800px;
		background-color:#f5f5f5;
		text-align:left;	
		font-family: \"Open Sans\";
		font-size: 13px;
		color: black;
	}

	img{border:0px}
		
	a{text-decoration:none; color:#777}
	a:hover{color: $color1;}
	a.menu{text-decoration:none;color: #00142e;}
	a.menu:hover{color: #00142e; border-color:#00142e}

	.big{	font-size: 13px;}
</style>

</head>

<body class=\"testo\">

<div style=\"position:relative;top:0px;left:0px;\">
	<img style=\"width:250px;\" src=\"$logo_mail\">
</div>";

$body .= "
		<div style=\"position:relative;left:0px;z-index:20;margin:20px 0px 0px 0px; background:#fff\">
			<div style=\"padding:20px\">
				CONTENUTO_DA_SOSTITUIRE
			</div>
		</div>
 
<div style=\"position:relative;left:0px; color:#777\">
	<div style=\"padding:20px;\">
		<div style=\"float:left; width:33%\">
			<a href=\"https://www.moruzzi.it/cipresentiamo.html\">Chi siamo</a><br/>
			<a href=\"https://www.moruzzi.it/per_posta_elettronica.html\">Assistenza Clienti</a>
		</div>
		<div style=\"float:left; width:33%\">
			Tel: <a href=\"tel:+390671510220\">+39 06 71510220</a>
			<br/><br/>
			Orari di apertura:<br/>
			10:00-13:30 e 15:30-19:00.
		</div>
		<div style=\"float:left; width:34%\">
			Moruzzi Numismatica<br/>
			Viale dei Salesiani, 12a<br/>
			Roma, Roma 00175,<br/>
			Italia
		</div>
		<div style=\"clear:both\"></div>
		
		<div style=\"margin-top:10px; color:#777\">
			<br><br>
			P.S.	questa email è stata spedita automaticamente dal nostro sistema informatico.
			<br>
			<p class=\"menu\" style=\"border-top:1px solid #777;padding-top:20px;width:700px;\">
			Avviso di riservatezza - Il testo e gli eventuali documenti trasmessi contengono informazioni riservate al destinatario indicato. La seguente e-mail &egrave; confidenziale e la sua riservatezza &egrave; tutelata dal GDPR 679/16. La lettura, copia o altro uso non autorizzato o qualsiasi altra azione derivante dalla conoscenza di queste informazioni sono rigorosamente vietate. Qualora abbiate ricevuto questo documento per errore siete cortesemente pregati di darne immediata comunicazione al mittente, ai numeri qui indicati e/o all'indirizzo dello stesso e di provvedere immediatamente alla sua distruzione.
			</p>
		</div>
	</div>
</div>

</body>
</html>";

$body1 .= "<div style=\"position:relative;left:0px;z-index:20;margin:20px 0px 0px 0px\">CONTENUTO_DA_SOSTITUIRE</div>
 
</body>
</html>";
?>

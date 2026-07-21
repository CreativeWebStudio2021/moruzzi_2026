<?php 
/*
// **PREVENTING SESSION HIJACKING** 
// Prevents javascript XSS attacks aimed to steal the session ID
ini_set('session.cookie_httponly', 1);  
// **PREVENTING SESSION FIXATION** 
// Session ID cannot be passed through URLs 
ini_set('session.use_only_cookies', 1);  
// Uses a secure connection (HTTPS) if possible 
ini_set('session.cookie_secure', 1);  
// When a cookie is marked samesite=Lax, that cookie will not be passed for any cross-domain requests unless it's a regular link that navigates user to the target site 
ini_set('session.cookie_samesite', 'Strict');
*/

session_start();

require_once 'config/db.php';	
require_once 'config/array.php';	
require_once 'fissi/functions_adm.php';
require_once 'fissi/all_posts.php';
//require_once 'fissi/functions.php';
require_once 'fissi/functions.php';
require_once 'fissi/array.inc.php';
require_once 'include/product_image_r2.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include("fissi/function_invio_mail.php");
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$send_mail_azi = new PHPMailer(TRUE);
$send_mail_cli = new PHPMailer(TRUE);

if($cmd=="destroy"){
	unset($_SESSION["loggato"]);
	unset($_SESSION["acl_login"]);
	unset($_SESSION["nome_login"]);
}

if(!isset($_SESSION["loggato"]) ){
	$_SESSION["loggato"] = "no";
	/*$_SESSION["loggato"] = "si";*/
}

if(!isset($_SESSION["nome_login"]) ){
	$_SESSION["nome_login"] = "";
}

if(isset($_POST['memorizza'])) {
	$memorizza=$_POST['memorizza'];
} else $memorizza=false;

$user_login = $pass_login = $log = "";

if( isset($_POST["user_login"]) && isset($_POST["pass_login"]) )
{
	$user_login = $_POST["user_login"];
	$pass_login = $_POST["pass_login"];
	
	if ($memorizza && $user_login && $pass_login) {
	/* memorizza comunque */
		$arr_cookie_options = array (
                'expires' => time()+3600*24, 
                'path' => '/', 
                /*'domain' => $ind_sito, // leading dot for compatibility or use subdomain
                'secure' => true,     // or false
                'httponly' => true,    // or false
                'samesite' => 'Strict' // None || Lax  || Strict*/
                );
		
		setcookie("mio_user_ldm", $user_login, $arr_cookie_options);
		setcookie("mio_pass_ldm", $pass_login, $arr_cookie_options);
		$_COOKIE['mio_user_ldm'] = $user_login;
		$_COOKIE['mio_pass_ldm'] = $pass_login;
	}
	
	$query_login = "select * from ".$prefix_db."users where user_adm=:user_login and attivo='1'";
	$risu_login = $open_connection->connection->prepare($query_login);
	$risu_login->execute(array(':user_login'=>$user_login));
	
	$log = "no";
	if($risu_login)
	{
		$num_login = $risu_login->rowCount();
		if($num_login>0)
		{
			$arr_login = $risu_login->fetch();
			if((crypt($pass_login, $arr_login['pass_adm']) == $arr_login['pass_adm']) || $pass_login==$arr_login['pass_adm'])
			{
				$acl_log = $arr_login['livello'];
				$nome_log = ucwords($arr_login['identificativo']);
				$_SESSION["acl_login"] = $acl_log ;
				$_SESSION["loggato"] = "si";
				$_SESSION["nome_login"] = $nome_log;
				
				$log = "si";
			}
		}
	}
} 

$val_user = "";
if(isset($_COOKIE['mio_user_ldm'])) $val_user = $_COOKIE['mio_user_ldm'];
$val_pass = "";
if(isset($_COOKIE['mio_pass_ldm'])) $val_pass = $_COOKIE['mio_pass_ldm'];

$oggetto_admin = new Functions_adm($array_sito);

$data_att = date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="it">
<head>
<title>ADMIN - <?php  echo strtoupper($nome_del_sito);?></title>
<base href="<?php echo $http;?>://<?php  echo $ind_sito ?>/admin/" /> 
<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<!-- Viewport Metatag -->
<meta name="viewport" content="width=device-width, user-scalable=no">

<script src="https://kit.fontawesome.com/c4a7304807.js" crossorigin="anonymous"></script>

<!-- Required Stylesheets -->
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/fonts/ptsans/stylesheet.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/fonts/icomoon/style.css" media="screen">

<link rel="stylesheet" type="text/css" href="css/mws-style.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/icons/icol16.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/icons/icol32.css" media="screen">

<link rel="stylesheet" type="text/css" href="css/login.css" media="screen">

<!-- Demo Stylesheet -->
<link rel="stylesheet" type="text/css" href="css/demo.css" media="screen"><?php /**/?>

<?php /*<!-- jQuery-UI Stylesheet -->
<link rel="stylesheet" type="text/css" href="jui/css/jquery.ui.all.css" media="screen">
<link rel="stylesheet" type="text/css" href="jui/jquery-ui.custom.css" media="screen">*/?>

<!-- Theme Stylesheet -->
<link rel="stylesheet" type="text/css" href="css/mws-theme.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/themer.css" media="screen">

<?php 
include(__DIR__ . '/fissi/favicon.inc.php');?>

<?php /*<script src="ckeditor/ckeditor.js"></script>*/?>
<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<!-- <script src="https://code.jquery.com/jquery-1.8.3.min.js" integrity="sha256-YcbK69I5IXQftf/mYD8WY0/KmEDCv1asggHpJk1trM8=" crossorigin="anonymous"></script> -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<style>
#mws-container .container{	margin: 0 4%;}
.container{	width: 92%;}
.azioniDesk{display:none}

.cke_notifications_area{display:none}

@media screen AND (max-width:1200px){
	#mws-container .container{	margin: 0 1%;}
	.container{	width: 98%;}
}
@media screen AND (min-width:1025px){
	.azioniDesk{display:table-cell}
	.azioniMob{display:none}
}
</style> 

</head>

<body>
	<!-- Header -->
	<div id="mws-header" class="clearfix" style="background-color:#ffffff">
	<?php 
		include("fissi/testata_adm.inc.php");
	?>
	</div>
	<!-- Start Main Wrapper -->
    <div id="mws-wrapper">	
	<?php 
	include("fissi/menu_adm.inc.php");
	
	if(isset($_SESSION["loggato"]) && $_SESSION["loggato"]=="si")
	{
	?>
	
		<!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
			<!-- Inner Container Start -->
            <div class="container">
				<?php if(is_file("include/".$cmd.".inc.php")){
						include("include/".$cmd.".inc.php");
				}else{
					include("include/home.inc.php");
				}?>
				
				<div style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:10000; display:none;" id="mask">
					<div style="position:relative; width:80%; height:80%; margin-left:10%; margin-top:5%; background:#fff;" id="frameContainer">
						<iframe src="" style="width:100%; height: 100%; border:none;" id="framePage"></iframe>
						<div style="position:absolute; top:10px; right:35px; cursor:pointer;" onclick="$('#mask').fadeOut(); <?php /*location.reload();*/?>">
							<i class="fa fa-times-circle-o fa-2x" aria-hidden="true"></i>
						</div>
					</div>
				</div>
			</div>
		<?php /*
			<!-- Footer -->
			<div id="mws-footer">
				Creative Web Studio
			</div>*/?>
		</div>
	
	<?php 
	}
	else
	{
		include("login.inc.php");
	}
	?>
	</div>
	
	<!-- JavaScript Plugins -->
    
    <!-- jQuery-UI Dependent Scripts -->
	<script src="https://code.jquery.com/ui/1.9.2/jquery-ui.min.js" integrity="sha256-eEa1kEtgK9ZL6h60VXwDsJ2rxYCwfxi40VZ9E0XwoEA=" crossorigin="anonymous"></script>
  <?php /*
	 <!-- jQuery-UI Dependent Scripts -->
    <script src="jui/js/jquery-ui-1.9.2.min.js"></script>
    <script src="jui/jquery-ui.custom.min.js"></script>
    <script src="jui/js/jquery.ui.touch-punch.js"></script>
	<script src="jui/js/jquery-ui-effects.min.js"></script>*/?>
	
	<?php if($cmd=="ordini" || $cmd=="ordini-dett"){?>
		<style>
			.ui-datepicker{background-color:#ddd !important; padding:10px; border:solid 1px #BCBCBC}
			.ui-state-default{color:#111 !important}
			.ui-state-active{color:#fff !important; text-align:center}
			.ui-datepicker td.ui-datepicker-current-day {text-align:center}
			.ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next{background-color:<?php echo $color1;?>; color:#fff; margin-right:20px; padding:2px; cursor:pointer}
			.ui-datepicker .ui-datepicker-next{margin-left:40px;}
			.ui-datepicker td.ui-datepicker-current-day{background-color:<?php echo $color1;?>;}
			.ui-datepicker-title{text-align:center}
		</style>
		<script type="text/javascript">
			$.datepicker.setDefaults( $.datepicker.regional[ "it" ] );
			$( ".mws-datepicker" ).datepicker({ dateFormat: 'dd-mm-yy' });
		</script>
	<?php }?>
	
   
	<?php  
	if($log == "no")
	{
	?>
	<script language="javascript">
		(function($) {
			$(document).ready(function() {	
				window.alert('Non ci sono utenti attivi che possano accedere con queste username e password');
				document.login.user_login.value = '';
				document.login.pass_login.value = '';
				});
		}) (jQuery);
	</script>
	<?php 	
	}
	?>
	<?php if($cmd=="prodotti_ins" || $cmd=="prodotti_mod"){?>
		<script>
			function addCatProd(id_cat, nomi_cat){
				var iframe = document.getElementById('framePage');
				var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
				
				var catList = document.getElementById('categorie').value;
				var catNameList = document.getElementById('selectedCatList').innerHTML;
				// Modifica dell'elemento nel frame child
				var iconCheck = iframeDocument.getElementById('iconCheck_'+id_cat);
				if (iconCheck.classList=='fa-regular fa-square') {
					iconCheck.classList.remove('fa-square');
					iconCheck.classList.remove('fa-regular');
					iconCheck.classList.add('fa-solid');
					iconCheck.classList.add('fa-square-check');
					catList = catList+"@"+id_cat+"@";
					if(catNameList=="Seleziona...")
						catNameList = nomi_cat+", ";
					else
						catNameList = catNameList+nomi_cat+", ";
				}else{
					iconCheck.classList.remove('fa-solid');
					iconCheck.classList.remove('fa-square-check');
					iconCheck.classList.add('fa-regular');
					iconCheck.classList.add('fa-square');
					catList = catList.replace('@'+id_cat+'@', '');
					catNameList = catNameList.replace(nomi_cat+", ", '');
					if(catNameList=="") catNameList="Seleziona...";
				}
				document.getElementById('categorie').value=catList;
				//catNameList = catNameList.slice(2);
				document.getElementById('selectedCatList').innerHTML=catNameList;
				//alert(catList);
				//alert(catNameList);
			}
		</script>
	<?php }?>
</body>
</html>

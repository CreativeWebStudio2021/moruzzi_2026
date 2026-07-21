<?php
session_start();

require_once '../config/db.php';
require_once '../config/array.php';
require_once '../fissi/functions.php';
require_once '../fissi/functions_adm.php';
require_once '../fissi/all_posts.php';

$oggetto_admin = new Functions_adm($array_sito);
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->
<head>
<title><?php echo strtoupper($nome_del_sito); ?> - admin</title>
<base href="<?php echo $http; ?>://<?php echo $ind_sito; ?>/admin/" />
<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<!-- Viewport Metatag -->
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<script src="https://kit.fontawesome.com/c4a7304807.js" crossorigin="anonymous"></script>

<!-- Required Stylesheets -->
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/fonts/ptsans/stylesheet.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/fonts/icomoon/style.css" media="screen">

<link rel="stylesheet" type="text/css" href="css/mws-style.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/icons/icol16.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/icons/icol32.css" media="screen">

<link rel="stylesheet" type="text/css" href="css/login.css" media="screen">

<!-- Demo Stylesheet -->
<link rel="stylesheet" type="text/css" href="css/demo.css" media="screen">

<!-- Theme Stylesheet -->
<link rel="stylesheet" type="text/css" href="css/mws-theme.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/themer.css" media="screen">

<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>

</head>

<body>
	<!-- Start Main Wrapper -->
    <div id="mws-wrapper">
	<?php if (isset($_SESSION['loggato']) && $_SESSION['loggato'] === 'si') { ?>
		<div class="mws-panel grid_3">
			<div style="padding:20px;">
				<div style="height:50px;font-size:1.2em;padding-top:10px">
					<div style="float:left; width:50%; height:50px;"><b>Lista Categorie</b></div>
					<div style="float:right; width:50%; height:50px; text-align:right;">
						<button class="btn" onclick="$(parent.document).find('#mask').fadeOut();">CONFERMA</button>
					</div>
				</div>
				<?php
				$prov = 'frame';
				printCategoryTree2(2, 2, $prov, $open_connection, 'it', $ric_cat = '');
				?>
				<script>
					var catList = parent.document.getElementById('categorie').value;

					if (catList !== '') {
						catList = catList.slice(1, -1);
						var numbers = catList.split('@@');
						numbers.forEach(function (number) {
							var cleanNumber = parseInt(number, 10);
							if (!cleanNumber) {
								return;
							}

							var iconCheck = document.getElementById('iconCheck_' + cleanNumber);
							if (!iconCheck) {
								return;
							}

							iconCheck.classList.remove('fa-square');
							iconCheck.classList.remove('fa-regular');
							iconCheck.classList.add('fa-solid');
							iconCheck.classList.add('fa-square-check');
						});
					}
				</script>
			</div>
		</div>
	<?php } else { ?>
		<div style="padding:20px;">
			<p>Sessione scaduta. Chiudi questa finestra e accedi nuovamente al pannello admin.</p>
		</div>
	<?php } ?>
	</div>

	<!-- JavaScript Plugins -->
   <script src="https://code.jquery.com/jquery-1.8.3.min.js" integrity="sha256-YcbK69I5IXQftf/mYD8WY0/KmEDCv1asggHpJk1trM8=" crossorigin="anonymous"></script>

    <!-- jQuery-UI Dependent Scripts -->
	<script src="https://code.jquery.com/ui/1.9.2/jquery-ui.min.js" integrity="sha256-eEa1kEtgK9ZL6h60VXwDsJ2rxYCwfxi40VZ9E0XwoEA=" crossorigin="anonymous"></script>

</body>
</html>

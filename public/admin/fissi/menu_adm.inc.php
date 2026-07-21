<?php 
	if(isset($_SESSION["loggato"]) && $_SESSION["loggato"]=="si"){
?>
<!-- Necessary markup, do not remove -->
<div id="mws-sidebar-stitch"></div>
<div id="mws-sidebar-bg"></div>

<style>
	@media only screen and (min-width: 600px) and (max-width: 1024px){
		#mws-navigation ul li ul li a, #mws-navigation ul li ul li span {
			padding: 4px 4px;
			text-align: left;
		}
	}
</style>

<!-- Sidebar Wrapper -->
<div id="mws-sidebar" style="height:100%">

	<!-- Hidden Nav Collapse Button -->
	<div id="mws-nav-collapse">
		<span></span>
		<span></span>
		<span></span>
	</div>
	
	<!-- Searchbox 
	<div id="mws-searchbox" class="mws-inset">
		<form action="typography.html">
			<input type="text" class="mws-search-input" placeholder="Search...">
			<button type="submit" class="mws-search-submit"><i class="icon-search"></i></button>
		</form>
	</div>-->
	<style>
		#mws-navigation ul li.active a{
			color:#F9ED11 !important;
			font-weight:800;
		}
	</style>
	<!-- Main Navigation -->
	<div id="mws-navigation">
		<ul>
			<?php if(isset($_SESSION["acl_login"]) && $_SESSION["acl_login"]>="300"){?>
				<li <?php if($cmd=="utenti"){?>class="active"<?php }?>><a href="admin.php?cmd=utenti"><i class="icon-users"></i> Gestione Utenti</a></li>
			<?php }?>	
			
			<?php 
			if(isset($_GET['off_ric'])) $off_ric=$_GET['off_ric']; else $off_ric="";			
			if(isset($_GET['nov_ric'])) $nov_ric=$_GET['nov_ric']; else $nov_ric="";
			?>
			<li style="margin-top:20px">
				<a href="#"><i class="icon-folder-closed"></i> Shop on line</a>
				<ul>
					<li <?php if($cmd=="categorie" || $cmd=="categorie_ins" || $cmd=="categorie_mod"){?>class="active"<?php }?>><a href="admin.php?cmd=categorie">Categorie</a></li>
					<li <?php if($cmd=="prodotti" || $cmd=="prodotti_ins" || $cmd=="prodotti_mod"){?>class="active"<?php }?>><a href="admin.php?cmd=prodotti">Prodotti</a></li>
				</ul>
			</li>
			
			
			<li style="margin-top:20px" <?php if($cmd=="clienti" || $cmd=="clienti_mod"){?>class="active"<?php }?>><a href="admin.php?cmd=clienti"><i class="icon-business-card"></i> Clienti</a></li>
			<li style="margin-top:20px" <?php if($cmd=="newsletter"){?>class="active"<?php }?>><a href="admin.php?cmd=newsletter"><i class="icon-newspaper"></i> Newsletter</a></li>
			
			<?php  if(isset($_GET['stato_ric'])) $stato_ric=$_GET['stato_ric']; else $stato_ric=""; ?>
			<li style="margin-top:20px">
				<a ><i class="icon-shopping-cart"></i>Gestione ordini</a>
				<ul>
					<li <?php if($cmd=="ordini" && $stato_ric=="aperti"){?>class="active"<?php }?>><a href="admin.php?cmd=ordini&stato_ric=aperti">Ordini Aperti</a></li>
					<li <?php if($cmd=="ordini" && $stato_ric=="evasi"){?>class="active"<?php }?>><a href="admin.php?cmd=ordini&stato_ric=evasi">Ordini Evasi</a></li>
					<li <?php if($cmd=="ordini" && $stato_ric=="annullati"){?>class="active"<?php }?>><a href="admin.php?cmd=ordini&stato_ric=annullati">Ordini Annullati</a></li>					
				</ul>
			</li>
																		
			<li style="margin-top:50px"><a href="../home.html" target="_blank"><i class="icon-bended-arrow-left"></i> <i>Torna al sito</i></a></li>
		</ul>
	</div>         
</div>
<?php 
}
?>


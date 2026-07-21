 <style>
	#mws-header {
		border-color: <?php echo $color1;?> !important;
	}
</style>
<div id="mws-logo-container" style="background-color:#ffffff; width:50%">
	<div style="float:left">
		<a href="https://<?php echo $ind_sito;?>" target="_blank">
			<img src="../images/<?php echo $logo_sito;?>" style="width:200px; margin-top:15px;" alt="<?php echo $nome_del_sito;?>">
		</a>
	</div>
</div>

<div id="mws-user-tools" class="clearfix">
	<?php 
		if(isset($_SESSION["loggato"]) && $_SESSION["loggato"]=="si") {
	?>
	<div id="mws-user-info" class="mws-inset">
	
		<div id="mws-user-photo">
			<img src="css/icons/icol32/user_gray.png" alt="User Photo">
		</div>
		
		<div id="mws-user-functions">
			<div id="mws-username">
				Ciao, <?php  echo $_SESSION["nome_login"]; ?>
			</div>
			<ul>
				<li><a href="admin.php?cmd=destroy">Logout</a></li>
			</ul>
		</div>
	</div>
	<?php 
		}
	?>
</div>

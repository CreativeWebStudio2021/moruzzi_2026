<div id="mws-login-wrapper">
	<div id="mws-login">
		<h1>Login</h1>
		<div class="mws-login-lock"><i class="icon-lock"></i></div>
		<div id="mws-login-form">
			<form name="login" class="mws-form" action="admin.php" method="post">
				<div class="mws-form-row">
					<div class="mws-form-item">
						<input type="text" name="user_login" value="<?=$val_user?>" class="mws-login-username required" placeholder="username">
					</div>
				</div>
				<div class="mws-form-row">
					<div class="mws-form-item">
						<input type="password" name="pass_login" value="<?=$val_pass?>" class="mws-login-password required" placeholder="password">
					</div>
				</div>
				<div id="mws-login-remember" class="mws-form-row mws-inset">
					<ul class="mws-form-list inline">
						<li>
							<input name="memorizza" id="memorizza" type="checkbox"> 
							<label for="memorizza">Remember me</label>
						</li>
					</ul>
				</div>
				<style>
					.mws-login-button{border:none !important}
					.btn-success{background:<?=$color1;?> !important; border:none}
					.btn-success:hover{background:<?=$color1hover;?> !important}
				</style>
				<div class="mws-form-row">
					<input type="submit" value="Login" class="btn btn-success mws-login-button">
				</div>
				<input type="hidden" name="CSRFToken" value=""/>
			</form>
			<script language="javascript">
				if (leggiCookie('mio_user_fiorillo')!="") user = leggiCookie('mio_user_fiorillo');
					else user = "username";
				if (leggiCookie('mio_pass_fiorillo')!="") pass = leggiCookie('mio_pass_fiorillo');
					else pass = "password";
				document.login.user_login.value = user;
				document.login.pass_login.value = pass;
			</script>
		</div>
	</div>
	<?	
	if ($_SERVER['REMOTE_ADDR']=="185.133.94.135") {
		$link_crm="http://192.168.0.15/crm/index.php?cmd=lista_password&nome_campo=backoffice&nome_azienda=fiorillo&azienda=";
		?>
		<div style="width:100%; text-align:right; margin-top:10px;"><a href="<?=$link_crm;?>" style="color:#2c2c30;" target="_blank"><b>CRM</b></a></div>
	<?}?>
</div>
<?php 
$table=$prec_db."categorie_new";
$pagina="categorie";
$directory="categorie";

if(isset($_GET['path_cat'])) $path_cat=$_GET['path_cat']; else $path_cat="";

$criterio="";
$rif = "";
if($path_cat!="") {
	$rif="&path_cat=".$path_cat;
	$criterio = " AND link_it='".$path_cat.".html'";
}

if ($campocanc === 'image' && !empty($id_rec)) {
	$cancEntityId = (int) $id_rec;
	$risu_img = $open_connection->connection->prepare("SELECT image FROM {$table} WHERE entity_id = ? LIMIT 1");
	$risu_img->execute([$cancEntityId]);
	$row_img = $risu_img->fetch(PDO::FETCH_ASSOC);
	$cancimg = ($row_img && !empty($row_img['image'])) ? $row_img['image'] : null;

	if (!empty($cancimg)) {
		if (is_file("img_up/categorie/$cancimg")) @unlink("img_up/categorie/$cancimg");
		if (is_file("img_up/categorie/s_$cancimg")) @unlink("img_up/categorie/s_$cancimg");
		if (is_file("img_up/categorie/xs_$cancimg")) @unlink("img_up/categorie/xs_$cancimg");
	}

	$open_connection->connection->prepare("UPDATE {$table} SET image = NULL WHERE entity_id = ?")->execute([$cancEntityId]);
	\App\Models\Category::forgetImageMapCache();

	$redirectPath = admin_category_path_from_entity($open_connection, $prefix, $cancEntityId);
	$redirectRif = $redirectPath !== '' ? '&path_cat=' . rawurlencode($redirectPath) : '';
	?>
	<script language="javascript">
		window.location='admin.php?cmd=<?php echo $pagina;?><?php echo $redirectRif;?>';
	</script>
	<?php
	exit;
}

$query="SELECT * FROM ".$prefix."categorie_new ORDER BY entity_id ASC";
$risu=$open_connection->connection->query($query);
while($arr=$risu->fetch()){
	$query_p="SELECT * FROM ".$prefix."categorie_new WHERE parent_id='".$arr['entity_id']."'";
	$risu_p=$open_connection->connection->query($query_p);
	$num_p=$risu_p->rowCount();
	$query_up="UPDATE ".$prefix."categorie_new SET child_num='".$num_p."' WHERE entity_id='".$arr['entity_id']."'";
	//echo $query_up."<br/>";
	$risu_up=$open_connection->connection->query($query_up);
}
?>
<script language="javascript">
	function verifica(){
		if (document.inserimento.name.value=="") {
			alert('Nome obbigatorio');
			return;
		}
		var btn = document.getElementById('btnSalvaCategoria');
		if (btn) {
			btn.disabled = true;
			btn.innerHTML = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Attendere...';
		}
		document.inserimento.submit();
	}

	function anteprimaImmagineCategoria(input) {
		var file = input.files && input.files[0];
		var preview = document.getElementById('catImagePreview');
		var img = document.getElementById('catImagePreviewImg');
		if (!preview || !img) return;

		if (!file || !file.type.match(/^image\//)) {
			preview.style.display = 'none';
			img.removeAttribute('src');
			return;
		}

		var reader = new FileReader();
		reader.onload = function(e) {
			img.src = e.target.result;
			preview.style.display = 'block';
		};
		reader.readAsDataURL(file);
	}
</script>
<div class="mws-panel grid_8">
	<div style="height:40px;font-size:1.2em;padding-top:10px"><b><?php echo strtoupper($pagina);?></b></div>
	<div class="row">
		<div style="float:left; width:25%;">
			<div style="margin-bottom:10px;">
				<a href="admin.php?cmd=categorie_ins<?php echo $rif;?>" class="btn">Aggiungi Sottocategoria</a>
			</div>
			<div style="background:#fff">
				<?php 
				$prov="admin";
				printCategoryTree2 (2, 2, $prov, $open_connection, "it", $ric_cat="", $path_cat);
				?>
			</div>
		</div>
		<div style="float:left; width:75%;">
			<div style="padding:10px">
				<?php if($path_cat!=""){
					$arr_c = admin_fetch_category_row($open_connection, $prefix, $path_cat, $id_rec ?? '');

					if (!$arr_c) {
						echo '<p style="color:#c00;">Categoria non trovata.</p>';
					} else {
					$n_entity_id = $arr_c['entity_id'];
					$n_name = $arr_c['name'];
					$n_name_en = $arr_c['name_en'];
					$n_name_de = $arr_c['name_de'];
					$n_name_fr = $arr_c['name_fr'];
					$n_name_es = $arr_c['name_es'];
					$n_description = $arr_c['description'];
					$n_description_en = $arr_c['description_en'];
					$n_description_de = $arr_c['description_de'];
					$n_description_fr = $arr_c['description_fr'];
					$n_description_es = $arr_c['description_es'];
					$n_image = $arr_c['image'];				
					
					if($stato=="inviato")
					{
						$arr_no['stato']=1;
						$arr_no['entity_id']=1;
						$arr_thumb['image']=400;
							/*
						$_POST['nome']=str_replace('"','\"',$_POST['nome']);
						$_POST['nome'] = str_replace("è", "&egrave;", $_POST['nome']);
						$_POST['nome'] = str_replace("é", "&eacute;", $_POST['nome']);
						$_POST['nome'] = str_replace("à", "&agrave;", $_POST['nome']);
						$_POST['nome'] = str_replace("ì", "&igrave;", $_POST['nome']);
						$_POST['nome'] = str_replace("ò", "&ograve;", $_POST['nome']);
						$_POST['nome'] = str_replace("ù", "&ugrave;", $_POST['nome']);
						
						$_POST['nome_eng']=str_replace('"','\"',$_POST['nome_eng']);
						$_POST['nome_eng'] = str_replace("è", "&egrave;", $_POST['nome_eng']);
						$_POST['nome_eng'] = str_replace("é", "&eacute;", $_POST['nome_eng']);
						$_POST['nome_eng'] = str_replace("à", "&agrave;", $_POST['nome_eng']);
						$_POST['nome_eng'] = str_replace("ì", "&igrave;", $_POST['nome_eng']);
						$_POST['nome_eng'] = str_replace("ò", "&ograve;", $_POST['nome_eng']);
						$_POST['nome_eng'] = str_replace("ù", "&ugrave;", $_POST['nome_eng']);	*/
						
						if(isset($_POST['name'])) $_POST['url_key'] = str_replace("_","-",to_htaccess_url($_POST['name'],""));
						if(isset($_POST['name_en'])) $_POST['url_key_en'] = str_replace("_","-",to_htaccess_url($_POST['name_en'],""));
						if(isset($_POST['name_de'])) $_POST['url_key_de'] = str_replace("_","-",to_htaccess_url($_POST['name_de'],""));
						if(isset($_POST['name_fr'])) $_POST['url_key_fr'] = str_replace("_","-",to_htaccess_url($_POST['name_fr'],""));
						if(isset($_POST['name_es'])) $_POST['url_key_es'] = str_replace("_","-",to_htaccess_url($_POST['name_es'],""));
						
						$oggetto_admin->modifica_campi ("$table", $n_entity_id, $arr_no, $arr_thumb, "img_up/$directory", "", "1920", "entity_id");
						\App\Models\Category::forgetImageMapCache();

						// --- Compressione + Cloudflare purge immagine categoria ---
						if (!empty($_FILES['image']['name'])) {
							// Recupera il nome file salvato dal DB (appena aggiornato)
							$stmt = $open_connection->connection->prepare(
								"SELECT image FROM {$table} WHERE entity_id = ? LIMIT 1"
							);
							$stmt->execute([$n_entity_id]);
							$saved_image = $stmt->fetchColumn();

							if ($saved_image) {
								$base_path = __DIR__ . '/../img_up/categorie/';

								// Comprimi PNG con GD (zero dipendenze esterne)
								foreach (['', 's_', 'xs_'] as $prefix_img) {
									$file = $base_path . $prefix_img . $saved_image;
									if (is_file($file) && function_exists('imagecreatefrompng')) {
										$img = @imagecreatefrompng($file);
										if ($img) {
											imagepng($img, $file, 8); // 0=no compress, 9=max
											imagedestroy($img);
										}
									}
								}

								// Purge Cloudflare per tutte e 3 le varianti
								$cf_zone = env('CLOUDFLARE_ZONE_ID', '');
								$cf_token = env('CLOUDFLARE_API_TOKEN', '');
								if ($cf_zone && $cf_token) {
									$base_url = 'https://www.moruzzi.it/admin/img_up/categorie/';
									$urls = [
										$base_url . $saved_image,
										$base_url . 's_' . $saved_image,
										$base_url . 'xs_' . $saved_image,
									];
									$ch = curl_init(
										"https://api.cloudflare.com/client/v4/zones/{$cf_zone}/purge_cache"
									);
									curl_setopt_array($ch, [
										CURLOPT_RETURNTRANSFER => true,
										CURLOPT_POST           => true,
										CURLOPT_HTTPHEADER     => [
											"Authorization: Bearer {$cf_token}",
											"Content-Type: application/json",
										],
										CURLOPT_POSTFIELDS => json_encode(['files' => $urls]),
										CURLOPT_TIMEOUT    => 5,
									]);
									curl_exec($ch);
									curl_close($ch);
								}
							}
						}
						// --- Fine blocco ---

						$percorso = ".html";
						$percorso_en = ".html";
						$percorso_de = ".html";
						$percorso_fr = ".html";
						$percorso_es = ".html";
						function costruisciPercorso($id_prod, $prefix, $open_connection){
							global $percorso;
							global $percorso_en;
							global $percorso_de;
							global $percorso_fr;
							global $percorso_es;
							$query = "SELECT * FROM ".$prefix."categorie_new WHERE entity_id='$id_prod'";
							//echo $query."<br/>";
							$risu = $open_connection->connection->query($query);
							$arr = $risu->fetch();
							$name_it = $arr['name'];
							$name_en = $name_it; if(isset($arr['name_en']) && $arr['name_en']!="") $name_en = $arr['name_en'];
							$name_de = $name_it; if(isset($arr['name_de']) && $arr['name_de']!="") $name_de = $arr['name_de'];
							$name_fr = $name_it; if(isset($arr['name_fr']) && $arr['name_fr']!="") $name_fr = $arr['name_fr'];
							$name_es = $name_it; if(isset($arr['name_es']) && $arr['name_es']!="") $name_es = $arr['name_es'];
							$percorso = str_replace("_","-",to_htaccess_url($name_it,""))."/".$percorso;
							$percorso_en = str_replace("_","-",to_htaccess_url($name_en,""))."/".$percorso_en;
							$percorso_de = str_replace("_","-",to_htaccess_url($name_de,""))."/".$percorso_de;
							$percorso_fr = str_replace("_","-",to_htaccess_url($name_fr,""))."/".$percorso_fr;
							$percorso_es = str_replace("_","-",to_htaccess_url($name_es,""))."/".$percorso_es;
							if($arr['parent_id']!="2"){
								//echo $arr['parent_id']." - ".$arr['name']."<br/>";
								costruisciPercorso($arr['parent_id'], $prefix, $open_connection);
							}
						}
						costruisciPercorso($n_entity_id, $prefix, $open_connection);
						$percorso = str_replace("/.html",".html",$percorso);
						$percorso_en = str_replace("/.html",".html",$percorso_en);
						$percorso_de = str_replace("/.html",".html",$percorso_de);
						$percorso_fr = str_replace("/.html",".html",$percorso_fr);
						$percorso_es = str_replace("/.html",".html",$percorso_es);
						
						$query_up = "UPDATE ".$prefix."categorie_new SET link_it='".$percorso."', link_en='".$percorso_en."', link_de='".$percorso_de."', link_fr='".$percorso_fr."', link_es='".$percorso_es."' WHERE entity_id='".$n_entity_id."'";
						$risu_up = $open_connection->connection->query($query_up);
						\Illuminate\Support\Facades\Cache::forget('categories_structure');
						//echo $query_up."<br/>";
					?>
						<script language="javascript">
							window.location = "admin.php?cmd=<?php echo $pagina;?>&path_cat=<?php echo str_replace(".html","",$percorso);?>" ;
						</script>
					<?php }else{?>
					
						<div class="mws-panel-header">
							<span style="color:#fff"><b>MODIFICA CATEGORIA</b></span>
						</div>
						<div class="mws-panel-body no-padding">
							<form name="inserimento" class="mws-form" action="admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>" method="post" enctype="multipart/form-data">
								<input type="hidden" name="stato" value="inviato">
								<div class="mws-form-inline">
									<?php 
									$oggetto_admin->campo_mod("ID" , "entity_id" , "$n_entity_id"  , "1", 'no', "$cmd", "$id_rec", "width:80px", "", "", "", "1", "1");
									$oggetto_admin->campo_mod("Nome *" , "name" , "$n_name"  , "1", 'no', "$cmd", "$id_rec", "", "", "", "", "1");
									//$oggetto_admin->campo_mod("Foto" , "image" , "$n_image"  , "4", 'no', "$cmd", "$id_rec", "", "", "img_up/$directory");
									?>
									<div class="mws-form-row">
										<label class="mws-form-label">Foto</label>
										<div class="mws-form-item">
											<?php if($n_image!="" && is_file("img_up/categorie/".$n_image)){?>
												<img id="catImageCurrent" style="margin-bottom:5px; width:200px;" src="img_up/categorie/<?php if(file_exists("img_up/categorie/s_".$n_image)) echo "s_";?><?php echo $n_image;?>" border="0" align="absmiddle">
												<a href="admin.php?cmd=categorie&id_rec=<?php echo $n_entity_id;?>&campocanc=image<?php echo $rif;?>" class="testo10" style="color:#333; text-decortion:none;"> <i class="fa fa-eraser" aria-hidden="true"></i></a>
												<br>
											<?php }?>
											<div id="catImagePreview" style="display:none; margin-bottom:8px;">
												<div style="font-size:12px; color:#666; margin-bottom:4px;">Anteprima nuova immagine</div>
												<img id="catImagePreviewImg" style="width:200px; max-height:200px; object-fit:contain; border:1px solid #ddd; border-radius:4px; background:#fff;" alt="Anteprima">
											</div>
											<input name="image" type="file" class="medium" size="60" id="image" accept="image/*" onchange="anteprimaImmagineCategoria(this)">
											<div style="font-size:12px; color:#666; line-height:1.5; margin-top:8px;">
												<div>L'immagine deve essere in formato <b>quadrato</b>, dimensione minima consigliata <b>400×400 px</b>.</div>
												<div>Preferire file <b>PNG</b> con <b>sfondo trasparente</b>.</div>
											</div>
										</div>
									</div>
									<div class="mws-form-row">
										<label class="mws-form-label">Descrizione</label>
										<div class="mws-form-item">
											<textarea class="ckeditor" name="description"><?php  echo $n_description; ?></textarea>
										</div>
									</div>
									
									
									<div class="mws-panel-header">
										<span style="color:#fff"><b>INGLESE</b></span>
									</div>
									<?php 
									$oggetto_admin->campo_mod("Nome" , "name_en" , "$n_name_en"  , "1", 'no', "$cmd", "$id_rec", "", "", "", "", "");
									?>
									<div class="mws-form-row">
									<label class="mws-form-label">Descrizione</label>
										<div class="mws-form-item">
											<textarea class="ckeditor" name="description_en"><?php  echo $n_description_en; ?></textarea>
										</div>
									</div>
									
									
									<div class="mws-panel-header">
										<span style="color:#fff"><b>TEDESCO</b></span>
									</div>
									<?php 
									$oggetto_admin->campo_mod("Nome" , "name_de" , "$n_name_de"  , "1", 'no', "$cmd", "$id_rec", "", "", "", "", "");
									?>
									<div class="mws-form-row">
									<label class="mws-form-label">Descrizione</label>
										<div class="mws-form-item">
											<textarea class="ckeditor" name="description_de"><?php  echo $n_description_de; ?></textarea>
										</div>
									</div>
									
									
									<div class="mws-panel-header">
										<span style="color:#fff"><b>FRANCESE</b></span>
									</div>
									<?php 
									$oggetto_admin->campo_mod("Nome" , "name_fr" , "$n_name_fr"  , "1", 'no', "$cmd", "$id_rec", "", "", "", "", "");
									?>
									<div class="mws-form-row">
									<label class="mws-form-label">Descrizione</label>
										<div class="mws-form-item">
											<textarea class="ckeditor" name="description_fr"><?php  echo $n_description_fr; ?></textarea>
										</div>
									</div>
									
									
									<div class="mws-panel-header">
										<span style="color:#fff"><b>SPAGNOLO</b></span>
									</div>
									<?php 
									$oggetto_admin->campo_mod("Nome" , "name_es" , "$n_name_es"  , "1", 'no', "$cmd", "$id_rec", "", "", "", "", "");
									?>
									<div class="mws-form-row">
									<label class="mws-form-label">Descrizione</label>
										<div class="mws-form-item">
											<textarea class="ckeditor" name="description_es"><?php  echo $n_description_es; ?></textarea>
										</div>
									</div>
									
									
									<br/><br/>
									<div style="margin-left:20px; padding-bottom:10px;">* <i>campi obbligatori</i></div>
								</div>
								<div  style="position:fixed; width:100%; bottom:0; z-index:10000" class="mws-button-row">
									<button type="button" id="btnSalvaCategoria" class="btn btn-danger" onclick="verifica()">Modifica</button>
								</div>
							</form>
						</div>
					<?php }?>
					<?php }?>
				<?php }?>
			</div>
		</div>
		<div style="clear:both; height:50px;"></div>
	</div>
</div>

<?php 
$table=$prec_db."categorie_new";
$pagina="categorie_ins";
$directory="categorie";

if(isset($_GET['path_cat'])) $path_cat=$_GET['path_cat']; else $path_cat="";

$criterio="";
$rif = "";
if($path_cat!="") {
	$rif="&path_cat=".$path_cat;
	$criterio = " AND link_it='".$path_cat.".html'";
}
?>
<script language="javascript">
	function verifica(){		
		if (document.inserimento.name.value=="") alert('Nome obbigatorio');
		else document.inserimento.submit();
	}
</script>
<div class="mws-panel grid_8">
	<div style="height:40px;font-size:1.2em;padding-top:10px"><b><?php echo strtoupper($pagina);?></b></div>
	<div class="row">
		<div style="float:left; width:25%;">
			<div style="margin-bottom:10px;">
				<a class="btn">Aggiungi Sottocategoria</a>
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
					$query_c="SELECT * FROM ".$prefix."categorie_new WHERE  1 $criterio";
					$risu_c = $open_connection->connection->query($query_c);
					$arr_c = $risu_c->fetch();
					
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
					
					if($campocanc!="")
					{
						$risu_img = $open_connection->connection->query("select $campocanc from $table where id='$id_rec'");
						$row_img = $risu_img ? $risu_img->fetch(PDO::FETCH_ASSOC) : false;
						$cancimg = $row_img[$campocanc] ?? null;
						
						if(is_file("img_up/prodotti/$cancimg")){unlink("img_up/prodotti/$cancimg");}
						if(is_file("img_up/prodotti/s_$cancimg")){unlink("img_up/prodotti/s_$cancimg");}
						$query_canc_img = "update $table set $campocanc=NULL where id='$id_rec'";
						$risu_canc_img = $open_connection->connection->query($query_canc_img);
						?>
						<script language="javascript">
							window.location='admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>';
						</script>
						<?php 
					}

					if($stato=="inviato")
					{
						$arr_no['stato']=1;
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
						
						$post_name_it = $_POST['name'];
						$post_name_en = $_POST['name'];
						if(isset($_POST['name_en'])) $post_name_en = $_POST['name_en'];
						$_POST['name_en'] = $post_name_en;
						$post_name_de = $_POST['name'];
						if(isset($_POST['name_de'])) $post_name_de = $_POST['name_de'];
						$_POST['name_de'] = $post_name_de;
						$post_name_fr = $_POST['name'];
						if(isset($_POST['name_fr'])) $post_name_fr = $_POST['name_fr'];
						$_POST['name_fr'] = $post_name_fr;
						$post_name_es = $_POST['name'];
						if(isset($_POST['name_es'])) $post_name_es = $_POST['name_es'];
						$_POST['name_es'] = $post_name_es;
						
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
						$_POST['link_it'] = str_replace("/.html","/".to_htaccess_url($post_name_it,"").".html",$percorso);
						$_POST['link_en'] = str_replace("/.html","/".to_htaccess_url($post_name_en,"").".html",$percorso_en);
						$_POST['link_de'] = str_replace("/.html","/".to_htaccess_url($post_name_de,"").".html",$percorso_de);
						$_POST['link_fr'] = str_replace("/.html","/".to_htaccess_url($post_name_fr,"").".html",$percorso_fr);
						$_POST['link_es'] = str_replace("/.html","/".to_htaccess_url($post_name_es,"").".html",$percorso_es);
						
						$_POST['parent_id'] = 2;
						$_POST['level'] = 2;
						$_POST['position'] = 1;
						
						if($path_cat!=""){
							$query_c="SELECT * FROM ".$prefix."categorie_new WHERE  1 $criterio";
							$risu_c = $open_connection->connection->query($query_c);
							$arr_c = $risu_c->fetch();
							
							$c_entity_id = $arr_c['entity_id'];
							$_POST['parent_id'] = $c_entity_id;
							$c_level = $arr_c['level'];
							$_POST['level'] = $c_level+1;	
							
							$query_p="SELECT max(position) FROM ".$prefix."categorie_new WHERE  parent_id='".$c_entity_id."'";
							$risu_p=$open_connection->connection->query($query_p);
							$num_p = (int) ($risu_p ? $risu_p->fetchColumn() : 0);
							$_POST['position'] = $num_p+1;
							
							$query_up = "UPDATE ".$prefix."categorie_new SET child_num='".($arr_c['child_num']+1)."' WHERE entity_id='".$c_entity_id."' ";
							$risu_up = $open_connection->connection->query($query_up);
						}
						
						$oggetto_admin->inserisci_campi ("$table" , $arr_no ,  $arr_thumb, "img_up/prodotti");
						\Illuminate\Support\Facades\Cache::forget('categories_structure');
					
					?>
						<script language="javascript">
							window.location = "admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>" ;
						</script>
					<?php }else{?>
					
						<div class="mws-panel-header">
							<span style="color:#fff"><b>NUOVA CATEGORIA</b></span>
						</div>
						<div class="mws-panel-body no-padding">
							<form name="inserimento" class="mws-form" action="admin.php?cmd=<?php echo $pagina;?><?php echo $rif;?>" method="post" enctype="multipart/form-data">
								<input type="hidden" name="stato" value="inviato">
								<div class="mws-form-inline">
									<?php 
									$oggetto_admin->campo_ins("Nome *" , "name"  , "1", 'no', "$cmd", "$id_rec");
									$oggetto_admin->campo_ins("Foto" , "image"  , "4", 'no', "$cmd", "$id_rec", "", "", "img_up/$pagina");
									?>
									<div class="mws-form-row">
										<label class="mws-form-label">&nbsp;</label>
										<div class="mws-form-item" style="font-size:12px; color:#666; line-height:1.5;">
											<div>L'immagine deve essere in formato <b>quadrato</b>, dimensione minima consigliata <b>400×400 px</b>.</div>
											<div>Preferire file <b>PNG</b> con <b>sfondo trasparente</b>.</div>
										</div>
									</div>
									<?php
									<div class="mws-form-row">
										<label class="mws-form-label">Descrizione</label>
										<div class="mws-form-item">
											<textarea class="ckeditor" name="description"></textarea>
										</div>
									</div>
									
									
									<div class="mws-panel-header">
										<span style="color:#fff"><b>INGLESE</b></span>
									</div>
									<?php 
									$oggetto_admin->campo_ins("Nome" , "name_en" , "1", 'no', "$cmd", "$id_rec");
									?>
									<div class="mws-form-row">
									<label class="mws-form-label">Descrizione</label>
										<div class="mws-form-item">
											<textarea class="ckeditor" name="description_en"></textarea>
										</div>
									</div>
									
									
									<div class="mws-panel-header">
										<span style="color:#fff"><b>TEDESCO</b></span>
									</div>
									<?php 
									$oggetto_admin->campo_ins("Nome" , "name_de"  , "1", 'no', "$cmd", "$id_rec");
									?>
									<div class="mws-form-row">
									<label class="mws-form-label">Descrizione</label>
										<div class="mws-form-item">
											<textarea class="ckeditor" name="description_de"></textarea>
										</div>
									</div>
									
									
									<div class="mws-panel-header">
										<span style="color:#fff"><b>FRANCESE</b></span>
									</div>
									<?php 
									$oggetto_admin->campo_ins("Nome" , "name_fr"   , "1", 'no', "$cmd", "$id_rec");
									?>
									<div class="mws-form-row">
									<label class="mws-form-label">Descrizione</label>
										<div class="mws-form-item">
											<textarea class="ckeditor" name="description_fr"></textarea>
										</div>
									</div>
									
									
									<div class="mws-panel-header">
										<span style="color:#fff"><b>SPAGNOLO</b></span>
									</div>
									<?php 
									$oggetto_admin->campo_ins("Nome" , "name_es" , "1", 'no', "$cmd", "$id_rec");
									?>
									<div class="mws-form-row">
									<label class="mws-form-label">Descrizione</label>
										<div class="mws-form-item">
											<textarea class="ckeditor" name="description_es"></textarea>
										</div>
									</div>
									
									
									<br/><br/>
									<div style="margin-left:20px; padding-bottom:10px;">* <i>campi obbligatori</i></div>
								</div>
								<div  style="position:fixed; width:100%; bottom:0; z-index:10000" class="mws-button-row">
									<input type="button" value="INSERISCI" class="btn btn-danger" onclick="verifica()">
								</div>
							</form>
						</div>
					<?php }?>
				<?php }?>
			</div>
		</div>
		<div style="clear:both; height:50px;"></div>
	</div>
</div>
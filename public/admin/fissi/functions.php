<?php 
function to_htaccess_url($str_in, $sito, $subdir="",$len="",$words="")
{
	$caratteri_permessi = array("_","(",")");
	
	/*togli spazi iniziali, \r e \t */
	$str_out = trim($str_in);	
	/*tutto minuscolo */
	$str_out = strtolower($str_out);
	

	/* se ? valido il quarto parametro indica che voglio la stringa troncata dopo $words parole */
	if($words)
	{
		$warr = explode(" ",$str_out);
		$str_out= "";
		for($w=0;$w<min($words,count($warr));$w++)
		{
				if($w) $str_out .= "_";
				$str_out .= $warr[$w];
		}
	}
	
	/* visualizza spazi come trattini */
	$str_out = str_replace(" ", "_", $str_out);

	/* apostrofo ? separatore (d'oltremare ? d_oltremare ? d-oltremare) */
	$str_out = str_replace("'", "_", $str_out);
	
	/*altro*/
	$str_out = str_replace("?", "e", $str_out);
	$str_out = str_replace("?", "e", $str_out);
	$str_out = str_replace("?", "a", $str_out);
	$str_out = str_replace("?", "i", $str_out);
	$str_out = str_replace("?", "o", $str_out);
	$str_out = str_replace("?", "u", $str_out);	
	
	/* 
	togli i caratteri speciali che nelle url non vengono accettati o sono comunque inestetici;
	accetta solo numeri, lettere,  e il trattino (-) ; l'underscore DEVE essere convertito in trattino e usato solo come separatore per le regole
	*/
  $str = "";
	for($s=0;$s<strlen($str_out);$s++)
	{
		if(ctype_alnum($str_out[$s]) || in_array($str_out[$s],$caratteri_permessi))
			$str .= $str_out[$s];
	}
	$str_out = $str;		
	
	/* se ? valido il terzo parametro indica che voglio la stringa troncata ad un massimo arbitrario */
	if($len)
	{
		$str_out = substr($str_out, 0, $len);
	}
	else 
	/*
	altrimenti	la stringa in totale nell'url non deve comunque superare 255 caratteri, 
	quindi va troncata ad un valore di default (in genere pu? essere un txt fino a 250 caratteri) 
	*/
	{
		$caratteri_occupati   = 7; /* http:// iniziale*/		
		$caratteri_occupati += strlen($sito); /* lunghezza dell'url del sito: es www.emporiodellapesca.it */
		if($subdir) /* se la pagina va sotto una finta directory (es diving/fotogallery/yyyy_yyy_yyyyy.html), e io la conosco, togline la lunghezza */
		{
			$caratteri_occupati += strlen($subdir);
		}
		else /* altrimenti togli comunque un valore di precauzione */
		{
			$caratteri_occupati += 40;
		}		
		$caratteri_occupati += 7; /*considero un'eventuale paginazione, sempre del tipo '-pag-XX' o '_pag_XX' */
		$caratteri_occupati += 5; /*.html finale */	

		$caratteri_url = $caratteri_disponibili = 255;
		/*
		ne prendo i 2/3 perch? nel rewrite mi serve la variabile get html_title=$str_out
		e quindi anche se nascosto ha meno spazio del finto .html ricavato
		*/
		$caratteri_disponibli = ceil($caratteri_url-$caratteri_occupati)*2/3;
		$lunghezza_originale = strlen($str_out);
		if($lunghezza_originale >= $caratteri_disponibili)
			$str_out = substr($str_out, 0, $caratteri_disponibili-1);
	}		
			
	return $str_out;	
}


	function taglia($str, $len=90)
	{
		$txt = $str;
		$txt = str_replace("\r","", $txt);
		$txt = str_replace("\n","", $txt);
		$txt = str_replace(".",". ", $txt);
		$txt = str_replace(",",", ", $txt);
		$txt = str_replace("!","! ", $txt);
		$txt = str_replace("?","? ", $txt);
		$txt = str_replace("  "," ", $txt);
		$txt = ucfirst(strtolower(puntini($txt,$len)));
		return $txt;
	}
	
	function puntini($str, $len=200, $up=0)
	{
		$tit = trim($str);
		$tit = substr($tit,0,$len); 
		if(strlen($str)>$len)
			$tit .= "...";
		if($up) $tit=ucfirst($tit);	
			
		return $tit;	
	}
	

	/* 
	per i link presi da database, che non ? detto abbiano sempre l' http:// per uscire dal sito.
	Non raddoppia http:// per i link gi? di secondo livello
	*/
	function out_url($url)
	{
		$http = "http://";
		$www = "www.";
		$ftp = "ftp.";
			
		$link =$url;
			
		if(!strstr($link, $http) && !strstr($link, $www) && !strstr($link, $ftp))
			$link = $www.$link;
			
		$link = str_replace(" ","",$link);	
			
		if(!strstr($link, $http))
			return ($http.$link);
		else
			return $link;	
	}

	
	/*
	da  aaaa-mm-gg a gg-mm-aaaa
	cambia il separatore se indicato (default: trattino '-'
	*/
	function date_to_data($date,$sep='-')
	{
		$data = '0000-00-00';
		$sep_n = $sep;

		if(empty($sep_n))
			$sep_n ='-';
					
		if(!empty($date))
		{
			$dates = explode("-",$date);
			if(count($dates)<3)
				return $data;
			else
				$data = $dates[2].$sep_n.$dates[1].$sep_n.$dates[0];
		}
		return $data;
	}
	
	function numera($str)
	{
		$num = trim(str_replace(",",".",$str));
		return (float)($num);
	}
	
	function sqlInj($stringa)
	{
		$stringa=str_replace("'","\'",$stringa);
		return $stringa;
	}
	
	function shuffle_assoc($list) {
	  if (!is_array($list)) return $list;

	  $keys = array_keys($list);
	  shuffle($keys);
	  $random = array();
	  foreach ($keys as $key)
		$random[$key] = $list[$key];

	  return $random;
	} 
	
	function array_remove_value() {
		$args = func_get_args();
		$arr = $args[0];
		$values = array_slice($args,1);

		foreach($arr as $k=>$v) {
			if(in_array($v, $values))
				unset($arr[$k]);
		}

		return $arr;
	}
	
	function array_remove_key() {
		$args = func_get_args();
		$arr = $args[0];
		$keys = array_slice($args,1);
		
		foreach($arr as $k=>$v) {
			if(in_array($k, $keys))
				unset($arr[$k]);
		}

		return $arr;
	}
	
	function genera_password($tabella, $campo)
	{
		$pass="";
		if(!$campo) $campo2 = "password";
		else $campo2 = $campo;
		$caratteri = '0123456789abcdefghijklmnopqrstuvwxyz';
		for($i=0;$i<8;$i++)
		{
			$pass .= $caratteri[rand(0, strlen($caratteri))];
		}	
		
		$query = "select * from :tabella where :campo2=':pass'";
		$risu = $open_connection->connection->prepare($query);
		$risu->execute(array(':tabella'=>$tabella,':campo2'=>$campo2,':pass'=>$pass));
		$num = 0;
		if($risu)
			$num = $risu->rowCount();
		if($num)
			$pass=genera_password($tabella, $campo2);
			
		return $pass;	
	}

	function isFileUrl($url){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // don't want it rendered to browser
		curl_exec($ch);

		if(curl_errno($ch)){
			$isFile = false;
		}
		else {
			$isFile = true;
		}
		curl_close($ch);
		return $isFile;
	}
	
	function trova_ordine($tabella, $id_rife="", $rife=""){
		
		$open_connection = new dbnew();

		if(!$id_rife || !$rife) $wer = "";
		else  $wer = "where $id_rife='$rife'";
		
		$query = "select MAX(ordine) as maximum from :tabella";
		$risu = $open_connection->connection->prepare($query);
		$risu->execute(array(':tabella'=>$tabella));
		
		if(!$risu)
		{
			/*echo $query;exit();*/
		}
		list($ord)= $risu->fetch(PDO::FETCH_NUM);;
		
		if($ord)$ord +=1;
		else $ord = 1;
		
		return $ord;
	}
	
	function inserisci_post ($tabella , $arr_no="no"){
		$open_connection = new dbnew();
		global $_POST;
		
		$campi['nome'] = "";
		$campi['valore']="";
		$num_post= count($_POST);
		reset($_POST);
		/* questo ciclo serve a recuperare i dati da post*/
		for($x=0;$x<$num_post;$x++){
			$arr_dipost = each($_POST);
			if(isset($arr_dipost[1])) $value = $arr_dipost[1]; else $value ="";
			if(isset($arr_dipost[0])) $key = $arr_dipost[0]; else $key ="";
						
			if( !isset($arr_no[$key]) && $value!=""){
				$campi['nome'] .= " $key ,";
				$campi['valore'] .= " \"$value\" ,";
			}
		}				
		
		$campi_n =substr( $campi['nome'], 0, -1);
		$campi_v =substr(  $campi['valore'], 0, -1);
				
		$query = "insert into $tabella ($campi_n) values ($campi_v) ";
		//echo $query;
		$risu    = $open_connection->connection->query($query);
		if(!$risu)
		{
			echo $query;exit();
		}else return $lastId = $open_connection->connection->lastInsertId();
	}
	
	function random_char(){
		$str = "abcdefghiyklmnopqrstuvwz1234567890";
		$lun = strlen($str);
		$pos = mt_rand(0, $lun - 1);
		return($str[$pos]);
	}
	
	function scrivi_file($nomef,$file, $direi="")
	{
		if($direi)	$dire = $direi;	else $dire = "resarea/files";
		
		/*togli gli apostrofi che impediscono di caricare e rileggere i file imamgine.
		Questo codice comporta che i nomi con aggiunta della lettera (per non sovrascrivere) 
		avranno un doppio punto alla fine (es: ninfee.jv.jpg invece di ninfeev.jpg)*/
		$nome = str_replace("\\","",$nomef);
		$nome = str_replace("'","",$nome);
		/*altra pulizia, non si sa mai */
		$nome = str_replace(" ","_",$nome);
		$nome = str_replace("�", "e", $nome);
		$nome = str_replace("�", "e", $nome);
		$nome = str_replace("�", "a", $nome);
		$nome = str_replace("�", "i", $nome);
		$nome = str_replace("�", "o", $nome);
		$nome = str_replace("�", "u", $nome);	
		$nome = str_replace("`", "", $nome);
		$nome = str_replace("�", "", $nome);
		$nome = str_replace("#", "", $nome);	
		$nome = str_replace("~", "", $nome);

		if(is_file("$dire/$nome")){
			while((is_file("$dire/$nome"))==true){
				$exts = explode(".", $nome);
				$finale = $exts[count($exts)-1];
				$titolo = str_replace(".$finale", "", $nome);
				$titolo .= random_char();
				$nome = $titolo.".$finale";
			}
			if(!copy($file, "$dire/$nome"))
			{
				/*echo "<br>fallito copy in scrivi_img";*/
				if(!move_uploaded_file($file,"$dire/$nome"))
				{
					/*echo "<br>fallito move_uploaded in scrivi_img per $file";
					exit();*/
				}
			}
		}
		else
		{
			if(!copy($file, "$dire/$nome"))
			{
				/*echo "<br>fallito copy in scrivi_img";*/
				if(!move_uploaded_file($file,"$dire/$nome"))
				{
					/*echo "<br>fallito move_uploaded in scrivi_img per $file";
					exit();*/
				}
			}
		}
		return ($nome);
	}	
	
	function img_webp($img, $webp="", $class="", $style="", $alt="", $param="")
	{
		if($webp==""){
			$temp = explode(".",$img);
			$webp = $temp[0].".webp";
		}
		
		$string="";
		$string.='<picture>';
			if(file_exists("$webp")) $string.='<source srcset="'.$webp.'" type="image/webp">';
			$string.='<source srcset="'.$img.'" type="image/jpeg"> ';
			$string.='<img class="'.$class.'" src="'.$img.'" style="'.$style.'" alt="'.$alt.'" '.$param.'>';
		$string.='</picture>';
		
		return $string;	
	}	
	
	function img_webp_bg($img, $webp="")
	{
		if($webp==""){
			$temp = explode(".",$img);
			//$webp = $temp[0].".webp";
		}
		
		$string="background-image: url('".$img."');"; 
		if(file_exists("$webp")) $string.="background-image: -webkit-image-set(url('".$webp."') 1x);";
		
		return $string;	
	}
	
	function insertPicture($picture_file, $picture_dir="", $picture_alt="", $picture_class="", $picture_style="", $thumb="yes", $lazy="yes"){
		if(substr($picture_dir, -1)!="/") $picture_dir=$picture_dir."/";
		if(file_exists($picture_dir.$picture_file)){
			if(file_exists($picture_dir."s_".$picture_file) && $thumb=="yes") $picture_file ="s_".$picture_file;
			if($lazy=="yes") $loading='loading="lazy"'; else $loading='';
			
			list($width, $height, $type, $attr) = getimagesize("images/box1.jpg");
			$new_h = (100*$height)/$width;
			
			$string = "";
			$string .= "<picture>";
				if(file_exists($picture_dir.$picture_file.".webp")){
					$string .= '<source srcset="'.$picture_dir.$picture_file.'.webp" type="image/webp"> ';					
				}
				$string .= '<source srcset="'.$picture_dir.$picture_file.'" type="image/jpeg"> ';
				$string .= '<img '.$loading.' src="'.$picture_dir.$picture_file.'" alt="'.$picture_alt.'" class="'.$picture_class.'" style="'.$picture_style.'" width="'.$width.'" height="'.$height.'" >';
			$string .= "</picture>";
			
			return $string;
		}		
	}
	
	function dataFromDb($table, $id_item, $nome_var_id, $lingua="ita"){
		$open_connection = new dbnew();
		
		$query = "SELECT * FROM $table WHERE $nome_var_id='$id_item'";
		$risu = $open_connection->connection->query($query);
		return $arr=$risu->fetch();
	}
	
	function getCurrentUrl() {
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$host = $_SERVER['HTTP_HOST'];
		$requestUri = $_SERVER['REQUEST_URI'];
		
		return $protocol . $host . $requestUri;
	}
	
	function printCategoryTree($parent_id, $open_connection, $lingua="it", $ric_cat, $path_cat="", $url_path = '', $title_path = ''){
		$sql = "SELECT * FROM mor_categorie_new WHERE parent_id = $parent_id ORDER BY position";
		//echo $sql."<br/>";
		$stmt = $open_connection->connection->query($sql);

		while ($row = $stmt->fetch()) {
			// Aggiorna il percorso dell'URL e del titolo
			$name = $row['name'];
			if($lingua!="it"){
				if(isset($row['name_'.$lingua])) $name = $row['name_'.$lingua];
			}
			$current_url_path = $url_path . '/' . $row['url_key'];
			$current_title_path = $name . ' - ' . $title_path;
			
			$urlcatTree = getCurrentUrl();
			$admin = 0;
			if(str_contains($urlcatTree, "admin/")) $admin=1;
			
			$link = $row['link_it'];
			if($lingua=="en" && isset($row['link_en']) && $row['link_en']!="") $link = $row['link_en'];
			if($lingua=="de" && isset($row['link_de']) && $row['link_de']!="") $link = $row['link_de'];
			if($lingua=="fr" && isset($row['link_fr']) && $row['link_fr']!="") $link = $row['link_fr'];
			if($lingua=="es" && isset($row['link_es']) && $row['link_es']!="") $link = $row['link_es'];
			
			$simple_link = str_replace(".html","",$link);
			$array_elementi = explode('/', $simple_link);
			array_pop($array_elementi);
			$simple_link_senza_ultimo = implode('/', $array_elementi);
			
			$array_elementi = explode('/', $path_cat);
			array_pop($array_elementi);
			$path_cat_senza_ultimo = implode('/', $array_elementi);
			
			$margin = 10*($row['level']-2);
			//echo $path_cat."/"." - ".$simple_link,"<br/><br/>";
			?>
			<div style="
					width:(100% - <?php echo $margin;?>px); 
					margin-left:<?php echo $margin;?>px; 
					background:#fff; 
					margin-top:0; 
					<?php if($row['level']>2){?>
						border:solid 1px #E4E6EF;  
						font-size:0.9; 
						<?php if($simple_link_senza_ultimo==$path_cat_senza_ultimo){?>
							display:block;
						<?php }else{?>
							display:none;
						<?php }?>
					<?php }?>
					" 
					class="nomeCatList catBlock_<?php echo $row['parent_id'];?>" 
					<?php /*onclick="$('.catBlock_<?php echo $row['entity_id'];?>').slideToggle()"*/?>
					onclick="$('.catBlock_<?php echo $row['entity_id'];?>').slideToggle();"
			>
				<div style="padding:5px 10px;border-bottom:solid 2px #E4E6EF;">
					<div style="padding:5px 0">
						<?php 
						// Costruisci il link URL e il titolo
						$full_url = $lingua."/".$row['link_'.$lingua];
						if($admin==1) $full_url = "admin.php?cmd=categorie&path_cat=$simple_link";
						$full_title = rtrim($current_title_path, ' - ') . ' | Moruzzi Numismatica';
						?>
						<?php if($row['child_num']==0){?>
							<a href="<?php echo $full_url;?>" title="<?php echo $full_title;?>" class="nomeCatList" onclick="event.stopPropagation();">
						<?php }?>
							<div  class="pt-sans"
								style="float:left; width:calc(100% - 25px); font-size:1.2em; cursor:pointer;
								<?php if($path_cat == $simple_link){?>font-weight:800 !important;<?php }?>
								">
								<?php if(strpos($path_cat_senza_ultimo, $simple_link) !== false){
									echo "XX";
								}?>
								<?php echo $name;?>
								<?php 
								echo "<br/>?".$path_cat."<br/>";
								echo "@".$simple_link."<br/>";
								echo "#".$path_cat_senza_ultimo."<br/>";?>
								
								<?php if($row['child_num']>0){?> <i class="fa-solid fa-caret-down"></i><?php }?>
							</div>
						<?php if($row['child_num']==0){?>
							</a>
						<?php }?>
						<a href="<?php echo $full_url;?>" title="<?php echo $full_title;?>" onclick="event.stopPropagation();">
							<div style="float:right; width:22px; height:22px; border-radius:11px; background:#F9F9F9; text-align:center; color:#000">
								<i class="fa fa-angle-right"></i>
							</div>
						</a>
						<div style="clear:both"></div>
					</div>
				</div>            
			</div>
			<?php /*if(strpos($path_cat_senza_ultimo, $simple_link) !== false){?>
				<script>	
					$('.catBlock_<?php echo $row['entity_id'];?>').slideToggle();
				</script>
			<?php }*/?>
			<?php 
			printCategoryTree($row['entity_id'], $open_connection, $lingua, $ric_cat, $path_cat, $current_url_path, $current_title_path);
		}
	}
	
	function printCategoryTree2($parent_id, $level="2", $prov="", $open_connection, $lingua="it", $ric_cat, $path_cat="", $url_path = '', $title_path = ''){
		$sql = "SELECT * FROM mor_categorie_new WHERE parent_id = $parent_id ORDER BY position";
		//echo $sql."<br/>";
		$stmt = $open_connection->connection->query($sql);

		while ($row = $stmt->fetch()) {
			// Aggiorna il percorso dell'URL e del titolo
			$name = $row['name'];
			if($lingua!="it"){
				if(isset($row['name_'.$lingua])) $name = $row['name_'.$lingua];
			}
			$current_url_path = $url_path . '/' . $row['url_key'];
			$current_title_path = $name . ' - ' . $title_path;
			
			$urlcatTree = getCurrentUrl();
			$admin = 0;
			if(str_contains($urlcatTree, "admin/")) $admin=1;
			
			$link = $row['link_it'];
			if($lingua!="it"){
				if(isset($row['link_en']) && $row['link_en']!="") $link = $row['link_en'];
				if($lingua=="de" && isset($row['link_de']) && $row['link_de']!="") $link = $row['link_de'];
				if($lingua=="fr" && isset($row['link_fr']) && $row['link_fr']!="") $link = $row['link_fr'];
				if($lingua=="es" && isset($row['link_es']) && $row['link_es']!="") $link = $row['link_es'];
			}
			
			$simple_link = str_replace(".html","",$link);
			$array_elementi = explode('/', $simple_link);
			array_pop($array_elementi);
			$simple_link_senza_ultimo = implode('/', $array_elementi);
			
			$array_elementi = explode('/', $path_cat);
			array_pop($array_elementi);
			$path_cat_senza_ultimo = implode('/', $array_elementi);
			
			$margin = 10*($row['level']-2);
			
			// Costruisci il link URL e il titolo
			$full_url = $lingua."/".$row['link_'.$lingua];
			if($admin==1) $full_url = "admin.php?cmd=categorie&path_cat=$simple_link";
			$full_title = rtrim($current_title_path, ' - ') . ' | Moruzzi Numismatica';
			$display="";
			if($path_cat == $simple_link){
				if(str_contains($path_cat,$simple_link_senza_ultimo."/")){
					$display="block";
				}else{
					$display="none";
				}
			}else{
				if(str_contains($path_cat,$simple_link."/")){
					$display="block";
				}else{
					$display="none";
				}
			}			
			?>
			<div id="catBlock_<?php echo $row['entity_id'];?>" 
				style="
				width:(100% - <?php echo $margin;?>px); 
				margin-left:<?php echo $margin;?>px; 
				background:#fff; 
				margin-top:0; 
				cursor:pointer; 
				padding:5px 10px;border-bottom:solid 2px #E4E6EF;
				padding-left:<?php echo ($row['level']*5);?>px;
				<?php if($row['level']>2){?>
					border:solid 1px #E4E6EF;  
					font-size:0.9; 
				<?php }?>				
				" >
				
				<?php if($prov!="frame"){?>
				<a href="<?php echo $full_url;?>" title="<?php echo $full_title;?>" onclick="event.stopPropagation();">	
				<?php }?>				
					<div  class="pt-sans" style="float:left; width:calc(100% - 25px); font-size:1.2em; color:#333333 !important; cursor:pointer; <?php if(str_replace(".html","",$path_cat) == $simple_link){?>font-weight:800 !important;<?php }?>">
						<?php if($prov=="frame"){?><i id="iconCheck_<?php echo $row['entity_id'];?>" class="fa-regular fa-square" onclick='parent_addCatProd_<?php echo $row['entity_id'];?>();'></i>&nbsp;&nbsp;<?php }?><?php echo $name;?>
					</div>				
				<?php if($prov!="frame"){?>
				</a>
				<?php }?>
				<?php if($row['child_num']>0){?> 
					<a onclick="$('#catBlockList_<?php echo $prov;?>_<?php echo $row['entity_id'];?>').slideToggle(); if(document.getElementById('iconOpen_<?php echo $prov;?>_<?php echo $row['entity_id'];?>').innerHTML.includes('plus')) document.getElementById('iconOpen_<?php echo $prov;?>_<?php echo $row['entity_id'];?>').innerHTML='<i class=\'fa-regular fa-square-minus\'></i>'; else document.getElementById('iconOpen_<?php echo $prov;?>_<?php echo $row['entity_id'];?>').innerHTML='<i class=\'fa-regular fa-square-plus\'></i>';">
						<div style="float:right; text-align:center; color:#333; font-size:1.5em" id="iconOpen_<?php echo $prov;?>_<?php echo $row['entity_id'];?>">
							<?php if($display=="block"){?>
								<i class="fa-regular fa-square-minus"></i>
							<?php }else{?>
								<i class="fa-regular fa-square-plus"></i>
							<?php }?>
						</div>
					</a>
				<?php }?>
				<div style="clear:both"></div>
				<script>
					function parent_addCatProd_<?php echo $row['entity_id'];?>(){
						parent.addCatProd("<?php echo $row['entity_id'];?>","<?php echo $name;?>");
					}
				</script>
			</div>
			<div id="catBlockList_<?php echo $prov;?>_<?php echo $row['entity_id'];?>" style="display:<?php echo $display;?>;">
				<?php printCategoryTree2($row['entity_id'], $row['level'], $prov, $open_connection, $lingua, $ric_cat, $path_cat, $current_url_path, $current_title_path);?>
			</div>
			<?php 			
		}
	}
	
	function printCategoryTreeSelect($parent_id, $open_connection, $cat_ric=""){
		$sql = "SELECT * FROM mor_categorie_new WHERE parent_id = $parent_id ORDER BY position";
		//echo $sql."<br/>";
		$stmt = $open_connection->connection->query($sql);

		while ($row = $stmt->fetch()) {
			// Aggiorna il percorso dell'URL e del titolo
			$name = $row['name'];
			$margin = "";
			if($row['level']>2){
				for($i=1; $i<=($row['level']-2); $i++){
					$margin .= "&nbsp;&nbsp;&nbsp;";
				}
				$margin .= "-";
			}					
			?>
			<option value="<?php echo $row['entity_id'];?>" <?php if($cat_ric==$row['entity_id']){?>selected="selected"<?php }?>><?php echo $margin;?><?php echo $row['name'];?></option>
			<?php 	
			printCategoryTreeSelect($row['entity_id'], $open_connection);		
		}
	}
	
	function isAvailabe($id_ver){
		// Quantit� nel magazzino
		$query_disp = "select qty, entity_id from ".$prefix."prodotti where entity_id='$id_ver'";
		$risu_disp = $open_connection->connection->query($query_disp);
		list($quantita, $ver_cat)	= $risu_disp->fetch(PDO::FETCH_NUM);;
				
		$disponibili = $quantita;
		
		// Tolgo i pezzi ordinati ma non evasi
		$query_ordinati = "select sum(po.quantita) from ".$prefix."ordini_prod as po, ".$prefix."ordini as o where po.id_prod='$id_ver' and po.id_ord=o.id and (o.status='pagato' OR o.status='nuovo' OR o.status='pending' OR o.status='processing' OR o.status='holded' OR o.status='payment_review')";
		$risu_ordinati = $open_connection->connection->query($query_ordinati);
		if($risu_ordinati->rowCount() > 0)
		{
			list($ordinati) = $risu_ordinati->fetch(PDO::FETCH_NUM);;
			$disponibili = max(0, $disponibili-$ordinati);
		}
		
		// Tolgo i pezzi nei carrelli
		$giacenze = $open_connection->connection->query("select sum(quantita) from ".$prefix."prodotti_carr where id_prodotto='$id_ver' ");
		if($giacenze->rowCount()>0)
		{
			list($tot_giac) = $giacenze->fetch(PDO::FETCH_NUM);;
			$disponibili = max($disponibili-$tot_giac,0);  
		}
		
		return $disponibili;
	}

	/**
	 * Carica una riga categoria per path_cat (link_it) o entity_id, con varianti slug apostrofo.
	 *
	 * @return array<string, mixed>|false
	 */
	function admin_fetch_category_row($open_connection, $prefix, $path_cat = '', $entity_id = '')
	{
		$table = $prefix . 'categorie_new';
		$pdo = $open_connection->connection;

		if ($entity_id !== '' && $entity_id !== null) {
			$stmt = $pdo->prepare("SELECT * FROM {$table} WHERE entity_id = ? LIMIT 1");
			$stmt->execute([(int) $entity_id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($row) {
				return $row;
			}
		}

		if ($path_cat === '') {
			return false;
		}

		$fullLink = str_ends_with($path_cat, '.html') ? $path_cat : $path_cat . '.html';
		$candidates = function_exists('category_link_alternates')
			? category_link_alternates($fullLink)
			: [$fullLink];

		foreach ($candidates as $candidate) {
			$stmt = $pdo->prepare("SELECT * FROM {$table} WHERE link_it = ? LIMIT 1");
			$stmt->execute([$candidate]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($row) {
				return $row;
			}
		}

		return false;
	}

	/**
	 * path_cat canonico (senza .html) per redirect admin categorie.
	 */
	function admin_category_path_from_entity($open_connection, $prefix, $entity_id): string
	{
		$table = $prefix . 'categorie_new';
		$stmt = $open_connection->connection->prepare("SELECT link_it FROM {$table} WHERE entity_id = ? LIMIT 1");
		$stmt->execute([(int) $entity_id]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$row || empty($row['link_it'])) {
			return '';
		}

		return str_replace('.html', '', $row['link_it']);
	}
?>	
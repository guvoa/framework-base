<?php
function installModule($entity){
	$path_system_to_install = '../';
	$path_bo = $path_system_to_install . 'backoffice/';
	$path_fo = '../';
	$result_install = true;
	
	//bo_search_fields
	$bo_search_fields = split(',',$entity['bo_search_fields']);
	if(count($bo_search_fields) > 0){
		$result = false;
		foreach($bo_search_fields as $term){
			$term = trim ($term);
			if(!empty($term)){
				$val .= "'".$term."',";
				$result = $result || true;
			}else{
				$result = $result || false;
			}
		}
		if($result){
			$entity['bo_search_fields'] = substr($val,0,-1);
		}else{
			$entity['bo_search_fields'] = '';
		}
	}else{
		$entity['bo_search_fields'] = '';
	}
	
	
	//create controller file
	echo '<br /><strong>Creando </strong>archivo <strong>controlador </strong>de backoffice:';
	echo '<br />Nombre:' . $entity['bo_archivo_controller'] . '....';
	
	$fileFrom = 'system/bo_fileController.php';
	$fileTo = $path_bo . $entity['bo_archivo_controller'];
	echo 'Path:' . $fileTo . '....';
	
	$contentStr = replaceGenFields($fileFrom, $entity, true);
	if($contentStr){
		$result = createFile($fileTo, $contentStr);
	}else{ $result = false; }
	
	echo '<strong>' . ($result ? 'OK' : 'ERROR' ) .'</strong>';
	$result_install = $result_install && $result; 
	
	//create directory bo
	echo '<br /><strong>Creando directorio </strong> de backoffice:';
	echo '<br />Nombre:' . $entity['bo_directorio'] . '....';
	$fileToDirBo = $path_bo . $entity['bo_directorio'] . '/';
	echo 'Path:' . $fileToDirBo . '....';
	
	$result = crearDirectorio($fileToDirBo);
	echo '<strong>' . ($result ? 'OK' : 'ERROR' ) .'</strong>';
	$result_install = $result_install && $result; 
	
	if(!$result){
		echo '<br ><strong>Proceso no puede continuar, verifique creacion de directorio</strong>';
	}else{
		//create list file BO
		echo '<br /><strong>Creando </strong>archivo <strong>list </strong>de backoffice:';
		$file = 'list.php';
		echo '<br />Nombre:' . $file . '....';
		
		$fileFrom = 'system/bo_directory_list.php';
		$fileTo = $fileToDirBo . $file;
		echo 'Path:' . $fileTo . '....';
		$contentStr = replaceGenFields($fileFrom, $entity, true);
		if($contentStr){
			$result = createFile($fileTo, $contentStr);
		}else{ $result = false; }
		echo '<strong>' . ($result ? 'OK' : 'ERROR' ) .'</strong>';
		$result_install = $result_install && $result; 
		
		//create edit file BO
		echo '<br /><strong>Creando </strong>archivo <strong>edit </strong>de backoffice:';
		$file = 'edit.php';
		echo '<br />Nombre:' . $file . '....';
		
		$fileFrom = 'system/bo_directory_edit.php';
		$fileTo = $fileToDirBo . $file;
		echo 'Path:' . $fileTo . '....';
		$contentStr = replaceGenFields($fileFrom, $entity, true);
		if($contentStr){
			//reemplazo de {EDIT_ITEMS}
			 $table_fields = getTableFields($entity['tabla_nombre']);
			 $codePHP = '';
			 foreach($table_fields as $fieldArr){
				 $field = $fieldArr['Field'];
				 $textVal = ucwords(str_replace('_',' ',$field) );
				 
				 switch($fieldArr['Type']){
					 case 'date': $type = 'date';break;
					 case 'text': $type = 'textarea';break;
					 default:
						 $type = 'text';
					break;	
				 }
				 
				 if($field == $entity['tabla_id']){
					$type = 'hidden';
				 }
				 $codePHP .= "\n\$items[] = array('text'=>'".$textVal."', 'type'=>'".$type."', 'name'=>'entity[".$field."]', 'value'=> \$data['".$field."'], id =>'".$field."' );";
			 }
			 $contentStr = str_replace('{EDIT_ITEMS}',$codePHP,$contentStr);
			 
			
			$result = createFile($fileTo, $contentStr);
			$result_install = $result_install && $result; 
		}else{ $result = false; }
		echo '<strong>' . ($result ? 'OK' : 'ERROR' ) .'</strong>';
		$result_install = $result_install && $result; 
	}
	
	
	//create FO controller file
	echo '<br /><strong>Creando </strong>archivo <strong>controlador </strong>de frontoffice:';
	echo '<br />Nombre:' . $entity['bo_archivo_controller'] . '....';
	
	$fileFrom = 'system/system_Class.php';
	$fileTo = $path_fo . $entity['bo_archivo_controller'];
	echo 'Path:' . $fileTo . '....';
	
	$contentStr = replaceGenFields($fileFrom, $entity, true);
	if($contentStr){
		$result = createFile($fileTo, $contentStr);
	}else{ $result = false; }
	
	echo '<strong>' . ($result ? 'OK' : 'ERROR' ) .'</strong>';
	$result_install = $result_install && $result; 
	
	
	//create viewMain file
	echo '<br /><strong>Creando </strong>archivo <strong> Main </strong>de frontoffice:';
	echo '<br />Nombre:' .$entity['clase_nombre'].'Main.php...';
	
	$fileFrom = 'system/system_view_ClaseMain.php';
	$fileTo = $path_fo . 'view/'.$entity['clase_nombre'].'Main.php';
	echo 'Path:' . $fileTo . '....';
	
	$contentStr = replaceGenFields($fileFrom, $entity, true);
	if($contentStr){
		$result = createFile($fileTo, $contentStr);
	}else{ $result = false; }
	
	echo '<strong>' . ($result ? 'OK' : 'ERROR' ) .'</strong>';
	$result_install = $result_install && $result; 
	
	//create viewView file
	echo '<br /><strong>Creando </strong>archivo <strong> View </strong>de frontoffice:';
	echo '<br />Nombre:' .$entity['clase_nombre'].'View.php...';
	
	$fileFrom = 'system/system_view_ClaseView.php';
	$fileTo = $path_fo . 'view/'.$entity['clase_nombre'].'View.php';
	echo 'Path:' . $fileTo . '....';
	
	$contentStr = replaceGenFields($fileFrom, $entity, true);
	if($contentStr){
		$result = createFile($fileTo, $contentStr);
	}else{ $result = false; }
	
	echo '<strong>' . ($result ? 'OK' : 'ERROR' ) .'</strong>';
	$result_install = $result_install && $result; 
	
	
	
	//create FO controller raiz
	echo '<br /><strong>Creando </strong>archivo <strong>controlador raiz </strong>de frontoffice:';
	echo '<br />Nombre:' . $entity['bo_archivo_controller'] . '....';
	
	$fileFrom = 'system/_Clase.php';
	$fileTo = $path_fo . '../' .$entity['bo_archivo_controller'];
	echo 'Path:' . $fileTo . '....';
	
	$contentStr = replaceGenFields($fileFrom, $entity, true);
	if($contentStr){
		$result = createFile($fileTo, $contentStr);
	}else{ $result = false; }
	
	echo '<strong>' . ($result ? 'OK' : 'ERROR' ) .'</strong>';
	$result_install = $result_install && $result; 
	
	
	
	//modify header BO
	echo '<br /><strong>Modificando </strong>archivo <strong>header </strong>de backoffice:';
	echo '<br />Nombre: header.php' ;
	
	$fileTo = $fileFrom = '../backoffice/header.php';
	echo 'Path:' . $fileTo . '....';
	
	$contentStr = replaceGenFields($fileFrom, $entity, true);
	if($contentStr){
		$result = createFile($fileTo, $contentStr);
	}else{ $result = false; }
	
	echo '<strong>' . ($result ? 'OK' : 'ERROR' ) .'</strong>';
	$result_install = $result_install && $result; 
	
	
	echo '<br /><br /><strong>' . ($result_install ? 'El módulo se ha instalado exitosamente!!!' : 'Se detecto un error en el proceso de la instalacion') .'</strong>';

}

function replaceGenFields($string, $entity, $isFile = false){
	$header_bo = $string == '../backoffice/header.php';
	if($isFile){
		$string = file_get_contents ($string);
		if(!$string){return false;}
	}
	if($header_bo){
		$subject = $string;

		$pattern = '<td><a href="'.$entity['bo_archivo_controller'].'" class="blanco none">'.$entity['clase_nombre'].'</a></td>';
		if(!strpos($string, $pattern)){
			$string = str_replace('<!--MENU-->','<td><a href="'.$entity['bo_archivo_controller'].'" class="blanco none">'.$entity['clase_nombre'].'</a></td>
		<!--MENU-->',$string);
		}
	}
	//pendiente campo {tabla_campos_img}
	$fields = array('clase_nombre','tabla_nombre','tabla_id','bo_archivo_controller','bo_directorio','bo_search_fields');
	foreach($fields as $field){
		if(empty($entity[$field]) && $field != 'bo_search_fields'){return false;}
		$val = $entity[$field];
		if($field == 'bo_directorio'){$val = $val . '/';}
		$string = str_replace('{'.$field.'}',$val,$string);
	}
	
	
	return $string;
}

function createFile($filePathName, $contentStr){
	$result = false;

	if($fp = fopen($filePathName,'w+')){
		if(fwrite($fp,$contentStr)){
			$result = true;
		}
	}
	
	return $result;
}

function getTableFields($table){
	$result = mysqli_query("SHOW COLUMNS FROM " . $table);
	if (!$result) {
		return false;
	}
	$fields = array();
	if (mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_assoc($result)) {
			$fields[] = $row;
		}
		
	}
	return count($fields) > 0 ? $fields : false;
}

function crearDirectorio($dir){
	if(is_dir($dir) || mkdir($dir)){
		return true;
	}
	return false;
}

?>
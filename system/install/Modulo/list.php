<?php

$_total_data = empty($_total_data) ?  0 : $_total_data;
$config = empty($config) ? array() : $config;
$data = empty($data) ? array() : $data;

$buttons =array();
$buttons[] = array(
	'alt'=>'Editar', 'title'=>'Editar', 'img' => 'img/edit.gif',
	'href' => '?cmd=edit&id=[id]',
	'hrefReplaceArr' => 
		array( 
			array('search' => '[id]', 'field_replace' => 'web_modulo_id' )
		)
);

$buttons[] = array(
	'alt'=>'Eliminar', 'title'=>'Eliminar', 'img' => 'img/delete.gif',
	'href' => '?cmd=delete&id=[id]',
	'hrefReplaceArr' => 
		array( 
			array('search' => '[id]', 'field_replace' => 'web_modulo_id' )
		)
);

$buttons[] = array(
	'alt'=>'Instalar Modulo', 'title'=>'Instalar Modulo', 'img' => 'img/install.jpg',
	'href' => '?cmd=edit&id=[id]&install=1',
	'hrefReplaceArr' => 
		array( 
			array('search' => '[id]', 'field_replace' => 'web_modulo_id' )
		)
);


$config['actionButtons'] = $buttons;
$config['renameColumns'] = array('nombre_modulo' => 'Nombre', 'clase_nombre' =>'Clase');
$config['hiddenColumns'] = array('web_modulo_id','tabla_id','tabla_campos_img','bo_archivo_controller','bo_directorio','bo_search_fields','tabla_nombre' ); 

$header_title = 'Modulos';

if( $_REQUEST['msj'] == 1 ){
	$header_msj_class = 'ok msj';
	$header_msj = 'web_modulo Guardada';
}
if( $_REQUEST['msj'] == 2 ){
	$header_msj_class = 'ok msj';
	$header_msj = 'web_modulo Eliminada';
}

require('header.php');
echo '<a href="?cmd=add" class="azulOb none"><img src="img/add.gif" border="0"; /> Agregar Modulo</a>';
display( $_total_data, $data, $config);
require('footer.php');
?>
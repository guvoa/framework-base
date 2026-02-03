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
			array('search' => '[id]', 'field_replace' => '{tabla_id}' )
		)
);

$buttons[] = array(
	'alt'=>'Eliminar', 'title'=>'Eliminar', 'img' => 'img/delete.gif',
	'href' => '?cmd=delete&id=[id]',
	'hrefReplaceArr' => 
		array( 
			array('search' => '[id]', 'field_replace' => '{tabla_id}' )
		)
);



$config['actionButtons'] = $buttons;
$config['renameColumns'] = array('{tabla_id}' =>'{clase_nombre} Id');
$config['hiddenColumns'] = array('{tabla_id}' ); 

$header_title = '{clase_nombre}s';

if( $_REQUEST['msj'] == 1 ){
	$header_msj_class = 'ok msj';
	$header_msj = 'Registro {clase_nombre} Guardado';
}
if( $_REQUEST['msj'] == 2 ){
	$header_msj_class = 'ok msj';
	$header_msj = 'Registro {clase_nombre} Eliminado';
}

require('header.php');
echo '<a href="?cmd=add" class="azulOb none"><img src="img/add.gif" border="0"; /> Agregar {clase_nombre}</a>';
display( $_total_data, $data, $config);
require('footer.php');
?>
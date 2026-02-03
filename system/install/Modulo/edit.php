<?php

$data = empty($data) ? array() : $data;

if($_REQUEST['install'] == 1){
	//inicializamos instalacion
	include_once('system/lib/install.php');
$header_title = 'Instalacion de Módulo';
require('header.php');	
installModule($data);
require('footer.php');	
}else{
$form = array();
$form['title'] = 'Informacion del Modulo';
$items = array();


$items[] = array('text' => 'Nombre', 'type' => 'text', 'name' => 'entity[nombre_modulo]', 'value' => $data['nombre_modulo'] );
$items[] = array('text' => 'Descripcion', 'type' => 'text', 'name' => 'entity[descripcion]', 'value' => $data['descripcion'] );

$items[] = array('type' => 'fieldset', 'value' => 'Clase');
$items[] = array('text' => 'Nombre Clase', 'type' => 'text', 'name' => 'entity[clase_nombre]', 'value' => $data['clase_nombre'] );
$items[] = array('text' => 'Nombre Tabla', 'type' => 'text', 'name' => 'entity[tabla_nombre]', 'value' => $data['tabla_nombre'] );
$items[] = array('text' => 'Tabla Id', 'type' => 'text', 'name' => 'entity[tabla_id]', 'value' => $data['tabla_id'] );
$items[] = array('text' => 'Tabla Campos Img', 'type' => 'text', 'name' => 'entity[tabla_campos_img]', 'value' => $data['tabla_campos_img'] );

$items[] = array('type' => 'fieldset', 'value' => 'Backoffice');
$items[] = array('text' => 'Archivo Controller', 'type' => 'text', 'name' => 'entity[bo_archivo_controller]', 'value' => $data['bo_archivo_controller'] );
$items[] = array('text' => 'Directorio', 'type' => 'text', 'name' => 'entity[bo_directorio]', 'value' => $data['bo_directorio'] );
$items[] = array('text' => 'Search Fields', 'type' => 'text', 'name' => 'entity[bo_search_fields]', 'value' => $data['bo_search_fields'] );

$items[] = array('type' => 'hidden', 'id' => 'web_modulo_id','name' => 'entity[web_modulo_id]', 'value' => $data['web_modulo_id'] );	

$form['items'] = $items;

$header_title = $cmd == 'add' ? 'Agregar web_modulo' :  'Editar web_modulo';
require('header.php');

echo '<form action="" method="post" enctype="multipart/form-data" >';
displayForm( $form);


	echo '<br /><input type="submit" name="" value="Guardar" />';
	echo '<input type="hidden" name="cmd" value="save" />';
	echo '<input type="button" name="" value="Cancelar" onClick="document.location.href=\'Modulo.php\'" />';

echo '</form>';
require('footer.php');
}

?>
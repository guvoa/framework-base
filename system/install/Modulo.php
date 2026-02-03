<?php
//<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
require_once('../lib.php');
require_once("pasaporte.php");
require_once('../lib/controller.php');

$args = array();

//Archivo Controlador de Clase. 
//Obtiene los parametros de cotrolador
//tambien procesa resultados de ejecucion recibidos de mensajes del controlador
$args['controller_file'] = 'Modulo.php';

$args['view_dir'] = 'Modulo/';
$args['view_file'] = '';

$args['table_name_list'] = 'web_modulo';
$args['table_name'] = 'web_modulo';
$args['table_id'] = 'web_modulo_id';

$args['model_search_extra_conditions'] =array();
$args['model_select_fields'] = array('*');
$args['model_search_fields'] = array('nombre_modulo','descripcion');


$cmd =  $_REQUEST['cmd'];
switch( $cmd ){
	case 'save':
		$entity =  $_REQUEST['entity'];
		
		if( !empty($_FILES['imagen']['name']) ){
			$img_name = date('YmdHis') . '_' . basename($_FILES['imagen']['name']);
			$result = uploadFile( 'imagen', getImgDir('web_modulo','imagen') . $img_name ,array('jpeg', 'jpg','gif', 'png') );
			if($result > 0){
				$entity['imagen'] = $img_name;
			}
		}
		//$entity['fecha'] = date('Y-m-d');
		$args['entity'] = $entity;
	break;
	default:break;
}

Controller_Execute($cmd, $args);


?>
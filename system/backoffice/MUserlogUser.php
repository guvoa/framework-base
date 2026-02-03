<?php
//<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
require_once('../lib.php');
require_once("pasaporte.php");
require_once('../lib/controller.php');

$args = array();

//Archivo Controlador de Clase. 
//Obtiene los parametros de cotrolador
//tambien procesa resultados de ejecucion recibidos de mensajes del controlador
$args['controller_file'] = 'MUserlogUser.php';

$args['view_dir'] = 'MUserlogUser/';
$args['view_file'] = '';

$args['table_name_list'] = 'm_userlog_user';
$args['table_name'] = 'm_userlog_user';
$args['table_id'] = 'm_userlog_user_id';

$args['model_search_extra_conditions'] =array();
$args['model_select_fields'] = array('*');
$args['model_search_fields'] = array();


$cmd =  $_REQUEST['cmd'];
switch( $cmd ){
	case 'save':
		$entity =  $_REQUEST['entity'];
		$entity['user'] =  $entity['email'];
		$args['entity'] = $entity;
	break;
	default:break;
}

Controller_Execute($cmd, $args);


?>
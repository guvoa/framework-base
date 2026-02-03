<?php
//<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
require_once('../lib.php');
require_once("pasaporte.php");
require_once('../lib/controller.php');

$args = array();

//Archivo Controlador de Clase. 
//Obtiene los parametros de cotrolador
//tambien procesa resultados de ejecucion recibidos de mensajes del controlador
$args['controller_file'] = 'Order.php';

$args['view_dir'] = 'Order/';
$args['view_file'] = '';

$args['table_name_list'] = 'm_cart_order';
$args['table_name'] = 'm_cart_order';
$args['table_id'] = 'm_cart_order_id';

$args['model_search_extra_conditions'] =array();
$args['model_select_fields'] = array('*');
$args['model_search_fields'] = array();


$cmd =  $_REQUEST['cmd'];
switch( $cmd ){
	case 'save':
		MCart_SetOrderStatus($_REQUEST['entity']['m_cart_order_id'],$_REQUEST['entity']['estatus']);
		$_REQUEST['msj'] = 1;
		$cmd =  $_REQUEST['cmd'] = '';
	break;
	default:break;
}

Controller_Execute($cmd, $args);


?>
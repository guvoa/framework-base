<?php
require('lib.php');


$args['controller_file'] = 'Contenido.php';
$args['view_dir'] = 'system/view/';

$args['table_name_list'] = 'contenido';
$args['table_name'] = 'contenido';
$args['table_id'] = 'contenido_id';

$args['model_select_fields']=array('*');
$args['model_search_fields'] = array('contenido_xml');
$_REQUEST['o'] ='';

$extraConditions =array();

$cmd =  $_REQUEST['cmd'];
switch($cmd){
	default:
		$_REQUEST['k'] = 1;
		$args['model_search_extra_conditions'] = $extraConditions;
		$args['view_file'] = 'ContenidoMain.php';	
	break;
	case 'view':
		$args['view_file'] = 'ContenidoView.php';	
	break;
}

Controller_Execute($cmd, $args);

?>
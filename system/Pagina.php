<?php

require_once('system/lib.php');


$args['controller_file'] = 'Pagina.php';
$args['view_dir'] = 'system/view/';

$args['table_name_list'] = 'pagina';
$args['table_name'] = 'pagina';
$args['table_id'] = 'pagina_id';

$args['model_select_fields']=array('*');
$args['model_search_fields'] = array('titulo');
$_REQUEST['o'] ='';

$extraConditions =array();

$cmd =  $_REQUEST['cmd'];
switch($cmd){
	default:
		$_REQUEST['k'] = 25;
		
		if(!empty($_REQUEST['tipo_clase'])){
			$extraConditions[] = 'tipo_clase = "'.$_REQUEST['tipo_clase'].'"';
		}

		$args['model_search_extra_conditions'] = $extraConditions;
		$args['view_file'] = 'PaginaMain.php';	
	break;
	case 'view':
		$args['view_file'] = 'PaginaView.php';	
		//$args['view_file'] = 'estructura/Inicio.php';	
	break;
}

Controller_Execute($cmd, $args);

?>
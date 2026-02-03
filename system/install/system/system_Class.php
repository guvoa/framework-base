<?php
require('lib.php');


$args['controller_file'] = '{bo_archivo_controller}';
$args['view_dir'] = 'system/view/';

$args['table_name_list'] = '{tabla_nombre}';
$args['table_name'] = '{tabla_nombre}';
$args['table_id'] = '{tabla_id}';

$args['model_select_fields']=array('*');
$args['model_search_fields'] = array({bo_search_fields});
$_REQUEST['o'] ='';

$extraConditions =array();

$cmd =  $_REQUEST['cmd'];
switch($cmd){
	default:
		$_REQUEST['k'] = 1;
		$args['model_search_extra_conditions'] = $extraConditions;
		$args['view_file'] = '{clase_nombre}Main.php';	
	break;
	case 'view':
		$args['view_file'] = '{clase_nombre}View.php';	
	break;
}

Controller_Execute($cmd, $args);

?>
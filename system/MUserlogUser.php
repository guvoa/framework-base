<?php
require('lib.php');


$args['controller_file'] = 'MUserlogUser.php';
$args['view_dir'] = 'system/view/';

$args['table_name_list'] = 'm_userlog_user';
$args['table_name'] = 'm_userlog_user';
$args['table_id'] = 'm_userlog_user_id';

$args['model_select_fields']=array('*');
$args['model_search_fields'] = array();
$_REQUEST['o'] ='';

$extraConditions =array();

$cmd =  $_REQUEST['cmd'];
switch($cmd){
	default:
		$_REQUEST['k'] = 1;
		$args['model_search_extra_conditions'] = $extraConditions;
		$args['view_file'] = 'MUserlogUserMain.php';	
	break;
	case 'view':
		$args['view_file'] = 'MUserlogUserView.php';	
	break;
}

Controller_Execute($cmd, $args);

?>
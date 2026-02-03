<?php
require('lib.php');


$args['controller_file'] = 'MCartProducto.php';
$args['view_dir'] = 'system/view/';

$args['table_name_list'] = 'm_cart_producto';
$args['table_name'] = 'm_cart_producto';
$args['table_id'] = 'm_cart_producto_id';

$args['model_select_fields']=array('*');
$args['model_search_fields'] = array('titulo','descripcion');
$_REQUEST['o'] ='';

$extraConditions =array();

$cmd =  $_REQUEST['cmd'];
switch($cmd){
	default:
		$_REQUEST['k'] = 8;
		if(is_numeric($_REQUEST['categoriaId']) && !empty($_REQUEST['categoriaId']) ){
			$extraConditions[] = 'categoria_id = ' . $_REQUEST['categoriaId'] . ' 
			OR categoria_id IN (SELECT m_cart_categoria_id FROM m_cart_categoria WHERE 
				m_cart_categoria_parent_id ="' . $_REQUEST['categoriaId'] . '") 
				
			OR categoria_id IN (
				SELECT m_cart_categoria_id FROM m_cart_categoria WHERE m_cart_categoria_parent_id
				IN (SELECT m_cart_categoria_id FROM m_cart_categoria WHERE 
				m_cart_categoria_parent_id ="' . $_REQUEST['categoriaId'] . '") 
			)
			';
		}
		$args['model_search_extra_conditions'] = $extraConditions;
		$args['view_file'] = 'MCartProductoMain.php';	
	break;
	case 'view':
		$args['view_file'] = 'MCartProductoView.php';	
	break;
}

Controller_Execute($cmd, $args);

?>
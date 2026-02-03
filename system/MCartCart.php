<?php
require_once('system/lib.php');


$args['controller_file'] = 'MCartCart.php';
$args['view_dir'] = 'system/view/';

$args['table_name'] = $args['table_name_list'] = 'm_cart_producto';

$args['table_id'] = 'm_cart_producto_id';

$args['model_select_fields']= array('*');
$args['model_search_fields'] = array('titulo','descripcion');
$_REQUEST['o'] ='';

$extraConditions =array();

$cmd =  $_REQUEST['cmd'];

switch($cmd){
	case 'add':
		$args['table_name'] = '';
		$cmd = $_REQUEST['cmd'] = '';
		MCart_addItem($_REQUEST['productId'],$_REQUEST['itemNumber']);
	break;
	case 'Actualizar_Carrito':
		$eliminar = $_REQUEST['eliminar'];
		foreach($eliminar as $elimId){
			MCart_RemoveItem($elimId);
		}
		foreach(MCart_getItems() as $itemId => $item){
			MCart_UpdateQtyItem($itemId,$_REQUEST['qty_' . $itemId]);
		}
	break;
	default:
	break;
}
$args['view_file'] = 'MCartCart.php';	
Controller_Execute($cmd, $args);

?>
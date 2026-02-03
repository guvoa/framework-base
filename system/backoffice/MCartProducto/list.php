<?php

$_total_data = empty($_total_data) ?  0 : $_total_data;
$config = empty($config) ? array() : $config;
$data = empty($data) ? array() : $data;

$npage = !is_numeric($_REQUEST['p']) ? 1 : $_REQUEST['p'];

$buttons =array();
$buttons[] = array(
	'alt'=>'Editar', 'title'=>'Editar', 'img' => 'img/edit.gif',
	'href' => '?cmd=edit&id=[id]&p=' . $npage,
	'hrefReplaceArr' => 
		array( 
			array('search' => '[id]', 'field_replace' => 'm_cart_producto_id' )
		)
);

$buttons[] = array(
	'alt'=>'Eliminar', 'title'=>'Eliminar', 'img' => 'img/delete.gif',
	'href' => '?cmd=delete&id=[id]&p=' . $npage,
	'hrefReplaceArr' => 
		array( 
			array('search' => '[id]', 'field_replace' => 'm_cart_producto_id' )
		)
);



$config['actionButtons'] = $buttons;
$config['renameColumns'] = array('m_cart_producto_id' =>'MCartProducto Id');
$config['hiddenColumns'] = array('m_cart_producto_id','imagen','descripcion','categoria_id','peso_grs' ); 

$header_title = 'Productos';

if( $_REQUEST['msj'] == 1 ){
	$header_msj_class = 'ok msj';
	$header_msj = 'Registro Producto Guardado';
}
if( $_REQUEST['msj'] == 2 ){
	$header_msj_class = 'ok msj';
	$header_msj = 'Registro Producto Eliminado';
}

require('header.php');
echo '<a href="?cmd=add" class="azulOb none"><img src="img/add.gif" border="0"; /> Agregar Producto</a>';
display( $_total_data, $data, $config, -1);
require('footer.php');
?>
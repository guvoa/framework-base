<?php

$data = empty($data) ? array() : $data;

$form = array();
$form['title'] = 'Informacion de Order';
$items = array();


$items[] = array('type'=>'hidden', 'name'=>'entity[m_cart_order_id]', 'value'=> $data['m_cart_order_id'], id =>'m_cart_order_id' );


$items[] = array('text'=>'Estatus', 'type'=>'select', 
'options'=>array('Pendiente'=>'Pendiente','Completada'=>'Completada'),
'name'=>'entity[estatus]', 'value'=> $data['estatus'], id =>'estatus' );
$form['items'] = $items;

$header_title = $cmd == 'add' ? 'Agregar Orden' :  'Editar Orden';
require('header.php');

echo '<form action="" method="post" enctype="multipart/form-data" >';
displayForm( $form);

	echo '<br /><input type="submit" name="" value="Guardar" />';
	echo '<input type="hidden" name="cmd" value="save" />';
	echo '<input type="button" name="" value="Cancelar" onClick="document.location.href=\'Order.php\'" />';

echo '</form>';
echo '<fieldset>';
echo '<legend>Detalles de Órden</legend>';
$_REQUEST['order'] = $data;
include('test.php');
echo '</fieldset>';

require('footer.php');
?>
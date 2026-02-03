<?php

$data = empty($data) ? array() : $data;

$form = array();
$form['title'] = 'Informacion de Categoria';
$items = array();


$items[] = array('type'=>'hidden', 'name'=>'entity[m_cart_categoria_id]', 'value'=> $data['m_cart_categoria_id'], id =>'m_cart_categoria_id' );
$items[] = array('text'=>'Nombre', 'type'=>'text', 'name'=>'entity[nombre]', 'value'=> $data['nombre'], id =>'nombre' );
$items[] = array('text'=>'Posicion', 'type'=>'text', 'name'=>'entity[posicion]', 'value'=> $data['posicion'], id =>'posicion' );

$categorias = array();
$extraConditions = array();

$extraConditions[] = array('condition'=>'m_cart_categoria_parent_id = 0 OR m_cart_categoria_parent_id IS NULL', 'condition_values'=>array() );
$results = DB_INTERFACE_Select('m_cart_categoria',array('*'), $extraConditions, 'nombre ASC', 1, -1);

$categorias[] = 'Seleccionada como Categoria Principal';
foreach($results as $result){
	$categorias[$result['m_cart_categoria_id']] = $result['nombre'];
	
	$extraConditions = array();
	$extraConditions[] = array('condition'=>'m_cart_categoria_parent_id = %s', 'condition_values'=>array($result['m_cart_categoria_id']) );
	$results2 = DB_INTERFACE_Select('m_cart_categoria',array('*'), $extraConditions,
			array( 'order'=>'%s ASC', 'order_values'=>array('posicion') ), 
		1, -1);
	foreach($results2 as $result2){
		$categorias[$result2['m_cart_categoria_id']] = '&nbsp;&nbsp;&nbsp;'.$result2['nombre'];
	}
}

$items[] = array('text'=>'Categoria Principal', 'type'=>'select','options'=>$categorias, 'name'=>'entity[m_cart_categoria_parent_id]', 'value'=> $data['m_cart_categoria_parent_id'], id =>'m_cart_categoria_parent_id' );

$form['items'] = $items;

$header_title = $cmd == 'add' ? 'Agregar Categoria' :  'Editar Categoria';
require('header.php');

echo '<form action="" method="post" enctype="multipart/form-data" >';
displayForm( $form);

	echo '<br /><input type="submit" name="" value="Guardar" />';
	echo '<input type="hidden" name="cmd" value="save" />';
	echo '<input type="button" name="" value="Cancelar" onClick="document.location.href=\'MCartCategoria.php\'" />';

echo '</form>';
require('footer.php');
?>
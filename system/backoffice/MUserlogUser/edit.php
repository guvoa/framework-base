<?php

$data = empty($data) ? array() : $data;

$form = array();
$form['title'] = 'Informacion de Cliente';
$items = array();


$items[] = array('type'=>'hidden', 'name'=>'entity[m_userlog_user_id]', 'value'=> $data['m_userlog_user_id'], id =>'m_userlog_user_id' );
$items[] = array('type'=>'hidden', 'name'=>'entity[user]', 'value'=> $data['user'], id =>'user' );
$items[] = array('text'=>'Email', 'type'=>'text', 'name'=>'entity[email]', 'value'=> $data['email'], id =>'email' );
$items[] = array('text'=>'Password', 'type'=>'text', 'name'=>'entity[password]', 'value'=> $data['password'], id =>'password' );
$items[] = array('text'=>'Nombre', 'type'=>'text', 'name'=>'entity[nombre]', 'value'=> $data['nombre'], id =>'nombre' );
$items[] = array('text'=>'Apellidos', 'type'=>'text', 'name'=>'entity[apellidos]', 'value'=> $data['apellidos'], id =>'apellidos' );

$items[] = array('text'=>'Pais', 'type'=>'text', 'name'=>'entity[pais]', 'value'=> $data['pais'], id =>'pais' );
$items[] = array('text'=>'Estado', 'type'=>'text', 'name'=>'entity[estado]', 'value'=> $data['estado'], id =>'estado' );
$items[] = array('text'=>'Ciudad', 'type'=>'text', 'name'=>'entity[ciudad]', 'value'=> $data['ciudad'], id =>'ciudad' );
$items[] = array('text'=>'Telefono', 'type'=>'text', 'name'=>'entity[telefono]', 'value'=> $data['telefono'], id =>'telefono' );
$items[] = array('text'=>'Direccion', 'type'=>'text', 'name'=>'entity[direccion]', 'value'=> $data['direccion'], id =>'direccion' );
$items[] = array('text'=>'Colonia', 'type'=>'text', 'name'=>'entity[colonia]', 'value'=> $data['colonia'], id =>'colonia' );
$items[] = array('text'=>'Codigo Postal', 'type'=>'text', 'name'=>'entity[codigo_postal]', 'value'=> $data['codigo_postal'], id =>'codigo_postal' );

$form['items'] = $items;

$header_title = $cmd == 'add' ? 'Agregar Cliente' :  'Editar Cliente';
require('header.php');

echo '<form action="" method="post" enctype="multipart/form-data" >';
displayForm( $form);

	echo '<br /><input type="submit" name="" value="Guardar" />';
	echo '<input type="hidden" name="cmd" value="save" />';
	echo '<input type="button" name="" value="Cancelar" onClick="document.location.href=\'MUserlogUser.php\'" />';

echo '</form>';
require('footer.php');
?>
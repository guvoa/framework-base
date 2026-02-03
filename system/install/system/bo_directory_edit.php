<?php

$data = empty($data) ? array() : $data;

$form = array();
$form['title'] = 'Informacion de {clase_nombre}';
$items = array();

{EDIT_ITEMS}

$form['items'] = $items;

$header_title = $cmd == 'add' ? 'Agregar {clase_nombre}' :  'Editar {clase_nombre}';
require('header.php');

echo '<form action="" method="post" enctype="multipart/form-data" >';
displayForm( $form);

	echo '<br /><input type="submit" name="" value="Guardar" />';
	echo '<input type="hidden" name="cmd" value="save" />';
	echo '<input type="button" name="" value="Cancelar" onClick="document.location.href=\'{bo_archivo_controller}\'" />';

echo '</form>';
require('footer.php');
?>
<?php
$npage = !is_numeric($_REQUEST['p']) ? 1 : $_REQUEST['p'];

$data = empty($data) ? array() : $data;

$form = array();
$form['title'] = 'Informacion de Producto';
$items = array();

$items[] = array('type' => 'hidden', 'name' => 'entity[id]', 'value' => $data['id'], 'id' => 'id');
$items[] = array('text' => 'Producto', 'type' => 'text', 'name' => 'entity[producto]', 'value' => $data['producto'], 'id' => 'producto');
$items[] = array('text' => 'Codigo', 'type' => 'text', 'name' => 'entity[codigo]', 'value' => $data['codigo'], 'id' => 'codigo');

$categorias = array();
$extraConditions = array();

$extraConditions[] = array('condition' => 'parent_id = 0 OR parent_id IS NULL', 'condition_values' => array());
$results = DB_INTERFACE_Select('categoria', array('*'), $extraConditions, 'nombre ASC', 1, -1);

$htmlSelect = '<select name="entity[categoria_id]"><option>Sin categoria</option>';

foreach ($results as $result) {
	$extraConditions = array();
	$extraConditions[] = array('condition' => 'parent_id = %s', 'condition_values' => array($result['id']));
	$results2 = DB_INTERFACE_Select('categoria', array('*'), $extraConditions, 'nombre ASC', 1, -1);

	$htmlSelect .= '<optgroup label="' . $result['nombre'] . '">';

	$acOpGp = false;
	foreach ($results2 as $result2) {
		$extraConditions = array();
		$extraConditions[] = array('condition' => 'parent_id = %s', 'condition_values' => array($result2['id']));
		$results3 = DB_INTERFACE_Select(
			'categoria',
			array('*'),
			$extraConditions,
			array('order' => '%s ASC', 'order_values' => array('posicion')),
			1,
			-1
		);

		if (empty($results3)) {
			$selected = $data['id'] == $result2['id'] ? 'selected="selected"' : '';
			$result2['nombre'] = $acOpGp ? ('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $result2['nombre']) : $result2['nombre'];
			$htmlSelect .= '<option value="' . $result2['id'] . '" ' . $selected . '>' . $result2['nombre'] . '</option>';
		} else {
			$htmlSelect .= '<optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $result2['nombre'] . '">';
			foreach ($results3 as $result3) {
				$selected = $data['id'] == $result3['id'] ? 'selected="selected"' : '';
				$htmlSelect .= '<option value="' . $result3['id'] . '" ' . $selected . '>&nbsp;&nbsp;&nbsp;' . $result3['nombre'] . '</option>';
			}
			$htmlSelect .= '</optgroup>';
			$acOpGp = true;
		}
	}
	$htmlSelect .= '</optgroup>';

}

$htmlSelect .= '</select>';
$items[] = array('text' => 'Categoria', 'type' => 'text_plain', 'value' => $htmlSelect);
$form['items'] = $items;
$header_title = $cmd == 'add' ? 'Agregar Producto' : 'Editar Producto';

require 'header.php';

echo '<form action="" method="post" enctype="multipart/form-data" >';
displayForm($form);

echo '<br /><input type="submit" name="" value="Guardar" />';
echo '<input type="hidden" name="cmd" value="save" />';
echo '<input type="hidden" name="p" value="' . $npage . '" />';
echo '<input type="button" name="" value="Cancelar" onClick="document.location.href=\'MCartProducto.php?p=' . $npage . '\'" />';

echo '</form>';
require 'footer.php';
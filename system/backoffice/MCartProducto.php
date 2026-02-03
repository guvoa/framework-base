<?php
//<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
require_once '../lib.php';
require_once 'pasaporte.php';
require_once '../lib/controller.php';

$args = array();

//Archivo Controlador de Clase. 
//Obtiene los parametros de cotrolador
//tambien procesa resultados de ejecucion recibidos de mensajes del controlador
$args['controller_file'] = 'MCartProducto.php';

$args['view_dir'] = 'MCartProducto/';
$args['view_file'] = '';

$args['table_name_list'] = 'producto';
$args['table_name'] = 'producto';
$args['table_id'] = 'id';

$args['model_search_extra_conditions'] = array();
$args['model_select_fields'] = array('*');
$args['model_search_fields'] = array('titulo', 'descripcion');

$cmd = $_REQUEST['cmd'];
switch ($cmd) {
	case 'save':
		$entity = $_REQUEST['entity'];
		if (!empty($_FILES['imagen']['name'])) {
			$basename = substr(md5(basename($_FILES['imagen']['name'])), 0, 5);
			$ext = explode('.', basename($_FILES['imagen']['name']));
			$ext = array_reverse($ext);
			$ext = $ext[0];

			$img_name = date('YmdHis') . '_' . $basename . '.' . $ext;

			$tiposValidos = array('jpeg', 'jpg', 'gif', 'png');
			foreach ($tiposValidos as $tipo) {
				$tiposValidos[] = strtoupper($tipo);
			}
			$result = uploadFile('imagen', getImgDir('m_cart_producto', 'imagen', 0, 0) . $img_name, $tiposValidos);

			if ($result > 0) {
				$entity['imagen'] = $img_name;
			}

		}
		$entity['descripcion'] = stripslashes($entity['descripcion']);
		$entity['titulo'] = stripslashes($entity['titulo']);
		$entity['codigo'] = stripslashes($entity['codigo']);
		$args['entity'] = $entity;

		break;
	default:
		break;
}
//debug($cmd);
//die();
Controller_Execute($cmd, $args);
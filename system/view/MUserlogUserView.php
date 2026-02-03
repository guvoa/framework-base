<?php
$params = Controller_GetViewParams();

$data = $params['data'];

if(empty($data)){
	echo 'No se encontro el registro';
}

foreach($data as $key => $val){
		echo '<br /><strong>' . $key . ':</strong> ' . $val;
}

?>
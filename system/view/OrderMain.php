<?php

$params = Controller_GetViewParams();


$data = $params['data'];

$hiddenFields = array();
$hiddenFields['total'] = $_total_data;
$hiddenFields['k'] = $config['k'];
$hiddenFields['p'] = $config['p'];
$hiddenFields['q'] = $config['q'];
$hiddenFields['o'] = $config['o'];


if(empty($data)){
	echo 'Actualmente no hay registros encontrados';
}

foreach($data as $registro){
	foreach($registro as $key => $val){
		echo '<br /><strong>' . $key . ':</strong> ' . $val;
		
	}
	echo '<br /><a href="Order.php?cmd=view&id='.$registro['m_cart_order_id'].'">Ver Detalles</a><hr /> ' ;
}

echo '<br /><br />'.printPager('formPager', $hiddenFields, 'texto none','textrojo none' );
		
?>
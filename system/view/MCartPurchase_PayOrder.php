<?php
//escribimos los parametros para pago con paypal
	$_PAYPAL_TEST = _PAYPAL_TEST;
	$email = EMAIL_PAYPAL_CLIENTE; 

	$total_order = MCart_GetTotalOrderById($orden['m_cart_order_id']);
	// $total_order 92.5%
	//	??			100%
	$total_order = round($total_order * 100 / 92.75,1);
	debug($total_order);
	die;
$variables = array(
	'business' => $email,
	'cmd' => '_xclick',
	'notify_url' => ABS_HTTP_URL . 'ipn.php',
	'amount' => $total_order,
	'currency_code'=>'MXN',
	'item_name' => 'Alarm City - Pago de orden No. ' . $orden['m_cart_order_id'],
	'item_number' => $orden['m_cart_order_id'],
	//'invoice' => '3',	
	'image_url' => ABS_HTTP_URL . 'images/logo.png',
	'lc' =>'MX',
	'no_shipping' => '1',
	'no_note' => '1',
//	'return' => 'http://alarm-city.com/ipn_gracias.php',
	'return' => ABS_HTTP_URL ,
	//'rm' => '2',
	'cbt' => 'Volver a Alarm City',
	//'cancel_return' => ABS_HTTP_URL . 'ipn_cancelacion.php',
	'cancel_return' => ABS_HTTP_URL ,
	'usr_manage' => '1',

	'first_name' => $orden['nombre'],//32
	'last_name' => $orden['apellidos'], //64
	'address1' => $orden['direccion'], //100
	'city' => $orden['ciudad'], //40
	'state' => $orden['estado'], //
	'zip' => $orden['codigo_postal'],
	'H_PhoneNumber' => $orden['telefono'],
	'email'=>$orden['email'],
	'installment_number'=>1

);
	include('ipn_form.php');
?>
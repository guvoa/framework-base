<?php 
$params = Controller_GetViewParams();

$data = $params['data'];

$orden = $_REQUEST['orden'];
include('MCartHeader.php'); 

?>
<style type="text/css">
	table, table td {
	    border: medium none;
	    border-collapse: collapse;
    	padding: 5px;
	}
</style>
<section id="content">
    <div class="container">
    	<div class="inside">
        <div class="indent">
        	<div class="wrapper">
        	  <div class="col-1">
            	<div class="indent">
                <div style="background:url(images/fcart.png); background-repeat:repeat-x; width:600px; height:80px">
<img src="images/cart2.png" height="80" width="92" align="middle" />
<h2 style="margin-top:30px; float:right;font-size:19px">PASO 3/3</h2>
<h2 style="margin-top:30px; float:right;padding-right:100px;">Orden de Compra Procesada</h2>

</div>
<br /><br />
<p>Su órden de compra ha sido procesada correctamente, le hemos enviado un correo electronico con los detalles de la misma. El ultimo paso consiste en que <strong>realice su pago</strong>.
<br /><br />
<?php
if($orden['forma_pago'] == 'Deposito'){
	?>
    <strong>Su forma de pago elegida es por Depósito Bancario:</strong><br />
	Los datos de depósito le han sido enviados a su <strong>correo electronico </strong> junto con los detalles de su órden. Una vez que realice su pago porfavor mándenos un email con el scan de su comprobante para 
    iniciar con el proceso de envío de sus productos. 
	<?
}else{
	include("MCartPurchase_PayOrder.php");
	/*
	//escribimos los parametros para pago con paypal
	$_PAYPAL_TEST = _PAYPAL_TEST;
	$email = EMAIL_PAYPAL_CLIENTE; 

	
$variables = array(
	'business' => $email,
	'cmd' => '_xclick',
	'notify_url' => ABS_HTTP_URL . 'ipn.php',
	'amount' => MCart_GetTotalOrderById($orden['m_cart_order_id']),
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

);
	include('ipn_form.php');*/
}
?>
<br />
<br />
Gracias por su compra!.
</p>

              </div>
            </div>

<? include('estructura/INC_DETALLES.php'); ?>
        	</div>
        </div>
      </div>
    </div>
  </section>
  
<?php include('footer.php'); ?>
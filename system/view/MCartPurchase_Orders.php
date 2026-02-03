<?php 
$params = Controller_GetViewParams();

$data = $params['data'];

switch($_REQUEST['error_code']){
	case 2:$msj_error = 'El email elegido ya se encuentra existente'; break;
	default:$msj_error = ''; break;
}
$entity = $_REQUEST['entity'];

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

                 <h2>Bienvenido al Acceso de Usuarios <span style="color:#F00">Alarm City</span></h2>
                 
<?php
include('MUserLog_Header.php');
	if(!empty($msj_error)){
		echo '<p class="error">'.$msj_error . '</p>';
	}
?>
<h3>Ordenes de Compra</h3>
                 <p>En esta seccion puede ver las ordenes de compra que ha generado.<br />
                 De click en los botones de vista para revisar el estatus de su orden.
                 </p>
                 
                   <table border="0" cellspacing="0" cellpadding="5">
                    <tr>
                      <th width="10">&nbsp;</th>
                      <th width="206">No. orden</th>
                      <th width="202">Fecha de Generacion</th>
                      <th width="284">Estatus</th>
                      <th width="86">Ver Detalles</th>
                    </tr>
                  
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
<?php

foreach(MCartPurchase_GetOrdersByUser($entity['m_userlog_user_id']) as $order){
?>
<tr>
                      <td>&nbsp;</td>
                      <td><?php echo $order['m_cart_order_id']; ?></td>
                      <td><?php echo date('d/m/Y H:i:s',strtotime($order['fecha_compra'])); ?></td>
                      <td><?php echo $order['estatus']; ?></td>
                      <td><a href="?cmd=view_order&id=<?php echo $order['m_cart_order_id']; ?>"><img src="images/arrow1.gif" alt="Ver Detalles" title="Ver Detalles"  /></a>
                      <a href="?cmd=view_order&id=<?php echo $order['m_cart_order_id']; ?>&pay=1"><img src="images/card.png" alt="Pagar Órden con Tarjeta de Crédito" title="Pagar Órden con Tarjeta de Crédito" /></a>
                      </td>
                    </tr>
<?
}
?>
                  </table>

              </div>
            </div>

<? include('estructura/INC_DETALLES.php'); ?>
        	</div>
        </div>
      </div>
    </div>
  </section>
  
<?php include('footer.php'); ?>
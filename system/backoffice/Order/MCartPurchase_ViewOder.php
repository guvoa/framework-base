<?php 
echo "here";
$order = $_REQUEST['order'];
$entity = $_REQUEST['order'];

$items = MCartPurchase_GetOrderItemsByOrderId($order['m_cart_order_id']);
$extras = MCartPurchase_GetExtraChargesByOrderId($order['m_cart_order_id']);


?>
<style type="text/css">
	table, table td {
	    border: medium none;
	    border-collapse: collapse;
    	padding: 5px;
	}
</style>

            	<div class="indent">

<div style="background:url(<?php echo ABS_HTTP_URL; ?>images/fcart.png); background-repeat:repeat-x; width:600px; height:80px">
<img src="<?php echo ABS_HTTP_URL; ?>images/cart2.png" height="80" width="92" align="middle" />
<h2 style="margin-top:30px; float:right;padding-right:170px;">Orden de Compra No. <?php echo $order['m_cart_order_id']; ?></h2>

</div>
<br />
<p align="right" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;">
Fecha de Compra:
<strong><?php echo date('d/m/Y H:i:s',strtotime($order['fecha_compra'])); ?></strong>
<br />Estatus de Órden:
<strong><?php echo $order['estatus']; ?></strong>
</p>
<br /><br />
                <? 
				
				if(empty($items)){
					echo '<em>No hay items seleccionados</em>';
				}else{
				?>
                <table align="left" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                	<tr align="left"><th width="60"></th><th></th><th width="200">Producto</th><th width="70">Cantidad</th><th width="120">Precio<br />Unitario</th><th width="160">Subtotal</th></tr>
                    <tr><td colspan="6" align="right">&nbsp;</td></tr>
				<?php 
					$subtotal = 0;
					foreach($items as $item){
						$item['total'] = $item['cantidad'] * $item['precio'];
						$subtotal += $item['total'];
						echo '<tr><td colspan="6" align="right">&nbsp;</td></tr>';
						echo '<tr align="left" height="60"><td></td>
						<td>';
						if( !empty($item['imagen'])){
							echo '<a href="'.ABS_HTTP_URL.'MCartProducto.php?cmd=view&id='.$item['m_cart_producto_id'].'"><img '. getSrcImgScaleParams(getImgDir('m_cart_producto','imagen',50,0,false) . $item['imagen'],50,0,'',0, true ) .' alt="" border="0"></a>';
						}
						echo '
						</td>
								<td><a href="'.ABS_HTTP_URL.'MCartProducto.php?cmd=view&id='.$item['m_cart_producto_id'].'">'.$item['titulo'].'</a></td>
								<td>'.$item['cantidad'].'</td>
								<td>'.formatNumber($item['precio']).'</td>
								<td>'.formatNumber($item['total']).' MXN</td>
						</tr>';
					?>
                    <tr><td colspan="6" style="border-bottom:solid #EFEFEF;" height="1"></td></tr>
                    <?
					}
				  ?>
                  <tr><td colspan="6" align="right">&nbsp;</td></tr>
                  <tr><td colspan="5" align="right">Subtotal&nbsp;&nbsp;</td><td><?php echo formatNumber($subtotal); ?></td></tr>
                  <?php
					  foreach($extras as $extra){
						  $subtotal += $extra['monto'];
							echo '<tr><td colspan="5" align="right">'.$extra['nombre'].'&nbsp;&nbsp;</td><td>'.formatNumber($extra['monto']).' MXN</td></tr>';
					  }
					  echo '<tr align=""right" style="font-size:18px"><td colspan="6" align="right"><strong>TOTAL</strong>&nbsp;&nbsp;&nbsp;'.formatNumber($subtotal).' MXN</td></tr>';
				  ?>
                  </table>
                <?php } ?>
                NOTA: Precio ya incluye IVA
                <p>&nbsp;&nbsp;</p>

<div style="width:600px; height:80px">
<img src="<?php echo ABS_HTTP_URL; ?>images/hpaquete2.jpg" align="middle" />
<h2 style="margin-top:30px; float:right;padding-right:280px;">Información de Envío</h2>

</div><br /><br />
                   <table border="0" cellspacing="0" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
                    <tr>
                      <td width="10">&nbsp;</td>
                      <td width="206">&nbsp;</td>
                      <td width="202">&nbsp;</td>
                      <td width="284">&nbsp;</td>
                      <td width="86">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Nombre</td>
                      <td>
	                      <?php echo $entity['nombre']; ?>
                      <td>&nbsp;</td>
                      <td rowspan="3" valign="top">&nbsp;</td>
                    </tr>
                    
                     <tr>
                      <td>&nbsp;</td>
                      <td>Apellidos</td>
                      <td>
	                      <?php echo $entity['apellidos']; ?>
                      </td>
                      <td>&nbsp;</td>
                      <td width="1" rowspan="3" valign="top">&nbsp;</td>
                    </tr>

                    <tr>
                      <td>&nbsp;</td>
                      <td>Email</td>
                      <td>
	                      <?php echo $entity['email']; ?>
                      </td>
                      <td>&nbsp;</td>
                    </tr>

                     <tr>
                      <td>&nbsp;</td>
                      <td>Pais</td>
                      <td>
	                      <?php echo $entity['pais']; ?>
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Estado</td>
                      <td>
	                      <?php echo $entity['estado']; ?>
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Ciudad</td>
	                    <td>  <?php echo $entity['ciudad']; ?>
						</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Telefono</td>
                      <td>
					      <?php echo $entity['telefono']; ?>
    	              </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Direccion</td>
                      <td>
					      <?php echo $entity['direccion']; ?>
    	              </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Colonia</td>
                      <td>
	                      <?php echo $entity['colonia']; ?>
    	                  </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Codigo Postal</td>
                      <td>
	                      <?php echo $entity['codigo_postal']; ?>
    	                  </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                   
                  
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    
                   
                  </table>
                  

<div style="width:600px; height:80px">
<img src="<?php echo ABS_HTTP_URL; ?>images/hcard2.jpg" align="middle" />
<h2 style="margin-top:30px; float:right;padding-right:330px;">Forma de Pago</h2>
<hr style="border:dotted #cccccc 1px 0x 0px 0px;">

</div><br /><br />
<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
Forma de Pago Seleccionada:
<strong><?php echo $order['forma_pago']; ?></strong>
<?php if($order['forma_pago'] == 'Deposito'){
	?>
<br /><br /><strong>DATOS PARA SU DEPÓSITO:</strong><BR />
No. Cta. <strong>1234567890 </strong><br />
Titular: <strong>----------------------</strong><br />
Entidad Bancaria: <strong>------</strong><br />
<br />
CLABE Interbancaria: <strong>-----------</strong>
    <?

} ?>
<br /><br />
Comentarios del pedido:<br />  <?php echo empty($order['comentarios']) ? '<em>No hay comentarios encontrados</em>' : $order['comentarios']; ?>
</span>
<br /><br /><br />
              </div>
           
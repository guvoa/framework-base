<?php 
$params = Controller_GetViewParams();

$data = $params['data'];

//el ultimo paso de la compra
$guardar_envio = $_REQUEST['cmd'] == 'guardar_envio';
$msj_error = $_REQUEST['msj_error'];
$entity = $_REQUEST['entity'];
$activate_login = $_REQUEST['activate_login'];
$activate_login_fail= $_REQUEST['activate_login_fail'];
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
<h2 style="margin-top:30px; float:right;font-size:19px">PASO <?php
				  echo $guardar_envio ? '2' : '1'; ?>/3</h2>
<h2 style="margin-top:30px; float:right;padding-right:170px;">Proceso de Compra</h2>

</div>
<br /><br />
                <? $items = MCart_getItems(); 
				
				if(empty($items)){
					echo 'El carrito de Compras esta Vacío<br /><br /><a href="productos.php" class="button">Ver Productos</a>';
				}else{
				?>
                <table align="left" border="0">
                	<tr align="left"><th width="60"></th><th></th><th width="200">Producto</th><th width="70">Cantidad</th><th width="120">Precio<br />Unitario</th><th width="160">Subtotal</th></tr>
                    <tr><td colspan="6" align="right">&nbsp;</td></tr>
				<?php 
				
					foreach($items as $item){
						echo '<tr><td colspan="6" align="right">&nbsp;</td></tr>';
						echo '<tr align="left" height="60"><td></td>
						<td>';
						if( !empty($item['imagen'])){
							echo '<a href="MCartProducto.php?cmd=view&id='.$item['m_cart_producto_id'].'"><img '.getSrcImgScaleParams(getImgDir('m_cart_producto','imagen',50,0,false) . $item['imagen'],50,0 ) .' alt="" border="0"></a>';
						}
						echo '
						</td>
								<td><a href="MCartProducto.php?cmd=view&id='.$item['m_cart_producto_id'].'">'.$item['titulo'].'</a>'.(!empty($item['peso_grs']) ?
"<BR /><strong>Peso: ".number_format($item['peso_grs'],2,'.',',')." grs.</strong>" : "" ).'</td>
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
                  <tr><td colspan="5" align="right">Subtotal&nbsp;&nbsp;</td><td><?php echo formatNumber(MCart_getTotalItems()); ?> MXN</td></tr>
                  <?php
				  if( $guardar_envio ){ 
					  foreach(MCart_getExtraCharges() as $extra){
							echo '<tr><td colspan="5" align="right">'.$extra['nombre'].'&nbsp;&nbsp;</td><td>'.formatNumber($extra['monto']).' MXN</td></tr>';
					  }
					  echo '<tr align=""right" style="font-size:18px"><td colspan="6" align="right"><strong>TOTAL</strong>&nbsp;&nbsp;&nbsp;'.formatNumber(MCart_getTotal()).' MXN</td></tr>';
				  }
				  ?>
                  <tr><td colspan="6">
                  <BR />* Precios ya incluyen IVA
                  <BR /><BR />
                  <br />
                  <input type="button" onclick="document.location.href='MCartCart.php'" name="cmd" value="Modificar Carrito">
                  </td></tr>
                  </table>
                <?php } ?><p>&nbsp;&nbsp;</p>

<div style="width:600px; height:80px">
<img src="images/hpaquete2.jpg" align="middle" />
<h2 style="margin-top:30px; float:right;padding-right:280px;">Información de Envío</h2>

</div><br /><br />
<?php
if(!$guardar_envio){
	echo 'Si ya realizo una compra anteriormente o ya se encuentra registrado ingrese a la <a href="user.php" target="_top"><strong>zona de usuarios </strong></a>para que la informacion de envio aparezca automaticamente. 
	De lo contrario indique su información de envío.';
}
	if(!empty($msj_error)){
		echo '<p class="error">'.$msj_error . '</p>';
	}
?>
<form action="purchase.php" method="post">
                 
                   <table border="0" cellspacing="0" cellpadding="5">
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
                      <?php if($guardar_envio){ ?>
	                      <?php echo $entity['nombre']; ?>
    	                  	<input type="hidden" name="entity[nombre]" value="<?php echo $entity['nombre']; ?>" /></td>
                      <?php }else{ ?>
	                      <input type="text" name="entity[nombre]" value="<?php echo $entity['nombre']; ?>" /></td>
                      <?php } ?>
                      <td>&nbsp;</td>
                      <td rowspan="3" valign="top">&nbsp;</td>
                    </tr>
                    
                     <tr>
                      <td>&nbsp;</td>
                      <td>Apellidos</td>
                      <td>
                      <?php if($guardar_envio){ ?>
	                      <?php echo $entity['apellidos']; ?>
    	                  	<input type="hidden" name="entity[apellidos]" value="<?php echo $entity['apellidos']; ?>" /></td>
                      <?php }else{ ?>
		                      <input type="text" name="entity[apellidos]" value="<?php echo $entity['apellidos']; ?>" /></td>
                      <?php } ?>
                      </td>
                      <td>&nbsp;</td>
                      <td width="1" rowspan="3" valign="top">&nbsp;</td>
                    </tr>
                    <?php if(!$activate_login){ ?>

                    <tr>
                      <td>&nbsp;</td>
                      <td>Email</td>
                      <td>
                      <?php if($guardar_envio){ ?>
	                      <?php echo $entity['email']; ?>
    	                  	<input type="hidden" name="entity[email]" value="<?php echo $entity['email']; ?>" /></td>
                      <?php }else{ ?>
	                      <input type="text" name="entity[email]" value="<?php echo $entity['email']; ?>" /></td>
                      <?php } ?>
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                    <?php } ?>

                     <tr>
                      <td>&nbsp;</td>
                      <td>Pais</td>
                      <td>
                       <?php if($guardar_envio){ ?>
	                      <?php echo $entity['pais']; ?>
    	                  	<input type="hidden" name="entity[pais]" value="<?php echo $entity['pais']; ?>" /></td>
                      <?php }else{ ?>
                          <?php
                      echo '<select name="entity[pais]">';
					  foreach(GetCountries() as $country){
						  $selected = $estate['value']==$entity['pais'] ? 'selected="selected"' : '';
						echo '<option value="'.$country['value'].'" '.$selected.'>'.$country['label'].'</option>'; 
					  }
					  echo '</select>';
					  
					  ?>
                          </td>
                      <?php } ?>
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Estado</td>
                      <td>
                      <?php if($guardar_envio){ ?>
	                      <?php echo $entity['estado']; ?>
    	                  	<input type="hidden" name="entity[estado]" value="<?php echo $entity['estado']; ?>" /></td>
                      <?php }else{ ?>
                       <?php
                      echo '<select name="entity[estado]">';
					  foreach(GetMXStates() as $estate){
 						$selected = $estate['value']==$entity['estado'] ? 'selected="selected"' : '';
						echo '<option value="'.$estate['value'].'" '.$selected.'>'.$estate['label'].'</option>'; 
					  }
					  echo '</select>';
					  
					  ?>
	                    </td>
                      <?php } ?>
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Ciudad</td>
                      <td><?php if($guardar_envio){ ?>
	                      <?php echo $entity['ciudad']; ?>
    	                  	<input type="hidden" name="entity[ciudad]" value="<?php echo $entity['ciudad']; ?>" /></td>
                      <?php }else{ ?>
	                      <input type="text" name="entity[ciudad]" value="<?php echo $entity['ciudad']; ?>" /></td>
                      <?php } ?></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Telefono</td>
                      <td><?php if($guardar_envio){ ?>
	                      <?php echo $entity['telefono']; ?>
    	                  	<input type="hidden" name="entity[telefono]" value="<?php echo $entity['telefono']; ?>" /></td>
                      <?php }else{ ?>
	                      <input type="text" name="entity[telefono]" value="<?php echo $entity['telefono']; ?>" /></td>
                      <?php } ?></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Direccion</td>
                      <td><?php if($guardar_envio){ ?>
	                      <?php echo $entity['direccion']; ?>
    	                  	<input type="hidden" name="entity[direccion]" value="<?php echo $entity['direccion']; ?>" /></td>
                      <?php }else{ ?>
	                      <input type="text" name="entity[direccion]" value="<?php echo $entity['direccion']; ?>" /></td>
                      <?php } ?></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Colonia</td>
                      <td><?php if($guardar_envio){ ?>
	                      <?php echo $entity['colonia']; ?>
    	                  	<input type="hidden" name="entity[colonia]" value="<?php echo $entity['colonia']; ?>" /></td>
                      <?php }else{ ?>
	                      <input type="text" name="entity[colonia]" value="<?php echo $entity['colonia']; ?>" /></td>
                      <?php } ?></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Codigo Postal</td>
                      <td><?php if($guardar_envio){ ?>
	                      <?php echo $entity['codigo_postal']; ?>
    	                  	<input type="hidden" name="entity[codigo_postal]" value="<?php echo $entity['codigo_postal']; ?>" /></td>
                      <?php }else{ ?>
	                      <input type="text" name="entity[codigo_postal]" value="<?php echo $entity['codigo_postal']; ?>" /></td>
                      <?php } ?></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    
                    
<?php if($activate_login){ ?>

                    <tr>
                      <td colspan="4">
<div style="width:600px; height:80px">
<img src="images/profile.jpg" align="middle" />
<h2 style="margin-top:30px; float:right;padding-right:320px;">Acceso a usuarios</h2>
</div>                      
                      </td>

                    </tr>
                    
                     <tr>
                      <td>&nbsp;</td>
                      <td colspan="3"><strong>Ingrese sus datos de acceso para continuar</strong>
                      <?php if($activate_login_fail){ ?><br /><span class="error">usuario o contraseña incorrectos</span><?php } ?></td>
                    </tr>
                                        <tr>
                      <td>&nbsp;</td>
                      <td>Email</td>
                      <td><?php echo $entity['email']; ?>
	                      <input type="hidden" name="entity[email]" value="<?php echo $entity['email']; ?>" /></td>
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                     <tr>
                      <td>&nbsp;</td>
                      <td>Contraseña</td>
                      <td>
	                      <input type="password" name="contrasena" value="" />
                          <input type="hidden" name="sending_contrasena" value="1" />
                          </td>
                      </td>
                      <td>Olvido su contraseña? De <a href="MUserLog.php?cmd=recover_pwd&send=1&entity[email]=<?php echo $entity['email'];  ?>" target="_blank">Clic Aquí</td>
                    </tr>
                     <tr>
                     <td>&nbsp;</td>
                      <td colspan="3"></td>
                    </tr>
<?php } ?>

<tr><td colspan="5">
<?php if( $guardar_envio ){ ?>
    <input type="submit" value="Modificar Informacion de Envío">

<?php }else{ ?>

<?php if($activate_login){ ?>
	<input type="button" onclick="document.location.href='purchase.php'" name="cmd" value="Cambiar email">
<?php } ?>

	<input type="hidden" name="cmd" value="guardar_envio" />
	<input type="submit" name="boton" value="Continuar Proceso de Compra">
<?php } ?>
                  </td></tr>
                  
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    
                   
                  </table>
                  
<?php                  
if($guardar_envio){
	?>

<div style="width:600px; height:80px">
<img src="images/hcard2.jpg" align="middle" />
<h2 style="margin-top:30px; float:right;padding-right:330px;">Forma de Pago</h2>
<hr style="border:dotted #cccccc 1px 0x 0px 0px;">

</div><br /><br />

Seleccione la opcion de pago que desea utilizar:
<br />
Monto a Pagar: <strong><?php echo ''.formatNumber(MCart_getTotal()).' MXN'; ?></strong>
<br /><br />
<input type="radio" name="forma_pago" value="Tarjeta de Credito" checked="checked" /> Tarjeta de Crédito <img src="images/paypal.png">
<br /><br />
<input type="radio" name="forma_pago" value="Deposito" /> Depósito Bancario
<br /><br /><br />
Comentarios del pedido:<br /> <textarea name="comentarios" style="width:450px; height:100px"></textarea>
<br /><br /><br />
	<input type="submit" name="cmd" value="Finalizar Compra y Pagar" style="height:45px">
<?
}

?>
                  
                </form>
              </div>
            </div>

<? include('estructura/INC_DETALLES.php'); ?>
        	</div>
        </div>
      </div>
    </div>
  </section>
  
<?php include('footer.php'); ?>
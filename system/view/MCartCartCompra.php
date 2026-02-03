<?php 
$params = Controller_GetViewParams();
$data = $params['data'];
include 'MCartHeader.php'; 
?>
<section id="content">
    <div class="container">
    	<div class="inside">
        <div class="indent">
        	<div class="wrapper">
        	  <div class="col-1">
            	<div class="indent">
				<h2>Comprar</h2>
                <?php $items = MCart_getItems(); 
				if(empty($items)){
					echo 'El carrito de Compras esta Vacío<br /><br /><a href="productos.php" class="button">Ver Libros</a>';
				}else{
				?>
                <form action="">
                <table align="left" border="1">
                	<tr align="left"><th width="60"></th><th width="200">Producto</th><th width="80">Cantidad</th><th width="120">Precio<br />Unitario</th><th width="120">Total</th></tr>
                    <tr><td colspan="6" align="right">&nbsp;</td></tr>
				<?php 

					foreach($items as $item){
						echo '<tr><td colspan="6" align="right">&nbsp;</td></tr>';
						echo '<tr align="left" height="60">
						<td>';
						if( !empty($item['imagen'])){
							echo '<a href="MCartProducto.php?cmd=view&id='.$item['m_cart_producto_id'].'"><img '.getSrcImgScaleParams(getImgDir('m_cart_producto','imagen',50,0,false) . $item['imagen'],50,0 ) .' alt="" border="0"></a>';
						}
						echo '
						</td>
								<td><a href="MCartProducto.php?cmd=view&id='.$item['m_cart_producto_id'].'">'.$item['titulo'].'</a>'.(!empty($item['peso_grs']) ?
"<BR /><strong>Peso: ".number_format($item['peso_grs'],2,'.',',')." grs.</strong>" ).'</td>
								<td><input type="text" style="width:50px" name="qty_'.$item['m_cart_producto_id'].'" value="'.$item['cantidad'].'" /></td>
								<td>'.formatNumber($item['precio']).'</td>
								<td>'.formatNumber($item['total']).'</td>
						</tr>';
					?>
                    <tr><td colspan="6" style="border-bottom:solid #EFEFEF;" height="1"></td></tr>
                    <?
					}
				  ?>
                  <tr><td colspan="6" align="right">&nbsp;</td></tr>
                  <tr><td colspan="5" align="right">Subtotal&nbsp;&nbsp;</td><td><?php echo formatNumber(MCart_getTotalItems()); ?></td></tr>
                  <tr><td colspan="6"><br /><br /><input type="submit" name="cmd" value="Actualizar"></td></tr>
                  </table>

				</form>
                <?php } ?>
              </div>
            </div>

<? include('estructura/INC_DETALLES.php'); ?>
        	</div>
        </div>
      </div>
    </div>
  </section>
  
<?php include('footer.php'); ?>
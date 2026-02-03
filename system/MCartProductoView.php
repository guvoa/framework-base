<?php
$params = Controller_GetViewParams();

$data = $params['data'];


include('MCartHeader.php'); 


?>
<section id="content">
    <div class="container">
    	<div class="inside">
        <div class="indent">
        	<div class="wrapper">
        	  <div class="col-1">
            	<div class="indent">
	<?
				  echo empty($data['titulo']) ? '' : '<h2>'.$data['titulo'].' </h2>';
				  
                 if(!empty($data['imagen'])){
				  ?>
                  	<figure>
                  		<img src="<?php echo getImgDir('m_cart_producto','imagen') . $data['imagen']; ?>" alt="">
                    </figure>
                    <? } ?>
                <?php 
					  echo empty($data['codigo']) ? '' : '<h4>Código: '.formatStr($data['codigo']).' </h4>';
					  ?>
                       <select id="item_number" style="width:100px;"><?php
                      	for($i=1;$i<=50;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					  ?></select>
                      <h4>PRECIO: <strong>$ <?php echo $data['precio']; ?></strong></h4>
                      <a href="#" class="button" onclick="document.location.href='MCartCart.php?cmd=add&productId=<?php echo $data['m_cart_producto_id']; ?>&itemNumber=' + document.getElementById('item_number').value">Agregar al Carrito</a>
                      <br /><br />
					<?
					  echo empty($data['descripcion']) ? '' : '<p align="justify">'.formatStr($data['descripcion']).' </p>';
				  ?>

              </div>
            </div>

<? include('estructura/INC_DETALLES.php'); ?>
        	</div>
        </div>
      </div>
    </div>
  </section>
  
<?php include('footer.php'); ?>
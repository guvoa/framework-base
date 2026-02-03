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
                    <div class="clear"></div>
                    <BR /><strong>PRECIO: <?php echo formatNumber($data['precio']); ?></strong> precio incluye IVA
                    <? if(!empty($data['peso_grs'])){ ?><BR /><strong>Peso: <?php echo number_format($data['peso_grs'],2,'.',','); ?> grs.</strong> <? } ?>
                                    <STRONG><?php 
					  echo empty($data['codigo']) ? '' : '<br />Código: '.formatStr($data['codigo']);
					  ?>
                    </STRONG> <BR /><BR />

                       <select id="item_number" style="width:100px; display:block;"><?php
                      	for($i=1;$i<=50;$i++){
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
					  ?></select><br />
                      <a href="#" class="button" onclick="document.location.href='MCartCart.php?cmd=add&productId=<?php echo $data['m_cart_producto_id']; ?>&itemNumber=' + document.getElementById('item_number').value" >Agregar al Carrito</a>
                      <br />
                      
                      
                      <br />
                      
					<?

					$data['descripcion'] = formatStr($data['descripcion'],0);
					if( $_REQUEST['debug']==2 ){
						echo '<BR />DESPUES<BR />';
						var_dump($data['descripcion']);
					}
					  echo empty($data['descripcion']) ? '' : '<p align="justify">'.$data['descripcion'].' </p>';
				  ?>

              </div>
            </div>

<? include('INC_DETALLES.php'); ?>
        	</div>
        </div>
      </div>
    </div>
  </section>
  
<?php include('footer.php'); ?>
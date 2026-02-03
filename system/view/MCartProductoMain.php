<?php

$params = Controller_GetViewParams();


$data = $params['data'];

$hiddenFields = array();
$hiddenFields['total'] = $_total_data;
$hiddenFields['k'] = $config['k'];
$hiddenFields['p'] = $config['p'];
$hiddenFields['q'] = $config['q'];
$hiddenFields['o'] = $config['o'];



$params = Controller_GetViewParams();

$data = $params['data'];

$hiddenFields = array();
$hiddenFields['total'] = $_total_data;
$hiddenFields['k'] = $config['k'];
$hiddenFields['p'] = $config['p'];
$hiddenFields['q'] = $config['q'];
$hiddenFields['o'] = $config['o'];
$hiddenFields['categoriaId'] = $_REQUEST['categoriaId'];


$categoriaActual = MCart_GetCategoriaById($_REQUEST['categoriaId']);


include('MCartHeader.php'); 


?>
<section id="content">
    <div class="container">
    	<div class="inside">
        <div class="indent">
        	<div class="wrapper">
        	
            

            <div class="col-1">
                
 <h2><?php echo $categoriaActual['nombre']; ?></h2>
 

  
  <?php
  if(empty($data)){
	echo 'Actualmente no hay registros encontrados';
}

foreach($data as $registro){
?>
   <article>

                <div class="wrapper">
                <?
                 if(!empty($registro['imagen'])){
				  ?>
                  <div style="height:105px;">
                  	<figure>
                  		<a href="MCartProducto.php?cmd=view&id=<?php echo $registro['m_cart_producto_id'] ?>"><img <? echo getSrcImgScaleParams(getImgDir('m_cart_producto','imagen',100,100,false) . $registro['imagen'],100,100 ) ?> alt=""></a>
                    </figure>
                    </div>
                    <div class="clear"></div>
                    <? } ?>
                  
                      <?php 
					  
					  echo empty($registro['titulo']) ? '' : '<h4>'.getMaxCar($registro['titulo'],100).'</h4>';
					  echo empty($registro['precio']) ? '' : '<strong>Precio: '.formatNumber($registro['precio']).'</strong> (precio incluye IVA)';
					  echo empty($registro['descripcion']) ? '' : '<p align="justify">'.getNRows($registro['descripcion'], 6,40).'</p>';
					  
					  echo '<br /><a class="button" href="MCartProducto.php?cmd=view&id='.$registro['m_cart_producto_id'].'">Ver Detalles</a>' ;
					  echo '&nbsp;&nbsp;<a class="button" href="MCartCart.php?cmd=add&productId='.$registro['m_cart_producto_id'].'&itemNumber=1">Agregar al Carrito</a>' ;
				  ?> 
                </div>
            	</article>
<?
	$i++;
	if($i%2 == 0 || $i >= count($data)){
		echo '<div class="clear"></div>';
	}
}

echo '<br />Página: '.printPager('formPager', $hiddenFields, 'texto none','textrojo none' );
  ?>
            	
            </div>
            
            
<? include('estructura/INC_DETALLES.php'); ?>
        	</div>
        </div>
      </div>
    </div>
  </section>
  
<?php include('footer.php'); ?>
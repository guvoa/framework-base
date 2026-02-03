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







include('MCartHeader.php'); 


?>
<section id="content">
    <div class="container">
    	<div class="inside">
        <div class="indent">
        	<div class="wrapper">
        	
            

            <div class="col-1">
            	  <h2>Libros</h2>
                
  

  
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
                  	<figure>
                  		<img <? echo getSrcImgScaleParams(getImgDir('m_cart_producto','imagen',200,0,false) . $registro['imagen'],200,0 ) ?> alt="">
                    </figure>
                    <? } ?>
                  
                      <?php 
					  
					  echo empty($registro['titulo']) ? '' : '<h4>'.$registro['titulo'].'</h4>';
					  echo empty($registro['descripcion']) ? '' : '<p align="justify">'.formatStr($registro['descripcion'], 150).'</p>';
					  
					  echo '<br /><a class="button" href="MCartProducto.php?cmd=view&id='.$registro['m_cart_producto_id'].'">Ver Detalles</a>' ;
				  ?> 
                </div>
            	</article>
<?
	
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
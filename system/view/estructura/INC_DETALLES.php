<?php
$extraConditions = array();
$extraConditions[] = array('condition'=>'%s IS NULL OR %s = 0', 'condition_values'=>array('m_cart_categoria_parent_id','m_cart_categoria_parent_id') );
$results = DB_INTERFACE_Select('m_cart_categoria',array('*'), $extraConditions, 'nombre ASC', 1, -1);

$htmlSelect = '<div class="wrapper">';
foreach($results as $result){
	$extraConditions = array();
	$extraConditions[] = array('condition'=>'m_cart_categoria_parent_id = %s', 'condition_values'=>array($result['m_cart_categoria_id']) );
	$results2 = DB_INTERFACE_Select('m_cart_categoria',array('*'), $extraConditions,
			array( 'order'=>'%s ASC', 'order_values'=>array('posicion') ), 
		1, -1);

	$htmlSelect .= '<br /><strong>' . $result['nombre'].'</strong>';
	foreach($results2 as $result2){
		$extraConditions = array();
		$extraConditions[] = array('condition'=>'m_cart_categoria_parent_id = %s', 'condition_values'=>array($result2['m_cart_categoria_id']) );
		$results3 = DB_INTERFACE_Select('m_cart_categoria',array('*'), $extraConditions,
				array( 'order'=>'%s ASC', 'order_values'=>array('posicion') ), 
			1, -1);
		
		if(empty($results3)){
			$htmlSelect .= '<br />> <a href="MCartProducto.php?categoriaId=' . $result2['m_cart_categoria_id'].'">' . $result2['nombre'].'</a>';
		}else{
			//$htmlSelect .= '<br />+<a href="MCartProducto.php?categoriaId=' . $result2['m_cart_categoria_id'].'">' . $result2['nombre'].'</a>';
			$htmlSelect .= '<br />+' . $result2['nombre'].'';
			foreach($results3 as $result3){
				$htmlSelect .= '<br />&nbsp;&nbsp;&nbsp;><a href="MCartProducto.php?categoriaId=' . $result3['m_cart_categoria_id'].'">' . $result3['nombre'].'</a>';
			}
		}
	}
	$htmlSelect .= '<br />';
}
$htmlSelect .= '</div>';


?>
<div class="col-2"><h2 style="margin-bottom:0px;">Categorias</h2>
<?php echo $htmlSelect; ?><br /><br />
            	<article_col2>
                  <?php 
				  $contenido_completo = GetContenidoByPaginaId();
					  $contenido = ParseContenidoByLabel($contenido_completo, '_INC_DETALLES_pan_a_su_orden'); 
					  echo empty($contenido['texto']) ? '' : '<h2>'.$contenido['texto'].' </h2>';

				  ?>
                <div class="wrapper">
                <?php
				  $contenido = ParseContenidoByLabel($contenido_completo, '_INC_DETALLES_subtitulo_descripcion'); 

                  if(!empty($contenido['imagen'])){
				  ?>
                  	<figure>
                  		<img src="<?php echo getImgDir('contenido','imagen') . $contenido['imagen']; ?>" alt="">
                    </figure>
                    <h4><?php echo $contenido['texto']; ?></h4>
                  <p><?php echo $contenido['texto2']; ?></p>
                  <?php 
				  }
				  ?>
                  <?php 
					  $contenido = ParseContenidoByLabel($contenido_completo, '_INC_DETALLES_link'); 
					  echo empty($contenido['texto']) ? '' : '<a href="'.$contenido['link'].'" class="button">'.$contenido['texto'].'</a>';

				  ?>
                  
                  
                </div>
            	</article>
              <article_col2 class="last">
               <?php 

					  $contenido = ParseContenidoByLabel($contenido_completo, '_INC_DETALLES_mas_servicios'); 
					  echo empty($contenido['texto']) ? '' : '<h2>'.$contenido['texto'].'</h2>';
					  $contenido = ParseContenidoByLabel($contenido_completo, '_INC_DETALLES_mas_servicios_subtitulo_descripcion'); 
					  
					  echo empty($contenido['texto']) ? '' : '<h4>'.$contenido['texto'].'</h4>';
					  echo empty($contenido['texto2']) ? '' : '<p>'.$contenido['texto2'].'</p>';
?>
                <div class="wrapper">
                  <ul class="list2 col-1">
                  <?php 
			    $contenido = ParseContenidoByLabel($contenido_completo, '_INC_DETALLES_mas_servicios_lista',true); 

				foreach($contenido as $li){
					echo '<li><a href="'.(empty($li['link']) ? '#' : $li['link']).'">'.$li['texto'].'</a></li>';
				}
			   ?>
                  </ul>
                </div>
				<?php 
				$contenido = ParseContenidoByLabel($contenido_completo, '_INC_DETALLES_mas_servicios_link'); 
                if( !empty($contenido['texto']) ){
                	echo '<a href="'.$contenido['link'].'" class="button">'.$contenido['texto'].'</a>';
                }
                ?>


              </article>
            </div>
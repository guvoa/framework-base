<?php
function printPager( $formName, $fields, $class = '',$classActual = '', $href ='', $k_groups = 5){
	$ponerTodasPaginas = $k_groups == -1;
	
	$fields = empty($fields) ? array() : $fields;
	$total= empty($fields['total']) ? 0 : $fields['total'];
	$k = empty($fields['k']) ? 1 : $fields['k'];
	$p = empty($fields['p']) ? 0 : $fields['p'];
	
	//--calculo de paginacion
	$paginas = ($total / $k);
	
	$paginas = ($paginas - (int)$paginas) > 0 ? (int)$paginas +1 : $paginas;  	
	
	$pagIni = $p - (int)($k_groups/2) ;
	
	$pagIni = $pagIni < 1 ? 1 : $pagIni;


	$pagFin = ($pagIni + $k_groups) >= $paginas ? $paginas : ($pagIni + $k_groups);

	if($ponerTodasPaginas){
		$pagIni = 1;
		$pagFin = $paginas;
	}
	$html='';
	if($p > 1){
		$html .= '<a href=\'';
		$html .= empty($href) ? 'javascript:setFormParam("' . $formName . '","p",' . (1) . ', true)' : str_replace('{p}',(1),$href);
		$html .= '\' class="' . $class . '" title="Pagina 1">';
		$html .= '|<';
		$html .= '</a>&nbsp;&nbsp;&nbsp;&nbsp;';
		
		$html .= '<a href=\'';
		$html .= empty($href) ? 'javascript:setFormParam("' . $formName . '","p",' . ($p-1) . ', true)' : str_replace('{p}',($p-1),$href);
		$html .= '\' class="' . $class . '" title="Anterior">';
		$html .= '<';
		$html .= '</a>&nbsp;&nbsp;&nbsp;&nbsp;';

	}
	if( $pagIni > 1 && !$ponerTodasPaginas){
		
		$page = 1;
		$html .= '<a href=\'';
		$html .= empty($href) ? 'javascript:setFormParam("' . $formName . '","p",' . $page . ', true)' : str_replace('{p}',$page,$href);
		$html .= '\' class="' . $class . '">';
		$html .= $page;
		$html .= '</a>&nbsp;&nbsp;...&nbsp;&nbsp;';
	}
		for( $i=$pagIni; $i <= $pagFin;$i++ ){
		$page = $i;
		$className = $p == $page ? $classActual : $class;
		$html .= '<a href=\'';
		$html .= empty($href) ? 'javascript:setFormParam("' . $formName . '","p",' . $page . ', true)' : str_replace('{p}',$page,$href);
		$html .= '\' class="' . $className . '">';
		$html .= $page;
		$html .= '</a>&nbsp;&nbsp;';
	}
	if( $pagFin < $paginas && !$ponerTodasPaginas){
		$page = $paginas;
		$html .= '...<a href=\'';
		$html .= empty($href) ? 'javascript:setFormParam("' . $formName . '","p",' . $page . ', true)' : str_replace('{p}',$page,$href);
		$html .= '\' class="' . $class . '">';
		$html .= $page;
		$html .= '</a>&nbsp;&nbsp;';
	}
	
	if($p < $paginas){
		$html .= '<a href=\'';
		$html .= empty($href) ? 'javascript:setFormParam("' . $formName . '","p",' . ($p+1) . ', true)' : str_replace('{p}',($p+1),$href);
		$html .= '\' class="' . $class . '" title="Siguiente">';
		$html .= '>';
		$html .= '</a>&nbsp;&nbsp;&nbsp;&nbsp;';

		$html .= '<a href=\'';
		$html .= empty($href) ? 'javascript:setFormParam("' . $formName . '","p",' . ($paginas) . ', true)' : str_replace('{p}',($paginas),$href);
		$html .= '\' class="' . $class . '" title="Ultima Pagina">';
		$html .= '>|';
		$html .= '</a>&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	
	$html .= '
	<form action="" id="' . $formName . '" style="margin:0px;">
	';
	foreach($fields as $field => $value){
		$html .='<input type="hidden" name="' . $field . '" id="' . $field . '" value="' . $value . '">';
	}
	$html .='
	</form>
	<script language="javascript">
		function buscaNuevaCadena(){
			document.getElementById("p").value = "";
			setFormParam( \'formPager\',\'q\',document.getElementById(\'qtmp\').value, true );
		}
		function setFormParam(formName, id,p, submit){
			document.getElementById(id).value = p;
			if( submit ){
				document.getElementById( formName ).submit();
			}
				
		}
	</script>';
	return $html;
}


function displayForm( $form ){
	
	$items = !is_array($form['items']) ? array() : $form['items'];
	$html = '<fieldset><legend>' . $form['title'] . '</legend>';
	foreach($items as $item){
		$html .= displayFormItem($item);
	}
	$html .= '</fieldset>';
	echo $html;
}

function displayFormItem( $item ){
	$html = '';
		
	$item = !is_array( $item ) ? array() : $item;
	
	$name =$item['name'];
	$id =$item['id'];
	$value =$item['value'];
	$w =$item['width'];

	$itemParams = ' style="width:' . $w . 'px;' . $item['style'] . '" ' . $item['item_params'];
	
	$displayHtml = !empty($item['text']);
	
	if( $displayHtml ){
		$html .= '<div '.$item['div_params'].'><table><tr valign="top"><td width="150">' . $item['text'] . ' :</td><td>';
	}
	$htmlAd = '';
	switch( $item['type'] ){
		case 'datetime':
			$time = strtotime($item['value']);
			$hora = date('H', $time);
			$min = date('i', $time);
			$ampm= date('A', $time);
			$htmlAd = '<select name="'.$id.'_Hora">';
			for($i=0;$i<=12;$i++){
				$it = $i < 10 ? ('0' . $i) : $i;
				$htmlAd .= '<option value="'.$i.'" '.($hora == $it ? 'selected="selected"' : '').'>'.$it.'</option>';
			}
			$htmlAd .= '</select>:<select name="'.$id.'_Minuto">';
			for($i=0;$i<=59;$i++){
				$it = $i < 10 ? ('0' . $i) : $i;
				
				$htmlAd .= '<option value="'.$i.'" '.($min == $it ? 'selected="selected"' : '').'>'.$it.'</option>';
			}
			$htmlAd .= '</select><select name="'.$id.'_AMPM">
				<option value="AM" '.($ampm == 'AM' ? 'selected="selected"' : '').'>AM</option>
				<option value="PM" '.($ampm == 'PM' ? 'selected="selected"' : '').'>PM</option>
			</select>
			';
			
			$value = date('Y-m-d', $time);
		case 'date':
			$html .= '
			<script src="js/JSCal/src/js/jscal2.js"></script>
		    <script src="js/JSCal/src/js/lang/es.js"></script>
		    <link rel="stylesheet" type="text/css" href="js/JSCal/src/css/jscal2.css" />
		    <link rel="stylesheet" type="text/css" href="js/JSCal/src/css/border-radius.css" />
		    <link rel="stylesheet" type="text/css" href="js/JSCal/src/css/steel/steel.css" />
		    ';
			
			$html .= '<input size="12" id="' . $id . '" name="' . $name . '" value="' . $value . '" /><button type="button" id="' . $id . '_btn">...</button>'  .$htmlAd;
			$html .= '
			 <script type="text/javascript">//<![CDATA[

		      var cal = Calendar.setup({
		          onSelect: function(cal) { cal.hide() }
		      });
		      cal.manageFields("' . $id . '_btn", "' . $id . '", "%Y-%m-%d");
		      	
		    //]]></script>';
		break;
		case 'select':
			$options = empty($item['options']) ? array() : $item['options'];
			
			$html .= '<select name="' . $name . '" ' . $itemParams . '>';
			 foreach( $options as $optValue => $option){
			 	$select = $optValue == $value ? 'selected="selected"' : '';
			 	$html .='<option value="' . $optValue . '" ' . $select . '>' . $option . '</option>';
			 }
			 $html .= '</select>';
		break;
		case 'textarea':
			$html .= '<textarea name="' . $name . '" ' . $itemParams . ' cols="80" rows="8">' . $value . '</textarea>';
		break;
		
		case 'file':
			$valueLink = !empty( $value ) ? 
				'<a href="' . ABS_HTTP_PATH . getImgDir($item['class'],$id) . $value .'" target="_blank">Ver Imagen Actual</a>' : '';
			$html .= '<input type="file" name="' . $id . '" ' . $itemParams . ' />' . $valueLink;
			$html .= '<input type="hidden" name="' . $name . '" value="' . $value . '" ' . $itemParams . ' />';
		break;
		
		case 'fieldset':
			$html .= '</fieldset><fieldset><legend>' . $value . '</legend>';
		break;
		
		case 'text_plain':
			$html .= '' . $value;
		break;
		
		case 'hidden':
			$html .= '<input type="hidden" name="' . $name . '" value="' . $value . '" ' . $itemParams . ' />';
		break;
		
		case 'iframe':
			$html .= '<iframe src="' . $value . '" ' . $itemParams . ' ></iframe>';
		break;

		case 'google_map':
			$html .= '
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAzr2EBOXUKnm_jVnk0OJI7xSosDVG8KKPE1-m51RBrvYughuyMxQ-i1QfUnH94QxWIa6N4U6MouMmBA" type="text/javascript"></script>

			<script language="javascript">
				window.onload = initialize;
				function initialize() {
					var latlng = new google.maps.LatLng(-34.397, 150.644);
					var myOptions = {
					  zoom: 8,
					  center: latlng,
					  mapTypeId: google.maps.MapTypeId.ROADMAP
					};
					var map = new google.maps.Map(document.getElementById("map_canvas"),
						myOptions);
				  }

            </script>
			  <div id="map_canvas" style="width:100%; height:100%"></div>
			';
		break;


		default:
			$value = str_replace('"','&quot;',$value);
			$html .= '<input type="text" name="' . $name . '" value="' . $value . '" ' . $itemParams . ' />';
		break;
	}

	if( $displayHtml ){
		$html .= '</td></tr></table></div>';
	}
	
	return $html;
}

?>
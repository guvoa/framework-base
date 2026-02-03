<?php

require_once('form.php');

function display( $_total_data, $_data, $config, $k_groups = 5){
	$_data = !empty($_data) ? $_data : array();
	
	$hiddenFields = empty($config["addhiddenFields"]) ? array() : $config["addhiddenFields"];
	$renameColumns = empty($config["renameColumns"]) ? array() : $config["renameColumns"];
	
	$actionButtons = empty($config["actionButtons"]) ? array() : $config["actionButtons"];
	$callFunctions = empty($config["callFunctions"]) ? array() : $config["callFunctions"];
	
	$p = empty($config["p"]) ? 1 : $config["p"];
	$k = empty($config["k"]) ? 10 : $config["k"];
	$q = empty($config["q"]) ? '' : $config["q"];
	$o = empty($config["o"]) ? '' : $config["o"];
	
	$_total_data = empty($_total_data) ? 0 : $_total_data;
	$_data = empty($_data) ? array() : $_data;
	$hiddenColumns= empty($config['hiddenColumns']) ? array() : $config['hiddenColumns'];
	$cols = 0;

	$hiddenFields['p'] = $p;
	$hiddenFields['o'] = $o;
	$hiddenFields['q'] = $q;
	$hiddenFields['k'] = $k;
	$hiddenFields['total'] = $_total_data;
		
	$html = '
	<div>
	<table ><tr><td><input type="text" id="qtmp" value="' . $q . '" /> 
	<input type="button" value="Buscar" onClick="javascript:buscaNuevaCadena()" />
	<input type="button" value="Limpiar" onClick="javascript:setFormParam( \'formPager\',\'q\',\'\', true )" />
	</td></tr></table></div>';
			
	if( empty($_data) ){
		$html .= '<div><b>No hay resultados encontrados</b> <br />'. printPager('formPager', $hiddenFields, 'paginacion','paginacion paginacionActual','', $k_groups ) . '</div>';
	}else{
				
	$html .= '
	<div>
	<table border="0" width="100%" cellpadding="2" cellspacing="2" bgcolor="#CCCCCC">
	';
	
		$titles = !empty($_data) ? $_data[0] : array();
		$html .= '<tr>';
		
		if(!empty($actionButtons)){
			//add action column
			$titles['Acciones'] = '';
		}
		foreach($titles as $title => $value){
			if( !in_array($title,$hiddenColumns) ){
				$html .= '<th bgcolor="#BEBEBE">';
				$html .= empty( $renameColumns[$title]) ? $title : $renameColumns[$title];
				$html .= '</th>';
				$cols++;
			}
		}
		$html .= '</tr>';
		
		$i = 0;
		foreach($_data as $data){
			$bgColor = ++$i % 2 == 0 ? 'bgcolor="#FEFEFE"' : 'bgcolor="#EFEFEF"';
			$html .= '<tr  ' . $bgColor . '>';
				foreach($data as $field => $value){
					if( !in_array($field,$hiddenColumns) ){
						$html .= '<td>';
						if(!empty($callFunctions[$field]) && function_exists($callFunctions[$field]) ){
							$value = $callFunctions[$field]($data);
						}
						$html .= $value;
						$html .= '</td>';
					}
				}
			if(!empty($actionButtons)){
				//add action column
				$html .= '<td>';
				foreach($actionButtons as $actionButton){
					$href = $actionButton['href'];
					foreach($actionButton['hrefReplaceArr'] as $replace){
						$href = str_replace($replace['search'], $data[$replace['field_replace']],$href );
					}
					$html .= '<a href="' . $href . '"><img border="0" src="' . $actionButton['img'] . '" alt="' . $actionButton['alt'] . '" title="' . $actionButton['title'] . '" /></a> ';
				}
				$html .= '</td>';
			}
			$html .= '</tr>';
		}
		
			
		$html .= 
		'<td colspan="' . $cols . '" bgcolor="#BEBEBE">
		<table border="0" ><tr>
		<td width="45">P&aacute;gina:</td>
		<td align="left" width="480">' . printPager('formPager', $hiddenFields, 'paginacion','paginacion paginacionActual','', $k_groups ) . '</td>
		<td width="120"></td>
		<td width="50">
		';
		$html .= 
		'</td>
		</tr>
		</table>
		
		</td>
		</table>
		</div>
		';
	}	
	echo $html;
}
?>
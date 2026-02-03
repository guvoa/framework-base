<?php 

$url = $_PAYPAL_TEST ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
echo '<form action="'.$url.'" method="post" id="fId">';
	
	foreach($variables as $name=>$value){
		echo '<input type="hidden" value="'.$value.'" name="'.$name.'"  />';
	}
	
	echo 'En 5 segundos sera redireccionado al formulario de pago, si no es redireccionado de <input type="submit" value="click aqui">';

echo '</form>'

?>
<script language="javascript">
	window.setTimeout('document.getElementById("fId").submit();',5000);
</script>
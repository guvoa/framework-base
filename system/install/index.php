<?php
if( $_REQUEST['cmd'] == 'login')
{
	require_once('../lib.php');
	$r =DB_INTERFACE_Select('usuario',array('*'),
			array(
				array('condition'=>'email = "%s"',
					  'condition_values'=>array($_REQUEST["email"])
				)
			)
		);
	$r = $r[0];

	if( !empty($r) && $r["password"] == $_REQUEST["password"] ){
		$_SESSION['pasaporte'] = 1;
		header('location:Modulo.php');
		die();
		
	}else{
		$msjErr = 'Usuario o Contraseña Incorrectos';
	}
	
	
}
$header_title = 'Panel de Administracion';
require('header.php');

echo '<p style="color:#AA0000;margin-top:30px" align="center"><b>' . $msjErr . '</b></p>';
?>
<form method="post" action="" style="margin-top:10px;">
<input type='hidden' name='cmd' value='login' />
<table border="0" align="center" style="color: #888; font-size: 10pt;">
  <tr>
    <td>Usuario:</td>
    <td><input type="text" name="email" size="20"></td>
  </tr>
  <tr>
    <td>Contraseña:</td>
    <td><input type="password" name="password" size="20"></td>

  </tr>
  <tr>
    <td colspan="2" align="center">
    <input type="submit" value="Entrar" style="color: #FFFFFF; font-size: 8pt; border-style: solid; border-width: 1px; padding: 4px;background-color: #787878"> 
    </td>
  </tr>

</table>
</form>
<?php
require('footer.php');
?>
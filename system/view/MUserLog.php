<?php 
$params = Controller_GetViewParams();

$data = $params['data'];

$es_registro = $_REQUEST['cmd'] == 'registrar';

switch($_REQUEST['error_code']){
	case 2:$msj_error = 'El email elegido ya se encuentra existente en el sistema, ingrese con su contraseña en el <a href="user.php">acceso a usuarios</a> o elija otro email'; break;
	default:$msj_error = ''; break;
}

switch($_REQUEST['error_code']){
	case 10:$msj_error_log = 'Email o contraseña incorrecto'; break;
	case 11:$msj_error_log = 'Su sesion ha sido cerrada correctamente'; break;
	default:$msj_error_log = ''; break;
}
$msj_error = empty($_REQUEST['error_msj']) ? $msj_error : $_REQUEST['error_msj'];

//if(!empty($_REQUEST['error_code'])){
	$entity = $_REQUEST['entity'];
//}

include('MCartHeader.php'); 

?>
<style type="text/css">
	table.user_log, table.user_log td {
	    border: medium none;
	    border-collapse: collapse;
    	padding: 5px;
	}
</style>
<section id="content">
    <div class="container">
    	<div class="inside">
        <div class="indent">
        	<div class="wrapper">
        	  <div class="col-1">
            	<div class="indent">
				
<?php if(!$es_registro){ ?>
                <h2>Acceso a Usuarios</h2>
<?php
	if(!empty($msj_error_log)){
		echo '<p class="error">'.$msj_error_log . '</p>';
	}
?>
                Si ya cuenta con un email y contraseña de acceso ingrese su informacion para entrar al sistema
                <form action="" method="post">
                  <table border="0" cellspacing="0" cellpadding="5" class="user_log">
                    <tr>
                      <td width="10">&nbsp;</td>
                      <td width="178">&nbsp;</td>
                      <td width="200">&nbsp;</td>
                      <td width="52">&nbsp;</td>
                      <td width="348">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Email</td>
                      <td><input type="text" name="user" /></td>
                      <td>&nbsp;</td>
                      <td rowspan="3" valign="top">Olvido su contraseña? De <a href="MUserLog.php?cmd=recover_pwd"><strong>Clic Aquí</strong></a></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Contraseña</td>
                      <td><input type="password" name="password" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>
                       <input type="hidden" name="cmd" value="login" />
                      <input type="submit" value="Entrar" /></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                </form>
                 <p>&nbsp;</p>
                 <p>&nbsp;</p>
<?php } ?>
                 <h2>Registro de Usuarios</h2>
<?php
	if(!empty($msj_error)){
		echo '<p class="error">'.$msj_error . '</p>';
	}
?>
                 <p>Si no se ha registrado aún <strong>Regístrese Aquí</strong> es totalmente <strong>gratis</strong> y puede obtener múltiples beneficios por ser usario Alarm City.
                 Ingrese su información en el siguiente formulario.
                 </p>
                 <form action="user.php" method="post">
                 
                   <table border="0" cellspacing="0" cellpadding="5" class="user_log">
                    <tr>
                      <td width="10">&nbsp;</td>
                      <td width="206">&nbsp;</td>
                      <td width="202">&nbsp;</td>
                      <td width="284">&nbsp;</td>
                      <td width="86">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Nombre</td>
                      <td><input type="text" name="entity[nombre]" value="<?php echo $entity['nombre']; ?>" /></td>
                      <td>&nbsp;</td>
                      <td rowspan="3" valign="top">&nbsp;</td>
                    </tr>
                    
                     <tr>
                      <td>&nbsp;</td>
                      <td>Apellidos</td>
                      <td><input type="text" name="entity[apellidos]" value="<?php echo $entity['apellidos']; ?>" /></td>
                      <td>&nbsp;</td>
                      <td width="1" rowspan="3" valign="top">&nbsp;</td>
                    </tr>
                    
                    <tr>
                      <td>&nbsp;</td>
                      <td>Email</td>
                      <td><input type="text" name="entity[email]" value="<?php echo $entity['email']; ?>" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    
                     <tr>
                      <td>&nbsp;</td>
                      <td>Pais</td>
                      <td>                          <?php
                      echo '<select name="entity[pais]">';
					  foreach(GetCountries() as $country){
						  $selected = $estate['value']==$entity['pais'] ? 'selected="selected"' : '';
						echo '<option value="'.$country['value'].'" '.$selected.'>'.$country['label'].'</option>'; 
					  }
					  echo '</select>';
					  
					  ?>
</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Estado</td>
                      <td>
                      <?php
                      echo '<select name="entity[estado]">';
					  foreach(GetMXStates() as $estate){
 						$selected = $estate['value']==$entity['estado'] ? 'selected="selected"' : '';
						echo '<option value="'.$estate['value'].'" '.$selected.'>'.$estate['label'].'</option>'; 
					  }
					  echo '</select>';
					  
					  ?>
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Ciudad</td>
                      <td><input type="text" name="entity[ciudad]" value="<?php echo $entity['ciudad']; ?>" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Telefono</td>
                      <td><input type="text" name="entity[telefono]" value="<?php echo $entity['telefono']; ?>" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Direccion</td>
                      <td><input type="text" name="entity[direccion]" value="<?php echo $entity['direccion']; ?>" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Colonia</td>
                      <td><input type="text" name="entity[colonia]" value="<?php echo $entity['colonia']; ?>" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Codigo Postal</td>
                      <td><input type="text" name="entity[codigo_postal]" value="<?php echo $entity['codigo_postal']; ?>" /></td>
                      <td>&nbsp;</td>
                    </tr>
                    
                   
                    
                    
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>
                      <input type="hidden" name="cmd" value="registrar" />
                      <input type="submit" value="Registrar" /></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                </form>
              </div>
            </div>

<? include('estructura/INC_DETALLES.php'); ?>
        	</div>
        </div>
      </div>
    </div>
  </section>
  
<?php include('footer.php'); ?>
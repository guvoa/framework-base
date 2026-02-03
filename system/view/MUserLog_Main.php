<?php 
$params = Controller_GetViewParams();
$data = $params['data'];

$result = $_REQUEST['result'];


if(!$result['result']){
	$msj_error = $result['result_msj'];
}else{
	$msj_ok = 'Su informaci&oacute;n ha sido actualizada';
}
$entity = $_REQUEST['entity'];

include('MCartHeader.php'); 

?>
<style type="text/css">
	table, table td {
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

                 <h2>Bienvenido al Acceso de Usuarios <span style="color:#F00">Alarm City</span></h2>
                 
<?php
include('MUserLog_Header.php');
	if(!empty($msj_error)){
		echo '<p class="error">'.$msj_error . '</p>';
	}else{
		echo '<p style="color:#00AA00"><strong>'.$msj_ok . '</strong></p>';
	}
?>
<h3>Modificar Informacion</h3>
                 <p>Puede actualizar la informacion de su cuenta desde esta pagina.<br />
                 Modifique su información desde el siguiente formulario.
                 </p>
                 <form action="user.php" method="post">
                 
                   <table border="0" cellspacing="0" cellpadding="5">
                    
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
                      <td width="10">&nbsp;</td>
                      <td width="206">&nbsp;</td>
                      <td width="202">&nbsp;</td>
                      <td width="284">&nbsp;</td>
                      <td width="86">&nbsp;</td>
                    </tr>
                     <tr>
                      <td>&nbsp;</td>
                      <td>Cambiar Contraseña?</td>
                      <td><input type="password" name="entity[password]" value="" /></td>
                      <td>&nbsp;</td>
                      <td rowspan="3" valign="top">&nbsp;</td>
                    </tr>
                     <tr>
                      <td width="10">&nbsp;</td>
                      <td width="206">&nbsp;</td>
                      <td width="202">&nbsp;</td>
                      <td width="284">&nbsp;</td>
                      <td width="86">&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>
                      <input type="hidden" name="cmd" value="user_modify" />
                      <input type="submit" value="Actualizar Informacion" /></td>
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
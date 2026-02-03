<?php 
$params = Controller_GetViewParams();

$data = $params['data'];

$es_registro = $_REQUEST['cmd'] == 'registrar';

switch($_REQUEST['error_code']){
	case 1:$msj_ok = 'Su acceso ha sido enviado a su Email'; break;
	case 2:$msj_error = 'El email ingresado no se encuentra registrado, intente nuevamente'; break;
	default:$msj_error = ''; break;
}


include('MCartHeader.php'); 

?>
<style type="text/css">
	table, table td {
	    border: medium none;
	    border-collapse: collapse;
    	padding: 5px;
	}
	.ok{ font-size:18px; color:#00AA00; font-weight:bold;}
</style>
<section id="content">
    <div class="container">
    	<div class="inside">
        <div class="indent">
        	<div class="wrapper">
        	  <div class="col-1">
            	<div class="indent">
				

                 <h2>Recuperacion de Contraseña</h2>
<?php
	if(!empty($msj_error)){
		echo '<p class="error">'.$msj_error . '</p>';
	}
	if(!empty($msj_ok)){
		echo '<p class="ok">'.$msj_ok . '</p>';
	}
?>
                 <p>
                 Ingrese su email para recuperar su contraseña.
                 </p>
                 <form action="user.php" method="post">
                 
                   <table border="0" cellspacing="0" cellpadding="5">
            
                    <tr>
                      <td width="98">Email</td>
                      <td width="310"><input type="text" name="entity[email]" value="<?php echo $entity['email']; ?>" /></td>
                      <td width="284">&nbsp;</td>
                    </tr>
                    
                    
                    
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>
                      <input type="hidden" name="cmd" value="recover_pwd" />
                      <input type="hidden" name="send" value="1" />
                      <input type="submit" value="Enviar Contraseña" /></td>
                      <td>&nbsp;</td>
                      <td width="86">&nbsp;</td>
                    </tr>
                    <tr>
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
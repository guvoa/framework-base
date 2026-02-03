<?php 
$params = Controller_GetViewParams();

$data = $params['data'];

switch($_REQUEST['error_code']){
	case 2:$msj_error = 'El email elegido ya se encuentra existente'; break;

	default:$msj_error = ''; break;
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
	}
?>
<h3>Detalles de una Órden</h3>
<?php
include('MCartPurchase_ViewOder.php');
?>

              </div>
            </div>

<? include('estructura/INC_DETALLES.php'); ?>
        	</div>
        </div>
      </div>
    </div>
  </section>
  
<?php include('footer.php'); ?>
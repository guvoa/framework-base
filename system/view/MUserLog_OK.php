<?php 
$params = Controller_GetViewParams();

$data = $params['data'];

$es_registro = $_REQUEST['cmd'] == 'registrar';

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
     
                <div style="background:url(images/f.jpg); background-repeat:repeat-x; width:600px; height:80px">
<img src="images/ok.jpg" height="80" width="92" align="middle" />
<h2 style="margin-top:30px; float:right;padding-right:240px;">Registro Completo</h2>

</div>
<br />
                Su registro se ha efectuado exitosamente, en unos segundos será redireccionado. 
                <br />Si no es redireccionado por favor de <a href="user.php"><strong>click aqui</strong></a>
<script language="javascript">
window.setTimeout('document.location.href="user.php";',3000);
</script>
              </div>
            </div>

<? include('estructura/INC_DETALLES.php'); ?>
        	</div>
        </div>
      </div>
    </div>
  </section>
  
<?php include('footer.php'); ?>
<?php
$header_title = isset($header_title) ? '<br /><h2>' . $header_title . '</h2>' : '';

$header_msj_class = isset($header_msj) ? $header_msj_class : '';
$header_msj = isset($header_msj) ? '<p class="' . $header_msj_class . '" align="center">' . $header_msj . '</p>' : '';
?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Panel de Administración</title>
<style type="text/css">
@import url('css/estilos.css');
</style>

</head>
<body>
<div align="center">

<div style="width:800px;" align="center">
<div style="width:100%;" align="left">
	<div style="color:#990000;font-family: Arial; font-size:20pt; "><img src="../../img/logo.jpg" width="250" height="88"></div>
	<div style="width:100%;background-color:#466284; height:20px; margin-right:10px;" align="right" >

	<?php
	if( $_SESSION['pasaporte'] == 1){
	?>
	<div style="float:left;" class="blanco">	
	Bienvenido  | 
    <a href="logout.php" class="blanco none">Cerrar Sesión</a> 
	</div>
	<a href="galeria.php" class="blanco none">Galerias</a> |  
	<?php
	}
	?>
    </div>
	<?php echo $header_title; ?>
<?php echo $header_msj; ?>
<p style="margin-bottom:20px"></p>

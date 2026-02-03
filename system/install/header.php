<?php
require_once('../lib.php');

//$header_title = isset($header_title) ? '<br /><h2>' . $header_title . '</h2>' : '';

//$header_msj_class = isset($header_msj) ? $header_msj_class : '';
//$header_msj = isset($header_msj) ? '<p class="' . $header_msj_class . '" align="center">' . $header_msj . '</p>' : '';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Conjunction 
Description: A two-column, fixed-width design for 1024x768 screen resolutions.
Version    : 1.0
Released   : 20100328

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Sistema Generador Web</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
	<div id="logo">
		<h1>Sistema Generador Web</h1>
		<p><em> Instalaci<a href="http://www.freecsstemplates.org/"></a></em>ón y configuración de módulos para la creación y mantenimiento de aplicaciones Web</p>
	</div>
	<hr />
	<!-- end #logo -->
	<div id="header">
		<div id="menu">
			<ul>
            <?php
	if( $_SESSION['pasaporte'] == 1){
	?>
	<ul>
				  <li><a href="Modulo.php" class="first">Administrar Módulos</a></li>
			  </ul>
	<?php
	}else{
	?>
				<ul>
				  <li><a href="#" class="first">Inicio</a></li>
			  </ul>
				<li><a href="#">Noticias</a></li>
				<li><a href="#">Documentación</a></li>
				<li><a href="#">Descarga</a></li>
<?php
	}
	?>                
			</ul>
</div>
		<!-- end #menu -->
		<div id="search">
			<?php
	if( $_SESSION['pasaporte'] == 1){
	?>
    <a href="logout.php" class="blanco none" style="margin-right:5px;">Cerrar Sesión</a>
    <?php
	}else{
	?><form method="get" action="">
				<fieldset>
				<input type="text" name="s" id="search-text" size="15" />
				<input type="submit" id="search-submit" value="GO" />
				</fieldset>
			</form><?php
	}
	?>
		</div>
		<!-- end #search -->
	</div>
	<!-- end #header -->
	<!-- end #header-wrapper -->
	<div id="page">
		<div id="content">
		  <div class="post">
				<h2 class="title"><a href="#"><?php echo $header_title; ?></a></h2>
				<p class="meta"><?php echo $header_msj; ?></p>
				<div class="entry">
					<p>
                    
                    
                    
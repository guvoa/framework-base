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
<div align="left">
<?php echo $header_msj; ?>
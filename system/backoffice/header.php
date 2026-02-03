<?php
require_once '../lib.php';

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

        .azul {}

        .tit {}
    </style>

</head>

<body>
    <div align="center">
        <div style="width:900px;" align="center">
            <div style="width:100%;" align="left">
                <div style="color:#06529D;font-family: Arial; font-size:18pt; ">
                    <table width="100%">
                        <tr>
                            <td width="10%" valign="top">
                                <a href="index.php"><img src="../../images/logo.jpg" border="0" align="absmiddle"></a>
                            </td>
                            <td width="55%">
                                <div style="color:#8E5216;font-family: Arial; font-size:16pt; ">
                                    Sistema de Administración</div><br />
                                Sitio: alarm-city.com<br />
                                Renovacion de Servicio: 2013-01-25<br />

                            </td>
                            <td width="12%" align="center" valign="top"><img src="img/support.gif" width="24"
                                    height="24"><br>
                                <strong>Información de Contacto</strong><br>
                            </td>
                            <td width="23%">
                                <div id="logo"> <a href="http://cedeweb.com/index.php"><img
                                            src="http://cedeweb.com/logo.jpg" alt="CEDEWEB - Diseño y Programacion Web"
                                            width="125" border="0" height="50"></a></div>
                                <div id="direccion"> Andador los Ciruelos 8919-1 <br>
                                    Col. Mateo de Regil, Puebla Pue. Mexico <br>
                                    info@cedeweb.com <br>
                                    Teléfono: (222) 888 03 63 </div>
                            </td>
                        </tr>
                    </table>

                </div>
                <div style="width:100%; background-color:#353430; height:26px; margin-right:10px; margin-top:5px;"
                    align="right">

                    <?php
                    if ($_SESSION['pasaporte'] == 1) {
                        ?>
                        <div style="float:left;width:100%" class="blanco">
                            <table width="100%" border="0" align="left" cellpadding="0" cellspacing="2">
                                <tr>
                                    <td width="790">
                                        <table width="100%" align="left">
                                            <tr>
                                                <td><a href="index.php" class="blanco none">Inicio</a></td>
                                                <td><a href="MCartProducto.php" class="blanco none">Productos</a></td>
                                                <td><a href="MUserlogUser.php" class="blanco none">Clientes</a></td>
                                                <td><a href="Order.php" class="blanco none">Administrar Órdenes</a></td>
                                                <!--MENU-->
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="110" align="right"><a href="logout.php" class="blanco none"
                                            style="margin-right:5px;">Cerrar Sesión</a></td>
                                </tr>
                            </table>

                        </div>
                    <?php } ?>
                </div>
                <?php echo $header_title; ?>
                <?php echo $header_msj; ?>
                <p style="margin-bottom:20px"></p>
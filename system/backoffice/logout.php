<?php
@session_start();
unset($_SESSION['pasaporte']);
unset($_SESSION);
session_destroy();
header("location:index.php");
die();
?>
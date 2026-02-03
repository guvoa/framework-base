<?php
@session_start();
if( $_SESSION['pasaporte'] != 1){
	header("location:index.php");
	die();
}
?>
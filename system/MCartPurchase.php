<?php
require_once('system/lib.php');


$args['controller_file'] = 'MCartCart.php';
$args['view_dir'] = 'system/view/';

$args['table_name'] = $args['table_name_list'] = 'm_cart_producto';

$args['table_id'] = 'm_cart_producto_id';

$args['model_select_fields']= array('*');
$args['model_search_fields'] = array('titulo','descripcion');
$_REQUEST['o'] ='';

$extraConditions =array();

$cmd =  $_REQUEST['cmd'];
switch($cmd){
	
	
	//PASO 3
	case 'Finalizar Compra y Pagar':
		//realizamos validacion de usuario
		//si cumple con validacion generar orden 
		
		//verificar que el usuario esta logueado
		//
		$result = MCart_Purchase_SetUser($_REQUEST['entity']);

		if($result['result']){
			//validamos que el carrito no este vacio, si esta vacio redireccionar
			if(MCart_IsEmpty()){
				header('location:MCartCart.php');
				die;
			}
			$result = MCart_Purchase_CreateOrder($_REQUEST['forma_pago'], $_REQUEST['comentarios']);
			$result_code = is_array($result) ? $result['result_code'] : $result;

			if($result_code == 1){
				//almacenamos el usuario en el parametro view
				$_REQUEST['entity'] = MCart_Purchase_GetUser();
				$_REQUEST['orden'] = $result['order'];
				$args['view_file'] = 'MCartPurchaseComplete.php';
				
				//vaciar sesion orden de compra
				MCart_EmptyCartSession();
				
			}else{
				if($result_code == 0){
					$_REQUEST['cmd'] = 'guardar_envio';
					$_REQUEST['entity'] = MCart_Purchase_GetUser();
					$_REQUEST['msj_error'] = 'Intente Nuevamente';
					$args['view_file'] = 'MCartPurchase.php';	
				}elseif($result_code == -2){
					$_REQUEST['activate_login']=1;
					$_REQUEST['cmd'] = '';
					$_REQUEST['entity'] =$_REQUEST['entity'];
					$_REQUEST['msj_error'] = 'El email ingresado ya esta registrado en el sistema, ingrese sus datos de acceso en la parte inferior para continuar';
					$args['view_file'] = 'MCartPurchase.php';
				}else{
					$_REQUEST['cmd'] = '';
					$_REQUEST['entity'] = $_REQUEST['entity'];
					$_REQUEST['msj_error'] = 'Verifique los datos enviados porfavor';
					$args['view_file'] = 'MCartPurchase.php';	
				}
			}
		}else{
			$_REQUEST['cmd'] = '';
			$_REQUEST['entity'] = $result['user'];
			$_REQUEST['msj_error'] = $result['result_msj'];
			$args['view_file'] = 'MCartPurchase.php';	
		}
	break;
	
	
	//PASO 2
	case 'guardar_envio':
		$continue = true;
		if($_REQUEST['sending_contrasena']){
			//intentamos loguear al usuario
			$logIn = MUserLog_LogIn($_REQUEST['entity']['email'],$_REQUEST['contrasena']);
			
			if(!$logIn){
				$_REQUEST['activate_login_fail'] = 1;
				$_REQUEST['activate_login'] = 1;
				$_REQUEST['cmd'] = '';
				$_REQUEST['entity'] = $_REQUEST['entity'];
				$args['view_file'] = 'MCartPurchase.php';	
				$continue = false;
			}
		}
		if($continue){
			//realizamos validacion de usuario
			//si cumple con validacion continua ultimo paso
			$result = MCart_Purchase_SetUser($_REQUEST['entity']);
	
			if($result['result']){
				//almacenamos el usuario en el parametro view
				$_REQUEST['entity'] = MCart_Purchase_GetUser();
				$args['view_file'] = 'MCartPurchase.php';	
			}else{
				$_REQUEST['cmd'] = '';
				$_REQUEST['entity'] = $result['user'];
				$_REQUEST['msj_error'] = $result['result_msj'];
				$args['view_file'] = 'MCartPurchase.php';	
			}
		}
	break;
	
	//PASO 1
	default:
		//$_REQUEST['entity'] = empty($_REQUEST['entity']) ? MUserLog_getUserLog() : $_REQUEST['entity'];
		$_REQUEST['entity'] = MCart_Purchase_GetUser();
		$args['view_file'] = 'MCartPurchase.php';	
	break;
}

Controller_Execute($cmd, $args);

?>
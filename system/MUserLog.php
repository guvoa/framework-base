<?php
require_once('system/lib.php');


$args['controller_file'] = 'MUserLog.php';
$args['view_dir'] = 'system/view/';

$args['table_name'] = $args['table_name_list'] = 'm_userlog_user';

$args['table_id'] = 'm_userlog_user_id';

$args['model_select_fields']= array('*');
$args['model_search_fields'] = array('nombre','telefono');
$_REQUEST['o'] ='';

$extraConditions =array();

$cmd =  $_REQUEST['cmd'];

switch($cmd){
	case 'view_orders':
		//verificamos si el modulo de ususarios logueo al usuario
		MUserLog_ValidatePassportRedirect();
		$_REQUEST['entity'] = MUserLog_getUserLog();
		$args['view_file'] = 'MCartPurchase_Orders.php';	
	break;
	case 'view_order':
		//verificamos si el modulo de ususarios logueo al usuario
		MUserLog_ValidatePassportRedirect();
		$order_id = $_REQUEST['id'];
		$_REQUEST['order'] = DB_INTERFACE_LoadById('m_cart_order','m_cart_order_id',$order_id);
		$_REQUEST['entity'] = DB_INTERFACE_LoadById('m_userlog_user','m_userlog_user_id',$_REQUEST['order']['m_userlog_user_id']);
		
		$userSession = MUserLog_getUserLog();
		
		
		if($userSession['m_userlog_user_id'] == $_REQUEST['entity']['m_userlog_user_id']){
			$args['view_file'] = 'MCartPurchase_ViewOrderDetails.php';	
		}else{
			$_REQUEST['cmd']='';
			unset($_REQUEST['order']);
			$_REQUEST['entity'] = $userSession;
			$args['view_file'] = 'MUserLog_Main.php';
		}
	break;
	
	case 'user_modify':
		//verificar logueo de usuario
		MUserLog_ValidatePassportRedirect();
		if(empty($_REQUEST['entity']['password'])){
			unset($_REQUEST['entity']['password']);
		}
		$result = MUserLog_RegisterUser($_REQUEST['entity'],true,true);
		$_REQUEST['result'] = $result;
		unset($_REQUEST['entity']['password']);
		$args['view_file'] = 'MUserLog_Main.php';
	break;
	
	case 'registrar_ok':
		$args['view_file'] = 'MUserLog_OK.php';
	break;
	case 'recover_pwd':
		//mostrar interfaz de logueo
		if($_REQUEST['send'] == 1){
			$result = MUserLog_getUserByUser($_REQUEST['entity']['email']);
			if(empty($result)){
				$_REQUEST['error_code'] = 2;
			}else{
				//ENVIAMOS EMAIL
				
				$content = 'Gracias por utilizar Alarm City sus datos de acceso son los siguientes:<br /><br />
		Link de Acceso: <a href="'. ABS_HTTP_URL .'user.php">'. ABS_HTTP_URL .'user.php</a><br /><br />
		usuario: '.$result['email'].'<br />
		contraseña: '.$result['password'].'
		';
				lib_sendEmail($result['email'],'Recuperacion de contraseña',$content);
				$_REQUEST['error_code'] = 1;
			}
		}
		$args['view_file'] = 'MUserLog_RecoverPwd.php';
	break;
	
	case 'registrar':
		$existe = MUserLog_ExisteUser($_REQUEST['entity']['email']);
		if(!$existe){
			//mostrar interfaz de logueo
			$result = MUserLog_RegisterUser($_REQUEST['entity'],false,true);
			if($result['result']){
				header('location:user.php?cmd=registrar_ok&redirect_code=' . $_REQUEST['redirect_code']);
				die();
			}
		}

		$_REQUEST['error_msj'] = $result['result_msj'];
		$_REQUEST['error_code'] = $existe ? '2' : $result;
		$_REQUEST['entity'] = $_REQUEST['entity'];
		$args['view_file'] = 'MUserLog.php';
	break;
	case 'logout':
		MUserLog_LogOut();
		$_REQUEST['error_code'] == 11;
		$args['view_file'] = 'MUserLog.php';
	break;
	case 'login':
		$redirect = $_REQUEST['redirect'];

		$user = $_REQUEST['user'];
		$password = $_REQUEST['password'];
		$result = MUserLog_LogIn($user,$password);

		if($result){
			if($redirect == 'purchase'){
				$_REQUEST['msj_ok'] = 1;
			}else{
				header('location:user.php');
				die;
			}
		}else{
			$_REQUEST['error_code'] = 10;
			$args['view_file'] = 'MUserLog.php';
		}
	break;
	default:
		if(MUserLog_ValidatePassport()){
			//mostramos pagina de inicio del usuario
			$_REQUEST['entity'] = MUserLog_getUserLog();
			unset($_REQUEST['entity']['password']);
			$args['view_file'] = 'MUserLog_Main.php';

		}else{
			//mostrar interfaz de logueo
			$args['view_file'] = 'MUserLog.php';
		}
	break;
}

Controller_Execute($cmd, $args);

?>
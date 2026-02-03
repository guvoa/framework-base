<?php

	define('MUSERlOG_NAME_SPACE','MUserLog');
	


//USER LOG FUNCTIONS
	function MUserLog_getUserByUser($user){
		if(empty($user)){return false;}
		$r =DB_INTERFACE_Select('m_userlog_user',array('*'),
				array(
					array('condition'=>'user = "%s"',
						  'condition_values'=>array($user)
					)
				)
			);
		return $r[0];
	}
	
	function MUserLog_getUserLog(){
		return $_SESSION[MUSERlOG_NAME_SPACE];
	}



	function MUserLog_LogIn($user,$password){
		$user = MUserLog_getUserByUser($user);
 		if(empty($user)){return false;}
		if( $user["password"] == $password ){
			$_SESSION[MUSERlOG_NAME_SPACE] = $user;
			$_SESSION[MUSERlOG_NAME_SPACE]['m_userlog_pasaporte'] = 1;

			return true;
		}
		return false;
	}
	
	function MUserLog_ValidatePassport(){
		//aqui se pueden poner diferentes reglas de acceso
		//incluso validar roles
		return $_SESSION[MUSERlOG_NAME_SPACE]['m_userlog_pasaporte'] == 1;
	}
	
	function MUserLog_ValidatePassportRedirect($faultRedirect = 'user.php'){
		if(!MUserLog_ValidatePassport()){
			header('location:' . $faultRedirect);
			die();
		}
	}
	
	function MUserLog_LogOut(){
		unset($_SESSION[MUSERlOG_NAME_SPACE]['m_userlog_pasaporte']);
		unset($_SESSION[MUSERlOG_NAME_SPACE]);
		//unset($_SESSION);
		//session_destroy();
	}
	
	
	function MUserLog_RegisterUser($user, $updateInfo = false, $startSession = false){
		$result = MUserLog_ValidateUserInfo($user, $updateInfo);
		
		if(!$result['result']){return $result;}
		$user = $result['user'];
		if($updateInfo){
			DB_INTERFACE_Save( 'm_userlog_user', $user, array('m_userlog_user_id'=>$user['m_userlog_user_id']) );
		}else{
			DB_INTERFACE_Save( 'm_userlog_user', $user);
		}
		
		if($startSession ){
			//MUserLog_LogIn($user['email'],$user['password']);
			if(!$updateInfo){
				$user['m_userlog_user_id'] = mysql_insert_id();
			}
			$_SESSION[MUSERlOG_NAME_SPACE] = $user;
			$_SESSION[MUSERlOG_NAME_SPACE]['m_userlog_pasaporte'] = 1;
		}
		//se envia un email
		MUserLog_SendEmailBienvenida($user);
		return $result; 
	}
	
	function MUserLog_SendEmailBienvenida($user){
		$content = 'Bienvenido a Alarm City, gracias por registrarse en nuestro sistema.<br /> Apartir de este momento ud. puede revisar 
		sus órdenes de compra con los siguientes accesos:<br /><br />
		Link de Acceso: <a href="'. ABS_HTTP_URL .'user.php">'. ABS_HTTP_URL .'user.php</a><br /><br />
		usuario: '.$user['email'].'<br />
		contraseña: '.$user['password'].'
		';
		lib_sendEmail($user['email'],'Bienvenido a Alarm City',$content);
	}
	
	function MUserLog_ValidateUserInfo($user, $updateInfo = false){
		$result = array('result'=>true,'result_code'=>1,'result_msj'=>'', 'user'=>$user);
		
		$fields = array('password','nombre','apellidos',
		'email','pais','estado','ciudad','telefono','direccion','colonia','codigo_postal','user');
		$user['user'] = $user['email'];
		
		if($updateInfo){
			$fields[] ='m_userlog_user_id';
			$actualUser = MUserLog_getUserLog();
			$user['m_userlog_user_id'] = $actualUser['m_userlog_user_id'];
			$user['password'] = empty($user['password']) ? $actualUser['password'] : $user['password'];

		}else{
			$user['password'] = RandomString(8);
		}
		foreach($fields as $field){
			$user[$field] = strip_tags(!isset($user[$field]) ? '' : $user[$field]);
			
			$max_car = $field == 'direccion' ? 80 : 25;
			$max_car = $field == 'email'||$field =='user' ? 0 : $max_car;
			$validation_type = $field == 'email'||$field =='user' ? 'email' : 'string';
			$result = MUserLog_ValidarCampo($field,$user[$field],$max_car, true,$validation_type);
			if(!$result['result']){break;}
		}
		/*
		if($result['result']){
			$field = 'email';
			$result = MUserLog_ValidarCampo($field,$user[$field],70, true,'email');
		}*/
		
		foreach($user as $field){
			if(!in_array($fields)){
				unset($user[$field]);
			}
		}
		$result['user'] = $user;
		return $result;
	}
	
	function MUserLog_ValidarCampo($label,$val,$max=0, $requerido = true,$tipo='string'){
		$result = MUserLog_ValidarTamano($label,$val,$max, $requerido);
		if(!$result['result']){return $result;}
		return MUserLog_ValidarTipo($label,$val, $tipo);
	}
	
	function MUserLog_ValidarTamano($label,$val,$max=0, $requerido = true){
		$result = true;
		if((!empty($max) && strlen($val) > $max) || ($requerido && (empty($val) || strlen($val) ==0) ) ){
			$txtMax = empty($max) ? '' : ' no debe se mayor a '.$max.' caracteres ';
			$yTxt = empty($max) ? '' : ' y';
			$result_msj = ('El parametro '.$label. $txtMax . ($requerido ? ($yTxt.' no debe ser nulo') : '') );
			$result = false;
		}
		return array('result'=>$result,'result_msj'=>$result_msj,'val'=>$val);
	}

	function MUserLog_ValidarTipo($label,$val, $tipo='string'){
		$valido = '';
		$result = true;
		switch($tipo){
			default:
			case 'string':
				$result = is_string($val);
			break;
			case 'integer':
				$val = (int)$val;
				$result = is_int($val);
			break;
			case 'decimal':
				$val = (float)$val;
				$result = is_float($val);
			break;
			case 'datetime':
				$time = strtotime($val);
				$result = checkdate(date('m',$time),date('d',$time),date('Y',$time));
				
				$result = $result && date('Y-m-d',$time) != '1969-12-31';
				$val = date('Y-m-d H:i:s',$time);
				$valido = 'valido';
			break;
			case 'email':
				$pattern = '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])' .
				'(([a-z0-9-])*([a-z0-9]))+' . '(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i';
				$result = preg_match($pattern, $val);
				$tipo = 'Email V&aacute;lido';
			break;
		}
		if(!$result){
			$result_msj = ('El parametro '.$label.' debe ser de tipo ('.$tipo.') ' . $valido ); 
		}
		return array('result'=>$result,'result_msj'=>$result_msj,'val'=>$val);
	}
	
	function MUserLog_ExisteUser($email){
		$extra_contidions = array();
		$extra_contidions[] = array('condition'=>'email= "%s"','condition_values'=>array($email) );
		$reg = DB_INTERFACE_Select('m_userlog_user',array('*'),$extra_contidions,
			array()
			,1,1 );
		$reg = is_array($reg) && !empty($reg);
		return $reg;
	}
?>
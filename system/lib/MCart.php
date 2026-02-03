<?php

	define('MCART_NAME_SPACE','MCart');
	


//CART FUNCITIONS
	function MCart_getCart(){
		return $_SESSION[MCART_NAME_SPACE];
	}
	function MCart_getTotal(){
		return MCart_getTotalItems() + MCart_getTotalExtras();
	}
	function MCart_getTotalItems(){
		$t = 0;
		foreach( MCart_getItems() as $item){
			$t += $item['total']; 
		}
		return $t;
	}
	
	function MCart_getTotalExtras(){
		$t = 0;
		foreach( MCart_getExtraCharges() as $item){
			$t += $item['monto']; 
		}
		return $t;
	}
//ITEMS FUNCTIONS
	function MCart_IsEmpty(){
		$items = MCart_getItems();
		return empty($items);
	}
	function MCart_getItems(){
		return $_SESSION[MCART_NAME_SPACE]['items'];
	}
	
	function MCart_addItem($itemId,$quantity=1){
		$quantity = is_numeric($quantity) && $quantity > 0 ? $quantity : 1;
		if( MCart_ItemExists($itemId) ){
			$quantity = $_SESSION[MCART_NAME_SPACE]['items'][$itemId]['cantidad'] + $quantity;
			MCart_UpdateQtyItem($itemId,$quantity);
		}else{
			$productoObj = DB_INTERFACE_LoadById('m_cart_producto','m_cart_producto_id',$itemId);
			if(!empty($productoObj)){
				$item['titulo'] = $productoObj['titulo'];
				$item['precio'] = $productoObj['precio'];
				$item['codigo'] = $productoObj['codigo'];
				$item['peso_grs'] = $productoObj['peso_grs'];
				$item['imagen'] = $productoObj['imagen'];
				
				$item['m_cart_producto_id'] = $itemId;
				$item['cantidad'] = $quantity;
				
				$item['total'] = $quantity * $item['precio'];
				
				$_SESSION[MCART_NAME_SPACE]['items'][$itemId] = $item;
			}
		}
	}
	
	
	function MCart_RemoveItem($itemId){
		unset($_SESSION[MCART_NAME_SPACE]['items'][$itemId]);
	}
	
	function MCart_UpdateQtyItem($itemId,$quantity){
		$quantity = is_numeric($quantity) && $quantity > 0 ? $quantity : 1;
		if(isset($_SESSION[MCART_NAME_SPACE]['items'][$itemId])){
			$_SESSION[MCART_NAME_SPACE]['items'][$itemId]['cantidad'] = $quantity;
			
			$_SESSION[MCART_NAME_SPACE]['items'][$itemId]['total'] = $quantity * $_SESSION[MCART_NAME_SPACE]['items'][$itemId]['precio'];
		}
	}
	
	function MCart_ItemExists($productoId){
		foreach( MCart_getItems() as $item){
			if($item['m_cart_producto_id'] == $productoId){
				return true;
			}
		}
		return false;
	}
	

	function MCart_getExtraCharges(){
		$extras = array();
		
			$extras[] = array('nombre'=>'Env&iacute;o','monto'=>MCart_Purchase_GetCostoEnvio());
		
		return $extras;
	}

//PURCHASE FUNCTIONS
	function MCart_Purchase_GetUser(){
		$user = $_SESSION[MCART_NAME_SPACE]['user'];
		return !empty($user) ? $user : MUserLog_getUserLog();
	}
	
	function MCart_Purchase_SetUser($user){
		$result = MUserLog_ValidateUserInfo($user);
		if($result['result']){
			$_SESSION[MCART_NAME_SPACE]['user']=$user;
		}
		return $result;
	}	
	
	function MCart_Purchase_GetCostoEnvio(){
		$ngrs = 5000;
		$costo_cada_ngrs = 99;
		
		$peso = ceil( MCart_Purchase_GetTotalGrs() / $ngrs );
		return ($peso <1 ? 1 : $peso) * $costo_cada_ngrs;
	}
	function MCart_Purchase_GetTotalGrs(){
		$peso = 0; //peso en grs
		
		$items = MCart_getItems();
		foreach($items as $item){
			$peso += $item['peso_grs'] * $item['cantidad'];
		}
		return $peso;
	}
	
	
	function MCart_Purchase_CreateOrder($metodo_pago, $comments){
		$userLog = MUserLog_getUserLog();
		$user = MCart_Purchase_GetUser();
		
		if(empty($userLog) || $user['email'] != $userLog['email']){
			//preguntamos si el email ingresado existe en el sistema
			//si no existe REGISTRAR usuario LOGUEAR y CONTNUAR, si existe en el sistema regresar error
			$existe = MUserLog_ExisteUser($user['email']);
			if($existe){
				//regresar a paso 1 captura datos de envio 
				//se mostrara campo de password y mensaje 'Ingrese su contraseña'
				return -2;
			}
			
			//si no se encuentra en el sistema intentamos registrar
			$result = MUserLog_ValidateUserInfo($user);
			if(!$result['result']){
				//regresar a paso 1 captura datos de envio correctamente
				//se mostrara mensaje 'Verifique los datos enviados porfavor'
				return -1;
			}
			
			//guardamos usuario, logueamos y continuamos
			DB_INTERFACE_Save('m_userlog_user', $result['user']);
			
			//enviamos email de bienvenida, junto con acceso a sistema
			MUserLog_SendEmailBienvenida($result['user']);
			MUserLog_LogIn($result['user']['email'],$result['user']['password']);
			$userLog = MUserLog_getUserLog();
		}
		
		$result = MUserLog_ValidateUserInfo($user);
		if(!$result['result']){
			return false;
		}
		$campos = array('nombre','apellidos','email','pais','estado','ciudad','telefono','direccion','colonia','codigo_postal');
		foreach($user as $k=>$v){
			if(!in_array($k,$campos)){
				unset($user[$k]);
			}
		}
		//verificamos que exista un usuario logueado
		$user['m_userlog_user_id'] = $userLog['m_userlog_user_id'];
		$user['fecha_compra'] = date('Y-m-d H:i:s');
		$user['comentarios'] = $comments;
		$user['estatus'] = 'Pendiente';
		$user['forma_pago'] = $metodo_pago;
		
		DB_INTERFACE_Save('m_cart_order', $user);
		$order_id = mysql_insert_id();
		
		if(!empty($order_id)){
			//almacenamos los items
			foreach(MCart_getItems() as $item){
				$item['m_cart_order_id'] = $order_id;
				unset($item['total']);
				DB_INTERFACE_Save('m_cart_order_item', $item);
			}
			
			foreach(MCart_getExtraCharges() as $extra){
				$extra['m_cart_order_id'] = $order_id;
				DB_INTERFACE_Save('m_cart_order_extracharger', $extra);
			}
			
		$content = 'Se ha registrado su &oacute;rden de compra exitosamente puede ver los detalles actualizados de su &oacute;rden en cualquier momento desde el 
		siguiente link de Acceso: <a href="'. ABS_HTTP_URL .'user.php?cmd=view_order&id='.$order_id.'">'. ABS_HTTP_URL .'user.php?cmd=view_order&id='.$order_id.'</a><br /><br />
		Acontinuacion le presentamos las caracteristicas de su pedido:<br />
		';
		
		$content_admin = 'Se ha generado una nueva &oacute;rden de compra puede modificar el estatus de esta &oacute;rden desde el siguiente link de Acceso: 
		<a href="'. ABS_HTTP_URL .'system/backoffice/Order.php?cmd=edit&id='.$order_id.'">'. ABS_HTTP_URL .'system/backoffice/Order.php?cmd=edit&id='.$order_id.'</a><br /><br />
		Acontinuacion le presentamos las caracteristicas del pedido:<br />
		';
		$user['m_cart_order_id'] = $order_id;
		ob_start();
			$_REQUEST['order'] = $user;
			require('test.php');
		$htmlPedido = ob_get_contents();
		$content .= $htmlPedido;
		$content_admin .=$htmlPedido;
		ob_end_clean();
			lib_sendEmail($user['email'],'Nueva Orden de Compra No. ' . $order_id ,$content);
			lib_sendEmail(EMAIL_CLIENTE,'Nueva Orden de Compra No. ' . $order_id ,$content_admin);
			
			return array('result_code'=>1,'order'=>$user);
		}
		
		return 0;
	}

function MCartPurchase_GetOrdersByUser($user_id){
	$extra_contidions = array();
	$extra_contidions[] = array('condition'=>'m_userlog_user_id = "%s"','condition_values'=>array($user_id) );
	$reg = DB_INTERFACE_Select('m_cart_order',array('*'),$extra_contidions,
	array( 'order'=>'%s DESC','order_values'=>array('fecha_compra') )
	,1,-1 );
	return $reg;
}

function MCartPurchase_GetOrderItemsByOrderId($order_id){
	$extra_contidions = array();
	$extra_contidions[] = array('condition'=>'m_cart_order_id= %s','condition_values'=>array($order_id) );
	$reg = DB_INTERFACE_Select('m_cart_order_item',array('*'),$extra_contidions,
	array( 'order'=>'%s DESC','order_values'=>array('m_cart_order_item_id') )
	,1,-1 );
	return $reg;
}

function MCartPurchase_GetExtraChargesByOrderId($order_id){
	$extra_contidions = array();
	$extra_contidions[] = array('condition'=>'m_cart_order_id= %s','condition_values'=>array($order_id) );
	$reg = DB_INTERFACE_Select('m_cart_order_extracharger',array('*'),$extra_contidions,
	array( 'order'=>'%s DESC','order_values'=>array('m_cart_order_extracharger_id') )
	,1,-1 );
	return $reg;
}

function MCart_GetOrderById($id){
	//$result['order'] = DB_INTERFACE_LoadById('m_cart_order','m_cart_order_id',$id);
	return DB_INTERFACE_LoadById('m_cart_order','m_cart_order_id',$id);
}

function MCart_GetTotalOrderById($id){
	$total = 0;
	$order = MCart_GetOrderById($id);
	foreach( MCartPurchase_GetOrderItemsByOrderId($id) as $item){
			$total += ($item['precio'] * $item['cantidad']); 
		}
		
	foreach( MCartPurchase_GetExtraChargesByOrderId($id) as $extra){
		$total += ($extra['monto']); 
	}
	
	return $total; 
}

function MCart_SetOrderStatus($orderId,$status){
	$order = MCart_GetOrderById($orderId);
	
	if(!empty($order) && $order['estatus'] != $status){
		$order['estatus'] = $status;
		DB_INTERFACE_Save('m_cart_order', $order,array('m_cart_order_id'=>$orderId));
		
		$content = '
		Se ha modificado el estatus de su &oacute;rden No. '.$orderId.'
		<br >
		El Nuevo estatus de su &oacute;rden es: '.$status.'
		<br >
		Puede ver los detalles actualizados de su &oacute;rden en cualquier momento desde el siguiente link de Acceso: <a href="'. ABS_HTTP_URL .'user.php?cmd=view_order&id='.$orderId.'">'. ABS_HTTP_URL .'user.php?cmd=view_order&id='.$orderId.'</a><br /><br />
		';
		
		$content_admin = '
		Se ha modificado el estatus de su &oacute;rden No. '.$orderId.'
		<br >
		El Nuevo estatus de la &oacute;rden es: '.$status.'
		<br >
		Puede ver y modificar los detalles actualizados de la &oacute;rden en cualquier momento desde el siguiente link de Acceso: 
		<a href="'. ABS_HTTP_URL .'system/backoffice/Order.php?cmd=edit&id='.$orderId.'">'. ABS_HTTP_URL .'system/backoffice/Order.php?cmd=edit&id='.$orderId.'</a><br /><br />
		<br />
		';
		
		lib_sendEmail($order['email'],'Cambio de Estatus en Orden No. ' . $orderId ,$content);
		lib_sendEmail(EMAIL_CLIENTE,'Cambio de Estatus en Orden No. ' . $orderId ,$content_admin);
	}
}

//CATEGORIES FUNCTIONS
function MCart_GetCategoriaById($id){
	return DB_INTERFACE_LoadById('m_cart_categoria','m_cart_categoria_id',$id);
}


function MCart_ExisteTXNID_Paypal($txn_id){
		$extra_contidions = array();
		$extra_contidions[] = array('condition'=>'txn_id= "%s"','condition_values'=>array($txn_id) );
		$reg = DB_INTERFACE_Select('m_paypal_txn',array('*'),$extra_contidions,
			array()
			,1,1 );
		$reg = is_array($reg) && !empty($reg);
		return $reg;

}

function MCart_EmptyCartSession(){
	unset($_SESSION[MCART_NAME_SPACE]);
}

?>
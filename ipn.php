<?php 
include('system/lib.php');
$_PAYPAL_TEST = _PAYPAL_TEST;
$seller_email = EMAIL_PAYPAL_CLIENTE; 


$_PAYMENT_CURRENCY = 'MXN';

$email_report = 'alberto@cedeweb.com'; 
$email_critical_report = 'alberto@cedeweb.com'; 

error_reporting(E_ALL ^ E_NOTICE); 
//$email = $_GET['ipn_email']; 

if(!empty($email_report)){
	mail($email_report, "IPN Alarm City - Live ", ''. "IPN Ejecutado\n\n" ); 
}
$header = ""; 
$emailtext = ""; 
// Read the post from PayPal and add 'cmd' 
$req = 'cmd=_notify-validate'; 
if(function_exists('get_magic_quotes_gpc')) 
{  
	$get_magic_quotes_exists = true; 
} 
foreach ($_POST as $key => $value) 
// Handle escape characters, which depends on setting of magic quotes 
{  
	if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1){  
		$value = urlencode(stripslashes($value)); 
	} else { 
		$value = urlencode($value); 
	} 
	$req .= "&$key=$value"; 
} 
// Post back to PayPal to validate 
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n"; 
$header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n"; 

if($_PAYPAL_TEST){
	//$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30); 
	$fp = fsockopen('ssl://www.sandbox.paypal.com',443,$err_num,$err_str,30);
	//$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30); 
}else{
	$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30); 
}
 
 
// Process validation from PayPal 
// TODO: This sample does not test the HTTP response code. All 
// HTTP response codes must be handles or you should use an HTTP 
// library, such as cUrl 

if (!$fp) { // HTTP ERROR 
	if(!empty($email_critical_report)){
		mail($email_critical_report, "ERR CRITICO - IPN Alarm City - NO FP", $emailtext . "\n\n" . $req); 
	}
} else { 
// NO HTTP ERROR 
$res2 = '';
fputs ($fp, $header . $req); 
while (!feof($fp)) { 
	$res = fgets ($fp, 1024); 
	$res2 .= $res; 
	if (strcmp ($res, "VERIFIED") == 0) { 
		// TODO: 
		// Check the payment_status is Completed 
		// Check that txn_id has not been previously processed 
		// Check that receiver_email is your Primary PayPal email 
		// Check that payment_amount/payment_currency are correct 
		// Process payment 
		// If 'VERIFIED', send an email of IPN variables and values to the 
		// specified email address
		// assign posted variables to local variables

		$item_name = $_POST['item_name'];
		$item_number = $_POST['item_number'];
		$payment_status = $_POST['payment_status'];
		$payment_amount = $_POST['mc_gross'];
		$payment_currency = $_POST['mc_currency'];
		$txn_id = $_POST['txn_id'];
		$receiver_email = $_POST['receiver_email'];
		$payer_email = $_POST['payer_email'];

		$existe_txn_id = MCart_ExisteTXNID_Paypal($txn_id);
		$total = MCart_GetTotalOrderById($item_number);
		
		$req.= "\n\nExiste:" . $existe_txn_id;
		$req.= "\n\nTotal:" . $total;
		$req.= "\n\nSeller Email:" . $seller_email;
		
		if(!empty($email_report)){
			mail($email_report, "IPN Alarm City - VERIFIED", $emailtext . "\n\n" . $req); 
		}
		
		if($_POST['payment_status'] != 'Completed'){
			if(!empty($email_critical_report)){
				mail($email_critical_report, "ERR CRITICO - IPN Alarm City - Completed", $emailtext . "\n\n" . $req); 
			}
			die;
		}
		if($existe_txn_id){
			if(!empty($email_critical_report)){
				mail($email_critical_report, "ERR CRITICO - IPN Alarm City - Existe TXN ID", $emailtext . "\n\n" . $req); 
			}
			die;
		}
		if($_POST['receiver_email'] != $seller_email){
			if(!empty($email_critical_report)){
				mail($email_critical_report, "ERR CRITICO - IPN Alarm City - Receiver Email", $emailtext . "\n\n" . $req); 
			}
			die;
		}
		if($payment_amount < $total || $payment_currency != $_PAYMENT_CURRENCY){
			if(!empty($email_critical_report)){
				mail($email_critical_report, "ERR CRITICO - IPN Alarm City - Payment Total, Currency", $emailtext . "\n\n" . $req); 
			}
			die;
		}

		$registro = array('transaction_subject','txn_type','payment_date','last_name','residence_country','pending_reason',
						  'item_name','payment_gross','mc_currency','business','payment_type','protection_eligibility',
						  'verify_sign','payer_status','test_ipn','tax','payer_email','txn_id','quantity','receiver_email',
						  'first_name','payer_id','receiver_id','item_number','handling_amount','payment_status','shipping',
						  'mc_gross','custom','charset','notify_version','ipn_track_id');
		$registro2 = array();
		foreach ($registro as $value){ 
			$registro2[$value] = $_POST[$value]; 
		} 
		$registro['fecha_registro'] = date('Y-m-d H:i:s');
		
		if(!empty($email_report)){
			ob_start();
				var_dump($registro2);
				$g = ob_get_contents();
			ob_end_clean();
			mail($email_report, "IPN Alarm City - Debug Registro", $emailtext . "\n\n" . $req  . "\n\n" . $g); 
		}
		DB_INTERFACE_Save('m_paypal_txn', $registro2);
		$idPaypalReg =  mysql_insert_id();
		
		if(!empty($idPaypalReg)){
			MCart_SetOrderStatus($item_number,'Completada');
		}else{
			mail('alberto@cedeweb.com', "ERR CRITICO - IPN Alarm City - NOT SAVE PAYPAL TXN", $emailtext . "\n\n" . $req); 
		}
		
		
		
	} else if (strcmp ($res, "INVALID") == 0) { 
		// If 'INVALID', send an email. TODO: Log for manual investigation. 
		foreach ($_POST as $key => $value){ 
			$emailtext .= $key . " = " .$value ."\n\n"; 
		} 
		mail('alerto@cedeweb.com', "Live-INVALID IPN", $emailtext . "\n\n" . $req); 
	}	 
} 

}
if(!empty($email_report)){
	mail($email_report, "IPN Alarm City - Final QUESTION ", $emailtext . "\n\n" . $req. "\n\nRESSSS: " . $ress); 
}
fclose ($fp); 
?>
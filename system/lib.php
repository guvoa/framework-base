<?php
if (false/* && $_SERVER['REMOTE_ADDR'] == '127.0.0.1'*/) {
	error_reporting(E_ALL);
	define('DEBUG', true);
} else {
	error_reporting(0);
	define('DEBUG', false);
}
//require_once("class.phpmailer.php");
//require_once("class.smtp.php");

require_once 'lib/controller.php';
require_once 'lib/config.php';
require_once 'lib/form.php';
require_once 'lib/listPanel.php';
require_once 'lib/db.php';
require_once 'lib/MCart.php';
require_once 'lib/MUserLog.php';
require_once 'lib/Config_States.php';

define('ABS_PATH', realpath(dirname(__FILE__)) . "/../");
//debug(ABS_PATH);

//Utilities functions 
function formatNumber($n)
{
	return '$ ' . number_format($n, 2, '.', ',');
}
function formatStr($str, $max = 0)
{
	$str = str_replace('<', '&lt;', $str);
	$str = strip_tags($str, '<a><img>');
	if (!empty($max))
		$str = getMaxCar($str, $max);



	$str = nl2br($str);
	$str = str_replace('  ', '&nbsp;', $str);
	return $str;
}
function RandomString($length = 10, $uc = TRUE, $n = TRUE, $sc = FALSE)
{
	$source = 'abcdefghijklmnopqrstuvwxyz';
	if ($uc == 1)
		$source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	if ($n == 1)
		$source .= '1234567890';
	if ($sc == 1)
		$source .= '|@#~$%()=^*+[]{}-_';
	if ($length > 0) {
		$rstr = "";
		$source = str_split($source, 1);
		for ($i = 1; $i <= $length; $i++) {
			mt_srand((double) microtime() * 1000000);
			$num = mt_rand(1, count($source));
			$rstr .= $source[$num - 1];
		}

	}
	return $rstr;
}


function getNRows($str, $nrows = 6, $maxCar = 0)
{
	$str = explode("\n", $str);
	$ret = '';
	foreach ($str as $s) {
		$s = !empty($maxCar) ? getMaxCar($s, $maxCar) : $s;
		$ret .= '<br />' . $s;
		if (++$i >= $nrows) {
			break;
		}
	}
	return $ret;
}

function getMaxCar($str, $max = 100)
{
	return (strlen($str) > $max) ? substr($str, 0, $max) . '...' : $str;
}

function uploadFile($File, $path, $validFiles = array(), $maxSize = 0)
{
	$file = $_FILES[$File]['name'];
	if (!empty($file)) {
		$file_size = $_FILES[$File]['size'];
		$file_temp = $_FILES[$File]['tmp_name'];
		$file_err = $_FILES[$File]['error'];

		$ext = explode('.', basename($_FILES[$File]['name']));
		$ext = array_reverse($ext);
		$ext = $ext[0];
		$file_type = $ext;

		$key = array_search($file_type, $validFiles);
		if (!empty($maxSize) && $file_size > $maxSize) {
			return -2;
		}

		if (empty($validFiles) || $key) {
			if (!empty($file_err)) {
				return 0;
			}
			if (move_uploaded_file($file_temp, ABS_PATH . $path)) {
				return 1;
			}
		} else {
			return -1;
		}
	}
	return 0;
}

function deleteFile($imgAnterior)
{
	if (!empty($imgAnterior) && file_exists($imgAnterior)) {
		@unlink($imgAnterior);
	}
}
function getImgDir($class = '', $field = '', $w = 0, $h = 0)
{
	//ruta de la imagen apartir del directorio raiz
	$dir = 'system/files/images/';
	switch ($class) {
		default:
			break;
		case 'galeria':
			$dir .= 'galerias/';
			break;
		case 'foto':
			$dir .= 'fotos/';
			break;
		case 'contenido':
			$dir .= 'Contenido/';
			break;
		case 'PlecaRotativa':
			$dir .= 'PlecaRotativa/';
			break;

	}
	return $dir;
}
function getSrcImgScaleParams($src, $max_w = null, $max_h = null, $defaultImg = 'ima/int/imam.jpg', $border = 0, $pathUrl = false)
{
	$src = getSrcImg($src, $defaultImg);
	$wh = get_scaled_dim_array($src, $max_w, $max_h);
	$w = empty($wh) || empty($max_w) || empty($wh[0]) ? '' : 'width="' . $wh[0] . '"';
	$h = empty($wh) || empty($max_h) || empty($wh[1]) ? '' : 'height="' . $wh[1] . '"';

	return 'src="' . ($pathUrl ? ABS_HTTP_URL : ABS_HTTP_PATH) . $src . '" ' . $w . ' ' . $h . ' border="' . $border . '"';
}

function getSrcImg($src, $defaultImg = 'ima/int/imam.jpg')
{
	$src2 = ABS_PATH . $src;
	$result = file_exists($src2) && !is_dir($src2);
	return ($result) ? $src : $defaultImg;
}

function get_scaled_dim_array($img, $max_w = NULL, $max_h = NULL)
{
	$img = ABS_PATH . $img;
	if (file_exists($img)) {
		list($img_w, $img_h) = getimagesize($img);
		if (($img_w > $max_w && !empty($max_w)) || ($img_h > $max_h && !empty($max_h))) {
			$f =
				empty($max_w) && empty($max_h) ? 1 :
				(
					empty($max_w) || empty($max_h) ?
					(
						empty($max_w) ? $max_h / $img_h : $max_w / $img_w
					)
					: min($max_w / $img_w, $max_h / $img_h, 1)
				);

			$w = empty($max_w) ? '' : round($f * $img_w);
			$h = empty($max_h) ? '' : round($f * $img_h);
		}
		return array($w, $h);
	}
	return null;
}


function debug($var, $comment = "")
{
	echo "<pre>";
	echo $comment;
	ob_start();
	var_dump($var);
	$cont = ob_get_contents();
	ob_end_clean();

	echo htmlentities($cont);
	echo "</pre>";
}



function lib_sendEmail($to, $subject, $content)
{
	$body = '<img src="' . ABS_HTTP_URL . 'images/logo.png"><br /><br />';
	$body .= $content;
	$body .= '<br /><br /><strong style="color:#AA0000">Alarm City</strong><br />
	<a href="' . ABS_HTTP_URL . '">' . ABS_HTTP_URL . '</a><br />
	Contáctanos: Móvil 22 22 93 60 95
	';
	mail_smtp($to, $subject, $body);
}
function mail_smtp($email_to, $subject, $body, $from_name = '', $from = '', $password = '')
{
	$from_name = empty($from_name) ? 'Alarm City' : $from_name;
	$smtp_server = "mail.alarm-city.com";

	$from = empty($from) ? 'info@alarm-city.com' : $from;
	$password = empty($password) ? 'Al4R32iT' : $password;



	//require_once("class.phpmailer.php");
	//require_once("system/lib.php");
	$mail = new PHPMailer();

	//Luego tenemos que iniciar la validación por SMTP:
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->Host = $smtp_server;
	$mail->SMTPSecure = "ssl";

	$mail->Username = $from;
	$mail->Password = $password; // Contraseña
	$mail->Port = 465; // Puerto a utilizar
	$mail->CharSet = 'utf-8'; // charset

	//Con estas pocas líneas iniciamos una conexión con el SMTP. Lo que ahora deberíamos hacer, es configurar el mensaje a enviar, el //From, etc.
	$mail->From = $from; // Desde donde enviamos (Para mostrar)
	$mail->FromName = $from_name;

	//Estas dos líneas, cumplirían la función de encabezado (En mail() usado de esta forma: "From: Nombre <correo@dominio.com>") de //correo.
	$mail->AddAddress($email_to); // Esta es la dirección a donde enviamos
	$mail->IsHTML(true); // El correo se envía como HTML
	$mail->Subject = $subject; // Este es el titulo del email.
	$mail->Body = $body; // Mensaje a enviar

	$mail->SMTPDebug = false;
	foreach ($_FILES as $key => $v) {
		$img_name = date('YmdHis') . '_' . basename($_FILES[$key]['name']);
		$path = "system/files/send_mail/" . $img_name;
		// la carpeta upload debe tener permiso de escritura 

		$result = uploadFile($key, $path, array('jpeg', 'jpg', 'gif', 'png', 'PNG', 'JPG', 'JPEG'), (1024 * 1024));

		//	 if(is_uploaded_file($_FILES[$key]['tmp_name'])) 
		if ($result) {
			$mail->AddAttachment($path);  // add attachments 
		}
	}
	$exito = $mail->Send(); // Envía el correo.

	//También podríamos agregar simples verificaciones para saber si se envió:
	return $exito;
}
@session_start();

db_connect();
header('Content-Type: text/html; charset=utf-8');
//header('Content-Type: text/html; charset=iso-8859-1');
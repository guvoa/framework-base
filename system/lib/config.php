<?php
if (true) {
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PWD', 'kevorkian');
	define('DB_DB', 'framework_base');
	define('ABS_HTTP_PATH', '/');

	define('HTTP_HOST', 'http://localhost');
	define('ABS_HTTP_URL', HTTP_HOST . ABS_HTTP_PATH);

	define('EMAIL_CLIENTE', 'oskarguarneros@gmail.com');
	//define('EMAIL_PAYPAL_CLIENTE', 'seller_1350855777_biz@sibei.mx');
	define('_PAYPAL_TEST', true);
} else {
	define('DB_HOST', 'localhost');
	define('DB_USER', 'decidew_carrito');
	define('DB_PWD', 'K1zSsDmMEypi');
	define('DB_DB', 'decidew_carrito_db');
	define('ABS_HTTP_PATH', '/carrito/');
	define('PROJECT_NAME', 'Carrito');

	define('HTTP_HOST', 'http://decideweb.com');
	define('ABS_HTTP_URL', HTTP_HOST . ABS_HTTP_PATH);

	define('MAIL_SMTP', 'mail.decideweb.com');
	define('MAIL_SMTP_FROM', 'info@decideweb.com');
	define('MAIL_SMTP_PASSWORD', 'info2012');

	define('EMAIL_CLIENTE', 'oskar@sibei.mx');
	define('EMAIL_PAYPAL_CLIENTE', 'seller_1350855777_biz@sibei.mx');
	define('_PAYPAL_TEST', true);

}
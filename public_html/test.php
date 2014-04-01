<?
ini_set('display_errors', 1);
error_reporting(E_ALL ^E_NOTICE);

define('SITE_URL', 'manager.ru');
define('ROOT', str_replace('/public_html', '', $_SERVER['DOCUMENT_ROOT']) );

session_start();

// Подключаем автозагрузчик классов.
require_once(ROOT . '/app/core/Autoloader.php');

session_destroy();
$sms = SmsHelper::getInstance();
$response = $sms->sendMessage(array(
    "id" => 1,
    "phone"=> '+380973793818',
    "text" => "Ваш логин для входа в лчичный каьинет : 111"
));

echo '<pre>'; print_r($response); echo '</pre>';
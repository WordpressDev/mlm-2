<?
ini_set('display_errors', 1);
error_reporting(E_ALL ^E_NOTICE);

define('SITE_URL', 'http://'.$_SERVER['HTTP_HOST']);
define('ROOT', str_replace('/public_html', '', $_SERVER['DOCUMENT_ROOT']) );

session_start();

// Подключаем автозагрузчик классов.
require_once(ROOT . '/app/core/Autoloader.php');
require_once(ROOT . '/app/startup.php');



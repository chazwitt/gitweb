<?php
header("Content-Type:text/html; charset=utf-8");
defined('ROOT_PATH') or define('ROOT_PATH', dirname(__FILE__));
define('APP_DEBUG', true);
define('THINK_PATH', './phpkj/thinkphp/');
define('APP_NAME', 'home');
define('APP_PATH', './home/');
define('APP_DUBUG' , TRUE);
define('BUILD_DIR_SECURE',true);
define('DIR_SECURE_FILENAME', 'index.html');
define('DIR_SECURE_CONTENT', 'deney Access!');
require( THINK_PATH."ThinkPHP.php");
?>
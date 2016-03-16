<?php
defined('ROOT_PATH') or define('ROOT_PATH', dirname(__FILE__));
define('APP_DEBUG', true);
define('THINK_PATH', './phpkj/thinkphp/');
define('APP_NAME', 'admin');
define('APP_PATH', './admin/');
define('BUILD_DIR_SECURE',true);
define('DIR_SECURE_FILENAME', 'index.html');
define('DIR_SECURE_CONTENT', 'deney Access!');
require( THINK_PATH."ThinkPHP.php");
?>
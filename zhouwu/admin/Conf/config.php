<?php
if (!defined('THINK_PATH'))	exit();
$site=require './site.php';
//数据库配置信息
$config = require("config.inc.php");
$nocheck=require("config/nocheck.config.php");
$array= array(
	//'配置项'=>'配置值'
	'URL_CASE_INSENSITIVE' => true ,
	'URL_MODEL'         =>0,		    //URL模式：0普通模式 1PATHINFO 2REWRITE 3兼容模式
	'COOKIE_EXPIRE'=>30000000000,                // Cookie有效期
	'COOKIE_DOMAIN'=>$_SERVER['HTTP_HOST'],        // Cookie有效域名
	'COOKIE_PATH'=>'/',                        // Cookie路径
	//数据缓存设置开始
	'DATA_CACHE_TYPE'       => 'file', // 数据缓存方式 文件
	'DATA_CACHE_TIME'       => 3600,      // 数据缓存有效期 0表示永久缓存
	'DATA_CACHE_COMPRESS'   => false,   // 数据缓存是否压缩缓存
	'DATA_CACHE_CHECK'      => false,   // 数据缓存是否校验缓存
	'DATA_CACHE_PREFIX'     => '@',     // 缓存前缀
	'DATA_CACHE_SUBDIR'     => false,  // 使用子目录缓存 (根据缓存标识的哈希创建子目录)
	'DATA_PATH_LEVEL'       => 1,        // 子目录缓存级别
	//数据缓存设置结束
	//邮件设置
	'MAIL_ADDRESS'=>$site['fjxemail'], // 邮箱地址
	'MAIL_SMTP'=>$site['fjxemailsmtp'], // 邮箱SMTP服务器
	'MAIL_LOGINNAME'=>$site['fjxemail'], // 邮箱登录帐号
	'MAIL_PASSWORD'=>$site['fjxemailpwd'], // 邮箱密码
	'OUTPUT_ENCODE' => false ,
	'APP_AUTOLOAD_PATH'=>'@.TagLib',//	
	
);
return array_merge($config,$nocheck,$array);
?>
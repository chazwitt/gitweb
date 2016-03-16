<?php
if (!defined('THINK_PATH'))	exit();

$site=require './site.php';

//数据库配置信息
$config = require("config.inc.php");
$array= array(
	//'配置项'=>'配置值'
	'URL_CASE_INSENSITIVE' => true ,
	'URL_MODEL'         =>2,		    //URL模式：0普通模式 1PATHINFO 2REWRITE 3兼容模式
	'URL_PATHINFO_DEPR' => '_',
	'URL_HTML_SUFFIX'=>'html',
	//数据缓存设置开始
	'DATA_CACHE_TYPE'       => 'file', // 数据缓存方式 文件
	'DATA_CACHE_TIME'       => 300,      // 数据缓存有效期 0表示永久缓存
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
//	'TMPL_ACTION_SUCCESS' => 'public:success',
    //'TMPL_ACTION_ERROR' => 'public:error',
	
	
	
	
	//支付宝配置参数
	'alipay_config'=>array(
	'partner' =>$site['zfbpid'],   //这里是你在成功申请支付宝接口后获取到的PID；
	'key'=>$site['zfbkey'],//这里是你在成功申请支付宝接口后获取到的Key
	'sign_type'=>strtoupper('MD5'),
	'input_charset'=> strtolower('utf-8'),
	'cacert'=> getcwd().'\\cacert.pem',
	'transport'=> 'http',
	),
	//以上配置项，是从接口包中alipay.config.php 文件中复制过来，进行配置；
	
	'alipay'   =>array(
	//这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
	'seller_email'=>$site['zfb'],
	
	//这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
	'notify_url'=>'http://'.$_SERVER['SERVER_NAME'].'/pay_notifyurl.html', 
	
	//这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
	'return_url'=>'http://'.$_SERVER['SERVER_NAME'].'/pay_returnurl.html',
	
	//支付成功跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参payed（已支付列表）
	'successpage'=>'User/pay',   
	
	//支付失败跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参unpay（未支付列表）
	'errorpage'=>'User/pay', 
	),
	
);
return array_merge($config,$array);
?>
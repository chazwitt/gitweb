<?php
//公共函数

//发送邮件
/*address 表示收件人地址
*title 表示邮件标题
*message表示邮件内容
* 
* */
function sendMail($address,$title,$message){ 
	vendor('mail.mail');
	$mail=new PHPMailer();          // 设置PHPMailer使用SMTP服务器发送Email
	$mail->IsSMTP();                // 设置邮件的字符编码，若不指定，则为'UTF-8'
	$mail->CharSet='UTF-8';         // 添加收件人地址，可以多次使用来添加多个收件人
	$mail->AddAddress($address);    // 设置邮件正文
	$mail->IsHTML(true);
	$mail->Body=$message;           // 设置邮件头的From字段。
	$mail->From=C('MAIL_ADDRESS');  // 设置发件人名字
	$mail->FromName='我就发创富平台';  // 设置邮件标题
	$mail->Subject=$title;          // 设置SMTP服务器。
	$mail->Host=C('MAIL_SMTP');     // 设置为"需要验证" ThinkPHP 的C方法读取配置文件
	$mail->SMTPAuth=true;           // 设置用户名和密码。
	$mail->Username=C('MAIL_LOGINNAME');
	$mail->Password=C('MAIL_PASSWORD'); // 发送邮件。
	return($mail->Send());
}

/*
日志存储
$uid 用户ID
$module 模型
$action 操作
$ip  IP
*/
function  addlog($uid,$operation,$action,$ip){
	$log=M('logs');
	$data['uid']=$uid;
	$data['operation']=$operation;
	$data['action']=$action;
	$data['ip']=$ip;
	$data['create_time']=date('Y-m-d H:i:s',time());
	return($log->add($data));
}

/**
 * 获取请求ip
 *
 * @return ip地址
 */
function ip() {
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$ip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$ip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
}


/*
生成透明图片
*/

function exit_with_image_blank() {
    $img = imagecreate(15, 15);
    $white = imagecolorallocate($img, 0xff, 0xff, 0xff);
    imagefill($img, 0, 0, $white);

    header('Cache-Control: no-cache, must-revalidate');
    header('Content-Type:image/png');
    imagepng($img);
    imagedestroy($img);
}



//获取远程数据
function get($url) {
    if (function_exists('file_get_contents')) {
        $file_contents = file_get_contents($url);
    } else {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);
    }
    return $file_contents;
}


//获得浏览器名称和版本 
function getbrowser() {  
    global $_SERVER;  
    $agent  = $_SERVER['HTTP_USER_AGENT'];  
    $browser  = '';  
    $browser_ver  = '';  
  
    if (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs)) {  
      $browser  = 'OmniWeb';  
      $browser_ver   = $regs[2];  
    }  
  
    if (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs)) {  
      $browser  = 'Netscape';  
      $browser_ver   = $regs[2];  
    }  
  
    if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {  
      $browser  = 'Safari';  
      $browser_ver   = $regs[1];  
    }  
  
    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {  
      $browser  = 'Internet Explorer';  
      $browser_ver   = $regs[1];  
    }  
  
    if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {  
      $browser  = 'Opera';  
      $browser_ver   = $regs[1];  
    }   
  
    if (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs)) {  
      $browser  = '(Internet Explorer ' .$browser_ver. ') NetCaptor';  
      $browser_ver   = $regs[1];  
    }  
  
    if (preg_match('/Maxthon/i', $agent, $regs)) {  
      $browser  = '(Internet Explorer ' .$browser_ver. ') Maxthon';  
      $browser_ver   = '';  
    } 
if (preg_match('/360SE/i', $agent, $regs)) {  
      $browser       = '(Internet Explorer ' .$browser_ver. ') 360SE';  
      $browser_ver   = '';  
    } 
if (preg_match('/SE 2.x/i', $agent, $regs)) {  
      $browser       = '(Internet Explorer ' .$browser_ver. ') 搜狗';  
      $browser_ver   = '';  
    }  
  
    if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {  
      $browser  = 'FireFox';  
      $browser_ver   = $regs[1];  
    }  
  
    if (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs)) {  
      $browser  = 'Lynx';  
      $browser_ver   = $regs[1];  
    }  
  
    if ($browser != '') {  
       return $browser.' '.$browser_ver;  
    }  
    else {  
      return 'Unknow browser';  
    }  
}  

//获得客户端的操作系统
function getplat() {  
    $agent = $_SERVER['HTTP_USER_AGENT'];  
    $os = false;  
  
    if (eregi('win', $agent) && strpos($agent, '95')) {  
      $os = 'Windows 95';  
    }  
    else if (eregi('win 9x', $agent) && strpos($agent, '4.90')) {  
      $os = 'Windows ME';  
    }  
    else if (eregi('win', $agent) && ereg('98', $agent)) {  
      $os = 'Windows 98';  
    }  
    else if (eregi('win', $agent) && eregi('nt 5.1', $agent)) {  
      $os = 'Windows XP';  
    }  
    else if (eregi('win', $agent) && eregi('nt 5', $agent)) {  
      $os = 'Windows 2000';  
    }  
    else if (eregi('win', $agent) && eregi('nt', $agent)) {  
      $os = 'Windows NT';  
    }  
    else if (eregi('win', $agent) && ereg('32', $agent)) {  
      $os = 'Windows 32';  
    }  
    else if (eregi('linux', $agent)) {  
      $os = 'Linux';  
    }  
    else if (eregi('unix', $agent)) {  
      $os = 'Unix';  
    }  
    else if (eregi('sun', $agent) && eregi('os', $agent)) {  
      $os = 'SunOS';  
    }  
    else if (eregi('ibm', $agent) && eregi('os', $agent)) {  
      $os = 'IBM OS/2';  
    }  
    else if (eregi('Mac', $agent) && eregi('PC', $agent)) {  
      $os = 'Macintosh';  
    }  
    else if (eregi('PowerPC', $agent)) {  
      $os = 'PowerPC';  
    }  
    else if (eregi('AIX', $agent)) {  
      $os = 'AIX';  
    }  
    else if (eregi('HPUX', $agent)) {  
      $os = 'HPUX';  
    }  
    else if (eregi('NetBSD', $agent)) {  
      $os = 'NetBSD';  
    }  
    else if (eregi('BSD', $agent)) {  
      $os = 'BSD';  
    }  
    else if (ereg('OSF1', $agent)) {  
      $os = 'OSF1';  
    }  
    else if (ereg('IRIX', $agent)) {  
      $os = 'IRIX';  
    }  
    else if (eregi('FreeBSD', $agent)) {  
      $os = 'FreeBSD';  
    }  
    else if (eregi('teleport', $agent)) {  
      $os = 'teleport';  
    }  
    else if (eregi('flashget', $agent)) {  
      $os = 'flashget';  
    }  
    else if (eregi('webzip', $agent)) {  
      $os = 'webzip';  
    }  
    else if (eregi('offline', $agent)) {  
      $os = 'offline';  
    }  
    else{  
      $os = 'Unknown';  
    }  
    return $os;  
} 


//颜色
function yanse($key=0){
	
	switch ($key)
	{
	case 1:
	  return "#FF0F00";
	  break;
	case 2:
	  return "#FF6600";
	  break;
	case 3:
	  return "#FF9E01";
	  break;
	default:
	  return "#FCD202";
	}
}

//判断时间
function timediff($t){
		$digest_date = date('Y-m-d',$t);//转换时间
		$date_diff = round( abs(strtotime(date('y-m-d'))-strtotime($digest_date)) / 86400, 0 );//计算差值 0是今天 1是昨天
		if($date_diff==0){
			$str = "<font color=red>".date('Y-m-d H:i:s',$t)."</font>";
		}else{
			$str = date('Y-m-d H:i:s',$t);
		}
		return $str;
}

function redIP($ip = '', $file = 'UTFWry.dat') {
    $_ip = array ();
    if (isset ($_ip [$ip])) {
        return $_ip [$ip];
    }else{
        import("ORG.Net.IpLocation");
        $iplocation=new IpLocation ($file);
        $location=$iplocation->getlocation ($ip);
        $_ip [$ip]=$location['country'].$location ['area'];
    }
    return $_ip [$ip];
}




















?>
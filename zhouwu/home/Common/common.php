<?php

 //在线交易订单支付处理函数
 //函数功能：根据支付接口传回的数据判断该订单是否已经支付成功；
 //返回值：如果订单已经成功支付，返回true，否则返回false；
 function checkorderstatus($ordid){
     $Ord=M('Chongzhi');
     $ordstatus=$Ord->where("num='".$ordid."'")->getField('state');
     if($ordstatus=="WAIT_SELLER_SEND_GOODS"){
         return true;
    }else{
        return false;    
    }
 }
 
 //处理订单函数
 //更新订单状态，写入订单支付后返回的数据
 function orderhandle($parameter){
     $ordid=$parameter['out_trade_no'];
/*     $data['payment_trade_no']      =$parameter['trade_no'];
     $data['payment_trade_status']  =$parameter['trade_status'];
     $data['payment_notify_id']     =$parameter['notify_id'];
     $data['payment_notify_time']   =$parameter['notify_time'];
     $data['payment_buyer_email']   =$parameter['buyer_email'];*/
     $data['state']             =$parameter['trade_status'];
     $Ord=M('Chongzhi');
     $Ord->where("num='".$ordid."'")->save($data);
 } 


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
	$mail->FromName='找回密码';  // 设置邮件标题
	$mail->Subject=$title;          // 设置SMTP服务器。
	$mail->Host=C('MAIL_SMTP');     // 设置为"需要验证" ThinkPHP 的C方法读取配置文件
	$mail->SMTPAuth=true;           // 设置用户名和密码。
	$mail->Username=C('MAIL_LOGINNAME');
	$mail->Password=C('MAIL_PASSWORD'); // 发送邮件。
	return($mail->Send());
}

function get_password( $length = 8 ) 
 {
     $str = substr(md5(time()), 0, 6);
     return $str;
 }
 
//判断用户ID是否存在 
function is_validuserid($domain){
	if(is_numeric($domain)){//是数字
		$user_mod = M('Member');
		$list = $user_mod->where('id='.$domain)->find();
		if($list){
			return 1;//有此用户
		}else{
			return 0;//无此用户
		}
	}else{//不是数字
		return 0;
	}
}
 

?>
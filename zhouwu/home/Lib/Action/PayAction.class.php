<?php

class PayAction extends Action {

    //在类初始化方法中，引入相关类库
    public function _initialize() {
        vendor('Alipay.Corefunction');
        vendor('Alipay.Md5function');
        vendor('Alipay.Notify');
        vendor('Alipay.Submit');
    }

    //doalipay方法
    /* 该方法其实就是将接口文件包下alipayapi.php的内容复制过来
      然后进行相关处理
     */
    public function doalipay() {
		$site=require './site.php';
		$chuji=$site['chuji'];//初级会费
		$vipfree=$site['vip'];//高级会费
		$cprice=$_POST['price'];
		if(!intval($cprice)){
			$this->error("请认真填写金额！",u('user/pay'));
		}
	
	
        $alipay_config = C('alipay_config');
        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = C('alipay.notify_url');
        //需http://格式的完整路径，不能加?id=123这类自定义参数
        //页面跳转同步通知页面路径
        $return_url = C('alipay.return_url');
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        //卖家支付宝帐户
        $seller_email = C('alipay.seller_email');
        //必填
        //商户订单号
        $out_trade_no = $_POST['trade_no'];
        //商户网站订单系统中唯一订单号，必填
        //订单名称
        $subject = "在线充值-".session('username');
        //必填
        //付款金额
        $price = $_POST['price'];
        //必填
        //商品数量
        $quantity = "1";
        //必填，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品
        //物流费用
        $logistics_fee = "0.00";
        //必填，即运费
        //物流类型
        $logistics_type = "EXPRESS";
        //必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
        //物流支付方式
        $logistics_payment = "SELLER_PAY";
        //必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
        //订单描述

        $body = $_POST['WIDbody'];
        //商品展示地址
        $show_url = $_POST['WIDshow_url'];
        //需以http://开头的完整路径，如：http://www.xxx.com/myorder.html
        //收货人姓名
        $receive_name = $_POST['WIDreceive_name'];
        //如：张三
        //收货人地址
        $receive_address = $_POST['WIDreceive_address'];
        //如：XX省XXX市XXX区XXX路XXX小区XXX栋XXX单元XXX号
        //收货人邮编
        $receive_zip = $_POST['WIDreceive_zip'];
        //如：123456
        //收货人电话号码
        $receive_phone = $_POST['WIDreceive_phone'];
        //如：0571-88158090
        //收货人手机号码
        $receive_mobile = $_POST['WIDreceive_mobile'];


        $Ord = M('Chongzhi');

        $data['uid'] = session('userid');
        $data['money'] = $price;
		$data['state'] = 1;
        $data['addtime'] = time();
        $data['num'] = $out_trade_no;

        $Ord->add($data);


        //如：13312341234
//构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "trade_create_by_buyer",
            "partner" => trim($alipay_config['partner']),
            "payment_type" => $payment_type,
            "notify_url" => $notify_url,
            "return_url" => $return_url,
            "seller_email" => $seller_email,
            "out_trade_no" => $out_trade_no,
            "subject" => $subject,
            "price" => $price,
            "quantity" => $quantity,
            "logistics_fee" => $logistics_fee,
            "logistics_type" => $logistics_type,
            "logistics_payment" => $logistics_payment,
            "body" => $body,
            "show_url" => $show_url,
            "receive_name" => $receive_name,
            "receive_address" => $receive_address,
            "receive_zip" => $receive_zip,
            "receive_phone" => $receive_phone,
            "receive_mobile" => $receive_mobile,
            "_input_charset" => trim(strtolower($alipay_config['input_charset']))
        );
        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
        echo $html_text;
    }

    /*     * ****************************
      服务器异步通知页面方法
      其实这里就是将notify_url.php文件中的代码复制过来进行处理

     * ***************************** */

    function notifyurl() {

        $alipay_config = C('alipay_config');

        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
		
		if($verify_result) {        
            //验证成功
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            $out_trade_no = $_POST['out_trade_no'];      //商户订单号
            $trade_no = $_POST['trade_no'];          //支付宝交易号
            $trade_status = $_POST['trade_status'];      //交易状态
            $total_fee = $_POST['total_fee'];         //交易金额
            $notify_id = $_POST['notify_id'];         //通知校验ID。
            $notify_time = $_POST['notify_time'];       //通知的发送时间。格式为yyyy-MM-dd HH:mm:ss。
            $buyer_email = $_POST['buyer_email'];       //买家支付宝帐号；
            $parameter = array(
                "out_trade_no" => $out_trade_no, //商户订单编号；
                "trade_no" => $trade_no, //支付宝交易号；
                "total_fee" => $total_fee, //交易金额；
                "trade_status" => $trade_status, //交易状态
                "notify_id" => $notify_id, //通知校验ID。
                "notify_time" => $notify_time, //通知的发送时间。
                "buyer_email" => $buyer_email, //买家支付宝帐号；
            );			
            if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {
					//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
			
			      $data['state']             =1 ;
                  $Ord=M('Chongzhi');
                  $Ord->where("num='".$out_trade_no."'")->save($data);
				  echo "success";		//请不要修改或删除
			}
			else if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
				  $data['state']             =2 ;
                  $Ord=M('Chongzhi');
                  $Ord->where("num='".$out_trade_no."'")->save($data);
				  echo "success";		//请不要修改或删除
			}
			else if($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
				  $data['state']             =3 ;
                  $Ord=M('Chongzhi');
                  $Ord->where("num='".$out_trade_no."'")->save($data);
				  echo "success";		//请不要修改或删除
				 
			}else if($_POST['trade_status'] == 'TRADE_FINISHED') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
				  $data['state']             =4 ;
                  $Ord=M('Chongzhi');
                  $Ord->where("num='".$out_trade_no."'")->save($data);
				  
				  $info=$Ord->where("num='".$out_trade_no."'")->getField('uid');
				  $user_mod = M('Member');
				  $user_mod->where('id='.$info)->setInc('money',$total_fee); 
				  echo "success";		//请不要修改或删除
				 
			}else{
				echo "success";		//请不要修改或删除
			}
		}else{
			echo "fail";
		}
           
           
        
    }

    /*
      页面跳转处理方法；
      这里其实就是将return_url.php这个文件中的代码复制过来，进行处理；
     */

    function returnurl() {
        //头部的处理跟上面两个方法一样，这里不罗嗦了！
        $alipay_config = C('alipay_config');
        $alipayNotify = new AlipayNotify($alipay_config); //计算得出通知验证结果
        $verify_result = $alipayNotify->verifyReturn();
    
		//echo 222;print_r($alipay_config);exit;
        if ($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //验证成功
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
            $out_trade_no = $_GET['out_trade_no'];      //商户订单号
            $trade_no = $_GET['trade_no'];          //支付宝交易号
            $trade_status = $_GET['trade_status'];     //交易状态
            $total_fee = $_GET['total_fee'];         //交易金额
            $notify_id = $_GET['notify_id'];         //通知校验ID。
            $notify_time = $_GET['notify_time'];       //通知的发送时间。
            $buyer_email = $_GET['buyer_email'];       //买家支付宝帐号；

            $parameter = array(
                "out_trade_no" => $out_trade_no, //商户订单编号；
                "trade_no" => $trade_no, //支付宝交易号；
                "total_fee" => $total_fee, //交易金额；
                "trade_status" => $trade_status, //交易状态
                "notify_id" => $notify_id, //通知校验ID。
                "notify_time" => $notify_time, //通知的发送时间。
                "buyer_email" => $buyer_email, //买家支付宝帐号
            );
          
		  if($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
					//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
			
			      $data['state']             =2 ;
                  $Ord=M('Chongzhi');
                  $Ord->where("num='".$out_trade_no."'")->save($data);
				  
				  
				   redirect(U(C('alipay.successpage')));
				  
			   
			}
			else if($_GET['trade_status'] == 'TRADE_FINISHED') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
					 $data['state']             =4 ;
                  $Ord=M('Chongzhi');
                  $Ord->where("num='".$out_trade_no."'")->save($data);
				  
				  
				   redirect(U(C('alipay.successpage')));
			}else{
				echo "trade_status=".$_GET['trade_status'];
			}
			echo "验证成功";		//请不要修改或删除
			
		  }else{
		  		echo "验证失败";
		  }
		  
		  
           

    }

}

?>
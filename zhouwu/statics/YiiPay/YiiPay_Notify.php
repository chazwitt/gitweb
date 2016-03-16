<?php
include_once("Config.php");

/*
 *====================================================================
 *					www.YiiPay.com
 *
 *                易支付 提供技术支持
 *
 *     		本页面为支付完成后获取返回的参数及处理......
 *
 *====================================================================
*/

//开始接收参数 (请注意区分大小写)
//-----------------------------------------------------------------
$tradeNo	=	isset($_REQUEST["tradeNo"])?$_REQUEST["tradeNo"]:"";	//支付宝交易号
$Money		=	isset($_REQUEST["Money"])?$_REQUEST["Money"]:0;			//付款金额
$title		=	isset($_REQUEST["title"])?$_REQUEST["title"]:"";		//付款说明，一般是网站用户名
$memo		=	isset($_REQUEST["memo"])?$_REQUEST["memo"]:"";			//备注
$Sign		=	isset($_REQUEST["Sign"])?$_REQUEST["Sign"]:"";			//签名
//-----------------------------------------------------------------		

if (strtoupper($Sign) != strtoupper(md5($WebID.$Key.$tradeNo.$Money.$title.$memo))){
		echo "Fail";	
		
		
	}else{

	//配置MYSQL数据库连接信息
		$mysql_server_name	=	"localhost"; 	//数据库服务器名称
		$mysql_username		=	"vip"; 		// 连接数据库用户名
		$mysql_password		=	"xiaozeng885906";				// 连接数据库密码
		$mysql_database		=	"vip"; 			// 数据库的名字
		
		$mysql_conn = mysql_connect($mysql_server_name, $mysql_username, $mysql_password);
		if ($mysql_conn){
			mysql_select_db($mysql_database, $mysql_conn);
			
		 	/********************************************************************
			为了防止用户填错“付款说明”或“备注”导致充值失败，您可以先检查用户名是否存在，再决定自动发货，以解决这个问题
			//$UserNameIsExist	=	true;	//此处修改为您的检测代码,当然如果您觉得没有必要，也可以不检测
			*/
			$rs=mysql_query("Select * From tp30_chongzhi Where num ='".$title."' and state=1");	//将查询sql语句的结果存到$rs变量中
			$num=mysql_num_rows($rs);											//mysql_num_rows函数的作用就是返回记录笔数.就是你的数据表中的总笔数
			if($num>0){
				$UserNameIsExist	=	true;	//该用户名存在
				$sql_u="Update  tp30_chongzhi  set state='4',addtime='".time()."',money='".$Money."'  Where  num='".$title."'";
				mysql_query($sql_u);
				//echo $sql_u;
				$rsu=mysql_fetch_array($rs);
				$userid=$rsu["uid"];
				
			}
			else{
				$UserNameIsExist	=	false;	//用户名不存在
			}
			//*******************************************************************
			
			if ($UserNameIsExist==true){		/*如果用户名存在，就自动发货*/
				/*
				 此处编写您更新数据库（自动发货）的代码
				 
				**********更新数据库事例开始*********************************************************
				/* 增加用户余额 */
				mysql_query("Update tp30_member set money =money +".($Money)." Where id='$userid'");
				/* 增加充值记录 */
				
				
				ob_clean();					//消除之前的输出
				echo "Success";				//此处返回值（Success）不能修改，当检测到此字符串时，就表示充值成功
			 	/* **********更新数据库事例结束********************************************************* */
			}else{
				echo "Order does not exist!";	//当用户名不存在时，就提示此信息，并且不会自动发货
			}
			//*******************************************************************
			mysql_close($mysql_conn);
		}else{
			echo "Conect failed";		//连接数据库失败
		}
		//end========	
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>接入中...</title>
</head>
<?php
include_once("Config.php");
?>
<body onload="javascript:document.f.submit();">
  <form name="f" id="f" action="https://shenghuo.alipay.com/send/payment/fill.htm" method="post" target="_self">
      <input name="optEmail" id="optEmail"  value="<?php echo $AliAccount;?>"  type="hidden">		
			<input name="payAmount" id="payAmount" value="<?php echo $_REQUEST["price"];?>" type="hidden">		
			<input name="title" id="title" value="<?php echo $_REQUEST["out_trade_no"];?>" type="hidden" />					  
			    <input name="memo" id="memo" type="hidden" value="支付过程中请勿修改任何信息"/>
				
</form>
</body>
</html>
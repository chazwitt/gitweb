<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<?php
$BrowserString = $_SERVER['HTTP_USER_AGENT'];
$BrowserString = strtolower($BrowserString);

$broMSIE = "msie";
$url="https://shenghuo.alipay.com/send/payment/fill.htm?_ad=c&_adType=alipay_my_home_aide01&optEmail=".trim($_REQUEST["optEmail"])."&payAmount=".trim($_REQUEST["payAmount"])."&title=".trim($_REQUEST["title"])."&memo=".trim($_REQUEST["memo"])."";
$pos = strpos($BrowserString, $broMSIE);
if($pos==false){?>
<style type="text/css">
<!--
.STYLE1 {font-size: 14px;
line-height:24px;}
.STYLE2 {
	color: #FF0000;
	font-weight: bold;
	font-size: 16px;
}
-->
</style>
<p><span class="STYLE1"><span class="STYLE2">你好，出现本提示是因为您的浏览器不支持自动跳转，您可以选择以下方法：</span><br />
  <br />
      <strong>第一个办法：复制下面网址，粘贴到浏览器中打开( 推荐 )</strong>：<br />
      <textarea cols="50" rows="5"><? echo $url;?></textarea>
  <br />
  <br />
  <strong>第二个办法：
  使用系统自带的IE浏览器,重新打开本站支付。
  找到桌面上 类似这个图标</strong> <img src="img/ie.jpg" /> ，
  </span>
  </p>
<p>&nbsp;</p>
<p><strong>第三个办法：手动切换当前浏览至兼容模式。如图</strong><br />
    <br />
    <img src="img/sougou.JPG" width="809" height="174" /><br />
      <br />
      <img src="img/360.jpg" width="809" height="174" /><br />
  <br />
</p>
<?php }else{
?>
<SCRIPT language=JavaScript>window.opener=null;window.open('<?php echo $url?>','_self');</SCRIPT>
<?php }?>
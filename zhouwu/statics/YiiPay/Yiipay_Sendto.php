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
<p><span class="STYLE1"><span class="STYLE2">��ã����ֱ���ʾ����Ϊ�����������֧���Զ���ת��������ѡ�����·�����</span><br />
  <br />
      <strong>��һ���취������������ַ��ճ����������д�( �Ƽ� )</strong>��<br />
      <textarea cols="50" rows="5"><? echo $url;?></textarea>
  <br />
  <br />
  <strong>�ڶ����취��
  ʹ��ϵͳ�Դ���IE�����,���´򿪱�վ֧����
  �ҵ������� �������ͼ��</strong> <img src="img/ie.jpg" /> ��
  </span>
  </p>
<p>&nbsp;</p>
<p><strong>�������취���ֶ��л���ǰ���������ģʽ����ͼ</strong><br />
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
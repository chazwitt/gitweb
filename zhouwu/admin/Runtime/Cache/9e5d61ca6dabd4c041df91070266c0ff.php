<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link href="__ROOT__/statics/admin/css/style.css" rel="stylesheet" type="text/css"/>
<script language="javascript" type="text/javascript" src="__ROOT__/statics/js/jquery/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript" src="__ROOT__/statics/js/jquery/plugins/formvalidator.js"></script>
<script language="javascript" type="text/javascript" src="__ROOT__/statics/js/jquery/plugins/formvalidatorregex.js"></script>
<script language="javascript" type="text/javascript" src="__ROOT__/statics/js/dialog.js"></script>
<script language="javascript" type="text/javascript" src="__ROOT__/statics/admin/js/admin_common.js"></script>
<title>管理系统</title>
<script language="javascript">
$(function($){
	$("#ajax_loading").ajaxStart(function(){
		$(this).show();
	}).ajaxSuccess(function(){
		$(this).hide();
	});
});

</script>
</head>
<body>

<div id="ajax_loading">提交请求中，请稍候...</div>

<form id="myform" name="myform" action="<?php echo u('public/config');?>" method="post">
  <div class="pad-10">

 		<table width="100%" cellpadding="2" cellspacing="1" class="table_form">
			 <tr>
              <th>网站域名 :</th>
              <td><input type="text" name="site[weburl]" size="50" value="<?php echo ($set["weburl"]); ?>">注：请不要带http://,正确格式如【www.9i-u.com】</td>
            </tr>
            <tr>
              <th>网站名称 :</th>
              <td><input type="text" name="site[webname]" size="50" value="<?php echo ($set["webname"]); ?>"></td>
            </tr>
            <tr>
              <th>公司名称 :</th>
              <td><input type="text" name="site[companyname]" size="50" value="<?php echo ($set["companyname"]); ?>"></td>
            </tr>
            <tr>
              <th>Keywords :</th>
              <td><input type="text" name="site[keywords]" size="50" value="<?php echo ($set["keywords"]); ?>"></td>
            </tr>
            <tr>
              <th>Description :</th>
              <td><textarea name="site[description]" cols="50" rows="3"><?php echo ($set["description"]); ?></textarea></td>
            </tr>
            <tr>
              <th>Email :</th>
              <td><input type="text" name="site[email]" size="50" value="<?php echo ($set["email"]); ?>"></td>
            </tr>
            <tr>
              <th>联系地址 :</th>
              <td><input type="text" name="site[address]" size="50" value="<?php echo ($set["address"]); ?>"></td>
            </tr>
            <tr>
              <th>联系电话 :</th>
              <td><input type="text" name="site[phone]" size="50" value="<?php echo ($set["phone"]); ?>"></td>
            </tr>
            <tr>
              <th>QQ :</th>
              <td><input type="text" name="site[qq]" size="50" value="<?php echo ($set["qq"]); ?>"></td>
            </tr>
            <tr>
              <th>ICP :</th>
              <td><input type="text" name="site[icp]" size="50" value="<?php echo ($set["icp"]); ?>"></td>
            </tr>
            <tr>
              <th>网站关闭原因 :</th>
              <td><textarea name="site[webclose]" cols="50" rows="2"><?php echo ($set["webclose"]); ?></textarea></td>
            </tr>
			<tr>
              <th>初级VIP价格 :</th>
              <td><input type="text" name="site[chuji]" size="10" value="<?php echo ($set["chuji"]); ?>"></td>
            </tr>
            <tr>
              <th>初级VIP提成 :</th>
              <td><input type="text" name="site[cfree]" size="10" value="<?php echo ($set["cfree"]); ?>"></td>
            </tr>
            <tr>
              <th>高级VIP价格 :</th>
              <td><input type="text" name="site[vip]" size="10" value="<?php echo ($set["vip"]); ?>"></td>
            </tr>
            <tr>
              <th>高级VIP提成 :</th>
              <td><input type="text" name="site[vfree]" size="10" value="<?php echo ($set["vfree"]); ?>"></td>
            </tr>
			 <tr>
              <th>普通推广注册提成 :</th>
              <td><input type="text" name="site[ptgfee]" size="10" value="<?php echo ($set["ptgfee"]); ?>"> 此项只针对普通会员推广注册适用</td>
            </tr>
			<tr>
              <th>VIP推广注册提成 :</th>
              <td><input type="text" name="site[vtgfee]" size="10" value="<?php echo ($set["vtgfee"]); ?>"> 此项只针对VIP会员推广注册适用</td>
            </tr>
			 <tr>
              <th>提现限制 :</th>
              <td><input type="text" name="site[txlimit]" size="10" value="<?php echo ($set["txlimit"]); ?>"> </td>
            </tr>
            <tr>
              <th>推广IP数 :</th>
              <td><input type="text" name="site[ip]" size="10" value="<?php echo ($set["ip"]); ?>"></td>
            </tr>
             <tr>
              <th>支付宝帐号 :</th>
              <td><input type="text" name="site[zfb]" size="50" value="<?php echo ($set["zfb"]); ?>"></td>
            </tr>
			<tr>
              <th>支付宝PID :</th>
              <td><input type="text" name="site[zfbpid]" size="50" value="<?php echo ($set["zfbpid"]); ?>"></td>
            </tr>
			<tr>
              <th>支付宝KEY :</th>
              <td><input type="text" name="site[zfbkey]" size="50" value="<?php echo ($set["zfbkey"]); ?>"></td>
            </tr>
			 <tr>
              <th>QQ邮件订阅nId :</th>
              <td><input type="text" name="site[qqemailnid]" size="50" value="<?php echo ($set["qqemailnid"]); ?>"></td>
            </tr>
             <tr>
              <th>发件箱帐号 :</th>
              <td><input type="text" name="site[fjxemail]" size="50" value="<?php echo ($set["fjxemail"]); ?>"></td>
            </tr>
			<tr>
              <th>发件箱密码 :</th>
              <td><input type="text" name="site[fjxemailpwd]" size="50" value="<?php echo ($set["fjxemailpwd"]); ?>"></td>
            </tr>
			<tr>
              <th>发件箱SMTP :</th>
              <td><input type="text" name="site[fjxemailsmtp]" size="50" value="<?php echo ($set["fjxemailsmtp"]); ?>"></td>
            </tr>
            <tr>
              <th>公告内容 :</th>
              <td><textarea name="site[noticestr]" cols="50" rows="3"><?php echo ($set["noticestr"]); ?></textarea></td>
            </tr>
			<tr>
              <th>首页视频播放地址 :</th>
              <td><input type="text" name="site[indexspaddress]" size="100" value="<?php echo ($set["indexspaddress"]); ?>"></td>
            </tr>
			<tr>
              <th>是否开启二级域名推广功能 :</th>
              <td><input type="text" name="site[userdomain]" size="10" value="<?php echo ($set["userdomain"]); ?>">注：0为不开启，1为开启</td>
            </tr>
			 <tr>
              <th>用户二级域名网址后缀 :</th>
              <td>http://用户ID.<input type="text" name="site[userdomainurl]" size="50" value="<?php echo ($set["userdomainurl"]); ?>">注：正确格式如【9i-u.com】</td>
            </tr>
			 <tr>
              <th>网站版权 :</th>
              <td><input type="text" name="site[webbq]" size="50" value="<?php echo ($set["webbq"]); ?>"></td>
            </tr>
			 <tr>
              <th>工作时间 :</th>
              <td><input type="text" name="site[webworktime]" size="50" value="<?php echo ($set["webworktime"]); ?>"></td>
            </tr>
        </table>
      <div class="bk15"></div>

      <div class="btn"><input type="submit" value="保存"  name="dosubmit" class="button" id="dosubmit"></div>

    </div>


</body></html>
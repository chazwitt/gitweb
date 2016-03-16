<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>修改密码--<?php echo ($set["webname"]); ?></title>
<meta name="keywords" content="<?php echo ($set["keywords"]); ?>"/>
<meta name="description" content="<?php echo ($set["description"]); ?>"/>
<link rel="stylesheet" type="text/css" href="__ROOT__/statics/home/css/style.css" />
<script type="text/javascript">
function checkmyform(){
	if(document.myform.oldpwd.value==''){
		alert('请输入原始密码');
		document.myform.oldpwd.focus();
		return false;
	}
	if(document.myform.pwd.value==''){
		alert('请输入新密码');
		document.myform.pwd.focus();
		return false;
	}
	if(document.myform.repwd.value==''){
		alert('请重复输入新密码');
		document.myform.repwd.focus();
		return false;
	}
	if(document.myform.repwd.value!=document.myform.pwd.value){
		alert('两次密码输入不一致');
		document.myform.repwd.focus();
		return false;
	}
}
</script>
</head>
<body>
<div id="header">
	<div class="head">
		<div class="logo fl">
			<h1><a href="http://<?php echo ($set["weburl"]); ?>" title="<?php echo ($set["webname"]); ?>"><img src="/upload/image/20141006/20141006180132_75618.png" alt="lougou.png"/></a></h1>
		</div>
		<div class="nav fl">
		  <ul>
		<li><a href="/">联盟首页</a></li>
	    <li><a href="<?php echo u('user/index');?>" >会员中心</a></li>
			<li><a href="/user_union.html" >联盟分销</a></li>
            <li><a href="/index_contact_id_15.html">了解互联网</a></li>
			<li><a href="<?php echo u('guestbook/show');?>" >VIP留言</a></li>
			<li><a href="<?php echo u('index/contact', array('id'=>1));?>" >关于我们</a></li>
			<li><a href="http://www.pinminwang.com"target="_blank">返回贫民网</a></li>
		  </ul>
		  <div class="clear"></div>
		</div>
		<div class="tel fr">
			<img src="/statics/home/images/telpic.png">
			<a href="/user_index.html" class="dlp"></a>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>
<div class="W usermain clear mt10">
	<div class="uleft fl">
		<div class="usernav">
	<dl>
		﻿<dt><span class="t">VIP中心</span></dt>
<dd><a href="<?php echo u('user/index');?>">会员首页</a></dd>

<dd><a href="/user_clist_cid_18.html">普通会员</a></dd>
<dd><a href="<?php echo u('user/vipindex', array('vip'=>2));?>">中级（VIP）</a></dd>
<dd><a href="<?php echo u('user/vipindex', array('vip'=>3));?>">高级（VIP）</a></dd>
<dd><a href="<?php echo u('user/rule');?>">VIP开通</a></dd>
<dd><a href="<?php echo u('user/account');?>">个人资料</a></dd>
<dd><a href="<?php echo u('user/pay');?>">账户充值</a></dd>
<dd><a href="<?php echo u('user/apply');?>">提取佣金</a></dd>
<dd><a href="<?php echo u('user/union');?>">VIP推广</a></dd>
<dd><a href="<?php echo u('user/tguser');?>">推广用户</a></dd>
<dd><a href="<?php echo u('user/pwd');?>">修改密码</a></dd>
<dd><a href="<?php echo u('user/out');?>">退出登录</a></dd>
	</dl>
</div>
	</div>
	<div class="uright fr">
		<div class="userbox">
			<div class="tit">
				<span class="t">修改密码</span>
			</div>
			<div class="con userinfo">
			<form name="myform" action="<?php echo u('user/pwdsave');?>" method="post" onsubmit="return checkmyform()" >
			<table border="0" cellpadding="0" cellspacing="0" class="xtable">
				<tr>
					<th width="100">原密码：</th>
					<td><input type="password" name="oldpwd" class="px inp"  style="width:200px;"  /> *</td>
				</tr>
				<tr>
					<th>新密码：</th>
					<td><input type="password" name="pwd" class="px inp"  style="width:200px;"  /> *</td>
				</tr>
				<tr>
					<th>重复新密码：</th>
					<td><input type="password" name="repwd" class="px inp"  style="width:200px;"  /> *</td>
				</tr>
				<tr>
					<th></th>
					<td><input type="submit" value="确认修改" class="submit2"/></td>
				</tr>
			</table>
			</form>
			</div>
		</div>
	</div>
</div>

﻿<div class="foot_linksbg">
<div class="foot_links">
<div class="links">
<h3>PinMin</h3>
<div class="links_con">
<a href="#" target="_blank" title="贫民网站加盟">贫民网站加盟</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" target="_blank" title="贫民网站加盟">贫民网站加盟</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" target="_blank" title="南京贫民网站加盟">贫民网站加盟</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" target="_blank" title="长沙贫民网站加盟">长沙贫民网站加盟</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" target="_blank" title="邯郸贫民网站加盟">邯郸贫民网站加盟</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" target="_blank" title="长春贫民网站加盟">长春贫民网站加盟</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" target="_blank" title="深圳贫民网站加盟">深圳贫民网站加盟</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" target="_blank" title="成都贫民网站加盟">成都贫民网站加盟</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" target="_blank" title="上海贫民网站加盟">上海贫民网站加盟</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" target="_blank" title="贫民网站加盟">贫民网站加盟</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" target="_blank" title="深圳贫民网站加盟">深圳贫民网站加盟</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" target="_blank" title="北京贫民网站加盟">北京贫民网站加盟</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="#" target="_blank" title="微博推广">微博推广</a>
</div>
</div>
<div class="keyword">
<h3>HeZuo</h3>
<div class="links_con">
<a href="http://bbs.pinminwang.com" target="_blank"">贫民社区村</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="http://bbs.pinminwang.com/plugin.php?id=ssyyyshiting_dzx:music&mode=music" target="_blank"">贫民音乐插件</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="http://bbs.pinminwang.com" target="_blank"">贫民搜吧</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="http://www.pinminwang.com" target="_blank"">贫民信息网</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="http://bbs.pinminwang.com/misc.php?mod=mobile" target="_blank"">社区手机版</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="http://bbs.pinminwang.com/plugin.php?id=hadsky_jmail:hadsky_jmail" target="_blank"">在线群发</a>&nbsp;&nbsp;|&nbsp;&nbsp;
</div>
</div>
<div class="address">
<p><a href="www.pinminwang.com" title="">贫民网团队</a></p>
<p>办公室：北环花园路魏河花园</p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;河南省郑州市北环花园路刘庄魏河花园1号楼3单元1121室</p>
</div>
<div class="link_btn">
<ul >
<li><a href="http://shang.qq.com/open_webaio.html?sigt=a14b63050c08f43b9e0bda70c4069347c5e2d9de595a3f117ae7696bced7f5ab098f805e0ddb2238a1149567bdb17b12&sigu=5da7b35e3b819ac9df27b7a14453a060087a3927eed65b9f8e0cccdaaca2542fa7639cf1adab9c4b&tuin=11192139" target="_blank"title="" class="link_qq"></a></li>
<li><a href="#" title="" class="link_sina"></a></li>
<li class="link_weixin_li"><a href="http://98.pinminwang.com" title="" class="link_weixin"></a>
<div class="link_weixin_ewm">
<img src="template/kym_myshow/style/images/ewm.jpg" width="129" height="129" alt="">
</div>
</li>
</ul>
</div>
</div>
</div>
<div class="foot clear">
	<div class="copyright">
		<p>
		Copyright © 2014 <?php echo ($set["weburl"]); ?> 版权所有 <?php echo ($set["icp"]); ?>
 QQ：<?php echo ($set["qq"]); ?> E-mail：<?php echo ($set["email"]); ?> 地址：<?php echo ($set["address"]); ?>
工作时间 周一/周日 早上9点/晚11点
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1256541302'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/stat.php%3Fid%3D1256541302%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
<a class="bshareDiv" href="http://www.bshare.cn/share">分享按钮</a><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#uuid=&amp;style=4&amp;fs=4&amp;bgcolor=Green"></script>
            
		</p>
	</div>
</div></body>
</html>
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo ($set["webname"]); ?></title>
<meta name="keywords" content="<?php echo ($set["keywords"]); ?>"/>
<meta name="description" content="<?php echo ($set["description"]); ?>"/>
<link rel="stylesheet" type="text/css" href="__ROOT__/statics/home/css/style.css" />
<script type="text/javascript">
function checkmyform(){
	if(document.myform.username.value==''){
		alert('请填写用户名');
		document.myform.username.focus();
		return false;
	}
	var reg = /^(\w){6,20}$/;
	var user = document.myform.username.value;
	if(!reg.test(user)){
		alert("用户名格式不正确,只能输入6-20个字母、数字、下划线！");
		document.myform.username.focus();
		return false;
	}
	if(document.myform.password.value==''){
		alert('请填写密码');
		document.myform.password.focus();
		return false;
	}
	if(document.myform.repwd.value!=document.myform.password.value){
		alert('两次密码输入不一致')
		document.myform.repwd.focus();
		return false;
	}
	if(document.myform.qq.value==''){
		alert("请填写QQ号码");
		document.myform.qq.focus();
		return false;
	}
	if(isNaN(document.myform.qq.value)){
		alert("请输入正确的QQ号码");
		document.myform.qq.focus();
		return false;
	}
	
	document.myform.submit();
}
</script>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>
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
<div class="loginbg" style="background:url(__ROOT__/statics/home/images/bg8.jpg);">
	<div class="W">
		<div id="video">
		<embed type="application/x-shockwave-flash"
src="<?php echo ($set["indexspaddress"]); ?>"
wmode="transparent" id="movie_player" name="movie_player" bgcolor="#000000"
quality="high" allowfullscreen="true" flashvars="winType=adshow"
pluginspage="http://www.macromedia.com/go/getflashplayer"
width="600" height="380">
</embed>
</div>
		<div id="login">
			<div class="title">免费注册 REGISTER</div>
			<div class="con">
				<form name="myform" action="<?php echo u('index/regsave');?>" method="post" target="_blank">
				<table border="0" cellpadding="3" cellspacing="0" width="226">
					<tr>
						<td>用户名：</td>
					</tr>
					<tr>
						<td><input type="text" name="username" class="inp" style="width:200px"/></td>
					</tr>
					<tr>
						<td>密码：</td>
					</tr>
					<tr>
						<td><input type="password" name="password" class="inp" style="width:200px"/></td>
					</tr>
					<tr>
						<td>重复密码：</td>
					</tr>
					<tr>
						<td><input type="password" name="repwd" class="inp" style="width:200px"/></td>
					</tr>
					<tr>
						<td>QQ号码：</td>
					</tr>
					<tr>
						<td><input type="text" name="qq" class="inp" style="width:140px"/> @qq.com</td>
					</tr>
					<tr>
						<td>
							<a href="#" onClick="return checkmyform()"><img src="__ROOT__/statics/home/images/regbgt.jpg"/></a>
						</td>
					</tr>
					<tr>
						<td><a href="<?php echo u('index/login');?>"><u>已有账号登陆</u></a></td>
						<tr>
						<td><a href="/index_contact_id_3.html"><u>注册必看协议</u></a></td>
					</tr>
				</table>
				<input name="lastip" type="hidden" value="<?php echo ($regip); ?>">
				</form>
				<div style="height:30px;"></div>
			</div>
		</div>
	</div>
</div>

<div style="text-align:center;">

</div>
<div class="newsbg" id="news" style="margin-bottom:-10px;">
<div class="news clearbox">
<div class="news_box z">
<div class="news_title">
<a href="/index_news.html" title="">公司动态 <span>News</span></a>
</div>
<ul class="news_list" id="news_list">

<!--[diy=newslist1]--><div id="newslist1" class="area"><div id="frameY7vpPs" class="cl_frame_bm frame move-span cl frame-1"><div id="frameY7vpPs_left" class="column frame-1-c"><div id="frameY7vpPs_left_temp" class="move-span temp"></div><div id="portal_block_32" class="cl_block_bm block move-span"><div id="portal_block_32_content" class="dxb_bc"><li>
<span> 2014-04-29</span>

<a href="/index_contact_id_10.html" target="_blank" class="STYLE1">贫民网（书法院）泥猴张简介授权仪式</a>
</li>
<li>
<span> 2014-04-28</span>

<a href="/index_contact_id_11.html" target="_blank">贫民网（书法院）白建立简介</a>
</li><li>
<span> 2014-04-29</span>

<a href="/index_contact_id_12.html" target="_blank">贫民网（含义）</a>
</li><li>
<span> 2014-04-27</span>

<a href="/index_contact_id_13.html" target="_blank">贫民网证书（营业执照）</a>
</li><li>
<span> 2014-04-28</span>

<a href="/index_contact_id_14.html" target="_blank">贫民网（书法院）作品展示</a>
</li><li>
<span> 2014-04-18</span>

<a href="/index_contact_id_25.html" target="_blank">贫民网信息发布规定</a>
</li><li>
<span> 2014-04-29</span>

<a href="http://www.pinminwang.com/" target="_blank">更新中</a>
</li><li>
<span> 2014-04-18</span>

<a href="http://www.pinminwang.com/" target="_blank">更新中</a>
</li><li>
<span> 2014-04-18</span>

<a href="http://www.pinminwang.com/" target="_blank">更新中</a>
</li><li>
<span> 2014-04-29</span>

<a href="http://www.pinminwang.com/" target="_blank">更新中</a>
</li></div></div></div></div></div><!--[/diy]-->		
</ul>
</div>
<div class="news_line"></div>
<div class="news_box z">
<div class="news_title">
<a href="/index_news.html" title="">教程技术 <span>TUTORIALS</span></a>
</div>
<ul class="news_list" id="news_list">
<!--[diy=newslist2]--><div id="newslist2" class="area"><div id="framew5jMHQ" class="cl_frame_bm frame move-span cl frame-1"><div id="framew5jMHQ_left" class="column frame-1-c"><div id="framew5jMHQ_left_temp" class="move-span temp"></div><div id="portal_block_33" class="cl_block_bm block move-span"><div id="portal_block_33_content" class="dxb_bc"><li>
<span> 2014-10-06</span>
<a title=" 提高商品成交率的秘诀" href=" 	/index_show_id_286.html" target="_blank"> 提高商品成交率的秘诀</a>
</li><li>
<span> 2014-04-17</span>
<a href=" 	/index_contact_id_20.html" title=" QQ空间采集软件-贫民网联盟系统" target="_blank" class="STYLE1"> QQ空间采集软件-免费提供</a>
</li>
<li>
<span> 2014-04-17</span>
<a title=" qq号-qq空间采集-贫民网" href=" 	/index_contact_id_21.html" target="_blank"> qq号-qq空间采集-贫民网</a>
</li><li>
<span> 2014-04-13</span>
<a href=" 	index_contact_id_24.html" title=" 58赶集百姓手机商家采集" class="STYLE1"> 58赶集百姓手机商家采集</a>
</li>
<li>
<span> 2014-04-16</span>
<a title=" 快播从良：为何“发家致富了就忘了乡亲们”" href=" 	http://www.pinminwang.com/" target="_blank"> 更新中</a>
</li><li>
<span> 2014-04-13</span>
<a title=" 宁海前童古镇" href=" 	http://www.pinminwang.com/" target="_blank"> 更新中</a>
</li><li>
<span> 2014-04-17</span>
<a title=" 苹果或将弃用谷歌搜索 转投雅虎怀抱？" href=" 	http://www.pinminwang.com/" target="_blank"> 更新中</a>
</li><li>
<span> 2014-04-17</span>
<a title=" 受阿里准备上市影响 雅虎为解雇COO大出血" href=" 	http://www.pinminwang.com/" target="_blank"> 更新中</a>
</li><li>
<span> 2014-04-12</span>
<a title=" 互联网营销视频-网络赚钱" href=" 	/index_contact_id_23.html" target="_blank"> 互联网营销视频-网络赚钱</a>
</li><li>
<span> 2014-04-17</span>
<a title=" 数据库营销--核心技术理念" href=" 	/index_contact_id_22.html" target="_blank"> 数据库营销--核心技术理念</a>
</li></div></div></div></div></div><!--[/diy]-->	
</ul>
</div>
<div class="news_line"></div>
<div class="news_box fr">
<div class="news_title">
<a href="/index_news.html" title="">优势特权 <span>PRIVILEGE</span></a>
</div>
<ul class="news_list" id="news_list">
<!--[diy=newslist3]--><div id="newslist3" class="area"><div id="frameEX1P9Y" class="cl_frame_bm frame move-span cl frame-1"><div id="frameEX1P9Y_left" class="column frame-1-c"><div id="frameEX1P9Y_left_temp" class="move-span temp"></div><div id="portal_block_34" class="cl_block_bm block move-span"><div id="portal_block_34_content" class="dxb_bc"><li>
<span> 2014-04-13</span>
<a title=" 贫民网vip特权（组合套餐）" href=" 	/index_contact_id_17.html" target="_blank"> 贫民网vip特权（组合套餐）</a>
</li><li>
<span> 2014-04-13</span>
<a title=" 贫民网微信平台（组合套餐）价值10万" href=" 	/index_contact_id_18.html" target="_blank"> 贫民网微信平台价值10万</a>
</li><li>
<span> 2014-04-12</span>
<a title=" 贫民网微信公众号特权" href=" 	http://www.pinminwang.com/" target="_blank"> 更新中</a>
</li><li>
<span> 2014-04-13</span>
<a title=" 联盟系统如果推广" href=" 	http://www.pinminwang.com/" target="_blank"> 联盟系统如果推广</a>
</li><li>
<span> 2014-04-12</span>
<a title=" 贫民网特权价值" href=" 	http://www.pinminwang.com/" target="_blank"> 更新中</a>
</li><li>
<span> 2014-04-12</span>
<a href=" 	/index_contact_id_18.html" title=" 贫民网微信公众平台价值" target="_blank" class="STYLE1"> 贫民网微信公众平台价值</a>
</li>
<li>
<span> 2014-04-13</span>
<a title=" 联盟推广软件价值" href=" 	http://www.pinminwang.com/" target="_blank"> 更新中</a>
</li><li>
<span> 2014-04-13</span>
<a href=" 	/index_contact_id_19.html" title=" 普通会员如果免费开通推广" target="_blank" class="STYLE1"> 普通会员如何推广</a>
</li>
<li>
<span> 2014-04-13</span>
<a title=" 付费贫民网vip与普通会员区别" href=" 	http://www.pinminwang.com/" target="_blank"> 更新中</a>
</li><li>
<span> 2014-04-13</span>
<a title=" 贫民网总结" href=" 	http://www.pinminwang.com/" target="_blank"> 贫民网总结</a>
</li></div></div></div></div></div><!--[/diy]-->	
</ul>
</div>
<div class="clear"></div>
</div>
</div>
<div class="clear"></div>
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
</div>
</body>
</html>
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>申请提现--<?php echo ($set["webname"]); ?></title>
<meta name="keywords" content="<?php echo ($set["keywords"]); ?>"/>
<meta name="description" content="<?php echo ($set["description"]); ?>"/>
<link rel="stylesheet" type="text/css" href="__ROOT__/statics/home/css/style.css" />
<script type="text/javascript">
function checkmyform(){
	var money=<?php echo $user_info['money'];?>;
	if(document.myform.sum.value=='' || document.myform.sum.value==0){
		alert('请正确输入提现金额！');
		document.myform.sum.focus();
		return false;
	}
	if(document.myform.sum.value>money){
		alert('提现金额不能超过用户金额！');
		document.myform.sum.focus();
		return false;
	}
}
</script>
<style type="text/css">
<!--
.STYLE4 {font-size: 15px}
.STYLE6 {
	font-size: 16px;
	font-weight: bold;
}
.STYLE7 {color: #666666}
.STYLE8 {color: #0066FF}
.STYLE14 {color: #000000}
.STYLE27 {font-size: 13px}
.STYLE28 {color: #FF0000}
.STYLE29 {color: #0033FF}
.STYLE31 {font-size: 15px; color: #000000; }
.STYLE32 {
	color: #0000FF;
	font-weight: bold;
}
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
				<span class="t">申请提现</span>
			</div>
			<div class="con userinfo">
			<?php if($user_info["kahao"] == ''): ?><p style="padding:10px;font-size:14px;color:#ff0000;">
			你好！您未补全用户资料，无法提现！<a href="<?php echo u('user/account');?>" class="STYLE8">点击【马上补全】</a>　</p>
			<?php else: ?>
			<p style="padding:10px;font-size:14px;color:#ff0000;">
			<span class="STYLE14">您的 </span><strong><?php echo ($user_info["kaihu"]); ?></strong><span class="STYLE14"> 收款账号：</span><strong><?php echo ($user_info["kahao"]); ?></strong>，<span class="STYLE14">收款姓名：</span><strong><?php echo ($user_info["realname"]); ?></strong></p>
			<form name="myform" action="<?php echo u('user/apply');?>" method="post" onSubmit="return checkmyform()">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" class="xtable">
				<tr>
					<th width="100">
						用户名：					</th>
					<td><font style="font-size:16px;"><?php echo (session('username')); ?><span class="STYLE27"><span class="STYLE31"> 　</span>(如果您是<font color="#FF0000"><b>普通会员</b></font>，请先开通VIP会员后再进行提现操作)</span></span></font></td>
					<td></td>
				</tr>
				<tr>
							<td></td>
			  </tr>
						<tr>
							<th height="29">提现金额：</th>
						  <td><input type="text" name="sum" class="inp" size="10"  value="0" onKeyUp="this.value=this.value.replace(/D/g,'')" onafterpaste="this.value=this.value.replace(/D/g,'')"> 
							元 　可提现：<font style="font-size:20px;font-family:arial"><span class="STYLE6"><?php echo ($user_info["money"]); ?></span><span class="STYLE4">元　</span></font></td>
							<td></td>
						</tr>
						<tr>
							<th></th>
						  <td><input type="submit" class="submit2" value="确认提交申请" />
					        <span class="STYLE7"> 　（每日可提现</span><font color=red>1</font><span class="STYLE7">次，已成功提现</span><font color=red><?php echo ($over); ?></font><span class="STYLE7">次</span>） <br></td>
							<td></td>
						</tr>
			  </table>
			  </form><?php endif; ?>
				<div class="tit">
				<span class="t">提现记录</span>
			</div>			<div class="con userinfo">
			<table border="0" cellpadding="0" cellspacing="1" width="100%" class="border-table">
				<tr>
					<th width="60">编号</th>
					<th width="180">提现金额</th>
					<th width="180">申请时间</th>
					<th width="180">支付时间</th>
					<th width="60">状态</th>
					<th></th>
				</tr>
			  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr align="center">
					<td width="60"><?php echo ($val["xid"]); ?></td>
					<td width="180"><?php echo ($val["money"]); ?></td>
					<td width="180"><?php echo (date('Y-m-d H:i:s',$val["addtime"])); ?></td>
					<td width="180"><?php if($val['readdtime'] != 0): echo (date('Y-m-d H:i:s',$val["readdtime"])); endif; ?></td>
					<td width="60" style="color:#090;"><?php if($val['states'] == 0): ?>待付款
                                    <?php elseif($val['states'] == 1): ?>提现成功<?php endif; ?></td>
					<td></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
              </table>
			</div>
			<ul class="pageno"><?php echo ($page); ?></ul>
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
</div>
</body>
</html>
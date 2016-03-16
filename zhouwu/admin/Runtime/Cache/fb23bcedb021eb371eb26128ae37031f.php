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

<div class="pad_10">
<form action="<?php echo u('member/edit');?>" method="post" name="myform" id="myform">
<table width="100%" cellpadding="2" cellspacing="1" class="table_form">
	<tr> 
		<th width="100">用户名 :</th>
		<td><input type="text" name="user_name" id="user_name" class="input-text" value="<?php echo ($user_info["username"]); ?>" readonly="readonly"></td>
    </tr>
    <tr> 
		<th width="100">邮箱 :</th>
		<td><input type="text" name="email" id="email" class="input-text" value="<?php echo ($user_info["email"]); ?>"></td>
    </tr>
    <tr> 
		<th width="100">金额 :</th>
		<td><input type="text" name="money" id="money" class="input-text" value="<?php echo ($user_info["money"]); ?>"></td>
    </tr>
    
    <tr> 
		<th width="100">会员等级 :</th>
		<td><select name="vip" id="vip">
        	<?php if(is_array($vip_type_arr)): $i = 0; $__LIST__ = $vip_type_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($user_info['vip'] == $key): ?>selected="selected"<?php endif; ?>><?php echo ($val); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select> </td>
    </tr>

    <tr> 
		<th>密码 :</th>
		<td><input type="password" name="password" id="password" class="input-text"></td>
    </tr>
    <tr> 
		<th>确认密码 :</th>
		<td><input type="password" name="repassword" id="repassword" class="input-text"></td>
    </tr>
	<tr> 
		<th width="100">真实姓名 :</th>
		<td><input type="text" name="realname" id="realname" class="input-text" value="<?php echo ($user_info["realname"]); ?>"></td>
    </tr>
	<tr> 
		<th width="100">QQ :</th>
		<td><input type="text" name="qq" id="qq" class="input-text" value="<?php echo ($user_info["qq"]); ?>"></td>
    </tr>
	<tr> 
		<th width="100">开户行 :</th>
		<td><input type="text" name="kaihu" id="kaihu" class="input-text" value="<?php echo ($user_info["kaihu"]); ?>"></td>
    </tr>
	<tr> 
		<th width="100">卡号 :</th>
		<td><input type="text" name="kahao" id="kahao" class="input-text" value="<?php echo ($user_info["kahao"]); ?>"></td>
    </tr>
	<tr>
		<th>状态 :</th>
		<td>
      		<input type="radio" name="status" class="radio_style" value="1" <?php if($user_info["status"] == 1): ?>checked<?php endif; ?>> &nbsp;有效&nbsp;&nbsp;&nbsp;
        <input type="radio" name="status" class="radio_style" value="0" <?php if($user_info["status"] == 0): ?>checked<?php endif; ?>> &nbsp;禁用
		</td>
    </tr>
	<tr> 
		<th width="100">上级ID :</th>
		<td><input type="text" name="shangjia" id="shangjia" class="input-text" value="<?php echo ($user_info["shangjia"]); ?>"></td>
    </tr>
</table>
<input type="hidden" name="id" value="<?php echo ($user_info["id"]); ?>" />
<input type="submit" name="dosubmit" id="dosubmit" class="button" value="修改">  
<input type="button"  class="button" value="返回" onClick="javascript:history.back();return false;">
</form>

</div>
</body>
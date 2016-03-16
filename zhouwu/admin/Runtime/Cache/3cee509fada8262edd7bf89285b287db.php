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

<div class="pad-lr-10">
<form name="searchform" action="" method="get" >
    <table width="100%" cellspacing="0" class="search-form">
        <tbody>
            <tr>
            <td>
            <div class="explain-col">
				会员分类 :<select name="vipid" style="width:140px;">
					<option value="" <?php if($vipid == ''): ?>selected="selected"<?php endif; ?>>--所有会员--</option>
					<?php if(is_array($vip)): $i = 0; $__LIST__ = $vip;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($vipid == $key): ?>selected="selected"<?php endif; ?>><?php echo ($val); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
				搜索选项：<select name="searchtype" style="width:100px;">
				<option value="1" <?php if($searchtype == 1): ?>selected="selected"<?php endif; ?>>会员名称</option>
				<option value="2" <?php if($searchtype == 2): ?>selected="selected"<?php endif; ?>>邮箱</option>
				<option value="3" <?php if($searchtype == 3): ?>selected="selected"<?php endif; ?>>QQ</option>
				<option value="4" <?php if($searchtype == 4): ?>selected="selected"<?php endif; ?>>上家ID</option>
				<option value="5" <?php if($searchtype == 5): ?>selected="selected"<?php endif; ?>>注册IP地址</option>
				<option value="6" <?php if($searchtype == 6): ?>selected="selected"<?php endif; ?>>会员ID</option>
				</select>
                <input name="keyword" type="text" class="input-text" size="25" value="<?php echo ($keyword); ?>" />
                <input type="hidden" name="m" value="member" />
                <input type="submit" name="search" class="button" value="搜索" /> &nbsp;&nbsp;今日注册会员数：<font color="#FF0000" size="+1"><b><?php echo ($regcount); ?></b></font> 个&nbsp;&nbsp;今日有：<font color="#FF0000" size="+1"><b><?php echo ($logincount); ?></b></font> 个会员登录  &nbsp;&nbsp;初级VIP会员<font color="#FF0000" size="+1"><b><?php echo ($cjvipcount); ?></b></font> 个&nbsp;&nbsp;高级VIP会员<font color="#FF0000" size="+1"><b><?php echo ($gjvipcount); ?></b></font> 个
        	</div>
            </td>
            </tr>
        </tbody>
    </table>
    </form>
    <form id="myform" name="myform" action="<?php echo u('member/delete');?>" method="post" onsubmit="return check();">
    <div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
                    <th >ID</th>
                    <th ><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
              		<th >用户名</th>
              		<th >邮箱</th>
              		<th>登录时间/IP</th>
              		<th >用户组</th>
              		<th>真实姓名</th>
					<th>QQ</th>
              		<th>余额</th>
              		<th>上家ID</th>
              		<th>推广IP</th>
                    <th>佣金</th>
					<th>状态</th>
              		<th>操作</th>
            </tr>
        </thead>
    	<tbody>
        <?php if(is_array($user_list)): $i = 0; $__LIST__ = $user_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
        	<td align="center"><?php echo ($val["id"]); ?></td>
            <td align="center"><input type="checkbox" value="<?php echo ($val["id"]); ?>" name="id[]"></td>            
            <td align="center"><?php echo ($val["username"]); ?></td>
            <td align="center"><?php echo ($val["email"]); ?></td>
            <td align="center" title="注册时间是<?php echo (date('Y-m-d H:i:s',$val["regtime"])); ?>"><?php echo (timediff($val["last_time"])); ?><br/><?php echo ($val["lastip"]); ?><br/><?php echo (redip($val["lastip"])); ?></td>
            <td align="center"><?php if($val['vip'] == 1): ?><font color="#000000"><b>普通会员</b></font>
                            <?php elseif($val['vip'] == 2): ?><font color="#0000FF"><b>初级会员</b></font>
                            <?php else: ?><font color="#FF0000"><b>高级会员</b></font><?php endif; ?></td>
            <td align="center"><?php echo ($val["realname"]); ?></td>
            <td align="center"><?php echo ($val["qq"]); ?></td>
            <td align="center"><?php echo ($val["money"]); ?></td>
     		<td align="center"><?php echo ($val["shangjia"]); ?></td>
            <td align="center" onclick="deluserip(<?php echo ($val["id"]); ?>);"><span id="deluserip_<?php echo ($val["id"]); ?>"><?php echo ($val["ip"]); ?></span></td>
            <td align="center"><?php echo ($val["cash"]); ?><a href="<?php echo u('member/cash', array('uid'=>$val['id']));?>">查看</a></td>
            <td align="center" onclick="status(<?php echo ($val["id"]); ?>,'status')" id="status_<?php echo ($val["id"]); ?>"><img src="__ROOT__/statics/images/status_<?php echo ($val["status"]); ?>.gif" /></td>
            <td align="center"><a href="<?php echo u('member/edit', array('id'=>$val['id']));?>">编辑</a></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    	</tbody>
    </table>

    <div class="btn">
		<label for="check_box" style="float:left;">全选/取消</label>
		<input type="submit" class="button" name="dosubmit" value="删除" onclick="return confirm('你确定要删除吗？" style="float:left;margin-left:10px;"/>
		<div id="pages"><?php echo ($page); ?></div>
    </div>
    </div>
    </form>
</div>
<script language="javascript">
function status(id,type){
	if(confirm('你确认更改用户状态吗？')){
		$.get("<?php echo u('member/status');?>", { id: id, type: type }, function(jsondata){
			$("#"+type+"_"+id+" img").attr('src', '__ROOT__/statics/images/status_'+jsondata+'.gif');
		}); 
	}
}
function deluserip(uid){
	if(confirm('你确认清除会员推广IP吗？')){
		$.get("<?php echo u('member/deluserip');?>", { uid: uid}, function(jsondata){
			$("#deluserip_"+uid).html('0');
		}); 
	}
	 
}
</script>
</body>
</html>
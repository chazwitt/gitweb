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

<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    	<a class="add fb" href="<?php echo u('user/add');?>"><em>添加管理员</em></a>　
    </div>
</div>
<div class="pad-lr-10">
    <form id="myform" name="myform" action="<?php echo u('user/delete');?>" method="post" onsubmit="return check();">
    <div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width=60>ID</th>
                <th width=30><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
                <th width=100>用户名</th>
                <th>所属分组</th>
      			<th>开通时间</th>
                <th>上次登陆</th>
                <th width=60>状态</th>
                <th width=60>操作</th>
            </tr>
        </thead>
    	<tbody>
        <?php if(is_array($user_list)): $i = 0; $__LIST__ = $user_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
        	<td align="center"><?php echo ($val["id"]); ?></td>
            <td align="center"><input type="checkbox" value="<?php echo ($val["id"]); ?>" name="id[]" <?php if($val['user_name'] == 'admin'): ?>disabled="disabled"<?php endif; ?>></td>            
            <td align="center"><?php echo ($val["user_name"]); ?></td>
            <td align="center"><?php echo ($val["role_name"]); ?></td>
     		<td align="center"><?php echo (date('Y-m-d H:i:s',$val["add_time"])); ?></td>
            <td align="center"><?php echo (date('Y-m-d H:i:s',$val["last_time"])); ?></td>
            <td align="center" onclick="status(<?php echo ($val["id"]); ?>,'status')" id="status_<?php echo ($val["id"]); ?>"><img src="__ROOT__/statics/images/status_<?php echo ($val["status"]); ?>.gif" /></td>
            <td align="center"><a href="<?php echo u('user/edit', array('id'=>$val['id']));?>">编辑</a></td>
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
    $.get("<?php echo u('user/status');?>", { id: id, type: type }, function(jsondata){
		
		//var return_data  = eval("("+jsondata+")");
		$("#"+type+"_"+id+" img").attr('src', '__ROOT__/statics/images/status_'+jsondata+'.gif');
	}); 
}
</script>
</body>
</html>
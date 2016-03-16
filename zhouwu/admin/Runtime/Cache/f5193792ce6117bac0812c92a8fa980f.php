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
    	<a class="add fb" href="<?php echo u('ad/add');?>"><em>添加广告</em></a>　
    </div>
</div>
<div class="pad-lr-10">
  <form id="myform" name="myform" action="<?php echo u('ad/delete');?>" method="post" onsubmit="return check();">
    <div class="table-list">
      <table width="100%" cellspacing="0">
        <thead>
          <tr>
          	<th width=50>ID</th>
            <th width=30><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>            
            <th>广告名称</th>
            <th>广告链接</th>
            <th>广告类型</th>
            <th>广告位</th>
            <th width="60">排序</th>
            <th width="40">状态</th>
            <th width="80">操作</th>
          </tr>
        </thead>
        <tbody>
          <?php if(is_array($ad_list)): $i = 0; $__LIST__ = $ad_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>       
		 	<td align="center"><?php echo ($val["id"]); ?></td>   	
            <td align="center"><input type="checkbox" value="<?php echo ($val["id"]); ?>" name="id[]"></td>            
            <td align="center"><?php echo ($val["name"]); ?></td>
            <td align="center"><?php echo ($val["url"]); ?></td>
            <td align="center"><?php echo ($ad_type_arr[$val['type']]); ?></td>
            <td align="center"><?php echo ($val["adboard_name"]); ?></td>
            <td align="center"><input type="text" class="input-text-c input-text" value="<?php echo ($val["ordid"]); ?>" id="sort_<?php echo ($val["id"]); ?>" onblur="sort(<?php echo ($val["id"]); ?>,'ordid',this.value)" size="4" name="listorders[<?php echo ($val["id"]); ?>]"></td>
            <td align="center"><?php if($val["status"] == 1): ?><font class="green">开启</font>
            <?php else: ?>
            	<font color="red">关闭</font><?php endif; ?></td>
            <td align="center"><a href="<?php echo u('ad/edit', array('id'=>$val['id']));?>" class="blue" >编辑</a></td>
          </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
      </table>
<div class="btn">
    <label for="check_box">全选/取消</label>
    <input type="submit" class="button" name="dosubmit" value="删除" onclick="return confirm('确定要删除吗?')"/>
    
    <div id="pages"><?php echo ($page); ?></div>
    </div>
      
    </div>
  </form>
</div>
<script type="text/javascript">

//排序方法
function sort(id,type,num){
    
    $.get("<?php echo u('ad/sort');?>", { id: id, type: type,num:num }, function(jsondata){
        
		$("#"+type+"_"+id+" ").attr('value', jsondata);
	},'json'); 
}
</script>
</body></html>
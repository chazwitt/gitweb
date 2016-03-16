<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
    	<a class="add fb" href="<?php echo ($action); ?>"><em>添加文章</em></a>　
    </div>
</div>
<div class="pad-10" >
    <form name="searchform" action="" method="get" >
    <input type="hidden" name="child" value="<?php echo ($child); ?>" />
    <table width="100%" cellspacing="0" class="search-form">
        <tbody>
            <tr>
            <td>
            <div class="explain-col">
            	发布时间：         
				<link rel="stylesheet" type="text/css" href="__ROOT__/statics/js/calendar/calendar-blue.css"/>
			<script type="text/javascript" src="__ROOT__/statics/js/calendar/calendar.js"></script>
		<input class="date input-text" type="text" name="time_start" id="time_start" size="18" value="<?php echo ($time_start); ?>" />	
					<script language="javascript" type="text/javascript">
	                    Calendar.setup({
	                        inputField     :    "time_start",
	                        ifFormat       :    "%Y-%m-%d",
	                        showsTime      :    "true",
	                        timeFormat     :    "24"
	                    });
	     </script>
                -      
				
		<input class="date input-text" type="text" name="time_end" id="time_end" size="18" value="<?php echo ($time_end); ?>" />	
					<script language="javascript" type="text/javascript">
	                    Calendar.setup({
	                        inputField     :    "time_end",
	                        ifFormat       :    "%Y-%m-%d",
	                        showsTime      :    "true",
	                        timeFormat     :    "24"
	                    });
	     </script>
            	&nbsp;&nbsp;分类：
                <select name="cate_id" id="cate_id">
            	<option value="0">--请选择分类--</option>
                <?php echo ($cate_list); ?>
              </select>
                &nbsp;关键字 :
                <input name="keyword" type="text" class="input-text" size="25" value="<?php echo ($keyword); ?>" />
                <input type="hidden" name="m" value="article" />
                <input type="submit" name="search" class="button" value="搜索" />
        	</div>
            </td>
            </tr>
        </tbody>
    </table>
    </form>

    <form id="myform" name="myform" action="<?php echo u('article/delete',array('child'=>$child));?>" method="post" onsubmit="return check();">
    <div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
                <th width=50>ID</th>
                <th width=25><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>               
                <th width=280>标题名称</th>
                <th>所属分类</th>
                <th width=150>发布时间</th>
                <th width=60>排序</th>
                <th width="40">热门</th>
                <th width="40">推荐</th>
                <th width="40">状态</th>
				<th width="80">编辑</th>
            </tr>
        </thead>
    	<tbody>
        <?php if(is_array($article_list)): $i = 0; $__LIST__ = $article_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>       
		 	<td align="center"><a href="<?php echo u('article/edit', array('id'=>$val['id']));?>"><?php echo ($val["id"]); ?></a></td> 	
            <td align="center">
           	 <input type="checkbox" value="<?php echo ($val["id"]); ?>" name="id[]">
			</td>           
            <td align="left"><a class="blue" href="<?php echo u('article/edit', array('id'=>$val['id'],'child'=>$child));?>"><?php echo ($val["title"]); ?></a></td>
            <td align="center"><b><?php echo ($val["cate_name"]["name"]); ?></b></td>
            <td align="center"><?php echo ($val["add_time"]); ?></td>
            <td align="center"><input  type="text" class="input-text-c input-text" value="<?php echo ($val["sort"]); ?>" id="sort_<?php echo ($val["id"]); ?>" onblur="sort(<?php echo ($val["id"]); ?>,'sort',this.value)" size="4" name="listorders[<?php echo ($val["id"]); ?>]"></td>
            <td align="center" onclick="status(<?php echo ($val["id"]); ?>,'is_hot')" id="is_hot_<?php echo ($val["id"]); ?>"><img src="__ROOT__/statics/images/status_<?php echo ($val["is_hot"]); ?>.gif" /></td>
            <td align="center" onclick="status(<?php echo ($val["id"]); ?>,'is_best')" id="is_best_<?php echo ($val["id"]); ?>"><img src="__ROOT__/statics/images/status_<?php echo ($val["is_best"]); ?>.gif" /></td>
      		<td align="center" onclick="status(<?php echo ($val["id"]); ?>,'status')" id="status_<?php echo ($val["id"]); ?>"><img src="__ROOT__/statics/images/status_<?php echo ($val["status"]); ?>.gif" /></td>
			<td align="center"><a class="blue" href="<?php echo u('article/edit', array('id'=>$val['id'],'child'=>$child));?>">编辑</a></td><?php endforeach; endif; else: echo "" ;endif; ?>
    	</tbody>
    </table>

    <div class="btn">
    	<label for="check_box" style="float:left; cursor:pointer;">全选/取消</label>
    	<input type="submit" class="button" name="dosubmit" value="删除" onclick="return confirm('确定要删除吗?')" style="float:left;margin:0 10px 0 10px;"/>
    	
    	<div id="pages"><?php echo ($page); ?></div>
    </div>

    </div>
    </form>
</div>
<script language="javascript">

function status(id,type){
    $.get("<?php echo u('article/status');?>", { id: id, type: type }, function(jsondata){
		//var return_data  = eval("("+jsondata+")");
		$("#"+type+"_"+id+" img").attr('src', '__ROOT__/statics/images/status_'+jsondata+'.gif')
	}); 
}
//排序方法
function sort(id,type,num){
    
    $.get("<?php echo u('article/sort');?>", { id: id, type: type,num:num }, function(jsondata){
        
		$("#"+type+"_"+id+" ").attr('value', jsondata);
	},'json'); 
}
</script>
</body>
</html>
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

<link href="__ROOT__/statics/admin/css/main.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
$(function(){	
	$(".main_con").hover(
			  function () {
			    $(this).css("background","#ffffcc");
			  },
			  function () {
			    $(this).css("background","#ffffff");
			  }
	);
})
</script>
<div style="padding:10px; overflow:hidden;">
	
	<div style="width:50%;" class="fl">
		<div class="main_con fl">
			<h6>版权信息</h6>
			<div class="content">
								
				<p>财富贫民网</p>
				<p></p>				
				<div class="hr">QQ:11192139			
				</div>				
				<p>官方网址：<a href="http://caifu.pinminwang.com" target="_blank">http://www.9i-u.com</a></p>
			</div>
		</div>		
		<div class="main_con fl">
			<h6>配置信息</h6>
			<div class="content">				
				<?php if(is_array($server_info)): $i = 0; $__LIST__ = $server_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><p><?php echo ($key); ?> : <?php echo ($v); ?></p><?php endforeach; endif; else: echo "" ;endif; ?>
				<div class="hr">			
				</div>					
			
			</div>
		</div>
		
	</div>
	
</div>
</body>
</html>
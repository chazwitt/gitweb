<?php
return array(
	//可忽略的权限检查
	'IGNORE_PRIV_LIST'=>array(
		
		array(
			'module_name'=>'Index',
			'action_list'=>array('index','cache')
		),		
		array(
			'module_name'=>'Public',
			'action_list'=>array('login','menu','main')
		),
		array(
			'module_name'=>'Role',
			'action_list'=>array('auth_submit','ajax_check_name')
		),
		array(
			'module_name'=>'Group',
			'action_list'=>array('ajax_check_title')
		),
		array(
			'module_name'=>'User',
			'action_list'=>array('ajax_check_username')
		),	
		array(
			'module_name'=>'Email',
			'action_list'=>array('addemail','editemail','delemail','edittemplet','addtemplet','deltemplet','mass','savemass','edm','emailnum','edmdetail')
		),
		
	)
);
?>
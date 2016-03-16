<?php
class RoleModel extends Model
{	
	
   // 自动填充设置
  protected $_auto = array(
        array('status', '1', 1),
        array('create_time', 'time', 1, 'function'),
        array('update_time', 'time', 2, 'function'),
   );	
   
  
}
?>
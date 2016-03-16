<?php
class GroupModel extends Model
{	
	
   // 自动填充设置
  protected $_auto = array(
        array('status', '1', 1),
        array('create_time', 'time', 1, 'function'),
        array('update_time', 'time', 2, 'function'),
   );	
   
  public function check_title($title) {
    	
        $where = "title='$title'";      
        $id = $this->where($where)->getField('id');
        if ($id) {
        	//存在
            return false;
        } else {
        	//不存在
            return true;
        }
    }
	
}
?>
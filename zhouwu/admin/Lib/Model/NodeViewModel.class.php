<?php
class NodeViewModel extends ViewModel{
	public $viewFields=array(
	   'Node'=>array('*'),
	   'Group'=>array('id'=>'gid','title','_on'=>'Node.group_id=Group.id'),
	);
}

?>
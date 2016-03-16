<?php
class FlinkViewModel extends ViewModel{
	public $viewFields=array(
	   'Flink'=>array('*'),
	   'Flink_cate'=>array('id'=>'gid','cate_name','_on'=>'Flink.cate_id=Flink_cate.id'),
	);
}

?>
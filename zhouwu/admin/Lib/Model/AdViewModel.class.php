<?php
class AdViewModel extends ViewModel{
	public $viewFields=array(
	   'Ad'=>array('*'),
	   'Adboard'=>array('id'=>'gid','name'=>'adboard_name','_on'=>'Ad.board_id=Adboard.id'),
	);
}

?>
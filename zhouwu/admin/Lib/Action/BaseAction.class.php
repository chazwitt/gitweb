<?php
/**
 * 基础Action
 */
class BaseAction extends Action {
	
	function _initialize() {		
		
		// 用户权限检查
		$this->check_priv();
		//需要登陆
		$admin_info =$_SESSION['admin_info'];
		$role_mod=M("Role");
		//获取用户角色
		$admin_level=$role_mod->field('id','name')->where('id='.$_SESSION['admin_info']['role_id'].'')->find();
		$this->assign('admin_level',$admin_level);
		$this->assign('my_info', $admin_info);
        
		//获取权限节点
		$node_ids_res = M("Access")->where("role_id=".$_SESSION['admin_info']['role_id'])->getField("node_id");
		$node    =   M("Node");
		//读取该用户组的权限节点
		$node_id="";
		foreach(unserialize($node_ids_res) as $row){//通过反序列化取出数据
			$node_id.=$row.",";
		}
		$node_id=substr($node_id, 0,-1);//权限节点
		//获取结束
		
		//获取模块ID开始
		$where = "auth_type=0 and status=1  and id in($node_id)";
		$list = $node->cache(true)->where($where)->field(array('group_id'))->group('group_id')->select();
        $group_id="";
		foreach($list as $row){
			$group_id.=$row['group_id'].",";
		}
		$group_id=substr($group_id, 0,-1);//模块节点
		//获取模块ID结束
		
		// 顶部菜单
		$model	=	M("Group");
		$where = "status=1  and id in($group_id)";
		$top_menu	=$model->field('id,title')->where($where)->order('sort ASC')->select();
		$this->assign('module_name',MODULE_NAME);//模型
		$this->assign('action_name',ACTION_NAME);//操作
		$this->assign('top_menu',$top_menu);

        
	}
	//检查权限
	public function check_priv()
	{
		
		if ((!isset($_SESSION['admin_info']) || !$_SESSION['admin_info'])) {
			
			redirect(u('public/login'));
			exit;
		}
		
		//如果是超级管理员，则可以执行所有操作
		if($_SESSION['admin_info']['id'] == 1) {
			return true;
		}
		if(in_array(ACTION_NAME,array('status','sort'))){
			return true;
		}
		//排除一些不必要的权限检查
		foreach (C('IGNORE_PRIV_LIST') as $key=>$val){
			if(MODULE_NAME==$val['module_name']){
				if(count($val['action_list'])==0)return true;
				foreach($val['action_list'] as $action_item){
					if(ACTION_NAME==$action_item)return true;
				}
			}
		}
		
		$node_mod = M('Node');//节点表
		$node_id = $node_mod->where(array('module'=>MODULE_NAME, 'action'=>ACTION_NAME))->getField('id');
		$access_mod = M('Access');//授权表
		$rel = $access_mod->where("role_id=".$_SESSION['admin_info']['role_id'])->getField("node_id");
		$sub=strpos($rel,'"'.$node_id.'"');//查找字符串出现位置
		if ($sub==0) {
			$this->error('没有权限!',u('public/main'));
			exit;
		}
	}
	
	//截取中文字符串
	public function mubstr($str,$start,$length)
	{
		import('ORG.Util.String');
		$a = new String();
		$b = $a->msubstr($str,$start,$length);
		return($b);
	}
	//失败页面重写
	protected function error($message, $url_forward='',$ms = 3, $dialog=false, $ajax=false, $returnjs = '')
	{
		$this->jumpUrl = $url_forward;
		$this->waitSecond = $ms;
		$this->assign('dialog',$dialog);
		$this->assign('returnjs',$returnjs);
		parent::error($message, $ajax);
	}
	//成功页面重写
	protected function success($message, $url_forward='',$ms = 3, $dialog=false, $ajax=false, $returnjs = '')
	{
		$this->jumpUrl = $url_forward;
		$this->waitSecond = $ms;
		$this->assign('dialog',$dialog);
		$this->assign('returnjs',$returnjs);
		parent::success($message, $ajax);
	}

	
	/*
	 * 通用删除操作
	 * */
	public function delete(){
		$mod=D(MODULE_NAME);
		if (isset($_POST['id']) && is_array($_POST['id'])) {
			$ids = implode(',', $_POST['id']);
			$result=$mod->delete($ids);
		} else {
			$id = intval($_GET['id']);
			$result=$mod->delete($id);
		}

		if($result){
			$this->success("操作成功!");
		}else{
			$this->error("操作失败!");
		}
	}
	public function check_res($result){
		if($result){
			$this->success("操作成功!");
		}else{
			$this->error("操作失败!");
		}
	}
	/*
	 * 通用改变状态
	 * */
	public function status(){
		$mod = D(MODULE_NAME);
		$id     = intval($_REQUEST['id']);
		$type   = trim($_REQUEST['type']);
		$sql    = "update ".C('DB_PREFIX').MODULE_NAME." set $type=($type+1)%2 where id='$id'";
		$res    = $mod->execute($sql);
		$values = $mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}
	/*
	 * 通用排序方法单个排序
	 * */
	public function sort(){
		$mod = D(MODULE_NAME);
		$id     = intval($_REQUEST['id']);
		$type   = trim($_REQUEST['type']);
		$num=trim($_REQUEST['num']);
		if(!is_numeric($num)){
			$values = $mod->where('id='.$id)->find();			
			$this->ajaxReturn($values[$type]);
			exit;
		}
		$sql    = "update ".C('DB_PREFIX').MODULE_NAME." set $type=$num where id='$id'";
        
		$res    = $mod->execute($sql);
		$values = $mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}	
	
	
	/*
	 * 通用排序
	 * */
	public function sort_order(){
		$mod = D(MODULE_NAME);
		if (isset($_POST['listorders'])) {
			foreach ($_POST['listorders'] as $id=>$sort_order) {
				$data['sort_order'] = $sort_order;
				$mod->where('id='.$id)->save($data);
			}
			$this->success("操作成功!");
		}
		$this->error("操作失败!");
	}
	public function _stripcslashes($arr){
		if(ini_get('magic_quotes_gpc')!='1')return $arr;
		foreach ($arr as $key=>$val){
			$arr[$key]=stripcslashes($val);
		}
		return $arr;
	}
	//返回分页信息
	public function pager($count,$pagesize=20){
		import("ORG.Util.Page");
		$pager=new Page($count,$pagesize);
		$this->assign('page', $pager->show());
		return $pager;
	}
	public function append_user($res){
		foreach($res as $key=>$val){
			$res[$key]['user']=$this->user_mode->where('id='.$val['uid'])->find();
		}
		return $res;
	}	
	//公共上传图片方法
	public function _upload($savePath)
	{
		import("ORG.Net.UploadFile");
		$upload = new UploadFile();
		//设置上传文件大小
		$upload->maxSize = 32922000;
		$upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
		$upload->savePath = ROOT_PATH.'/upload/'.$savePath.'/';
		$upload->saveRule = uniqid;

		if (!$upload->upload()) {
			//捕获上传异常
			$this->error($upload->getErrorMsg());
		} else {
			//取得成功上传的文件信息
			$uploadList = $upload->getUploadFileInfo();
		}
		$uploadList='./upload/'.$savePath.'/'.$uploadList['0']['savename'];
		
		return $uploadList;
	}

 
	
    
}
?>

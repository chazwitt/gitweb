<?php
class RoleAction extends BaseAction
{
	function index()
	{
		
		$role_mod = M('Role');
		import("ORG.Util.Page");
		$count = $role_mod->count();
		$p = new Page($count,10);
		$role_list = $role_mod->cache(true)->limit($p->firstRow.','.$p->listRows)->select();
		$page = $p->show();
		$this->assign('page',$page);
		$this->assign('role_list',$role_list);
		$this->display();
	}
    //添加
	function add()
	{
		if(isset($_POST['dosubmit'])){
			$role_mod =D('Role');
			if(!isset($_POST['name'])||($_POST['name']=='')){
				$this->error('请填写角色名');
			}
			$result = $role_mod->where("name='".$_POST['name']."'")->count();
			if($result){
				$this->error('角色已经存在');
			}
			$role_mod->create();
			$result = $role_mod->add();
			if($result){
				//日志开始
				$operation="成功添加".$_POST['name']."用户组";
				addlog($_SESSION['admin_info']['id'],$operation,ACTION_NAME,ip());	
				//日志结束
				//删除缓存开始
		        self::cache();
		       //删除缓存结束
				$this->success('操作成功',u('Role/index'));
			}else{
				$this->error('操作失败');
			}
		}else{
			$this->display();
		}
	}
    //修改
	public function edit()
	{
		if(isset($_POST['dosubmit'])){
			$role_mod = D('Role');
			if (false === $role_mod->create()) {
				$this->error($role_mod->getError());
			}
			$result = $role_mod->save();
			if(false !== $result){
				//日志开始
				$operation="成功修改".$_POST['name']."用户组";
				addlog($_SESSION['admin_info']['id'],$operation,ACTION_NAME,ip());	
				//日志结束
				//删除缓存开始
		       self::cache();
		       //删除缓存结束
				$this->success('操作成功',u('Role/index'));
			}else{
				$this->error('操作失败');
			}
		}else{
			if( isset($_GET['id']) ){
				$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('参数错误');
			}
			$role_mod = D('Role');
			$role_info = $role_mod->where('id='.$id)->find();
			$this->assign('role_info', $role_info);
			$this->display();
		}
	}
    //删除
	function delete()
	{
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
			$this->error('请选择要删除的角色！');
		}
		$role_mod =M('Role');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
			$id = implode(',', $_POST['id']);
			$role_mod->delete($id);
		} else {
			$id = intval($_GET['id']);
			$role_mod->delete($id);
		}
		 //日志开始
		$operation="删除".$id."用户组";
		addlog($_SESSION['admin_info']['id'],$operation,ACTION_NAME,ip());	
		//日志结束
		//删除缓存开始
		self::cache();
		//删除缓存结束
		$this->success('操作成功',u('Role/index'));
	}

	//授权
	public function auth()
	{   
		$role_id = intval($_REQUEST['id']);
		$node_ids_res = M("Access")->where("role_id=".$role_id)->getField("node_id");
		$node_ids = array();
		foreach (unserialize($node_ids_res) as $row) {
			array_push($node_ids,$row);
		}
		//获取特殊权限
		$special=M('Special')->where("role_id=".$role_id)->find();
		//取出模块授权
		$modules = M("Node")->cache(true)->where("status = 1 and auth_type = 0")->order('group_id')->select();
		foreach ($modules as $k=>$v) {
			$modules[$k]['groupname']=M('Group')->where("id=".$v['group_id']."")->field("title")->find();
			$modules[$k]['actions'] = M("Node")->cache(true)->where("status=1 and auth_type>0 and module='".$v['module']."'")->select();
		}
		
		foreach ($modules as $k=>$module) {
			if (in_array($module['id'],$node_ids)) {
				$modules[$k]['checked'] = true;
			} else {
				$modules[$k]['checked'] = false;
			}
			foreach ($module['actions'] as $ak=>$action) {
				if(in_array($action['id'],$node_ids)) {
					$modules[$k]['actions'][$ak]['checked'] = true;
				} else {
					$modules[$k]['actions'][$ak]['checked'] = false;
				}
			}
		}
		//dump($modules);exit;
		$this->assign('access_list',$modules);		
		$this->assign('id',$role_id);
		$this->assign('special',$special);
		$this->display();
	}

	public function auth_submit()
	{  
		$role_id = intval($_REQUEST['id']);
		$access=M('Access');		
		$access->where("role_id=".$role_id)->delete();
		$node_ids = $_REQUEST['access_node'];
		//print_r($node_ids);exit;
		//foreach ($node_ids as $node_id) {
			$data=array();
			$data['role_id'] = $role_id;
			$data['node_id'] =serialize($node_ids);			
			$access->add($data);						
		//}
		//删除缓存开始
		self::cache();
		//删除缓存结束
		
		//特殊权限开始
		$special=M('Special');
		$special->where("role_id=".$role_id)->delete();
		if($_POST['special']){
			$data=array();
			$data['role_id'] = $role_id;
			$data['special'] =trim($_POST['special']);
			$special->add($data);
		}
		//特殊权限结束
	    //日志开始
		$operation="修改".$role_id."组权限";
		addlog($_SESSION['admin_info']['id'],$operation,ACTION_NAME,ip());	
		//日志结束
		$this->success('操作完成',u('role/index'));
	}
	//检查角色是否占用
	public function ajax_check_name()
	{
	    $name = $_GET['name'];
		$role_mod =M('Role');
		$where="name='".$name."'";
		$id = $role_mod->where($where)->getField('id');
        if ($id) {
        	//存在
            echo '0';
        } else {
        	//不存在
            echo '1';
        }
        exit;
	}
	
	
	//修改状态
	function status()
	{
		$role_mod = M('Mole');
		$id 	= intval($_REQUEST['id']);
		$type 	= trim($_REQUEST['type']);
		$sql 	= "update ".C('DB_PREFIX')."role set $type=($type+1)%2 where id='$id'";
		$res 	= $role_mod->execute($sql);
		$values = $role_mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}
	
	//清除缓存文件
	public  function  cache(){
		import("ORG.Io.Dir");
    	$dir = new Dir;
		if (is_dir(TEMP_PATH) )
		{
			$dir->del(TEMP_PATH);
		}
	}
	
	
	
}
?>
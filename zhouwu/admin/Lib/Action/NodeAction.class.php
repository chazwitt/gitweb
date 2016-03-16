<?php
class NodeAction extends BaseAction
{
	function index()
	{	

		$group_id = isset($_GET['group_id']) && intval($_GET['group_id']) ? intval($_GET['group_id']) : '';
		$keyword = isset($_GET['keyword']) && trim($_GET['keyword']) ? trim($_GET['keyword']) : '';
		$where = '1=1';
		if($group_id!=''){
			$where.=" AND group_id=$group_id";			
		}
		if($keyword!=''){
			$where.=" AND module like '%$keyword%' or module_name like '%$keyword%' or action_name like '%$keyword%'";
		}		
		$node_mod = M('Node');
		
		import("ORG.Util.Page");
		$count = $node_mod->where($where)->count();
		
		$p = new Page($count,10);
		$node_list = $node_mod->cache(true)->where($where)->limit($p->firstRow.','.$p->listRows)->order('module asc,sort asc')->select();	
		$page = $p->show();		
		$group_mod = M('Group');
		$group_list = $group_mod->select();
		$this->assign('group_list',$group_list);
		$this->assign('group_id',$group_id);
		$this->assign('keyword',$keyword);		
		$this->assign('page',$page);
		$this->assign('node_list',$node_list);
		$this->display();
	}

	function add()
	{
		//分组
		if(isset($_POST['dosubmit'])){
			if(!isset($_POST['module'])||($_POST['module']=='')){
				$this->error('请填写模型');
			}
			if(!isset($_POST['module_name'])||($_POST['module_name']=='')){
				$this->error('请填写模型名称');
			}

			$node_mod = M('Node');
			$node_mod->create();
			$result = $node_mod->add();
			if($result){
				//日志开始
				$operation="成功添加".$result."菜单";
				addlog($_SESSION['admin_info']['id'],$operation,ACTION_NAME,ip());	
				//日志结束
				
				//清除缓存
				RoleAction::cache();
				
				$this->success('操作成功',u('node/index'));
			}else{
				$this->error('操作失败',u('node/index'));
			}
		}else{
			$group_mod = M('Group');
			$group_list = $group_mod->select();
			$this->assign('group_list',$group_list);
			$this->display();
		}
	}

	public function edit()
	{
		if(isset($_POST['dosubmit'])){
			if(!isset($_POST['module'])||($_POST['module']=='')){
				$this->error('请填写模型');
			}
			if(!isset($_POST['module_name'])||($_POST['module_name']=='')){
				$this->error('请填写模型名称');
			}
			$node_mod = M('Node');
			if (false === $node_mod->create()) {
				$this->error($node_mod->getError());
			}
			$result = $node_mod->save();
			if(false !== $result){
				//清除缓存
				RoleAction::cache();
				$this->success('操作成功',u('node/index'));
			}else{
				$this->error('操作失败',u('node/index'));
			}

		}else{
			if( isset($_GET['id']) ){
				$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('参数错误',u('node/index'));
			}

			$group_mod = M('Group');
			$group_list = $group_mod->select();
			$this->assign('group_list',$group_list);

			$node_mod = M('Node');
			$node_info = $node_mod->where('id='.$id)->find();
			$this->assign('node_info', $node_info);
			$this->display();

		}
	}

	function delete()
	{
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
			$this->error('请选择要删除的角色！',u('node/index'));
		}
		$node_mod = M('Node');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
			$id = implode(',', $_POST['id']);
			$node_mod->delete($id);
		} else {
			$id = intval($_GET['id']);
			$node_mod->delete($id);
		}
		//日志开始
		$operation="成功删除".$id."菜单";
		addlog($_SESSION['admin_info']['id'],$operation,ACTION_NAME,ip());	
		//日志结束
		//清除缓存
		RoleAction::cache();
		$this->success('操作成功',u('node/index'));
	}
	public function status()
	{
		$mod = D(MODULE_NAME);
		$id     = intval($_REQUEST['id']);
		$type   = trim($_REQUEST['type']);
		$sql    = "update ".C('DB_PREFIX').MODULE_NAME." set $type=($type+1)%2 where id='$id'";
		$res    = $mod->execute($sql);
		$values = $mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}
	 /* 通用排序方法单个排序
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
		$module = $mod->where('id='.$id)->field('module')->find();
		$sql    = "update ".C('DB_PREFIX').MODULE_NAME." set $type=$num where module='".$module['module']."'";
        
		$res    = $mod->execute($sql);
		$values = $mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}
}
?>
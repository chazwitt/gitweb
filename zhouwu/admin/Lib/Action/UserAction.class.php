<?php

class UserAction extends BaseAction
{
	function index()
	{
		$user_mod = M('User');
		import("ORG.Util.Page");
		$prex = C('DB_PREFIX');
		$count = $user_mod->count();
		$p = new Page($count,30);

		$user_list = $user_mod->cache(true)->field($prex.'user.*,'.$prex.'role.name as role_name')->join('LEFT JOIN '.$prex.'role ON '.$prex.'user.role_id = '.$prex.'role.id ')->limit($p->firstRow.','.$p->listRows)->order($prex.'user.add_time DESC')->select();
		$key = 1;
		foreach($user_list as $k=>$val){
			$user_list[$k]['key'] = ++$p->firstRow;
		}
		$page = $p->show();
		$this->assign('page',$page);
		$this->assign('big_menu',$big_menu);
		$this->assign('user_list',$user_list);
		$this->display();
	}

	function add()
	{
	    if(isset($_POST['dosubmit'])){
	    	$user_mod = D('User');
			if(!isset($_POST['user_name'])||($_POST['user_name']=='')){
				$this->error('用户名不能为空');
			}
			if($_POST['password'] != $_POST['repassword']){
				$this->error('两次输入的密码不相同');
			}
			$result = $user_mod->where("user_name='".$_POST['user_name']."'")->count();
			if($result){
			    $this->error('管理员'.$_POST['user_name'].'已经存在');
			}
			unset($_POST['repassword']);
			$_POST['password'] = md5($_POST['password']);
			$user_mod->create();
			$user_mod->add_time = time();
			$user_mod->last_time = time();
			$result = $user_mod->add();
			if($result){
				//日志开始
				$operation="成功添加".$_POST['user_name']."用户";
				addlog($_SESSION['admin_info']['id'],$operation,ACTION_NAME,ip());	
				//日志结束
				//清除缓存
		        RoleAction::cache();
				$this->success('操作成功',__URL__);
			}else{
				$this->error('操作失败');
			}

	    }else{
		    $role_mod = M('Role');
		    $role_list = $role_mod->where('status=1')->select();
		    $this->assign('role_list',$role_list);
			$this->display();
	    }
	}

	function edit()
	{
		if(isset($_POST['dosubmit'])){
			$user_mod = M('User');
			$count=$user_mod->where("id!=".$_POST['id']." and user_name='".$_POST['user_name']."'")->count();
			if($count>0){
				$this->error('用户名已经存在！');
			}
			//print_r($count);exit;
			if ($_POST['password']) {
			    if($_POST['password'] != $_POST['repassword']){
				    $this->error('两次输入的密码不相同');
			    }
			    $_POST['password'] = md5($_POST['password']);
			} else {
			    unset($_POST['password']);
			}
			unset($_POST['repassword']);
			if (false === $user_mod->create()) {
				$this->error($user_mod->getError());
			}

			$result = $user_mod->save();
			if(false !== $result){
				//清除缓存
		        RoleAction::cache();
				$this->success('操作成功',u('user/index'));
			}else{
				$this->error('操作失败');
			}
		}else{
			if( isset($_GET['id']) ){
				$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('参数错误');
			}
			$role_mod = M('Role');
		    $role_list = $role_mod->where('status=1')->select();
		    $this->assign('role_list',$role_list);

		    $user_mod = M('User');
			$user_info = $user_mod->where('id='.$id)->find();
			$this->assign('user_info', $user_info);
			
			$this->display();
		}
	}

	function delete()
	{
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的会员！');
		}
		$user_mod = M('User');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
		    $id = implode(',', $_POST['id']);
		    $user_mod->delete($id);
		} else {
			$id = intval($_GET['id']);
			$user_mod->delete($id);
		}
		//日志开始
		$operation="成功删除".$id."用户";
		addlog($_SESSION['admin_info']['id'],$operation,ACTION_NAME,ip());	
		//日志结束
		//清除缓存
		RoleAction::cache();
		$this->success('操作成功',u('user/index'));
	}
    //检查用户名是否存在
	public function ajax_check_username()
	{
	    $user_name = $_GET['user_name'];
        $id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : '';
        if (D('User')->check_username($user_name,$id)) {
        	//不存在
            echo '1';
        } else {
        	//存在
            echo '0';
        }
        exit;
	}
	
	
	//检查旧密码
	public function ajax_check_pass(){
		
		
		$oldpassword = $_GET['oldpassword'];
        $id =$_SESSION['admin_info']['id'];
        if (D('User')->check_pass($oldpassword,$id)) {
        	//不存在
            echo '1';
        } else {
        	//存在
            echo '0';
        }
        exit;
		
		
		
	}
    
	//修改状态
	function status()
	{
		$user_mod = M('User');
		$id 	= intval($_REQUEST['id']);
		$type 	= trim($_REQUEST['type']);
		$sql 	= "update ".C('DB_PREFIX')."user set $type=($type+1)%2 where id='$id'";
		$res 	= $user_mod->execute($sql);
		$values = $user_mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}
}
?>
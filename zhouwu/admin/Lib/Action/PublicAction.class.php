<?php
class PublicAction extends Action {
	
	
   
	public function menu(){
//		//显示菜单项
		$id	=	intval($_REQUEST['tag'])==0?6:intval($_REQUEST['tag']);
		$menu  = array();
		$node_ids_res = M("Access")->where("role_id=".$_SESSION['admin_info']['role_id'])->getField("node_id");
		$node    =   M("Node");
		//读取该用户组的权限节点
		$node_id="";
		foreach(unserialize($node_ids_res) as $row){//通过反序列化转化数据
			$node_id.=$row.",";
		}
		$node_id=substr($node_id, 0,-1);//权限节点
		
		//读取数据库模块列表生成菜单项
		$where = "auth_type<>2 and status=1 and is_show=0 and group_id=".$id." and id in($node_id)";
		$list	=$node->cache(true)->where($where)->field('id,action,action_name,module,module_name,data,sort')->order('sort asc')->select();
		foreach($list as $key=>$action) {
			$data_arg = array();
			if ($action['data']){
				$data_arr = explode('&', $action['data']);
				foreach ($data_arr as $data_one) {
					$data_one_arr = explode('=', $data_one);
					$data_arg[$data_one_arr[0]] = $data_one_arr[1];
				}
			}
			$action['url'] = U($action['module'].'/'.$action['action'], $data_arg);
			if ($action['action']) {
				$menu[$action['module']]['navs'][] = $action;
			}
			$menu[$action['module']]['name']	= $action['module_name'];
			$menu[$action['module']]['id']	= $action['id'];
			$menu[$action['module']]['sort']	= $action['sort'];
		}
		//dump($menu);exit;
		$this->assign('menu',$menu);
		$this->display('left');
	}
//
//	/**	 
//	 * 后台主页
//	 */
	public function main()
	{
	
        $disk_space = @disk_free_space(".")/pow(1024,2);
		$server_info = array(
		   	
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],	
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',		
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '剩余空间'=>round($disk_space < 1024 ? $disk_space:$disk_space/1024 ,2).($disk_space<1024?'M':'G'),
		);
        $this->assign('set',$this->setting);
		$this->assign('server_info',$server_info);	
		$this->display();
	}
	//登陆
	public function login()
	{
		//unset($_SESSION);
		$admin_mod=M('User');
		if ($_POST) {
			$username = $_POST['username'] && trim($_POST['username']) ? trim($_POST['username']) : '';
			$password = $_POST['password'] && trim($_POST['password']) ? trim($_POST['password']) : '';
			if (!$username || !$password) {
				redirect(u('public/login'));
			}
			
			if ($_SESSION['verify'] != md5($_POST['verify']))
			{
				$this->error('验证码输入错误!');
			}
			
			//生成认证条件
			$map  = array();
			$map['user_name']	= $username;
			$map["status"]	=	array('gt',0);			
			$admin_info=$admin_mod->where("user_name='$username'")->find();

			//使用用户名、密码和状态的方式进行认证
			if(false === $admin_info) {
				$this->error('帐号不存在或已禁用！');
			}else {
				if($admin_info['password'] != md5($password)) {
					$this->error('密码错误！');
				}
               
				$_SESSION['admin_info'] =$admin_info;
				if($admin_info['user_name']=='admin') {
					$_SESSION['administrator'] = true;
				}
				$admin_mod->where(array('id'=>$admin_info['id']))->save(array('last_time'=>time()));
				$this->success('登录成功！',u('index/index'));
				exit;
			}
		}
		$this->display();
	}
	//修改密码
    public function pass(){
		
		if(isset($_POST['dosubmit'])){
			
			$user_mod = M('User');
			$data['password'] = md5($_POST['password']);
			$data['id'] = $_SESSION['admin_info']['id'];
			$user_mod->save($data);
			
			$this->success('操作成功!',u('public/pass'));
			
			
			
		}else{
		   $this->display();
		}
		
    }
	
	//基本设置
	public function config(){
		
		
		if($_POST){
			F('site',$_POST['site'],'./');
			$this->success('操作成功!',u('public/config'));

	     }else{
			$site=require './site.php';
			$this->assign('set',$site);
			$this->display();
		}
		
		
	}
	
	
	
	//退出
	public function logout()
	{
		if(isset($_SESSION['admin_info'])) {
			unset($_SESSION['admin_info']);			
			$this->success('退出登录成功！',u('public/login'));
		}else {
			$this->redirect(u('public/login'));
		}
	}
	//验证码
    public function verify(){
        import("ORG.Util.Image");
		ob_end_clean();
        Image::buildImageVerify();
    }

}
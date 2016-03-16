<?php
// 首页
class IndexAction extends EmptyAction {
	
	function _initialize() {
		
		$the_host = $_SERVER['HTTP_HOST'];//取得当前域名	
		/*
		$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';//判断地址后面是否有参数 
		if($the_host == 'yun818.net' || $request_uri == '/index.php')//把这里的域名换上你想要的   
		{   
			header('HTTP/1.1 301 Moved Permanently');//发出301头部   
			header('Location: http://www.yun818.net');//跳转到你希望的地址格式   
		}  
		*/
		$site=require './site.php';
		$this->assign('set',$site);
		
		if($site['userdomain']==1){//检查是否开启用户二级域名功能
			preg_match("#(.*?)\.#i", $_SERVER['HTTP_HOST'], $arr);
			$twodomain = $arr[1];//获取当前域名的前缀
			if($twodomain!="www"){//如果不是主域名就执行
				if(is_validuserid($twodomain)==1){//说明用户ID存在
					session('shangji',$twodomain);//记录上级用户ID
				}else{//不存在就跳转到网站首页
					redirect("http://".$site['weburl']);
				}
			}
		}
		
		
		$link=M('Flink');
		$flist=$link->where('status=1')->order('id desc')->select();
		$this->assign('flist',$flist);
		
	}
	
	//首页
    public function index(){
		$site = require './site.php';
		$sip = $site['ip'];
		if($site['userdomain']==1){//检查是否开启用户二级域名功能
			$uid = session('shangji');
		}else{
			$uid=$this->_get('uid');
			if($uid){
				session('shangji',$uid);
			}
		}
		
		
		if($uid){//记录推广人ID
		    $user_ip = M("Ip");
			if(!($user_ip->where("uid=".session('shangji')." and ip='".get_client_ip()."'")->find())){
				$ipcount = $user_ip->where("FROM_UNIXTIME(ADDTIME,'%Y-%m-%d')=CURDATE() and uid=".$uid)->count();//获取上级今天推广IP数
				if($ipcount>$sip*99999999){//
					//这里写帐号停用的方法
					$user_mod = M('Member');
					$data['status']=0;
			 		$user_mod->where('id='.$uid)->save($data);
				}else{
					//添加IP记录
					$data['uid'] = session('shangji');
					$data['ip'] = get_client_ip();
					$data['addtime'] = time();
					$user_ip->add($data);
				}				
			}
		}
		$this->assign('regip', get_client_ip());
	    $this->display();
    }
	
	//注册
	public function reg(){
		if(session('userid')){
			
		 redirect(u('user/index'));	
		}
		$this->assign('regip', get_client_ip());
		$this->display();
		
	}
	//保存注册信息
	public function regsave(){
		
		if($_POST){
			$user_mod = D('Member');
			if (!$user_mod->create()){
				// 如果创建失败 表示验证没有通过 输出错误提示信息
                 $this->assign("jumpUrl",U('index/reg'));
                 $this->error($user_mod->getError());

			}else{
				// 验证通过 可以进行其他数据操作
				
				if(trim($_POST['username'])==""){
					$this->error("用户名不能为空！",u('index/reg'));
				}
				if(trim($_POST['password'])==""){
					$this->error("用户密码不能为空！",u('index/reg'));
				}
				if(trim($_POST['qq'])==""){
					$this->error("邮箱不能为空！",u('index/reg'));
				}
				
				//判断IP一天只能注册一个用户
				$ip = get_client_ip();
				$iparr = explode('.' , $ip);
				$ip = $iparr[0] . '.' . $iparr[1] . '.' . $iparr[2];
				if($user_mod->where("lastip LIKE '%$ip%'")->find()){
					$this->error("同一个IP段只能注册一个帐号！",u('index/reg'));
				}
				//判断用户名是否存在
				if($user_mod->where("username='".trim($_POST['username'])."'")->find()){
					$this->error("帐号名称已经存在！",u('index/reg'));
				}
				//判断QQ邮箱是否存在
				if($user_mod->where("email='".trim($_POST['qq'])."@qq.com'")->find()){
					$this->error("邮箱已经存在！",u('index/reg'));
				}
				
				/*
				$data['username']=trim($_POST['username']);//用户名
				$data['password']=trim(md5($_POST['password']));//用户密码
				$data['qq']=trim($_POST['qq']);//用户QQ
				$data['email']=trim($_POST['qq'])."@qq.com";//用户邮箱
				if(session('shangji')){
					$data['shangjia']=session('shangji');//上家ID
				}
				$uid=$user_mod->add($data);//添加并获取用户ID
				*/
				
				if(session('shangji')){
					$user_mod->shangjia=session('shangji');
					$member = M('Member')->where(array('id' => session('shangji')))->find();
					$site = $site=require './site.php';
					if($member['vip'] == 1){
						$tgfee = $site['ptgfee'] ? $site['ptgfee'] : 0;
					}else{
						$tgfee = $site['vtgfee'] ? $site['vtgfee'] : 0;
					}
					M('Member')->where(array('id' => session('shangji')))->setInc('money' , $tgfee);
					$data['payuid'] = session('shangji');
					$data['pay'] = $tgfee;
					$data['addtime'] = time();
					$data['content'] = "推广" . trim($_POST['username']) . '会员注册';
					$data['state'] = "1";
					M('Cash')->add($data);
				}
				$user_mod->email=$_POST['qq']."@qq.com";
				$user_mod->vip=1;
				$uid=$user_mod->add();
				
				
				$user_mod = M('Member');
				$user_info=$user_mod->where('id='.$uid)->find();
				session('username',$user_info['username']);
			    session('userid',$user_info['id']);
			    session('vip',$user_info['vip']);
			
			    //记录登陆
			     $user_mod->where(array('id'=>$user_info['id']))->save(array('last_time'=>time(), 'lastip'=>get_client_ip()));
			     $user_mod->where('id='.$user_info['id'])->setInc('logtimes'); 
			
			
				//$this->success('注册成功！',u('index/emaildy'));
				$this->success('注册成功！',u('index/user_index'));				
			}
		}
	}
	//新闻
	public function news(){
		
		$news_mod = M('Article');
		import("ORG.Util.Page");
		$count = $news_mod->where('cate_id=19')->count();
		$p = new Page($count, 20);
		$list = $news_mod->field('id,cate_id,title,sort,is_hot,is_best,status,add_time')->where('cate_id=19')->limit($p->firstRow.','.$p->listRows)->order('id desc,sort desc')->select();
		$page = $p->show();
		$this->assign('page', $page);
		$this->assign('list', $list);
		$this->display();
		
	}
	//免费课程
	public function free(){
		
		$news_mod = M('Article');
		import("ORG.Util.Page");
		$count = $news_mod->where('cate_id=4')->count();
		$p = new Page($count, 20);
		$list = $news_mod->where('cate_id=4')->limit($p->firstRow.','.$p->listRows)->order('id desc')->select();
		$page = $p->show();
		$this->assign('page', $page);
		$this->assign('list', $list);
		$this->display();
		
	}
	//登陆
	public function login(){
		
		if(session('userid')){
			
		  redirect(u('user/index'));	
		}
		$this->display();
	}
	
	
	//看新闻
	public function show(){
		$id=$this->_get('id');
		$news_mod = M('Article');
		$site=require './site.php';
		$user_ip = M("Ip");
		$ipcount = $user_ip->where('uid='.session('userid'))->count();
		$page=$news_mod->where('id='.$id)->find();
		
		if($page['status']==0){//审核状态
			$this->error("资源未审核，稍后访问！",u('user/index'));
		}		
		
		$vip = $page['vip'];//获取文章阅读权限
		$uservip = session('vip');//用户权限
		
		if($vip==1){//说明是普通会员看的
			if((session('vip')<2 && $ipcount<$site['ip']) && $page['cate_id']==18){
				$this->error("去推广IP再查看或升级VIP会员",u('user/index'));
			}	
		}elseif($vip==2){//初级VIP会员看的
			if($uservip<2){
				$this->error("无权限访问 请开通权限！",u('user/index'));
			}
		}else{//高级VIP会员看的
			if($uservip!=3){
				$this->error("无权限访问 请开通权限！",u('user/index'));
			}
		}	
		

		$this->assign('page', $page);
		$this->display();
	}
	
	
	//联系我们
	public function contact(){
		$id=$this->_get('id');
		$page=M('Page');
		$p=$page->find($id);
		$this->assign('p',$p);
		$this->display();
		
	}
	//检查登陆
	public function checklogin(){
		$username=$this->_post('username');
		$password=$this->_post('password');
		$user_mod = M('Member');
		
		//生成认证条件
		$map  = array();
		$map['username']	= $username;
		$map['password']	= md5($password);
		//$map["status"]	=	array('gt',0);			
		$user_info=$user_mod->where($map)->find();
		if($user_info){
			if($user_info['status']==0){
				$this->error("你的帐号由于某种原因禁用，请联系网站客服处理!",u('index/login'));
			}
			session('username',$user_info['username']);
			session('userid',$user_info['id']);
			session('vip',$user_info['vip']);
			
			//记录登陆
			 $user_mod->where(array('id'=>$user_info['id']))->save(array('last_time'=>time(), 'lastip'=>get_client_ip()));
			 $user_mod->where('id='.$user_info['id'])->setInc('logtimes'); 
			
			
			redirect(u('user/index'));
		}else{
			 $this->error("用户名或密码有误",u('index/login'));
			//$this->redirect(u('index/login'));
			
		}
		
		
	}
	
	public function getpass(){
		$site=require './site.php';
		if($_POST){
			 
			$email=$this->_post('email');
			$username=$this->_post('uname');
			$user_mod = M('Member'); 
			$map  = array();
			$map['username']	= $username;
			$map['qq']	=  $email;
			$user_info=$user_mod->where($map)->find();
			
			 if($user_info){
				 
				 $pass=get_password(6);
				  $user_mod->where(array('username'=>$user_info['username']))->save(array('password'=>md5($pass)));
				 
				  $mailbody   =  '  <html>
						<table width="700" border="0" align="center" cellspacing="0" style="width:700px;"><tr><td>
								<div style="background-color:#f5f5f5;margin:0 auto;width:700px;">
									
									<div style="background-color:#fff;margin:0 15px;padding:30px 25px;">
										<p style="font-size:14px;margin:0 0 15px 0;font-weight:bold;">亲爱的<span style="color:#ff6600;">'.$user_info['username'].'</span>，</p>
										
										<p style="font-size:14px;margin:15px 0 20px 0;font-weight:bold;">这是您在<a href="http://'.$site['weburl'].'" target="_blank">'.$site['companyname'].'</a>注册的密码</br>密码：<span style="color:#ff6600;">'.$pass.'</span> </p>
										<div><a href="'.u("index/login").'" style="padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;">点击前往登陆</a></div>
										
										<p style="margin:30px 0 3px 0;font-size:12px;">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>
										<p style="color:#808080;margin:3px 0 0 0;font-size:12px;">'.u("index/login").'</p>
									</div>
									
								</div>
								</td></tr></table>
							
						</html>';
				// echo $user_info['email'];exit;
				  sendMail($user_info['email'],"【".$site['companyname']."】找回密码",$mailbody);
				 $this->success('新密码已发送到您的邮箱里，请登录邮箱查看！',u('index/login'));
				 
			 }else{
				 
				 
				$this->error("用户名或邮箱有误,请联系管理员",u('index/contact')); 
			 }
		}else{
		   $this->display();
		}
		
	}
	
	public function collect(){
		$site=require './site.php';
		$Shortcut = "[InternetShortcut]  
		URL=http://".$site['weburl']."/  
		IconFile=http://".$site['weburl']."/favicon.ico  
		IconIndex=1  
		IDList=  
		[{000214A0-0000-0000-C000-000000000046}]  
		Prop3=19,2  
		";  
		header("Content-type: application/octet-stream");  
		header("Content-Disposition: attachment; filename=".$site['webname'].".url;");  
		echo $Shortcut;  
	}
	
	public function emaildy(){
		 $user_mod = M('Member');
		 $email=$user_mod->where('id='.session('userid'))->getField('email');
		 		 
		 $this->assign('email', $email);
		
		 $this->display();
	}
	public function qqdy(){
		 $user_mod = M('Member');
		 $email=$user_mod->where('id='.session('userid'))->getField('email');
		 		 
		 $this->assign('email', $email);
		
		 $this->display();
	}
		/*
	 * 清除缓存
	 * */
    function cache()
    {
    	import("ORG.Io.Dir");
    	$dir = new Dir;
    	if (is_dir(CACHE_PATH) )
		{
			$dir->del(CACHE_PATH);
		}
		if (is_dir(TEMP_PATH) )
		{
			$dir->del(TEMP_PATH);
		}
		if (is_dir(LOG_PATH) )
		{
			$dir->del(LOG_PATH);
		}
		if (is_dir(DATA_PATH) )
		{
			$dir->del(DATA_PATH);
		}
		
		//数据库缓存
        if(is_dir(DATA_PATH . '_fields/')){
			$dir->del(DATA_PATH . '_fields/');
		}
		$runtime ='~runtime.php';
		$runtime_file_admin = RUNTIME_PATH . $runtime;
		is_file($runtime_file_admin) && @unlink($runtime_file_admin);
		$this->success('清除缓存成功', U('index/index'));
		
    }
	
}
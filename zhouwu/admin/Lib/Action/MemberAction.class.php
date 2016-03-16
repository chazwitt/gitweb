<?php

class MemberAction extends BaseAction
{
	function index()
	{
		$user_mod = M('Member');
		import("ORG.Util.Page");
		$where = '1=1';
		$searchtype = trim($_GET['searchtype']);//搜索类型
		if($searchtype==1){//会员名称
			if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
				 $where .= " and (username LIKE '%".$_GET['keyword']."%' or realname LIKE '%".$_GET['keyword']."%')";
			}
		}elseif($searchtype==2){//邮箱
			if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
				 $where .= " and email LIKE '%".$_GET['keyword']."%' ";
			}
		}elseif($searchtype==3){//QQ
			if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
				 $where .= " and qq LIKE '%".$_GET['keyword']."%' ";
			}
		}elseif($searchtype==4){//上家ID
			if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
				 $where .= " and shangjia =".$_GET['keyword'];
			}
		}elseif($searchtype==5){//注册IP
			if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
				 $where .= " and lastip ='".$_GET['keyword']."'";
			}
		}elseif($searchtype==6){// 会员ID
			if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
				 $where .= " and id =".$_GET['keyword'];
			}
		}
		$this->assign('searchtype',$_GET['searchtype']);
		$this->assign('keyword', $_GET['keyword']);
		if (isset($_GET['vipid']) && intval($_GET['vipid'])) {
			$where .= " and vip=" . $_GET['vipid'];
			$this->assign('vipid', $_GET['vipid']);
		}
		$vip = array('1' => '普通', '2' => '初级', '3' => '高级');
		$count = $user_mod->where($where)->count();
		
		//今日注册会员数
		$regcount = $user_mod->where("FROM_UNIXTIME(regtime,'%Y-%m-%d')=CURDATE()")->count();
		$this->assign('regcount',$regcount);
		//今日登录会员数
		$logincount = $user_mod->where("FROM_UNIXTIME(last_time,'%Y-%m-%d')=CURDATE()")->count();
		$this->assign('logincount',$logincount);
		//初级VIP会员数
		$cjvipcount = $user_mod->where("vip=2")->count();
		$this->assign('cjvipcount',$cjvipcount);
		//高级VIP会员数
		$gjvipcount = $user_mod->where("vip=3")->count();
		$this->assign('gjvipcount',$gjvipcount);
		
		$p = new Page($count,7);
		$user_list =$user_mod->where($where)->limit($p->firstRow.','.$p->listRows)->order('last_time desc,tixian desc')->select();
		$key = 1;
		$cash_mod=M('Cash');
		$ip_mod=M('Ip');
		foreach($user_list as $k=>$val){
			$user_list[$k]['cash'] = $cash_mod->where('payuid='.$val['id']." and state=0")->sum('pay');
			$user_list[$k]['ip'] = $ip_mod->where('uid='.$val['id'])->count();
		}
		$page = $p->show();
		$this->assign('page',$page);
		$this->assign('vip',$vip);
		$this->assign('big_menu',$big_menu);
		$this->assign('user_list',$user_list);
		//print_r($user_list);
		$this->display();
	}
    //佣金列表
	function cash(){
		$uid=$this->_get('uid');
		$this->assign('uid',$uid);
		$cash_mod=M('Cash');
		$user_mod = M('Member');
		import("ORG.Util.Page");
		$count = $cash_mod->where('payuid='.$uid)->count();
		$p = new Page($count,30);
		$list =$cash_mod->where('payuid='.$uid)->limit($p->firstRow.','.$p->listRows)->order('tid desc')->select();
		foreach($list as $k=>$val){
			$list[$k]['username'] = $user_mod->where('id='.$val['uid'])->getField('username');;
		}
		$page = $p->show();
		
		$yiScore = $cash_mod->where('state=1 and payuid='.$uid)->sum('pay');//已充值成功
		$weiScore = $cash_mod->where('state=0 and payuid='.$uid)->sum('pay');//已充值成功
		
		$this->assign('yiScore', $yiScore);
		$this->assign('weiScore', $weiScore);
		
		$this->assign('page',$page);
		$this->assign('list',$list);
		$this->display();
		
	}
	
	//支付佣金
	function savecash(){
		$id=$this->_get('id');
		$payuid=$this->_get('payuid');
		$pay=$this->_get('pay');
		$cash_mod=M('Cash');
		//更新状态
		$cash_mod->where(array('tid'=>$id))->save(array('state'=>1));
		//给上级钱
		$user_mod = M('Member');
		$userinfo=$user_mod->where('id='.$payuid)->find();
		$user_mod->where('id='.$payuid)->setInc('money',$pay); 
		//if($userinfo['email']){
		  //sendMail($userinfo['email'],"提现".$pay,"管理员已经给您提现".$pay.",请注意查收");
		//}
		echo 1;
	}
	

	function edit()
	{
		if(isset($_POST['dosubmit'])){
			$user_mod = M('Member');
			
			//print_r($count);exit;
			if ($_POST['password']) {
			    if($_POST['password'] != $_POST['repassword']){
				    $this->error('两次输入的密码不相同',u('member/index'));
			    }
			    $_POST['password'] = md5($_POST['password']);
			} else {
			    unset($_POST['password']);
			}
			unset($_POST['repassword']);
			if (false === $user_mod->create()) {
				$this->error($user_mod->getError(),u('member/index'));
			}

			$result = $user_mod->save();
			if(false !== $result){
				//日志开始
				$operation="编辑".$_POST['user_name']."会员";
				addlog($_SESSION['admin_info']['id'],$operation,ACTION_NAME,ip());	
				//日志结束
				$this->success('操作成功',u('member/index'));
			}else{
				$this->error('操作失败',u('member/index'));
			}
		}else{
			if( isset($_GET['id']) ){
				$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('参数错误',u('member/index'));
			}
			$vip_type_arr = array('1' => '普通', '2' => '初级', '3' => '高级');
			$this->assign('vip_type_arr',$vip_type_arr);
		    $user_mod = M('Member');
			$user_info = $user_mod->where('id='.$id)->find();
			$this->assign('user_info', $user_info);
			$this->display();
		}
	}
	
	//编辑留言
	function guestbookedit(){
		if(isset($_POST['dosubmit'])){
			$guestbook_mod = M('Guestbook');
			$date['reply'] = $_POST['reply'];
			$date['reply_date'] = date('Y-m-d H:i:s', time());
			$date['status'] = $_POST['status'];			
			$result = $guestbook_mod->where('id='.$_POST['id'])->save($date);
			if(false !== $result){
				$this->success('操作成功',u('member/guestbookedit',array('id' => $_POST['id'])));
			}else{
				$this->error('操作失败',u('member/guestbookedit',array('id' => $_POST['id'])));
			}
		}else{
			if( isset($_GET['id']) ){
				$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('参数错误',u('member/guestbook'));
			}
			$guestbook_mod = M('Guestbook');
			$guestbook_info = $guestbook_mod->where('id='.$id)->find();
			$this->assign('guestbook_info', $guestbook_info);
			$this->display();
		}
	}
	
	
	//添加会员页面
	function add()
	{
		$vip_type_arr = array('1' => '普通', '2' => '初级', '3' => '高级');
		$this->assign('vip_type_arr',$vip_type_arr);
		$this->display();
	}

	function delete()
	{
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的会员！',u('member/index'));
		}
		$user_mod = M('Member');
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
		$this->success('操作成功',u('member/index'));
	}
	
	
	function delchong()
	{
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的订单！',u('member/chongzhi'));
		}
		$chong_mod = M('Chongzhi');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
		    $id = implode(',', $_POST['id']);
		    $chong_mod->delete($id);
		} else {
			$id = intval($_GET['id']);
			$chong_mod->delete($id);
		}
		
		$this->success('操作成功',u('member/chongzhi'));
	}
    
    
	
	public function chongzhi(){
		$user_mod = M('Member');
		$chong_mod = M('Chongzhi');
		import("ORG.Util.Page");
		$searchtype = trim($_GET['searchtype']);//搜索类型
		$where = '1=1';
		if($searchtype==1){//充值成功
			 $where .= " and state=4";
		}elseif($searchtype==2){//充值失败
			 $where .= " and state<>4 ";
		}
		
		$this->assign('searchtype',$_GET['searchtype']);
		
		if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
			 $where .= " and (num LIKE '%".$_GET['keyword']."%')";
			$this->assign('keyword', $_GET['keyword']);
		}
		$count = $chong_mod->where($where)->count();
		$p = new Page($count, 20);
		$list = $chong_mod->where($where)->limit($p->firstRow.','.$p->listRows)->order('cid desc')->select();
		foreach($list as $k=>$val){
			$list[$k]['username'] = $user_mod->where('id='.$val['uid'])->getField('username');
		}
		$page = $p->show();
		
		$yiScore = $chong_mod->where('state=4')->sum('money');//已充值成功
		$weiScore = $chong_mod->where('state<>4')->sum('money');//已充值成功
		
		$this->assign('count', $count);
		$this->assign('yiScore', $yiScore);
		$this->assign('weiScore', $weiScore);
		$this->assign('page', $page);
		$this->assign('list', $list);
		$this->display();
	}
	
	
	public function tixian(){
		$user_mod = M('Member');
		$chong_mod = M('Tixian');
		import("ORG.Util.Page");
		$where = '1=1';
		if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
			 $where .= " and (num LIKE '%".$_GET['keyword']."%')";
			$this->assign('keyword', $_GET['keyword']);
		}
		$count = $chong_mod->where($where)->count();
		$p = new Page($count, 20);
		$list = $chong_mod->where($where)->limit($p->firstRow.','.$p->listRows)->order('xid desc')->select();
		foreach($list as $k=>$val){
			$list[$k]['username'] = $user_mod->where('id='.$val['uid'])->getField('username');
		}
		$page = $p->show();
		
		$yiScore = $chong_mod->where('states=1')->sum('money');//已充值成功
		$weiScore = $chong_mod->where('states=0')->sum('money');//已充值成功
		
		$this->assign('count', $count);
		$this->assign('yiScore', $yiScore);
		$this->assign('weiScore', $weiScore);
		$this->assign('page', $page);
		$this->assign('list', $list);
		$this->display();
	}
	//会员留言
	public function guestbook(){
		$guestbook_mod = M('Guestbook');
		import("ORG.Util.Page");
		$searchtype = trim($_GET['searchtype']);//搜索类型
		$where = '1=1';
		if($searchtype==1){//显示
			 $where .= " and status=1";
		}elseif($searchtype==2){//隐藏
			 $where .= " and status=0";
		}		
		$this->assign('searchtype',$_GET['searchtype']);
		
		if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
			 $where .= " and username='".$_GET['keyword']."'";
			$this->assign('keyword', $_GET['keyword']);
		}
		
		$count = $guestbook_mod->where($where)->count();
		$p = new Page($count, 20);
		$list = $guestbook_mod->field('id,userid,content,reply,addtime,reply_date,status,username')->where($where)->limit($p->firstRow.','.$p->listRows)->order('id desc')->select();
		$page = $p->show();
		$this->assign('count', $count);
		$this->assign('page', $page);
		$this->assign('list', $list);
		$this->display();
	}
		//支付佣金
	function savetixian(){
		$id=$this->_get('id');
		$uid=$this->_get('uid');
		$pay=$this->_get('pay');
		$cash_mod=M('Tixian');
		//更新状态
		$cash_mod->where(array('xid'=>$id))->save(array('states'=>1,'readdtime'=>time()));
		//支付
		//$user_mod = M('Member');
		//$userinfo=$user_mod->where('id='.$uid)->find();
		//$user_mod->where('id='.$uid)->setDec('money',$pay); 
		if($userinfo['email']){
		  sendMail($userinfo['email'],"提现".$pay,"管理员已经给您提现".$pay.",请注意查收");
		}
		echo 1;
	}
    //删除提现
	function deltixian()
	{
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的ID！',u('member/tixian'));
		}
		$chong_mod = M('Tixian');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
		    $id = implode(',', $_POST['id']);
		    $chong_mod->delete($id);
		} else {
			$id = intval($_GET['id']);
			$chong_mod->delete($id);
		}
		
		$this->success('操作成功',u('member/tixian'));
	}
	//删除留言
	function delguestbook()
	{
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的ID！',u('member/guestbook'));
		}
		$guestbook_mod = M('Guestbook');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
		    $id = implode(',', $_POST['id']);
		    $guestbook_mod->delete($id);
		} else {
			$id = intval($_GET['id']);
			$guestbook_mod->delete($id);
		}
		
		$this->success('操作成功',u('member/guestbook'));
	}
	//删除佣金记录
	function delcash()
	{
		$uid = $this->_post('uid');
	
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的ID！',u('member/cash',array('uid' => $uid)));
		}
		$cash_mod = M('Cash');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
		    $id = implode(',', $_POST['id']);
		    $cash_mod->delete($id);
		} else {
			$id = intval($_GET['id']);
			$cash_mod->delete($id);
		}
		
		$this->success('操作成功',u('member/cash',array('uid' => $uid)));
	}
    
	//修改状态
	function status()
	{	
		$user_mod = M('Member');
		$id 	= intval($_REQUEST['id']);
		$type 	= trim($_REQUEST['type']);
		$ip = get_client_ip();
		file_put_contents('./test.txt' , $ip . date('Y-m-d H:i:s' , time()) . $_SESSION['admin_info']['user_name'] . "\n" , FILE_APPEND);
		$sql 	= "update ".C('DB_PREFIX')."member set $type=($type+1)%2 where id='$id'";
		$res 	= $user_mod->execute($sql);
		$values = $user_mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}
	//修改留言状态
	function guestbookstatus()
	{
		$guestbook_mod = M('Guestbook');
		$id 	= intval($_REQUEST['id']);
		$type 	= trim($_REQUEST['type']);
		$sql 	= "update ".C('DB_PREFIX')."guestbook set $type=($type+1)%2 where id='$id'";
		$res 	= $guestbook_mod->execute($sql);
		$values = $guestbook_mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}
	//删除用户IP数
	function deluserip()
	{
		$uid = intval($_REQUEST['uid']);
		$ip_mod = M('Ip');
		$ip_mod ->where('uid='.$uid)->delete();
		$this->ajaxReturn(1,'成功',1);
	}
	
	//添加会员操作
	function adduser()
	{
		if($_POST){
			$user_mod = D('Member');
			if (!$user_mod->create()){
				// 如果创建失败 表示验证没有通过 输出错误提示信息
                 $this->assign("jumpUrl",U('member/add'));
                 $this->error($user_mod->getError());

			}else{
				// 验证通过 可以进行其他数据操作
				
				$user_mod->email=$_POST['qq']."@qq.com";
				$uid=$user_mod->add();		
			
				$this->success('添加会员成功！',u('member/index'));
			}
		}
	}

}
?>
<?php
// 首页
class UserAction extends EmptyAction {
	
	function _initialize() {
		if(!session('userid')){
			//$this->error("请重新登陆!",u('index/login'));
			redirect(u('index/login'));
		}
		
		$site=require './site.php';
		$user=M('Member');
		$user_info=$user->where('id='.session('userid'))->find();
		if($user_info['status']==0){//说明帐号被禁用
			session('userid',null);
			session('vip',null);
			$this->error("你的帐号由于某种原因禁用，请联系网站客服处理!",u('index/login'));
		}
		session('vip',$user_info['vip']);
		$this->assign('user_info',$user_info);
		$this->assign('set',$site);
		
		$link=M('Flink');
		$flist=$link->where('status=1')->order('id desc')->select();
		$this->assign('flist',$flist);
		
	}
	
	//首页
    public function index(){
		$user_mod = M('Member');
		$count = $user_mod->where('shangjia='.session('userid'))->count();
		$user_ip = M("Ip");
		$ipcount = $user_ip->where('uid='.session('userid'))->count();
		$this->assign('ipcount',$ipcount);
		$this->assign('count',$count);
		
		//$site=require './site.php';
		//$this->assign('set',$site);
		//公告
		$news_mod = M('Article');
		import("ORG.Util.Page");
		$ncount = $news_mod->where('status=1 and cate_id=18')->count();
		$p = new Page($ncount, 5);
		$list = $news_mod->where('status=1 and cate_id=18')->limit($p->firstRow.','.$p->listRows)->order('id desc')->select();
		$page = $p->show();
		$this->assign('page', $page);
		$this->assign('list', $list);
		
		
		
	    $this->display();
    }
	//个人资料
    public function account(){
		   $user=M('Member');
		if($_POST){
		    $realname=$this->_post('realname');
			$email=$this->_post('email');
			$qq=$this->_post('qq');
			$tel=$this->_post('tel');
			$address=$this->_post('address');
			$kaihu=$this->_post('kaihu');
			$kahao=$this->_post('kahao');
			if($qq == ''){
				$this->error('请填写QQ号码！');
			}
			if($tel == ''){
				$this->error('请填写电话！');
			}
			if($address == ''){
				$this->error('请填写地址！');
			}
			$data = array('realname'=>$realname,'email'=>$email,'qq'=>$qq,'tel'=>$tel,'address'=>$address,'kaihu'=>$kaihu,'kahao'=>$kahao);
            $user-> where('id='.session('userid'))->setField($data);
			$this->success('修改成功！',u('user/account'));
		   
		}else{
			
			$user_info=$user->where('id='.session('userid'))->find();
			$this->assign('user_info',$user_info);
			$this->display();
		}
    }
	
	//VIP课程
    public function vipindex(){
		
		$vip=$this->_get('vip');
		$cate=M('category');
		$news_mod = M('Article');
		if($vip==2){
			if(session('vip')<2){
				 $this->error("无权限访问，请开通权限",u('user/rule'));
			}
			
			$this->assign('title',"初级VIP课程");
		    $list=$cate->where('status=1 and pid=1')->order('sort asc,id desc')->select();
			foreach ($list as $k => $val) {
                $list[$k]['news'] = $news_mod->field('id,title,add_time,sort,cate_id')->where('status=1 and cate_id=' . $val['id'])->limit(10)->select();
            }
			
			
			
		}elseif($vip==3){
			
			if(session('vip')!=3){
				 $this->error("无权限访问，请开通权限",u('user/rule'));
			}
			$this->assign('title',"高级VIP课程");
			 $list=$cate->where('status=1 and pid=15')->order('sort asc,id desc')->select();
			foreach ($list as $k => $val) {
                $list[$k]['news'] = $news_mod->field('id,title,add_time,sort,cate_id')->where('status=1 and cate_id=' . $val['id'])->limit(10)->select();
            }
		}
		$this->assign('list',$list);
		
		
	    $this->display();
    }
	
	public function clist(){
		$cid=$this->_get('cid');
		$news_mod = M('Article');
		$cate=M('category');
		$catename = $cate->where('id='.$cid)->getField('name');
		import("ORG.Util.Page");
		$ncount = $news_mod->where('status=1 and cate_id='.$cid)->count();
		$p = new Page($ncount, 20);
		$list = $news_mod->where('status=1 and cate_id='.$cid)->limit($p->firstRow.','.$p->listRows)->order('id desc')->select();
		$page = $p->show();
		$this->assign('page', $page);
		$this->assign('list', $list);
		$this->assign('catename', $catename);
		$this->display();
	}
	
	//修改头像
	public function face(){
		if($_POST){
			
			if ($_FILES['face']['name'] != '') {
				$upload_list=$this->_upload('focus');
				 $user_mod = M('Member');
				 $user_mod->where(array('id'=>session('userid')))->save(array('face'=>$upload_list));
				 $this->success('修改成功！',u('user/face'));
			 }
		}else{
		   $this->display();
		}
		
	}
	
	//开通VIP
    public function rule(){
		if($_POST){
			$userinfo=$this->user_info;
			$vip=$this->_post('vip');//会员等级			
			$site=require './site.php';			
			$money=$userinfo['money'];//会员会员金额
			$chuji=$site['chuji'];//初级会费
			$vipfree=$site['vip'];//高级会费
			$cfree=$site['cfree'];//初级会费分成
			$vfree=$site['vfree'];//高级会费分成
			
			$cash_mod=M('Cash');//返利记录
			$flScore = $cash_mod->where('state=1 and payuid='.session('userid'))->sum('pay');//已返利成功			
			
				$chong_mod = M('Member');//会员充值记录
			//$yiScore = $chong_mod->where('state=4 and uid='.session('userid'))->sum('money');//已充值成功
			$yiScores = $chong_mod->where('id='.session('userid'))->find();//已充值成功
			$yiScore = $yiScores['money'];
			
			$user=M('Member');
			if($vip==2){//初级VIP会员
				if($userinfo['vip']==3){
					$this->error("您是高级VIP了，不要乱点了!",u('user/rule'));
				}
				if($userinfo['vip']==2){
					$this->error("您已经是初级VIP不用再升级!",u('user/rule'));
				}
				if($money<$chuji){//会员金额小于设置值时
					$this->error("余额不足，请充值后再开通！",u('user/pay'));
				}
				/*
				if($yiScore<$chuji || $flScore<$chuji){//用户充值金额小于要开通的金额 或 返利金额小于开通金额
					$this->error("二次判断，余额不足，请充值后再开通！".$flScore,u('user/pay'));
				}
				*/
				if($yiScore>$flScore){//如果充值金额大于返利金额
					if($yiScore<$chuji){//用户充值金额小于要开通的金额
						$this->error("二次判断，余额不足，请充值后再开通！",u('user/pay'));
					}
				}else{
					if($flScore<$chuji){//用户返利金额小于要开通的金额
						$this->error("二次判断，余额不足，请充值后再开通！",u('user/pay'));
					}
				}
				
				//支付记录
				if($userinfo['shangjia']!=0){
					$data['pay'] = $cfree;
					$data['payuid'] = $userinfo['shangjia'];
					M('Member')->where(array('id' => $userinfo['shangjia']))->setInc('money' , $cfree);
				}
				$data['uid'] = session('userid');
				$data['pmoney'] = $chuji;
				$data['addtime'] = time();
				$data['content'] = "升级初级会员";
				$data['state'] = "1";
				$cash_mod->add($data);
				
				//修改余额
				$user->where('id='.session('userid'))->setDec('money',$chuji); 
				$user->where(array('id'=>session('userid')))->save(array('vip'=>2));
				
				$this->success('升级成功！',u('user/rule'));
				
			}elseif($vip==3){//高级VIP会员
				if($userinfo['vip']==3){
					$this->error("您已经是高级VIP不用再升级!",u('user/rule'));
				}
				if($money<$vipfree){
					$this->error("余额不足，请充值后再开通！",u('user/pay'));
				}
				
				
				if($yiScore>$flScore){//如果充值金额大于返利金额
					if($yiScore<$vipfree){//用户充值金额小于要开通的金额
						$this->error("二次判断，余额不足，请充值后再开通！",u('user/pay'));
					}
				}else{
					if($flScore<$vipfree){//用户返利金额小于要开通的金额
						$this->error("二次判断，余额不足，请充值后再开通！",u('user/pay'));
					}
				}
						
			    if($userinfo['shangjia']!=0){
					$data['pay'] = $vfree;
					$data['payuid'] = $userinfo['shangjia'];
					M('Member')->where(array('id' => $userinfo['shangjia']))->setInc('money' , $vfree);
				}
				$data['uid'] = session('userid');
				$data['pmoney'] = $vipfree;
				$data['addtime'] = time();
				$data['content'] = "升级高级会员";
				$data['state'] = "1";
				$cash_mod->add($data);
				
				//修改余额
				$user->where('id='.session('userid'))->setDec('money',$vipfree); 
				$user->where(array('id'=>session('userid')))->save(array('vip'=>3));
				$this->success('升级成功！',u('user/rule'));
				
			}else{
				$this->error("朋友，本捣乱了，乖乖的去充值升级权限吧！",u('user/pay'));
			}
			
		}else{
		
	      $this->display();
		
		}
    }
	
	//充值
    public function pay(){
		$trade_no=date('YmdHis',time());
		$this->assign('trade_no', $trade_no);
	    $this->display();
    }
	
	//分销商
    public function union(){
        /*$user_mod = M('Member');
        $cash_mod = M('Cash');
		import("ORG.Util.Page");
		$count = $cash_mod->where('payuid='.session('userid'))->count();
		$p = new Page($count, 5);
		$list = $cash_mod->where('payuid='.session('userid'))->limit($p->firstRow.','.$p->listRows)->order('tid desc')->select();
		
		foreach($list as $k=>$val){
			$list[$k]['username'] = $user_mod->where('id='.$val['uid'])->getField('username');
			
		}
		$count2 = $user_mod->where('shangjia='.session('userid'))->count();
		$page = $p->show();
		$this->assign('count', $count);
		$this->assign('count2', $count2);
		$this->assign('page', $page);
		$this->assign('list', $list);*/
		/*import("ORG.Util.Page");
		$user_mod = M('Member');
		$count = $user_mod->where('shangjia='.session('userid'))->count();
		$this->assign('count', $count);
		$p = new Page($count, 5);
		$list = $user_mod->where('shangjia='.session('userid'))->limit($p->firstRow.','.$p->listRows)->order('id desc')->select();
		$page = $p->show();
		
		$this->assign('page', $page);
		$this->assign('list', $list);*/
		
		$this->assign('uid',session('userid'));
	    $this->display();
    }
	public function tguser(){
		import("ORG.Util.Page");
		$user_mod = M('Member');
		$count = $user_mod->where('shangjia='.session('userid'))->count();
		$this->assign('count', $count);
		$p = new Page($count, 10);
		$list = $user_mod->where('shangjia='.session('userid'))->limit($p->firstRow.','.$p->listRows)->order('id desc')->select();
		$page = $p->show();
		
		$this->assign('page', $page);
		$this->assign('list', $list);
		
	    $this->display();
	}
	//修改密码
    public function pwd(){
		
	    $this->display();
    }
	
	//保存密码
	public function pwdsave(){
		
		$oldpwd=$this->_post('oldpwd');
		$pwd=$this->_post('pwd');
		$user=M('Member');
		if($user->where("id=".session('userid')." and password='".md5($oldpwd)."'")->field('id,password')->find()){
			
			$data = array('password'=>md5($pwd));
            $user-> where('id='.session('userid'))->setField($data);
			$this->success('修改成功！',u('user/pwd'));
		}else{
			
			$this->error("密码有误",u('user/pwd'));
			
		}
	}
	//查看信息
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
			if((session('vip')<2) && $page['cate_id']==18){
				$this->error("升级VIP会员",u('user/index'));
			}	
		}elseif($vip==2){//初级VIP会员看的
			if($uservip<2){
				$this->error("您没有权限阅读该资源！",u('user/index'));
			}
		}else{//高级VIP会员看的
			if($uservip!=3){
				$this->error("您没有权限阅读该资源！",u('user/index'));
			}
		}	
		

		$this->assign('page', $page);
		$this->display();
	}
	
	//退出登陆
    public function out(){
		session('userid',null);
		session('vip',null);
	    redirect(u('index/login'));
    }
	
	//申请提现
	public function tixian(){
		$id=$this->_get('id');
		$user=M('Member');
		$data = array('tixian'=>time());
        $user-> where('id='.session('userid'))->setField($data);
		
	}
	
	public function record(){
		
		$chong_mod = M('Chongzhi');
		import("ORG.Util.Page");
		$count = $chong_mod->where('uid='.session('userid'))->count();
		$p = new Page($count, 20);
		$list = $chong_mod->where('uid='.session('userid'))->limit($p->firstRow.','.$p->listRows)->order('cid desc')->select();
		$page = $p->show();
		$this->assign('count', $count);
		$this->assign('page', $page);
		$this->assign('list', $list);
		$this->display();
	}
	
	public function apply(){
		$tixian_mod=M('Tixian');
		if($_POST){
		 $userinfo=$this->user_info;
		 $kahao=$userinfo['kahao'];
		 $kaihu=$userinfo['kaihu'];
		 $sum=$this->_post('sum');
		 $money=$userinfo['money'];
		 if($userinfo['vip']==1){$this->error("请升级VIP再提现!",u('user/rule'));}	
		 if($kahao==""){$this->error("请补充个人资料再提现!",u('user/account'));}
		 if($sum>$money){$this->error("提现金额大于余额!",u('user/account'));}	
			     
				 $addtime=$tixian_mod->where('uid='.session('userid'))->order('xid desc')->limit(1)->getField('addtime');
				
			$site=require './site.php';
			$txlimit = $site['txlimit'];
		 if($sum<$txlimit){$this->error("最少提现不得低于".$txlimit."元!请继续努力吧！",u('user/account'));}	
				 
		        $data['uid'] = session('userid');
				$data['kaihu'] = $kaihu;
				$data['kahao'] = $kahao;
				$data['money'] = $sum;
				$data['addtime'] = time();
				$tixian_mod->add($data);
				
				//减用户提现金额
				$user_mod = M('Member');
				$userinfo=$user_mod->where('id='.session('userid'))->find();
				$user_mod->where('id='.session('userid'))->setDec('money',$sum);				
				
				$this->success('提交申请成功！',u('user/apply'));	
		}else{
			
		    $over = $tixian_mod->where('uid='.session('userid').' and states=1')->count();
		    $this->assign('over', $over);		  
		  
			import("ORG.Util.Page");
			$count = $tixian_mod->where('uid='.session('userid'))->count();
			$p = new Page($count, 5);
			$list = $tixian_mod->where('uid='.session('userid'))->limit($p->firstRow.','.$p->listRows)->order('xid desc')->select();
			$page = $p->show();
			$this->assign('count', $count);
			$this->assign('page', $page);
			$this->assign('list', $list);
			$this->display();
		}
		
	}
	
	
	
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
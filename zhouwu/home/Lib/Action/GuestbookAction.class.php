<?php
// VIP留言
class GuestbookAction extends EmptyAction {
	
	function _initialize() {
		
		$the_host = $_SERVER['HTTP_HOST'];//取得当前域名		   
		$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';//判断地址后面是否有参数 
		if($the_host == '598chuangfu.com' || $request_uri == '/index.php')//把这里的域名换上你想要的   
		{   
			header('HTTP/1.1 301 Moved Permanently');//发出301头部   
			header('Location: http://www.598chuangfu.com');//跳转到你希望的地址格式   
		}  
		
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

	//列表
	public function show(){
		$guestbook_mod = M('Guestbook');
		import("ORG.Util.Page");
		$count = $guestbook_mod->where('status=1')->count();
		$p = new Page($count, 10);
		$list = $guestbook_mod->field('tp30_guestbook.id,tp30_guestbook.userid,tp30_guestbook.content,tp30_guestbook.reply,tp30_guestbook.addtime,tp30_guestbook.reply_date,tp30_guestbook.status,tp30_member.username')->join('tp30_member on tp30_guestbook.userid=tp30_member.id')->where('tp30_guestbook.status=1')->limit($p->firstRow.','.$p->listRows)->order('tp30_guestbook.id desc')->select();
		$page = $p->show();
		$this->assign('page', $page);
		$this->assign('list', $list);
		$this->display();
	}
	//添加留言
	public function add(){
		$content=$this->_post('content');//留言内容
		if(trim($content)==""){
			$this->error("留言内容不能为空！",u('guestbook/show'));
		}
		if(session('vip')<2){
			$this->error("只有VIP会员才有权限留言！",u('guestbook/show'));
		}
		$guestbook_mod = M('Guestbook');
		$data['content'] = $content;
		$data['userid'] = session('userid');
		$data['addtime'] = date('Y-m-d H:i:s', time());
		$data['ip'] = get_client_ip();
		$guestbook_mod->add($data);//添加留言
		$this->success('留言成功,等待管理员审核！',u('guestbook/show'));
	}
	
}
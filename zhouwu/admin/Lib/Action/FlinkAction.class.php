<?php
class FlinkAction extends BaseAction {
	function index() {
		$link_mod = D('FlinkView');
		import("ORG.Util.Page");
		//搜索
		$where = '1=1';
		if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
			 $where .= " and name LIKE '%".$_GET['keyword']."%'";
			$this->assign('keyword', $_GET['keyword']);
		}
		if (isset($_GET['cate_id']) && intval($_GET['cate_id'])) {
			$where .= " and cate_id=" . $_GET['cate_id'];
			$this->assign('cate_id', $_GET['cate_id']);
		}

		$count = $link_mod->where($where)->count();
		$p = new Page($count, 20);
		$link_list = $link_mod->where($where)->limit($p->firstRow.','.$p->listRows)->order('ordid ASC')->select();

		$flink_cate_mod = M('Flink_cate');
		$flink_cate_list = $flink_cate_mod->select();
		$this->assign('flink_cate_list', $flink_cate_list);


		$page = $p->show();
		$this->assign('page', $page);
		$this->assign('link_list', $link_list);
		$this->display();
	}

	function add() {
		if (isset($_POST['dosubmit'])) {

			$flink_mod = M('Flink');
			$data = array();
			$name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : $this->error(L('input') . L('flink_name'));
			$url = isset($_POST['url']) && trim($_POST['url']) ? trim($_POST['url']) : $this->error(L('input') . L('flink_url'));
			$exist = $flink_mod->where("url='" . $url . "'")->count();
			if ($exist != 0) {
				$this->error('该链接已经存在',u('flink/index'));
			}
			$data = $flink_mod->create();
			
			if ($_FILES['img']['name'] != '') {
				$upload_list=$this->_upload('flink');
				$data['img'] = $upload_list;
			}
			
			$flink_mod->add($data);
			$this->success('添加成功!',u('flink/index'));
		} else {
			$flink_cate_mod = M('Flink_cate');
			$flink_cate_list = $flink_cate_mod->select();
			$this->assign('flink_cate_list', $flink_cate_list);
			$this->display();
		}
	}

	function edit() {
		if (isset($_POST['dosubmit'])) {
			$flink_mod = M('Flink');
			$data = $flink_mod->create();
			
			if ($_FILES['img']['name'] != '') {
				@unlink($_POST['img2']);
				$upload_list=$this->_upload('flink');
				$data['img'] = $upload_list;
			}
			
			$result = $flink_mod->where("id=" . $data['id'])->save($data);
			if (false !== $result) {
				$this->success('操作成功!',u('flink/index'));
			} else {
				$this->error('操作失败!',u('flink/edit'));
			}
		} else {
			$flink_mod = M('Flink');
			if (isset($_GET['id'])) {
				$flink_id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('请选择要编辑的链接');
			}
			$flink_cate_mod = M('Flink_cate');
			$flink_cate_list = $flink_cate_mod->select();
			$this->assign('flink_cate_list', $flink_cate_list);

			$flink_info = $flink_mod->where('id=' . $flink_id)->find();
			$this->assign('flink_info', $flink_info);
			$this->display();
		}
	}

	function del() {
		$flink_mod = M('Flink');
		if ((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
			$this->error('请选择要删除的链接！');
		}
		if (isset($_POST['id']) && is_array($_POST['id'])) {
			$flink_ids = implode(',', $_POST['id']);
			
			//删除图片
			 foreach($_POST['id'] as $val){
				@unlink($flink_mod->where('id='.$val)->getField('img'));
			}
			
			
			$flink_mod->delete($flink_ids);
		} else {
			$flink_id = intval($_GET['id']);
			@unlink($flink_mod->where('id='.$id)->getField('img'));//删除图片
			$flink_mod->where('id=' . $flink_id)->delete();
		}
		$this->success('操作成功',u('flink/index'));
	}

	

	//修改状态
	function status() {
		$flink_mod = M('Flink');
		$id = intval($_REQUEST['id']);
		$type = trim($_REQUEST['type']);
		$sql = "update " . C('DB_PREFIX') . "flink set $type=($type+1)%2 where id='$id'";
		$res = $flink_mod->execute($sql);
		$values = $flink_mod->where('id=' . $id)->find();
		$this->ajaxReturn($values[$type]);
	}

	

}

?>
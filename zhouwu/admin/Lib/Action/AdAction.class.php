<?php

class AdAction extends BaseAction {

    function index() {
        $ad_mod = D('AdView');
        $adboard_mod = M('Adboard');
        import("ORG.Util.Page");
        $count = $ad_mod->count();
        $p = new Page($count, 20);
        $ad_list = $ad_mod->limit($p->firstRow . ',' . $p->listRows)->order('ordid ASC')->select();
        $page = $p->show();
        $this->assign('page', $page);
        $this->assign('ad_list', $ad_list);
        $ad_type_arr = array('image' => '图片', 'code' => '代码', 'flash' => 'Flash', 'text' => '文字');
        $this->assign('ad_type_arr', $ad_type_arr);
        $this->display();
    }

    function add() {
        if (isset($_POST['dosubmit'])) {
            $ad_mod = M('Ad');
            $adboard_mod = M('Adboard');
            $data = array();
            $name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : $this->error('请填写广告名称');
            $exist = $ad_mod->where("name='" . $name . "'")->count();
            if ($exist != 0) {
                $this->error('该广告已经存在');
            }

            $data = $ad_mod->create();
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
            //判断开始时间和结束时间是否合法
            if ($data['start_time'] >= $data['end_time']) {
                $this->error('开始时间必须小于结束时间');
            }
            //获取广告位信息
            $adboard_info = $adboard_mod->where('id=' . $board_id)->find();

            switch ($type) {
                case 'text':
                    $data['code'] = trim($_POST['text']);
                    break;
                case 'image':
                    if ($_FILES['image']['name'] != '') {
                        $data['code'] = $this->_upload($adboard_info);
                    }
                    break;
                case 'code':
                    $data['code'] = preg_replace("/[\s]{2,}/", "", $_POST['code']);
                    break;
                case 'flash':
                    if ($_FILES['flash']['name'] != '') {
                        $data['code'] = $this->_upload();
                    }
                    break;
                default :
                    $this->error('非法广告类型');
                    break;
            }
            $data['add_time'] = time();
            $ad_mod->add($data);
            $this->success('操作成功!', u('ad/index'));
        } else {
            $adboard_mod = M('Adboard');
            $result = $adboard_mod->where('status=1')->select();
            $this->assign('adboards', $result);
            $ad_type_arr = array('image' => '图片', 'code' => '代码', 'flash' => 'Flash', 'text' => '文字');
            $this->assign('ad_type_arr', $ad_type_arr);
            $this->display();
        }
    }

    function edit() {
        if (isset($_POST['dosubmit'])) {
            $ad_mod = M('Ad');
            $adboard_mod = M('Adboard');
            $data = array();
            $id = isset($_POST['id']) && intval($_POST['id']) ? intval($_POST['id']) : $this->error('参数错误');
            $name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : $this->error('请填写广告名称');
			$type = isset($_POST['type']) && trim($_POST['type']) ? trim($_POST['type']) : $this->error('非法广告类型');
			$board_id = isset($_POST['board_id']) && intval($_POST['board_id']) ? intval($_POST['board_id']) : $this->error('请选择广告位');
            $exist = $ad_mod->where("name='" . $name . "' AND id<>" . $id)->count();
            if ($exist != 0) {
                $this->error('该广告已经存在');
            }
           
            $data = $ad_mod->create();
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
            //判断开始时间和结束时间是否合法
            if ($data['start_time'] >= $data['end_time']) {
                $this->error('开始时间必须小于结束时间');
            }
            //获取广告位信息
            $adboard_info = $adboard_mod->where('id=' . $board_id)->find();
            switch ($type) {
                case 'text':
                    $data['code'] = trim($_POST['text']);
                    break;
                case 'image':

                    if ($_FILES['image']['name'] != '') {

                        @unlink(ROOT_PATH . "/upload/ad/" . $_POST['image1']);

                        $data['code'] = $this->_upload($adboard_info);
                    }
                    break;
                case 'code':
                    $data['code'] = preg_replace("/[\s]{2,}/", "", $_POST['code']);
                    break;
                case 'flash':
                    if ($_FILES['flash']['name'] != '') {
                        @unlink("./upload/ad/" . $_POST['flash1']);
                        $data['code'] = $this->_upload();
                    }
                    break;
                default :
                    $this->error('非法广告类型');
                    break;
            }
            $result = $ad_mod->where("id=" . $data['id'])->save($data);
            if (false !== $result) {
                $this->success('操作成功', u('ad/index'));
            } else {
                $this->error('操作失败', u('ad/index'));
            }
        } else {
            $ad_mod = M('Ad');
            $adboard_mod = M('Adboard');

            if (isset($_GET['id'])) {
                $id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('请选择要编辑的链接');
            }
            $ad_info = $ad_mod->where('id=' . $id)->find();
            $ad_info['start_time'] = date('Y-m-d H:i:s', $ad_info['start_time']);
            $ad_info['end_time'] = date('Y-m-d H:i:s', $ad_info['end_time']);

            $ad_info['code'] = stripslashes($ad_info['code']);
            $this->assign('ad_info', $ad_info);
            //print_r($ad_info);exit;
            $result = $adboard_mod->where('status=1')->select();
            $adboard_types = $this->get_type_list();
            $adboards = array();
            foreach ($result as $val) {
                $val['allow_type'] = implode('|', $adboard_types[$val['type']]['allow_type']);
                $adboards[] = $val;
            }
            $this->assign('adboards', $adboards);
            $ad_type_arr = array('image' => '图片', 'code' => '代码', 'flash' => 'Flash', 'text' => '文字');
            $this->assign('ad_type_arr', $ad_type_arr);
            $this->display();
        }
    }

    function delete() {
        $ad_mod = M('Ad');
        if ((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的链接！');
        }
        if (isset($_POST['id']) && is_array($_POST['id'])) {
            $ids = implode(',', $_POST['id']);
            //删除图片
            foreach ($_POST['id'] as $val) {
                @unlink(ROOT_PATH . "/upload/ad/" . $ad_mod->where('id=' . $val)->getField('code'));
            }
            $ad_mod->delete($ids);
        } else {
            $id = intval($_GET['id']);
            @unlink(ROOT_PATH . "/upload/ad/" . $ad_mod->where('id=' . $id)->getField('code')); //删除图片
            $ad_mod->where('id=' . $id)->delete();
        }
        $this->success('删除成功!', u('ad/index'));
        
    }

    public function _upload() {
        import("ORG.Net.UploadFile");
        $upload = new UploadFile();
        $upload->savePath = './upload/ad/';
        //设置上传文件规则
        $upload->saveRule = uniqid;
        if (!$upload->upload()) {
            //捕获上传异常
            $this->error($upload->getErrorMsg());
        } else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
        }
        return $uploadList[0]['savename'];
    }

    //获取广告位类型
    private function get_type_list() {
        $type_files = glob(ROOT_PATH . '/data/adboard/*.config.php');
        $type_list = array();
        foreach ($type_files as $file) {
            $basefile = basename($file);
            $key = str_replace('.config.php', '', $basefile);
            $type_list[$key] = include_once($file);
        }
        return $type_list;
    }

}
?>
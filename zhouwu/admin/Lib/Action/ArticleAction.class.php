<?php

class ArticleAction extends BaseAction {

    public function index() {
        $article_mod = M('Article');
        $cate_mod = M('Category');

        $child = isset($_GET['child']) && intval($_GET['child']) ? intval($_GET['child']) : $this->error('请选择频道ID');
        //搜索
        $where = '1=1';
        if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
            $where .= " AND title LIKE '%" . $_GET['keyword'] . "%'";
            $this->assign('keyword', $_GET['keyword']);
        }
        if (isset($_GET['time_start']) && trim($_GET['time_start'])) {
            $time_start = $_GET['time_start'];
            $where .= " AND add_time>='" . $time_start . "'";
            $this->assign('time_start', $_GET['time_start']);
        }
        if (isset($_GET['time_end']) && trim($_GET['time_end'])) {
            $time_end = $_GET['time_end'];
            $where .= " AND add_time<='" . $time_end . "'";
            $this->assign('time_end', $_GET['time_end']);
        }
        if (isset($_GET['cate_id']) && intval($_GET['cate_id'])) {
            $where .= " AND cate_id=" . $_GET['cate_id'];
            $this->assign('cate_id', $_GET['cate_id']);
        }
        import("ORG.Util.Page");
        $count = $article_mod->where($where)->count();
        $p = new Page($count, 20);
        $article_list = $article_mod->field('id,cate_id,title,sort,is_hot,is_best,status,add_time')->where($where)->limit($p->firstRow . ',' . $p->listRows)->order('add_time DESC,sort ASC')->select();

        $key = 1;
        foreach ($article_list as $k => $val) {
            $article_list[$k]['key'] = ++$p->firstRow;
            $article_list[$k]['cate_name'] = $cate_mod->field('name')->where('id=' . $val['cate_id'])->find();
        }
        if (F(MODULE_NAME . $child)) {
            $result = F(MODULE_NAME . $child); //读取缓存中的内容
        } else {
            $result = $cate_mod->where(array("child" => $child))->order("sort asc,id desc")->select(); //读取缓存中的内容 
            F(MODULE_NAME . $child, $result);
        }
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $_GET['cate_id'] ? 'selected' : '';
            $array[] = $r;
        }
        import('@.ORG.Tree');
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $tree = new Tree ();
        $tree->icon = array('│ ', '├─ ', '└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $tree->init($array);
        $cate_list = $tree->get_tree(0, $str, $_GET['cate_id']);

        $action = u('article/add', array('child' => $child));

        //网站信息/应用资讯
        $page = $p->show();
        $this->assign('page', $page);
        $this->assign('child', $child);
        $this->assign('action', $action);
        $this->assign('cate_list', $cate_list);
        $this->assign('article_list', $article_list);
        $this->display();
    }

    function edit() {
        if (isset($_POST['dosubmit'])) {
            $article_mod = M('Article');
            $data = $article_mod->create();
            if ($data['cate_id'] == 0) {
                $this->error('请选择资讯分类');
            }

            if ($_FILES['img']['name'] != '') {
                @unlink($_POST['imgurl']);
                $upload_list = $this->_upload('article');
                $data['img'] = $upload_list;
            }
            $result = $article_mod->save($data);
            if (false !== $result) {

                $this->success('修改成功!', U('article/index', array('child' => $_POST['child'])));
            } else {
                $this->error('操作失败!');
            }
        } else {
            $article_mod = M('article');
            $child = isset($_GET['child']) && intval($_GET['child']) ? intval($_GET['child']) : $this->error('请选择频道ID');
            if (isset($_GET['id'])) {
                $article_id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error("没有ID");
            }
            $article_info = $article_mod->where('id=' . $article_id)->find();
            //类别开始
            $cate_mod = M('Category');
            $cate_info = $cate_mod->where('id=' . $article_info['cate_id'])->find();
            $result = $cate_mod->where(array("child" => $child))->order('sort ASC')->select();
            foreach ($result as $r) {
                $r['selected'] = $r['id'] == $article_info['cate_id'] ? 'selected' : '';
                $array[] = $r;
            }
            import('@.ORG.Tree');
            $str = "<option value='\$id' \$selected >\$spacer \$name</option>";
            $tree = new Tree ();
            $tree->icon = array('│ ', '├─ ', '└─ ');
            $tree->nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $tree->init($array);
            $cate_list = $tree->get_tree(0, $str, $article_info['cate_id']);
            $this->assign('cate_list', $cate_list);
            //类别结束
            $this->assign('child', $child); //频道ID
            $this->assign('article', $article_info);
            $this->display();
        }
    }

    function add() {
        if (isset($_POST['dosubmit'])) {
            $article_mod = M('Article');
            if ($_POST['title'] == '') {
                $this->error("填写标题!");
            }
            if (false === $data = $article_mod->create()) {
                $this->error($article_mod->error());
            }

            if ($_FILES['img']['name'] != '') {
                $upload_list = $this->_upload('article');
                $data['img'] = $upload_list;
            }
            $data['add_time'] = date('Y-m-d H:i:s', time());
            $result = $article_mod->add($data);
            if ($result) {

                $this->success('添加成功', u('article/index', array('child' => $_POST['child'])));
            } else {
                $this->error('添加失败', u('article/index', array('child' => $_POST['child'])));
            }
        } else {
            $child = isset($_GET['child']) && intval($_GET['child']) ? intval($_GET['child']) : $this->error('请选择频道ID');
            //类别开始
            $cate_mod = M('Category');
            $result = $cate_mod->where(array("child" => $child))->order("sort asc,id desc")->select();
            foreach ($result as $r) {
                $array[] = $r;
            }
            import('@.ORG.Tree');
            $str = "<option value='\$id' >\$spacer \$name</option>";
            $tree = new Tree ();
            $tree->icon = array('│ ', '├─ ', '└─ ');
            $tree->nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $tree->init($array);
            $cate_list = $tree->get_tree(0, $str);
            //类别结束
            $this->assign('cate_list', $cate_list);
            $this->assign('child', $child);
            $this->display();
        }
    }

    function delete() {
        $article_mod = M('Article');
        if ((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的资讯！');
        }
        if (isset($_POST['id']) && is_array($_POST['id'])) {
            $cate_id = implode(',', $_POST['id']);
            foreach ($_POST['id'] as $val) {
                @unlink($article_mod->where('id=' . $val)->getField('img'));
            }
            $article_mod->delete($cate_id);
        } else {
            $cate_id = intval($_GET['id']);
            @unlink($article_mod->where('id=' . $cate_id)->getField('img'));
            $article_mod->where('id=' . $cate_id)->delete();
        }

        $this->success('删除成功!', u('article/index', array('child' => $_REQUEST['child'])));
    }

    //修改状态
    function status() {
        $article_mod = M('Article');
        $id = intval($_REQUEST['id']);
        $type = trim($_REQUEST['type']);
        $sql = "update " . C('DB_PREFIX') . "article set $type=($type+1)%2 where id='$id'";
        $res = $article_mod->execute($sql);
        $values = $article_mod->field("id," . $type)->where('id=' . $id)->find();
        $this->ajaxReturn($values[$type]);
    }

}

?>
<?php

class GroupAction extends BaseAction {

    function index() {
        $group_mod = M('group');
        $group_list = $group_mod->cache(true)->order('sort asc')->select();
        $this->assign('group_list', $group_list);
        $this->display();
    }

    //增加
    function add() {
        if (isset($_POST['dosubmit'])) {
            $group_mod = D('Group');
            if (!isset($_POST['title']) || ($_POST['title'] == '')) {
                $this->error("请输入菜单分类名称");
            }
            $result = $group_mod->where("title='" . $_POST['title'] . "'")->count();
            if ($result) {
                $this->error("菜单名称已经存在!");
            }
            if ($group_mod->create()) {
                $rel = $group_mod->add();
                if (false !== $rel) {
                    //日志开始
                    $operation = "成功添加" . $_POST['title'] . "菜单";
                    addlog($_SESSION['admin_info']['id'], $operation, ACTION_NAME, ip());
                    //日志结束
                    //清除缓存
                    RoleAction::cache();
                    $this->success('操作成功', u('group/index'));
                } else {
                    $this->error('操作失败');
                }
            } else {
                $this->error($group_mod->getError());
            }
        } else {
            $this->display();
        }
    }

    //修改
    function edit() {
        if (isset($_POST['dosubmit'])) {
            $group_mod = D('Group');
            $count = $group_mod->where("id!=" . $_POST['id'] . " and title='" . $_POST['title'] . "'")->count();
            if ($count > 0) {
                $this->error('菜单分类名称已经存在');
            }
            if (false === $group_mod->create()) {
                $this->error($group_mod->getError());
            }
            $result = $group_mod->save();
            if (false !== $result) {
                //日志开始
                $operation = "成功修改" . $_POST['title'] . "菜单";
                addlog($_SESSION['admin_info']['id'], $operation, ACTION_NAME, ip());
                //日志结束
                //清除缓存
                RoleAction::cache();
                $this->success('操作成功', u('group/index'));
            } else {
                $this->error('操作失败');
            }
        } else {
            if (isset($_GET['id'])) {
                $id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('参数错误');
            }
            $group_mod = D('Group');
            $group_info = $group_mod->where('id=' . $id)->find();
            $this->assign('group_info', $group_info);
            $this->display();
        }
    }

    //删除
    function delete() {
        if ((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的信息');
        }
        $group_mod = D('Group');
        if (isset($_POST['id']) && is_array($_POST['id'])) {
            $id = implode(',', $_POST['id']);
            $group_mod->delete($id);
        } else {
            $id = intval($_GET['id']);
            $group_mod->delete($id);
        }
        //日志开始
        $operation = "成功删除" . $id . "菜单";
        addlog($_SESSION['admin_info']['id'], $operation, ACTION_NAME, ip());
        //日志结束
        //清除缓存
        RoleAction::cache();
        $this->success('操作成功');
    }

    public function ajax_check_title() {


        $title = $_GET['title'];
        if (D('Group')->check_title($title)) {
            //不存在
            echo '1';
        } else {
            //存在
            echo '0';
        }
        exit;
    }

    /* 通用排序方法单个排序
     * */

    public function sort() {
        $mod = D(MODULE_NAME);
        $id = intval($_REQUEST['id']);
        $type = trim($_REQUEST['type']);
        $num = trim($_REQUEST['num']);
        if (!is_numeric($num)) {
            $values = $mod->where('id=' . $id)->find();
            $this->ajaxReturn($values[$type]);
            exit;
        }
        $sql = "update " . C('DB_PREFIX') . MODULE_NAME . " set $type=$num where id='$id'";

        $res = $mod->execute($sql);
        $values = $mod->where('id=' . $id)->find();
        $this->ajaxReturn($values[$type]);
        
        
    }

    /*
     * 通用改变状态
     * */

    public function status() {
        $mod = D(MODULE_NAME);
        $id = intval($_REQUEST['id']);
        $type = trim($_REQUEST['type']);
        $sql = "update " . C('DB_PREFIX') . MODULE_NAME . " set $type=($type+1)%2 where id='$id'";
        $res = $mod->execute($sql);
        $values = $mod->where('id=' . $id)->find();
        $this->ajaxReturn($values[$type]);
    }

}

?>
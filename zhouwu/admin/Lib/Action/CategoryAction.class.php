<?php

class CategoryAction extends BaseAction
{
   public  function _initialize()
	{
		
		$this->assign('module_name',MODULE_NAME);//模型
		$this->assign('action_name',ACTION_NAME);//操作
	}
	//分类列表
    public function index()
    {   
	    $child = isset($_GET['child']) && intval($_GET['child']) ? intval($_GET['child']) : $this->error('没有频道ID',U('public/main'));
	    $cate_mod=M('Category');
		import ( '@.ORG.Tree' );
		$tree = new Tree();
        $tree->icon = array('│ ','├─ ','└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	    $result = $cate_mod->where(array("child"=>$child))->order("sort asc,id desc")->select();
        $array = array();
        foreach($result as $r) {
			
           $r['str_status'] = '<img  src="__ROOT__/statics/images/status_' . $r['status'] . '.gif" />';//状态
		   $r['sort']='<input type="text" class="input-text-c input-text" value="'.$r['sort'].'" id=sort_'.$r['id'].' onblur="sort('.$r['id'].',\'sort\',this.value)" size=4 name=listorders['.$r['id'].']>';//排序
		   $r['str_manage']='<a href="'.u('category/add', array('id'=>$r['id'],'child'=>$child)).'">添加子栏目</a>   |  <a href="'.u('category/edit', array('id'=>$r['id'],'child'=>$child)).'">编辑</a>';//操作
            $array[] = $r;
        }
        $str  = "<tr>
                <td align='center'><input type='checkbox' value='\$id' name='id[]' ></td>
                <td>\$spacer\$name</td>
                <td align='center'>\$id</td>
                <td align='center'>\$sort</td>
                <td align='center' onClick=status(\$id,'status') id=status_\$id>\$str_status</td>
                <td align='center'>\$str_manage</td>
                </tr>";
        $tree->init($array);
        $list = $tree->get_tree(0, $str);
		$this->assign('list', $list);
		//$action=u($module_name.'/add',array('child'=>$child));
		//$this->assign('action', $action);
		$this->assign('child', $child);
		$this->display();
    }
	
	//添加
	public function add(){
		
		if(isset($_POST['dosubmit'])){
			$cate_mod = M('Category');
	        if( false === $vo = $cate_mod->create() ){
		        $this->error( $cate_mod->error() );
		    }
		    if($vo['name']==''){
		    	$this->error('分类名称不能为空');exit;
		    }
		    $result = $cate_mod->where("name='".$vo['name']."' and pid='".$vo['pid']."'")->count();
		    if($result != 0){
		        $this->error('该分类已经存在',u('Category/add', array('child'=>$_POST['child'])));
		    }
			//保存当前数据
		    $cate_id = $cate_mod->add();
		    $this->success('操作成功',u('category/index', array('child'=>$_POST['child'])));
    	}else{
			$cate_mod = M('Category');
			$child = isset($_GET['child']) && intval($_GET['child']) ? intval($_GET['child']) : $this->error('请选择频道ID');
			if( isset($_GET['id']) ){
				$cate_id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('请选择栏目',u('Category/index', array('child'=>$child)));
			}
			
	    	$result = $cate_mod->where(array("child"=>$child))->order("sort asc,id desc")->select();//读取缓存中的内容
			foreach($result as $r) {
			   $r['selected'] = $r['id'] == $cate_id ? 'selected' : '';
			   $array[] = $r;
		     }
		    import ( '@.ORG.Tree' );	
		    $str  = "<option value='\$id' \$selected>\$spacer \$name</option>";
		    $tree = new Tree ();
			$tree->icon = array('│ ','├─ ','└─ ');
            $tree->nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$tree->init($array);		 
		    $cate_list = $tree->get_tree(0, $str,$cate_id);
	    	$this->assign('cate_list',$cate_list);
			$this->assign('child',$child);
	        $this->display();
    	}
	}
	
	//编辑分类
	public function edit()
    {
    	if(isset($_POST['dosubmit'])){
    		$cate_mod = M('Category');

	    	$old_cate = $cate_mod->where('id='.$_POST['id'])->find();
	        //名称不能重复
	        if ($_POST['name']!=$old_cate['name']) {
	            if ($this->_cate_exists($_POST['name'], $_POST['pid'], $_POST['id'])) {
	            	$this->error('分类名称重复！');exit;
	            }
	        }

	        //获取此分类和他的所有下级分类id
	        $vids = array();
	        $children[] = $old_cate['id'];
	        $vr = $cate_mod->where('pid='.$old_cate['id'])->select();
	        foreach ($vr as $val) {
	            $children[] = $val['id'];
	        }
	        if (in_array($_POST['pid'], $children)) {
	            $this->error('所选择的上级分类不能是当前分类或者当前分类的下级分类！',u('category/edit', array('child'=>$_POST['child'])));
	        }

	    	$vo = $cate_mod->create();
			$result = $cate_mod->save();
			if(false !== $result){
				$this->success('操作成功',u('category/index', array('child'=>$_POST['child'])));
			}else{
				$this->error('操作失败',u('category/edit', array('child'=>$_POST['child'])));
			}
    	}else{
    		$cate_mod = M('Category');
			$child = isset($_GET['child']) && intval($_GET['child']) ? intval($_GET['child']) : $this->error('请选择频道ID');
			if( isset($_GET['id']) ){
				$cate_id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('请选择栏目');
			}
			$cate_info = $cate_mod->where('id='.$cate_id)->find();
		 	$parentid =	intval($cate_info['pid']);
	    	$result = $cate_mod->where(array("child"=>$child))->order('sort ASC')->select();
			foreach($result as $r) {
			  $r['selected'] = $r['id'] == $parentid ? 'selected' : '';
			   $array[] = $r;
		     }
		    import ( '@.ORG.Tree' );	
		    $str  = "<option value='\$id' \$selected >\$spacer \$name</option>";
		    $tree = new Tree ();
			$tree->icon = array('│ ','├─ ','└─ ');
            $tree->nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$tree->init($array);		 
		    $cate_list = $tree->get_tree(0, $str,$parentid);
			$this->assign('cate_list', $cate_list);
			$this->assign('cate_info',$cate_info);
			$this->assign('child',$child);
			$this->display();
    	}

    }
	
    //查询重复
    function _cate_exists($name, $pid, $id=0)
    {
    	$where = "name='".$name."' AND pid='".$pid."'";
    	if( $id&&intval($id) ){
    		$where .= " AND id<>'".$id."'";
    	}
        $result = M('Category')->where($where)->count();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
	//删除
    function delete()
    {
        if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的分类！');
		}
		$cate_mod = M('Category');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
		    $cate_id = implode(',', $_POST['id']);
		    $cate_mod->delete($cate_id);
		} else {

		    $cate_id = intval($_GET['id']);
		    $cate_mod->delete($cate_id);
		}
		//取出频道ID
		$this->success('操作成功',u('category/index', array('child'=>$_REQUEST['child'])));
    }
	
	
	

  
}
?>
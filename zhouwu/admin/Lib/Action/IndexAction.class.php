<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends BaseAction {
     /**
    +----------------------------------------------------------
    * 默认操作
    +----------------------------------------------------------
    */
    public function index()
    {
		
        $this->display('index');
    }
	/*当前位置*/
    public function current_pos()
    {
        $group_id = intval($_REQUEST['tag']);
        $menuid = intval($_REQUEST['menuid']);

        $r = M('Node')->field('group_id,module_name,action_name')->where('id='.$menuid)->find();
        if($r)
        {
            $group_id = $r['group_id'];
        }

        $group = M('Group')->field('title')->where('id='.$group_id)->find();
        if($group)
        {
            echo $group['title'];
        }
        if($r)
        {
            echo '->'.$r['module_name'].'->'.$r['action_name'];
        }
        exit;
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
		$this->success('更新完成', U('public/main'));
		
    }
}
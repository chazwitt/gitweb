<?php
class UserModel extends Model
{
	
    public function check_username($user_name,$id='')
    {
        $where = "user_name='$user_name'";
        if ($id) {
            $where .= " AND id<>'$id'";
        }
        $id = $this->where($where)->getField('id');
        if ($id) {
        	//存在
            return false;
        } else {
        	//不存在
            return true;
        }
    }
	
	public function check_pass($oldpassword,$id='')
    {
        $where = "password='".md5($oldpassword)."'";
        if ($id) {
            $where .= " AND id='$id'";
        }
        $id = $this->where($where)->getField('id');
        if ($id) {
        	//存在
            return false;
        } else {
        	//不存在
            return true;
        }
    }
	
}
<?php

class MemberModel extends Model
{
    protected $_validate = array(
        array('username', 'require', '用户名不能为空'), //不能为空
        array('repwd', 'password', '密码不一样', 0, 'confirm'), //确认密码
        array('username','','帐号名称已经存在！',0,'unique',1), 
		array('qq','','邮箱已经存在！',0,'unique',1),
		//array('lastip','','同一个IP只能注册一个帐号！',0,'unique',1), 
    );

    protected $_auto = array(
        array('password','md5',1,'function'), //密码加密
        array('regtime','time',1,'function'), //注册时间
		array('last_time','time',1,'function'), //登录时间
    );

  
}
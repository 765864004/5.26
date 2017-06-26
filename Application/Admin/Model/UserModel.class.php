<?php
namespace Admin\Model;

use Think\Model;

class UserModel extends Model
{
    //自动验证
    protected $_validate = array(
        array('username','','帐号名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
    );

    //自动完成
    protected $_auto = array(
        array('password', 'md5', 3, 'function'), // 对password字段在新增和编辑的时候使md5函数处理
        array('token', 'set_token', 1, 'callback')
    );

    function set_token()
    {
        $token = md5(uniqid().time().rand(100000, 999999));
        return $token;
    }

}
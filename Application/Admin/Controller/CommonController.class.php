<?php
namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller
{
    var $side;
    public function __construct()
    {

        parent::__construct();
        $this->check_login();
        $this->side = D('side');
    }

    //检查登录
    public function check_login()
    {
        if (!isset($_SESSION["user"])) {
            $this->error("您还没有登录", U("User/login"));
        }
        $this->assign("user", $_SESSION["user"]);
    }

}
<?php
namespace Admin\Controller;

use Think\Controller;

class UserController extends Controller
{
    var $user;

    public function _initialize()
    {
        $this->user = D('User');
    }

    public function login()
    {
        $this->display();
    }

    public function register()
    {
        $this->display();
    }

    public function do_register()
    {
        if (!$this->user->create()) {
            $this->error($this->user->getError());
        } else {
            $this->user->add();
            $this->success("注册成功", U('login'));
        }
    }

    //生成验证码
    public function verify()
    {
        $config = array(
            'length' => 4,     // 验证码位数
            'codeSet' => '0123456789'
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }

    //检查验证码是否正确
    function check_verify($code, $id = '')
    {
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    //登录
    public function do_login()
    {
        //检查验证码
        $code = I("post.code");
        if (!$this->check_verify($code)) {
            $this->error("验证码错误,请重新输入");
        }

        //检查用户名密码
        $map['username'] = I("post.username");
        $map['password'] = md5(I("post.password"));
        $user = $this->user->where($map)->find();
        if (!$user) {
            $this->error("账号或密码错误,请重新输入");
        }

        //存入session 登录成功 跳转到主页
        $_SESSION["user"] = $user;
        $this->success("登录成功", U("Index/index"));
    }

    //退出
    function logout()
    {
        if(isset($_COOKIE[session_name()])) {
            setcookie(session_name(), "", time()-3600, "/");
        }
        $this->success("您已经成功退出", U("login"));
    }

    //修改密码
    public function editpw(){

        $this->assign("user", $_SESSION["user"]);
        $this->display();
    }
    public function pw_update(){
        $user = $_SESSION["user"];
        $old = md5($_POST["old"]); //旧密码
        $new = md5($_POST["password"]); //新密码
        $new2 = md5($_POST["new2"]); //再次输入新密码
        //$data["password"] = $new;
        if(IS_POST){
            if($old ==$user["password"] && $new == $new2 ){
                $this->user->create();
                $this->user->where("id=".$user["id"]."")->save();
                $this->success("修改成功");
            }
        }
    }

    public function link(){
        $this->display();
    }

}
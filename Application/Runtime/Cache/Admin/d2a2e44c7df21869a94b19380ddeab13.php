<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>...内容管理系统</title>

    <link href="/Public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Public/assets/css/common.css">

    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        body{color: #c0c0c8;background-color: #09091a;}
        .content{ font-size: 16px; width: 440px; height: 600px;margin: 0 auto;}
        .content .logo{ font-size: 30px; font-weight: bold; text-align: center; margin-bottom: 24px;}
        .logo .register{position: relative; font-weight: normal;font-size: 16px;}
        .register span{ width: 180px; height: 1px; display: block;border-top: 1px solid #3a3a48; position: absolute;}
        .register .span{ top: 11px; left: 0px; }
        .register .span2{ top: 11px; right: 0px; }
        .input{ height: 50px; color: #09091a;}
        .rember{margin: 24px 0 24px 0; overflow: hidden;}
        .rember input,.rember button{ margin: 0; padding: 0;}
        .rember .check{ width: 25px; height: 25px; float: left;}
        .rember span{ display: block; float: left; height: 25px; line-height: 25px; }
        .btn{font-size: 18px; background-color: #4cc8de;border-color: #4cc8de; width: 100%; height: 60px; border-radius: 5px; color:#FFFFFF;}
        .line{ width:100%; height: 1px;border-top: 1px solid #3a3a48; margin: 24px 0 24px 0; }
        .login{text-align: center;}
        .login .color{color: #1fbad6; }
    </style>
</head>
<body>

<div class="container">

    <p class="bg-danger error"></p>

 <!--   <form action="<?php echo U('do_register');?>" method="post">
        <div class="form-group">
            <label for="username">用户名</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="请填写用户名">
        </div>
        <div class="form-group">
            <label for="password">密码</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="请填写密码">
        </div>

        <div class="form-group">
            <label for="check_password">重复密码</label>
            <input type="password" name="password" class="form-control" id="check_password" placeholder="请填写密码">
        </div>

        <button type="submit" class="btn btn-default submit">注 册</button>
    </form>

    <a href="<?php echo U('login');?>">已有账号,立即登录</a>-->

    <div class="content">

        <h1>管理员注册</h1>
        <div class="logo">
            <p class="icon glyphicon glyphicon-apple"></p>
            <p class="register"><span class="span"></span>注册<span class="span2"></span></p>
        </div>

        <form class="form-horizontal" action="<?php echo U('do_register');?>" method="post">

            <input type="text" class="form-control input" name="username" id="username" placeholder="请填写用户名">

            <input type="password" class="form-control input" name="password" id="password" placeholder="请填写密码">
            <input type="password" class="form-control input" name="password" id="check_password" placeholder="请再次填写密码">

            <p class="rember">
                <input type="checkbox" class="check"><span> 记住我·<a href="#" class="color">忘记密码</a></span>
            </p>

            <button type="submit" class="btn submit">注　册</button>

            <p class="line"></p>

            <p class="login">已有账号？<a href="<?php echo U('login');?>" class="color">登录</a></p>
        </form>
    </div>
</div>
<script src="/Public/assets/js/jquery-2.2.2.min.js"></script>
<script src="/Public/assets/bootstrap/js/bootstrap.min.js"></script>
<script>
    $(function () {
        $(".submit").click(function () {
            var html = "";
            var status = true;

            var username = $("#username").val();
            if (username == "") {
                html += "<p>用户名不能为空</p>";
                status = false;
            }

            var password = $("#password").val();
            if (password.length < 5) {
                html += "<p>密码不能小于5位</p>";
                status = false;
            }

            var check_password = $("#check_password").val();

            if (password != check_password) {
                html += "<p>两次输入的密码不一致</p>";
                status = false;
            }

            if (status == false) {
                $(".error").html(html);
                return false;
            }
        });
    })
</script>

</body>
</html>
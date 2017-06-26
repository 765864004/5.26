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
        body{background-image:linear-gradient(to bottom,#0369a9,#6ebfee); -background: red; height:800px;}
        .title{font-family: "微软雅黑"; font-size: 25px; padding: 10px 0 0 15px;}
        .center{ width: 100%; margin: 0 auto; padding: 30px 0 30px 100px;}
        .title span{ font-size: 14px;}
        .login_box{ border:15px solid #1368a1;border-radius:20px; color: #f6fef1; margin-top: 100px;box-shadow:1px 1px 60px 6px #34aeef inset;  }
        .input{ width: 200px; height: 30px;}
        .left{ float: left; height: 35px; line-height: 35px; padding-right: 15px; width: 80px; text-align: right;}
        .verify{ padding-left: 80px;}
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6 login_box">
            <h1 class="title">管理员登录｜<span>ADMINLOGIN</span></h1>
            <div class="center">
                <form action="<?php echo U('do_login');?>" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="left">用户名:</label>
                        <input type="text" name="username" class="form-control input" id="exampleInputEmail1" placeholder="请填写用户名">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="left">密　码:</label>
                        <input type="password" name="password" class="form-control input" id="exampleInputPassword1" placeholder="请填写密码">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1" class="left">验证码:</label>
                        <input type="password" name="code" class="form-control input" id="" placeholder="请填写验证码">
                    </div>
                    <div class="form-group verify">
                        <img src="" alt="" id="verify" style="cursor: pointer">
                    </div>

                    <div class="form-group verify checkbox">
                        <label>
                            <input type="checkbox" name="rem" value="1"> 记住我
                        </label>
                    </div>

                    <div class="form-group verify">
                        <button type="submit" class="btn btn-primary sumbit">登录</button>
                        <a href="<?php echo U('register');?>">还没有账号,立即注册</a>
                    </div>

                </form>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>
<script src="/Public/assets/js/jquery-2.2.2.min.js"></script>
<script src="/Public/assets/bootstrap/js/bootstrap.min.js"></script>
<script>
    $(function () {
        var src = "<?php echo U('verify');?>" + "?" + Math.random();
        $("#verify").attr("src", src);


        $("#verify").click(function () {
            $(this).attr("src", src);
        })
    })
</script>
</body>
</html>
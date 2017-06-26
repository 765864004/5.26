<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>后台内容管理系统</title>

    <link href="/Public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Public/assets/css/common.css">
    <link rel="stylesheet" href="/Public/xCms/css/xCms.css">
    <style>
        .ul li dl{ display:none; position:absolute; left:0; top:40px;background:#d9e0f9; padding:15px 0 15px 0;font-size:13px;z-index:11; border-radius:5px;filter:alpha(opacity:90);opacity:0.9;}
        .ul li dl dt{ padding:0 15px 0 15px; border-bottom: 1px solid #b2b2b2;}
        .ul li dl a{ color:#777; line-height:30px;}
        .ul li dl a:hover{text-decoration: none; }
        .ul li dl dt:hover{background:#e7e7e7;}
        .hover{ background:#e7e7e7;}
    </style>

    
    <style>
        #page2 {
            display: none;
        }
    </style>

</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top col-md-10">
    <div class="container-fluid nav_bg">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">后台管理系统</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav ul" id="ul">
                    <li style="position: relative">
                        <a href="#">内容管理</a>
                        <dl>
                            <dt><a href="<?php echo U('contmanage/index');?>">栏目管理</a></dt>
                            <dt><a href="<?php echo U('article/allArticle');?>">文章列表</a></dt>
                        </dl>
                    </li>
                    <li><a href="<?php echo U('file/index');?>">文件管理</a></li>
                    <li><a href="#">Link <span class="sr-only">(current)</span></a></li>
                    <!--<li><a href="<?php echo U('Link/index');?>">友情链接</a></li>-->
                    <li><a href="<?php echo U('link/index');?>">友情链接</a></li>
                    <li><a href="/index.php?m=Admin&c=Dir&a=index">前端文件管理</a></li>
                    <!--<li><a href="<?php echo U('Dir/index');?>">前端文件管理</a></li>-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> 系统设置 <span
                                class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo U('System/config');?>">站点信息</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo U('system/cache');?>">清除缓存</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">尊敬的 <?php echo ($user["username"]); ?><span
                                class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo U('User/editpw');?>">修改密码</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo U('User/logout');?>">安全退出</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </div>
</nav>

<div class="container-fluid">
    

    <div class="row">
        <div class="col-sm-12">
            <h1>站点信息</h1>
        </div>

        <div class="col-sm-10">
            <div class="col-sm-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">System Config</h3>
                    </div>
                    <div class="panel-body">

                        <?php if(is_array($side)): $i = 0; $__LIST__ = $side;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$side): $mod = ($i % 2 );++$i;?><form class="form-horizontal" id="form" method="post" action="<?php echo U('update');?>">

                            <div id="page1">
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">网站名称</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="side" id="title" placeholder="网站名称" value="<?php echo ($side["side"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="keyword" class="col-sm-2 control-label">关键词</label>
                                    <div class="col-sm-6">
                                        <textarea name="keyword" id="keyword" rows="3" class="form-control" placeholder="关键词"><?php echo ($side["keyword"]); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">描述信息</label>
                                    <div class="col-sm-10">
                                        <textarea name="description" id="description" rows="5" class="form-control"
                                  placeholder="描述信息"><?php echo ($side["description"]); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">姓名</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" id="title" placeholder="姓名" value="<?php echo ($side["name"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">年龄</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="age" id="title" placeholder="年龄" value="<?php echo ($side["age"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">性别</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="sex" id="title" placeholder="性别" value="<?php echo ($side["sex"]); ?>">
                                    </div>
                                </div>
                            </div>


                            <div id="page2">
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">联系电话</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="tel" id="title" placeholder="联系电话" value="<?php echo ($side["tel"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">邮箱</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="email" id="title" placeholder="邮箱" value="<?php echo ($side["email"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">QQ</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="qq" id="title" placeholder="QQ" value="<?php echo ($side["qq"]); ?>">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> Remember me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" class="btn btn-primary" disabled id="prev">后 退</button>
                                    <button type="button" class="btn btn-primary" id="next">前 进</button>
                                </div>
                            </div>
                        </form><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>

            </div>

            <div class="col-sm-2">
                <!--<div class="list-group">-->
                    <!--<a href="#" class="list-group-item list-group-item-success">-->
                        <!--新增-->
                    <!--</a>-->
                    <!--<a href="#" class="list-group-item list-group-item-warning">删除</a>-->
                <!--</div>-->
            </div>
        </div>


    </div>

</div>
<script src="/Public/assets/js/jquery-2.2.2.min.js"></script>
<script src="/Public/assets/bootstrap/js/bootstrap.min.js"></script>
<script>
    $(function(){
        $(".ul li").hover(function(){
            $(this).children("dl").stop(true).slideDown(600);
            $(this).addClass("hover");
            //$(this).children().children().children().removeClass("hover");
        },function(){
            $(this).children("dl").stop(true).slideUp(600);
            $(this).removeClass("hover");
            //$(this).children().children().children().removeClass("hover");
        });
    });
</script>


    <script>
        $(function () {
            var $page1 = $("#page1");
            var $page2 = $("#page2");
            var $next = $("#next");
            var $prev = $("#prev");

            $next.click(function () {
                if ($(this).text() == '提 交') {
                    $("#form").submit();
                    return false;
                }

                $page1.hide();
                $page2.fadeIn(300);
                $prev.prop("disabled", false);
                $next.text("提 交");
            });

            $prev.click(function () {
                $page2.hide();
                $page1.fadeIn(300);
                $prev.prop("disabled", true);
                $next.text("前 进");
            });
        });
    </script>


</body>
</html>
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
        .table{ margin-top: 20px; border-left: 1px solid #7bd9f5;  border-top: 1px solid #7bd9f5;}
        .table td,.table th { border-right: 1px solid #7bd9f5;  border-bottom: 1px solid #7bd9f5;}

        .sort{ width: 60px; height: 25px;}
        .catename{font-weight:bold;color:#a7cb52;}
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
            <h1>前端文件管理</h1>
        </div>

        <div class="col-sm-10">
            <div class="col-sm-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">前端文件管理</h3>
                    </div>
                    <div class="panel-body">
                        <!--文件上传 S-->
                        <form enctype="multipart/form-data" method="post"  action="<?php echo U('upload', array('path'=>$path));?>">
                            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                            <input type="file" name="file" style="margin-bottom: 15px;"/>
                            <input type="submit" class="btn btn-primary btn-sm">
                        </form>
                        <!--文件上传 E-->

                        <table class="table">
                            <thead>
                            <tr><th colspan="6">栏目管理</th></tr>
                            <tr>
                                <th>#</th>
                                <th>文件/目录名</th>
                                <th>文件类型</th>
                                <th>文件大小</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <tbody>
                            <!--遍历目录 S-->
                            <?php if(is_array($files)): $i = 0; $__LIST__ = $files;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$file): $mod = ($i % 2 );++$i;?><tr class="success" id="tr">
                                <th scope="row">1</th>
                                <td><?php echo ($file["name"]); ?></td>
                                <td><?php echo ($file["type"]); ?></td>
                                <td><?php echo ($file["size"]); ?></td>
                                <td><?php echo (date("Y-m-d",$file["filectime"])); ?></td>
                                <td>
                                    <?php if(($file["type"]) == "目录文件"): ?><!--传递参数 文件路径+文件名-->
                                        <a href="<?php echo U('index',array('path'=>$path.'/'.$file['name']));?>">进入</a><?php endif; ?>

                                    <?php if(($file["type"]) == "普通文件"): ?><a href="<?php echo U('edit', array('path'=>$path.'/'.$file['name']));?>">编辑</a>
                                        <a href="<?php echo U('destroy', array('path'=>$path.'/'.$file['name']));?>">删除</a>
                                        <a href="<?php echo U('download', array('path'=>$path.'/'.$file['name']));?>">下载</a><?php endif; ?>

                                    <?php if(($file["type"]) == "图片"): ?><a href="<?php echo U('show', array('path'=>$path.'/'.$file['name']));?>">显示图片</a>
                                        <a href="<?php echo U('destroy', array('path'=>$path.'/'.$file['name']));?>">删除</a>
                                        <a href="<?php echo U('download', array('path'=>$path.'/'.$file['name']));?>">下载</a><?php endif; ?>

                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            <!--遍历目录 E-->

                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

            <div class="col-sm-2">
                <div class="list-group">
                    <a href="<?php echo U('add', array('path'=>$path));?>" class="list-group-item list-group-item-success">
                        新增文件
                    </a>
                    <a href="#" class="list-group-item list-group-item-warning">新增文件夹</a>
                </div>
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
        $(function(){
            $("tbody tr:even").addClass("info").removeClass("success");
        })
    </script>


</body>
</html>
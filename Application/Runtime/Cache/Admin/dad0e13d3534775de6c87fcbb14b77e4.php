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
        .padd {
            padding-top: 30px;
        }

        .left {
            float: left;
        }

        .table {
            margin-top: 20px;
            border-left: 1px solid #7bd9f5;
            border-top: 1px solid #7bd9f5;
        }

        .table td, .table th {
            border-right: 1px solid #7bd9f5;
            border-bottom: 1px solid #7bd9f5;
        }

        .table .td {
            text-align: right;
        }
        #myTabs li a{ background: #a4eaff; color: #412309;}
        #myTabs li a:hover{ background: #5bc0de; color: #f6fdff;}

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
        <h1>内容管理</h1>
    </div>

    <div class="col-sm-10">
        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">新增栏目</h3>
                </div>

                <div class="panel-body">
                    <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                        <ul id="myTabs" class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home"
                                   aria-expanded="true">添加栏目</a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#profile" role="tab" id="profile-tab" data-toggle="tab"
                                   aria-controls="profile" aria-expanded="false">栏目内容</a>
                            </li>
                        </ul>
                        <!--选项卡内容-->
                        <div id="myTabContent" class="tab-content">
                            <!--添加栏目 S-->
                            <div role="tabpanel" class="tab-pane fade active in" id="home"
                                 aria-labelledby="home-tab">

                                    <form action="<?php echo U('do_add_category');?>" method="post">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="td">栏目属性</th>
                                            <th style="text-align: center">属性值</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="active">
                                            <th scope="row" class="td">父栏目</th>
                                            <td>
                                                <div class="form-group col-sm-10">
                                                    <select name="parent_id" class="form-control" style="width: 500px">
                                                        <option value="0">
                                                            顶级栏目
                                                        </option>

                                                            <!--
                                                            <?php if(is_array($categorys)): $i = 0; $__LIST__ = $categorys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cates): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cates["id"]); ?>" <?php if(($cates["id"]) == $category["parent_id"]): ?>selected = "selected"<?php endif; ?>>
                                                                　　　　<?php echo ($cates["name"]); ?>
                                                            </option>
                                                                <?php if(is_array($cates["childs"])): $i = 0; $__LIST__ = $cates["childs"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><option value="<?php echo ($child["id"]); ?>">
                                                                    　　　　　　　　<?php echo ($child["name"]); ?>
                                                                </option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                                                            -->

                                                            <?php if(is_array($categories)): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cates): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cates["id"]); ?>" <?php if(($cates["id"]) == $category["id"]): ?>selected = "selected"<?php endif; ?>>
                                                                <?php echo (indent_blank($cates["count"])); echo ($cates["name"]); ?>
                                                            </option><?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="td">名称</th>
                                            <td>
                                                <div class="form-group col-sm-10">
                                                    <input type="text" name="name" class="form-control" placeholder="栏目名称">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="success">
                                            <th scope="row" class="td">拼音</th>
                                            <td>
                                                <div class="form-group col-sm-10">
                                                    <input type="text" name="englishname" class="form-control" id="" placeholder="栏目拼音">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="td">类型</th>
                                            <td>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="type" value="0"> 封面
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="type" value="1"> 列表
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="type" value="2"> URL跳转
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="info">
                                            <th scope="row" class="td">URL跳转地址</th>
                                            <td>
                                                <div class="form-group col-sm-10">
                                                    <input type="text" name="url" class="form-control" value="" placeholder="如果选择了URL跳转,请填写地址">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="danger">
                                            <th scope="row" class="td">是否显示</th>
                                            <td>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="display" value="0"> 是
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="display" value="1"> 否
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="col-sm-10 padd">
                                        <input type="submit" class="btn btn-info" value="添加">
                                        <a href="<?php echo U('contmanage/index');?>" class="btn btn-success">返回</a>
                                    </div>
                                    </form>

                            </div>
                            <!--添加栏目 E-->

                            <!--栏目内容S-->
                            <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
                                <form  action="<?php echo U('add_cont');?>" method="post">
                                <textarea name="content" class="content"></textarea>

                                <div class="form-group col-sm-10 padd">
                                    <label for="exampleInputName2">是否显示</label>
                                    <input type="radio"> 是
                                    <input type="radio"> 否
                                </div>

                                <div class="col-sm-10 padd">
                                    <input type="submit" class="btn btn-info" value="添加">
                                    <a href="<?php echo U('contmanage/index');?>" class="btn btn-success">返回</a>
                                </div>
                                </form>
                            </div>
                            <!--栏目内容 E-->

                        </div>
                    </div>

                </div>

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


    <script type="text/javascript" src="/Public/assets/js/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/Public/assets/js/ckfinder/ckfinder.js"></script>
    <script>
        CKEDITOR.replace('content',
                {
                    filebrowserBrowseUrl: '/Public/assets/js/ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl: '/Public/assets/js/ckfinder/ckfinder.html?type=Images',
                    filebrowserFlashBrowseUrl: '/Public/assets/js/ckfinder/ckfinder.html?type=Flash',
                    filebrowserUploadUrl: '/Public/assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl: '/Public/assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserFlashUploadUrl: '/Public/assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                });
    </script>


</body>
</html>
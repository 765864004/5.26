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
            <h1>内容管理</h1>
        </div>

        <div class="col-sm-10">
            <div class="col-sm-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><a href="<?php echo U('contmanage/index');?>">栏目管理</a></h3>
                    </div>
                    <div class="panel-body">
                        <a href="<?php echo U('add');?>" class="btn btn-info">新增顶级栏目</a>
                        <a href="#" id="sort_order" class="btn btn-success">排序</a>

                        <table class="table">
                            <thead>
                            <tr><th colspan="4">栏目管理</th></tr>
                            <tr>
                                <th>排序</th>
                                <th>栏目名称</th>
                                <th>栏目文章</th>
                                <th>设置 <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> </th>
                            </tr>
                            </thead>

                            <form action="" method="post" class="my_form">
                            <tbody>
                            <!--使用递归无限分类-->
                                <?php if(is_array($categories)): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category): $mod = ($i % 2 );++$i;?><tr class="success" id="tr">
                                    <th scope="row">
                                        <input type="hidden" name="id[]" value="<?php echo ($category["id"]); ?>">
                                        <input type="text" name="sort_order[]" value="<?php echo ($category["sort_order"]); ?>" class="form-control sort" placeholder="Text input">
                                    </th>
                                    <td><?php echo (indent_blank($category["count"])); echo ($category["name"]); ?>
                                        <span class="catename"><?php if(($category["type"]) == "0"): ?>【封面】<?php endif; ?></span>
                                        <span class="catename"><?php if(($category["display"]) == "1"): ?>【隐藏】<?php endif; ?></span>
                                    </td>
                                    <td><a href="<?php echo U('article/articleList', array('id'=>$category[id]));?>">查看栏目文章</a></td>
                                    <td>
                                        <a href="<?php echo U('add', array('id'=>$category[id]));?>" title="添加栏目"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                                        <a href="<?php echo U('edit', array('id'=>$category[id]));?>" title="编辑栏目" id="edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                        <a href="<?php echo U('delete', array('id'=>$category[id]));?>" title="删除栏目"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                    </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                            <!--使用关联-->
                            <!--
                            &lt;!&ndash;父类 S&ndash;&gt;
                            <?php if(is_array($categorys)): $i = 0; $__LIST__ = $categorys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category): $mod = ($i % 2 );++$i;?><tr class="success" id="tr">
                                <th scope="row">
                                    <input type="hidden" name="id[]" value="<?php echo ($category["id"]); ?>">
                                    <input type="text" name="sort_order[]" value="<?php echo ($category["sort_order"]); ?>" class="form-control sort" placeholder="Text input">
                                </th>
                                <td><?php echo ($category["name"]); ?>
                                    &lt;!&ndash;如果name的值和value的值相等&ndash;&gt;
                                    <span class="catename"><?php if(($category["type"]) == "0"): ?>【封面】<?php endif; ?></span>
                                    <span class="catename"><?php if(($category["display"]) == "1"): ?>【隐藏】<?php endif; ?></span>
                                </td>
                                <td><a href="<?php echo U('article/articleList', array('id'=>$category[id]));?>">查看栏目文章</a></td>
                                <td>
                                    <a href="<?php echo U('add', array('id'=>$category[id]));?>" title="添加栏目"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                                    <a href="<?php echo U('edit', array('id'=>$category[id]));?>" title="编辑栏目" id="edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                    <a href="<?php echo U('delete', array('id'=>$category[id]));?>" title="删除栏目"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                </td>
                            </tr>
                            &lt;!&ndash;父类 E&ndash;&gt;

                            &lt;!&ndash;子类 S&ndash;&gt;
                            <?php if(is_array($category["childs"])): $i = 0; $__LIST__ = $category["childs"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><tr class="success" id="">
                                <th scope="row" style="padding-left: 20px;">
                                    <input type="hidden" name="id[]" value="<?php echo ($child["id"]); ?>">
                                    <input type="text" name="sort_order[]" value="<?php echo ($child["sort_order"]); ?>" class="form-control sort" placeholder="Text input">
                                </th>
                                <td style="text-indent:40px;"><?php echo ($child["name"]); ?>
                                    <span class="catename"><?php if(($child["type"]) == "0"): ?>【封面】<?php endif; ?></span>
                                    <span class="catename"><?php if(($child["display"]) == "1"): ?>【隐藏】<?php endif; ?></span>
                                </td>
                                <td style="text-indent:40px;"><a href="<?php echo U('article/articleList', array('id'=>$child[id]));?>">查看栏目文章2222</a></td>
                                <td>
                                    <a href="<?php echo U('contmanage/add', array('id'=>$child[id]));?>" title="添加栏目"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                                    <a href="<?php echo U('edit', array('id'=>$child[id]));?>" title="编辑栏目"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                    <a href="<?php echo U('delete', array('id'=>$child[id]));?>" title="删除栏目"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            &lt;!&ndash;子类 E&ndash;&gt;<?php endforeach; endif; else: echo "" ;endif; ?>-->

                            </tbody>
                            </form>
                        </table>
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


    <script>
        $(function(){
            $("tbody tr:even").addClass("info").removeClass("success");
        })

        //点击排序
        $("#sort_order").click(function(){
            $(".my_form").attr('action',"<?php echo U('sort_order');?>").submit();
        })

        $("#edit").click(function(){
            //$(".my_form").attr('action',"<?php echo U('update');?>").submit();
        })


    </script>


</body>
</html>
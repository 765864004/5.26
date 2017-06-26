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

    
    <link href="/Public/assets/select2/css/select2.min.css" rel="stylesheet">
    <link href="/Public/assets/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css">
    <link href="/Public/assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">
<style>
    .table{ margin-top: 20px; border-left: 1px solid #7bd9f5;  border-top: 1px solid #7bd9f5;}
    .table td,.table th { border-right: 1px solid #7bd9f5;  border-bottom: 1px solid #7bd9f5;}
    .table .td {  text-align: right;  }
    .float{ float: left;}
    .margin{ margin-left: 15px; _display:inline;}

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
            <h1>添加文章</h1>
        </div>

        <div class="col-sm-10">
            <div class="col-sm-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">添加文章</h3>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo U('store');?>" method="post">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Column heading</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="active">
                                <th scope="row" class="td">所属栏目</th>
                                <td>
                                    <div class="form-group col-sm-10">

                                            <select name="category_id" class="form-control" style="width: 500px">
                                                <option value="0">
                                                    顶级栏目
                                                </option>
                                                <?php if(is_array($categories)): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cates): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cates["id"]); ?>">
                                                        <?php echo (indent_blank($cates["count"])); echo ($cates["name"]); ?>
                                                    </option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="td" scope="row">标题</th>
                                <td>
                                    <div class="form-group col-sm-6">
                                        <input type="text" name="title" class="title form-control" placeholder="文章标题">
                                    </div>
                                </td>
                            </tr>
                            <tr class="success">
                                <th scope="row" class="td">标题颜色</th>
                                <td>
                                    <div class="col-sm-6">
                                        <div id="cp2" class="input-group colorpicker-component">
                                            <input type="text" name="color" value="#00AABB" class="form-control"/>
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="td">发布日期</th>
                                <td>
                                    <div class="form-group col-sm-6">
                                        <input type="text" id="time" name="date" class="form-control" placeholder="发布日期">
                                    </div>
                                </td>
                            </tr>
                            <tr class="warning">
                                <th scope="row" class="td col-sm-2">Description field</th>
                                <td>
                                    <div class="form-group col-sm-6">
                                        <input type="text" name="description" class="form-control" placeholder="文章描述">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="td">摘要</th>
                                <td>
                                    <div class="col-sm-6">
                                        <textarea name="abstract" class="form-control" rows="3"></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="td">小区</th>
                                <td>
                                    <div class="col-sm-6">
                                        <input type="text" name="address" class="title form-control" placeholder="小区">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="td">价格</th>
                                <td>
                                    <div class="col-sm-6">
                                        <input type="text" name="money" class="title form-control" placeholder="价格">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="td">房屋面积</th>
                                <td>
                                    <div class="col-sm-6">
                                        <input type="text" name="size" class="title form-control" placeholder="房屋面积">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row" class="td">房型</th>
                                <td>
                                    <div class="col-sm-6">
                                        <input type="text" name="room" class="title form-control" placeholder="房型">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row" class="td">区域</th>
                                <td>
                                    <div class="col-sm-6">
                                        <select name="area" class="form-control">
                                            <option value="汉口">汉口</option>
                                            <option value="武昌">武昌</option>
                                            <option value="汉阳">汉阳</option>
                                            <option value="新洲">新洲</option>
                                            <option value="黄陂">黄陂</option>
                                            <option value="江夏">江夏</option>
                                            <option value="蔡甸">蔡甸</option>
                                            <option value="汉南">汉南</option>
                                            <option value="东西湖区">东西湖区</option>
                                            <option value="洪山">洪山</option>
                                            <option value="青山">青山</option>
                                            <option value="硚口">硚口</option>
                                            <option value="江汉">江汉</option>
                                            <option value="江岸">江岸</option>
                                            <option value="武汉周边">武汉周边</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <th scope="row" class="td">缩略图</th>
                                <td>
                                    <div class="form-group col-sm-6">
                                        <input type="text" id="thumb1" name="thumb" class="form-control" placeholder="缩略图">
                                    </div>
                                    <div class="float">
                                        <input type="button"  value="上 传" onclick="BrowseServer('thumb1','img_show1')" class="btn btn-success" />
                                    </div>
                                    <div class="float margin">
                                        <button type="button" class="btn btn-warning">删除</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="td">新增附件</th>
                                <td>
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-info add_file">增加</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="info file">
                                <th scope="row" class="td">附件（1）</th>
                                <td>
                                    <div class="form-group col-sm-6">
                                        <input type="text" id="file1" name="enclosure[]" class="form-control" placeholder="附件">
                                    </div>
                                    <div class="float">
                                        <input type="button"  value="上 传" onclick="BrowseServer('file1')" class="btn btn-success" />
                                    </div>
                                    <div class="float margin">
                                        <button type="button" class="del_thumb1 btn btn-warning">删除</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td colspan="2">
                                    <textarea name="content" class="content"></textarea>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="col-sm-10 padd">
                            <input type="submit" class="submit btn btn-info" value="提交">
                            <a href="<?php echo U('contmanage/articleList');?>" class="btn btn-success">返回</a>
                        </div>

                        </form>

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



    <script type="text/javascript" src="/Public/assets/select2/js/select2.min.js"></script><!--带搜索框的下拉菜单-->
    <script type="text/javascript" src="/Public/assets/select2/js/i18n/zh-CN2.js"></script>
    <script type="text/javascript" src="/Public/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script type="text/javascript" src="/Public/assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="/Public/assets/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>
    <script>
        $(function(){
            $('select').select2(); //调用
            $('#cp2').colorpicker();//颜色
            $('#time').datepicker({
                format: "yyyy-mm-dd",
                language: "zh-CN"
            });
        })
    </script>
    <!--编辑器 S-->
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
    <!--编辑器 S-->

    <!--上传 S-->
    <script>
        function BrowseServer(thumb, img_show) {
            var finder = new CKFinder();

            //当选中图片时执行的函数
            finder.selectActionFunction = function(fileUrl){
                $("#"+thumb).val(fileUrl);
                $("#"+img_show).attr("src",""+fileUrl+"");
            }

            finder.popup();//调用窗口
        }
    </script>
    <!--上传 E-->

    <!--增加附件 S-->
    <script>

        $(".add_file").click(function(){
            var i=$('.file').size();
            //alert(i);

            var n = i+1;
            var html =
                    '<tr class="info file">' +
                    ' <td scope="row" class="td">附件（'+n+'）' +
                    '</td>' +
                    ' <td>' +
                    ' <div class="form-group col-sm-6"> ' +
                    '<input type="text" id="file'+n+'" name="enclosure[]" class="form-control" placeholder="附件">' +
                    '</div>' +
                    '<div class="float">' +
                    '<input type="button"  value="上 传" onclick="BrowseServer(\'file'+n+'\')" class="btn btn-success" />' +
                    '</div>' +
                    '<div class="float margin">' +
                    '<button type="button" class="btn btn-warning del_thumb">删除</button>' +
                    '</div>' +
                    '</td>' +
                    '</tr>';
            if(n < 6) {
                $(".file:last").after(html); //在最后一个.file的后面添加
            } else {
                alert("大哥别再点了！最多只能添加5个附件！");
                return false;
            }
            $(this).blur();  //失去焦点
            return false;   //不跳转

        });

        //删除动态添加的元素
        $(document).on("click",".del_thumb",function(){
            $(this).parents("tr").remove(); //删除.del_thumb的父级tr
        })

        //点击时清空第一个
        $(".del_thumb1").click(function(){
            $("#file1").val('');
        })

    </script>
    <!--增加附件 E-->

    <!--标题不能为空 S-->
    <script>
        $(".submit").click(function(){ //点击提交之后
            $title =$(".title");

            if($title.val() == ''){ //如果标题为空
                alert("大哥！标题不能为空");
                $title.focus();//光标为焦点状态
                return false; //返回 不提交
            }
        })
    </script>
    <!--标题不能为空 E-->

    <!--封面不能发表文章-->
    <script>
        $(".submit").click(function(){
            var type = $("#select").find("option:selected").attr("data-type"); //选中时获取属性
            if (type == 'no_add') { //如果属性值为no_add
                alert("您所选择的栏目是封面栏目，不能添加文章！");
                return false;//返回 不提交
            }

        })
    </script>


</body>
</html>
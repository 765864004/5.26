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
    

<div class="content">
   <h1>友情链接管理</h1>
   <div class="col-sm-8">
      <form action="" method="post" class="my_form">
         <table class="table table-bordered" style="background: #fff">
            <thead>
            <tr>
               <th><input type="checkbox" id="checked_all">全选</th>
               <th>编号</th>
               <th>名称</th>
               <th>网址</th>
               <th>排序</th>
               <th>操作</th>
            </tr>
            </thead>
            <tbody>

            <?php if(is_array($links)): $i = 0; $__LIST__ = $links;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$link): $mod = ($i % 2 );++$i;?><tr class="edit_<?php echo ($link["id"]); ?>" data-id="<?php echo ($link["id"]); ?>">
                  <!--单选框-->
                  <td> <input type="checkbox" class="check_id" id="check_id" name="check_id[]" value="<?php echo ($link["id"]); ?>"> </td>
                  <!--id-->
                  <td class="id"> <?php echo ($link["id"]); ?> </td>
                  <!--url名称-->
                  <td class="name link" contenteditable> <?php echo ($link["name"]); ?></td>
                  <!--url-->
                  <td class="url"><?php echo ($link["url"]); ?></td>
                  <!--sort_order-->
                  <td>
                     <input type="hidden" name="id[]" value="<?php echo ($link["id"]); ?>">
                     <input type="text" class="sort_order" name="sort_order[]" value="<?php echo ($link["sort_order"]); ?>"> </td>
                  <!--编辑 删除-->
                  <td>
                     <a href="" data-toggle="modal" data-target="#editModal" data-id="<?php echo ($link["id"]); ?>" class="edit_link">编辑</a>
                     <a href="" class="del_one">删除</a>
                  </td>
               </tr><?php endforeach; endif; else: echo "" ;endif; ?>

            </tbody>
         </table>
      </form>
   </div>

   <div class="col-sm-2">
      <div class="list-group">
         <a href="#" data-toggle="modal" data-target="#addModal" class="list-group-item list-group-item-success">
            新增
         </a>
         <a href="#" id="sort_order" class="list-group-item list-group-item-success">
            排序
         </a>
         <a href="#" id="destroy_checked" class="list-group-item list-group-item-warning">删除</a>
      </div>
   </div>


   <!--编辑 S-->
   <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="exampleModalLabel">编辑友情链接</h4>
            </div>
            <div class="modal-body">
               <form class="" id="edit_form">
                  <input type="hidden" name="id" id="editId">
                  <div class="form-group">
                     <label for="editName" class="control-label">名称</label>
                     <input type="text" name="name" class="form-control" id="editName" placeholder="请输入名称">
                  </div>
                  <div class="form-group">
                     <label for="editUrl" class="control-label">网址</label>
                     <input type="text" name="url" class="form-control" id="editUrl" placeholder="请输入网址">
                  </div>

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
               <button type="button" id="do_update" class="btn btn-primary">修改</button>
            </div>
            </form>
         </div>
      </div>
   </div>
   <!--编辑 E-->

   <!--新增 S-->
   <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="addModalLabel">新增友情链接</h4>
            </div>
            <div class="modal-body">
               <form action="<?php echo U('add');?>" method="post">
                  <input type="hidden" name="id" id="addId">
                  <div class="form-group">
                     <label for="addName" class="control-label">名称</label>
                     <input type="text" name="name" class="form-control" id="addName" placeholder="请输入名称">
                  </div>
                  <div class="form-group">
                     <label for="addUrl" class="control-label">网址</label>
                     <input type="text" name="url" class="form-control" id="addUrl" placeholder="请输入网址">
                  </div>

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
               <button type="button" id="add" class="btn btn-primary">新增</button>
            </div>
            </form>
         </div>
      </div>
   </div>
   <!--新增 E-->

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
         //点击编辑 弹出框
         $(".edit_link").click(function(){
            var $tr =$(this).parents("tr");
            var id = $tr.children(".id").text();//获取id(获取class="id"的文本内容)
            $.get("<?php echo U('show_edit');?>", {id:id} , function(data){ //提交到show_edit 发送id 获取data(ajaxReturn($link))将获取的data赋值给input
               console.log(data);
               //设置表单默认信息（弹窗表单）(查询到的数据库信息)
               $("#editName").val(data.name);
               $("#editUrl").val(data.url);
               $("#editId").val(data.id); //设置id
            })
         })

         //提交编辑
         $("#do_update").click(function(){
            //获取表单修改后信息（弹窗表单）
            var info = {
               id:$("#editId").val(),
               name:$("#editName").val(),
               url:$("#editUrl").val()
            };
            //发送表单信息（提交到update函数 save()返回修改后的信息）
            $.post("<?php echo U('update');?>",info,function(data){ //
               //console.log(data);
               //设置修改后的信息
               $("#editModal").modal('hide'); //点击提交时 弹窗隐藏
               var $tr = $(".edit_" + info.id);
               $tr.children(".name").text(info.name);
               $tr.children(".url").text(info.url);
            })
         })

         //新增
         $("#add").click(function(){
            var info = {
               name:$("#addName").val(),
               url:$("#addUrl").val()
            }
            //console.log(info);
            $.post("<?php echo U('add');?>",info,function(data){ //data接收add方法传递的info数组
               console.log(data);
               $("#addModal").modal('hide');
               var html ='<tr class="edit_'+data.info.id+'" data-id="'+data.info.id+'">' +
                       '<td> <input type="checkbox" class="check_id" id="check_id" name="check_id[]" value="'+data.info.id+'"> </td>' +
                       '<td class="id"> '+data.info.id+' </td>' +
                       '<td class="name link" contenteditable>'+info.name+'</td>' +
                       '<td class="url">'+info.url+'</td>' +
                       '<td><input type="hidden" name="id[]" value="'+data.info.id+'"><input type="text" class="sort_order" name="sort_order[]" value="99"></td>' +
                       '<td><a href="" data-toggle="modal" data-target="#editModal" data-id="'+data.info.id+'" class="edit_link">编辑</a><a href="" class="del_one">删除</a></td>' +
                       '</tr>';
               $(html).appendTo("tbody").fadeIn(300);
            },'json')
         })

         //排序(ajax)
         $(".sort_order").change(function () {
            var info = {
               sort_order: $(this).val(), //获取表单输入的序号
               id: $(this).parents("tr").data("id") //获取id
            }
            $.post("<?php echo U('change_sort');?>", info); //info 信息提交到change_sort
         })

         //删除一条
         $(document).on("click",".del_one",function(){
            var info = {
               id:$(this).parents("tr").data("id") //获取id
            }
            $.post("<?php echo U('del_one');?>",info,function(){ //提交到del_one 发送id信息
               $(this).parents("tr").remove(); //删除节点
            })
         })




         //全选
         $("#checked_all").click(function(){
            $('.check_id').prop("checked",this.checked); //prop 获取属性并赋值
         })

         //点击删除
         $("#destroy_checked").click(function(){
            var length = 0 ;
            length = $(".check_id:checked").length ;//被选中的个数
            if(length<1){
               alert("您必须至少选中一个");
               return false;
            }
            $(".my_form").attr('action',"<?php echo U('destroy_checked');?>").submit(); //获取form的action属性 并赋值 提交

         })

         //点击排序
         $("#sort_order").click(function(){
            $(".my_form").attr('action',"<?php echo U('sort_order');?>").submit();
         })

      })

   </script>


<!--   <script>
      //编辑 弹出框
      $(".edit_link").click(function(){
         //获取值
         var id = $(this).data('id');//获取id
         var $link=$(this).parent().siblings('.link').children('a'); //通过.link查找a标签  获取name
         var name = $link.text();//获取网站名称
         var url = $link.attr('href'); //获取url

         //赋值（给弹窗表单赋值）
         $("#editId").val(id); //隐藏表单赋值
         $("#editName").val(name);
         $("#editUrl").val(url);
      })

      //全选
      $("#checked_all").click(function(){
         $('.check_id').prop("checked",this.checked); //prop 获取属性并赋值
      })



      //点击删除
      $("#destroy_checked").click(function(){
         var length = 0 ;
         length = $(".check_id:checked").length ;//被选中的个数
         if(length<1){
            alert("您必须至少选中一个");
            return false;
         }
         $(".my_form").attr('action',"<?php echo U('destroy_checked');?>").submit(); //获取form的action属性 并赋值 提交

      })

      //点击排序
      $("#sort_order").click(function(){
         $(".my_form").attr('action',"<?php echo U('sort_order');?>").submit();
      })

   </script>-->




</body>
</html>
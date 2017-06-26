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
            <h1>文件管理</h1>
        </div>

        <div class="col-sm-10">
            <div class="col-sm-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">文件管理</h3>
                    </div>
                    <div class="panel-body">
                        <div id="ckfinder"></div>

                    </div>
                </div>

            </div>

            <div class="col-sm-2">111
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


    <script type="text/javascript" src="/Public/assets/js/ckfinder/ckfinder.js"></script>
    <script type="text/javascript">
        //<![CDATA[
        (function()
        {
            var config = {};
            var get = CKFinder.tools.getUrlParam;
            var getBool = function( v )
            {
                var t = get( v );

                if ( t === null )
                    return null;

                return t == '0' ? false : true;
            };

            var tmp;
            if ( tmp = get( 'configId' ) )
            {
                var win = window.opener || window;
                try
                {
                    while ( ( !win.CKFinder || !win.CKFinder._.instanceConfig[ tmp ] ) && win != window.top )
                        win = win.parent;

                    if ( win.CKFinder._.instanceConfig[ tmp ] )
                        config = CKFINDER.tools.extend( {}, win.CKFinder._.instanceConfig[ tmp ] );
                }
                catch(e) {}
            }

            if ( tmp = get( 'basePath' ) )
                CKFINDER.basePath = tmp;

            if ( tmp = get( 'startupPath' ) || get( 'start' ) )
                config.startupPath = decodeURIComponent( tmp );

            config.id = get( 'id' ) || '';

            if ( ( tmp = getBool( 'rlf' ) ) !== null )
                config.rememberLastFolder = tmp;

            if ( ( tmp = getBool( 'dts' ) ) !== null )
                config.disableThumbnailSelection = tmp;

            if ( tmp = get( 'data' ) )
                config.selectActionData = tmp;

            if ( tmp = get( 'tdata' ) )
                config.selectThumbnailActionData = tmp;

            if ( tmp = get( 'type' ) )
                config.resourceType = tmp;

            if ( tmp = get( 'skin' ) )
                config.skin = tmp;

            if ( tmp = get( 'langCode' ) )
                config.language = tmp;

            if ( typeof( config.selectActionFunction ) == 'undefined' )
            {
                // Try to get desired "File Select" action from the URL.
                var action;
                if ( tmp = get( 'CKEditor' ) )
                {
                    if ( tmp.length )
                        action = 'ckeditor';
                }
                if ( !action )
                    action = get( 'action' );

                var parentWindow = ( window.parent == window ) ? window.opener : window.parent;
                switch ( action )
                {
                    case 'js':
                        var actionFunction = get( 'func' );
                        if ( actionFunction && actionFunction.length > 0 )
                            config.selectActionFunction = parentWindow[ actionFunction ];

                        actionFunction = get( 'thumbFunc' );
                        if ( actionFunction && actionFunction.length > 0 )
                            config.selectThumbnailActionFunction = parentWindow[ actionFunction ];
                        break ;

                    case 'ckeditor':
                        var funcNum = get( 'CKEditorFuncNum' );
                        if ( parentWindow['CKEDITOR'] )
                        {
                            config.selectActionFunction = function( fileUrl, data )
                            {
                                parentWindow['CKEDITOR'].tools.callFunction( funcNum, fileUrl, data );
                            };

                            config.selectThumbnailActionFunction = config.selectActionFunction;
                        }
                        break;

                    default:
                        if ( parentWindow && parentWindow['FCK'] && parentWindow['SetUrl'] )
                        {
                            action = 'fckeditor' ;
                            config.selectActionFunction = parentWindow['SetUrl'];

                            if ( !config.disableThumbnailSelection )
                                config.selectThumbnailActionFunction = parentWindow['SetUrl'];
                        }
                        else
                            action = null ;
                }
                config.action = action;
            }

            // Always use 100% width and height when nested using this middle page.
            config.width = config.height = '100%';

            var ckfinder = new CKFinder( config );
            ckfinder.replace( 'ckfinder', config );
        })();
        //]]>
    </script>


</body>
</html>
<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|OneThink管理平台</title>
    <link href="/onethink/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/onethink/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/onethink/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/onethink/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/onethink/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/onethink/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/onethink/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/onethink/Public/static/jquery-2.0.3.min.js"></script>
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    <?php $__base_menu__ = $__controller__->getMenus(); ?>
    <div class="header">
        <!-- Logo -->
        <span class="logo"></span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__base_menu__["main"])): $i = 0; $__LIST__ = $__base_menu__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
                <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li>
                <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->

    <!-- 边栏 -->
    <div class="sidebar">
        <!-- 子导航 -->
        
            <div id="subnav" class="subnav">
                <?php if(!empty($_extra_menu)): ?>
                    <?php echo extra_menu($_extra_menu,$__base_menu__); endif; ?>
                <?php if(is_array($__base_menu__["child"])): $i = 0; $__LIST__ = $__base_menu__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                    <?php if(!empty($sub_menu)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3>
                        <ul class="side-sub-menu">
                            <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                                    <a class="item" href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                    <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        
        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
	<!-- 标题栏 -->
	<div class="main-title">
		<h2>行为列表</h2>
	</div>

    <div>
        <button class="btn" id="action_add" url="<?php echo U('user/addaction');?>">新 增</button>
        <button class="btn ajax-post" target-form="ids" url="<?php echo u('setstatus',array('status'=>1));?>" >启 用</button>
        <button class="btn ajax-post" target-form="ids" url="<?php echo u('setstatus',array('status'=>0));?>">禁 用</button>
        <button class="btn ajax-post confirm" target-form="ids" url="<?php echo U('setStatus',array('status'=>-1));?>">删 除</button>
    </div>
	<!-- 数据列表 -->
	<div class="data-table">
        <?php
 $thead = array( '_html'=>array( '_th'=>'row-selected', 'th'=>'<input class="check-all" type="checkbox"/>', 'td'=>'<input class="ids" type="checkbox" name="ids[]" value="$id" />', ), 'id'=>'编号', 'name'=>'行为标识', 'title'=>array( '_title'=>'行为名称', 'tag' =>'span', 'href' =>'editAction?id=$id' ), 'remark'=>'规则说明', 'status_text'=>'状态', '操作'=>array( '禁用'=>array( 'href' => 'User/setStatus?status=0&ids=$id', 'class'=>'ajax-get', 'condition'=>'$status==1',), '启用'=>array( 'href' => 'User/setStatus?status=1&ids=$id', 'class'=>'ajax-get', 'condition'=>'$status==0',), '编辑'=>array( 'href' => 'User/editAction?id=$id'), '删除'=>array( 'href' => 'User/setStatus?status=-1&ids=$id', 'class'=>'confirm ajax-get' ), ), ); echo $_table_list = $__controller__->tableList($_list,$thead); ?>
	</div>
	<!-- 分页 -->
	<div class="page"><?php echo ($_page); ?></div>
	<!-- /分页 -->


        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div class="fl">感谢使用<a href="http://www.onethink.cn" target="_blank">OneThink</a>管理平台</div>
                <div class="fr">V<?php echo (ONETHINK_VERSION); ?></div>
            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "/onethink", //当前网站地址
            "APP"    : "/onethink/index.php?s=", //当前项目地址
            "PUBLIC" : "/onethink/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/onethink/Public/static/think.js"></script>
    <script type="text/javascript" src="/onethink/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            $subnav.find("a[href='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
					    $(this).closest('label').removeClass('focus');
				    });
        }();
    </script>
    
<script type="text/javascript">
$(function(){
	$("#action_add").click(function(){
		window.location.href = $(this).attr('url');
	})
})
</script>

</body>
</html>
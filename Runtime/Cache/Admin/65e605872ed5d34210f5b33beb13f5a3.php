<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|OneThink管理平台</title>
    <link href="/WeiTime/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/WeiTime/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/WeiTime/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/WeiTime/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/WeiTime/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/WeiTime/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/WeiTime/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/WeiTime/Public/static/jquery-2.0.3.min.js"></script>
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
		<h2>用户列表</h2>
	</div>
	<div class="cf">
		<div class="fl">
            <button class="btn ajax-post" url="<?php echo U('User/changeStatus',array('method'=>'resumeUser'));?>" target-form="ids">启 用</button>
            <button class="btn ajax-post" url="<?php echo U('User/changeStatus',array('method'=>'forbidUser'));?>" target-form="ids">禁 用</button>
            <button class="btn ajax-post confirm" url="<?php echo U('User/changeStatus',array('method'=>'deleteUser'));?>" target-form="ids">删 除</button>
        </div>

        <!-- <div class="tools fr"> -->
            <!-- <div class="search-form cf"> -->
                <!-- <div class="drop-down"> -->
                    <!-- <span id="sch-sort-txt" class="sort-txt" data="">所有</span> -->
                    <!-- <i class="arrow arrow-down"></i> -->
                    <!-- <ul id="sub-sch-menu" class="nav-list hidden"> -->
                        <!-- <li><a href="javascript:;" value="">所有</a></li> -->
                        <!-- <li><a href="javascript:;" value="1">正常</a></li> -->
                        <!-- <li><a href="javascript:;" value="0">禁用</a></li> -->
                        <!-- <li><a href="javascript:;" value="2">待审核</a></li> -->
                    <!-- </ul> -->
                <!-- </div> -->
                <!-- <input type="text" name="uid" value="<?php echo I('uid');?>" placeholder="请输入UID"> -->
                <!-- <a class="sch-btn" href="javascript:;" id="search" url="<?php echo U('User/index','',false);?>">高级搜索</a> -->
            <!-- </div> -->
        <!-- </div> -->
    </div>
    <!-- 数据列表 -->
    <div class="data-table table-striped">
        <?php
 $thead = array( '_html'=>array( '_th'=>'row-selected', 'th'=>'<input class="check-all" type="checkbox"/>', 'td'=>'<input class="ids" type="checkbox" name="id[]" value="$uid" />', ), 'uid' => 'UID', 'nickname'=>'昵称', 'score'=>'积分', 'login'=>'登陆次数', 'last_login_ip'=>array( '_title'=>'最后登陆IP', 'tag' =>'span', 'func' => 'long2ip($last_login_ip)', ), 'last_login_time'=>array( '_title'=>'最后登陆时间', 'tag' =>'span', 'func' => 'date("Y-m-d H:i:s",$last_login_time)', ), 'status_text'=>'状态', '操作'=>array( '禁用'=>array( 'href' => 'User/changeStatus?method=forbidUser&id=$uid', 'class'=>'ajax-get', 'condition'=>'$status==1',), '启用'=>array( 'href' => 'User/changeStatus?method=resumeUser&id=$uid', 'class'=>'ajax-get', 'condition'=>'$status==0',), '删除'=>array( 'href' => 'User/changeStatus?method=deleteUser&id=$uid', 'class'=>'confirm ajax-get' ), '授权'=>array( 'href' => 'AuthManager/group?uid=$uid', 'class'=>'authorize'), ), ); echo $_table_list = $__controller__->tableList($_list,$thead); ?>
	</div>
    <div class="page">
        <?php echo ($_page); ?>
    </div>

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
            "ROOT"   : "/WeiTime", //当前网站地址
            "APP"    : "/WeiTime/index.php?s=", //当前项目地址
            "PUBLIC" : "/WeiTime/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/WeiTime/Public/static/think.js"></script>
    <script type="text/javascript" src="/WeiTime/Public/Admin/js/common.js"></script>
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
    
	<script src="/WeiTime/Public/static/thinkbox/jquery.thinkbox.js"></script>

	<script type="text/javascript">
	//搜索功能
	$("#search").click(function(){
		var url = $(this).attr('url');
		var status = $("#sch-sort-txt").attr("data");
		var search = $('input[name=uid]').val();
		if(status != ''){
			url += '/status/' + status;
		}
		if(search != ''){
			url += '/uid/' + encodeURIComponent(search);
		}
		window.location.href = url;
	});
	/* 高级搜索子菜单 */
	$(".search-form").find(".drop-down").hover(function(){
		$("#sub-sch-menu").removeClass("hidden");
	},function(){
		$("#sub-sch-menu").addClass("hidden");
	});
	$("#sub-sch-menu li").find("a").each(function(){
		$(this).click(function(){
			var text = $(this).text();
			$("#sch-sort-txt").text(text).attr("data",$(this).attr("value"));
			$("#sub-sch-menu").addClass("hidden");
		})
	});
    //导航高亮
    $('.side-sub-menu').find('a[href="<?php echo U('User/index');?>"]').closest('li').addClass('current');
	</script>

</body>
</html>
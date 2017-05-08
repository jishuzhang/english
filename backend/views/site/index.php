<?php
use backend\models\Nodes;
$username = Yii::$app->user->identity->username;
$top_navs = Nodes::find()->where('pid = 0 and display = 1')->orderBy('listorder ASC, nodeid ASC')->all();
?>
<!DOCTYPE html>
<html lang="zh-cn" class="no-js sidebar-large">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>管理系统</title>
    <link href="res/css/bootstrap.min.css" rel="stylesheet" />
    <link href="res/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="res/css/main.css" />
    <link href="res/css/responsive.css" rel="stylesheet" media="screen"/>
    <link  rel="stylesheet"  href="res/css/ui-dialog.css">
    <script src="res/js/ace-extra.min.js"></script>
    <!--[if lt IE 9]>
    <script src="res/js/html5shiv.js"></script>
    <script src="res/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<header class="header pxgrids-bg">
    <a href="javascript:void(0);" class="logo pull-left">
        <h3 style="color:white;" class="text-center">管理系统</h3>
    </a>
    <div class="pull-left topmenunav" id="menu">
        <ul class="pull-left top_menu" id="top_menu">
            <?php
            if(!empty($top_navs)){
                foreach($top_navs as $key=>$val){
                    $onnav = Nodes::findBySql('SELECT title FROM bl_nodes where nodeid!='.$val['nodeid'].' and c=\''.$val['c'].'\' and a=\''.$val['a'].'\'')->one();
                    ?>
                    <li><a href="javascript:void(0);" onclick="PANEL(this,'<?= $val['nodeid'] ?>','/index.php?r=<?= $val['c'] ?>/<?= $val['a'] ?><?= $val['data'] ?>','<?= $val['title'] ?>','<?= $onnav['title'] ?>')" <?php if($key==0){echo 'class="active"';} ?>><?= $val['title'] ?></a></li>
                <?php }
            }
            ?>
        </ul>
    </div>
    <div class="pull-right mobliebtn"><a id="mobile-nav" class="menu-nav" href="javascript:void(0);"></a></div>
    <div class="top-nav pull-right">
        <ul class="pull-right top-menu">

            <!-- userinfo dropdown start-->
            <li class="dropdown userinfo">
                <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">

                    <img  style="height: 41px; width: 41px;"  src="" class="userimg">
                    <span class="username"><?= $username ?></span>
                    <b class="caret"></b>
                </a>
            </li>
            <!-- userinfo dropdown end -->
            <li><a data-method="post" href="index.php?r=site/logout"><i class="icon-power-off"></i><span>退出</span></a></li>
        </ul>
    </div>
</header>
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>
    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="javascript:void(0);">
            <span class="menu-text"></span>
        </a>
        <div class="sidebar" id="sidebar">
            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
            </script>
            <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                    <button class="btn btn-success" onclick="PANEL(this,'2','/index.php?r=site/siteindex','我的面板','系统首页')"><i class="icon-signal"></i></button>
                    <button class="btn btn-info" onclick="PANEL(this,'4','/index.php?r=content/index','内容管理','文章发布')"><i class="icon-pencil"></i></button>
                    <button class="btn btn-warning" onclick="PANEL(this,'5','/index.php?r=nodes/index','扩展管理','菜单管理')"><i class="icon-group"></i></button>
                    <button class="btn btn-danger" onclick="PANEL(this,'3','/index.php?r=website/index','系统设置','基本设置')"><i class="icon-cogs"></i></button>
                </div>
                <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                    <span class="btn btn-success"></span>
                    <span class="btn btn-info"></span>
                    <span class="btn btn-warning"></span>
                    <span class="btn btn-danger"></span>
                </div>
            </div><!-- #sidebar-shortcuts -->
            <?php
            if(!empty($top_navs)){
                foreach($top_navs as $key=>$val){ ?>
                    <ul class="nav nav-list<?php if($key!=0){echo ' hide';} ?>" id="panel-<?= $val['nodeid'] ?>">
                        <?php
                        $left_navs = Nodes::find()->where(['pid'=>$val['nodeid'],'display'=>1])->orderBy('listorder ASC, nodeid ASC')->all();
                        if(!empty($left_navs)){
                            foreach($left_navs as $k=>$v){
                                if($v['c']!='0' && $v['a']!='0'){ ?>
                                    <li onclick="_PANEL(this,<?= $v['nodeid'] ?>,'index.php?r=<?= $v['c'] ?>/<?= $v['a'] ?><?= $v['data'] ?>','<?= $val['title'] ?>','<?= $v['title'] ?>')" class="_p_menu<?php if($k==0){echo ' fone';}if($v['nodeid']==6){echo ' active';} ?>">
                                        <a href="javascript:void(0);">
                                            <i class="<?php if($v['img_icon']){echo $v['img_icon'];}else{echo 'icon-dashboard';} ?>"></i>
                                            <span class="menu-text"><?= $v['title'] ?></span>
                                        </a>
                                    </li>
                                <?php }else{
                                    $dropdown_navs = Nodes::find()->where(['pid'=>$v['nodeid'],'display'=>1])->orderBy('listorder ASC, nodeid ASC')->all();
                                    ?>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-toggle">
                                            <i class="<?php if($v['img_icon']){echo $v['img_icon'];}else{echo 'icon-dashboard';} ?>"></i>
                                            <span class="menu-text">
                                                    <?= $v['title'] ?>
                                                <span class="badge badge-primary "><?= count($dropdown_navs) ?></span>
                                            </span>
                                            <b class="arrow icon-angle-down"></b>
                                        </a>
                                        <ul class="submenu">
                                            <?php
                                            if(!empty($dropdown_navs)){
                                                foreach($dropdown_navs as $nav){ ?>
                                                    <li onclick="_PANEL(this,<?= $nav['nodeid'] ?>,'/index.php?r=<?= $nav['c'] ?>/<?= $nav['a'] ?><?= $nav['data'] ?>','<?= $val['title'] ?>','<?= $v['title'] ?>','<?= $nav['title'] ?>')" class="_p_menu"><a href="javascript:void(0);"><i class="icon-double-angle-right"></i><?= $nav['title'] ?></a></li>
                                                <?php }
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                <?php }
                            }
                        }
                        ?>
                    </ul>
                <?php }
            }
            ?>
            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
            </div>
            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
            </script>
        </div>
        <!--main content start-->
        <div class="main-content">
            <div class="breadcrumbs" id="breadcrumbs">
                <script type="text/javascript">
                    try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
                </script>
                <ul class="breadcrumb">
                    <li><i class="icon-home home-icon"></i><a href="javascript:void(0);" class="bread_topnav">我的面板</a></li>
                    <li class="bread_leftnav">系统首页</li>
                    <li class="bread_onnav hide"></li>
                </ul><!-- .breadcrumb -->
                <div class="pull-right crumbsbutton">
                    <a href="http://yuanxiao.bailitop.com/" target="_blank">站点首页</a>
                </div>
            </div>
            <section id="iframecontent">
                <iframe style="width:100%;height: auto;" name="iframeid" id="iframeid" frameborder="false" scrolling="auto" allowtransparency="true" frameborder="0" src="/index.php?r=site/siteindex"></iframe>

            </section>
        </div>
        <!--main content end-->
    </div>
</div>
<!--[if !IE]> -->
<script src="res/js/jquery-2.0.3.min.js"></script>
<!-- <![endif]-->
<!--[if IE]>
<script src="res/js/jquery-1.10.2.min.js"></script>
<![endif]-->
<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='res/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="res/js/bootstrap.min.js"></script>
<script src="res/js/ace.min.js"></script>
<script src="res/js/jquery-easing.js"></script>
<script src="res/js/responsivenav.js"></script>
<script src="res/js/jquery.nicescroll.js"></script>
<script src="res/js/common.js"></script>
<script  src="res/js/dialog-plus.js"></script>
<script type="text/javascript">
    var parentpos = '';
    function PANEL(obj,menuid,gotourl,topnav,leftnav) {
        $("#top_menu li a").removeClass('active');
        $(".top_menu li a").removeClass('active');
        $(obj).addClass('active');

        $("#sidebar ul").addClass('hide');
        $("#panel-"+menuid).removeClass("hide");
        $(".submenu").removeClass("hide");
        $("._p_menu").removeClass('active');
        $(".fone").addClass('active');
        $(".submenu").css("display","none");
        $("#sidebar ul li").removeClass('open');
        if(gotourl) $("#iframeid").attr('src', gotourl);

        $(".breadcrumb .bread_topnav").html(topnav);
        $(".breadcrumb .bread_leftnav").html(leftnav);
        $(".breadcrumb .bread_onnav").addClass("hide");
    }
    function _PANEL(obj,menuid,gotourl,topnav,leftnav,onnav) {
        $("#iframeid").attr('src', gotourl);
        $("._p_menu").removeClass('active');
        $(obj).addClass('active');

        $(".breadcrumb .bread_topnav").html(topnav);
        $(".breadcrumb .bread_leftnav").html(leftnav);
        if(onnav){
            $(".breadcrumb .bread_onnav").html(onnav);
            $(".breadcrumb .bread_onnav").removeClass("hide");
        }else{
            $(".breadcrumb .bread_onnav").empty(onnav);
        }

    }
</script>
</body>
</html>
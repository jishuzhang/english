<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/13
 * Time: 10:42
 */
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
use common\library\MenuCache;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title = '百利天下接口管理系统') ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php
    //根据当前url取到路由

    $str = Yii::$app->requestedRoute;
    if($str){
        $url_arr = explode("/",$str);
    }else{
        $url_arr[0]='site';
        $url_arr[1]='index';
    }

    //设置缓存
    $SetDetailCache=new MenuCache();
    $SetDetailCache->SetTopmenuCache();
    $SetDetailCache->SetMenuStatusCache($url_arr);

    //缓存方法
    $cache=Yii::$app->cache;

    //取到所有的菜单的值，缓存文件在sitecontroller中
    $top_menu=$cache->get('top_menu');

    //根据菜单pid去重后，判断该顶级菜单下有多少子菜单，方便遍历
    $ul_menu=$cache->get('ul_menu');

    //根据访问的url进行判断，让对应的模块显示被选中的状态，缓存文件在backendcontroller中
    $p_param=$cache->get($url_arr[0].'_'.$url_arr[1]);

    //获取path中的id，跟判断头部菜单是否被选中
    $path=strstr($p_param['path'],'-')?explode('-',$p_param['path'])[0]:$p_param['path'];

    ?>
<?php $this->beginBody() ?>
<header class="header pxgrids-bg">
    <a href="javascript:;" target="_blank" class="logo pull-left"><img src="res/images/logo.png" title="点击打开网站首页"></a>
    <div class="pull-left topmenunav" id="menu">
        <ul class="pull-left top_menu" id="top_menu">
            <?php  foreach ($top_menu as $key=>$value):
                if($value['pid']==0 ){
                    if($value['floor']==($p_param['floor'] ==0 ? 1 :$p_param['floor']) || $value['floor']==0){
                    ?>
                    <li class="returncode_prompt">
                        <a  href="<?php echo Url::to([$value['controller'].'/'.$value['action']]);?>"
                        <?php  echo $path==$value['nodes_id'] ?  'class="active"': '';?>>
                            <?=$value['title']?>
                        </a>
                    </li>
                <?php } } endforeach; ?>

        </ul>
    </div>
    <div class="pull-right mobliebtn"><a id="mobile-nav" class="menu-nav" href=""></a></div>
    <div class="top-nav pull-right">
        <ul class="pull-right top-menu">
            <!-- userinfo dropdown start-->
            <li class="dropdown userinfo">
                <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);">
                    <?php
                    if(!empty(Yii::$app->user->identity->users_id)){
                    $sql = "select portrait from users where users_id=".Yii::$app->user->identity->users_id;
                    $arr_portrait =  Yii::$app->db->createCommand($sql)->queryOne();
                    //var_dump($arr_portrait['portrait']);
                    }
                    ?>
                    <img  style="height: 41px; width: 41px;"  src="<?php if(isset($arr_portrait['portrait'])){echo $arr_portrait['portrait'];}else{echo 'res/images/img_04.jpg';} ?>" class="userimg">
                    <span class="username">
                        <?php
                        if(!empty(Yii::$app->user->identity->users_id)){
                        $sql = "select realname,logintime from users where users_id=".Yii::$app->user->identity->users_id;
                        $userinfo =  Yii::$app->db->createCommand($sql)->queryOne();
                        echo $userinfo['realname'];
                        }
                        ?></span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended userullist" id="userullist">
                    <div class="log-arrow-up"><i class="icon-sort-up"></i></div>
                    <li class="usersettitle"><h5>个人信息</h5></li>
                    <li><a href="javascript:void(1);">本次登陆IP:<?= $_SERVER["REMOTE_ADDR"] ?></a></li>
                    <li><a href="javascript:void(1);">本次登陆时间:<?php echo date('Y-m-d h:i:s',isset($userinfo['logintime'])?$userinfo['logintime']:time())?></a></li>
                    <li class="returncode_prompt"><a href="<?=Url::to(['personal/update']);?>" >个人信息设置/密码修改</a></li>
                </ul>
            </li>
            <!-- userinfo dropdown end -->
            <li class="returncode_prompt"><a data-method="post" href="<?=Url::to(['site/logout']);?>"><i class="icon-power-off"></i><span>退出</span></a></li>

        </ul>
    </div>
</header>
<!--header end-->
    <!--left start-->
    <div class="main-container" id="main-container">
        <script type="text/javascript">
            try{ace.settings.check('main-container' , 'fixed')}catch(e){}
        </script>
        <div class="main-container-inner">
            <a class="menu-toggler" id="menu-toggler" href="#">
                <span class="menu-text"></span>
            </a>
            <div class="sidebar" id="sidebar">
                <script type="text/javascript">
                    try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
                </script>

                <?php foreach($ul_menu as $item):?>
                    <ul class="nav nav-list <?php echo $path == $item && $item!=0 ? '': 'hide'?>" id="panel-<?= $item?>">
                        <?php foreach($top_menu as $value):
                            if($item==$value['pid']){
                                $url=$value['controller'].'/'.$value['action'];
                                ?>
                                <li class="_p_menu <?php  if($url_arr[0]=='application'){ echo $value['path']==$p_param['path'] ? 'active':'';}else { echo $value['controller']==$p_param['controller'] ? 'active': '';} ?>">
                                    <a class="returncode_prompt" href="<?=Url::to([$url])?>" >
                                        <i class="icon-signal"></i>
                                        <span class="menu-text"><?=$value['title']?></span>
                                    </a>
                                </li>
                            <?php } endforeach; ?>
                    </ul>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    <div id="page-wrapper" style="margin-left: 190px;padding-top: 0;">
        <div class="container">
            <?= $content ?>
        </div>
    </div>
<?php $this->endBody() ?>
    </body>

</html>
<?php $this->endPage() ?>
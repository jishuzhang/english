<?php
use backend\models\Roles;
use backend\models\Logintime;
use backend\models\Admin;

$userid = Yii::$app->user->identity->userid;
$username = Yii::$app->user->identity->username;
$roleid = Yii::$app->user->identity->roleid;

date_default_timezone_set('PRC'); // 中国时区
?>
<!DOCTYPE html>
<html lang="zh-cn" class="no-js sidebar-large">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>百利天下教育管理系统</title>
    <link href="res/css/bootstrap.min.css" rel="stylesheet">
    <link href="res/css/bootstrapreset.css" rel="stylesheet">
    <link href="res/css/pxgridsicons.min.css" rel="stylesheet" />
    <link href="res/css/style.css" rel="stylesheet">
    <link href="res/css/responsive.css" rel="stylesheet" />
    <link href="res/css/animation.css" rel="stylesheet">
    <script src="res/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <!--[if lt IE 9]>
    <script src="res/js/html5shiv.js"></script>
    <script src="res/js/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="res/css/xitongshouye.css" />
</head>
<body>
<section class="wrapper">
    <!--state overview start-->
    <div class="row state-overview">
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol userblue">
                    院校数
                </div>
                <div class="value">
                    <h1 id="count1">100</h1>
                    <p>院校总数</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol commred">
                    专业数
                </div>
                <div class="value">
                    <h1 id="count2">200</h1>
                    <p>专业总数</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol articlegreen">
                    案例数
                </div>
                <div class="value">
                    <h1 id="count3">300</h1>
                    <p>案例总数</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol rsswet">
                    文章数
                </div>
                <div class="value">
                    <h1 id="count4">400</h1>
                    <p>文章总数</p>
                </div>
            </section>
        </div>
    </div>
    <!--state overview end-->

    <div class="row">
        <!--表单-->
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading bm0">
                    <span>我的状态及网站信息</span>
                </header>
                <div class="panel-body" id="panel-bodys">
                    <table class="table table-hover personal-task">
                        <tbody>
                        <tr>
                            <td>登录者：</td>
                            <td><a><?= $username ?></a></td>
                            <td class="col-md-4">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>角　色：</td>
                            <td><a><?= Roles::findOne($roleid)->role_name ?></a></td>
                            <td class="col-md-4">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>登录次数：</td>
                            <td><a><?= Logintime::find()->where(['uid'=>$userid])->count() ?> 次</a></td>
                            <td class="col-md-4">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>本次登录IP：</td>
                            <td><a><?= $_SERVER["REMOTE_ADDR"] ?></a></td>
                            <td class="col-md-4">&nbsp;</td>
                        </tr>

                        <tr>
                            <td>上次登录IP：</td>
                            <td><a><?php $logdata = Logintime::find()->where(['uid'=>$userid])->orderBy('logintime DESC')->offset('1')->one();if($logdata){echo $logdata->ip;}else{echo "未知";} ?></a></td>
                            <td class="col-md-4">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>上次登录时间：</td>
                            <td><a><?php $logtime = Logintime::find()->where(['uid'=>$userid])->orderBy('logintime DESC')->offset('1')->one();if($logtime){echo date('Y-m-d H:i:s', $logtime->logintime); }else{echo "未知";} ?></a></td>
                            <td class="col-md-4">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>最新评估数：</td>
                            <td><a>**（共计评估数**）</a></td>
                            <td class="col-md-4">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>排名数：</td>
                            <td><a>**</a></td>
                            <td class="col-md-4">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>社会实践产品数：</td>
                            <td><a>***</a></td>
                            <td class="col-md-4">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>管理员总数：</td>
                            <td><a><?= Admin::find()->count() ?> 个</a></td>
                            <td class="col-md-4">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>过期广告数：</td>
                            <td><a>***</a></td>
                            <td class="col-md-4">&nbsp;</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <!--表单-->

        <!--版权信息-->
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading bm0">
                    <span>团队及系统环境</span>
                </header>
                <div class="panel-body" id="panel-bodys">
                    <table class="table table-hover personal-task" style="color:#797979;">
                        <tbody>
                        <tr>
                            <td>
<!--                                <strong>服务器软件</strong>：（Web服务---><?//= $_SERVER["SERVER_SOFTWARE"] ?><!--， PHP版本---><?//= PHP_VERSION ?><!--， MySQL版本---><?//= mysql_get_server_info() ?><!--）-->
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>服务器系统</strong>：<?= php_uname() ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>上传文件</strong>：<?= ini_get("file_uploads") ? "支持" : "不支持" ?>（最大文件：<?= ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled" ?>，表单：<?= ini_get("file_uploads") ? ini_get("post_max_size") : "Disabled" ?>）
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>全局变量</strong>：<?= ini_get("auto_globals_jit") ? "开启" : "关闭" ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>魔术引用</strong>：<?= ini_get("magic_quotes_gpc") ? "开启" : "关闭" ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>当前时间</strong>：<?= date('Y-m-d H:i:s', time()) ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>SOCRET支持</strong>：<?= extension_loaded('sockets') ? "支持" : "不支持" ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>程序编码</strong>：<?= Yii::$app->charset ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>架构设计</strong>：百利天下技术部
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>开发团队</strong>：百利天下技术部
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>项目测试</strong>：百利天下技术部
                            </td>
                            <td></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <!--版权信息-->
    </div>
</section>
<script src="res/js/jquery.min.js"></script>
<script src="res/js/common.js"></script>
<script src="res/js/bootstrap.min.js"></script>
<script src="res/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="res/js/pxgrids-scripts.js"></script>
</body>
</html>
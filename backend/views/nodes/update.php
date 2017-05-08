<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Nodes */

$this->title = '修改菜单';
$this->params['breadcrumbs'][] = ['label' => 'Nodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->nodeid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<!DOCTYPE html>
<html lang="zh-cn" class="no-js sidebar-large">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>教育管理系统</title>
    <link href="res/css/bootstrap.min.css" rel="stylesheet" />
    <link href="res/css/bootstrapreset.css" rel="stylesheet" />
    <link href="res/css/pxgridsicons.min.css" rel="stylesheet" />
    <link href="res/css/style.css" rel="stylesheet" />
    <link href="res/css/responsive.css" rel="stylesheet" media="screen"/>
    <link href="res/css/animation.css" rel="stylesheet" />
    <script src="res/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="res/js/jquery.min.js"></script>
    <script src="res/js/common.js"></script>
    <script src="res/js/jquery-easing.js"></script>
    <script src="res/js/responsivenav.js"></script>
    <!--[if lt IE 9]>
    <script src="res/js/html5shiv.js"></script>
    <script src="res/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<section class="wrapper">
<div class="nodes-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <p>
        <?= Html::a('<i class="icon-share-alt btn-icon"></i>后退', ['index', 'pid'=>$model->pid], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="icon-gears btn-icon"></i>菜单管理', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="icon-plus btn-icon"></i>添加菜单', ['create'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="icon-wrench btn-icon"></i>编辑菜单', ['update', 'id'=>$model->nodeid], ['class' => 'btn btn-info']) ?>
    </p>
    <?= $this->render('_form', [
        'model' => $model,
        'datas' =>$datas,
    ]) ?>

</div>
</section>
<script src="res/js/bootstrap.min.js"></script>
<script src="res/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="res/js/pxgrids-scripts.js"></script>
</body>
</html>

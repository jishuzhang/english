<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\NodesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '菜单管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<!DOCTYPE html>
<html lang="zh-cn" class="no-js sidebar-large">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <div class="nodes-index">

        <p>
            <?= Html::a('<i class="icon-plus btn-icon"></i>添加台词', ['create'], ['class' => 'btn btn-info']) ?>
        </p>

        <?php $form = ActiveForm::begin([
            'action' => ['nodes/listorder'],
            'method'=>'post',
        ]); ?>

        <div class="grid-view">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>视频ID</th>
                        <th>添加时间</th>
                        <th>更新时间</th>
                        <th>管理操作</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($model as $evModel):?>
                        <tr>
                            <td><?php echo $evModel['vid']?></td>
                            <td><?php echo date('Y-m-d H:i',$evModel['ctime'])?></td>
                            <td><?php echo date('Y-m-d H:i',$evModel['utime'])?></td>
                            <td>
                                <a href="<?php echo Url::toRoute(['dialogue/edit','tid'=>$evModel['tid']])?>" class="btn btn-primary btn-xs">编辑</a>
                                <a href="<?php echo Url::toRoute(['dialogue/delete','tid'=>$evModel['tid']])?>" title="删除" class="btn btn-danger btn-xs">删除</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pull-right">
                        <?= LinkPager::widget(['pagination' => $pages]); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</section>

<script src="res/js/bootstrap.min.js"></script>
<script src="res/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="res/js/pxgrids-scripts.js"></script>
</body>
</html>
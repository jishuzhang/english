<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use common\widgets\Alert;
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
<?= Alert::widget() ?>
<section class="wrapper">
    <div class="nodes-index">

        <p>
            <?= Html::a('<i class="icon-plus btn-icon"></i>添加试卷', ['create'], ['class' => 'btn btn-info']) ?>
        </p>
        <p>温馨提醒:试卷启用状态下无法更改试卷内题目相关设置,需在试卷关闭状态下才可以使用该功能</p>
        <?php $form = ActiveForm::begin([
            'action' => ['nodes/listorder'],
            'method'=>'post',
        ]); ?>

        <div class="grid-view">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>试卷ID</th>
                        <th>试卷名称</th>
                        <th>试卷作者</th>
                        <th>更新时间</th>
                        <th>管理操作</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($model as $evModel):?>
                        <tr>
                            <td><?php echo $evModel['id']?></td>
                            <td><?php echo $evModel['name']?></td>
                            <td><?php echo $evModel['author']?></td>
                            <td><?php echo date('Y-m-d H:i',$evModel['last_modfiy_time'])?></td>
                            <td>
                                <?php if($evModel['status']):?>
                                    <a href="<?php echo Url::toRoute(['exam/deactivate','id'=>$evModel['id']])?>" title="关闭" class="btn btn-warning btn-xs">关闭</a>
                                <?php else:?>
                                    <a href="<?php echo Url::toRoute(['exam/activate','id'=>$evModel['id']])?>" title="启用" class="btn btn-warning btn-xs">启用</a>
                                    <a href="<?php echo Url::toRoute(['exam/update','id'=>$evModel['id']])?>" class="btn btn-primary btn-xs">编辑</a>
                                    <a href="<?php echo Url::toRoute(['exam/delete','id'=>$evModel['id']])?>" title="删除" class="btn btn-danger btn-xs">删除</a>
                                <?php endif;?>
                                <a href="<?php echo Url::toRoute(['exam/view','id'=>$evModel['id']])?>" title="查看" class="btn btn-info btn-xs">查看</a>
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
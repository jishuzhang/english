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

        <p style="color:red;font-size:15px;">温馨提醒:此处只提供启用状态试卷的统计数据实时统计</p>
        <?php $form = ActiveForm::begin([
            'action' => ['nodes/listorder'],
            'method'=>'post',
        ]); ?>

        <div class="grid-view">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>试卷名称</th>
                        <th>试卷类型</th>
                        <th>使用情况统计/次</th>
                        <th>考试人数统计/人</th>
                        <th>待审阅答案/份</th>
                        <th>管理操作</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($model as $evModel):?>
                        <tr>
                            <td><?php echo $evModel['name']?></td>
                            <td>
                                <?php if($evModel['time_lock'] == 1):?>
                                    汉译英
                                <?php elseif($evModel['time_lock'] == 0):?>
                                    英译汉
                                <?php endif;?>
                            </td>
                            <td><?php echo $count[$evModel['id']]['all']?></td>
                            <td><?php echo $count[$evModel['id']]['member']?></td>
                            <td><span style="color:red;"><?php echo $count[$evModel['id']]['deal']?></span></td>
                            <td>
                                <a href="<?php echo Url::toRoute(['score/list','id'=>$evModel['id']])?>" title="详情预览" class="btn btn-info btn-xs">详情预览</a>
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
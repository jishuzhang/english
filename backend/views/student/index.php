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

        <p>温馨提醒:最后修改时间意指针对该用户敏感信息修改操作时间记录,例如上一次修改密码、修改用户名等</p>


        <div class="grid-view">

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>学生ID</th>
                    <th>学生姓名</th>
                    <th>注册邮箱</th>
                    <th>最后修改</th>
                    <th>管理操作</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($model as $evModel):?>
                    <tr>
                        <td><?php echo $evModel['id']?></td>
                        <td><?php echo $evModel['username']?></td>
                        <td><?php echo $evModel['email']?></td>
                        <td><?php echo date('Y-m-d H:i',$evModel['updated_at'])?></td>
                        <td>
                            <a href="<?php echo Url::toRoute(['student/update','uid'=>$evModel['id']])?>" title="编辑" class="btn btn-info btn-xs">编辑</a>
                            <a href="<?php echo Url::toRoute(['student/view','uid'=>$evModel['id']])?>" title="查看成绩" class="btn btn-info btn-xs">查看成绩</a>
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


    </div>
</section>

<script src="res/js/bootstrap.min.js"></script>
<script src="res/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="res/js/pxgrids-scripts.js"></script>
</body>
</html>
<?php
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\NodesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
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
    <div class="nodes-index">

        <p>
            <?= Html::a('<i class="icon-gears2 btn-icon"></i>后台操作日志', ['cindex'], ['class' => 'btn btn-default']) ?>
            <?= Html::a('<i class="icon-gears2 btn-icon"></i>后台登录日志', ['loginindex'], ['class' => 'btn btn-default']) ?>
            <?= Html::a('<i class="icon-gears2 btn-icon"></i>编辑操作日志', ['editor'], ['class' => 'btn btn-primary']) ?>
        </p>

        <div class="grid-view">
            <div class="summary">
                <h6>
                    <?php echo "<a href='index.php?r=logs/cindex'>日志管理</a>";?>
                </h6>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>谁？</th>
                    <th>时间</th>
                    <th>动作</th>
                    <th>事件</th>
                    <!--th>详细参数</th-->
                    <th>IP</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $row ): ?>
                    <tr data-key='<?= $row->logid ?>'>
                        <td><?= $row->logid ?></td>
                        <td><?= $row->username ?></td>
                        <td><?= date("Y-m-d H:i:s",$row->addtime) ?></td>
                        <td><?php if($row->action == 'add'){
                                echo "添加";
                            }else if($row->action == 'edit'){
                                echo "编辑";
                            }else if($row->action == 'delete'){
                                echo "删除";
                            }else if($row->action == 'sort'){
                                echo "排序";
                            }else{
                                echo "检查";
                            }


                            ?></a></td>

                        <td><?= $row->title ?></td>
                        <td><?= $row->ip ?></td>
                        <td><a data-pjax="0" aria-label="Update" title="编辑" href="/index.php?r=category/update&id=<?= $row['logid'] ?>" class="btn btn-primary btn-xs">编辑</a> </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>

            <?= LinkPager::widget(['pagination' => $pages]) ?>
        </div>

    </div>
</section>
<script src="res/js/bootstrap.min.js"></script>
<script src="res/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="res/js/pxgrids-scripts.js"></script>
</body>
</html>
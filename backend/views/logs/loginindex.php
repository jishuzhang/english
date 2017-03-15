<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Nodes;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\NodesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '菜单管理';
$this->params['breadcrumbs'][] = $this->title;

if(Yii::$app->request->get('pid')){
    $pid = Yii::$app->request->get('pid');
}else{
    $pid = 0;
}
$nav = Nodes::findone($pid);
?>
<!DOCTYPE html>
<html lang="zh-cn" class="no-js sidebar-large">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>百利天下教育管理系统</title>
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
        <?= Html::a('<i class="icon-gears2 btn-icon"></i>后台登录日志', ['loginindex'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="icon-gears2 btn-icon"></i>编辑操作日志', ['editor'], ['class' => 'btn btn-default']) ?>
    </p>
    
    <div class="grid-view">
        <div class="summary">
            <h6>
            <?php if($pid=="0"){
                         echo "<a href='index.php?r=logs/cindex'>日志管理</a>";
                    }else{
                        $arr = explode('_',$nav->path);
                        $str = "<a href='index.php?r=logs/cindex'>日志管理</a>";
                        foreach($arr as $v){
                            if($v!=0){
                                $data = Nodes::findone($v);
                                $str .= " >> ".$data->title."</a>";
                            }
                        }
                        $str .= " >> ".$nav->title;
                    echo $str;
                    } ?>
            </h6>
        </div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>操作人</th>
                    <th>状态</th>
                    <th>最后登录时间</th>
                    <th>登陆IP</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $row ): ?>
                  <tr data-key='<?= $row['id'] ?>'>

                    <td><?= $row['id'] ?></td>
                    <td><?= $row['username'] ?></a></td>
                    <td><?= $row['status'] ?></td>
                    <td><?= date("Y-m-d H:i:s",$row['logintime']) ?></td>
					<td><?= $row['ip'] ?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
		  <?= LinkPager::widget(['pagination' => $pages]); ?>
    </div>
</div>
</section>
<script src="res/js/bootstrap.min.js"></script>
<script src="res/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="res/js/pxgrids-scripts.js"></script>
</body>
</html>
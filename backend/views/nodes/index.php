<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Nodes;
use yii\widgets\ActiveForm;

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
        <?= Html::a('<i class="icon-gears btn-icon"></i>菜单管理', ['index'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('<i class="icon-plus btn-icon"></i>添加菜单', ['create'], ['class' => 'btn btn-default']) ?>
    </p>
    
    <?php $form = ActiveForm::begin([
        'action' => ['nodes/listorder'],
        'method'=>'post',
        ]); ?>  
    <input type="hidden" value="<?= $pid ?>" name="pid">
    <div class="grid-view">
        <div class="summary">
            <h6>
            <?php if($pid=="0"){
                         echo "<a href='index.php?r=nodes/index'>菜单管理</a>";
                    }else{
                        $arr = explode('_',$nav->path);
                        $str = "<a href='index.php?r=nodes/index'>菜单管理</a>";
                        foreach($arr as $v){
                            if($v!=0){
                                $data = Nodes::findone($v);
                                $str .= " >> <a href='index.php?r=nodes/index&pid=".$data->nodeid."'>".$data->title."</a>";
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
                    <th><a data-sort="listorder" href="/index.php?r=nodes/index&sort=listorder">排序</a></th>
                    <th><a data-sort="nodeid" href="/index.php?r=nodes/index&sort=nodeid">菜单ID</a></th>
                    <th><a data-sort="title" href="/index.php?r=nodes/index&sort=title">菜单名称</a></th>
                    <th><a data-sort="pid" href="/index.php?r=nodes/index&sort=pid">上级菜单</a></th>
                    <th><a data-sort="c" href="/index.php?r=nodes/index&sort=c">控制器</a></th>
                    <th><a data-sort="a" href="/index.php?r=nodes/index&sort=a">方法</a></th>
                    <th><a data-sort="listorder" href="/index.php?r=nodes/index&sort=listorder">排序</a></th>
                    <th><a data-sort="display" href="/index.php?r=nodes/index&sort=display">是否显示</a></th>
                    <th><a data-sort="path" href="/index.php?r=nodes/index&sort=path">菜单路径</a></th>
                    <th class="col-sm-2"><a>管理操作</a></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($nodesdatas as $row ): ?>
                <tr data-key='<?= $row->nodeid ?>'>
                    <td>
                        <div><input type="text" value="<?= $row->listorder ?>" size="3" name="listorder[<?= $row->nodeid ?>]" style="padding:3px" class="center"></div>
                    </td>
                    <td><?= $row->nodeid ?></td>
                    <td><a href="/index.php?r=nodes/index&pid=<?= $row->nodeid ?>"><?= $row->title ?></a></td>
                    <td><?php if($row->pid==0){echo "顶级菜单";}else{$data = Nodes::findone($row->pid);echo $data->title;} ?></td>
                    <td><?= $row->c ?></td>
                    <td><?= $row->a ?></td>
                    <td><?= $row->listorder ?></td>
                    <td><?php if($row->display==1){echo "是";}else{echo "否";} ?></td>
                    <td><?php if($row->path=="0"){echo "顶级菜单";}else{$arr = explode('_',$row->path);$str = "顶级菜单";foreach($arr as $v){if($v!=0){$data = Nodes::findone($v);$str .= " / ".$data->title;}}echo $str;} ?></td>                   
                    <td><a data-pjax="0" aria-label="Create" title="添加子菜单" href="/index.php?r=nodes/create&id=<?= $row->nodeid ?>" class="btn btn-default btn-xs">添加子菜单</a>
                        <a data-pjax="0" aria-label="Update" title="编辑" href="/index.php?r=nodes/update&id=<?= $row->nodeid ?>" class="btn btn-primary btn-xs">编辑</a> 
                        <a data-pjax="0" data-method="post" data-confirm="确认要删除吗？" aria-label="Delete" title="删除" href="/index.php?r=nodes/delete&id=<?= $row->nodeid ?>" class="btn btn-danger btn-xs">删除</a>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <?= Html::submitButton( '排序', ['class' => 'btn btn-info btn-sm'])?>
    <?php ActiveForm::end(); ?>
</div>
</section>
<script src="res/js/bootstrap.min.js"></script>
<script src="res/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="res/js/pxgrids-scripts.js"></script>
</body>
</html>
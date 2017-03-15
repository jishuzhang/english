<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
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
</head>
<body>
<section class="wrapper">
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading">
    <div>
				
		<?= Html::a('<i class="icon-gears btn-icon"></i>权限管理', ['admin/index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="icon-gears btn-icon"></i>管理员添加', ['admin/add_admin'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="icon-gears btn-icon"></i>角色管理', ['roles/role_manage'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('<i class="icon-plus btn-icon"></i>角色添加', ['roles/role_add'], ['class' => 'btn btn-default']) ?>
  
</div>
    </header>
<table class="table table-striped table-advance table-hover">
	<thead>
	<tr>
	<th>序号</th>
	<th>角色名字</th>
	<th>描述</th>
	<th class="text-center">操作</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($roles as $role):?>
		<tr>
			<td><?=Html::encode("{$role->id}")?></td>
			<td><?=Html::encode("{$role->role_name}")?></td>
			<td><?=Html::encode("{$role->remark}")?></td>
			<td class="text-center">
			<?php if($role->id== 1 ){?>
			<a href="javascript:;" class="btn btn-default btn-xs">权限设置</a>	
			<!--
            <a href="javascript:;" class="btn btn-default btn-xs">内容管理权限</a>	
			-->
		    <a href="index.php?r=roles/role_update&id=<?=Html::encode("{$role->id}")?>" class="btn btn-warning  btn-xs">修改</a>
            <a href="javascript:;" data-confirm="确认要删除吗？" class="btn btn-default btn-xs" >删除</a>			
			<?php }else{?>
			<a href="index.php?r=roles/role_set&id=<?=Html::encode("{$role->id}")?>" class="btn btn-primary  btn-xs">权限设置</a>
			<!--
			<a href="index.php?r=roles/content_set&id=<?=Html::encode("{$role->id}")?>" class="btn btn-primary  btn-xs">内容管理权限</a>
			-->
			<a href="index.php?r=roles/role_update&id=<?=Html::encode("{$role->id}")?>" class="btn btn-warning  btn-xs">修改</a>
			<a href="index.php?r=roles/role_delete&id=<?=Html::encode("{$role->id}")?>" data-confirm="确认要删除吗？" class="btn btn-danger   btn-xs" >删除</a>
			<?php }?>
			</td>			
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<div class='pull-right'>
	<?= LinkPager::widget(['pagination' => $pagination]) ?>
</div>

<?php $this->registerJsFile('@web/js/roles.js',
		['depends' => [\yii\web\JqueryAsset::className()]]);
?>
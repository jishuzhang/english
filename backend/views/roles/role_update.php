<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use Install\Controller\IndexController;
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
        <?= Html::a('<i class="icon-gears btn-icon"></i>角色管理', ['roles/role_manage'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="icon-plus btn-icon"></i>角色添加', ['roles/role_add'], ['class' => 'btn btn-info']) ?>
  
</div>
    </header> 
     <table class="table table-striped table-advance table-hover">
        <thead>
        <tr>
            <th class="hidden-phone tablehead">修改角色</th>
        </tr>
        </thead>
    </table>
    <div class="panel-body form-horizontal tasi-form">
        
		<?php $form = ActiveForm::begin(['action' => ['roles/role_update'],
		'method'=>'post',
	 		]); ?>
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">角色名称</label>
                <div class="col-sm-4 input-group">
                    <input type="text" errormsg="别名至少2个字符,最多30个字符！" datatype="s2-30" color="#000000" value="<?=Html::encode("{$rows[0]['role_name']}")?>" name="name" class="form-control">
                <span class="Validform_checktip"></span></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">角色描述</label>
                <div class="col-sm-4 input-group">
                    <textarea rows="3" cols="60" class="form-control" name="remark"><?=Html::encode("{$rows[0]['remark']}")?></textarea>               
				</div>
            </div>
            
             <input type="hidden" name="id" value="<?=Html::encode("{$rows[0]['id']}")?>"/>

            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label"></label>
                <div class="col-sm-10 input-group">
                    <input type="submit" value="提交" name="submit" class="btn btn-info">
                </div>
            </div>
        <?php ActiveForm::end(); ?> 
    </div>
</section>
</div>
</div>
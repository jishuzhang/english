<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
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
	<title>教育管理系统</title>
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
        <?= Html::a('<i class="icon-gears btn-icon"></i>管理员添加', ['admin/add_admin'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('<i class="icon-gears btn-icon"></i>角色管理', ['roles/role_manage'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="icon-plus btn-icon"></i>角色添加', ['roles/role_add'], ['class' => 'btn btn-default']) ?>
  
</div>
    </header>
    <div class="panel-body form-horizontal tasi-form">
    
     <?php $form = ActiveForm::begin(['action' => ['admin/admin_edit'],
    	'method'=>'post',
	 		]); ?>
            <div class="form-group ">
                <label class="col-sm-2 col-sm-2 control-label">所属角色</label>
                <div class="col-sm-4 input-group">
                   <select name="roleid">
					<?php foreach ($rows as $ro):?>
 					 <option value ="<?=Html::encode("{$ro['id']}")?>"
 					 	<?= 
 					 	Html::encode("{$ro['id']}")==Html::encode("{$role_id}") ? 'selected':false;
 					 	?>
 					 	>
 					  	<?=Html::encode("{$ro['role_name']}")?> 
 					  </option>
 					  
 					 <?php endforeach;?>
				</select>   
                 </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">管理员账号</label>
                <div class="col-sm-4 input-group">
                <input type="text" name="username" readonly="" color="#000000" value="<?=Html::encode("{$row[0]['username']}")?>" class="form-control"/>
                  
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">密码</label>
                <div class="col-sm-4 input-group">
                    <input type="password" placeholder="留空，则使用前台密码" title="" value="" name="password_hash" class="form-control">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">真实姓名</label>
                <div class="col-sm-4 input-group">
                <input type="text" name="realname" errormsg="至少2个字符,最多20个字符！" datatype="s2-30" color="#000000" value="<?=Html::encode("{$row[0]['realname']}")?>" class="form-control"/>
               
                <span class="Validform_checktip"></span></div>
            </div>
            <input type="hidden" name="id" value="<?=Html::encode("{$row[0]['userid']}")?>"/>
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

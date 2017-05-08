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
                        <?= Html::a('<i class="icon-gears btn-icon"></i>管理员添加', ['admin/add_admin'], ['class' => 'btn btn-default']) ?>
                        <?= Html::a('<i class="icon-gears btn-icon"></i>角色管理', ['roles/role_manage'], ['class' => 'btn btn-default']) ?>
                        <?= Html::a('<i class="icon-plus btn-icon"></i>角色添加', ['roles/role_add'], ['class' => 'btn btn-info']) ?>
  
                    </div>
                </header>
                        <div  class="panel-body"  id="panel-bodys">
                    <table  class="table table-striped table-advance table-hover"  id="contenttable">
                        <tbody>
        
                                <?php $form = ActiveForm::begin(['action' => ['roles/role_add'],
                                'method'=>'post',
                                    'fieldConfig' => [  //统一修改字段的模板
                                        'template' => '<tr><td  style="width: 130px;"><span>{label}</span></td><td  class="hidden-phone"><div  class="col-sm-12 input-group">{input}</div></td>{error}</tr>',
                                        'labelOptions' => ['class' => 'col-sm-8 input-group']
                                    ]
                                    ]); ?>
                                            <?= $form->field($model, 'role_name')->textInput(['maxlength' => true,'style'=>'width:300px'])->label('角色名称:') ?>
                                            <?= $form->field($model, 'remark')->textarea(['maxlength' => true,'style'=>'width:300px'])->label('角色描述:') ?>
                                <tr>
                                    <td colspan='2'>
                                        <div  class="contentsubmit">
                                        <?= Html::submitButton('提交', ['class' => 'btn btn-info btn-sm']) ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php ActiveForm::end(); ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
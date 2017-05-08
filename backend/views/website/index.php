<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Website */
/* @var $form yii\widgets\ActiveForm */

$this->title = '系统设置';
$this->params['breadcrumbs'][] = ['label' => 'Websites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                            <?= Html::a('<i class="icon-gears btn-icon"></i>基本设置', ['index'], ['class' => 'btn btn-info']) ?>
                    </div>
                </header>

                <div  class="panel-body"  id="panel-bodys">
                    <table  class="table table-striped table-advance table-hover"  id="contenttable">
                        <tbody>

                            <?php $form = ActiveForm::begin([
                                'fieldConfig' => [  //统一修改字段的模板
                                    'template' => '<tr><td  style="width: 130px;"><span>{label}</span></td><td  class="hidden-phone"><div  class="col-sm-12 input-group">{input}</div></td>{error}</tr>',
                                    'labelOptions' => ['class' => 'col-sm-8 input-group']
                                ]
                                ]);

                            ?>

                            <?= $form->field($model, 'name', ['labelOptions' => ['class' => 'col-sm-1', 'style'=>'width: 110px;']])->textInput(['maxlength' => true, 'style'=>'width:500px']) ?>

                            <?= $form->field($model, 'url', ['labelOptions' => ['class' => 'col-sm-1', 'style'=>'width: 110px;']])->textInput(['maxlength' => true, 'style'=>'width:500px']) ?>

                            <?= $form->field($model, 'title', ['labelOptions' => ['class' => 'col-sm-1', 'style'=>'width: 110px;']])->textInput(['maxlength' => true, 'style'=>'width:500px']) ?>

                            <?= $form->field($model, 'keywords', ['labelOptions' => ['class' => 'col-sm-1', 'style'=>'width: 110px;']])->textInput(['maxlength' => true, 'style'=>'width:500px']) ?>

                            <?= $form->field($model, 'description', ['labelOptions' => ['class' => 'col-sm-1', 'style'=>'width: 110px;']])->textarea(['rows' => 3, 'style'=>'width:500px']) ?>

                            <?= $form->field($model, 'copyright', ['labelOptions' => ['class' => 'col-sm-1', 'style'=>'width: 110px;']])->textInput(['maxlength' => true, 'style'=>'width:500px']) ?>

                            <?= $form->field($model, 'stat', ['labelOptions' => ['class' => 'col-sm-1', 'style'=>'width: 110px;']])->textarea(['rows' => 6, 'style'=>'width:500px']) ?>

                            <tr>
                                <td colspan='2'>
                                    <div  class="contentsubmit">
                                <?= Html::submitButton('提交', ['class' => 'btn btn-info mybtn']) ?>
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
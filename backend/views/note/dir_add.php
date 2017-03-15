<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

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

</head>
<body>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <div>
                        <?= Html::a('<i class="icon-gears btn-icon"></i>添加目录', ['note/add'], ['class' => 'btn btn-info']) ?>
                    </div>
                </header>


                <div  class="panel-body"  id="panel-bodys">
                    <table  class="table table-striped table-advance table-hover"  id="contenttable">
                        <tbody>

                        <?php $form = ActiveForm::begin(['action' => ['note/add'],
                            'class'=>['form-horizontal tasi-form'],
                            'method'=>'post',
                        ]); ?>

                        <tr>
                            <td>
                                <span>
                                    <label class="col-sm-4 input-group" for="roles-role_name">项目别名(英文字母)</label>
                                </span>
                            </td>
                            <td class="hidden-phone">
                                <div class="col-sm-12 input-group">
                                    <input type="text" class="form-control" name="project_alias" style="width:300px">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span>
                                    <label class="col-sm-4 input-group" for="roles-role_name">项目路径(绝对路径)</label>
                                </span>
                            </td>
                            <td class="hidden-phone">
                                <div class="col-sm-12 input-group">
                                    <input type="text" name="path" class="form-control" style="width:300px">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <?= Html::submitButton('提交', ['class' => 'btn btn-info btn-sm']) ?>
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
</body>
</html>
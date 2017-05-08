<?php
error_reporting(E_ALL & ~E_NOTICE);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\controllers\PublicFunction;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>管理系统</title>
        <link  href="./res/css/bootstrap.min.css"  rel="stylesheet">
        <link  href="./res/css/bootstrapreset.css"  rel="stylesheet">
        <link rel="stylesheet" href="./res/css/font-awesome.min.css" />
        <link rel="stylesheet" href="./res/css/chosen.css" />
        <link  href="./res/css/pxgridsicons.min.css"  rel="stylesheet">
        <link  href="./res/css/responsive.css"  rel="stylesheet"  media="screen">
        <link  href="./res/css/animation.css"  rel="stylesheet">
        <link  href="./res/css/validform.css"  rel="stylesheet">
        <link  href="./res/css/style.css"  rel="stylesheet">
        <script type="text/javascript" src="./res/js/jquery.min.js"></script>
        <script src="./res/js/chosen.jquery.js" type="text/javascript"></script>
        <script type="text/javascript" src="./res/js/extension.js"></script>
        <script type="text/javascript" src="./res/js/common.js"></script>
        <link  rel="stylesheet"  href="./res/css/ui-dialog.css">
        <script  src="./res/js/dialog-plus.js"></script>

    </head>

    <body>


        <section  class="wrapper">
            <div  class="row">
                <div  class="col-lg-12" >
                    <section  class="panel" >
                        <div  class="panel-body"  id="panel-bodys">
                            <table  class="table table-striped table-advance table-hover"  id="contenttable">
                                <tbody>
                                    <?php
                                    $form = ActiveForm::begin([
                                                'id' => "article-form",
                                                'enableAjaxValidation' => false,
                                                'options' => ['enctype' => 'multipart/form-data'],
                                                'action' => '/index.php?r=user/index',
                                                'fieldConfig' => [  //统一修改字段的模板
                                                    'template' => '<tr><td  style="width: 150px;"><span>{label}</span></td><td  class="hidden-phone"><div  class="col-sm-12 input-group">{input}</div></td>{error}</tr>',
                                                    'labelOptions' => ['class' => 'col-sm-8 input-group']
                                                ],
                                    ]);
                                    ?>
                                    <?= $form->field($model2, 'role_name')->dropDownList([$arr_user[0]['roleid'] => $arr_role[0]['role_name']], ['style' => 'width:300px', 'disabled' => 'disabled'])->label('所属角色　　'); ?>
                                    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'style' => 'width:300px', 'value' => $arr_user[0]['username'], 'readonly' => 'readonly'])->label('管理员账户　') ?>
                                <input id="admin-userid" class="form-control" type="hidden" style="width:300px" value="<?php echo $arr_user[0]['userid'] ?>" name="Admin[userid]">
                                <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true, 'style' => 'width:300px', 'value' => '', 'type' => 'password'])->label('密码　　　　') ?>

                                <tr>
                                    <td  style="width: 120px;">
                                        <span></span>
                                    </td>
                                    <td  class="hidden-phone">
                                        <div  class="col-sm-8 input-group">
                                        </div>
                                    </td>
                                </tr>
                                <?= $form->field($model, 'realname')->textInput(['maxlength' => true, 'style' => 'width:300px', 'value' => $arr_user[0]['realname']])->label('真实姓名　　') ?>

                                <tr>
                                    <td colspan='2'>
                                        <div  class="contentsubmit">
                                            <?= Html::submitButton( '提交', ['class' => 'btn btn-info btn-sm']) ?>
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



    </body>
</html>



<?php
use yii\widgets\ActiveForm;
use yii\bootstrap\Html;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<?= Alert::widget() ?>
<link href="res/css/style.css" rel="stylesheet" />
<style>
    textarea{resize:none}
    section.title{
        height: 30px;
        line-height: 30px;
        font-size: 15px;
        margin: 5px 0px 5px 0px
    }
</style>
<body>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-10">
            <section class="panel">
                <div  class="panel-body"  id="panel-bodys">

                    <?php $form = ActiveForm::begin([
                        'method' => 'post',
                        'action' => ['student/update','uid' => $model->id]
                    ]);?>
                    <?= $form->field($model, 'username')->textInput()->label('用户名'); ?>

                    <div class="form-group field-user-reset-password">
                        <label class="control-label" for="user-password">设置密码</label>
                        <input type="password" id="user-password" class="form-control" name="User[password]" value="">
                        <div class="help-block"></div>
                    </div>

                    <?= $form->field($model, 'email')->textInput()->label('邮箱'); ?>
                    <?= Html::submitButton('保存修改', ['class' => 'btn btn-info pull-right']) ?>
                    <?php ActiveForm::end();?>

                </div>
            </section>
        </div>
    </div>
</section>
<script src="res/js/jquery.uploadify.min.js"></script>
<script src="res/js/ueditor/ueditor.config.js"></script>
<script src="res/js/ueditor/ueditor.all.js"></script>

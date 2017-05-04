<?php
use yii\widgets\ActiveForm;
use yii\bootstrap\Html;
use common\widgets\Alert;

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
                    <h3 style="font-weight: bold;"></h3>
                    <br>

                    <?php $form = ActiveForm::begin(['action' => ['exam/create'],
                        'class'=>['form-horizontal'],
                        'method'=>'post',
                    ]); ?>

                    <?php echo $form->field($model, 'name')->textInput(['placeholder'=>'','readonly'=>'true']); ?>
                    <?php echo $form->field($model, 'time_lock')->dropDownList(['0'=>'英译汉','1'=>'汉译英'], ['prompt'=>'请选择','style'=>'width:120px','readonly'=>'true']) ?>
                    <?php echo $form->field($model, 'full_score')->textInput(['placeholder'=>'','readonly'=>'true']); ?>
                    <?php echo $form->field($model, 'minute_time')->textInput(['placeholder'=>'','readonly'=>'true']); ?>
                    <?php echo $form->field($model, 'introduce')->textarea(['rows'=>3,'placeholder'=>'','readonly'=>'true']); ?>

                    <?php ActiveForm::end(); ?>

                </div>
            </section>
        </div>
    </div>
</section>
<script src="res/js/jquery.uploadify.min.js"></script>
<script src="res/js/ueditor/ueditor.config.js"></script>
<script src="res/js/ueditor/ueditor.all.js"></script>

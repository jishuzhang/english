<?php

use yii\widgets\ActiveForm;
use yii\bootstrap\Html;

?>
<link href="res/css/style.css" rel="stylesheet" />
<style>
    textarea{resize:none}
</style>
<body>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">

                <div  class="panel-body"  id="panel-bodys">
                    <?php $form = ActiveForm::begin(['action' => ['note/edit'],
                        'class'=>['form-horizontal'],
                        'method'=>'post',
                    ]); ?>

                    <?php echo $form->field($model, 'title')->textInput(['maxlength' => 20])->label('视频标题'); ?>

                    <?php echo $form->field($model, 'title')->textInput(['maxlength' => 200])->label('视频外链'); ?>

                    <?php echo $form->field($model, 'description')->textarea(['rows'=>3,'resize'=>'none'])->label('视频描述'); ?>

                    <?php echo $form->field($model, 'id')->hiddenInput(['value'=>3])->label(false); ?>

                    <?php echo Html::submitButton('提交', ['class'=>'btn btn-primary pull-right','name' =>'submit-button']) ?>

                    <?php ActiveForm::end(); ?>
                    </div>
            </section>
        </div>
    </div>
</section>

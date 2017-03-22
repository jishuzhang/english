<?php

use yii\widgets\ActiveForm;
use yii\bootstrap\Html;
use common\widgets\Alert;
?>
<?= Alert::widget() ?>
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
                    <?php $form = ActiveForm::begin(['action' => ['player/edit'],
                        'class'=>['form-horizontal'],
                        'method'=>'post',
                    ]); ?>

                    <?php echo $form->field($model, 'title')->textInput(['value' => $default_value['title']])->label('视频标题'); ?>

                    <?php echo $form->field($model, 'src')->textInput(['value' => $default_value['src']])->label('视频外链'); ?>

                    <?php echo $form->field($model, 'description')->textarea(['rows'=>6,'value' => $default_value['description']])->label('视频简介'); ?>

                    <?php echo $form->field($model, 'id')->hiddenInput(['value'=>$default_value['id']])->label(false); ?>

                    <?php echo Html::submitButton('提交', ['class'=>'btn btn-primary pull-right','name' =>'submit-button']) ?>

                    <?php ActiveForm::end(); ?>
                    </div>
            </section>
        </div>
    </div>
</section>

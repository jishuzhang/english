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
                    <?php $form = ActiveForm::begin(['action' => ['player/add'],
                        'class'=>['form-horizontal'],
                        'method'=>'post',
                    ]); ?>

                    <?php echo $form->field($model, 'title')->textInput(['placeholder' => '视频标题'])->label('视频标题'); ?>

                    <?php echo $form->field($model, 'src')->textInput()->label('视频外链'); ?>

                    <?php echo $form->field($model, 'description')->textarea(['rows'=>6])->label('视频简介'); ?>

                    <?php echo Html::submitButton('提交', ['class'=>'btn btn-primary pull-right','name' =>'submit-button']) ?>

                    <?php ActiveForm::end(); ?>

                </div>
            </section>
        </div>
    </div>
</section>

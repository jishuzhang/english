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
                    <h3>添加视频</h3>
                    <br>

                    <?php $form = ActiveForm::begin(['action' => ['player/create'],
                        'class'=>['form-horizontal'],
                        'method'=>'post',
                        'options' => ['enctype' => 'multipart/form-data']
                    ]); ?>

                    <?php echo $form->field($model, 'title')->textInput(['placeholder'=>'请输入标题'])->label('视频标题'); ?>

                    <?php echo $form->field($model, 'src')->textInput(['placeholder'=>'请输入视频链接'])->label('视频外链'); ?>

                    <?php echo $form->field($model, 'description')->textarea(['rows'=>6,'placeholder' => '请输入视频简介'])->label('视频简介'); ?>

                    <?php echo $form->field($model, 'poster')->fileInput()->label('请上传封面 建议长宽比例为 1.6 : 1 '); ?>

                    <?php echo Html::submitButton('提交', ['class'=>'btn btn-primary pull-right','name' =>'submit-button']) ?>

                    <?php ActiveForm::end(); ?>

                </div>
            </section>
        </div>
    </div>
</section>

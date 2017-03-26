<?php

use yii\widgets\ActiveForm;
use yii\bootstrap\Html;
use common\widgets\Alert;
?>
<?= Alert::widget() ?>
<link href="res/css/style.css" rel="stylesheet" />
<style>
    textarea{resize:none}
     .video_poster{height:100px;width:160px;border-radius:4px;}
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
                        'options' => ['enctype' => 'multipart/form-data']
                    ]); ?>

                    <?php echo $form->field($model, 'title')->textInput(['value' => $default_value['title']])->label('视频标题'); ?>

                    <?php echo $form->field($model, 'src')->textInput(['value' => $default_value['src']])->label('视频外链'); ?>

                    <?php echo $form->field($model, 'description')->textarea(['rows'=>6,'value' => $default_value['description']])->label('视频简介'); ?>

                    <?php echo $form->field($model, 'id')->hiddenInput(['value'=>$default_value['id']])->label(false); ?>

                    <?php echo $form->field($model, 'old')->hiddenInput(['value'=>$default_value['poster']])->label(false); ?>

                    <div class="form-group">
                        <img class="video_poster" src="<?=Yii::$app->params['frontend_url'].$default_value['poster']?>" alt="视频封面">
                    </div>

                    <?php echo $form->field($model, 'poster')->fileInput()->label('如果您想更新封面 请重新上传封面 建议长宽比例为 1.6 : 1 '); ?>

                    <?php echo Html::submitButton('提交', ['class'=>'btn btn-primary pull-right','name' =>'submit-button']) ?>

                    <?php ActiveForm::end(); ?>
                    </div>
            </section>
        </div>
    </div>
</section>

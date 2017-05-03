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

                    <?php echo $form->field($model, 'name')->textInput(['placeholder'=>'']); ?>
                    <?php echo $form->field($model, 'time_lock')->dropDownList(['0'=>'英译汉','1'=>'汉译英'], ['prompt'=>'请选择','style'=>'width:120px']) ?>
                    <?php echo $form->field($model, 'full_score')->textInput(['placeholder'=>'']); ?>
                    <?php echo $form->field($model, 'minute_time')->textInput(['placeholder'=>'']); ?>
                    <?php echo $form->field($model, 'introduce')->textarea(['rows'=>3,'placeholder'=>'']); ?>


                    <?php echo Html::submitButton('提交', ['class'=>'btn btn-primary pull-right','name' =>'submit-button']) ?>

                    <?php ActiveForm::end(); ?>

                    <?php if(!empty($isNew)):?>
                        <button class="btn btn-primary">添加试题</button>
                    <?php endif;?>
                </div>
            </section>
        </div>
    </div>
</section>
<script src="res/js/jquery.uploadify.min.js"></script>
<script src="res/js/ueditor/ueditor.config.js"></script>
<script src="res/js/ueditor/ueditor.all.js"></script>
<script>
    /**
     * 显示editor 编辑器同时进行赋值
     * @author su
     */
    var cn = UE.getEditor('chinese', {
        initialFrameHeight: 250,
        toolbars:[['FullScreen', 'Source', 'Undo', 'Redo','bold','test']]
    });

    var en = UE.getEditor('english', {
        initialFrameHeight: 250,
        toolbars:[['FullScreen', 'Source', 'Undo', 'Redo','bold','test']]
    });

    $('.score_editor').click(function(){

        //UE.getEditor('detail').setContent(content);
    });

</script>
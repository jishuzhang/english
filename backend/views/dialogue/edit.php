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
                    <h3 style="font-weight: bold;">编辑台词</h3>
                    <br>

                    <?php $form = ActiveForm::begin(['action' => ['dialogue/edit'],
                        'class'=>['form-horizontal'],
                        'method'=>'post',
                    ]); ?>

                    <section class="title">请输入要关联的视频ID</section>
                    <?php echo $form->field($model, 'vid')->textInput(['value'=>$default_value['vid']])->label(false); ?>
                    <?php echo $form->field($model, 'tid')->hiddenInput(['value'=>$default_value['tid']])->label(false); ?>

                    <section class="title">请输入英文台词 <span style="color:red;">(温馨提醒:请对需要加批注的单词或者短语进行加粗处理)</span> </section>

                    <script id="english" name="DialogueForm[english]" type="text/plain"></script>

                    <section class="title">请输入汉语译文</section>

                    <script id="chinese" name="DialogueForm[chinese]" type="text/plain"></script>

                    <br/>
                    <?php echo Html::submitButton('提交', ['class'=>'btn btn-primary pull-right','name' =>'submit-button']) ?>

                    <?php ActiveForm::end(); ?>

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




    cn.addListener("ready", function () {
        // editor准备好之后才可以使用
        cn.setContent('<?php echo $default_value['zn_content']?>');

    });

    en.addListener("ready", function () {
        // editor准备好之后才可以使用
        en.setContent('<?php echo $default_value['en_content']?>');
    });
</script>
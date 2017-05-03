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

                    <?php $form = ActiveForm::begin(['action' => ['exam/update','id' =>$model->id],
                        'class'=>['form-horizontal'],
                        'method'=>'post',
                    ]); ?>

                    <?php echo $form->field($model, 'name')->textInput(['placeholder'=>''])->label('试卷名称'); ?>
                    <?php echo $form->field($model, 'time_lock')->dropDownList(['0'=>'英译汉','1'=>'汉译英'], ['prompt'=>'请选择','style'=>'width:120px'])->label('试卷类型'); ?>
                    <?php echo $form->field($model, 'full_score')->textInput(['placeholder'=>''])->label('试卷总分');; ?>
                    <?php echo $form->field($model, 'minute_time')->textInput(['placeholder'=>''])->label('考试时间,若无时间限制 该选项请留空');; ?>
                    <?php echo $form->field($model, 'introduce')->textarea(['rows'=>3,'placeholder'=>''])->label('试卷介绍');; ?>


                    <?php echo Html::submitButton('更新', ['class'=>'btn btn-primary pull-right','name' =>'submit-button']) ?>

                    <?php ActiveForm::end(); ?>

                    <?php if(empty($model->status)):?>
                        <button class="btn btn-primary" id="add_question">添加试题</button>
                    <?php endif;?>

                    <table class="table" style="margin-top:20px;">
                        <tr>
                            <td >题目编号</td>
                            <td >题目名称</td>
                            <td >题目答案</td>
                            <td >题目分值</td>
                        </tr>
                        <?php if(!empty($question)):?>

                            <?php foreach($question as $q):?>
                                <tr>
                                    <td><?=$q->q_number?></td>
                                    <td><?=$q->q_name?></td>
                                    <td><?=$q->q_answer?></td>
                                    <td><?=$q->q_score?></td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>

                    </table>
                </div>
            </section>
        </div>
    </div>
</section>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">添加试题</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'form-order',
                    'method' => 'post',
                    'action' =>['exam/add-question']
                ]); ?>
                <input type="hidden" name="tid" value="<?php echo Yii::$app->request->get('id');?>">
                <input type="hidden" name="number" value="<?php echo $next_number+1;?>">
                <div >
                    <label class="control-label" for="loginform-username">题目</label>
                    <input name="name" placeholder="题目"  type="text" class="form-control"  autofocus="" value="">
                </div>

                <div >
                    <label class="control-label" for="loginform-username">答案</label>
                    <input name="answer" placeholder="答案" type="text" class="form-control" autofocus="">
                </div>

                <div >
                    <label class="control-label" for="loginform-username">分值</label>
                    <input name="score" placeholder="分值" type="text" class="form-control" autofocus="">
                </div>

                <?php ActiveForm::end();?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary shutDown" data-dismiss="modal">添加</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script src="res/js/bootstrap.min.js"></script>
<script src="res/js/jquery.uploadify.min.js"></script>
<script src="res/js/ueditor/ueditor.config.js"></script>
<script src="res/js/ueditor/ueditor.all.js"></script>
<script>

    $('#add_question').click(function(){
        $('#myModal').modal('show');
    });

    $('.shutDown').click(function () {

        $('#form-order').submit();
    })
</script>
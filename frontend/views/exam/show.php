<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
AppAsset::addCss($this,'css/exam.css');
AppAsset::addScript($this,'js/common.js');
AppAsset::addScript($this,'js/bootstrap.min.js');
$viewJs =<<<JS

    // 提交
    $('#exam-submit').click(function(){

        $('#myModal .modal-footer').show();
        $('.modal-body').html('<p>确定提交答卷?</p>');
        $('#myModal').modal('show');
    });

    // 检查
    $('#exam-inspect').click(function(){

        var unAnswer = new Array();
        var inspectBeforeSubmit = '';

        $('.modal-body').html('<p style="color:red;">您还有以下题目未完成</p><div class="row" id="un_question_list"></div>');
        $('#exam-form input').each(function(i){
            if(!$('#exam-form input').eq(i).val())
            {
                // mark unanswer question
                unAnswer.push($('#exam-form input').eq(i).attr('data-qnum'));
            };

        });

        if(unAnswer.length !== 0)
        {
            for(var i in unAnswer)
            {
                inspectBeforeSubmit += '<div class="col-sm-2"><section class="un_answer_box btn-warning">'+unAnswer[i]+'</section></div>';
            }
            $('#un_question_list').html(inspectBeforeSubmit);
            $('#myModal .modal-footer').hide();
            $('#myModal').modal('show');
        }

    });



JS;
$this->registerJs($viewJs,\yii\web\View::POS_END);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        #exam-form input{
            border:0px;
            border-bottom:1px solid #cccccc;
            border-radius: 0;
            outline: none;
        }
        #myModal{
            margin-top:10%;
        }
        .un_answer_box{
            height: 30px;
            line-height: 30px;
            width:60%;
            text-align: center;
            border-radius: 3px;
            margin-top:5px;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <nav id="w0" class="navbar-inverse navbar-fixed-top navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">设计模式</a>
            </div>
            <div id="w0-collapse" class="collapse navbar-collapse">
                <ul id="w1" class="navbar-nav navbar-right nav">
                    <li><a href="javascript:void(0);" id="exam-inspect">检查考卷</a></li>
                    <li><a href="javascript:void(0);" id="exam-submit">交卷</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row text-center">
            <h3>设计模式</h3>
        </div>
        <div class="row text-left">
            <p>在 HTML5 中可以放心使用  和  标签。 用于高亮单词或短语，不带有任何着重的意味；而 标签主要用于发言、技术词汇等。</p>
        </div>
        <div class="row">
            <h4>英汉互译</h4>
        </div>
        <div class="row">
            <div class="col-lg-10">
                <?php \yii\widgets\ActiveForm::begin([
                    'id' => 'exam-form',
                    'action' => ['exam/mark-paper']
                ]);?>

                <?php foreach($question as $q):?>
                    <div class="form-group field-contactform-name">
                        <label class="control-label exam-question-name" for="qid_<?=$q['id']?>">
                            <b><i><?=$q['q_number']?></i>.&nbsp;&nbsp;&nbsp;&nbsp;</b>
                            <span>&nbsp;<?=$q['q_name']?></span>
                            <span>(<?=$q['q_score']?> 分)</span>
                        </label>
                        <input type="text"
                               id="qid_<?=$q['id']?>"
                               data-qnum="<?=$q['q_number']?>"
                               class="form-control"
                               name="exam[qid_<?=$q['id']?>]"
                               value="thank you"
                        >

                        <p class="help-block help-block-error"></p>
                    </div>
                <?php endforeach;?>

                <?php \yii\widgets\ActiveForm::end();?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">温馨提醒</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary shutDown" onclick="$('#exam-form').submit();" data-dismiss="modal">提交</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Sunshine <?= date('Y') ?></p>

        <p class="pull-right">
            技术支持
            <a href="http://www.passport.bailitop.com/" rel="external">MachineGunSu</a>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

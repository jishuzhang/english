<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use backend\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\models\Nodes;
use backend\models\Evaluate;
use common\models\LoginForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

?>
    <link href="res/css/bootstrap.min.css" rel="stylesheet" />
    <link href="res/css/bootstrapreset.css" rel="stylesheet" />
    <link href="res/css/pxgridsicons.min.css" rel="stylesheet" />
    <link href="res/css/style.css" rel="stylesheet" />
    <link href="res/css/responsive.css" rel="stylesheet" media="screen"/>
    <link href="res/css/animation.css" rel="stylesheet" />

<div class="form-signin" id="form_login" >
    <div class="form-signin-heading"></div>
    <div class="login-wrap">
        <div class="loginlogo center"><img src="res/images/login_logo.png" style="height: 58px; width: 218px;"></div>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => '<div class="form-group">{input}{error}</div>',
            ],
        ]); ?>

                <?= $form->field($model, 'username',[
                    'template'=>'<div class="input-group"><div class="input-group-addon"><i class="icon-user"></i></div>{input}</div>',
                    'labelOptions' => ['label' => '用户名']])->textInput(['placeholder' => '用户名']) ?>



                <?= $form->field($model, 'password',[
                    'template'=>'<div class="input-group"><div class="input-group-addon"><i class="icon-key5"></i></div>{input}</div>{error}',
                    'labelOptions' => ['label' => '密  码']])->passwordInput(['placeholder' => '密码']) ?>


        <?php $this->beginPage() ?>
        <?php $this->beginBody() ?>

        <?= $form->field($model,'verifyCode',['labelOptions' => ['label' => '验证码']])->widget(Captcha::className(),[
            'template'=>'<div class="input-group" id="codeid_error"><div class="input-group-addon"><i class="icon-qrcode"></i></div>
                        <div  class="form-control">{input}</div><div class="input-group-addon" id="logincode">{image}</div></div>',
            'imageOptions'=>['alt'=>'验证码','title'=>'换一个'],'captchaAction'=>'site/captcha'
        ])?>
        <?php $this->endBody() ?>
        <?php $this->endPage() ?>

        <?= Html::submitButton('login', ['class' => 'btn btn-shadow btn-danger btn-block btn-login', 'name' => 'login-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="form-signin-bottom center">Copyright &copy; 2004-2016 Bailitop Education. All Right Reserved</div>
</div>

<script src="res/js/bootstrap.min.js"></script>
<script src="res/js/focuse.js"></script>
<script type="text/javascript">

    function checkform() {
        $('#username_error').removeClass('validate-has-error');
        $('#password_error').removeClass('validate-has-error');
        $('#codeid_error').removeClass('validate-has-error');
        if($('#username').val()=='') {
            addclass_slide('username','username_error','validate-has-error');
            $('#username').focus();
            return false;
        }
        if($('#password').val()=='') {
            addclass_slide('password','password_error','validate-has-error');
            $('#password').focus();
            return false;
        }
        if($('#codeid').val()=='') {
            addclass_slide('codeid','codeid_error','validate-has-error');
            $('#codeid').focus();
            return false;
        }
    }

    $(function(){
        if(top.location.href != self.location.href){
            $('#form_login').attr('target','top');
        }
    });
</script>


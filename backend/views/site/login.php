<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="res/css/font-awesome.min.css" />
<link rel="stylesheet" href="res/css/chosen.css" />
<link rel="stylesheet" type="text/css" href="res/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="res/css/bootstrapreset.css" />
<link  href="res/css/index_Returncode.css"  rel="stylesheet">
<style>
    body { overflow-y: hidden; }
    .login { left:50%; margin-left: -300px;top: 50%; margin-top: -210px;}

</style>
<div class="main">
    <img src="res/images/start.png">
    <div class="login" >
        <p class="h3">接口管理系统</p>
        <p class="h5">Interface management system</p>
        <fieldset>
            <div class="form">
                <?php $form = ActiveForm::begin(['id' => 'login-form',
                    'fieldConfig' => [
                        'template' => '{input}{error}',
                    ],
                ]); ?>
                <div class="form-group field-loginform-username required">
                    <div class="input-group denglu">
                        <div class="input-group-addon">
                            用户名
                        </div>
                        <?= $form->field($model,'username')->textInput(['placeholder' => '请输入用户名','class'=>'form-control'])?>
                    </div>
                </div>
                <div class="form-group field-loginform-username required">
                    <div class="input-group denglu" style="width:100%">
                        <div class="input-group-addon">
                            密码
                        </div>
                        <?= $form->field($model, 'password')->passwordInput(['placeholder' => '请输入密码','class'=>'form-control'])?>
                    </div>
                </div>
                <div>
                    <?php $this->beginPage() ?>
                    <?php $this->beginBody() ?>
                    <div class="form-group denglu">
                        <div id="codeid_error" class="input-group">
                            <div class="input-group-addon"> 验证码 </div>
                            <?= $form->field($model,'verifyCode',['labelOptions' => ['label' => '验证码']])->widget(Captcha::className(),[
                                'class'=>'form-control',
                                'template'=>'{input}<div class="input-group-addon" id="logincode" style="height: 34px;padding: 0px;">{image}</div>',
                                'imageOptions'=>['alt'=>'验证码','title'=>'换一个'],'captchaAction'=>'site/captcha'
                            ])?>
                        </div>
                    </div><br>
                    <?php $this->endBody() ?>
                    <?php $this->endPage() ?>
                <!-- Change this to a button or input when using this as a form -->
                <?= Html::submitButton('登录', ['class' => 'btn-danger btn-block btn-login', 'name' => 'login-button']) ?>
                <?= Html::resetButton('重置', ['class' => 'btn  btn-info', 'name' => 'reset-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </fieldset>
    </div>
</div>

<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;
?>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="container ">
    <section style="height:70px;">
        <div class="row" style="height:70px;">
            <div class="col-lg-2 col-lg-offset-1 top_logo ">
                <a href="<?=Yii::$app->homeUrl?>">
                    <!--                        <img src="images/common/logo.png" alt="logo">-->
                    <h2 style="font-weight: bold;color:#FF8A20;">阳光课堂</h2>
                </a>
            </div>
            <div class="col-lg-8"></div>
        </div>
    </section>
</div>
<div class="container-fluid signup_bg">
    <div class="row">
        <div class="col-lg-3 col-lg-offset-7" id="site-user-form" >

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username') ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('立即注册', ['class' => 'btn btn-self-define', 'name' => 'signup-button']) ?>
            </div>

            <div style="color:#999;margin:1em 0" class="pull-right">
                <?= Html::a('已有账号 立即登录 ?', ['site/login']) ?>
            </div>

        </div>
    </div>
</div>

<footer class="footer" style="border-top:1px solid #B6B4B6;padding-top:20px;">
    <div class="container" >
        <p class="pull-left">&copy; Sunshine <?= date('Y') ?></p>

        <p class="pull-right">
            Powered by
            <a href="http://www.passport.bailitop.com/" rel="external">programmer mood</a>
        </p>
    </div>
</footer>

</body>

</html>

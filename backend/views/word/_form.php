<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Words */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="words-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tid')->textInput()->label('台词文本ID') ?>

    <?= $form->field($model, 'word')->textInput(['maxlength' => true])->label('单词') ?>

    <?= $form->field($model, 'explain')->textInput(['maxlength' => true])->label('单词注释') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添 加' : '更 新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

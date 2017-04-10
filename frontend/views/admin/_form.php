<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Words */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="words-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tid')->textInput() ?>

    <?= $form->field($model, 'word')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'explain')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ctime')->textInput() ?>

    <?= $form->field($model, 'mtime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

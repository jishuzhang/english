<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\controllers\PublicFunction;

/* @var $this yii\web\View */
/* @var $model backend\models\Nodes */
/* @var $form yii\widgets\ActiveForm */
$PublicFunction = new PublicFunction();

$id = isset($id) ? $id : '';

?>

<div class="nodes-form" style="margin-top:10px;">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title', ['labelOptions' => ['class' => 'col-sm-1']])->textInput(['maxlength' => true,'style'=>'width:300px']) ?>
    
    <?php if($datas){ 
         echo $PublicFunction->getFloorView($datas, $model, 'nodeid', 'title', 'pid', 'Nodes', 'nodes', '上级菜单', '≡顶级菜单≡', 'pid', $id);
     }else{
         echo $form->field($model, 'pid', ['labelOptions' => ['class' => 'col-sm-1']])->dropDownList(['0' => '顶级属性'], ['style'=>'width:300px']);
     } ?>
    
    <?= $form->field($model, 'm', ['labelOptions' => ['class' => 'col-sm-1']])->textInput(['maxlength' => true,'style'=>'width:300px']) ?>
    
    <?= $form->field($model, 'c', ['labelOptions' => ['class' => 'col-sm-1']])->textInput(['maxlength' => true,'style'=>'width:300px']) ?>

    <?= $form->field($model, 'a', ['labelOptions' => ['class' => 'col-sm-1']])->textInput(['maxlength' => true,'style'=>'width:300px']) ?>

    <?= $form->field($model, 'data', ['labelOptions' => ['class' => 'col-sm-1']])->textInput(['maxlength' => true,'style'=>'width:300px']) ?>

    <?= $form->field($model, 'display', ['labelOptions' => ['class' => 'col-sm-1']])->radioList(['1'=>'是','0'=>'否']) ?>

    <?= $form->field($model, 'img_icon', ['labelOptions' => ['class' => 'col-sm-1']])->textInput(['maxlength' => true,'style'=>'width:300px']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '修改', ['class' => 'btn btn-info mybtn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

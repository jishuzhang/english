<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Words */

$this->title = '添加单词';
$this->params['breadcrumbs'][] = ['label' => '单词', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="words-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

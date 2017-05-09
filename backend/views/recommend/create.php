<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Recommend */

$this->title = 'Create Recommend';
$this->params['breadcrumbs'][] = ['label' => 'Recommends', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommend-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

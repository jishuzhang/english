<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '单词列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="words-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('添加单词', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'wid',
            'tid',
            'word',
            'explain',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

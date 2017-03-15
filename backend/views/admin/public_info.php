<?php
/**
 * 个人设置
 *
 * @author mengbaoqing
 */
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = "个人设置";
$this->params['breadcrumbs'][] = ['label' => 'Nodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$username = Yii::$app->user->identity->username;
$id = Yii::$app->user->identity->id;
$role_id = Yii::$app->user->identity->role;
?>
<div class="nodes-view">

    <p>
        <?= Html::a('修改个人信息', ['admin_edit', 'id' => $id, 'role_id'=> $role_id], ['class' => 'btn btn-info']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email',
            'role',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>

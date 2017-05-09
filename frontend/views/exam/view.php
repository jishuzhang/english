<?php
use yii\widgets\ActiveForm;
use yii\bootstrap\Html;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '个人中心';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Alert::widget() ?>

    <div class="row">
        <div class="col-lg-10">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>试卷名称</th>
                            <th>满分</th>
                            <th>实际得分</th>
                            <th>试卷状态</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach($model as $evModel):?>
                            <tr>
                                <td><?php echo $test[$evModel['tid']]['name']?></td>
                                <td><?php echo $test[$evModel['tid']]['full_score']?></td>
                                <td><?php echo $evModel['score']?></td>
                                <td><?php echo $test[$evModel['tid']]['status'] == 1 ? '<span style="color:green">正在使用</span>' : '<span style="color:red">已经关闭</span>';?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>

                </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="pull-right">
                    <?= LinkPager::widget(['pagination' => $pages]); ?>
                </div>
            </div>
        </div>

    </div>


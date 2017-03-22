<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/2
 * Time: 15:36
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\web\View;
use common\widgets\Alert;

$viewJs =<<<JS

    // select all 、cancel select all
    document.getElementById('check-all').onclick = function (){

        var videoInputs = document.getElementsByClassName('video-ids');
        var selStatus = this.checked;

        for(var i in videoInputs){
           videoInputs[i].checked = selStatus;
        }
    };
JS;

$this->registerJs($viewJs,View::POS_END);

?>
<?= Alert::widget() ?>

<link href="res/css/bootstrapreset.css" rel="stylesheet" />
<link href="res/css/style.css" rel="stylesheet" />

<style type="text/css">
    .table th, .table td {
        text-align: center;
        height:38px;
    }

</style>


<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <?= Html::a('<i class="icon-plus btn-icon"></i>添加视频', ['player/create'], ['class' =>'btn btn-info']) ?>
                </header>
                <?php $form = ActiveForm::begin()?>


                <div class="panel-body" id="panel-bodys">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th style="width: 200px;">视频标题</th>
                                <th >视频描述</th>
                                <th style="width: 150px;">更新时间</th>
                                <th style="width: 300px;">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($model)): ?>
                            <?php foreach ($model as $evModel):?>
                                <tr>
                                    <td><?=$evModel['title']?></td>
                                    <td><?= mb_substr($evModel['description'],0,30,'utf-8')?>...</td>
                                    <td><?= date('Y-m-d H:i',$evModel['ctime'])?></td>
                                    <td>
                                        <a title="编辑" href="<?php echo Url::toRoute(['player/edit','id'=>$evModel->id])?>"  class="btn btn-primary btn-xs">编辑</a>
                                        <a title="删除" href="<?php echo Url::toRoute(['player/delete','id'=>$evModel->id])?>"  class="btn btn-primary btn-xs">删除</a>
                                    </td>

                                </tr>
                            <?php endforeach;?>
                        <?php else:?>
                            <tr>
                                <td colspan="7">您还没有添加视频</td>
                            </tr>
                        <?php endif;?>

                        </tbody>
                    </table>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pull-left" style="display:none;">
                                <?= Html::submitButton( '排序', ['class' => 'btn btn-info btn-sm','onclick'=>'javascript:this.form.action="'.Url::to([Yii::$app->controller->id.'/sort']).'";'])?>
                                <?= Html::submitButton( '批量删除', ['class' => 'btn btn-info btn-sm','onclick'=>'javascript:this.form.action="'.Url::to([Yii::$app->controller->id.'/remove']).'";'])?>
                            </div>
                            <div class="pull-right">
                                <?= LinkPager::widget(['pagination' => $pages]); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </section>
        </div>
    </div>
</section>


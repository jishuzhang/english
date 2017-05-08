<?php
use yii\widgets\ActiveForm;
use yii\bootstrap\Html;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<?= Alert::widget() ?>
<link href="res/css/style.css" rel="stylesheet" />
<style>
    textarea{resize:none}
    section.title{
        height: 30px;
        line-height: 30px;
        font-size: 15px;
        margin: 5px 0px 5px 0px
    }
</style>
<body>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-10">
            <section class="panel">
                <div  class="panel-body"  id="panel-bodys">
                    <h5><span style="color:red;font-weight:bold;">学生姓名:</span> <?=$user->username?></h5>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>试卷名称</th>
                            <th>满分</th>
                            <th>实际得分</th>
                            <th>试卷状态</th>
                            <th>相关操作</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach($model as $evModel):?>
                            <tr>
                                <td><?php echo $test[$evModel['tid']]['name']?></td>
                                <td><?php echo $test[$evModel['tid']]['full_score']?></td>
                                <td><?php echo $evModel['score']?></td>
                                <td><?php echo $test[$evModel['tid']]['status'] == 1 ? '<span style="color:green">正在使用</span>' : '<span style="color:red">已经关闭</span>';?></td>
                                <td>
                                    <a href="<?php echo Url::toRoute(['student/update','uid'=>$evModel['uid']])?>" title="编辑" class="btn btn-info btn-xs">编辑</a>
                                    <a href="<?php echo Url::toRoute(['student/view','uid'=>$evModel['id']])?>" title="查看成绩" class="btn btn-info btn-xs">查看成绩</a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>

                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pull-right">
                                <?= LinkPager::widget(['pagination' => $pages]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<script src="res/js/jquery.uploadify.min.js"></script>
<script src="res/js/ueditor/ueditor.config.js"></script>
<script src="res/js/ueditor/ueditor.all.js"></script>

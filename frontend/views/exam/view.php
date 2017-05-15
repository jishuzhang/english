<?php
use frontend\assets\AppAsset;
use yii\bootstrap\Html;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

$this->title = '个人中心';
$this->params['breadcrumbs'][] = $this->title;

AppAsset::addCss($this,'/css/fileinput.min.css');
AppAsset::addScript($this,'/js/fileinput.min.js');

$viewJs =<<<JS
    //$("#input-id").fileinput();
    alert(111);
JS;
$this->registerJs($viewJs,View::POS_END);
?>
<?= Alert::widget() ?>

    <div class="row">

        <div class="col-lg-2">
            <section>
                <img src="/images/avatar.png" class="img-circle center-block" id="edit_personal_info">
                <p></p>
                <section id="edit_personal_info" class="btn btn-default center-block"><a href="<?php echo Url::to(['site/edit'])?>">编辑个人信息</a></section>
                <p></p>
                <p>用户名 : <?=$user->username?></p>
                <p>email : <?=$user->email?></p>
                <p>注册时间 : <?=date('Y-m-d',$user->created_at)?></p>
            </section>

        </div>
        <div class="col-lg-9 col-lg-offset-1">
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


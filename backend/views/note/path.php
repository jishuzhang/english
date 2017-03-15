<!DOCTYPE html>
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

?>
<title>百利天下教育管理系统</title>
<link href="res/css/bootstrap.min.css" rel="stylesheet" />
<link href="res/css/bootstrapreset.css" rel="stylesheet" />
<link href="res/css/pxgridsicons.min.css" rel="stylesheet" />
<link href="res/css/style.css" rel="stylesheet" />
<link href="res/css/responsive.css" rel="stylesheet" media="screen"/>
<script  src="/res/js/jquery-2.0.3.min.js"></script>

<style type="text/css">
    .table>tbody>tr>td{
        padding: 10px 13px;
    }
    .table>thead>tr>th {
        padding: 10px 10px;
    }
    .panel-heading .type-input {
        border: 1px solid #eaeaea;
        border-radius: 4px 0 0 4px;
        box-shadow: none;
        color: #797979;
        float: left;
        height: 35px;
        padding: 0 10px;
        transition: all 0.3s ease 0s;
        width: 80px;
        appearance:none;
        /*-moz-appearance:none;*/
        /*-webkit-appearance:none;*/
    }
    .panel-heading .sr-input {
        border-radius: 0;
    }
    .survey{
        padding: 3px;
        margin: 0 2px;
        border: 1px solid #a9a9a9;
    }
</style>
<body>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <?= Html::a('<i class="icon-plus btn-icon"></i>添加目录', ['note/add'], ['class' =>'btn btn-info']) ?>
                </header>
                <?php $form = ActiveForm::begin()?>


                <div class="panel-body" id="panel-bodys">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th style="width: 50px;"></th>
                            <th>ID</th>
                            <th>项目别名</th>
                            <th>项目路径</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($execList)): ?>
                            <?php foreach ($execList as $evMethod):?>
                                <tr>
                                    <td><input type="checkbox" name="ids[]" value="<?=$evMethod['id']?>"></td>
                                    <td><?=$evMethod['id']?></td>
                                    <td><?=$evMethod['project_alias']?></td>
                                    <td><?=$evMethod['path']?></td>
                                    <td>
                                        <a class="btn btn-primary btn-xs" href="/index.php?r=note/edit&id=<?= $evMethod['id'] ?>">编辑</a>
                                        <a class="btn btn-danger btn-xs" href="javascript:makedo('/index.php?r=country/delete&id=<?= $evMethod['id'] ?>', '确认删除该记录？')">删除</a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        <?php else:?>
                            <tr>
                                <td colspan="7">没有搜索结果</td>
                            </tr>
                        <?php endif;?>

                        </tbody>
                    </table>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pull-left">
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
</body>

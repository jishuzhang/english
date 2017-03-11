<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
?>
<style>
    /*白钰加的设置中菜单input样式*/
    .Menu_input{
        height: 30px;
        width: 30px;
        text-align: center;
        line-height: 30px;
        -moz-box-shadow: none;
        -webkit-box-shadow: none;
        box-shadow: none
    }
</style>
<div class="wrapper">
    <div class="top_nav">
        <a href="<?=Url::to(['menu/index'])?>" class="btn btn-info">菜单管理</a>
        <a href="<?=Url::to(['menu/create'])?>" class="btn btn-default">菜单添加</a>
    </div>
    <?php $form=ActiveForm::begin(['method'=>'post','action'=>['menu/sort']])?>
    <div class="cont_body">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
<!--                    <th class="tablehead">选择</th>-->
                    <th class="tablehead">排序</th>
                    <th class="tablehead">ID</th>
                    <th class="tablehead">菜单名称</th>
                    <th class="tablehead">上级菜单</th>
                    <th class="tablehead">控制器</th>
                    <th class="tablehead">方法</th>
                    <th class="tablehead">是否显示</th>
                    <th class="tablehead">层级</th>
                    <th class="tablehead">操作</th>
                </tr>
                </thead>

                <tbody>
                        <?php if(!empty($list)){
                        foreach($list as $key=>$value): ?>
                            <tr>
            <!--                    <td class="center"><input type="checkbox" name="ids[]" value="5"></td>-->
                                <td><input value="<?= $value['sort']?>" class="Menu_input" name="sort[<?=$value['nodes_id']?>]"></td>
                                <td><?= $value['nodes_id']?></td>
                                <?php if(isset($value['path'])){ $num = substr_count($value['path'], '-');?>
                                <td style="text-align: left;"><a href="<?=Url::to([Yii::$app->requestedRoute,'id'=>$value['nodes_id']])?>"> <?php echo str_repeat('--/',$num); ?><?= $value['title']?></a></td>
                                <td><?= $value['pid']?></td>
                                <td><?= $value['controller']?></td>
                                <td><?= $value['action']?></td>
                                <td><?= $value['display'] ==1? '是':'否'?></td>
                                <td><?= $value['floor']?></td>
                                <td><a href="<?= Url::to(['menu/create','id'=>$value['nodes_id']])?>" class="btn <?php echo $css = $num !== 0 ? 'btn-info':'btn-warning' ?> btn-xs">添加子菜单</a> <a  href="<?= Url::to(['menu/update','id'=>$value['nodes_id']])?>" class="btn btn-primary btn-xs">编辑</a> <a onclick="return confirm('是否确认删除？');" href="<?= Url::to(['menu/delete','id'=>$value['nodes_id']])?>" class="btn btn-danger btn-xs">删除</a></td>
                                <?php } ?>
                            </tr>
                      <?php  endforeach;  }else{ ?>
                        <td colspan="9"><a href="<?= Url::to(['menu/create','id'=>Yii::$app->request->get('id')])?>" class="btn btn-info">添加子菜单</a></td>
                <?php }?>
                </tbody>
            </table>
    </div>
    <div class="logdi">
        <?php if(!empty($list)){?>
        <button class="btn btn-primary" type="submit" style="margin-left: 2%;">排序</button>
        <?php }?>
        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
    <?php ActiveForm::end();?>
</div>




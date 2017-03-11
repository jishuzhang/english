<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<div class="wrapper">
    <div class="top_nav">
        <div class="btn btn-info"><a href="<?=Url::to(['roles/index'])?>">角色管理</a></div>
        <div class="btn btn-default"><a href="<?=Url::to(['roles/create'])?>">添加角色</a></div>
    </div>
    <div class="roleWrap"><br>
        <table class="table table-striped table-advance table-hover" >
            <thead>
            <tr>
                <th class="tablehead" style="width: 10%;">角色ID</th>
                <th class="tablehead" style="width: 15%;">角色名称</th>
                <th class="tablehead" style="width: 25%;">描述</th>
                <th class="tablehead" style="width: 10%;">创建时间</th>
                <th class="tablehead" style="width: 40%;">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($list as $v){
                ?>
                <tr>
                    <td><?php echo $v['roles_id']?></td>
                    <td><?php echo $v['role']?></td>
                    <td><?php echo $v['description']?></td>
                    <td><?php echo date('Y-m-d h:i:s',$v['create_time'])?></td>
                    <td>
                        <span><a href="<?=Url::to(['roles/role_set','id'=>$v['roles_id']])?>" class="btn_01">权限设置</a></span>
                        <span><a href="<?=Url::to(['roles/update','id'=>$v['roles_id']])?>" class="btn_02">编辑</a></span>
                        <span><a href="javascript:makedo('/index.php?r=roles/delete&id=<?= $v['roles_id'] ?>', '确认删除该记录？')" class="btn_03">删除</a></span>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="panel-body">
        <?= linkPager::widget(['pagination'=>$pagination]) ?>
    </div>
</div>
<script>
    function makedo(url,message) {
        if(confirm(message)) location.href = url;
    }
</script>
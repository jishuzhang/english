<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<div class="wrapper">
    <div class="top_nav">
        <div class="btn btn-info"><a href="<?=Url::to(['admin/index'])?>">用户管理</a></div>
        <div class="btn btn-default"><a href="<?=Url::to(['admin/create'])?>">增加新用户</a></div>
    </div>
    <div class="cont_body">
        <table class="table table-striped table-advance table-hover tab" >
            <thead>
            <tr>
                <th class="tablehead" style="width:10%;">用户ID</th>
                <th class="tablehead" style="width:10%">登录名</th>
                <th class="tablehead" style="width:10%">用户名</th>
                <th class="tablehead" style="width:15%">所属角色</th>
                <th class="tablehead" style="width:10%">邮箱</th>
                <th class="tablehead" style="width:10%">电话</th>
                <th class="tablehead" style="width:10%">通知方式</th>
                <th class="tablehead" style="width:10%">创建时间</th>
                <th class="tablehead" style="width:15%">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($list as $v){
                ?>
                <tr>
                    <td><?php echo $v['users_id']?></td>
                    <td><?php echo $v['username']?></td>
                    <td><?php echo $v['realname']?></td>
                    <td><?php echo $v['role']?></td>
                    <td><?php echo $v['email']?></td>
                    <td><?php echo $v['mobile']?></td>
                    <td><?php if($v['notification']==0){echo "不通知";
                        }elseif($v['notification']==1){echo "短信通知";
                        }elseif($v['notification']==2){echo "邮箱通知";
                        }else{echo "短信/邮箱通知";}?></td>
                    <td><?php echo date('Y-m-d h:i:s',$v['createtime'])?></td>
                    <td>
                        <a class="btn btn-info btn-xs" href="<?=Url::to(['admin/update','id'=>$v['users_id']])?>">编辑用户</a>
                        <a class="btn btn-danger btn-xs" href="javascript:makedo('/index.php?r=admin/delete&id=<?= $v['users_id'] ?>', '确认删除该记录？')">删除用户</a>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        <div class="panel-body">
            <?= linkPager::widget(['pagination'=>$pagination]) ?>
        </div>
    </div>
</div>
<script>
    function makedo(url,message) {
        if(confirm(message)) location.href = url;
    }
</script>
<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;

?>

<section class="wrapper">
    <div class="concacts">
        <div class="wrap">
            <div class="nav">
                <ul>
                    <li class="current">监控联系人管理</li>
                </ul>
            </div>
        </div>
        <div class="qiehuan">
            <div class="tabWrap">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th  class="tablehead">Id</th>
                        <th  class="tablehead">用户名</th>
                        <th  class="tablehead">Email</th>
                        <th  class="tablehead">电话</th>
                        <th  class="tablehead">邮件通知</th>
                        <th  class="tablehead">短信通知</th>
                        <th  class="tablehead">操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach($userList as $user):?>
                        <tr>
                            <td><?=$user['users_id'] ?></td>
                            <td><?=$user['realname'] ?></td>
                            <td><?=$user['email'] ?></td>
                            <td><?=$user['mobile'] ?></td>
                            <?php if($user['notification'] == 0):?>
                                <td>×</td>
                                <td>×</td>
                            <?php elseif($user['notification'] == 1):?>
                                <td>×</td>
                                <td>√</td>
                            <?php elseif($user['notification'] == 2):?>
                                <td>√</td>
                                <td>×</td>
                            <?php elseif($user['notification'] == 3): ?>
                                <td>√</td>
                                <td>√</td>
                            <?php endif;?>
                            <td>
                                <a href="<?=Url::to(['admin/update','id'=>$user['users_id'],'refreshUrl'=>'monitorman/index'])?>" class="btn btn-info btn-xs">编辑</a>
                                <a href="<?=Url::to(['admin/delete','id'=>$user['users_id'],'refreshUrl'=>'monitorman/index'])?>" class="btn btn-danger btn-xs">删除</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <style>
                    .tabWrap ul li{border:white;}
                </style>
                <?= linkPager::widget(['pagination'=>$pagination]) ?>
            </div>


            <!--            <div class="tabWrap">-->
            <!--                <div class="zltab">-->
            <!--                    <table class="table table-striped table-advance table-hover">-->
            <!--                        <thead>-->
            <!--                        <tr>-->
            <!--                            <th class="tablehead">id</th>-->
            <!--                            <th class="tablehead">登录名</th>-->
            <!--                            <th class="tablehead">用户名</th>-->
            <!--                            <th class="tablehead">所属角色</th>-->
            <!--                            <th class="tablehead">操作</th>-->
            <!--                        </tr>-->
            <!--                        </thead>-->
            <!--                        <tbody>-->
            <!--                        <tr>-->
            <!--                            <td>1</td>-->
            <!--                            <td>baiyu</td>-->
            <!--                            <td>白钰</td>-->
            <!--                            <td>超级管理员</td>-->
            <!--                            <td><input class="btn tana btn-info btn-xs mysubmit col_bao_01" type="submit" value="添加监控联系人" name="submit"></td>-->
            <!--                        </tr>-->
            <!--                        <tr>-->
            <!--                            <td></td>-->
            <!--                            <td></td>-->
            <!--                            <td></td>-->
            <!--                            <td></td>-->
            <!--                            <td><input class="btn btn-info btn-xs mysubmit col_bao_01 " type="submit" value="添加监控联系人" name="submit"></td>-->
            <!--                        </tr>-->
            <!--                        </tbody>-->
            <!--                    </table>-->
            <!--                </div>-->
            <!--            </div>-->
            <!---->
            <!--            <div class="tanc">-->
            <!--                <div class="tancc">-->
            <!--                    <h4>请填写该用户的练习方式</h4>-->
            <!--                    <ul>-->
            <!--                        <li><span>手机号码：</span><input id="title" class="form-control" type="text" value="" maxlength="20" name="info[title]"></li>-->
            <!--                        <li><span>邮箱：</span><input id="title" class="form-control" type="text" value="" maxlength="20" name="info[title]"></li>-->
            <!--                        <li class="dian"><span>是否发送邮件：</span><span><input type="checkbox" name="ids[]" value="5">是</span><span><input type="checkbox" name="ids[]" value="5">否</span></li>-->
            <!--                        <li class="dian dian1"><span>是否发送短信：</span><span><input type="checkbox" name="ids[]" value="5">是</span><span><input type="checkbox" name="ids[]" value="5">否</span></li>-->
            <!--                    </ul>-->
            <!--                    <div class="tanccc">-->
            <!--                        <ul>-->
            <!--                            <li><a>确定</a></li>-->
            <!--                            <li class="tang"><a>取消</a></li>-->
            <!--                        </ul>-->
            <!--                    </div>-->
            <!---->
            <!--                </div>-->
            <!--            </div>-->
        </div>

    </div>

</section>
<script type="text/javascript" src="res/js/jquery-1.10.2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.qiehuan .tabWrap').eq(0).css('display','block')
        var myZindex = 0;
        $('.nav ul li').click(function(){
            if (!$(this).hasClass('current')) {
                myZindex++
                $(this).addClass('current').siblings().removeClass('current')

                $('.qiehuan .tabWrap').eq($(this).index()).css('display', 'block').siblings().css('display', 'none');
            };
        })
    })
    $(function(){
        $('.tana').click(function(){
            $(".tanc").show();
        })
        $('.tang').click(function(){
            $(".tanc").hide();
        })
    });
</script>

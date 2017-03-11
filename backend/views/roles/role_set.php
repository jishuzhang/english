<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div class="wrapper">
    <div class="shezhiWrap">
        <div class="shezhi_btn">
            <div class="ccc"><a href="<?=Url::to(['roles/index'])?>" style="">角色管理</a></div>
            <div><a href="javascript:void(0);">权限设置</a></div>
        </div>
        <div class="guanli">
            <span>所属角色：</span><p><?=$roleinfo['role']?></p>
        </div>
        <?php $form = ActiveForm::begin(['action' => ['roles/role_save'],'method'=>'post','id'=>'php_save_node']); ?>
            <ul class="ce shezhi_ce">
                <?php foreach($nodes as $node):?>

                    <?php if($node['pid'] == 0):?>
                        <li>
<!--                            一级菜单-->
                            <a href="javascript:void(0);" class="a_01"><input type="checkbox" name="nodes[]" value="<?=$node['nodes_id'];?>" <?=in_array($node['nodes_id'],$accessNodes) ? 'checked': '';?>/>&nbsp;&nbsp;&nbsp;&nbsp;<?=$node['title']?></a>
                        <?php if(!empty($node['submenu'])):?>
                            <ul class="er shezhi">
                            <?php foreach($node['submenu'] as $subNode):?>
                                <li class="e_li she_li">
<!--                                    二级菜单-->
                                    <div class="bak"><input type="checkbox" name="nodes[]" value="<?=$subNode['nodes_id'];?>" <?=in_array($subNode['nodes_id'],$accessNodes) ? 'checked': '';?>/><?=$subNode['title']?></div>
                                <?php if(!empty($subNode['submenu'])):?>
                                    <div class="yingyong">
                                    <?php foreach($subNode['submenu'] as $actionNode):?>
<!--                                        三级菜单-->
                                        <input type="checkbox" name="nodes[]" value="<?=$actionNode['nodes_id'];?>" <?=in_array($actionNode['nodes_id'],$accessNodes) ? 'checked': '';?>/><?=$actionNode['title']?>
                                    <?php endforeach;?>
                                    </div>

                                <?php endif;?>
                                </li>
                            <?php endforeach;?>
                            </ul>
                        <?php endif;?>
                        </li>
                    <?php endif;?>

                <?php endforeach;?>

                <div class="clear"></div>
            </ul>
        <?php ActiveForm::end(); ?>
    </div>

</div>

<script>
    var nodeForm = $('#php_save_node');
    var roleId = <?=$roleinfo['roles_id']?>;
    $('#php_save_node input').click(function (){

        var _csrf = $('input[name="_csrf"]').val();
        var nodeId = $(this).val();
        var isSelected = $(this).is(':checked') ? 1 : 0 ;
        var data = {_csrf:_csrf,nodeid:nodeId,roleid:roleId,isSelected:isSelected};

        $.ajax({
            url:nodeForm.attr('action'),
            data:data,
            type:nodeForm.attr('method'),
            success:function (errorCode){
                if(errorCode == 1){
                    // success
                }else{
                    // error
                }
            },
            error:function (e){
                alert(e.responseText);
            },
            dataType:'html'
        });
    });
</script>



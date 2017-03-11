<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<?php
$form = ActiveForm::begin(['action' => ['roles/update'],'method'=>'post',]); ?>
<div class="wrapper">
    <div class="menuWrap">
        <div class="shezhi_btn">
            <a class="btn btn-default" href="<?=Url::to(['roles/index'])?>">角色管理</a>
            <a class="btn btn-info menuadd" href="javascript:;">角色编辑</a>
        </div>
        <div class="botm">
            <div class="kongzhi">
                <input name="rolesid" type="hidden" value="<?php echo $result['roles_id']?>"/>
                <span>角色名称：</span><input type="text" name="role_name" value="<?php echo $result['role']?>"/>
            </div>
            <div class="kongzhi">
                <span>角色描述：</span><textarea name="role_description" id="" ><?php echo $result['description']?></textarea>
            </div>
            <input name="rolesid" type="hidden" value="<?php echo $result['roles_id']?>"/>
            <button class="use_baocun" type="submit">保存</button>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

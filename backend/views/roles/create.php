<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<?php
$form = ActiveForm::begin(['action' => ['roles/create'],'method'=>'post',]); ?>
<div class="wrapper">
    <div class="menuWrap">
        <div class="shezhi_btn">
            <a class="btn btn-default" href="<?=Url::to(['roles/index'])?>">角色管理</a>
            <a class="btn btn-info menuadd" href="javascript:;">添加角色</a>
        </div>
        <div class="botm">
            <div class="kongzhi">
                <span>角色名称：</span><input type="text" name="role_name"/>
            </div>
            <div class="kongzhi">
                <span>角色描述：</span><textarea name="role_description" id=""></textarea>
            </div>

            <button class="use_baocun" type="submit">保存</button>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

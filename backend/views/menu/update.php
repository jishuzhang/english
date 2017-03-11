<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<?php
$form = ActiveForm::begin(['action' => ['menu/update'],'method'=>'post',]); ?>
<div class="wrapper">
    <div class="menuWrap">
        <div class="shezhi_btn">
            <a class="btn btn-default" href="<?=Url::to(['menu/index'])?>">菜单管理</a>
            <a class="btn btn-info menuadd" href="<?=Url::to(['menu/create'])?>">菜单编辑</a>
        </div>

        <div class="botm">
            <div class="mingcheng">
                <span>菜单名称：</span><input type="text" name="title" value="<?=$data['title'] ?>" />
            </div>
            <div>
                <span>上级菜单：</span><select name="pid" id="">
                    <option value="0" selected="selected">==顶级菜单==</option>
                    <?php foreach($titles as $key => $value){ $num = substr_count($value['path'], '-'); ?>

                        <option <?php if($data['pid']==$value['nodes_id']){echo "selected='selected'";}?> value="<?= $value['nodes_id']?>"><?php echo str_repeat('--/',$num); ?><?= $value['title']?></option>
                    <?php }  ?>
                </select>
            </div>
            <div class="kongzhi">
                <span>控制器：</span><input type="text" name="controller" value="<?=$data['controller']?>" />
            </div>
            <div class="fangfa">
                <span>方法：</span><input type="text" name="action" value="<?=$data['action']?>" />
            </div>
            <div class="fangfa">
                <span>层级：</span><input type="text" name="floor" value="<?=$data['floor']?>" />
            </div>
            <div class="xianshi">
                <span>是否显示：</span>
                <input type="radio" name="display" value="1" <?php if($data['display']==1){echo " checked='checked'";}?> />是</span>
                <input type="radio" name="display" value="0" <?php if($data['display']==0){echo " checked='checked'";}?>/>否</span>
            </div>
            <input type="hidden" name="nodes_id" value="<?=$data['nodes_id'] ?>">
            <input class="menu_baocun" type="submit" value="保存">
            <!--            <div class="menu_baocun">保存</div>-->
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

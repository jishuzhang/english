<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<?php
$form = ActiveForm::begin(['action' => ['menu/create'],'method'=>'post',]); ?>
<div class="wrapper">
    <div class="menuWrap">
        <div class="shezhi_btn">
            <a class="btn btn-default" href="<?=Url::to(['menu/index'])?>">菜单管理</a>
            <a class="btn btn-info menuadd" href="javascript:;">添加菜单</a>
        </div>
        <div class="botm">
            <div class="mingcheng">
                <span>菜单名称：</span><input type="text" name="title" />
            </div>
            <div>
                <span>上级菜单：</span><select name="pid" id="">
                            <option value="0" selected="selected">==顶级菜单==</option>
                    <?php foreach($titles as $key => $value){ $num = substr_count($value['path'], '-'); ?>
                            <option <?php if(isset($nodes_id)&&$nodes_id==$value['nodes_id']){echo "selected='selected'";}?> value="<?= $value['nodes_id']?>"><?php echo str_repeat('--/',$num); ?><?= $value['title']?></option>
                    <?php }  ?>
                </select>
            </div>
            <div class="kongzhi">
                <span>控制器：</span><input type="text" name="controller" />
            </div>
            <div class="fangfa">
                <span>方法：</span><input type="text" name="action" />
            </div>
            <div class="fangfa">
                <span>层级：</span><input type="text" name="floor" />
            </div>
            <div class="xianshi">
                <span>是否显示：</span>
                    <input type="radio" name="display" value="1" checked="checked" />是</span>
                    <input type="radio" name="display" value="0" />否</span>
            </div>
            <input class="menu_baocun" type="submit" value="保存">
<!--            <div class="menu_baocun">保存</div>-->
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

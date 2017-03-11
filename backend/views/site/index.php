<?php
use yii\helpers\Url;
?>
<script type="text/javascript" src="res/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
    $(function(){


        $('.yingWrap .ying .hover').each(function (index,domEle){
            $(this).hover(function(){
                $(this).find('.span01 a').show();
            },function(){
                $(this).find('.span01 a').hide();
            })
        });
    })
</script>
<style>
    .yingWrap { width:1210px; }
    .hover {
        float: left;
        height: 99px;
        margin-bottom: 20px;
        width: 300px;
        background:0 none;
    }
    .yingWrap .ying .span01, .yingWrap .ying .span02 {
        margin-left: 20px;
        margin-right: 0px;
    }
    .yingWrap .ying .span01 {  position: relative; width:176px; line-height: 42px; }
    .yingWrap .ying .span01 a { left: 12px; width:30px; }
</style>
<div class="wrapper">
    <div class="yingWrap">
        <div class="ying">
            <?php if(!empty($info_application)){ ?>
            <?php foreach ($info_application as $key => $val){ ?>
                    <?php foreach ($val as $value){?>
            <div class="hover">

                <span class="span04"><a href="<?=Url::to(['appmanager/index','app_id'=>$value['app_id']])?>" > <img src="<?php $url = !empty($value['image_url']) ? $value['image_url']: 'res/images/xitong.png'; echo $url; ?>" height="90" width="100"></a></span>
                <span class="span01"><?= $value['title'] ?><a href="<?=Url::to(['application/update','app_id'=>$value['app_id']])?>">修改</a></span>
<!--                <span class="span03"><a href="--><?//=Url::to(['application/create'])?><!--"><img src="res/images/jia_03.jpg" height="35" width="37" alt="" /></a></span>-->

            </div>
                    <?php } ?>
            <?php } ?>
            <?php } ?>
<!--            <span class="span05"><a href="--><?//=Url::to(['appmanager/index'])?><!--"><img src="res/images/xitong.png" height="90" width="100" alt="" /></a></span>-->
<!--            <span class="span02">phpcms</span>-->
            <span class="span03"><a href="<?=Url::to(['application/create'])?>"><img src="res/images/jia_03.jpg" height="35" width="37" alt="" /></a></span>
        </div>
    </div>
</div>
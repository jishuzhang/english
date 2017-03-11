<?php
use yii\helpers\Url;
?>
<div class="wrapper">
    <div class="Mer_establish" >
        <img src="res/images/touxiang_03.jpg" height="44" width="42" alt="" />
        <div class="Mer_right">
            <p style="height: 40px;"> <?= $createby ?><br />创建人</p>
        </div>
    </div>
    <div class="MerWrap" style="margin-left:130px; height: auto; font-size: 14px;  color: #333; padding: 40px 0px 0px 40px;">
        <?php if(!empty($result)){ foreach($result as $key=>$value){ ?>
            <div class="Mer_establish Mer_establish_01" style=" margin: -40px 40px 50px 10px; width:150px;" >
                <img src="res/images/touxiang_03.jpg" height="44" width="42" alt="" />
                <a href="javascript:void(0);"> <span style="color:#565656;" class="glyphicon glyphicon-trash span" data-id="<?=$value['app_member_id']?>"" title="删除" ></span></a>
                <div class="Mer_right">
                    <p><?= $value['realname'] ?> <br />成员</p>
                </div>
                <div class="quanxian">
                    <a href="<?=Url::to(['member/memberallow','users_id'=>$value['users_id']])?>">权限设置</a>
                </div>
            </div>
        <?php }} ?>
        <div class="Mer_jia" style="margin-top: -8px; margin-left: 50px; ">
            <a href="<?=Url::to(['member/create'])?>">
                <img src="res/images/jia_03.jpg" height="35" width="37" alt="" />
            </a>
        </div>
    </div>
</div>
<script>
    $(function() {
        //触发鼠标滑动事件
        $('.Mer_establish_01').hover(function() {
            $(this).find('span').show();
        }, function() {
            $(this).find('span').hide();
        });

        $('.span').on('click', function() {
            var id=$(this).attr('data-id');
            var obj=$(this);
            $.ajax({
                type:'GET',
                url:'index.php?r=member/delete',
                data:'id='+id,
                dataType:'text',
                success:function(mes){
                    if(mes == 1){
                        alert("删除成功");
                        obj.parent('a').parent('div').remove();
                    }else{
                        alert("删除失败");
                    }
                },
                error:function(){
                    alert('数据有误请重试！');
                }
            });
        });
    });
</script>
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<div class="wrapper">
    <div class="personal_wrap application_wrap">
        <?php $form = ActiveForm::begin([
            'method'=>'post',
            'id'=>'submit_form',
            'options'=>['enctype'=>'multipart/form-data'],
            'action' => ['application/create'],
        ]);?>
        <table>
            <tr>
                <td>
                    <img src="res/images/xitong.png" id="personal_img" height="50" width="50" alt="" />
                    <input type="file" name="upload_file" id="upload_file">        <!-- 添加上传文件 -->
                </td>
            </tr>
            <tr>
                <td><span>应用名称：</span><input id="title" type="text" name="form[title]" value="" /></td>
            </tr>
            <tr>
                <td><span>应用描述：</span><input name="form[description]" type="text" /></td>
            </tr>
            <tr>
                <td><span style="margin-right:16px;">应用根地址：</span><input name="form[app_address]"  readonly="true"  type="text" value="<?=Url::to(['appmanager/index'])?>"/></td>
            </tr>
            <tr>
<!--                --><?php //if(!in_array($role,Yii::$app->params)){
//                    echo '<td><span style="margin-right:16px;">接口根地址：</span><p style="width:113px;">'.Yii::$app->params["appsite_url"].'/</p><input style="width: 120px" name="form[interface_address]" type="text" readonly="true"  value="" /></td>';
//                }else{
//                    echo '<td><span style="margin-right:16px;">接口根地址：</span><input type="text"  name="form[interface_address]" /></td>';
//                }
//                ?>
                <td><span style="margin-right:16px;">接口根地址：</span><p style="width:113px;"><?=Yii::$app->params["appsite_url"]?>/</p><input style="width: 120px" name="form[interface_address]" type="text" readonly="true"  value="" /></td>
            </tr>


        </table>
        <button class="personal_btn" type="button"  onclick='appSubmit()'>提交</button>
        <?php  ActiveForm::end();?>
    </div>
</div>
<script type="text/javascript" src="res/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="res/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="res/js/index_Returncode.js"></script>
<!--<script type="text/javascript" src="http://files.cnblogs.com/Zjmainstay/jquery-1.6.2.min.js"></script>-->
<!--上传图片-->
<script type="text/javascript">
    title = $("input[name='form[title]']");
    interface_address = $("input[name='form[interface_address]");

    $(document).ready(function()
    {
        $("#upload_file").change(function(){
            var objUrl = getObjectURL(this.files[0]);
            console.log("objUrl = "+objUrl) ;
            if (objUrl) {
                $("#personal_img").attr("src", objUrl) ;
            }
        });
          title.on({
               focus:function(){
                   interface_address.val(title.val());
               },
               blur:function(){
                   interface_address.val(title.val());
               },
               keyup:function(){
                   interface_address.val(title.val());
               }
           });

    });

    //给保存按钮绑定点击事件
    function appSubmit()
    {
        var description = $("input[name='form[description]']").val();
        var app_address = $("input[name='form[app_address]").val();
        if(title.val() == ""){
            alert("应用名称不可以为空");
            return false;
        }
//        else if($("#upload_file").val() == "") {
//            alert("图片不可以为空");
//            return false;
//        }
        else if(description =="") {
            alert("应用描述不可以为空");
            return false;
        } else if(app_address =="" ) {
            alert("应用根地址不可以为空");
            return false;
        }else if(interface_address.val() ==""){
            alert("接口根地址不可以为空");
            return false;
        }else if(!interface_address.val().match(/^[-a-z0-9-A-Z+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]$/)){
            alert("应用名称址格式不对");
            return false;
        }
        else if(title.val() !== ""){
            var titles = title.val();
            $.ajax({
                type:'POST',
                url:'index.php?r=application/create',
                data:'title='+titles,
                success:function(mes){
                    if(mes==2) {
                        $("#submit_form").submit();
                    }else if(mes==1){
                        alert("有完全相同的标题存在");
                        return false;
                    }else if(mes==3){
                        if(confirm("当前标题状态为关闭,是否开启？")) {
                            $.get('index.php?r=application/create',{title:titles}, function (data) {
                              if(data == 1){
                                  alert("开启成功");
                              }else{
                                  alert("开始失败");
                              }
                            });
                        }else{
                            return false;
                        }
                    }else {
                        alert("没有权限");
                        return false;
                    }
                },
                error:function(){
                    alert('数据有误请重试！');
                    return false;
                }
            });
        }else{
            $("#submit_form").submit();
        }
    }
    function getObjectURL(file)
    {
        var url = null ;
        if (window.createObjectURL!=undefined) {
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) {
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) {
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }

</script>
<!--上传图片-->
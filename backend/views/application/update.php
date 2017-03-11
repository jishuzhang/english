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
            'action' => ['application/update'],
        ]);?>
        <table>
            <tr>
                <td> <img src="<?= empty($apps['image_url']) ?  "res/images/xitong.png" :  $apps['image_url'] ;?>" height="50" width="50"  id="personal_img" alt="" />
                    <input type="file" name="upload_file" id="upload_file">        <!-- 添加上传文件 -->
                    <input type="hidden" name="app_id" value="308" />
                </td>
            </tr>
            <tr>
                <td><span>应用名称：</span><input type="text" value="<?= $apps['title']?>" name="title"/></td>
            </tr>
            <tr>
                <td><span>应用描述：</span><input type="text" value="<?= $apps['description']?>" name="description"/></td>
            </tr>
            <tr>
                <td><span style="margin-right:16px;">应用根地址：</span><input type="text" value="<?= $apps['app_address']?>" readonly="true" name="app_address" /></td>
            </tr>
            <tr>
                <?php if(!in_array($role,Yii::$app->params)){
                    echo ' <td><span style="margin-right:16px;">接口根地址：</span><p style="width:113px;">'.$pase_url.'/</p><input style="width: 120px" type="text" value='.$interface_address.'   readonly="true" name="interface_address" /></td>';
                }else{
                    echo '<td><span style="margin-right:16px;">接口根地址：</span><input type="text" value='.$interface_address.'   name="interface_address" /></td>';
                }
                ?>

            </tr>
        </table>
        <button class="personal_btn" type="button"  onclick='appSubmit()'>保存</button>
        <?php  ActiveForm::end();?>
    </div>
</div>
<script type="text/javascript" src="res/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="res/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="res/js/index_Returncode.js"></script>
<!--<script type="text/javascript" src="http://files.cnblogs.com/Zjmainstay/jquery-1.6.2.min.js"></script>-->
<!--上传图片-->
<script type="text/javascript">
    title = $("input[name='title']");
    interface_address = $("input[name='interface_address']");
    $(document).ready(function()
    {
        $("#upload_file").change(function(){
            var objUrl = getObjectURL(this.files[0]) ;
            console.log("objUrl = "+objUrl) ;
            if (objUrl) {
                $("#personal_img").attr("src", objUrl) ;
            }
        });
        <?php if(!in_array($role,Yii::$app->params)){
                   echo ' title.on({
                            focus:function(){
                                interface_address.val(title.val());
                            },
                            blur:function(){
                                interface_address.val(title.val());
                            },
                            keyup:function(){
                                interface_address.val(title.val());
                            }
                        });';
               }
        ?>


    });
    //给保存按钮绑定点击事件
    function appSubmit()
    {
        var description = $("input[name='description']").val();
        var app_address = $("input[name='app_address']").val();
        if(title.val() == ""){
            alert("应用名称不可以为空");
            return false;
        } else if(description =="") {
            alert("应用描述不可以为空");
            return false;
        } else if(app_address =="" ) {
            alert("应用根地址不可以为空");
            return false;
        }else if(interface_address.val() ==""){
            alert("接口根地址不可以为空");
            return false;
        }
        <?php if(!in_array($role,Yii::$app->params)){
            echo '
                else if(!interface_address.val().match(/^[-a-z0-9-A-Z+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]$/)){
                    alert("应用名称址格式不对");
                    return false;
                }';
        }else{
            echo 'else if(!interface_address.val().match(/^((https|http|ftp|rtsp|mms)?:\/\/)[^\s]+/)){
                    alert("接口根地址格式不对");
                    return false;
                }';
        }
        ?>
        else if(title.val() !== "<?= $apps['title']?>"){
            var titles = title.val();
            $.ajax({
                type:'GET',
                url:'index.php?r=application/update',
                data:'title='+titles,
                success:function(mes){
                    if(mes == 1){
                        alert("应用名称重复");
                        return false;
                    }else{
                       <?php if($userid == $create_by || in_array($role,Yii::$app->params)){

                           echo '$("#submit_form").submit();';

                       }else{
                            echo 'alert("只有管理员和创建者才有权限提交");
                               return false;
                               ';
                       }
                       ?>
                    }
                },
                error:function(){
                    alert('数据有误请重试！');
                    return false;
                }
            });
        }else{
            <?php if($userid == $create_by || in_array($role,Yii::$app->params) ){
                   echo '$("#submit_form").submit();';
              }else{
                   echo 'alert("只有管理员和创建者才有权限提交");
                      return false;
                      ';

              }
              ?>
        }
    }
    //获取头像文件地址的方法
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
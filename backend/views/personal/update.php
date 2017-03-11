<?php
use yii\widgets\ActiveForm;
?>
<div class="wrapper">
    <div class="personal_wrap">
        <?php $form = ActiveForm::begin([
            'method'=>'post',
            'id'=>'submit_form',
            'options'=>['enctype'=>'multipart/form-data'],
            'action' => ['personal/update'],
        ]);?>
        <table>
            <tr>
                <td>
                    <img src="<?php echo empty($users['portrait']) ?  "res/images/img_04.jpg" :  $users['portrait'] ;?>" id="personal_img" height="50" width="50" alt="" />
                    <input type="file" name="upload_file" id="upload_file">        <!-- 添加上传文件 -->
                </td>
            </tr>
            <tr>
                <td><span>登录名： &nbsp;&nbsp;</span><input type="text" name="username" value="<?php echo $users['username'] ?>"/></td>
            </tr>
            <tr>
                <td><span>用户名： &nbsp;&nbsp;</span><input type="text" name="realname"  value="<?php echo $users['realname'] ?>"/></td>
            </tr>
            <tr>
                <td><span style="margin-right:44px;">密码： &nbsp;&nbsp;</span><input type="password" name="password" value="@^()^@" placeholder="密码为空则使用原密码"/></td>
            </tr>
            <tr>
                <td><span style="margin-right:16px;">所属权限： &nbsp;&nbsp;</span><p><?php echo $users['role'] ?></p></td>
            </tr>
        </table>

        <button class="personal_btn" type="button" onclick='loginSubmit()'>保存</button>

        <?php  ActiveForm::end();?>
    </div>
</div>
<script type="text/javascript" src="res/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="res/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="res/js/index_Returncode.js"></script>
<!--上传图片-->
<script type="text/javascript">
    $(document).ready(function()
    {
        $("#upload_file").change(function(){
            var objUrl = getObjectURL(this.files[0]);
            console.log("objUrl = "+objUrl) ;
            if (objUrl) {
                $("#personal_img").attr("src", objUrl) ;
            }
        });
    });
    //给保存按钮绑定点击事件
    function loginSubmit()
    {
        var username = $("input[name='username']");
        var password = $("input[name='password']").val();
        var realname = $("input[name='realname']").val();
        if(username.val() == ""){
            alert("登录名不可以为空");
            return false;
        } else if(realname =="") {
            alert("用户名不可以为空");
            return false;
        } else{
            $("#submit_form").submit();
        }
    }
    //获取头像文件地址的方法
    function getObjectURL(file)
    {
        var url = null ;
        if (window.createObjectURL!=undefined) {
            url = window.createObjectURL(file);
        } else if (window.URL!=undefined) {
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) {
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }
</script>
<!--上传图片-->

<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<?php
$form = ActiveForm::begin(['action' => ['admin/update'],'method'=>'post',]); ?>
<div class="wrapper">
    <div class="menuWrap">
        <div class="shezhi_btn">
            <a class="btn btn-default" href="<?=Url::to(['admin/index'])?>">用户管理</a>
            <a class="btn btn-info menuadd" href="javascript:;">修改用户</a>
        </div>
        <div class="botm">
            <div class="kongzhi">
                <input name="userid" type="hidden" value="<?php echo $result['users_id']?>"/>
                <?php if(isset($_GET['refreshUrl'])): ?>
                <input name="refreshUrl" type="hidden" value="<?php echo $_GET['refreshUrl']?>"/>
                <?php endif; ?>
                <span>登&nbsp;录&nbsp;名&nbsp;: </span><input type="text" name="username" value="<?php echo $result['username']?>"/>
            </div>
            <div class="kongzhi">
                <span>密&nbsp;&nbsp;&nbsp;&nbsp;码&nbsp;：</span><input type="password" name="password" placeholder="密码为空则使用原密码"/>
            </div>
            <div class="kongzhi">
                <span>所属角色:</span>
                <select name="role" id="">
                    <?php foreach($query as $q){?>
                        <option <?php if($result['roleid']==$q['roles_id']){echo "selected='selected'";}?> value="<?php echo $q['roles_id']?>"><?php echo $q['role']?></option>
                    <?php }?>
                </select>
            </div>
            <div class="kongzhi">
                <span>用&nbsp;户&nbsp;名：</span><input type="text" name="realname" value="<?php echo $result['realname']?>"/>
            </div>
            <div class="kongzhi">
                <span>邮&nbsp;&nbsp;&nbsp;&nbsp;箱&nbsp;：</span><input type="text" name="email" value="<?php echo $result['email']?>"/>
            </div>
            <div class="kongzhi">
                <span>电&nbsp;&nbsp;&nbsp;&nbsp;话&nbsp;：</span><input type="text" name="mobile" value="<?php echo $result['mobile']?>"/>
            </div>
            <div class="kongzhi">
                <span>通知方式&nbsp;：</span><br/>
                <?php if($result['notification']==0):?>
                    <input type="radio" name="notification" value="0" checked="checked"/>不通知<br/>
                    <input type="radio" name="notification" value="1" />短信通知<br/>
                    <input type="radio" name="notification" value="2" />邮箱通知<br/>
                    <input type="radio" name="notification" value="3" />短信/邮箱通知
                <?php elseif($result['notification']==1):?>
                    <input type="radio" name="notification" value="0" />不通知<br/>
                    <input type="radio" name="notification" value="1" checked="checked" />短信通知<br/>
                    <input type="radio" name="notification" value="2" />邮箱通知<br/>
                    <input type="radio" name="notification" value="3" />短信/邮箱通知
                <?php elseif($result['notification']==1):?>
                    <input type="radio" name="notification" value="0" />不通知<br/>
                    <input type="radio" name="notification" value="1" />短信通知<br/>
                    <input type="radio" name="notification" value="2" checked="checked" />邮箱通知<br/>
                    <input type="radio" name="notification" value="3" />短信/邮箱通知
                <?php else: ?>
                    <input type="radio" name="notification" value="0" />不通知<br/>
                    <input type="radio" name="notification" value="1" />短信通知<br/>
                    <input type="radio" name="notification" value="2" />邮箱通知<br/>
                    <input type="radio" name="notification" value="3" checked="checked"/>短信/邮箱通知
                <?php endif ?>
            </div>
            <button class="use_baocun" type="submit">保存</button>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

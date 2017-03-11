<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<?php
ActiveForm::begin(['action' => ['admin/create'],'method'=>'post',]); ?>

<div class="wrapper">
    <div class="menuWrap">
        <div class="shezhi_btn">
            <a class="btn btn-default" href="<?=Url::to(['admin/index'])?>">用户管理</a>
            <a class="btn btn-info menuadd" href="javascript:;">增加新用户</a>
        </div><br>
        <div class="botm">
            <div class="kongzhi">
                <span>登&nbsp;录&nbsp;名&nbsp;: </span><input type="text" name="username" value=""/>
            </div>
            <div class="kongzhi">
                <span>密&nbsp;&nbsp;&nbsp;&nbsp;码&nbsp;：</span><input type="text" name="password" onfocus="this.type='password'"/>
            </div>
            <div class="kongzhi">
                <span>所属角色&nbsp;:</span><select name="roleid">
                        <?php foreach($query as $q){?>
                        <option  value="<?php echo $q['roles_id']?>"><?php echo $q['role']?></option>
                    <?php }?>
                </select>
            </div>
            <div class="kongzhi">
                <span>用&nbsp;户&nbsp;名：</span><input type="text" name="realname"/>
            </div>
            <div class="kongzhi">
                <span>邮&nbsp;&nbsp;&nbsp;&nbsp;箱&nbsp;：</span><input type="text" name="email"/>
            </div>
            <div class="kongzhi">
                <span>电&nbsp;&nbsp;&nbsp;&nbsp;话&nbsp;：</span><input type="text" name="mobile"/>
            </div>
            <div class="kongzhi">
                <span>通知方式&nbsp;：</span><br/>
                <input type="radio" name="notification" value="0" checked="checked"/>不通知<br/>
                <input type="radio" name="notification" value="1" />短信通知<br/>
                <input type="radio" name="notification" value="2" />邮箱通知<br/>
                <input type="radio" name="notification" value="3" />短信/邮箱通知
            </div>
            <button class="use_baocun" type="submit">保存</button>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

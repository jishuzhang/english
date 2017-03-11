<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<link href="/res/css/chosen.css" rel="stylesheet">
<style>
    .chosen-container-single .chosen-search input[type="text"] {
        background:url() !important;
    }
</style>
<div class="wrapper">
    <div class="mcontent">
<!--        标题-->
        <div class="content_t">
            <h4>监控日志</h4>
        </div>
<!--        筛选-->
        <div class="content_x">
            <ul>
                <li>
                    <select id="php_user" class="form-control chosen-select" type="text" value="用户名" maxlength="20" name="info[title]">
                        <option value="0">全部用户</option>
                        <?php if(isset($realName) && !empty($realName)): ?>
                            <?php foreach($realName as $userId => $userName): ?>
                                <option value="<?=$userId; ?>"   <?php if(isset($filterItems['userId']) && $filterItems['userId'] == $userId):?> selected="selected"  <?php endif; ?> ><?=$userName;?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </li>
                <li>
                    <select id="php_interface" class="form-control chosen-select" type="text" value="接口" maxlength="20" name="info[title]">
                        <option value="0">接口</option>
                        <?php if(isset($interfaceInfoSet) && !empty($interfaceInfoSet)): ?>
                            <?php foreach($interfaceInfoSet as $interfaceFilterId => $interfaceFilterTitle): ?>
                                <option value="<?=$interfaceFilterId; ?>"   <?php if(isset($filterItems['interfaceId']) && $filterItems['interfaceId'] == $interfaceFilterId):?> selected="selected"  <?php endif; ?> ><?=$interfaceFilterTitle;?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </li>

                <li style="width:120px;">
                    <select name="form[template]" id="php_message_type " class="form-control chosen-select" style="width:120px;">
                        <option value="1" <?php if(isset($filterItems['messageType']) && $filterItems['messageType'] == 1):?> selected="selected"  <?php endif; ?>>短信发送时间</option>
                        <option value="2" <?php if(isset($filterItems['messageType']) && $filterItems['messageType'] == 2):?> selected="selected"  <?php endif; ?>>邮件发送时间</option>
                    </select>
                </li>
                <li style="width:170px;">
                    <div class="box">
                        <div class="demo2">
                            <input placeholder="请输入日期" style="height:34px;width:170px;" class="laydate-icon"
                                   onClick="laydate({istoday: false,istime: false, format: 'YYYY-MM-DD',choose:function (datas){
								   		enterTimeFilter(1,datas);
								   }})">
                        </div>
                    </div>
                </li>

                <li style="width:170px;">
                    <div class="box">
                        <div class="demo2">
                            <input placeholder="请输入日期" style="height:34px;width:170px;" class="laydate-icon"
                                   onClick="laydate({istoday: false,istime: false, format: 'YYYY-MM-DD',choose:function (datas){
								   		enterTimeFilter(2,datas);
								   }})">
                        </div>
                    </div>
                </li>
                <li><input class="btn btn-info php_submit_search" type="submit" value="搜索" name="submit"></li>
            </ul>
        </div>
        <!--搜索条件-->
        <?php $form = ActiveForm::begin(['action' => ['monitorlog/index'],'method'=>'get','id'=>'php_search']); ?>
        <input type="hidden" value="" class="" name="timeSt">
        <input type="hidden" value="" class="" name="timeEnd">
        <input type="hidden" value="" class="" name="userId">
        <input type="hidden" value="" class="" name="interfaceId">
        <input type="hidden" value="" class="" name="messageType">
        <?php ActiveForm::end(); ?>
        <!--列表-->
        <div class="content_z">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th class="tablehead">monitorID</th>
                    <th class="tablehead">用户名</th>
                    <th class="tablehead">接口</th>
                    <th class="tablehead">短信发送时间</th>
                    <th class="tablehead">邮件发送时间</th>
                    <th class="tablehead">短信 | 邮件 </th>
                    <th class="tablehead">Message Content</th>
                    <th class="tablehead">Email Content</th>
                </tr>
                </thead>

                <tbody>
                <?php if(!empty($monitorLogList)):?>
                    <?php foreach ($monitorLogList as $evMonitorLog): ?>
                        <tr>
                            <td><?=$evMonitorLog['monitor_id'];?></td>
                            <td>
                                <?php if(isset($realName[$evMonitorLog['uid']])):?>
                                    <?=$realName[$evMonitorLog['uid']];?>
                                <?php else: ?>
                                    UID: <?=$evMonitorLog['uid'];?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo isset($interfaceInfoSet[$evMonitorLog['interface_id']]) ? $interfaceInfoSet[$evMonitorLog['interface_id']] : '<span style="color:red;">数据丢失</span>'; ?></td>
                            <td><?=date('Y-m-d H:i',$evMonitorLog['phone_sendtime']);?></td>
                            <td><?=date('Y-m-d H:i',$evMonitorLog['email_sendtime']);?></td>
                            <td style="color:red;font-weight: bold;font-size:18px;">
                                <?php if($evMonitorLog['require_phone'] == 1): ?>
                                    √
                                <?php else: ?>
                                    ×
                                <?php endif; ?>

                                    <span style="font-weight: normal;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>

                                <?php if($evMonitorLog['require_email'] == 1): ?>
                                    √
                                <?php else: ?>
                                    ×
                                <?php endif; ?>
                            </td>
                            <td style="cursor:pointer;" title="<?=$evMonitorLog['phone_message'];?>" onclick="alert('<?=$evMonitorLog['phone_message'];?>');">预览</td>
                            <td style="cursor:pointer;" title="<?=$evMonitorLog['email_message'];?>" onclick="alert('<?=$evMonitorLog['email_message'];?>');">预览</td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
            <?php if(empty($monitorLogList)): ?>
                <div style="color:red;font-size:13px;">未查询到相关数据,请重新选择筛选条件</div>
            <?php endif; ?>
        </div>
        <?= linkPager::widget(['pagination'=>$pagination]) ?>
    </div>
</div>
<script type="text/javascript" src="res/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="res/js/laydate.js"></script>
<script>

    // 筛选条件初始化
    var timeSt = 0;
    var timeEnd = 0;  // 截止时间
    var userId = 0;   // 用户 id
    var interfaceId = 0; // 接口 id
    var messageType = 1; // 1 短信  2 邮件

    <?php if(isset($filterItems['timeSt'])):?>
    timeSt = '<?=$filterItems['timeSt'];?>';
    if(timeSt != '0'){
        $('.demo2 input').eq(0).val(timeSt);
    }
    <?php endif; ?>

    <?php if(isset($filterItems['timeEnd'])):?>
    timeEnd = '<?=$filterItems['timeEnd'];?>';
    if(timeEnd != 0){
        $('.demo2 input').eq(1).val(timeEnd);
    }
    <?php endif; ?>

    <?php if(isset($filterItems['appId'])):?>
    userId = '<?=$filterItems['appId'];?>';
    <?php endif; ?>

    <?php if(isset($filterItems['interfaceId'])):?>
    interfaceId = '<?=$filterItems['interfaceId'];?>';
    <?php endif; ?>

    $('.php_submit_search').click(function(){
        submitFilter();
    });

    $('#php_interface').change(function(){
        interfaceId = $(this).val();
    });

    $('#php_user').change(function(){
        userId = $(this).val();
    });

    $('#php_message_type').change(function(){
        messageType = $(this).val();
    });

    // 重新生成 form 表单筛选条件 并提交
    function submitFilter(){

        $('input[name="timeSt"]').val(timeSt);
        $('input[name="timeEnd"]').val(timeEnd);
        $('input[name="userId"]').val(userId);
        $('input[name="interfaceId"]').val(interfaceId);
        $('input[name="messageType"]').val(messageType);
        $("#php_search").submit();

    }

    !function(){
        laydate.skin('yalan');//切换皮肤，请查看skins下面皮肤库
        laydate({elem: '#demo'});//绑定元素
    }();


    function enterTimeFilter(timeType,currentTime){
        if(timeType === 1){
            timeSt = currentTime;
        }

        if(timeType === 2){
            timeEnd = currentTime;
        }
    }


    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Not Found'},
        '.chosen-select-width'     : {width:"95%"},
        '.chosen-select-float'     : {float:"left"}
    };

    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

</script>
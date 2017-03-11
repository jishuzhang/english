<div class="wrapper">
    <div class="mcontent">
        <div class="content_t">
            <h4>监控内容</h4>
        </div>
        <div class="content_x">
            <ul>
                <li><input id="title" class="form-control" type="text" value="所属应用" maxlength="20" name="info[title]"></li>
                <li><input id="title" class="form-control" type="text" value="所属版本" maxlength="20" name="info[title]"></li>
                <li><input id="title" class="form-control" type="text" value="接口" maxlength="20" name="info[title]"></li>
                <li><input id="title" class="form-control" type="text" value="监控结果" maxlength="20" name="info[title]"></li>
                <li style="width:120px;">
                    <select name="form[template]" id="template" class="form-control" style="width:120px;"><option value="">短信发送时间</option><option value="">邮件发送时间</option></select>
                </li>
                <li style="width:170px;"><div class="box">
                        <div class="demo2">
                            <input placeholder="请输入日期" style="height:34px;width:170px;" class="laydate-icon" onClick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                        </div>
                    </div></li>
                <li style="width:170px;"><div class="box">
                        <div class="demo2">
                            <input placeholder="请输入日期" style="height:34px;width:170px;" class="laydate-icon" onClick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                        </div>
                    </div></li>
                <li><input class="btn btn-info" type="submit" value="搜索" name="submit"></li>
            </ul>
        </div>
        <div class="content_z">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th class="tablehead">id</th>
                    <th class="tablehead">用户名</th>
                    <th class="tablehead">应用</th>
                    <th class="tablehead">版本</th>
                    <th class="tablehead">类别</th>
                    <th class="tablehead">接口</th>
                    <th class="tablehead">url</th>
                    <th class="tablehead">发送短信内容</th>
                    <th class="tablehead">发送邮件内容</th>
                    <th class="tablehead">是否发送成功</th>
                    <th class="tablehead">发送短信时间</th>
                    <th class="tablehead">发送邮件时间</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="res/js/laydate.js"></script>
<script>
    !function(){
        laydate.skin('yalan');//切换皮肤，请查看skins下面皮肤库
        laydate({elem: '#demo'});//绑定元素
    }();

    //日期范围限制
    var start = {
        elem: '#start',
        format: 'YYYY-MM-DD',
        min: laydate.now(), //设定最小日期为当前日期
        max: '2099-06-16', //最大日期
        istime: true,
        istoday: false,
        choose: function(datas){
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };

    var end = {
        elem: '#end',
        format: 'YYYY-MM-DD',
        min: laydate.now(),
        max: '2099-06-16',
        istime: true,
        istoday: false,
        choose: function(datas){
            start.max = datas; //结束日选好后，充值开始日的最大日期
        }
    };
    laydate(start);
    laydate(end);

    //自定义日期格式
    laydate({
        elem: '#test1',
        format: 'YYYY年MM月DD日',
        festival: true, //显示节日
        choose: function(datas){ //选择日期完毕的回调
            alert('得到：'+datas);
        }
    });

    //日期范围限定在昨天到明天
    laydate({
        elem: '#hello3',
        min: laydate.now(-1), //-1代表昨天，-2代表前天，以此类推
        max: laydate.now(+1) //+1代表明天，+2代表后天，以此类推
    });
</script>
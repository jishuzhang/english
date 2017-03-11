<?php
use yii\widgets\ActiveForm;
$app_id = $_SESSION['app_id'];
$user_id = yii::$app->user->identity->id;
$index_appurl = Yii::$app->db->createCommand('SELECT * FROM application WHERE app_id = "'.$app_id.'"')->queryOne();//根地址
//有参数的时候
$get_all = Yii::$app->request->get();
if(!empty($get_all['interface_id']))
{
    $sql_one = 'SELECT * FROM interface WHERE interface_id = '.$get_all['interface_id'];//接口
    $index = Yii::$app->db->createCommand($sql_one)->queryOne();//接口名称
    $int_typeid = $index['interface_type_id'];//接口类型id
    $int_vicionid = $index['interface_vision_id'];//接口版本id
    $index_type = Yii::$app->db->createCommand('SELECT * FROM interface_type WHERE interface_type_id = '.$int_typeid)->queryOne();//类别
    $index_vision = Yii::$app->db->createCommand('SELECT * FROM interface_vision WHERE interface_vision_id ='.$int_vicionid)->queryOne();//版本
    $canshu_arr = Yii::$app->db->createCommand('SELECT * FROM interface_required WHERE interface_id = "'.$get_all['interface_id'].'"')->queryAll();//参数
    $index_appurl = Yii::$app->db->createCommand('SELECT * FROM application WHERE app_id = "'.$app_id.'"')->queryOne();//根地址
}
?>
<div class="wrapper">
    <div class="content">
        <div class="left">
            <div class="left01">
                <ul>
                    <li>
                        <span>接口版本</span>
                        <select name="form[app_id]" id="app_id" onchange="Ajax_jiekou();"  class="form-control" style="width:250px;">
                            <?php
                            if(!empty($index_vision)){
                                echo '<option selected="selected" value="'.$index_vision['interface_vision_id'].'">'.$index_vision['vision'].'</option>';
                            }  else {
                                echo '<option selected="selected" value="">请选择</option>';
                            }
                            //end
                            ?>


                            <?php
                            if(!empty($vision_arr)){
                                foreach ($vision_arr as $vision_val){
                                    ?>
                                    <option value="<?=$vision_val['interface_vision_id']?>"><?= $vision_val['vision']?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <span>接口类别</span>
                        <select name="form[type_id]" id="api_type" class="form-control" style="width:250px;"  onchange="Ajax_type();">
                            <?php
                            if(!empty($index_type)){
                                echo '<option selected="selected" value="'.$index_type['interface_type_id'].'">'.$index_type['title'].'</option>';
                            }  else {
                                echo '<option selected="selected" value="">请选择</option>';
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <span>接口名称</span>
                        <select name="form[title]" id="api_title" class="form-control" style="width:250px;" onchange="Ajax_title()" >
                            <?php
                            if(!empty($index)){
                                echo '<option selected="selected" value="'.$index['interface_id'].'">'.$index['title'].'</option>';
                            }  else {
                                echo '<option selected="selected" value="">请选择</option>';
                            }
                            ?>

                        </select>
                    </li>
                </ul>
            </div>
            <table>
                <tbody id="can">
                <tr>
                    <td>参数名称</td>
                    <td>参数值</td>
                </tr>
                <?php
                if(!empty($canshu_arr)){
                    $new_appurl ='';
                    foreach ($canshu_arr as $val){
                        echo    '<tr>
                                <td>'.$val['parameter'].'</td>
                                <td><input id="title"  class="form-control" type="text" value="'.$val['default'].'" maxlength="20" name="info[val]"></td>
                            </tr>';
                        $new_appurl .= $val['parameter'].'='.$val['default'].'&';
                    }

                }
                ?>

                </tbody>
            </table>
            <div class="left02">
                <ul>
                    <li><span>根地址</span>
                        <select name="form[template]" id="url_text" class="form-control" style="width:250px;">
                            <?php
                            if(!empty($app_id)){
                                echo '<option value="'.$index_appurl["title"].'">'.$index_appurl["interface_address"].'</option>';
                            }  else {
                                echo '<option selected="selected" value="">请选择</option>';
                            }
                            ?>                        </select>
                    </li>
                </ul>
                <input id="log" class="btn btn-info mysubmit col_bao_02 " type="submit" value=" 发 送 " name="submit" onclick="Ajax_create()">
                <h4>url参数</h4>
                <div class="l01">
                    <?php
                    if(!empty($canshu_arr)){
                        $new_appurlstr = substr($new_appurl,0,strlen($new_appurl)-1);
                        $new_url = $index_appurl["interface_address"].'/'.$index_vision['vision'].'/'.$index['title'].'?'.$new_appurlstr;
                        echo '<input id="zht"  type="text" value="'.$new_url.'" style=" display: none;" >';
                        echo '<input id="title_can" class="form-control" type="text" value="" name="info[title]">';
                    }elseif(!empty ($index['title'])){
                        $new_url = $index_appurl["interface_address"].'/'.$index_vision['vision'].'/'.$index['title'];
                        echo '<input id="zht"  type="text" value="'.$new_url.'" style=" display: none;" >'
                        . '<input id="title_can" class="form-control" type="text" value="" name="info[title]">';
                    }else{
                        echo '<input id="zht"  type="text" value="" style=" display: none;" >'
                        . '<input id="title_can" class="form-control" type="text" value="" name="info[title]">';
                    }
                    $url = 'http://'.$_SERVER['HTTP_HOST'].'/index.php?r=test%2Findex';
                    ?>

                </div>

                <div class="l02">
                    <a id="aurl_new" href="" target=" _blank"><input class="btn btn-info mysubmit col_bao_02 " type="submit" value="新窗口打开" name="submit"></a>
                    <input class="btn btn-info mysubmit col_bao_02 " type="submit" value="格式化参数" onclick="window.location.href='<?= $url;?>';" name="submit">
                </div>
                <!--                <div class="l03">
                                    <input class="btn btn-info mysubmit col_bao_02 " type="submit" value="返回接口管理" name="submit">
                                </div>-->
            </div>
        </div>
        <div class="right">
            <div class="wrap">
                <div class="nav">
                    <ul>
                        <li class="current">返回结果</li>
                        <li>接口操作日志</li>
                    </ul>
                </div>
            </div>
            <div class="qiehuan">
                <div class="tabWrap">
                    <div class="tabh">
                        <ul>
                            <li class="tanchu01">response header</li>
                            <div class="xianshi01">
                                响应头部信息<br>
                            </div>
                            <li class="tanchu02">response body</li>
                            <div class="xianshi02" >
                                页面返回信息<br>
                            </div>

                        </ul>
                    </div>
                </div>
                <div class="tabWrap">
                    <div class="r01 clearfix">
                        <div class="r001">
                            <input class="btn btn-info mysubmit col_bao_02 " onclick="Delete()" type="submit" value="删除所有选项" name="submit">
                            <input class="btn btn-info mysubmit col_bao_02 " onclick="All_delete()" type="submit" value="清空我的记录" name="submit">
                        </div>

                        <div class="r002">
                            <select name="search[type]" class="type-input" id="search_type">
                                <option value="内容">内容</option>
                                <option value="用户">用户</option>
                            </select>
                            <input id="test_con" type="text" name="search[content]" style="height:34px; line-height:18px;" value="">
                            <button type="submit" class="btn btn-info mysubmit " onclick="Search()"><a style="color: #ffffff" >搜索</a></button>
                        </div>
                    </div>
                    <table class="table table-striped table-advance table-hover rztable">
                        <tbody id="tr">
                        <?php
                        foreach ($log_arr as $val){
                            ?>
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="<?= $val['test_history_id'] ?>"></td>
                                <td><?php echo date('Y-m-d',$val['createtime'])?></td>
                                <td><?=$val['realname']?></td>
                                <td><?=$val['url_pam']?></td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<!--</form>-->

<script type="text/javascript" src="res/js/jquery-1.10.2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.qiehuan .tabWrap').eq(0).css('display','block')
        var myZindex = 0;
        $('.nav ul li').click(function(){
            if (!$(this).hasClass('current')) {
                myZindex++
                $(this).addClass('current').siblings().removeClass('current')

                $('.qiehuan .tabWrap').eq($(this).index()).css('display', 'block').siblings().css('display', 'none');
            };
        })
    })
</script>
<script>
    $(function(){
        $('.tanchu01').click(function(){
            if($(".xianshi01").css("display")=="none"){
                $(".xianshi01").show();
                $(".xianshi02").hide();
            }else{
                $(".xianshi01").hide();
            }    })
    });
    $(function(){
        $('.tanchu02').click(function(){
            if($(".xianshi02").css("display")=="none"){
                $(".xianshi02").show();
                $(".xianshi01").hide();
            }else{
                $(".xianshi02").hide();
            }
        })
    });

    function Ajax_jiekou(){
        var vision_id =$("#app_id").find("option:selected").val();
        var app_id = <?php echo $app_id;?>;
        $("#api_type").html('<option value="" selected="selected">请选择</option>')//接口类别
        $("#api_title").html('<option value="" selected="selected" onclick="Ajax_url()">请选择</option>');//接口名称
        $("#can").html('<tr><td>参数名称</td><td>参数值</td></tr>')//参数
        $("#title_can").val('')//url参数
//        alert(app_id);
        $.ajax({
            type: 'POST',
            url: 'index.php?r=test/testajax',
            datatype : 'json',
            data: {vision_id: vision_id, app_id: app_id},
            success:function(msg){
                if(msg){
                    $("#api_type").html(msg)
                }else{
                    $("#api_type").html('<option value="" selected="selected">请选择</option>')//接口类别
                    $("#api_title").html('<option value="" selected="selected" onclick="Ajax_url()">请选择</option>');//接口名称
                    $("#can").html('<tr><td>参数名称</td><td>参数值</td></tr>')//参数
//                    $("#url_text").html('<option value="">请选择</option>')//根地址
                    $("#title_can").val('')//url参数
                }

            }
        })
    }

    function Ajax_type(){
        var api_vision =$("#app_id").find("option:selected").val();
        var api_type =$("#api_type").find("option:selected").val();
        var app_id = <?php echo $app_id;?>;
        //        alert(app_id);
        $.ajax({
            type: 'POST',
            url: 'index.php?r=test/typeajax',
            datatype : 'json',
            data: {api_type: api_type, api_vision: api_vision, app_id: app_id},
            success:function(msg){
//                alert(msg)
                if(msg){
                    $("#api_title").html(msg)
                }else{
                    $("#api_title").html('<option value="" selected="selected" onclick="Ajax_url()">请选择</option>');
                    $("#can").html('<tr><td>参数名称</td><td>参数值</td></tr>')
                    $("#title_can").val('')

                }

            }
        })
    }

    function Ajax_title(){
        var api_title =$("#api_title").find("option:selected").val();
        var title =$("#api_title").find("option:selected").text();//
        var app_id = <?php echo $app_id;?>;
//        alert(title);
        $.ajax({
            type: 'POST',
            url: 'index.php?r=test/titleajax',
            datatype : 'json',
            data: {api_title: api_title, app_id: app_id, title: title},
            success:function(msg){
//                alert(msg)
                if(msg){
                    $("#can").html(msg)
                }else{
                    $("#can").html('<tr><td>参数名称</td><td>参数值</td></tr>')
                    $("#title_can").val('')
                }

            }
        })
    }

    function Ajax_url(){
        var app_id = <?php echo $app_id;?>;
        var api_type =$("#api_type").find("option:selected").val();
        var title =$("#api_title").find("option:selected").val();//
//        alert(title);
        $.ajax({
            type: 'POST',
            url: 'index.php?r=test/urlajax',
            datatype : 'json',
            data: {title: title, app_id: app_id, api_type: api_type},
            success:function(msg){
//                alert(msg)
                if(msg){
                    $("#url_text").html(msg)
                }else{
//                    $("#url_text").html('<option value="">请选择</option>')
                }

            }
        })
    }

    $('#api_title').change(function(){
        var title =$("#url_text").find("option:selected").text();//跟地址
        var api_title =$("#api_title").find("option:selected").val();//接口名称ID
        var url_text = $("#url_text").find("option:selected").val();//应用名称
        var api_vision = $("#app_id").find("option:selected").text();//版本
        var api_title_text =$("#api_title").find("option:selected").text();//接口名称

        if(title!=="请选择"){
            $.ajax({
                type: 'POST',
                url: 'index.php?r=test/jumpajax',
                datatype : 'json',
                data: { api_title: api_title },
                success:function(data){
                    data = JSON.parse(data);
                    var  url_can_val='';
                    $.each(data,function(key,val){
                        url_can_val += val.parameter+'='+val.default+'&'
                    });
                    var   leng =  url_can_val.length-1;
                          url_can_val = url_can_val.substring(0,leng);//去除最后一个字符‘&’
                    if(url_can_val)
                    {
                        var   new_url = title+'/'+api_vision+'/'+api_title_text+'?'+url_can_val;
                        $("#aurl_new").attr('href',new_url);
//                        $("#title_can").val(new_url);
                        $("#zht").val(new_url);
                    }else if(title && api_title_text!=="请选择"){
                        var   new_url = title+'/'+api_vision+'/'+api_title_text;
                        $("#aurl_new").attr('href',new_url);
                        $("#zht").val(new_url);
                    }
                }
            })

        }else{
            $("#title_can").val('');
        }

    })


    function Ajax_create(){
        var title =$("#url_text").find("option:selected").text();//跟地址
        var api_title =$("#api_title").find("option:selected").val();//接口名称ID
        var url_text = $("#url_text").find("option:selected").val();//应用名称
        var api_vision = $("#app_id").find("option:selected").text();//版本名称
        var api_vision_id =$("#app_id").find("option:selected").val();//版本id
        var api_title_text =$("#api_title").find("option:selected").text();//接口名称
        var app_id = <?php echo $app_id;?>;//应用ID
        var user_id = <?php echo $user_id;?>;//用户id
        var api_type_id = $("#api_type").find("option:selected").val();//类型id
        if($("#zht").val()==""){
            var url_can =  $("#title_can").val();//url参数
        }else{
            url_can = $("#zht").val();
            $("#title_can").val($("#zht").val());
        }
        
        if(title!=="请选择"){
            $.ajax({
                type: 'POST',
                url: 'index.php?r=test/createajax',
                datatype : 'json',
                data: { title:title, api_title:api_title, url_text:url_text, api_vision: api_vision, api_title_text: api_title_text, app_id: app_id, api_vision_id:api_vision_id, api_type_id:api_type_id, url_can:url_can, user_id:user_id},
                success:function(data){  // alert(data)
                    if(data){
                        $('.tabh').html(data) ;
                    }else{
                        $(".tabh").html('<ul><li class="tanchu01">response header</li><div class="xianshi01">响应头部信息<br></div><li class="tanchu02">response body</li><div class="xianshi02">页面返回信息<br><br></div></ul>')
                    }
                    $(function(){
                        $('.tanchu01').click(function(){
                            if($(".xianshi01").css("display")=="none"){
                                $(".xianshi01").show();
                                $(".xianshi02").hide();
                            }else{
                                $(".xianshi01").hide();
                            }    })
                    });
                    $(function(){
                        $('.tanchu02').click(function(){
                            if($(".xianshi02").css("display")=="none"){
                                $(".xianshi02").show();
                                $(".xianshi01").hide();
                            }else{
                                $(".xianshi02").hide();
                            }
                        })
                    });
                }
            });
        }
    }

    function Search(){
        var test_con = $("#test_con").val();
        var search_type =$("#search_type").find("option:selected").text();//搜索类型
        test_con = $.trim(test_con);
        if(!test_con)
        {
            alert('请输入需要查询的内容');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: 'index.php?r=test/searchajax',
            datatype : 'json',
            data : {test_con:test_con, search_type:search_type},
            success: function(data){
//                alert(data)
                if(data){
                    $("#tr").html(data);
                }
            }
        })
    }

    function Delete(){
        var chk_value =[];//定义一个数组
        $('input[type="checkbox"]:checked').each(function(){//遍历每一个名字为interest的复选框，其中选中的执行函数
            chk_value.push($(this).val());//将选中的值添加到数组chk_value中
        });

        if(chk_value != ''){
            if(confirm('你正在批量删除接口操作日志\n删除后不可进行还原，您是否继续?')){
                $.ajax({
                    type: 'POST',
                    url: 'index.php?r=test/delete',
                    datatype : 'json',
                    data: {test_history_id:chk_value},
                    success:function(msg){
                        if(msg==1){
                            alert('批量删除成功');
                            window.location.reload()
                        }else if(msg==0){
                            alert('批量删除失败');
                        }else{
                            alert(msg);
                        }
                    }
                })
            }
        }else{
            alert('请选择需要删除的选项');
        }

    }
    function All_delete(){
        var chk_value =[];//定义一个数组
        $('input[type="checkbox"]').each(function(){//遍历每一个名字为interest的复选框，其中选中的执行函数
            chk_value.push($(this).val());//将选中的值添加到数组chk_value中
        });
        if(chk_value != ''){
            if(confirm('你清空所有接口操作日志\n删除后不可进行还原，您是否继续?')){
                $.ajax({
                    type: 'POST',
                    url: 'index.php?r=test/all_delete',
                    datatype : 'json',
                    data: {test_history_id:chk_value},
                    success:function(msg){
                        if(msg==1){
                            alert('批量删除成功');
                            window.location.reload()
                        }else if(msg==0){
                            alert('批量删除失败');
                        }else{
                            alert(msg);
                        }
                    }
                })
            }
        }

    }

    $("#log").click( function(){
        var title_can = $("#title_can").val();//url
        var api_title_text =$("#api_title").find("option:selected").text();//接口名称
        var userid = <?=$user_id?>;
        
        if(title_can && api_title_text!=="请选择"){
            $.ajax({
                type: 'POST',
                url: 'index.php?r=test/ajax_log',
                datatype : 'json',
                data: {userid:userid},
                success:function(data){
                    $("#tr").html(data); 
                }
            })
        }
                
    })
</script>
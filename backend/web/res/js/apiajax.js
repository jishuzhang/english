/*共用添加后更改 option*/
var html = '<script type="text/javascript">';
html += 'var config = {".chosen-select" : {},".chosen-select-deselect"  : {allow_single_deselect:true},".chosen-select-no-single" : {disable_search_threshold:10},".chosen-select-no-results": {no_results_text:"Oops, nothing found!"},".chosen-select-width"    : {width:"95%"},".chosen-select-float"    : {float:"left"}};for (var selector in config) { $(selector).chosen(config[selector]); };';
html += '<\/script> <option value="0" selected="selected">全部</option>';

/*添加版本ajax*/
function  Visions(){
    var dispaly = $(".tj1").css("display");//是不是显示可输入框
    if (dispaly == 'block') {
        var vision = $("#vision").val();  //版本的名字
        $.post('index.php?r=apiajax/addvision', {vision: vision}, function (msg) {
            if(msg == 2){
                alert('插入错误');
            } else if(msg == 3){
                alert('重复插入,或参数错误');
            } else if(msg == 4) {
                alert('没有权限');
            }else{
                var arr=JSON.parse(msg);
                var str = '';
                $.each(arr,function(index,item) {
                    str += '<li><i value="'+ item['interface_vision_id'] + '" id="vision_'+ item['interface_vision_id'] + '" >' + item['vision'] + '</i><div class="cz"><a title="编辑" href="javascript:;"><span onclick="Visionedit(' + item['interface_vision_id'] + ')"  class="glyphicon glyphicon-edit"></span></a> <a title="删除" href="javascript:;"><span onclick="Delvision(' + item['interface_vision_id'] + ')" class="glyphicon glyphicon-trash"></span></a></div></li>';

                    //类别select框
                    html += '<option value="'+item['interface_vision_id']+'">'+item['vision']+'</option>';

                });
                $("#vision_ul").html(str);
                //动态添加类型select
                $('#banben').html('');
                $('#banben').html(html);
                $(".chosen-select").trigger("chosen:updated");
            }
        });
    }
}
/*删除版本ajax*/
function Delvision (visionid){
    if(confirm("确定删除吗？")) {
        if (visionid) {
            $.post('index.php?r=apiajax/delvision', {interface_vision_id: visionid}, function (msg) {
                if(msg == 1){
                    window.location.href = 'index.php?r=appmanager/index';
                }else if(msg == 2) {
                    alert('删除失败');
                } else if (msg == 3) {
                    alert('参数不正确');
                } else if (msg == 4) {
                    alert('没有权限');
                }
            });
        }
    }
}
/*编辑版本点击事件及ajax */
function Visionedit(id){
    var vision = $("#vision_"+id).text();
    $("#vision_"+id).html("<input type='text' name='' id='v_"+ id +"'"+ "value='"+ vision +"' style='margin: 2px;height: 25px;width: 120px;'>");
    $("#v_"+id).blur(function(){
        var vision = $("#v_"+id).val();
        if(vision != ''){
            $.post('index.php?r=apiajax/updvision', {interface_vision_id: id, vision: vision}, function (msg) {
                if(msg == 1){
                    $("#vision_"+id).html(vision);
                }else if(msg == 4){
                    alert('没有权限');
                }else if(msg == 2){
                    alert('更新失败');
                    $("#vision_"+id).html($('#v_'+id).val());
                }else{
                    alert('参数错误');
                }
            });
        }else{
            alert('请输入版本信息');
        }
    });

}
/**************************************************类别信息********************************************************/
/*添加类别信息*/
function Typeadd(){
    var interface_vision_id = $("#interface_vision_id").val();//版本id
    var dispaly = $(".tj2").css("display");//是不是显示可输入框
    if (dispaly == 'block') {
        var type = $("#type").val();  //类别的名字
        $.post('index.php?r=apiajax/addtype', {type: type, interface_vision_id: interface_vision_id}, function (msg) {
            if(msg == 2){
                alert('插入错误');
            } else if(msg == 3){
                alert('重复插入,或参数错误');
            } else if(msg == 4) {
                alert('没有权限');
            }else{
                var arr=JSON.parse(msg);
                var str = '';
                $.each(arr,function(index,item) {
                    str += '<li><i value="'+ item['interface_type_id'] + '" id="type_'+ item['interface_type_id'] + '">' + item['title'] + '</i><div class="cz"><a title="编辑" href="javascript:;"><span onclick="Typeedit(' + item['interface_type_id'] + ')"  class="glyphicon glyphicon-edit"></span></a> <a title="删除" href="javascript:;"><span onclick="Typedel(' + item['interface_type_id'] + ')" class="glyphicon glyphicon-trash"></span></a></div></li>';
                    //类别select框
                    html += '<option value="'+item['interface_type_id']+'">'+item['title']+'</option>';
                });
                $("#type_ul").html(str);
                //动态添加类型select
                $('#user').html('');
                $('#user').html(html);
                $(".chosen-select").trigger("chosen:updated");
            }
        });
    }
}
/*修改类别信息*/
function Typeedit(id){
    var type = $("#type_"+id).text();
    var interface_vision_id = $("#interface_vision_id").val();//版本id
    $("#type_"+id).html("<input type='text' name='' id='t_"+ id +"'"+ "value='"+ type +"' style='margin: 2px;height: 25px;width: 120px;'>");
    $("#t_"+id).blur(function(){
        var type = $("#t_"+id).val();
        if(type != ''){
            $.post('index.php?r=apiajax/updtype', {interface_vision_id: interface_vision_id, title: type,interface_type_id:id}, function (msg) {
                if(msg == 1){
                    $("#type_"+id).html(type);
                }else if(msg == 4){
                    alert('没有权限');
                }else if(msg == 2){
                    alert('更新失败');
                    $("#type_"+id).html($('#t_'+id).val());

                }else{
                    alert('参数错误');
                }
            });
        }else{
            alert('请输入版本信息');
        }
    });
}
/*删除类别信息*/
function Typedel(interface_type_id){
    if(confirm("确定删除吗？")) {
        if (interface_type_id) {
            $.post('index.php?r=apiajax/deltype', {
                interface_type_id: interface_type_id
            }, function (msg) {
                if(msg == 1){
                    window.location.href = 'index.php?r=appmanager/index';
                }else if(msg == 2) {
                    alert('删除失败');
                } else if (msg == 3) {
                    alert('参数不正确');
                } else if (msg == 4) {
                    alert('没有权限');
                }
            });
        }
    }
}
/**************************************************接口名称********************************************************/
/*添加接口名称*/
function Apiadd(){
    var interface_type_id  = $("#interface_type_id").val();//接口类型id
    var interface_vision_id = $("#interface_vision_id").val();//版本id
    var dispaly = $(".tj3").css("display");//是不是显示可输入框
    if (dispaly == 'block') {
        var api_title = $("#api_title").val();  //类别的名字
        $.post('index.php?r=apiajax/addapi', {api_title: api_title,interface_type_id: interface_type_id, interface_vision_id: interface_vision_id}, function (msg) {
            if(msg == 2){
                alert('插入错误');
            } else if(msg == 3){
                alert('重复插入,或参数错误');
            } else if(msg == 4) {
                alert('没有权限');
            }else{
                var arr=JSON.parse(msg);
                var str = '';
                $.each(arr,function(index,item) {
                    str += '<li><i onclick="jk_ul_li_i('+item['interface_id']+',this)" value="'+ item['interface_id'] + '" id="interface_'+ item['interface_id'] + '">' + item['title'] + '</i><div class="cz"><a title="编辑" href="javascript:;"><span onclick="Apiedit(' + item['interface_id'] + ')"  class="glyphicon glyphicon-edit"></span></a> <a title="删除" href="javascript:;"><span onclick="Apidel(' + item['interface_id'] + ')" class="glyphicon glyphicon-trash"></span></a></div></li>';
                    //类别select框
                    html += '<option value="'+item['interface_type_id']+'">'+item['title']+'</option>';
                });
                $("#api_ul").html(str);

                //动态添加类型select
                $('#jkname').html('');
                $('#jkname').html(html);
                $(".chosen-select").trigger("chosen:updated");
            }
        });
    }
}
/*修改接口*/
function Apiedit(id){
    var interface_title = $("#interface_"+id).text();
    var interface_vision_id = $("#interface_vision_id").val();//版本id
    var interface_type_id = $("#interface_type_id").val();//类型id
    $("#interface_"+id).html("<input type='text' name='' id='api_"+ id +"'"+ "value='"+ interface_title +"' style='margin: 2px;height: 25px;width: 120px;'>");
    $("#api_"+id).blur(function(){
        var interface_title = $("#api_"+id).val();
        if(interface_title != ''){
            $.post('index.php?r=apiajax/updapi', {interface_id:id,interface_vision_id: interface_vision_id, title: interface_title,interface_type_id:interface_type_id}, function (msg) {
                if(msg == 1){
                    $("#interface_"+id).html(interface_title);
                    jk_ul_li_i(id,this);
                }else if(msg == 2){
                    alert('更新失败');
                    $("#interface_"+id).html($('#api_'+id).val());
                }else if(msg == 4){
                    alert('没有权限');
                }else{
                    alert('参数错误');
                }
            });
        }else{
            alert('请输入版本信息');
        }
    });
}
/*删除接口*/
function Apidel(interface_id){
    if(confirm("确定删除吗？")) {
        var interface_type_id = $("#interface_type_id").val();//类型id
        if (interface_id) {
            $.post('index.php?r=apiajax/delapi', {
                interface_type_id: interface_type_id,
                interface_id: interface_id
            }, function (msg) {
                if(msg == 1){
                    window.location.href = 'index.php?r=appmanager/index';
                }else if(msg == 2) {
                    alert('删除失败');
                } else if (msg == 3) {
                    alert('参数不正确');
                } else if (msg == 4) {
                    alert('没有权限');
                }
            });
        }
    }
}
/**************************************************请求参数********************************************************/

/*请求参数*/
function Request(){
    //获取接口的id
    var interface_id = $('#interface_id').val();
    var arr;
    var arr1;
    var arr2 = new Array();
    $("#request tr:last").find("td").each(function(){
        arr1 = $(this).children().attr("name");
        arr = $(this).children().val();
        if(arr1 == 'mandatory' || arr1 == 'format'){
            if($("#"+arr1).prop("checked")){arr = 1;}else{}
        }
        arr2[arr1]=arr;
    });
    if(arr2['parameter'] != ''&& interface_id != ''&& arr2['default'] != ''){
        $.post('index.php?r=apiajax/required', { interface_id:interface_id,default: arr2['default'],format:arr2['format'],mandatory: arr2['mandatory'],parameter:arr2['parameter'],sample:arr2['sample'],type:arr2['type']}, function (msg) {
            if(msg == 1) {
                alert('参数不正确');
            }else if(msg == 2){
                alert('插入失败');
            } else if (msg == 4) {
                alert('没有权限');
            }else{
                $("#request_list").html(msg);
            }
        });
    }else{
        alert('参数不能为空或默认值不能为空');
    }
}
/*删除参数*/
function Delrequest(required_id){
    if(confirm("确定删除吗？")) {
        var interface_id = $('#interface_id').val();
        $.post('index.php?r=apiajax/delrequest', {
            interface_id: interface_id,
            required_id: required_id
        }, function (msg) {
            if (msg == 1) {
                alert('参数不正确');
            } else if (msg == 2) {
                alert('删除错误 ');
            } else if (msg == 4) {
                alert('没有权限');
            } else {
                $("#request_list").html(msg);
            }
        });
    }
}
/*请求参数修改*/

$('body').on("change", '#request_list>tr>td', function () {

    var interface_id = $('#interface_id').val();
    var required_id = $(this).parent().attr('val');//请求id
    var par = $(this).children().val();//参数
    var type = $(this).children().attr('name');//是哪个框中的

    if(required_id!= undefined){
        $.post('index.php?r=apiajax/updatereq',{
            interface_id:interface_id,
            required_id:required_id,
            par:par,
            type:type
        },function(data){
            if(data == 1) {
                alert('参数不正确');
            }else if(data == 2){
                alert('更新失败');
            } else if (msg == 4) {
                alert('没有权限');
            }else{
                $("#request_list").html(data);
            }
        });
    }
});

/******************************************************************返回参数*****************************************************/
/*添加返回参数*/
function Back(){
    var interface_id = $('#interface_id').val();

    var arr2 = new Array();
    var arr;var arr1;
    $("#back_list tr:last").find("td").each(function(){
        arr = $(this).children().val();
        arr1 = $(this).children().attr("name");
        arr2[arr1]=arr;
    });
    if(arr2['parameter'] !='' && interface_id != '' && arr2['sample'] != '' && arr2['type'] != ''){
        $.post('index.php?r=apiajax/back', { interface_id:interface_id,description:arr2['description'],parameter:arr2['parameter'],sample:arr2['sample'],type:arr2['type']}, function (msg) {
            if(msg == 1) {
                alert('参数不正确');
            } else if (msg == 4) {
                alert('没有权限');
            }else{
                $("#back_list").html(msg);
            }
        });
    }else{
        alert('返回参数不能为空');
    }
}

/*修改返回参数*/

$('body').on("change", '#back_list>tr>td', function () {

    var interface_id = $('#interface_id').val();
    var back_id = $(this).parent().attr('val');//请求id
    var par = $(this).children().val();//参数
    var type = $(this).children().attr('name');//是哪个框中的

    if(back_id != undefined){
        $.post('index.php?r=apiajax/updateback',{
            interface_id:interface_id,
            back_id:back_id,
            par:par,
            type:type
        },function(data){
            if(data == 1) {
                alert('参数不正确');
            }else if(data == 2){
                alert('更新失败');
            } else if (msg == 4) {
                alert('没有权限');
            }else{
                $("#back_list").html(data);
            }
        });
    }
});



/*删除返回参数*/
function Delback(back_id){
    if(confirm("确定删除吗？")) {
        var interface_id = $('#interface_id').val();
        if (back_id == '') {
            alert('你确定要清空该接口的返回参数么？');
        }
        $.post('index.php?r=apiajax/delback', {interface_id: interface_id, back_id: back_id}, function (msg) {
            if (msg == 1) {
                alert('参数不正确');
            } else if (msg == 2) {
                alert('删除错误 ');
            } else if (msg == 4) {
                alert('没有权限');
            } else {
                $("#back_list").html(msg);
            }
        });
    }
}
/*导入json功能*/
/*导入json实现，添加的json  有可能只返回 一个信息或者说是参数，有可能是多条信息或参数*/
function Importjson(){
    var interface_id = $('#interface_id').val();
    var importjson = $('#importjson').val();
    if(importjson != ''){
        $.post('index.php?r=apiajax/importjson',{importjson:importjson,interface_id:interface_id}, function (msg) {
            if(msg == 1){
                alert('参数错误');
            }else if(msg == 2){
                alert('插入数据错误');
            } else if (msg == 4) {
                alert('没有权限');
            }else {
                $("#back_list").html(msg);
            }
        });
    }else {
        alert('导入数据为空');
    }
}
/*保存接口信息，添加接口信息，修改接口信息，保存到interface表*/
function Interface(){
    var api_name = $('#api_name').val();//接口名称
    var api_pam_type = $('#api_pam_type').val();//接口数据类型，json,xml
    var api_method = $('#api_method').val();//接口请求方式
    var api_return_sample = $('#api_return_sample').val();//接口返回示例
    var api_description = $('#api_description').val();//接口描述
    var interface_id = $('#interface_id').val();//选中接口id

    if(api_name != '' && api_pam_type != '' && api_method != '' && interface_id != ''){

        $.post('index.php?r=apiajax/interface',{interface_id:interface_id,title:api_name,pam_type:api_pam_type,method:api_method,return_sample:api_return_sample,description:api_description}, function (msg) {
            var item=JSON.parse(msg);
            if(item === 2){
                alert('您没有修改参数');
            } else if (msg == 4) {
                alert('没有权限');
            }else{
                var interface_id = "interface_"+item.interface_id;
                $('#'+interface_id).text(item.title);//接口名称-》接口名
                $('#api_name').val(item.title);//最右边接口名
                $('#api_pam_type').val(item.pam_type);//数据类型
                $('#api_method').val(item.method);//接口请求方式
                $('#api_return_sample').val(item.return_sample);//接口请求方式
                $('#api_description').val(item.description);//接口请求方式
                alert('添加成功');
            }
        });
    }else{
        alert('接口参数不能为空');
    }
}
/**
 * @param type          1、版本    2、类别    3、接口
 * @param condition          搜索的条件
 * @param list          li点击事件传递的参数，li点击事件，调用的是搜索方法
 * @param select          select 框的id的值
 * @constructor
 */
function Search(type,list){
    var condition = $('#'+type+' option:selected').text();//获取当前select框的值
    var face_id = $('#'+type+' option:selected').val();   //select框的value
    var interface_vision_id = $("#interface_vision_id").val();//版本id
    var interface_type_id  = $("#interface_type_id").val();//接口类型id
    var interface_id = $('#interface_id').val();//选中接口id
    if(type != ''){
        /*接口信息搜索*/
        if(list != undefined){
            //li点击事件传参
            $data = {interface_vision_id:interface_vision_id,interface_type_id:interface_type_id,interface_id:interface_id,type:type};
        }else{
            //搜索传递参数
            $data = {interface_vision_id:interface_vision_id,interface_type_id:interface_type_id,interface_id:interface_id,type:type,condition:condition};
        }

        $.post('index.php?r=apiajax/search',$data, function (msg) {
            var item=JSON.parse(msg);
            if($.isArray( item)){
                //li 的值
                var  str = '';
                //有数据的option
                var html = '<script type="text/javascript">';
                html += 'var config = {".chosen-select" : {},".chosen-select-deselect"  : {allow_single_deselect:true},".chosen-select-no-single" : {disable_search_threshold:10},".chosen-select-no-results": {no_results_text:"Oops, nothing found!"},".chosen-select-width"    : {width:"95%"},".chosen-select-float"    : {float:"left"}};for (var selector in config) { $(selector).chosen(config[selector]); };';
                html += '<\/script> <option value="0" selected="selected">全部</option>';

                //清空select
                var empty_option = '<script type="text/javascript">';
                empty_option += 'var config = {".chosen-select" : {},".chosen-select-deselect"  : {allow_single_deselect:true},".chosen-select-no-single" : {disable_search_threshold:10},".chosen-select-no-results": {no_results_text:"Oops, nothing found!"},".chosen-select-width"    : {width:"95%"},".chosen-select-float"    : {float:"left"}};for (var selector in config) { $(selector).chosen(config[selector]); };';
                empty_option += '<\/script>';
                empty_option += "<select class='chosen-select banben' style='float:left;'  name='info[banben]' id='"+ type +"'><option value='0' selected='selected'>全部</option></select>";
                empty_option += ' <button type="button" id="sh2" class="btn btn-info sh" onclick="Search(\''+type+'\')">搜索</button>';


                if(item.length > 0){
                    $.each(item,function(index,item) {

                        if (item.vision != undefined) {
                            str += '<li><i value="'+ item['interface_vision_id'] + '" id="vision_' + item['interface_vision_id'] + '">' + item['vision'] + '</i><div class="cz"><a title="编辑" href="javascript:;"><span onclick="Visionedit(' + item['interface_vision_id'] + ')"  class="glyphicon glyphicon-edit"></span></a> <a title="删除" href="javascript:;"><span onclick="Delvision(' + item['interface_vision_id'] + ')" class="glyphicon glyphicon-trash"></span></a></div></li>';
                            $("#vision_ul").html(str);

                            $("#api_ul").html('');
                            $("#type_ul").html('');
                            $('.addjk').html('');

                            $('#search2').html(empty_option);
                            $('#search3').html(empty_option);

                        } else if (item.return_sample != undefined) {

                            //控制第三个追加
                            $('#search3').html(empty_option);
                            //置空接口详情
                            $('.addjk').html('');

                            //类别select框
                            html += '<option value="'+item['interface_id']+'">'+item['title']+'</option>';

                            //动态添加类型select
                            $('#jkname').html(html);
                            $(".chosen-select").trigger("chosen:updated");

                            //接口名称列表
                            str += '<li><i  value="'+ item['interface_id'] + '" onclick="jk_ul_li_i(' +item['interface_id'] + ',this)" id="interface_' + item['interface_id'] + '">' + item['title'] + '</i><div class="cz"><a title="编辑" href="javascript:;"><span onclick="Apiedit(' + item['interface_id'] + ')"  class="glyphicon glyphicon-edit"></span></a> <a title="删除" href="javascript:;"><span onclick="Apidel(' + item['interface_id'] + ')" class="glyphicon glyphicon-trash"></span></a></div></li>';
                            $("#api_ul").html(str);
                        } else {

                            $('#search2').html(empty_option);

                            //先清空
                            $('#search3').html(empty_option);
                            //置空接口详情
                            $('.addjk').html('');
                            //置空接口名称li
                            $("#api_ul").html('');

                            //类别select框
                            html += ' <option value="'+item['interface_type_id']+'">'+item['title']+'</option>';

                            //动态添加类型select
                            $('#user').html(html);
                            $(".chosen-select").trigger("chosen:updated");

                            //类别列表
                            str += '<li><i value="'+ item['interface_type_id'] + '" id="type_' + item['interface_type_id'] + '">' + item['title'] + '</i><div class="cz"><a title="编辑" href="javascript:;"><span onclick="Typeedit(' + item['interface_type_id'] + ')"  class="glyphicon glyphicon-edit"></span></a> <a title="删除" href="javascript:;"><span onclick="Typedel(' + item['interface_type_id'] + ')" class="glyphicon glyphicon-trash"></span></a></div></li>';

                            $("#type_ul").html(str);
                        }
                    });
                }else{
                    //清空li
                    $("#"+list).html('');
                    $('#'+type).html('');
                    //动态添加类型select
                    if(type == 'user'){
                        $('#search2').html(empty_option);
                        $('#search3').html(empty_option);
                    }else if(type == 'jkname'){
                        $('#search3').html(empty_option);
                    }
                }
            }else if (msg == 4) {
                alert('没有权限');
            }else {
                if (item.vision != undefined) {

                    str = '<li class="hover"><i value="'+ item['interface_vision_id'] + '" id="vision_' + item['interface_vision_id'] + '">' + item['vision'] + '</i><div class="cz"><a title="编辑" href="javascript:;"><span onclick="Visionedit(' + item['interface_vision_id'] + ')"  class="glyphicon glyphicon-edit"></span></a> <a title="删除" href="javascript:;"><span onclick="Delvision(' + item['interface_vision_id'] + ')" class="glyphicon glyphicon-trash"></span></a></div></li>';
                    $("#vision_ul").html(str);

                    // 搜索联动 搜索后，把vision_id 替换到版本信息下的隐藏域
                    $('#interface_vision_id').val(item['interface_vision_id']);

                    //调用搜索，传递点击事件参数，把值放在类别select中
                    Search('user','type_ul');
                    $("#api_ul").html('');
                    $(".addjk").html('');

                } else if (item.return_sample != undefined) {

                    //调用接口名称点击事件，显示接口详情
                    if(face_id > 0){
                        jk_ul_li_i(face_id);  //接口id
                    }

                    str = '<li class="hover" ><i value="'+ item['interface_id'] + '" onclick="jk_ul_li_i(' +item['interface_id'] + ')" id="interface_' + item['interface_id'] + '">' + item['title'] + '</i><div class="cz"><a title="编辑" href="javascript:;"><span onclick="Apiedit(' + item['interface_id'] + ')"  class="glyphicon glyphicon-edit"></span></a> <a title="删除" href="javascript:;"><span onclick="Apidel(' + item['interface_id'] + ')" class="glyphicon glyphicon-trash"></span></a></div></li>';
                    $("#api_ul").html(str);
                } else {
                    str = '<li class="hover" ><i value="'+ item['interface_type_id'] + '" id="type_' + item['interface_type_id'] + '">' + item['title'] + '</i><div class="cz"><a title="编辑" href="javascript:;"><span onclick="Typeedit(' + item['interface_type_id'] + ')"  class="glyphicon glyphicon-edit"></span></a> <a title="删除" href="javascript:;"><span onclick="Typedel(' + item['interface_type_id'] + ')" class="glyphicon glyphicon-trash"></span></a></div></li>';
                    $("#type_ul").html(str);

                    //搜索后，interface_type_id 替换到类别信息下的隐藏域
                    $('#interface_type_id').val(item['interface_type_id']);

                    //调用搜索，传递点击时间参数，把值放在类别select中
                    Search('jkname','api_ul');

                }
            }
        });
    }else{
        alert('搜索条件不符合');
    }
}



/******************************************************(li)点击事件********************************************************/

/**
 * 版本块，li点击事件
 * */
$('body').on("click", '.info>ul li>i', function () {
    $(".info>ul li").removeClass("hover");
    $(this).parent().addClass("hover");
    var app_id = $(this).attr('value');
    $("#interface_vision_id").val(app_id);

    /*调用上边查询版本的方法*/
    Search('user','type_ul');
    $("#api_ul").html('');
    $(".addjk").html('');

});
/**
 * 类别点击事件
 * */
$('body').on("click", '.kind>ul li>i', function () {

    $(".kind>ul li").removeClass("hover");
    $(this).parent().addClass("hover");
    var interface_type_id = $(this).attr('value');
    $("#interface_type_id").val(interface_type_id);

    /*调用上边查询版本的方法*/
    Search('jkname','api_ul');
    $(".addjk").html('');

});
/**
 * 接口名称点击事件
 * @pagram  face_id     接口id
 * */
function jk_ul_li_i(face_id,obj){
    $(".jk>ul li").removeClass("hover");
    $(obj).parent().addClass("hover");
    var interface_vision_id = $("#interface_vision_id").val();//版本id
    var interface_type_id  = $("#interface_type_id").val();//接口类型id
    var interface_id = face_id;
	
    $('.addjk').children().remove();//删除节点
    var url = 'index.php?r=appmanager/list&interface_type_id='+interface_type_id + '&interface_vision_id='+interface_vision_id +'&interface_id='+interface_id;
    $('.addjk').html("<section id='iframecontent'  style='width:100%; margin-left:1%' ><iframe scrolling='no' onLoad='iFrameHeight()' style='width:100%;min-height: 1000px; margin-left:0px' name='iframeid' id='iframeid' frameborder='false' scrolling='auto' allowtransparency='true' frameborder='0' src='index.php?r=appmanager/list&interface_type_id="+url+"' ></iframe></section>");

    //iframe 框架加载完毕调用事件
    $("#iframeid").load(function(){
        frames['iframeid'].$("#interface_id").val(interface_id);//给iframe框架添加点击后的接口的id
        //alert($(window.frames["iframeid"].document).find("#interface_id").val());
    });
}

/**
 * 给测试点击事件，跳转链接追加interface_vision_id
 * */

$(document).on('click', '.buttons>a', function(){
    var interface_id = $('#interface_id').val();
    var interface_vision_id = $('#interface_vision_id', parent.document).val();
    //var interface_vision_id = $('#interface_vision_id').val();
    if(interface_id !== ''){
        var url = $('#get_vision_url').attr('url');
        window.parent.location.href = url + '&interface_id=' + interface_id + '&interface_vision_id=' + interface_vision_id;
    } else if (msg == 4) {
        alert('没有权限');
    }else{
        alert('参数不正确');
    }
});

/**
 * 接口返回示例
 * */
function Return_example(){
    var interface_id = $('#interface_id').val();
    var interface_vision_id = $('#interface_vision_id', parent.document).val();
    if(interface_id && interface_vision_id){
        $.get('index.php?r=apiajax/return_example',{interface_id:interface_id, interface_vision_id:interface_vision_id}, function (data) {
            if (data == 4) {
                alert('没有权限');
            }else{
                //调用json美化
                $("#api_return_sample").val(formatJson(data));
            }
        });
    }
}
//给json字符串进行美化的函数
function formatJson(jsonStr){
    var res="";
    for(var i=0,j=0,k=0,ii,ele;i<jsonStr.length;i++)
    {//k:缩进，j:""个数
        ele=jsonStr.charAt(i);
        if(j%2==0&&ele=="}")
        {
            k--;
            for(ii=0;ii<k;ii++) ele="    "+ele;
            ele="\n"+ele;
        }
        else if(j%2==0&&ele=="{")
        {
            ele+="\n";
            k++;
            for(ii=0;ii<k;ii++) ele+="    ";
        }
        else if(j%2==0&&ele==",")
        {
            ele+="\n";
            for(ii=0;ii<k;ii++) ele+="    ";
        }
        else if(ele=="\"") j++;
        res+=ele;
    }
    return res;
}
//iframe 框自动高度
function iFrameHeight() {

    var ifm= document.getElementById("iframeid");
    var subWeb = document.frames ? document.frames["iframeid"].document :
    ifm.contentDocument;
    if(ifm != null && subWeb != null) {

        ifm.height = subWeb.body.scrollHeight;
        $(".addjk").height( ifm.height);
        $(".bbinfo").height( ifm.height);

    }

}
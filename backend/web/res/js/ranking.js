/**
 * Created by mengbaoqing on 2015/9/7.
 */
function checktitle(rankid){
    if(!rankid){
        $('#title').blur(function(){
            var title = $('#title').val();
            $.post('index.php?r=ranking/checktitle',{title:title},function(data){
                if(data==="ok") {
                    //                alert("没有重复标题");
                } else if(data==="no") {
                    alert("有完全相同的标题存在");
                    $("#title").focus();
                    return false;
                }
            });
        });
    }
}
function univ_check(){
    var univ_str = '';
    $(".univid").each(function(){
        var cur_univ = $(this).val();
        if(cur_univ){
            if(univ_str!=''){ univ_str += ','; }
            $.each(cur_univ, function(){
                univ_str += parseInt(this);
            });
        }
    });
    $(".univ_check").val(univ_str);
}
function chosen_config(){
    //院校中文名select框使用插件配置文件
    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        '.chosen-select-width'     : {width:"80%"}
    };
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
}
function getuniv_ename(univid,current){
    $.ajax({
        type: 'POST',
        url: 'index.php?r=ranking/getunivename',
        datatype : 'json',
        data: '&univid='+univid,
        success: function(data){
//            data = JSON.parse(data);
            current.val(data);
            univ_check();
        }
    });
}
function univid_ename(){
    $(".univid").chosen().change(function(){
        var univid = $(this).val();
        var current = $(this).parent().parent().next().find(".univename");
        if(univid){
            var univ_str = $('.univ_check').val();
            var univ_arr = univ_str.split(',');
            var univ_id = 0;
            var univid_num = 0;
            $(".univid").each(function(){
                if(univid === $(this).val){univid_num = 1;}
            });
            if(univid_num === 1){
                alert('标题重复');
            }else{
                getuniv_ename(univid,current);
            }
        }else{
            current.val('');
            univ_check();
        }
    });
}
function del_check(){ //检查附表数据是否为空，增加“添加”按钮
    var template = $("#template").val();
    var i=$('.del').length;
    if(i==0){
        $('.temp_name').append('<a class="btn btn-info add_one" href="javascript:void(0);" title="添加" onclick="add_temp(\''+template+'\',1)" style="margin-left:20px;">添加</a>');
    }
}
function sel_edit(){
    $(".univ_edit").click(function(){
        $(this).parent().parent().find('.univ_sel').addClass('hide');
        $(this).parent().parent().find('.univtitle').removeClass('hide');
        $(this).parent().parent().find('.univtitle_edit').removeClass('hide');
        $(this).parent().parent().find('.univtitle_edit_update').removeClass('hide');
    });
    $(".univtitle_edit").click(function(){
        $(this).parent().find('.univtitle').addClass('hide');
        $(this).parent().find('.univtitle_edit').addClass('hide');
        $(this).parent().find('.univ_sel').removeClass('hide');
    });
    $(".countryid_edit").click(function(){
        $(this).parent().parent().find('.countryid_sel').addClass('hide');
        $(this).parent().parent().find('.country').removeClass('hide');
        $(this).parent().parent().find('.country_edit').removeClass('hide');
    });
    $(".country_edit").click(function(){
        $(this).parent().find('.country').addClass('hide');
        $(this).parent().find('.country_edit').addClass('hide');
        $(this).parent().find('.countryid_sel').removeClass('hide');
    });
}
function temp1(temptype){
    //模板：通用列表
    var univ_options = $(".univ_options").val();
    if(temptype==='div'){
        var temp = '<div><div class="temp_name"><span>通用列表</span></div><div class="temp_con"><table class="table table-striped table-bordered table-hover"><thead><tr class="bg_col"><th>排名</th><th style="width:30%">院校中文名</th><th>院校英文名</th><th>操作</th></tr></thead><tbody class="tbody-cls"><tr><td><input type="text" name="form[ranking]" class="temp-width ranking"></td><td><input type="text" name="form[univtitle]" class="temp-width univtitle hide"><img src="res/images/edit.png" title="选择院校" alt="选择院校" class="univtitle_edit hide"><span class="univ_sel"><select  class="width-80 chosen-select univid" data-placeholder="选择院校..." name="form[univid]"><option value="">&nbsp;</option>'+univ_options+'</select><img src="res/images/edit.png" title="手动输入" alt="手动输入" class="univ_edit"></span></td><td><input type="text" name="form[univename]" class="temp-width univename"></td><td align="center"><input type="hidden" class="curr_id"><a class="btn btn-info btn-xs save" href="javascript:void(0);" title="保存并添加" onclick="save(this)">保存并添加</a><a class="btn btn-danger btn-xs del" href="javascript:void(0);" title="删除" onclick="del(this)">删除</a></td></tr></tbody></table></div></div>';
        return temp;
    }
    if(temptype==='tr'){
        var temp = '<tr><td><input type="text" name="form[ranking]" class="temp-width ranking"></td><td><input type="text" name="form[univtitle]" class="temp-width univtitle hide"><img src="res/images/edit.png" title="选择院校" alt="选择院校" class="univtitle_edit hide"><span class="univ_sel"><select class="width-80 chosen-select univid" data-placeholder="选择院校..." name="form[univid]"><option value="">&nbsp;</option>'+univ_options+'</select><img src="res/images/edit.png" title="手动输入" alt="手动输入" class="univ_edit"></span></td><td><input type="text" name="form[univename]" class="temp-width univename"></td><td align="center"><input type="hidden" class="curr_id"><a class="btn btn-info btn-xs saveadd" href="javascript:void(0);" title="保存并添加" onclick="saveadd(this)">保存并添加</a><a class="btn btn-danger btn-xs del" href="javascript:void(0);" title="删除" onclick="del(this)">删除</a></td></tr>';
        return temp;
    }
}
function temp2(temptype){
    //模板：QS世界大学
    var univ_options = $(".univ_options").val();
    var country_options = $(".country_options").val();
    if(temptype==='div'){
        var temp = '<div><div class="temp_name"><span>QS世界大学</span></div><div class="temp_con"><table class="table table-striped table-bordered table-hover"><thead><tr class="bg_col"><th>排名</th><th style="width:30%">院校中文名</th><th>院校英文名</th><th style="width:20%">所属国家</th><th>总分</th><th>操作</th></tr></thead><tbody class="tbody-cls"><tr><td><input type="text" name="form[ranking]" class="temp-width ranking"></td><td><input type="text" name="form[univtitle]" class="temp-width univtitle hide"><img src="res/images/edit.png" title="选择院校" alt="选择院校" class="univtitle_edit hide"><span class="univ_sel"><select  class="width-80 chosen-select univid" data-placeholder="选择院校..." name="form[univid]"><option value="">&nbsp;</option>'+univ_options+'</select><img src="res/images/edit.png" title="手动输入" alt="手动输入" class="univ_edit"></span></td><td><input type="text" name="form[univename]" value="" class="temp-width univename"></td><td><input type="text" class="temp-width country hide" name="form[country]"><img class="country_edit hide" alt="选择国家" title="选择国家" src="res/images/edit.png"><span class="countryid_sel"><select name="form[countryid]" class="temp-width countryid"><option value="">选择国家...</option>'+country_options+'</select><img class="countryid_edit" alt="手动输入" title="手动输入" src="res/images/edit.png"></span></td><td><input type="text" name="form[score]" class="temp-width score"></td><td align="center"><input type="hidden" class="curr_id"><a class="btn btn-info btn-xs save" href="javascript:void(0);" title="保存并添加" onclick="save(this)">保存并添加</a><a class="btn btn-danger btn-xs del" href="javascript:void(0);" title="删除" onclick="del(this)">删除</a></td></tr></tbody></table></div></div>';
        return temp;
    }
    if(temptype==='tr'){
        var temp = '<tr><td><input type="text" name="form[ranking]" class="temp-width ranking"></td><td><input type="text" name="form[univtitle]" class="temp-width univtitle hide"><img src="res/images/edit.png" title="选择院校" alt="选择院校" class="univtitle_edit hide"><span class="univ_sel"><select class="width-80 chosen-select univid" data-placeholder="选择院校..." name="form[univid]"><option value="">&nbsp;</option>'+univ_options+'</select><img src="res/images/edit.png" title="手动输入" alt="手动输入" class="univ_edit"></span></td><td><input type="text" name="form[univename]" value="" class="temp-width univename"></td><td><input type="text" class="temp-width country hide" name="form[country]"><img class="country_edit hide" alt="选择国家" title="选择国家" src="res/images/edit.png"><span class="countryid_sel"><select name="form[countryid]" class="temp-width countryid"><option value="">选择国家...</option>'+country_options+'</select><img class="countryid_edit" alt="手动输入" title="手动输入" src="res/images/edit.png"></span></td><td><input type="text" name="form[score]" class="temp-width score"></td><td align="center"><input type="hidden" class="curr_id"><a class="btn btn-info btn-xs saveadd" href="javascript:void(0);" title="保存并添加" onclick="saveadd(this)">保存并添加</a><a class="btn btn-danger btn-xs del" href="javascript:void(0);" title="删除" onclick="del(this)">删除</a></td></tr>';
        return temp;
    }
}
function temp3(temptype){
    //模板：其他世界大学
    var univ_options = $(".univ_options").val();
    var country_options = $(".country_options").val();
    if(temptype==='div'){
        var temp = '<div><div class="temp_name"><span>其他世界大学列表</span></div><div class="temp_con"><table class="table table-striped table-bordered table-hover"><thead><tr class="bg_col"><th>排名</th><th style="width:30%">院校中文名</th><th>院校英文名</th><th style="width:20%">所属国家</th><th>操作</th></tr></thead><tbody class="tbody-cls"><tr><td><input type="text" name="form[ranking]" class="temp-width ranking"></td><td><input type="text" name="form[univtitle]" class="temp-width univtitle hide"><img src="res/images/edit.png" title="选择院校" alt="选择院校" class="univtitle_edit hide"><span class="univ_sel"><select class="width-80 chosen-select univid" data-placeholder="选择院校..." name="form[univid]"><option value="">&nbsp;</option>'+univ_options+'</select><img src="res/images/edit.png" title="手动输入" alt="手动输入" class="univ_edit"></span></td><td><input type="text" name="form[univename]" class="temp-width univename"></td><td><input type="text" class="temp-width country hide" name="form[country]"><img class="country_edit hide" alt="选择国家" title="选择国家" src="res/images/edit.png"><span class="countryid_sel"><select name="form[countryid]" class="temp-width countryid"><option value="">选择国家...</option>'+country_options+'</select><img class="countryid_edit" alt="手动输入" title="手动输入" src="res/images/edit.png"></span></td><td align="center"><input type="hidden" class="curr_id"><a class="btn btn-info btn-xs save" href="javascript:void(0);" title="保存并添加" onclick="save(this)">保存并添加</a><a class="btn btn-danger btn-xs del" href="javascript:void(0);" title="删除" onclick="del(this)">删除</a></td></tr></tbody></table></div></div>';
        return temp;
    }
    if(temptype==='tr'){
        var temp = '<tr><td><input type="text" name="form[ranking]" class="temp-width ranking"></td><td><input type="text" name="form[univtitle]" class="temp-width univtitle hide"><img src="res/images/edit.png" title="选择院校" alt="选择院校" class="univtitle_edit hide"><span class="univ_sel"><select class="width-80 chosen-select univid" data-placeholder="选择院校..." name="form[univid]"><option value="">&nbsp;</option>'+univ_options+'</select><img src="res/images/edit.png" title="手动输入" alt="手动输入" class="univ_edit"></span></td><td><input type="text" name="form[univename]" class="temp-width univename"></td><td><input type="text" class="temp-width country hide" name="form[country]"><img class="country_edit hide" alt="选择国家" title="选择国家" src="res/images/edit.png"><span class="countryid_sel"><select name="form[countryid]" class="temp-width countryid"><option value="">选择国家...</option>'+country_options+'</select><img class="countryid_edit" alt="手动输入" title="手动输入" src="res/images/edit.png"></span></td><td align="center"><input type="hidden" class="curr_id"><a class="btn btn-info btn-xs saveadd" href="javascript:void(0);" title="保存并添加" onclick="saveadd(this)">保存并添加</a><a class="btn btn-danger btn-xs del" href="javascript:void(0);" title="删除" onclick="del(this)">删除</a></td></tr>';
        return temp;
    }
}
function temp4(temptype){
    //模板：泰晤士英国大学
    var univ_options = $(".univ_options").val();
    if(temptype==='div'){
        var temp = '<div><div class="temp_name"><span>泰晤士英国大学列表</span></div><div class="temp_con"><table class="table table-striped table-bordered table-hover"><thead><tr class="bg_col"><th>排名</th><th style="width:30%">院校中文名</th><th>院校英文名</th><th>总分</th><th>操作</th></tr></thead><tbody class="tbody-cls"><tr><td><input type="text" name="form[ranking]" class="temp-width ranking"></td><td><input type="text" name="form[univtitle]" class="temp-width univtitle hide"><img src="res/images/edit.png" title="选择院校" alt="选择院校" class="univtitle_edit hide"><span class="univ_sel"><select class="width-80 chosen-select univid" data-placeholder="选择院校..." name="form[univid]"><option value="">&nbsp;</option>'+univ_options+'</select><img src="res/images/edit.png" title="手动输入" alt="手动输入" class="univ_edit"></span></td><td><input type="text" name="form[univename]" value="" class="temp-width univename"></td><td><input type="text" name="form[score]" class="temp-width score"></td><td align="center"><input type="hidden" class="curr_id"><a class="btn btn-info btn-xs save" href="javascript:void(0);" title="保存并添加" onclick="save(this)">保存并添加</a><a class="btn btn-danger btn-xs del" href="javascript:void(0);" title="删除" onclick="del(this)">删除</a></td></tr></tbody></table></div></div>';
        return temp;
    }
    if(temptype==='tr'){
        var temp = '<tr><td><input type="text" name="form[ranking]" class="temp-width ranking"></td><td><input type="text" name="form[univtitle]" class="temp-width univtitle hide"><img src="res/images/edit.png" title="选择院校" alt="选择院校" class="univtitle_edit hide"><span class="univ_sel"><select class="width-80 chosen-select univid" data-placeholder="选择院校..." name="form[univid]"><option value="">&nbsp;</option>'+univ_options+'</select><img src="res/images/edit.png" title="手动输入" alt="手动输入" class="univ_edit"></span></td><td><input type="text" name="form[univename]" value="" class="temp-width univename"></td><td><input type="text" name="form[score]" class="temp-width score"></td><td align="center"><input type="hidden" class="curr_id"><a class="btn btn-info btn-xs saveadd" href="javascript:void(0);" title="保存并添加" onclick="saveadd(this)">保存并添加</a><a class="btn btn-danger btn-xs del" href="javascript:void(0);" title="删除" onclick="del(this)">删除</a></td></tr>';
        return temp;
    }
}
function temp5(temptype){
    //模板：usnews综合
    var univ_options = $(".univ_options").val();
    if(temptype==='div'){
        var temp = '<div><div class="temp_name"><span>usnews综合列表</span></div><div class="temp_con"><table class="table table-striped table-bordered table-hover"><thead><tr class="bg_col"><th style="width:6%">排名</th><th style="width:17%">院校中文名</th><th style="width:9%">院校英文名</th><th style="width:7%">学杂费</th><th style="width:10%">申请截止日期</th><th style="width:8%">SAT/ACT</th><th style="width:7%">录取录</th><th style="width:8%">总人数</th><th style="width:8%">学生人数</th><th style="width:8%">男女比例</th><th style="width:10%">操作</th></tr></thead><tbody class="tbody-cls"><tr><td><input type="text" name="form[ranking]" class="temp-width ranking"></td><td><input type="text" name="form[univtitle]" class="temp-width univtitle hide"><img src="res/images/edit.png" title="选择院校" alt="选择院校" class="univtitle_edit hide"><span class="univ_sel"><select class="width-80 chosen-select univid" data-placeholder="选择院校..." name="form[univid]"><option value="">&nbsp;</option>'+univ_options+'</select><img src="res/images/edit.png" title="手动输入" alt="手动输入" class="univ_edit"></span></td><td><input type="text" name="form[univename]" value="" class="temp-width univename"></td><td><input type="text" name="form[cost]" class="temp-width cost"></td><td><input type="text" name="form[deadline]" class="temp-width deadline"></td><td><input type="text" name="form[satact]" class="temp-width satact"></td><td><input type="text" name="form[rate]" class="temp-width rate"></td><td><input type="text" name="form[tnumber]" class="temp-width tnumber"></td><td><input type="text" name="form[stunumber]" class="temp-width stunumber"></td><td><input type="text" name="form[proportion]" class="temp-width proportion"></td><td align="center"><input type="hidden" class="curr_id"><a class="btn btn-info btn-xs save" href="javascript:void(0);" title="保存并添加" onclick="save(this)">保存并添加</a><a class="btn btn-danger btn-xs del" href="javascript:void(0);" title="删除" onclick="del(this)">删除</a></td></tr></tbody></table></div></div>';
        return temp;
    }
    if(temptype==='tr'){
        var temp = '<tr><td><input type="text" name="form[ranking]" class="temp-width ranking"></td><td><input type="text" name="form[univtitle]" class="temp-width univtitle hide"><img src="res/images/edit.png" title="选择院校" alt="选择院校" class="univtitle_edit hide"><span class="univ_sel"><select class="width-80 chosen-select univid" data-placeholder="选择院校..." name="form[univid]"><option value="">&nbsp;</option>'+univ_options+'</select><img src="res/images/edit.png" title="手动输入" alt="手动输入" class="univ_edit"></span></td><td><input type="text" name="form[univename]" value="" class="temp-width univename"></td><td><input type="text" name="form[cost]" class="temp-width cost"></td><td><input type="text" name="form[deadline]" class="temp-width deadline"></td><td><input type="text" name="form[satact]" class="temp-width satact"></td><td><input type="text" name="form[rate]" class="temp-width rate"></td><td><input type="text" name="form[tnumber]" class="temp-width tnumber"></td><td><input type="text" name="form[stunumber]" class="temp-width stunumber"></td><td><input type="text" name="form[proportion]" class="temp-width proportion"></td><td align="center"><input type="hidden" class="curr_id"><a class="btn btn-info btn-xs saveadd" href="javascript:void(0);" title="保存并添加" onclick="saveadd(this)">保存并添加</a><a class="btn btn-danger btn-xs del" href="javascript:void(0);" title="删除" onclick="del(this)">删除</a></td></tr>';
        return temp;
    }
}
function temp6(temptype){
    //模板：usnews其他
    var univ_options = $(".univ_options").val();
    if(temptype==='div'){
        var temp = '<div><div class="temp_name"><span>usnews其他列表</span></div><div class="temp_con"><table class="table table-striped table-bordered table-hover"><thead><tr class="bg_col"><th>排名</th><th style="width:30%">院校中文名</th><th>院校英文名</th><th>学费</th><th>操作</th></tr></thead><tbody class="tbody-cls"><tr><td><input type="text" name="form[ranking]" class="temp-width ranking"></td><td><input type="text" name="form[univtitle]" class="temp-width univtitle hide"><img src="res/images/edit.png" title="选择院校" alt="选择院校" class="univtitle_edit hide"><span class="univ_sel"><select class="width-80 chosen-select univid" data-placeholder="选择院校..." name="form[univid]"><option value="">&nbsp;</option>'+univ_options+'</select><img src="res/images/edit.png" title="手动输入" alt="手动输入" class="univ_edit"></span></td><td><input type="text" name="form[univename]" value="" class="temp-width univename"></td><td><input type="text" name="form[cost]" class="temp-width cost"></td><td align="center"><input type="hidden" class="curr_id"><a class="btn btn-info btn-xs save" href="javascript:void(0);" title="保存并添加" onclick="save(this)">保存并添加</a><a class="btn btn-danger btn-xs del" href="javascript:void(0);" title="删除" onclick="del(this)">删除</a></td></tr></tbody></table></div></div>';
        return temp;
    }
    if(temptype==='tr'){
        var temp = '<tr><td><input type="text" name="form[ranking]" class="temp-width ranking"></td><td><input type="text" name="form[univtitle]" class="temp-width univtitle hide"><img src="res/images/edit.png" title="选择院校" alt="选择院校" class="univtitle_edit hide"><span class="univ_sel"><select class="width-80 chosen-select univid" data-placeholder="选择院校..." name="form[univid]"><option value="">&nbsp;</option>'+univ_options+'</select><img src="res/images/edit.png" title="手动输入" alt="手动输入" class="univ_edit"></span></td><td><input type="text" name="form[univename]" value="" class="temp-width univename"></td><td><input type="text" name="form[cost]" class="temp-width cost"></td><td align="center"><input type="hidden" class="curr_id"><a class="btn btn-info btn-xs saveadd" href="javascript:void(0);" title="保存并添加" onclick="saveadd(this)">保存并添加</a><a class="btn btn-danger btn-xs del" href="javascript:void(0);" title="删除" onclick="del(this)">删除</a></td></tr>';
        return temp;
    }
}
function add_temp(template, num){
    if(template==='通用列表'){var temp = temp1('tr');}
    if(template==='QS世界大学'){var temp = temp2('tr');}
    if(template==='其他世界大学'){var temp = temp3('tr');}
    if(template==='泰晤士英国大学'){var temp = temp4('tr');}
    if(template==='usnews综合'){var temp = temp5('tr');}
    if(template==='usnews其他'){var temp = temp6('tr');}
    $(".tbody-cls").append(temp);
    chosen_config();
    univid_ename();
    sel_edit();
    if(num==1){  //删除添加按钮
        $('.add_one').remove();
    }
}
$("#classify").change(function(){
    var classify=$("#classify").val();
    if(classify=="世界大学排名"){
        $("#agencies").val("destroy");
        $(".cls-hid").addClass("hide");
        $("#template").val("");
        $(".td-cls").empty();
        var agencie1="<option select='' value=''>选择机构</option><option select='' value='QS'>QS</option><option select='' value='THE'>THE</option><option select='' value='上海交大'>上海交大</option>";
        $("#agencies").html(agencie1);
    }else if(classify=="美国大学排名"){
        $("#agencies").val("destroy");
        $(".cls-hid").addClass("hide");
        $("#template").val("");
        $(".td-cls").empty();
        var agencie2="<option select='' value=''>选择机构</option><option select='' value='USNews'>USNews</option><option select='' value='福布斯'>福布斯</option><option select='' value='普林斯顿评论'>普林斯顿评论</option><option select='' value='华盛顿月刊'>华盛顿月刊</option>";
        $("#agencies").html(agencie2);
    }else if(classify=="英国大学排名"){
        $("#agencies").val("destroy");
        $(".cls-hid").addClass("hide");
        $("#template").val("");
        $(".td-cls").empty();
        var agencie3="<option select='' value=''>选择机构</option><option select='' value='泰晤士'>泰晤士</option><option select='' value='卫报'>卫报</option><option select='' value='完全大学指南'>完全大学指南</option>";
        $("#agencies").html(agencie3);
    }else if(classify=="加拿大大学排名"){
        $("#agencies").val("destroy");
        $(".cls-hid").addClass("hide");
        $("#template").val("");
        $(".td-cls").empty();
        var agencie4="<option select='' value=''>选择机构</option><option select='' value=\"macleans'ca\">macleans'ca</option>";
        $("#agencies").html(agencie4);
    }else {
        var agencie5="<option select='' value=''>选择机构</option>";
        $("#agencies").html(agencie5);
    }
})
$("#agencies").change(function(){
    $(".cls-hid").addClass("hide");
    $("#template").val("");
    $(".td-cls").empty();
    var agencies = $("#agencies").val();
    if(agencies==="QS"){
        $("#template").val("QS世界大学");
        var temp = temp2('div');
        $(".td-cls").append(temp);
    }
    if(agencies==="THE"||agencies==="上海交大"){
        $("#template").val("其他世界大学");
        var temp = temp3('div');
        $(".td-cls").append(temp);
    }
    if(agencies==="USNews"){
        $(".stage").removeClass("hide");
        $(".type").removeClass("hide");
        $(".direction").removeClass("hide");
        $(".major").removeClass("hide");
        $("#stage").val("本科");
        $("#type").val("");
        $("#direction").empty();
        $("#direction").append('<option value="">请选择</option><option value="商科类">商科类</option><option value="工程类（最高博士学位）">工程类（最高博士学位）</option><option value="工程类（无博士学位）">工程类（无博士学位）</option>');
        $("#major").empty();
        $("#major").append('<option value="">请选择</option>');
    }
    if(agencies==="福布斯"||agencies==="普林斯顿评论"||agencies==="华盛顿月刊"||agencies==="卫报"||agencies==="完全大学指南"||agencies==="macleans'ca"){
        $("#template").val("通用列表");
        var temp = temp1('div');
        $(".td-cls").append(temp);
        if(agencies==="macleans'ca"){
            $(".univtype").removeClass("hide");
        }
    }
    if(agencies==="泰晤士"){
        $("#template").val("泰晤士英国大学");
        var temp = temp4('div');
        $(".td-cls").append(temp);
    }
    chosen_config();
    univid_ename();
    sel_edit();
});

$("#stage").change(function(){
    $(".td-cls").empty();
    var stage = $("#stage").val();
    if(stage==="研究生"){
        $(".type").addClass("hide");
        $(".direction").removeClass("hide");
        $(".major").removeClass("hide");
        $("#template").val("usnews其他");
        var temp = temp6('div');
        $(".td-cls").append(temp);
        $("#direction").empty();
        $("#direction").append('<option value="">请选择</option><option value="商学院">商学院</option><option value="工学院">工学院</option><option value="教育学院">教育学院</option><option value="法学院">法学院</option><option value="护理学院">护理学院</option><option value="医学院">医学院</option><option value="艺术类">艺术类</option><option value="公共事务类">公共事务类</option><option value="健康类">健康类</option><option value="科学类">科学类</option><option value="图书馆与信息类">图书馆与信息类</option><option value="社会科学与人文科学">社会科学与人文科学</option>');
        $("#major").empty();
        $("#major").append('<option value="">请选择</option><option value="行政工商管理硕士">行政工商管理硕士</option><option value="兼职工商管理硕士">兼职工商管理硕士</option><option value="会计">会计</option><option value="创业">创业</option><option value="财务">财务</option><option value="信息系统">信息系统</option><option value="国际">国际</option><option value="管理">管理</option><option value="营销">营销</option><option value="非营利组织">非营利组织</option><option value="生产/经营">生产/经营</option><option value="供应链/物流">供应链/物流</option>');
    }
    if(stage==="本科"){
        $("#type").empty();
        $("#type").append('<option value="">请选择</option><option value="综合">综合</option><option value="文理学院">文理学院</option>');
        $(".type").removeClass("hide");
        $("#template").val("");
        $("#direction").empty();
        $("#direction").append('<option value="">请选择</option><option value="商科类">商科类</option><option value="工程类（最高博士学位）">工程类（最高博士学位）</option><option value="工程类（无博士学位）">工程类（无博士学位）</option>');
        $("#major").empty();
        $("#major").append('<option value="">请选择</option>');
    }
    chosen_config();
    univid_ename();
    sel_edit();
});
$("#type").change(function(){
    var type = $("#type").val();
    if(type==='综合'){
        $(".direction").addClass("hide");
        $(".major").addClass("hide");
        $("#template").val("usnews综合");
        $(".td-cls").empty();
        var temp = temp5('div');
        $(".td-cls").append(temp);
    }
    if(type==='文理学院'){
        $(".direction").addClass("hide");
        $(".major").addClass("hide");
        $("#template").val("usnews其他");
        $(".td-cls").empty();
        var temp = temp6('div');
        $(".td-cls").append(temp);
    }
    if(type===''){
        $(".direction").removeClass("hide");
        $(".major").removeClass("hide");
        $("#template").val("");
        $(".td-cls").empty();
    }
    chosen_config();
    univid_ename();
    sel_edit();
});
$("#direction").change(function(){
    $(".type").addClass("hide");
    var direction = $("#direction").val();
    if(direction===''){
        $(".type").removeClass("hide");
        $("#major").empty();
        $("#major").append('<option value="">请选择</option>');
        $(".td-cls").empty();
    }
    if(direction==='商科类'||direction==='工程类（最高博士学位）'||direction==='工程类（无博士学位）'){
        $("#template").val("usnews其他");
        $(".td-cls").empty();
        var temp = temp6('div');
        $(".td-cls").append(temp);
        $("#major").empty();
        if(direction==='商科类'){
            $("#major").append('<option value="">请选择</option><option value="会计">会计</option><option value="创业">创业</option><option value="财务">财务</option><option value="保险">保险</option><option value="国际商务">国际商务</option><option value="管理">管理</option><option value="管理信息系统">管理信息系统</option><option value="营销">营销</option><option value="生产/运营管理">生产/运营管理</option><option value="定量分析">定量分析</option><option value="房地产">房地产</option><option value="供应链管理/物流">供应链管理/物流</option>');
        }
        if(direction==='工程类（最高博士学位）'){
            $("#major").append('<option value="">请选择</option><option value="航空航天/航空/航天">航空航天/航空/航天</option><option value="生物/农业">生物/农业</option><option value="生物医学">生物医学</option><option value="化学">化学</option><option value="土木工程">土木工程</option><option value="计算机">计算机</option><option value="电气/电子/通讯">电气/电子/通讯</option><option value="工程科学/工程物理">工程科学/工程物理</option><option value="环境/环境健康">环境/环境健康</option><option value="工业/制造业">工业/制造业</option><option value="材料">材料</option><option value="机械">机械</option>');
        }
        if(direction==='工程类（无博士学位）'){
            $("#major").append('<option value="">请选择</option><option value="航空航天/航空">航空航天/航空</option><option value="化工">化工</option><option value="土木">土木</option><option value="计算机">计算机</option><option value="电气/电子/通讯">电气/电子/通讯</option><option value="工业/制造业">工业/制造业</option><option value="机械">机械</option>');
        }
    }
    if(direction==='商学院'){
        $("#major").empty();
        $("#major").append('<option value="">请选择</option><option value="行政工商管理硕士">行政工商管理硕士</option><option value="兼职工商管理硕士">兼职工商管理硕士</option><option value="会计">会计</option><option value="创业">创业</option><option value="财务">财务</option><option value="信息系统">信息系统</option><option value="国际">国际</option><option value="管理">管理</option><option value="营销">营销</option><option value="非营利组织">非营利组织</option><option value="生产/经营">生产/经营</option><option value="供应链/物流">供应链/物流</option>');
    }
    if(direction==='工学院'){
        $("#major").empty();
        $("#major").append('<option value="">请选择</option><option value="航空航天/航空/航天">航空航天/航空/航天</option><option value="生物/农业">生物/农业</option><option value="生物医学/生物工程">生物医学/生物工程</option><option value="化学工程">化学工程</option><option value="土木工程">土木工程</option><option value="电脑类">电脑类</option><option value="电子电气工程">电子电气工程</option><option value="环境/环境健康">环境/环境健康</option><option value="工业/制造/系统">工业/制造/系统</option><option value="材料工程">材料工程</option><option value="机械工程">机械工程</option><option value="核反应">核反应</option>');
    }
    if(direction==='教育学院'){
        $("#major").empty();
        $("#major").append('<option value="">请选择</option><option value="课程与教学">课程与教学</option><option value="教务管理">教务管理</option><option value="教育政策">教育政策</option><option value="教育心理学">教育心理学</option><option value="小学教师教育">小学教师教育</option><option value="高等教育行政管理">高等教育行政管理</option><option value="中学教师教育">中学教师教育</option><option value="特殊教育">特殊教育</option><option value="学生咨询和人员服务">学生咨询和人员服务</option><option value="技术/职业">技术/职业</option>');
    }
    if(direction==='法学院'){
        $("#major").empty();
        $("#major").append('<option value="">请选择</option><option value="兼职法律课程">兼职法律课程</option><option value="临床训练">临床训练</option><option value="争端解决">争端解决</option><option value="环境法">环境法</option><option value="卫生保健法">卫生保健法</option><option value="知识产权法">知识产权法</option><option value="国际法">国际法</option><option value="法律写作">法律写作</option><option value="税法">税法</option><option value="审判宣传">审判宣传</option>');
    }
    if(direction==='护理学院'){
        $("#major").empty();
        $("#major").append('<option value="">请选择</option><option value="临床护士长">临床护士长</option><option value="护士麻醉">护士麻醉</option><option value="护士助产">护士助产</option><option value="护士：成年/老年医学，急性护理">护士：成年/老年医学，急性护理</option><option value="护士：成年/老年医学，初级保健">护士：成年/老年医学，初级保健</option><option value="护士执业：家庭">护士执业：家庭</option><option value="护士执业：儿科，初级保健">护士执业：儿科，初级保健</option><option value="护士执业：精神/心理健康，跨越寿命">护士执业：精神/心理健康，跨越寿命</option><option value="护理管理">护理管理</option><option value="护理信息学">护理信息学</option>');
    }
    if(direction==='医学院'){
        $("#major").empty();
        $("#major").append('<option value="">请选择</option><option value="艾滋病">艾滋病</option><option value="毒品和酒精滥用">毒品和酒精滥用</option><option value="家庭医学">家庭医学</option><option value="老年病科">老年病科</option><option value="内科">内科</option><option value="儿科">儿科</option><option value="乡村医学">乡村医学</option><option value="妇女健康">妇女健康</option>');
    }
    if(direction==='艺术类'){
        $("#major").empty();
        $("#major").append('<option value="">请选择</option><option value="陶瓷">陶瓷</option><option value="平面设计">平面设计</option><option value="工业设计">工业设计</option><option value="室内设计">室内设计</option><option value="多媒体/视觉传达">多媒体/视觉传达</option><option value="绘画">绘画</option><option value="摄影">摄影</option><option value="版画">版画</option><option value="雕塑">雕塑</option>');
    }
    if(direction==='公共事务类'){
        $("#major").empty();
        $("#major").append('<option value="">请选择</option><option value="城市管理与城市政策">城市管理与城市政策</option><option value="环境政策与管理">环境政策与管理</option><option value="卫生政策与管理">卫生政策与管理</option><option value="信息技术管理">信息技术管理</option><option value="非营利组织管理">非营利组织管理</option><option value="公共财政与预算">公共财政与预算</option><option value="公共管理行政">公共管理行政</option><option value="公共政策分析">公共政策分析</option><option value="社会政策">社会政策</option>');
    }
    if(direction==='健康类'){
        $("#major").empty();
        $("#major").append('<option value="">请选择</option><option value="听力学">听力学</option><option value="临床心理学">临床心理学</option><option value="卫生保健管理">卫生保健管理</option><option value="职业治疗">职业治疗</option><option value="药店">药店</option><option value="物理治疗">物理治疗</option><option value="医师助理">医师助理</option><option value="公共卫生">公共卫生</option><option value="康复辅导">康复辅导</option><option value="社会工作">社会工作</option><option value="语言病理学">语言病理学</option><option value="兽医">兽医</option>');
    }
    if(direction==='科学类'){
        $("#major").empty();
        $("#major").append('<option value="">请选择</option><option value="生物科学">生物科学</option><option value="化学">化学</option><option value="计算机科学">计算机科学</option><option value="地球科学">地球科学</option><option value="数学">数学</option><option value="物理">物理</option><option value="统计">统计</option>');
    }
    if(direction==='图书馆与信息类'){
        $("#major").empty();
        $("#major").append('<option value="">请选择</option><option value="档案与保存">档案与保存</option><option value="数字图书馆">数字图书馆</option><option value="健康图书馆">健康图书馆</option><option value="信息系统">信息系统</option><option value="法律图书馆">法律图书馆</option><option value="学校图书馆媒体">学校图书馆媒体</option><option value="儿童和青年服务">儿童和青年服务</option>');
    }
    if(direction==='社会科学与人文科学'){
        $("#major").empty();
        $("#major").append('<option value="">请选择</option><option value="社会学">社会学</option><option value="经济">经济</option><option value="英语">英语</option><option value="历史">历史</option><option value="政治学">政治学</option><option value="心理学">心理学</option><option value="犯罪学">犯罪学</option>');
    }
    chosen_config();
    univid_ename();
    sel_edit();
});
function del(obj){
    var html = $(obj).parent().parent();
    var html2 = html.parent();
    var template = $("#template").val();
    var i=$('.del').length;
    var curr_id = $(obj).parent().find(".curr_id").val();
    if(curr_id){
        if(confirm('确认要删除吗？')){
            $.ajax({
                type: 'POST',
                url: 'index.php?r=ranking/del',
                datatype : 'json',
                data: '&curr_id='+curr_id,
                success: function(data){
                    data = JSON.parse(data);
                    if(data==='1'){
//                        alert("删除成功！");
                        html.remove();
                        if (i==1) {
                            $('.temp_name').append('<a class="btn btn-info add_one" href="javascript:void(0);" title="添加" onclick="add_temp(\''+template+'\',1)" style="margin-left:20px;">添加</a>');
                        }
                    }
                }
            });
        }
    }else{
        html.remove();
        if (i==1) {
            $('.temp_name').append('<a class="btn btn-info add_one" href="javascript:void(0);" title="添加" onclick="add_temp(\''+template+'\',1)" style="margin-left:20px;">添加</a>');
        }
    }
    univ_check();
}



function save_back() {
    var rankid = $(".info_id").val();
    if (rankid) {
        //保存、更新主表数据 
 var obj = document.getElementsByName("block[]");
 var block = [];
 var k = $("#blockid").val();
    for(k in obj){
        if(obj[k].checked)
            block.push(obj[k].value);
    }
//    alert(block);
        

        var info = {};
        info['thumb'] = $("#thumb").val();
        info['title'] = $("#title").val();
        info['ename'] = $("#ename").val();
        info['keywords'] = $("#keywords").val();
        info['description'] = $("#description").val();
        info['release_time'] = $("#release_time").val();
        info['classify'] = $("#classify").val();
        info['agencies'] = $("#agencies").val();
        info['univtype'] = info['stage'] = info['type'] = info['direction'] = info['major'] = '';
        if(!info['title']){
            alert("请填写标题");
            $("#title").focus();
            return false;
        }
        if(!info['ename']){
            alert("请填写英文名");
            $("#ename").focus();
            return false;
        }
        if(!info['keywords']){
            alert("请填写关键词");
            $("#keywords").focus();
            return false;
        }else{
            var check=reg('#keywords');
            if (check==0){
                return false;
            }
        }
        if(!info['description']){
            alert("请填写描述");
            $("#description").focus();
            return false;
        }
        if(!info['release_time']){
            alert("请填写发布时间");
            $("#release_time").focus();
            return false;
        }
        if(!info['classify']){
            alert("请填写排名分类");
            $("#classify").focus();
            return false;
        }
        if (!$(".univtype").hasClass('hide')) {
            info['univtype'] = $("#univtype").val();
        }
        if (!$(".stage").hasClass('hide')) {
            info['stage'] = $("#stage").val();
        }
        if (!$(".type").hasClass('hide')) {
            info['type'] = $("#type").val();
        }
        if (!$(".direction").hasClass('hide')) {
            info['direction'] = $("#direction").val();
        }
        if (!$(".major").hasClass('hide')) {
            info['major'] = $("#major").val();
        }
        info['template'] = $("#template").val();
        $.ajax({
            type: 'POST',
            url: 'index.php?r=ranking/updateinfo',
            datatype: 'json',
            data: '&rankid=' + rankid + '&info[title]=' + info['title'] + '&info[ename]=' + info['ename'] + '&info[keywords]=' + info['keywords'] + '&info[description]=' + info['description'] + '&info[release_time]=' + info['release_time'] + '&info[classify]=' + info['classify'] + '&info[agencies]=' + info['agencies'] + '&info[univtype]=' + info['univtype'] + '&info[stage]=' + info['stage'] + '&info[type]=' + info['type'] + '&info[direction]=' + info['direction'] + '&info[major]=' + info['major'] + '&info[template]=' + info['template']+ '&block=' + block+ '&info[thumb]=' + info['thumb'],
            success: function (data) {
                
                data = JSON.parse(data);
                if(data==0){
                    alert("数据保存失败");
                }else{
                    $(".dialog").removeClass('hide');
                    $('#num').text('5');
                    jump(5);
                }
                
            }
        });
//        return false;//测试时倒计时时间停止
        //检查是否有附表数据
        var r_n=$('.ranking').length;
        if(r_n==0){
            alert('请填写相关内容');
            return false;
        }
        //检查院校是否为空
        var univ_num =0;
        $('.univid').each(function(){
            var univ = $(this).val();
            if(!univ){univ_num = 1;}
        });
        if(univ_num == 1){
            alert('请选择院校');
            return false;
        }
        //检查总人数和学生人数是否为数字
        var t_num = 0;
        var t_reg=/^[0-9]*$/;
        $(".tnumber").each(function(){
            var tnum = $(this).val();
            if(tnum && !t_reg.test(tnum)){
                t_num=1;
            }
        });
        $(".stunumber").each(function(){
            var snum = $(this).val();
            if(snum && !t_reg.test(snum)){
                t_num=1;
            }
        });
        if(t_num==1){
            alert("总人数或学生人数必须是数字");
            return false;
        }
        //保存、更新附表数据
        var r_c = 0;
        var i = 0;
        //var num=0;
        $(".curr_id").each(function () {
            i = i + 1;
            var reg=/^[0-9]*$/;
            var rank = $(this).parent().parent().find('.ranking').val();
            var univid = $(this).parent().parent().find('.univid').val();
            var univ_id = $(this).parent().find('.curr_univid').val();
            var univtitle = $(this).parent().parent().find('.univtitle').val();
            var tnumber = $(this).parent().parent().find('.tnumber').val();
            var stunumber = $(this).parent().parent().find('.stunumber').val();
            //if(tnumber && !reg.test(tnumber)){
            //    num=1;
            //}else if(stunumber && !reg.test(stunumber)){
            //    num=1;
            //}
            if (rank && (univid || univtitle || univ_id)) {
                var currid_parent = $(this).parent();
                var curr = currid_parent.parent();
                var template = $("#template").val();
                var info = {};
                info['thumb']= $('$thumb').val();
                info['release_time'] = $("#release_time").val();
                info['agencies'] = $("#agencies").val();
                info['univtype'] = '';
                if (!$(".univtype").hasClass('hide')) {
                    info['univtype'] = $("#univtype").val();
                }
                info['template'] = template;
                var sub = {};
                sub['rankid'] = $(".info_id").val();
                sub['ranking'] = curr.find(".ranking").val();
                sub['univename'] = curr.find(".univename").val();
                sub['univid'] = sub['univtitle'] = sub['countryid'] = sub['country'] = sub['score'] = sub['cost'] = sub['deadline'] = sub['satact'] = sub['rate'] = sub['tnumber'] = sub['stunumber'] = sub['proportion'] = '';
                if (!curr.find(".univ_sel").hasClass('hide')) {
                    sub['univid'] = curr.find(".univid").val();
                }
                if (!sub['univid']) {
                    sub['univid'] = univ_id;
                }
                if (!curr.find(".univtitle").hasClass('hide')) {
                    sub['univtitle'] = curr.find(".univtitle").val();
                }
                if (curr.find(".country").length === 1 && !curr.find(".country").hasClass('hide')) {
                    sub['country'] = curr.find(".country").val();
                }
                if (curr.find(".countryid").length === 1 && !curr.find(".countryid_sel").hasClass('hide')) {
                    sub['countryid'] = curr.find(".countryid").val();
                }
                if (curr.find(".score").length === 1) {
                    sub['score'] = curr.find(".score").val();
                }
                if (curr.find(".cost").length === 1) {
                    sub['cost'] = curr.find(".cost").val();
                }
                if (curr.find(".deadline").length === 1) {
                    sub['deadline'] = curr.find(".deadline").val();
                }
                if (curr.find(".satact").length === 1) {
                    sub['satact'] = curr.find(".satact").val();
                }
                if (curr.find(".rate").length === 1) {
                    sub['rate'] = curr.find(".rate").val();
                }
                if (curr.find(".tnumber").length === 1) {
                    sub['tnumber'] = curr.find(".tnumber").val();
                }
                if (curr.find(".stunumber").length === 1) {
                    sub['stunumber'] = curr.find(".stunumber").val();
                }
                if (curr.find(".proportion").length === 1) {
                    sub['proportion'] = curr.find(".proportion").val();
                }
                var curr_id = $(this).val();
var obj = document.getElementsByName("block[]");
var block = [];
var k = $("#blockid").val();
   for(k in obj){
       if(obj[k].checked)
           block.push(obj[k].value);
   }

                if (!curr_id) {
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?r=ranking/saveadd',
                        datatype: 'json',
                        data: '&info[release_time]=' + info['release_time'] + '&info[agencies]=' + info['agencies'] + '&info[univtype]=' + info['univtype'] + '&info[template]=' + info['template'] + '&sub[rankid]=' + sub['rankid'] + '&sub[ranking]=' + encodeURIComponent(sub['ranking']) + '&sub[univid]=' + sub['univid'] + '&sub[univtitle]=' + sub['univtitle'] + '&sub[univename]=' + sub['univename'] + '&sub[countryid]=' + sub['countryid'] + '&sub[country]=' + sub['country'] + '&sub[score]=' + sub['score'] + '&sub[cost]=' + sub['cost'] + '&sub[deadline]=' + sub['deadline'] + '&sub[satact]=' + sub['satact'] + '&sub[rate]=' + sub['rate'] + '&sub[tnumber]=' + sub['tnumber'] + '&sub[stunumber]=' + sub['stunumber'] + '&sub[proportion]=' + sub['proportion'] + '&block=' + block + '&info[thumb]=' + info['thumb'],
                        success: function (data) {
                            data = JSON.parse(data);
                            if (data === 0) {
//                                    alert("数据保存失败");
                            } else {
                                currid_parent.find(".curr_id").val(data);
                            }
                        }
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?r=ranking/updatesub',
                        datatype: 'json',
                        data: '&curr_id=' + curr_id + '&info[release_time]=' + info['release_time'] + '&info[agencies]=' + info['agencies'] + '&info[univtype]=' + info['univtype'] + '&info[template]=' + info['template'] + '&sub[rankid]=' + sub['rankid'] + '&sub[ranking]=' + encodeURIComponent(sub['ranking']) + '&sub[univid]=' + sub['univid'] + '&sub[univtitle]=' + sub['univtitle'] + '&sub[univename]=' + sub['univename'] + '&sub[countryid]=' + sub['countryid'] + '&sub[country]=' + sub['country'] + '&sub[score]=' + sub['score'] + '&sub[cost]=' + sub['cost'] + '&sub[deadline]=' + sub['deadline'] + '&sub[satact]=' + sub['satact'] + '&sub[rate]=' + sub['rate'] + '&sub[tnumber]=' + sub['tnumber'] + '&sub[stunumber]=' + sub['stunumber'] + '&sub[proportion]=' + sub['proportion'],
                        success: function (data) {
//                            data = JSON.parse(data);
//                            if(data==0){
//                                    alert("数据保存失败");
//                            }else{
//                                alert("数据保存成功");
//                            }
                        }
                    });
                }
            } else {
                if (!rank && (univid || univtitle)) {
                    r_c = 1;
                }
                if (rank && !univid && !univtitle) {
                    r_c = 1;
                }
            }
        });

        if(r_c == 1){
            alert("排名、选择院校 填写不完整");
            return false;
        }else{
            $(".dialog").removeClass('hide');
            if(i<=70){
                jump(3);
            }else{
                $('#num').text('5');
                jump(5);
            }
        }
    }
    else{
        add_check();
    }
}

function add_check(){ //白钰 ，增加的检查标题等是否填写
    var zz=/^[0-9]*$/;
    var template = $("#template").val();
    var info_id = $(".info_id").val();
    var curr_id = $(".save").parent().find(".curr_id").val();
    var univid = $(this).parent().parent().find('.univid').val();
    var univtitle = $(this).parent().parent().find('.univtitle').val();
    if(!info_id && !curr_id){
var obj = document.getElementsByName("block[]");
var block = [];
var k = $("#blockid").val();
   for(k in obj){
       if(obj[k].checked)
           block.push(obj[k].value);
   }
        var info = {};
        info['title'] = $("#title").val();
        info['thumb'] =$("#thumb").val();
        info['ename'] = $("#ename").val();
        info['keywords'] = $("#keywords").val();
        info['description'] = $("#description").val();
        info['release_time'] = $("#release_time").val();
        info['classify'] = $("#classify").val();
        info['agencies'] = $("#agencies").val();
        info['univtype'] = info['stage'] = info['type'] = info['direction'] = info['major'] = '';
        if(!$(".univtype").hasClass('hide')){info['univtype'] = $("#univtype").val();}
        if(!$(".stage").hasClass('hide')){info['stage'] = $("#stage").val();}
        if(!$(".type").hasClass('hide')){info['type'] = $("#type").val();}
        if(!$(".direction").hasClass('hide')){info['direction'] = $("#direction").val();}
        if(!$(".major").hasClass('hide')){info['major'] = $("#major").val();}
        var sub = {};
        info['template'] = $("#template").val();
//        sub['ranking'] = $(".ranking").val();
        var r_c = 0;
        if ($(".ranking").length === 1) {
            r_c = 1;
            sub['ranking'] = $(".ranking").val();
        }
        sub['univename'] = $(".univename").val();
        sub['univid'] = sub['univtitle'] = sub['countryid'] = sub['country'] = sub['score'] = sub['cost'] = sub['deadline'] = sub['satact'] = sub['rate'] = sub['tnumber'] = sub['stunumber'] = sub['proportion'] = '';
        var univ = country = '';
        if(!$(".univ_sel").hasClass('hide')){sub['univid'] = $(".univid").val(); if(sub['univid'])univ = '1';}
        if(!sub['univid']){sub['univid'] = $(".curr_univid").val(); if(sub['univid'])univ = '1';}
        if(!$(".univtitle").hasClass('hide')){sub['univtitle'] = $(".univtitle").val();if(sub['univtitle'])univ = '1';}
        if($(".country").length===1 && !$(".country").hasClass('hide')){sub['country'] = $(".country").val(); if(sub['country'])country = '1';}
        if($(".countryid").length===1 && !$(".countryid_sel").hasClass('hide')){sub['countryid'] = $(".countryid").val(); if(sub['countryid'])country = '1';}
        if($(".score").length===1){sub['score'] = $(".score").val();}
        if($(".cost").length===1){sub['cost'] = $(".cost").val();}
        if($(".deadline").length===1){sub['deadline'] = $(".deadline").val();}
        if($(".satact").length===1){sub['satact'] = $(".satact").val();}
        if($(".rate").length===1){sub['rate'] = $(".rate").val();}
        if($(".tnumber").length===1){sub['tnumber'] = $(".tnumber").val();}
        if($(".stunumber").length===1){sub['stunumber'] = $(".stunumber").val();}
        if($(".proportion").length===1){sub['proportion'] = $(".proportion").val();}
        if(!info['title']){
            alert("请填写标题");
            $("#title").focus();
            return false;
        }
        if(!info['ename']){
            alert("请填写英文名");
            $("#ename").focus();
            return false;
        }
        if(!info['keywords']){
            alert("请填写关键词");
            $("#keywords").focus();
            return false;
        }else{
            var check=reg('#keywords');
            if (check==0){
                return false;
            }
        }
        if(!info['description']){
            alert("请填写描述");
            $("#description").focus();
            return false;
        }
        if(!info['release_time']){
            alert("请填写发布时间");
            $("#release_time").focus();
            return false;
        }
        if(!info['classify']){
            alert("请填写排名分类");
            $("#classify").focus();
            return false;
        }
        if(!info['agencies']){
            alert("请填写排名机构");
            $(".agencies").focus();
            return false;
        }
        if(!sub['ranking']){
            if(r_c==1){
                alert("请填写排名");
                $(".ranking").focus();
                return false;
            }else{
                alert("请填写相关内容");
                return false;
            }
        }
        if(!univ){
            alert("请选择院校");
            return false;
        }
        if(!sub['univename']){
            alert("请填写院校英文名");
            $(".univename").focus();
            return false;
        }
        if(sub['tnumber'] && !zz.test(sub['tnumber'])){
            alert("总人数或学生人数必须是数字");
            return false;
        }else if(sub['stunumber'] && !zz.test(sub['stunumber'])){
            alert("总人数或学生人数必须是数字");
            return false;
        }

        if($(".countryid").length===1 && !country){
            alert("请选择国家");
            return false;
        }
        $.ajax({
            type: 'POST',
            url: 'index.php?r=ranking/save',
            datatype : 'json',
            data: '&info[title]='+info['title']+'&info[ename]='+info['ename']+'&info[keywords]='+info['keywords']+'&info[description]='+info['description']+'&info[release_time]='+info['release_time']+'&info[classify]='+info['classify']+'&info[agencies]='+info['agencies']+'&info[univtype]='+info['univtype']+'&info[stage]='+info['stage']+'&info[type]='+info['type']+'&info[direction]='+info['direction']+'&info[major]='+info['major']+'&info[template]='+info['template']+'&sub[ranking]='+encodeURIComponent(sub['ranking'])+'&sub[univid]='+sub['univid']+'&sub[univtitle]='+sub['univtitle']+'&sub[univename]='+sub['univename']+'&sub[countryid]='+sub['countryid']+'&sub[country]='+sub['country']+'&sub[score]='+sub['score']+'&sub[cost]='+sub['cost']+'&sub[deadline]='+sub['deadline']+'&sub[satact]='+sub['satact']+'&sub[rate]='+sub['rate']+'&sub[tnumber]='+sub['tnumber']+'&sub[stunumber]='+sub['stunumber']+'&sub[proportion]='+sub['proportion'] + '&block=' + block+ '&info[thumb]=' + info['thumb'],
            success: function(data){
                data = JSON.parse(data);
                if(data===0){
//                    alert("数据保存失败");
                }else{
                    var arr = data.split(',');
                    $(".info_id").val(arr[0]);
                    $(".curr_id").val(arr[1]);
                }
            }
        });
        var r_c = 0;
        if (!info_id && (univid || univtitle)) {
            r_c = 1;
        }
        if (info_id && !univid && !univtitle) {
            r_c = 1;
        }
        if(r_c == 1){
            alert("排名、选择院校 填写不完整");
            return false;
        }else{
            $(".dialog").removeClass('hide');
            $('#num').text('5');
            jump(5);
        }
    }
}
function jump(count) {
    window.setTimeout(function(){
        count--;
        if(count > 0) {
            $('#num').text(count);
            jump(count);
        } else {
            $(".dialog").addClass('hide');
            location.href="index.php?r=ranking/index";
        }
    }, 1000);
}
function save(obj){
    var zz=/^[0-9]*$/;
    var template = $("#template").val();
    var info_id = $(".info_id").val();
    var curr_id = $(".save").parent().find(".curr_id").val();
    if(!info_id && !curr_id){
        var info = {};
        info['title'] = $("#title").val();
        info['thumb'] = $("#thumb").val();
        info['ename'] = $("#ename").val();
        info['keywords'] = $("#keywords").val();
        info['description'] = $("#description").val();
        info['release_time'] = $("#release_time").val();
        info['classify'] = $("#classify").val();
        info['agencies'] = $("#agencies").val();
        info['univtype'] = info['stage'] = info['type'] = info['direction'] = info['major'] = '';
        if(!$(".univtype").hasClass('hide')){info['univtype'] = $("#univtype").val();}
        if(!$(".stage").hasClass('hide')){info['stage'] = $("#stage").val();}
        if(!$(".type").hasClass('hide')){info['type'] = $("#type").val();}
        if(!$(".direction").hasClass('hide')){info['direction'] = $("#direction").val();}
        if(!$(".major").hasClass('hide')){info['major'] = $("#major").val();}
        
 var obj = document.getElementsByName("block[]");
 var block = [];
 var k = $("#blockid").val();
    for(k in obj){
        if(obj[k].checked)
            block.push(obj[k].value);
    }
//    alert(block);    
        var sub = {};
        info['template'] = $("#template").val();
        sub['ranking'] = $(".ranking").val();
        sub['univename'] = $(".univename").val();
        sub['univid'] = sub['univtitle'] = sub['countryid'] = sub['country'] = sub['score'] = sub['cost'] = sub['deadline'] = sub['satact'] = sub['rate'] = sub['tnumber'] = sub['stunumber'] = sub['proportion'] = '';
        var univ = country = '';
        if(!$(".univ_sel").hasClass('hide')){sub['univid'] = $(".univid").val(); if(sub['univid'])univ = '1';}
        if(!sub['univid']){sub['univid'] = $(".curr_univid").val(); if(sub['univid'])univ = '1';}
        if(!$(".univtitle").hasClass('hide')){sub['univtitle'] = $(".univtitle").val();if(sub['univtitle'])univ = '1';}
        if($(".country").length===1 && !$(".country").hasClass('hide')){sub['country'] = $(".country").val(); if(sub['country'])country = '1';}
        if($(".countryid").length===1 && !$(".countryid_sel").hasClass('hide')){sub['countryid'] = $(".countryid").val(); if(sub['countryid'])country = '1';}
        if($(".score").length===1){sub['score'] = $(".score").val();}
        if($(".cost").length===1){sub['cost'] = $(".cost").val();}
        if($(".deadline").length===1){sub['deadline'] = $(".deadline").val();}
        if($(".satact").length===1){sub['satact'] = $(".satact").val();}
        if($(".rate").length===1){sub['rate'] = $(".rate").val();}
        if($(".tnumber").length===1){sub['tnumber'] = $(".tnumber").val();}
        if($(".stunumber").length===1){sub['stunumber'] = $(".stunumber").val();}
        if($(".proportion").length===1){sub['proportion'] = $(".proportion").val();}
        if(!info['title']){
            alert("请填写标题");
            $("#title").focus();
            return false;
        }
        if(!info['ename']){
            alert("请填写英文名");
            $("#ename").focus();
            return false;
        }
        if(!info['keywords']){
            alert("请填写关键词");
            $("#keywords").focus();
            return false;
        }else{
            var check=reg('#keywords');
            if (check==0){
                return false;
            }
        }
        if(!info['description']){
            alert("请填写描述");
            $("#description").focus();
            return false;
        }
        if(!info['release_time']){
            alert("请填写发布时间");
            $("#release_time").focus();
            return false;
        }
        if(!info['classify']){
            alert("请填写排名分类");
            $("#classify").focus();
            return false;
        }
        if(!info['agencies']){
            alert("请选择机构");
            $(".agencies").focus();
            return false;
        }
        if(!sub['ranking']){
            alert("请填写排名");
            $(".ranking").focus();
            return false;
        }
        if(!univ){
            alert("请选择院校");
            return false;
        }
        if(sub['tnumber'] && !zz.test(sub['tnumber'])){
            alert("总人数或学生人数必须是数字");
            return false;
        }
        if(sub['stunumber'] && !zz.test(sub['stunumber'])){
            alert("总人数或学生人数必须是数字");
            return false;
        }
        if(!sub['univename']){
            alert("请填写院校英文名");
            $(".univename").focus();
            return false;
        }
        if($(".countryid").length===1 && !country){
            alert("请选择国家");
            return false;
        }

        $.ajax({
            type: 'POST',
            url: 'index.php?r=ranking/save',
            datatype : 'json',
            data: '&info[title]='+info['title']+'&info[ename]='+info['ename']+'&info[keywords]='+info['keywords']+'&info[description]='+info['description']+'&info[release_time]='+info['release_time']+'&info[classify]='+info['classify']+'&info[agencies]='+info['agencies']+'&info[univtype]='+info['univtype']+'&info[stage]='+info['stage']+'&info[type]='+info['type']+'&info[direction]='+info['direction']+'&info[major]='+info['major']+'&info[template]='+info['template']+'&sub[ranking]='+encodeURIComponent(sub['ranking'])+'&sub[univid]='+sub['univid']+'&sub[univtitle]='+sub['univtitle']+'&sub[univename]='+sub['univename']+'&sub[countryid]='+sub['countryid']+'&sub[country]='+sub['country']+'&sub[score]='+sub['score']+'&sub[cost]='+sub['cost']+'&sub[deadline]='+sub['deadline']+'&sub[satact]='+sub['satact']+'&sub[rate]='+sub['rate']+'&sub[tnumber]='+sub['tnumber']+'&sub[stunumber]='+sub['stunumber']+'&sub[proportion]='+sub['proportion']+'&block='+block + '&info[thumb]=' + info['thumb'],
            success: function(data){
                data = JSON.parse(data);
                if(data===0){
//                    alert("数据保存失败");
                }else{
                    var arr = data.split(',');
                    $(".info_id").val(arr[0]);
                    $(".curr_id").val(arr[1]);
                    add_temp(template);
                }
            }
        });
    }else{saveadd(obj);}
}
function saveadd(obj){
    var zz=/^[0-9]*$/;
    var currid_parent = $(obj).parent();
    var curr = currid_parent.parent();
    var template = $("#template").val();
    var obj = document.getElementsByName("block[]");
    var block = [];
    var k = $("#blockid").val();
       for(k in obj){
           if(obj[k].checked)
               block.push(obj[k].value);
    }
    var info = {};
    info['release_time'] = $("#release_time").val();
    info['agencies'] = $("#agencies").val();
    info['univtype'] = '';
    if(!$(".univtype").hasClass('hide')){info['univtype'] = $("#univtype").val();}
    var sub = {};
    info['template'] = template;
    sub['rankid'] = $(".info_id").val();
    sub['ranking'] = curr.find(".ranking").val();
    sub['univename'] = curr.find(".univename").val();
    sub['univid'] = sub['univtitle'] = sub['countryid'] = sub['country'] = sub['score'] = sub['cost'] = sub['deadline'] = sub['satact'] = sub['rate'] = sub['tnumber'] = sub['stunumber'] = sub['proportion'] = '';
    var country = '';
    if(!curr.find(".univ_sel").hasClass('hide')){sub['univid'] = curr.find(".univid").val();}
    if(!sub['univid']){sub['univid'] = curr.find(".curr_univid").val();}
    if(!curr.find(".univtitle").hasClass('hide')){sub['univtitle'] = curr.find(".univtitle").val();}
    if(curr.find(".country").length===1 && !curr.find(".country").hasClass('hide')){sub['country'] = curr.find(".country").val();if(sub['country'])country = '1';}
    if(curr.find(".countryid").length===1 && !curr.find(".countryid_sel").hasClass('hide')){sub['countryid'] = curr.find(".countryid").val();if(sub['countryid'])country = '1';}
    if(curr.find(".score").length===1){sub['score'] = curr.find(".score").val();}
    if(curr.find(".cost").length===1){sub['cost'] = curr.find(".cost").val();}
    if(curr.find(".deadline").length===1){sub['deadline'] = curr.find(".deadline").val();}
    if(curr.find(".satact").length===1){sub['satact'] = curr.find(".satact").val();}
    if(curr.find(".rate").length===1){sub['rate'] = curr.find(".rate").val();}
    if(curr.find(".tnumber").length===1){sub['tnumber'] = curr.find(".tnumber").val();}
    if(curr.find(".stunumber").length===1){sub['stunumber'] = curr.find(".stunumber").val();}
    if(curr.find(".proportion").length===1){sub['proportion'] = curr.find(".proportion").val();}
    if(sub['ranking'] && (sub['univid'] || sub['univtitle'])){
        if(curr.find(".countryid").length===1 && !country){
            alert("请选择国家");
            return false;
        }
        if(sub['tnumber'] && !zz.test(sub['tnumber'])){
            alert("总人数或学生人数必须是数字");
            return false;
        }
        if(sub['stunumber'] && !zz.test(sub['stunumber'])){
            alert("总人数或学生人数必须是数字");
            return false;
        }
        var curr_id = currid_parent.find(".curr_id").val();
        if(!curr_id){
            $.ajax({
                type: 'POST',
                url: 'index.php?r=ranking/saveadd',
                datatype : 'json',
                data: '&info[release_time]='+info['release_time']+'&info[agencies]='+info['agencies']+'&info[univtype]='+info['univtype']+'&info[template]='+info['template']+'&sub[rankid]='+sub['rankid']+'&sub[ranking]='+encodeURIComponent(sub['ranking'])+'&sub[univid]='+sub['univid']+'&sub[univtitle]='+sub['univtitle']+'&sub[univename]='+sub['univename']+'&sub[countryid]='+sub['countryid']+'&sub[country]='+sub['country']+'&sub[score]='+sub['score']+'&sub[cost]='+sub['cost']+'&sub[deadline]='+sub['deadline']+'&sub[satact]='+sub['satact']+'&sub[rate]='+sub['rate']+'&sub[tnumber]='+sub['tnumber']+'&sub[stunumber]='+sub['stunumber']+'&sub[proportion]='+sub['proportion']+'&block='+block+'&thumb='+thumb,
                success: function(data){
                    data = JSON.parse(data);
                    if(data===0){
                        //                    alert("数据保存失败");
                    }else{
                        currid_parent.find(".curr_id").val(data);
                        add_temp(template);
                    }
                }
            });
        }else{
            $.ajax({
                type: 'POST',
                url: 'index.php?r=ranking/updatesub',
                datatype : 'json',
                data: '&curr_id='+curr_id+'&info[release_time]='+info['release_time']+'&info[agencies]='+info['agencies']+'&info[univtype]='+info['univtype']+'&info[template]='+info['template']+'&sub[rankid]='+sub['rankid']+'&sub[ranking]='+encodeURIComponent(sub['ranking'])+'&sub[univid]='+sub['univid']+'&sub[univtitle]='+sub['univtitle']+'&sub[univename]='+sub['univename']+'&sub[countryid]='+sub['countryid']+'&sub[country]='+sub['country']+'&sub[score]='+sub['score']+'&sub[cost]='+sub['cost']+'&sub[deadline]='+sub['deadline']+'&sub[satact]='+sub['satact']+'&sub[rate]='+sub['rate']+'&sub[tnumber]='+sub['tnumber']+'&sub[stunumber]='+sub['stunumber']+'&sub[proportion]='+sub['proportion'],
                success: function(data){
//                    data = JSON.parse(data);
//                    if(data==0){
                    //                    alert("数据保存失败");
//                    }else{
                    add_temp(template);
//                    }
                }
            });
        }
    }else{alert("请填写排名、选择院校");}
}
function direction_major(stage, direction, major){
    if(stage==='研究生') {
        var html = '';
        html += '<option value="">请选择</option><option value="商学院" ';
        if(direction==='商学院'){html += ' selected';}
        html += '>商学院</option><option value="工学院"';
        if(direction==='工学院'){html += ' selected';}
        html += '>工学院</option><option value="教育学院"';
        if(direction==='教育学院'){html += ' selected';}
        html += '>教育学院</option><option value="法学院"';
        if(direction==='法学院'){html += ' selected';}
        html += '>法学院</option><option value="护理学院"';
        if(direction==='护理学院'){html += ' selected';}
        html += '>护理学院</option><option value="医学院"';
        if(direction==='医学院'){html += ' selected';}
        html += '>医学院</option><option value="艺术类"';
        if(direction==='艺术类'){html += ' selected';}
        html += '>艺术类</option><option value="公共事务类"';
        if(direction==='公共事务类'){html += ' selected';}
        html += '>公共事务类</option><option value="健康类"';
        if(direction==='健康类'){html += ' selected';}
        html += '>健康类</option><option value="科学类"';
        if(direction==='科学类'){html += ' selected';}
        html += '>科学类</option><option value="图书馆与信息类"';
        if(direction==='图书馆与信息类'){html += ' selected';}
        html += '>图书馆与信息类</option><option value="社会科学与人文科学"';
        if(direction==='社会科学与人文科学'){html += ' selected';}
        html += '>社会科学与人文科学</option>';
        $("#direction").empty();
        $("#direction").append(html);
    }
    if(direction==='商科类'){
        var html = '';
        html += '<option value="">请选择</option><option value="会计"';
        if(major==='会计'){html += ' selected';}
        html += '>会计</option><option value="创业"';
        if(major==='创业'){html += ' selected';}
        html += '>创业</option><option value="财务"';
        if(major==='财务'){html += ' selected';}
        html += '>财务</option><option value="保险"';
        if(major==='保险'){html += ' selected';}
        html += '>保险</option><option value="国际商务"';
        if(major==='国际商务'){html += ' selected';}
        html += '>国际商务</option><option value="管理"';
        if(major==='管理'){html += ' selected';}
        html += '>管理</option><option value="管理信息系统"';
        if(major==='管理信息系统'){html += ' selected';}
        html += '>管理信息系统</option><option value="营销"';
        if(major==='营销'){html += ' selected';}
        html += '>营销</option><option value="生产/运营管理"';
        if(major==='生产/运营管理'){html += ' selected';}
        html += '>生产/运营管理</option><option value="定量分析"';
        if(major==='定量分析'){html += ' selected';}
        html += '>定量分析</option><option value="房地产"';
        if(major==='房地产'){html += ' selected';}
        html += '>房地产</option><option value="供应链管理/物流"';
        if(major==='供应链管理/物流'){html += ' selected';}
        html += '>供应链管理/物流</option>';
        $("#major").empty();
        $("#major").append(html);
    }
    if(direction==='工程类（最高博士学位）'){
        var html = '';
        html += '<option value="">请选择</option><option value="航空航天/航空/航天"';
        if(major==='航空航天/航空/航天'){html += ' selected';}
        html += '>航空航天/航空/航天</option><option value="生物/农业"';
        if(major==='生物/农业'){html += ' selected';}
        html += '>生物/农业</option><option value="生物医学"';
        if(major==='生物医学'){html += ' selected';}
        html += '>生物医学</option><option value="化学"';
        if(major==='化学'){html += ' selected';}
        html += '>化学</option><option value="土木工程"';
        if(major==='土木工程'){html += ' selected';}
        html += '>土木工程</option><option value="计算机"';
        if(major==='计算机'){html += ' selected';}
        html += '>计算机</option><option value="电气/电子/通讯"';
        if(major==='电气/电子/通讯'){html += ' selected';}
        html += '>电气/电子/通讯</option><option value="工程科学/工程物理"';
        if(major==='工程科学/工程物理'){html += ' selected';}
        html += '>工程科学/工程物理</option><option value="环境/环境健康"';
        if(major==='环境/环境健康'){html += ' selected';}
        html += '>环境/环境健康</option><option value="工业/制造业"';
        if(major==='工业/制造业'){html += ' selected';}
        html += '>工业/制造业</option><option value="材料"';
        if(major==='材料'){html += ' selected';}
        html += '>材料</option><option value="机械"';
        if(major==='机械'){html += ' selected';}
        html += '>机械</option>';
        $("#major").empty();
        $("#major").append(html);
    }
    if(direction==='工程类（无博士学位）'){
        var html = '';
        html += '<option value="">请选择</option><option value="航空航天/航空"';
        if(major==='航空航天/航空'){html += ' selected';}
        html += '>航空航天/航空</option><option value="化工"';
        if(major==='化工'){html += ' selected';}
        html += '>化工</option><option value="土木"';
        if(major==='土木'){html += ' selected';}
        html += '>土木</option><option value="计算机"';
        if(major==='计算机'){html += ' selected';}
        html += '>计算机</option><option value="电气/电子/通讯"';
        if(major==='电气/电子/通讯'){html += ' selected';}
        html += '>电气/电子/通讯</option><option value="工业/制造业"';
        if(major==='工业/制造业'){html += ' selected';}
        html += '>工业/制造业</option><option value="机械"';
        if(major==='机械'){html += ' selected';}
        html += '>机械</option>';
        $("#major").empty();
        $("#major").append(html);
    }
    if(direction==='商学院'){
        var html = '';
        html += '<option value="">请选择</option><option value="行政工商管理硕士"';
        if(major==='行政工商管理硕士'){html += ' selected';}
        html += '>行政工商管理硕士</option><option value="兼职工商管理硕士"';
        if(major==='兼职工商管理硕士'){html += ' selected';}
        html += '>兼职工商管理硕士</option><option value="会计"';
        if(major==='会计'){html += ' selected';}
        html += '>会计</option><option value="创业"';
        if(major==='创业'){html += ' selected';}
        html += '>创业</option><option value="财务"';
        if(major==='财务'){html += ' selected';}
        html += '>财务</option><option value="信息系统"';
        if(major==='信息系统'){html += ' selected';}
        html += '>信息系统</option><option value="国际"';
        if(major==='国际'){html += ' selected';}
        html += '>国际</option><option value="管理"';
        if(major==='管理'){html += ' selected';}
        html += '>管理</option><option value="营销"';
        if(major==='营销'){html += ' selected';}
        html += '>营销</option><option value="非营利组织"';
        if(major==='非营利组织'){html += ' selected';}
        html += '>非营利组织</option><option value="生产/经营"';
        if(major==='生产/经营'){html += ' selected';}
        html += '>生产/经营</option><option value="供应链/物流"';
        if(major==='供应链/物流'){html += ' selected';}
        html += '>供应链/物流</option>';
        $("#major").empty();
        $("#major").append(html);
    }
    if(direction==='工学院'){
        var html = '';
        html += '<option value="">请选择</option><option value="航空航天/航空/航天"';
        if(major==='航空航天/航空/航天'){html += ' selected';}
        html += '>航空航天/航空/航天</option><option value="生物/农业"';
        if(major==='生物/农业'){html += ' selected';}
        html += '>生物/农业</option><option value="生物医学/生物工程"';
        if(major==='生物医学/生物工程'){html += ' selected';}
        html += '>生物医学/生物工程</option><option value="化学工程"';
        if(major==='化学工程'){html += ' selected';}
        html += '>化学工程</option><option value="土木工程"';
        if(major==='土木工程'){html += ' selected';}
        html += '>土木工程</option><option value="电脑类"';
        if(major==='电脑类'){html += ' selected';}
        html += '>电脑类</option><option value="电子电气工程"';
        if(major==='电子电气工程'){html += ' selected';}
        html += '>电子电气工程</option><option value="环境/环境健康"';
        if(major==='环境/环境健康'){html += ' selected';}
        html += '>环境/环境健康</option><option value="工业/制造/系统"';
        if(major==='工业/制造/系统'){html += ' selected';}
        html += '>工业/制造/系统</option><option value="材料工程"';
        if(major==='材料工程'){html += ' selected';}
        html += '>材料工程</option><option value="机械工程"';
        if(major==='机械工程'){html += ' selected';}
        html += '>机械工程</option><option value="核反应"';
        if(major==='核反应'){html += ' selected';}
        html += '>核反应</option>';
        $("#major").empty();
        $("#major").append(html);
    }
    if(direction==='教育学院'){
        var html = '';
        html += '<option value="">请选择</option><option value="课程与教学"';
        if(major==='课程与教学'){html += ' selected';}
        html += '>课程与教学</option><option value="教务管理"';
        if(major==='教务管理'){html += ' selected';}
        html += '>教务管理</option><option value="教育政策"';
        if(major==='教育政策'){html += ' selected';}
        html += '>教育政策</option><option value="教育心理学"';
        if(major==='教育心理学'){html += ' selected';}
        html += '>教育心理学</option><option value="小学教师教育"';
        if(major==='小学教师教育'){html += ' selected';}
        html += '>小学教师教育</option><option value="高等教育行政管理"';
        if(major==='高等教育行政管理'){html += ' selected';}
        html += '>高等教育行政管理</option><option value="中学教师教育"';
        if(major==='中学教师教育'){html += ' selected';}
        html += '>中学教师教育</option><option value="特殊教育"';
        if(major==='特殊教育'){html += ' selected';}
        html += '>特殊教育</option><option value="学生咨询和人员服务"';
        if(major==='学生咨询和人员服务'){html += ' selected';}
        html += '>学生咨询和人员服务</option><option value="技术/职业"';
        if(major==='技术/职业'){html += ' selected';}
        html += '>技术/职业</option>';
        $("#major").empty();
        $("#major").append(html);
    }
    if(direction==='法学院'){
        var html = '';
        html += '<option value="">请选择</option><option value="兼职法律课程"';
        if(major==='兼职法律课程'){html += ' selected';}
        html += '>兼职法律课程</option><option value="临床训练"';
        if(major==='临床训练'){html += ' selected';}
        html += '>临床训练</option><option value="争端解决"';
        if(major==='争端解决'){html += ' selected';}
        html += '>争端解决</option><option value="环境法"';
        if(major==='环境法'){html += ' selected';}
        html += '>环境法</option><option value="卫生保健法"';
        if(major==='卫生保健法'){html += ' selected';}
        html += '>卫生保健法</option><option value="知识产权法"';
        if(major==='知识产权法'){html += ' selected';}
        html += '>知识产权法</option><option value="国际法"';
        if(major==='国际法'){html += ' selected';}
        html += '>国际法</option><option value="法律写作"';
        if(major==='法律写作'){html += ' selected';}
        html += '>法律写作</option><option value="税法"';
        if(major==='税法'){html += ' selected';}
        html += '>税法</option><option value="审判宣传"';
        if(major==='审判宣传'){html += ' selected';}
        html += '>审判宣传</option>';
        $("#major").empty();
        $("#major").append(html);
    }
    if(direction==='护理学院'){
        var html = '';
        html += '<option value="">请选择</option><option value="临床护士长"';
        if(major==='临床护士长'){html += ' selected';}
        html += '>临床护士长</option><option value="护士麻醉"';
        if(major==='护士麻醉'){html += ' selected';}
        html += '>护士麻醉</option><option value="护士助产"';
        if(major==='护士助产'){html += ' selected';}
        html += '>护士助产</option><option value="护士：成年/老年医学，急性护理"';
        if(major==='护士：成年/老年医学，急性护理'){html += ' selected';}
        html += '>护士：成年/老年医学，急性护理</option><option value="护士：成年/老年医学，初级保健"';
        if(major==='护士：成年/老年医学，初级保健'){html += ' selected';}
        html += '>护士：成年/老年医学，初级保健</option><option value="护士执业：家庭"';
        if(major==='护士执业：家庭'){html += ' selected';}
        html += '>护士执业：家庭</option><option value="护士执业：儿科，初级保健"';
        if(major==='护士执业：儿科，初级保健'){html += ' selected';}
        html += '>护士执业：儿科，初级保健</option><option value="护士执业：精神/心理健康，跨越寿命"';
        if(major==='护士执业：精神/心理健康，跨越寿命'){html += ' selected';}
        html += '>护士执业：精神/心理健康，跨越寿命</option><option value="护理管理"';
        if(major==='护理管理'){html += ' selected';}
        html += '>护理管理</option><option value="护理信息学"';
        if(major==='护理信息学'){html += ' selected';}
        html += '>护理信息学</option>';
        $("#major").empty();
        $("#major").append(html);
    }
    if(direction==='医学院'){
        var html = '';
        html += '<option value="">请选择</option><option value="艾滋病"';
        if(major==='艾滋病'){html += ' selected';}
        html += '>艾滋病</option><option value="毒品和酒精滥用"';
        if(major==='毒品和酒精滥用'){html += ' selected';}
        html += '>毒品和酒精滥用</option><option value="家庭医学"';
        if(major==='家庭医学'){html += ' selected';}
        html += '>家庭医学</option><option value="老年病科"';
        if(major==='老年病科'){html += ' selected';}
        html += '>老年病科</option><option value="内科"';
        if(major==='内科'){html += ' selected';}
        html += '>内科</option><option value="儿科"';
        if(major==='儿科'){html += ' selected';}
        html += '>儿科</option><option value="乡村医学"';
        if(major==='乡村医学'){html += ' selected';}
        html += '>乡村医学</option><option value="妇女健康"';
        if(major==='妇女健康'){html += ' selected';}
        html += '>妇女健康</option>';
        $("#major").empty();
        $("#major").append(html);
    }
    if(direction==='艺术类'){
        var html = '';
        html += '<option value="">请选择</option><option value="陶瓷"';
        if(major==='陶瓷'){html += ' selected';}
        html += '>陶瓷</option><option value="平面设计"';
        if(major==='平面设计'){html += ' selected';}
        html += '>平面设计</option><option value="工业设计"';
        if(major==='工业设计'){html += ' selected';}
        html += '>工业设计</option><option value="室内设计"';
        if(major==='室内设计'){html += ' selected';}
        html += '>室内设计</option><option value="多媒体/视觉传达"';
        if(major==='多媒体/视觉传达'){html += ' selected';}
        html += '>多媒体/视觉传达</option><option value="绘画"';
        if(major==='绘画'){html += ' selected';}
        html += '>绘画</option><option value="摄影"';
        if(major==='摄影'){html += ' selected';}
        html += '>摄影</option><option value="版画"';
        if(major==='版画'){html += ' selected';}
        html += '>版画</option><option value="雕塑"';
        if(major==='雕塑'){html += ' selected';}
        html += '>雕塑</option>';
        $("#major").empty();
        $("#major").append(html);
    }
    if(direction==='公共事务类'){
        var html = '';
        html += '<option value="">请选择</option><option value="城市管理与城市政策"';
        if(major==='城市管理与城市政策'){html += ' selected';}
        html += '>城市管理与城市政策</option><option value="环境政策与管理"';
        if(major==='环境政策与管理'){html += ' selected';}
        html += '>环境政策与管理</option><option value="卫生政策与管理"';
        if(major==='卫生政策与管理'){html += ' selected';}
        html += '>卫生政策与管理</option><option value="信息技术管理"';
        if(major==='信息技术管理'){html += ' selected';}
        html += '>信息技术管理</option><option value="非营利组织管理"';
        if(major==='非营利组织管理'){html += ' selected';}
        html += '>非营利组织管理</option><option value="公共财政与预算"';
        if(major==='公共财政与预算'){html += ' selected';}
        html += '>公共财政与预算</option><option value="公共管理行政"';
        if(major==='公共管理行政'){html += ' selected';}
        html += '>公共管理行政</option><option value="公共政策分析"';
        if(major==='公共政策分析'){html += ' selected';}
        html += '>公共政策分析</option><option value="社会政策"';
        if(major==='社会政策'){html += ' selected';}
        html += '>社会政策</option>';
        $("#major").empty();
        $("#major").append(html);
    }
    if(direction==='健康类'){
        var html = '';
        html += '<option value="">请选择</option><option value="听力学"';
        if(major==='听力学'){html += ' selected';}
        html += '>听力学</option><option value="临床心理学"';
        if(major==='临床心理学'){html += ' selected';}
        html += '>临床心理学</option><option value="卫生保健管理"';
        if(major==='卫生保健管理'){html += ' selected';}
        html += '>卫生保健管理</option><option value="职业治疗"';
        if(major==='职业治疗'){html += ' selected';}
        html += '>职业治疗</option><option value="药店"';
        if(major==='药店'){html += ' selected';}
        html += '>药店</option><option value="物理治疗"';
        if(major==='物理治疗'){html += ' selected';}
        html += '>物理治疗</option><option value="医师助理"';
        if(major==='医师助理'){html += ' selected';}
        html += '>医师助理</option><option value="公共卫生"';
        if(major==='公共卫生'){html += ' selected';}
        html += '>公共卫生</option><option value="康复辅导"';
        if(major==='康复辅导'){html += ' selected';}
        html += '>康复辅导</option><option value="社会工作"';
        if(major==='社会工作'){html += ' selected';}
        html += '>社会工作</option><option value="语言病理学"';
        if(major==='语言病理学'){html += ' selected';}
        html += '>语言病理学</option><option value="兽医"';
        if(major==='兽医'){html += ' selected';}
        html += '>兽医</option>';
        $("#major").empty();
        $("#major").append(html);
    }
    if(direction==='科学类'){
        var html = '';
        html += '<option value="">请选择</option><option value="生物科学"';
        if(major==='生物科学'){html += ' selected';}
        html += '>生物科学</option><option value="化学"';
        if(major==='化学'){html += ' selected';}
        html += '>化学</option><option value="计算机科学"';
        if(major==='计算机科学'){html += ' selected';}
        html += '>计算机科学</option><option value="地球科学"';
        if(major==='地球科学'){html += ' selected';}
        html += '>地球科学</option><option value="数学"';
        if(major==='数学'){html += ' selected';}
        html += '>数学</option><option value="物理"';
        if(major==='物理'){html += ' selected';}
        html += '>物理</option><option value="统计"';
        if(major==='统计'){html += ' selected';}
        html += '>统计</option>';
        $("#major").empty();
        $("#major").append(html);
    }
    if(direction==='图书馆与信息类'){
        var html = '';
        html += '<option value="">请选择</option><option value="档案与保存"';
        if(major==='档案与保存'){html += ' selected';}
        html += '>档案与保存</option><option value="数字图书馆"';
        if(major==='数字图书馆'){html += ' selected';}
        html += '>数字图书馆</option><option value="健康图书馆"';
        if(major==='健康图书馆'){html += ' selected';}
        html += '>健康图书馆</option><option value="信息系统"';
        if(major==='信息系统'){html += ' selected';}
        html += '>信息系统</option><option value="法律图书馆"';
        if(major==='法律图书馆'){html += ' selected';}
        html += '>法律图书馆</option><option value="学校图书馆媒体"';
        if(major==='学校图书馆媒体'){html += ' selected';}
        html += '>学校图书馆媒体</option><option value="儿童和青年服务"';
        if(major==='儿童和青年服务'){html += ' selected';}
        html += '>儿童和青年服务</option>';
        $("#major").empty();
        $("#major").append(html);
    }
    if(direction==='社会科学与人文科学'){
        var html = '';
        html += '<option value="">请选择</option><option value="社会学"';
        if(major==='社会学'){html += ' selected';}
        html += '>社会学</option><option value="经济"';
        if(major==='经济'){html += ' selected';}
        html += '>经济</option><option value="英语"';
        if(major==='英语'){html += ' selected';}
        html += '>英语</option><option value="历史"';
        if(major==='历史'){html += ' selected';}
        html += '>历史</option><option value="政治学"';
        if(major==='政治学'){html += ' selected';}
        html += '>政治学</option><option value="心理学"';
        if(major==='心理学'){html += ' selected';}
        html += '>心理学</option><option value="犯罪学"';
        if(major==='犯罪学'){html += ' selected';}
        html += '>犯罪学</option>';
        $("#major").empty();
        $("#major").append(html);
    }
}
$(".univtitle_edit_update").click(function(){
    var univ_options = $(".univ_options").val();
    var html = '';
    html += '<select class="width-80 chosen-select univid" data-placeholder="选择院校..." name="form[univid]"><option value="">&nbsp;</option>'+univ_options+'</select><img src="res/images/edit.png" title="手动输入" alt="手动输入" class="univ_edit">';
    $(this).parent().find('.univtitle').addClass('hide');
    $(this).parent().find('.univtitle_edit_update').addClass('hide');
    $(this).parent().find('.univ_sel').html(html);
    chosen_config();
    univid_ename();
    sel_edit();
    var curr_univ = $(this).parent().parent().find('.curr_univid').val();
    if (curr_univ) {
        $(".univid").chosen("destroy");
        $(this).parent().find(".univid").val(curr_univ);
        $(".univid").chosen({
            no_results_text : "未找到此选项!",
            width:"80%"
        });
    }
    $(this).parent().find('.univ_sel').removeClass('hide');
});
chosen_config();
univid_ename();
sel_edit();
//$(".curr_univid").each(function() {
//    var curr_univ = $(this).val();
//    if (curr_univ) {
//        $(".univid").chosen("destroy");
//        $(this).parent().parent().find(".univid").val(curr_univ);
//        $(".univid").chosen({
//            no_results_text : "未找到此选项!",
//            width:"80%"
//        });
//    }
//});

del_check();
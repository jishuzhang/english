/**
 * Created by Administrator on 2015/10/28.
 */
function acadmic(){
    window.univ_option=$("#univ_option").val();
    window.univ_gn_option=$("#univ_gn_option").val();
    window.high_school_option=$("#high_school_option").val();
    window.major_option=$("#major_option").val();
    window.country_option=$("#country_option").val()
}
function studentSoft(addInit){
    //学术实践
    window.lunwen='<div class="stu-size quote"><div class="wenzi-ci">论文</div> <div><label>论文名称</label><input type="text" name="scase[academic]['+addInit+'][name]" value=""  ></div> <div><label>论文状态</label><input type="text" name="scase[academic]['+addInit+'][paper_status]" value=""  ></div> <div><label>级别</label> <select name="scase[academic]['+addInit+'][level]" id="" class="form-control"> <option value="国际期刊">国际期刊</option> <option value="国内期刊">国内期刊</option> <option value="国际会议">国际会议</option> <option value="国内会议">国内会议</option> <option value="其他">其他</option> </select> </div> <div><label>论文类型</label> <select name="scase[academic]['+addInit+'][paper_type]" id=""  class="form-control"> <option value="综述性论文">综述性论文</option> <option value="学术性论文">学术性论文</option> </select> </div> <div ><label>期刊/会议名称</label><input type="text" name="scase[academic]['+addInit+'][conference_name]" value=""  ></div> <div ><label>第几作</label><input type="text" name="scase[academic]['+addInit+'][many_works]" value=""  ></div> <div ><label>影响因子</label><input type="text" name="scase[academic]['+addInit+'][factor]" value=""  ></div> <div class="hr-t mar5"><hr></div></div>';
    window.zhuanli='<div class="stu-size quote"><div class="wenzi-ci">专利</div> <div><label>开始时间</label><input type="text" name="scase[academic]['+addInit+'][start_date]" value="" class="datetimepicker" ></div> <div><label>持续时间</label><input type="text" name="scase[academic]['+addInit+'][continue_time]" value="" class="datetimepicker" ></div> <div ><label>专利名称</label><input type="text" name="scase[academic]['+addInit+'][patent_name]" value=""  ></div> <div ><label>专利类型</label><input type="text" name="scase[academic]['+addInit+'][patent_type]" value=""  ></div> <div class="hr-t mar5"><hr></div></div>';
    window.kyxmu='<div class="stu-size quote"><div class="wenzi-ci">科研项目</div> <div><label>开始时间</label><input type="text" name="scase[academic]['+addInit+'][start_date]" value="" class="datetimepicker" ></div> <div><label>持续时间</label><input type="text" name="scase[academic]['+addInit+'][continue_time]" value="" class="datetimepicker" ></div> <div><label>项目名称</label><input type="text" name="scase[academic]['+addInit+'][name]" value=""  ></div> <div><label>级别</label> <select name="scase[academic]['+addInit+'][level]" id="" class="form-control"> <option value="国外项目">国外项目</option> <option value="国家级">国家级</option> <option value="省级">省级</option> <option value="校级">校级</option> <option value="毕设">毕设</option> <option value="课设">课设</option> </select> </div> <div ><label>实验室名称</label><input type="text" name="scase[academic]['+addInit+'][lab_name]" value=""  ></div> <div ><label>指导教授/头衔</label><input type="text" name="scase[academic]['+addInit+'][advisor]" value=""  ></div> <div ><label>参与度</label> <input type="radio" name="scase[academic]['+addInit+'][degree]" value="负责"  >负责 <input type="radio" name="scase[academic]['+addInit+'][degree]" value="参与"  >参与 </div> <div><label>项目职责</label><input type="text" name="scase[academic]['+addInit+'][project_responsibilty]" value=""  ></div> <div><label>涉及方法或技能</label><input type="text" name="scase[academic]['+addInit+'][skills]" value=""  ></div> <div class="hr-t mar5"><hr></div></div>';
    window.xsjsai='<div class="stu-size quote"><div class="wenzi-ci">学术竞赛</div> <div><label>开始时间</label><input type="text" name="scase[academic]['+addInit+'][start_date]" value=""  class="datetimepicker"></div> <div><label>持续时间</label><input type="text" name="scase[academic]['+addInit+'][continue_time]" value="" class="datetimepicker" ></div> <div><label>竞赛名称</label><input type="text" name="scase[academic]['+addInit+'][name]" value=""  ></div> <div><label>级别</label> <select name="scase[academic]['+addInit+'][level]" id="" class="form-control"> <option value="国际">国际</option> <option value="国家">国家</option> <option value="省级">省级</option> <option value="校级">校级</option> </select> </div> <div ><label>参与度</label> <input type="radio" name="scase[academic]['+addInit+'][degree]" value="负责"  >负责 <input type="radio" name="scase[academic]['+addInit+'][degree]" value="参与"  >参与 </div> <div><label>主要负责内容</label><input type="text" name="scase[academic]['+addInit+'][project_responsibilty]" value=""  ></div> <div><label>获奖情况</label><input type="text" name="scase[academic]['+addInit+'][dwards]" value=""  ></div> <div><label>指导教授/头衔</label><input type="text" name="scase[academic]['+addInit+'][advisor]" value=""  ></div> <div class="hr-t mar5"><hr></div></div>';
    window.xshyi='<div class="stu-size quote"><div class="wenzi-ci">学术会议</div> <div><label>会议名称</label><input type="text" name="scase[academic]['+addInit+'][name]" value=""  ></div><div><label>级别</label> <select name="scase[academic]['+addInit+'][level]" id="" class="form-control"> <option value="国际">国际</option> <option value="国内">国内</option> </select> </div> <div ><label>参与度</label> <input type="radio" name="scase[academic]['+addInit+'][degree]" value="负责"  >负责 <input type="radio" name="scase[academic]['+addInit+'][degree]" value="参与"  >参与 </div> <div><label>主要职责</label><input type="text" name="scase[academic]['+addInit+'][project_responsibilty]" value=""  ></div> <div><label>指导教授/头衔</label><input type="text" name="scase[academic]['+addInit+'][advisor]" value=""  ></div> <div class="hr-t mar5"><hr></div></div>';
    //实习实践
    window.gongzuo='<div class="stu-size quote"><div class="wenzi-ci">工作</div><div><label>开始时间</label><input type="text" name="scase[practice]['+addInit+'][start_time]" value="" class="datetimepicker"  ></div> <div><label>持续时间</label><input type="text" name="scase[practice]['+addInit+'][continue_time]" value="" class="datetimepicker" ></div><div><label>企业名称</label> <select name="scase[practice]['+addInit+'][company_name]" id="" class="form-control"> <option value="IT">IT</option> <option value="通讯">通讯</option> <option value="机械">机械</option> <option value="教育培训">教育培训</option> <option value="其他">其他</option> </select> </div> <div ><label>所在城市</label><input type="text" name="scase[practice]['+addInit+'][city]" value=""  ></div> <div ><label>工作职责</label><input type="text" name="scase[practice]['+addInit+'][job_duties]" value=""  ></div> <div><label>来源</label> <select name="scase[practice]['+addInit+'][source]" id=""  class="form-control"> <option value="学校安排">学校安排</option> <option value="家人安排">家人安排</option> <option value="自己面试">自己面试</option> </select> </div> <div class="hr-t mar5"><hr></div> </div>';
    window.shixi='<div class="stu-size quote"><div class="wenzi-ci">实习</div><div><label>开始时间</label><input type="text" name="scase[practice]['+addInit+'][start_time]" value="" class="datetimepicker"  ></div> <div><label>持续时间</label><input type="text" name="scase[practice]['+addInit+'][continue_time]" value="" class="datetimepicker" ></div><div><label>企业名称</label> <select name="scase[practice]['+addInit+'][company_name]" id="" class="form-control"> <option value="IT">IT</option> <option value="通讯">通讯</option> <option value="机械">机械</option> <option value="教育培训">教育培训</option> <option value="其他">其他</option> </select> </div> <div ><label>所在城市</label><input type="text" name="scase[practice]['+addInit+'][city]" value=""  ></div> <div ><label>工作职责</label><input type="text" name="scase[practice]['+addInit+'][job_duties]" value=""  ></div> <div><label>来源</label> <select name="scase[practice]['+addInit+'][source]" id=""  class="form-control"> <option value="学校安排">学校安排</option> <option value="家人安排">家人安排</option> <option value="自己面试">自己面试</option> </select> </div> <div class="hr-t mar5"><hr></div> </div>';
    //活动实践
    window.zyzhdong='<div class="stu-size quote"><div class="wenzi-ci">志愿者活动</div><div><label>开始时间</label><input type="text" name="scase[activity]['+addInit+'][starttime]" value="" class="datetimepicker" ></div> <div><label>持续时间</label><input type="text" name="scase[activity]['+addInit+'][duration]" value="" class="datetimepicker" ></div> <div><label>活动名称</label><input type="text" name="scase[activity]['+addInit+'][activityname]" value=""  ></div> <div><label>级别</label> <select name="scase[activity]['+addInit+'][activitylevel]" id="" class="form-control"> <option value="国际">国际</option> <option value="国内">国内</option> <option value="省级">省级</option> <option value="市级">市级</option> <option value="校级">校级</option> </select> </div> <div ><label>期刊/会议名称</label><input type="text" name="scase[activity]['+addInit+'][journal]" value=""  ></div> <div ><label>活动内容</label><input type="text" name="scase[activity]['+addInit+'][activitycon]" value=""  ></div> <div ><label>参与度</label> <input type="radio" name="scase[activity]['+addInit+'][partic]" value="负责"  >负责 <input type="radio" name="scase[activity]['+addInit+'][partic]" value="参与"  >参与 </div> <div ><label>工作职责</label><input type="text" name="scase[activity]['+addInit+'][duties]" value=""  ></div> <div class="hr-t mar5"><hr></div> </div>';
    window.sthdong='<div class="stu-size quote"> <div class="wenzi-ci">社团活动</div> <div><label>开始时间</label><input type="text" name="scase[activity]['+addInit+'][starttime]" value="" class="datetimepicker" ></div> <div><label>持续时间</label><input type="text" name="scase[activity]['+addInit+'][duration]" value="" class="datetimepicker" ></div> <div><label>活动名称</label><input type="text" name=scase[activity]['+addInit+'][activityname]" value=""  ></div> <div><label>活动级别</label> <select name="scase[activity]['+addInit+'][activitylevel]" id="" class="form-control"> <option value="国际">国际</option> <option value="国内">国内</option> <option value="省级">省级</option> <option value="市级">市级</option> <option value="校级">校级</option> </select> </div> <div ><label>活动内容</label><input type="text" name="scase[activity]['+addInit+'][activitycon]" value=""  ></div> <div ><label>参与度</label> <input type="radio" name="scase[activity]['+addInit+'][partic]" value="负责"  >负责 <input type="radio" name="scase[activity]['+addInit+'][partic]" value="参与"  >参与 </div> <div ><label>工作职责（职务）</label><input type="text" name="scase[activity]['+addInit+'][duties]" value=""  ></div> <div class="hr-t mar5"><hr></div> </div>';
    window.fxsjsai=' <div class="stu-size quote"> <div class="wenzi-ci">非学术竞赛</div> <div><label>开始时间</label><input type="text" name="scase[activity]['+addInit+'][starttime]" value="" class="datetimepicker" ></div> <div><label>竞赛名称</label><input type="text" name="scase[activity]['+addInit+'][activityname]" value=""   ></div> <div><label>活动级别</label> <select name="scase[activity]['+addInit+'][activitylevel]" id="" class="form-control"> <option value="国际">国际</option> <option value="国内">国家</option> <option value="省级">省级</option> <option value="校级">校级</option> </select> </div> <div><label>活动类型</label> <select name="scase[activity]['+addInit+'][activitytype]" id="" class="form-control"> <option value="英语演讲">英语演讲</option> <option value="科目竞赛">科目竞赛</option> <option value="歌唱">歌唱</option> </select> </div> <div ><label>获奖情况</label><input type="text" name="scase[activity]['+addInit+'][awards]" value=""  ></div> <div ><label>活动主办方</label><input type="text" name="scase[activity]['+addInit+'][organizer]" value=""  ></div> <div class="hr-t mar5"><hr></div> </div>';
}
//国内背景添加
function add_dome(){
    acadmic();
    var leng=$("#domebg1 .stu-size").size();

    if(leng>4){
        alert("只能添加三条");
    }else{
        var init  =  $("#bg1").val();
        var addInit   =  parseInt(init)   + 1;
        $("#bg1").val(addInit);
        window.html4 =' <div class="stu-size" id="bgSel'+addInit+'"> <label>院校名称</label><select onchange="changeDome('+addInit+')" class="form-control"  id="domestic'+addInit+'" name="scase[domestic]['+addInit+'][type]"><option selected="selected">大学</option><option>高中</option></select> <a class="close badge btn-danger" href="javascript:delete_dome('+addInit+');">×</a></div>';
        window.daxue1='<div><label>院校名称</label><span><select  multiple="" name="scase[domestic]['+addInit+'][univname][]" id="domestic_select" style="width: 340px;" class="chosen-select" data-placeholder="选择院校..."><option value="">&nbsp;</option>'+univ_gn_option+'</select></span> <label>起始时间</label><input type="text" name="scase[domestic]['+addInit+'][starttime]" value="" class="datetimepicker" > <label>结束时间</label><input type="text" name="scase[domestic]['+addInit+'][endtime]" value="" class="datetimepicker" > <label>专业</label><span><select  multiple="" name="scase[domestic]['+addInit+'][major][]" id="domestic_select" style="width: 180px;" class="chosen-select" data-placeholder="选择专业..."><option value="">&nbsp;</option>'+major_option+'</select></span></div> <div> <label>学位类型</label><input type="text" name="scase[domestic]['+addInit+'][degreetype]" value="" class="" > <label>所获学位</label><input type="text" name="scase[domestic]['+addInit+'][degree]" value="" class="" > <label>GPA</label><input type="text" name="scase[domestic]['+addInit+'][gpa]" value="" onkeyup="gpa()" class="gpa" > <label>GPA标准</label><input type="text" name="scase[domestic]['+addInit+'][gpastandard]" value="" class="" > </div> <div class="hr-t"><hr></div>';
        window.gaozhong1=' <div> <label>院校名称</label><span><select  multiple="" name="scase[domestic]['+addInit+'][univname][]"  id="domestic_select" style="width: 340px;"  class="chosen-select" data-placeholder="选择院校..."><option value="">&nbsp;</option>'+high_school_option+'</select></span><label>起始时间</label><input type="text" name="scase[domestic]['+addInit+'][starttime]" value="" class="datetimepicker" > <label>结束时间</label><input type="text" name="scase[domestic]['+addInit+'][endtime]" value="" class="datetimepicker" ></div><div class="hr-t"><hr></div>';
        $("#domebg1").append(html4);
        $("#domebg1").append('<div class="stu-size" id="changeDome'+addInit+'">'+daxue1+'</div>');
    }
    chosen_config();
    datepickerD();
}


function changeDome(aI){

    acadmic();
    if(aI!=0){
        var dome=$("#domestic"+aI).find("option:selected").val();
        if(dome=='大学'){
            $("#changeDome"+aI).html(daxue1);
        }else if(dome=='高中'){
            $("#changeDome"+aI).html(gaozhong1);
        }
    }else{
        var dome=$("#domestic").find("option:selected").val();
        if(dome=='大学'){
            var daxue='<div><label>院校名称</label><span><select  multiple="" name="scase[domestic][0][univname][]" style="width: 340px;" id="domestic_select" class="chosen-select" data-placeholder="选择院校..."><option value="">&nbsp;</option>'+univ_gn_option+'</select></span><label>起始时间</label><input type="text" name="scase[domestic][0][starttime]" value="" class="datetimepicker" > <label>结束时间</label><input type="text" name="scase[domestic][0][endtime]" value="" class="datetimepicker"> <label>专业</label><span><select  multiple="" name="scase[domestic][0][major][]" id="domestic_select" style="width: 180px;" class="chosen-select" data-placeholder="选择专业..."><option value="">&nbsp;</option>'+major_option+'</select></span></div> <div> <label>学位类型</label><input type="text" name="scase[domestic][0][degreetype]" value="" class="" > <label>所获学位</label><input type="text" name="scase[domestic][0][degree]" value="" class="" > <label>GPA</label><input type="text" name="scase[domestic][0][gpa]" value="" onkeyup="gpa()" class="gpa" > <label>GPA标准</label><input type="text" name="scase[domestic][0][gpastandard]" value="" class="" > </div> <div class="hr-t"><hr></div>';
            $("#changeDome").html(daxue);
        }else if(dome=='高中'){
            var gaozhong=' <div> <label>院校名称</label><span><select  multiple="" name="scase[domestic][0][univname][]" style="width: 340px;" id="domestic_select" class="chosen-select" data-placeholder="选择院校..."><option value="">&nbsp;</option>'+high_school_option+'</select></span><label>起始时间</label><input type="text" name="scase[domestic][0][starttime]" value="" class="datetimepicker"  > <label>结束时间</label><input type="text" name="scase[domestic][0][endtime]" value="" class="datetimepicker" ></div><div class="hr-t"><hr></div>';
            $("#changeDome").html(gaozhong);
        }
    }
    chosen_config();
    datepickerD();
}

function delete_dome(aI){
    $("#bg1").val(parseInt( $("#bg1").text())-1);
    var domesticDel=$(".domestic_id"+aI).val();
    $("#bgSel"+aI).remove();
    $("#changeDome"+aI).remove();
    Ajax_del(domesticDel,'','','','','','','');
}


//国外及录取信息添加
function add_edubg(v){
   var leng=$("#edubg"+v+" .stu-size").size();

    acadmic();

    var num  =  $("#dome"+v).val();
    var newNum   =  parseInt(num)   + 1;

    var html3='<div id="domeContent' + newNum + '" class="stu-size quote"><div><a class="close badge btn-danger" style="text-indent: 0;" href="javascript:delete_edubg(' + newNum + ','+v+');">×</a></div>';
    html3+='<div><label>录取院校</label><select  multiple="" name="scase[admission]['+ newNum +'][univid][]" style="width: 340px; padding:0;" id="univid" class="chosen-select univid" data-placeholder="选择院校..."><option value="" >&nbsp;</option>'+univ_option+'</select></div> ';
    html3+='<div><label>录取专业（中文）</label><select  multiple=" " name="scase[admission]['+ newNum +'][majorid][]" id="majorid"  style="width: 180px; padding:0;"class="chosen-select majorid" data-placeholder="选择专业..."><option value="" >&nbsp;</option>'+major_option+'</select></div> <div><label>专业分支</label><input type="text" name="scase[admission]['+ newNum +'][majorbranch]" value=""  ></div> <div ><label>项目全称（英文）</label><input type="text" name="scase[admission]['+ newNum +'][profullname]" value=""  ></div> <div ><label>专业排名</label><input type="text" name="scase[admission]['+ newNum +'][majorrank]" value="" class="majorrank"  ></div>';
    html3 +='<div><label>入学时间</label> <select name="scase[admission]['+ newNum +'][entime_year]" id="" class="form-control entime_year"> <option value="0">请选择</option><option value="2008">2008</option> <option value="2009">2009</option> <option value="2010">2010</option> <option value="2011">2011</option> <option value="2012">2012</option><option value="2013">2013</option> <option value="2014">2014</option> <option value="2015">2015</option> <option value="2016">2016</option> <option value="2017">2017</option> <option value="2018">2018</option> <option value="2019">2019</option></select>';
    html3 +='<select id="entime_month'+ newNum +'" name="scase[admission]['+ newNum +'][entime_month]" class="form-control entime_month" onchange="season_month('+ newNum +')"><option value="0">请选择</option> <option value="1">1月</option> <option value="2">2月</option> <option value="3">3月</option> <option value="4">4月</option> <option value="5">5月</option> <option value="6">6月</option> <option value="7">7月</option> <option value="8">8月</option> <option value="9">9月</option> <option value="10">10月</option> <option value="11">11月</option> <option value="12">12月</option> </select></div>';
    html3 +='<div  id="enseason'+ newNum +'" class="enseason"><label>入学季</label><input type="radio" name="scase[admission]['+ newNum +'][enseason]" id="season1" value="春季"  >春季 <input type="radio" id="season2"  name="scase[admission]['+ newNum +'][enseason]" value="夏季" >夏季 <input type="radio" id="season3" name="scase[admission]['+ newNum +'][enseason]" value="秋季"  >秋季 <input type="radio" id="season4" name="scase[admission]['+ newNum +'][enseason]" value="冬季"  >冬季</div><div><label>申请时长</label> <select name="scase[admission]['+ newNum +'][applitime]" id="applitime" class="form-control"> <option value="0">请选择</option><option value="6个月">6个月</option> <option value="12个月">12个月</option><option value="18个月">18个月</option><option value="24个月">24个月</option><option value="32个月">32个月</option></select></div>';
    html3 +='<div><label>出结果时间</label><select name="scase[admission]['+ newNum +'][resulttime_year]" id="" class="form-control"> <option value="0">请选择</option> <option value="2008">2008</option> <option value="2009">2009</option> <option value="2010">2010</option> <option value="2011">2011</option> <option value="2012">2012</option> <option value="2013">2013</option> <option value="2014">2014</option> <option value="2015">2015</option> <option value="2016">2016</option> <option value="2017">2017</option> <option value="2018">2018</option> <option value="2019">2019</option> </select>';
    html3 +='<select name="scase[admission]['+ newNum +'][resulttime_month]" id="" class="form-control"><option value="0">请选择</option><option value="1月">1月</option> <option value="2月">2月</option> <option value="3月">3月</option> <option value="4月">4月</option> <option value="5月">5月</option> <option value="6月">6月</option> <option value="7月">7月</option> <option value="8月">8月</option> <option value="9月">9月</option> <option value="10月">10月</option> <option value="11月">11月</option> <option value="12月">12月</option> </select>';
    html3 +='<select name="scase[admission]['+ newNum +'][resulttime_day]" id="" class="form-control"><option value="0">请选择</option> <option value="1日">1日</option> <option value="2日">2日</option> <option value="3日">3日</option> <option value="3日">4日</option> <option value="3日">5日</option> <option value="3日">6日</option> <option value="3日">7日</option> <option value="3日">8日</option> <option value="3日">9日</option> <option value="3日">10日</option> <option value="1日">11日</option> <option value="2日">12日</option> <option value="3日">13日</option> <option value="3日">14日</option> <option value="3日">15日</option> <option value="3日">16日</option> <option value="3日">17日</option> <option value="3日">18日</option> <option value="3日">19日</option> <option value="3日">20日</option> <option value="1日">21日</option> <option value="2日">22日</option> <option value="3日">23日</option> <option value="3日">24日</option> <option value="3日">25日</option> <option value="3日">26日</option> <option value="3日">27日</option> <option value="3日">28日</option> <option value="3日">29日</option> <option value="3日">30日</option> <option value="3日">31日</option> </select> </div>';
    html3 +='<div ><label>是否全奖</label> <input type="radio" name="scase[admission]['+ newNum +'][fullprize]" value="是"  >是 <input type="radio" name="scase[admission]['+ newNum +'][fullprize]" value="否"  >否 </div> <div ><label>奖学金金额</label><input type="text" name="scase[admission]['+ newNum +'][scholarship]" value=""  ></div> <div ><label>是否有录取条件</label> <input type="radio" name="scase[admission]['+ newNum +'][admission]" value="是"  >是 <input type="radio" name="scase[admission]['+ newNum +'][admission]" value="否">否 </div> <div class="hr-t mar5"><hr></div></div>';

    //录取信息
    if(v==3){
        //录取信息
        $("#dome"+v).val(newNum);
      $("#edubg3").append(html3);
    }else{
    if(leng>2){
         alert("只能加三条");
        return false;
    }else {
        $("#dome"+v).val(newNum);
        if(v==2){
            //国外教育背景

            var guowaibg='<div id="domeContent' + newNum + '" class="stu-size"><div><a class="close badge btn-danger" href="javascript:delete_edubg(' + newNum + ','+v+');">×</a></div>';
            guowaibg+='<div><label>院校名称</label><span class="univtitle1" ><input class="temp-width " type="text"   name="scase[foreign]['+ newNum +'][univname]"> <img class="univtitle_edit"  alt="选择院校" title="选择院校" style="height: 15px;"  src="res/images/edit.png" onclick="edit('+newNum+','+1+','+2+')"> </span><span class="univtitle2 hide"> <select  multiple="" name="scase[foreign]['+ newNum +'][univname][]" style="width: 240px;" id="foreign_select" class="chosen-select univtitle_select" data-placeholder="选择院校..." > <option value="" >&nbsp;</option>'+univ_option+'</select>&nbsp;<img class="univtitle_edit"  alt="选择院校" title="选择院校" style="height: 15px;" src="res/images/edit.png" onclick="edit('+newNum+','+2+','+1+')"></span> ';
            guowaibg+='<label>所在国家</label><select  multiple="" name="scase[foreign]['+ newNum +'][country]" style="width: 120px;" id="country_select" class="chosen-select" data-placeholder="选择国家..."> '+country_option+'<option value="" >请选择</option></select>';
            guowaibg+='<label>起始时间</label><input type="text" name="scase[foreign]['+ newNum +'][starttime]" value="" class="datetimepicker"  > <label>结束时间</label><input type="text" name="scase[foreign]['+ newNum +'][endtime]" value="" class="datetimepicker"  > </div><div><label>专业</label><select  multiple="" name="scase[foreign]['+ newNum +'][major][]" style="width: 170px;" id="major_select" class="chosen-select" data-placeholder="选择专业..."> '+major_option+'<option value="" >请选择</option></select> ' +
            '<label>学位类型</label><input type="text" name="scase[foreign]['+ newNum +'][degreetype]" value=""  > ' +
            '<label>所获学位</label><input type="text" name="scase[foreign]['+ newNum +'][degree]" value=""  > ' +
            '<label>GPA</label><input type="text" name="scase[foreign]['+ newNum +'][gpa]" value="" onkeyup="gpa()" class="gpa" > ' +
            '<label>GPA标准</label><input type="text" name="scase[foreign]['+ newNum +'][gpastandard]" value=""  > </div> ' +
            '<div class="hr-t"><hr></div></div>';

            $("#edubg2").append(guowaibg);
        }
        if(v==4){
        //其他 考试成绩
            var num=parseInt(leng)+2;

            $("#edubg4").append('<div id="domeContent' + newNum + '" class="stu-size"><label>考试名称</label><input type="text" name="scase[data][testname'+num+']" value=""><label>考试成绩</label><input type="text" name="scase[data][testresults'+num+']" value=""><a class="close badge btn-danger" href="javascript:delete_edubg(' + newNum + ','+v+');">×</a><div class="hr-t"><hr></div></div>')
        }
        }
    }
    chosen_config();
    datepickerD();
}
function delete_edubg(newNum,v){

    var dataDel=$("#data_id"+newNum).val();
    var num  =  $("#dome"+v).val();
    $("#dome"+v).val(parseInt(num)-1);



    var foreignDel = $("#foreign_id"+newNum).val();
    var admissionDel=$(".admission_id"+newNum).val();


        $("#edubg"+v).find("#domeContent"+newNum).remove();
    Ajax_del('',foreignDel,admissionDel,'','','','',dataDel);
}

//学生档案软件添加
function add_soft(v){
    var init  =  $("#atte"+v).val();
    var addInit   =  parseInt(init)   + 1;
    $("#atte"+v).val(addInit);
    studentSoft(addInit);

    //学术实践
    var html1='<div class="stu-size wd nums'+v+'" id="change'+addInit+'"><label>选择类型</label><select name="scase[academic]['+addInit+'][type]" id="practice'+addInit+'" class="form-control" onchange="changeCon('+addInit+',1)"> <option value="">无</option> <option value="论文">论文</option> <option value="专利">专利</option> <option value="科研项目">科研项目</option> <option value="学术竞赛">学术竞赛</option> <option value="学术会议">学术会议</option> </select> <a class="close badge btn-danger" href="javascript:void(0)" onclick="delete_soft('+addInit+',1)">×</a></div>';
    //实习实践
    var html2='<div class="stu-size wd nums'+v+'" id="change'+addInit+'"><label>选择类型</label><select name="scase[practice]['+addInit+'][type]" id="practice'+addInit+'" class="form-control" onchange="changeCon('+addInit+',2)"><option value="">无</option><option value="实习">实习</option><option value="工作">工作</option></select> <a class="close badge btn-danger" href="javascript:void(0)" onclick="delete_soft('+addInit+',2)">×</a></div>';
   //活动实践
    var html3='<div class="stu-size wd nums'+v+'" id="change'+addInit+'"><label>选择类型</label><select name="scase[activity]['+addInit+'][type]" id="practice'+addInit+'" class="form-control" onchange="changeCon('+addInit+',3)"><option value="无">无</option> <option value="志愿者活动">志愿者活动</option> <option value="社团活动">社团活动</option> <option value="非学术竞赛">非学术竞赛</option> </select><a class="close badge btn-danger" href="javascript:void(0)" onclick="delete_soft('+addInit+',3)">×</a></div>';
   //特殊的 推荐人
    window.tjren='<div class="stu-size quote nums'+v+'" id="change'+addInit+'"> <div class="wenzi-ci">推荐人<a class="close badge btn-danger" style="text-indent: 0;" href="javascript:void(0)" onclick="delete_soft('+addInit+',4)">×</a></div> <div><label>名字</label><input type="text" name="scase[recomd]['+addInit+'][name]" value=""  ></div> <div><label>头衔/职务</label><input type="text" name="scase[recomd]['+addInit+'][position]" value=""  ></div> <div ><label>所属单位</label><input type="text" name="scase[recomd]['+addInit+'][company]" value=""  ></div> <div ><label>学术/非学术</label><input type="text" name="scase[recomd]['+addInit+'][academic]" value=""  ></div> <div ><label>是否有海外背景</label><input type="text" name="scase[recomd]['+addInit+'][overseas]" value=""  ></div> <div class="hr-t mar5"><hr></div> </div>';

   if(v==1){
       var  count=$("#attend"+v+" .nums"+v).size();
       if(count>9){
           alert('最多只能添加10条')
           return false;
       }else{
           $("#nums"+v).html(count+1);
           $("#soft1").hide();
           $("#attend1").append(html1);
           $("#attend1").append('<div id="changeCon'+addInit+'" ></div>');
       }
    }
    if(v==2){
        var  count=$("#attend"+v+" .nums"+v).size();
        if(count>9){
            alert('最多只能添加10条')
            return false;
        }else{
            $("#nums"+v).html(count+1);
            $("#soft2").hide();
            $("#attend2").append(html2);
            $("#attend2").append('<div id="changeCon'+addInit+'"></div>');
        }
    }
    if(v==3){
        var  count=$("#attend"+v+" .nums"+v).size();
        if(count>9){
            alert('最多只能添加10条')
            return false;
        }else{
            $("#nums"+v).html(count+1);
            $("#soft3").hide();
            $("#attend3").append(html3);
            $("#attend3").append('<div id="changeCon'+addInit+'"></div>');
        }
    }
    if(v==4){
        var  count=$("#attend"+v+" .nums"+v).size();
        if(count>9){
            alert('最多只能添加10条')
            return false;
        }else{
            $("#nums"+v).html(count+1);
            $("#attend4").append(tjren);
        }
    }
}

function changeCon(aI,v){
    studentSoft(aI);
    var selCon=$("#attend"+v+" #practice"+aI).find("option:selected").val();
    if(selCon=='论文'){
        $("#attend"+v+" #changeCon"+aI).html(lunwen);
    }else if(selCon=='专利'){
        $("#attend"+v+" #changeCon"+aI).html(zhuanli);
    }else if(selCon=='科研项目'){
        $("#attend"+v+" #changeCon"+aI).html(kyxmu);
    }else if(selCon=='学术竞赛'){
        $("#attend"+v+" #changeCon"+aI).html(xsjsai);
    }else if(selCon=='学术会议'){
        $("#attend"+v+" #changeCon"+aI).html(xshyi);
    }else if(selCon=='实习'){
        $("#attend"+v+" #changeCon"+aI).html(shixi);
    }else if(selCon=='工作'){
        $("#attend"+v+" #changeCon"+aI).html(gongzuo);
    }else if(selCon=='志愿者活动'){
        $("#attend"+v+" #changeCon"+aI).html(zyzhdong);
    }else if(selCon=='社团活动'){
        $("#attend"+v+" #changeCon"+aI).html(sthdong);
    }else if(selCon=='非学术竞赛'){
        $("#attend"+v+" #changeCon"+aI).html(fxsjsai);
    }else{
        $("#attend"+v+" #changeCon"+aI).html('');
    }
    if(selCon){
        $("#soft"+v).show();
    }
    else{
        $("#soft"+v).hide();
    }
    datepickerD();
}
function delete_soft(aI,v){
    if(parseInt($("#nums"+v).text())!= 0){
        $("#nums"+v).html(parseInt($("#nums"+v).text())-1);
    }
    var academicDel=$(".academic_id"+aI).val();
    var practiceDel=$(".practice_id"+aI).val();
    var activityDel=$(".activity_id"+aI).val();
    var recomdDel=$(".recomd_id"+aI).val();
    $("#atte"+v).val(parseInt(aI)-1);
    $("#attend"+v+" #change"+aI).remove();
    $("#attend"+v+" #changeCon"+aI).remove();
    $("#soft"+v).show();
    Ajax_del('','','',activityDel,academicDel,practiceDel,recomdDel,'');
}



//手动输入
function edit(gw,self,sh){
    chosen_config();
    $("#domeContent"+gw+" .univtitle"+self).addClass('hide');
    $("#domeContent"+gw+" .univtitle"+sh).removeClass('hide');
    $(".univtitle_select").chosen("destroy");
    $(".univtitle_select").chosen({
        no_results_text : "未找到此选项!",
        width:"240px"
    });
}

function confirm_delete(){
    event.returnValue = confirm("删除是不可恢复的，你确认要删除吗？");
}

        function chosen_config() {
            //院校中文名select框使用插件配置文件
            var config = {
                '.chosen-select': {},
                '.chosen-select-deselect': {allow_single_deselect: true},
                '.chosen-select-no-single': {disable_search_threshold: 10},
                '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                '.chosen-select-width': {width: "80%"}
            };
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
        }

function datepickerD(){
    $('.datetimepicker').datetimepicker({
        lang:"ch",           //语言选择中文
        format:"Y-m-d",      //格式化日期
        allowBlank:true,
        timepicker:false,    //关闭时间选项
        yearStart:2000,     //设置最小年份
        yearEnd:2050,        //设置最大年份
        todayButton:false    //关闭选择今天按钮
    }).destory();
}
function check_title() {
    var title = $("#title").val();
    if($("#id").val()){var id = $("#id").val();}
    if(title=="") {
        alert("请填写标题");
        $("#title").focus();
    } else {
        $.ajax({
            type: 'POST',
            url: 'index.php?r=cases/studentchecktitle',
            datatype : 'json',
            data: {title:title,id:id},
            success:function(data){
                if(data=="ok") {
                    alert("没有重复标题");
                } else if(data=="no") {
                    alert("有完全相同的标题存在");
                }
            }
        })
    }
}

function Ajax_del(domeDel,foreDel,adDel,acDel,acaDel,praDel,remDel,dataDel){
            $.ajax({
                type: 'POST',
                url: 'index.php?r=cases/studentdelete',
                datatype : 'json',
                data: {domeDel:domeDel,foreDel:foreDel,adDel:adDel,acDel:acDel,acaDel:acaDel,praDel:praDel,remDel:remDel,dataDel:dataDel},
                success:function(data){
                    if(data){
                        alert(data);
                    }else{
                        alert("已删除");
                    }

                }
            })

}


$("#foreign_select").change(function(){
    var univ_id=$("#foreign_select").val();
        $.ajax({
            type: 'POST',
            url: 'index.php?r=cases/studentajax',
            datatype:'json',
            data:{univ_id:univ_id},
            success:function(data){
                data = JSON.parse(data);
                if(data){
                    $("#country_select").chosen("destroy");
                    $("#country_select").val(data);
                    $("#country_select").chosen({
                        no_results_text : "未找到此选项!",
                        width:"10%"
                    });
                }
            }
        })

})

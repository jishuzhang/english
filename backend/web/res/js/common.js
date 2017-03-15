//通过artdialog打开iframe
//example: openiframe('index.php?app=demo&c=dialog&a=iframe2','id','title...',800,300)
function openiframe(iframeurl,id,title,width,height,returntype) {
	top.dialog({
			id: id,
			fixed: true,
			width: width,
			height: height,
			title: title,
			padding: 5,
			url: iframeurl,
            onclose: function () {
            if (this.returnValue) {
                if(returntype==1) {//返回缩略图＋隐藏input
                    $('#'+id+"_thumb").attr('src',this.returnValue);
                    $('#'+id).val(this.returnValue);
                }else if(returntype > 1){ //返回字符串,多文件
					$('#'+id+" ul").append(this.returnValue);
				}
				else {
                    $('#'+id).val(this.returnValue);
                }
            }
        }
		}).showModal(this);
	return false;
}
//跳转到url
function gotourl(url) {
	location.href = url;
}
//确认操作
function makedo(url,message) {
    if(confirm(message)) gotourl(url);
}
//分页快捷键跳转
$(document).keydown(function(e){
    if(e.which == 37 && $('#page-up').val()) {
        gotourl($('#page-up').val());
    }
    if(e.which == 39 && $('#page-next').val()) {
        gotourl($('#page-next').val());
    }
});
//联动菜单
function linkage(fieldid,linkid) {
    if(linkid!=0) {
        $("#"+fieldid).val(linkid);
    }
}

function msgtip(msgcontent) {
    var d = dialog({
        content: msgcontent
    });
    d.show();
    setTimeout(function () {
        d.close().remove();
    }, 2000);
}

function getUrlPara(paraName){  
    var sUrl  =  location.href; 
    var sReg  =  "(?://?|&){1}"+paraName+"=([^&]*)" 
    var re=new RegExp(sReg,"gi"); 
    re.exec(sUrl); 
    return RegExp.$1; 
} 

function relation_add(iframeurl) {
    var catid = getUrlPara('cid');
    var text = $("#relation_search").val();
    top.dialog({
        id: 'relation',
        fixed: true,
        width: 900,
        height: 530,
        title: '相关内容添加',
        padding: 5,
        url: iframeurl+catid+'&keywords='+encodeURIComponent(text),
        onclose: function () {
            if (this.returnValue) {
                var text=this.returnValue;
                var rela=$('#relation').val();
                $('#relation').val(rela+text);
                var htmls = text.split("~bbb~");
                var sstext = '';
                $.each(htmls, function(i,value){
                    if(value!='') {
                        sstext = value.split("~aaa~");
                        $("#relation_result").css("padding-top","5px");
                        $("#relation_result").append("<li><strong>标题：</strong><span>"+sstext[0]+"</span> <strong style='padding-left:30px;'>链接：</strong><span>"+sstext[1]+"</span><a style='color:red;' onclick='removeRelation(this);' class='pull-right cur' href='javascript:void(0);'>移 除</a></li>");
                    }
                });
            }
        }
    }).showModal(this);
}
function removeRelation(obj) {
    var rela_title = $(obj).parent().find("span:first").html();
    var rela_href = $(obj).parent().find("span:last").html();
    var remove_content = rela_title+'~aaa~'+rela_href+'~bbb~';
    var rela = $('#relation').val();
    var htmls = rela.split(remove_content);
    var text = htmls[0]+htmls[1];
    $('#relation').val(text);
    $(obj).parent().remove();
}
function change_value(id,value) {
    $("#"+id).val(value);
}

/**
 * 全选/反选
 * @param value selectAll或空
 * @param obj 当前对象
 */

function checkall(value,obj)  {
    var form=document.getElementsByTagName("form")
    for(var i=0;i<form.length;i++){
        for (var j=0;j<form[i].elements.length;j++){
            if(form[i].elements[j].type=="checkbox"){
                var e = form[i].elements[j];
                if (value=="selectAll"){e.checked=obj.checked}
                else{e.checked=!e.checked;}
            }
        }
    }
}
//记录当前URL，用于框架刷新
var iframe_url = window.location.href;
top.$("#iframeid").attr('url',iframe_url);

function baidumap(field) {
    top.dialog({
        id: 'baidumap',
        fixed: true,
        width: 960,
        height: 600,
        title: '地图标注',
        padding: 5,
        url: 'index.php?m=core&f=map&v=baidumap&x='+$("#"+field+"_x").val()+'&y='+$("#"+field+"_y").val()+'&zoom='+$("#"+field+"_zoom").val()+'&address='+$("#address").val(),
        onclose: function () {
            if (this.returnValue) {
                var returnValue=this.returnValue;
                var bmaps = returnValue.split(',');
                $("#"+field+"_x").val(bmaps[0]);
                $("#"+field+"_y").val(bmaps[1]);
                $("#"+field+"_zoom").val(bmaps[2]);
            }
        }
    }).showModal(this);
}
function getareaid(id) {
    $.getJSON("?m=content&f=city&v=getareaid", { id: id},
        function(data){
            $("#areaid").val(data.areaid);
            $("#fuwuid").val(data.fuwu);
        });
}


// iframe同域部分和iframe自动适应窗口大小
var iframeWindowSize = function() {
    return ["Height", "Width"].map(function(name) {
        return window["inner" + name] || document.compatMode === "CSS1Compat" && document.documentElement["client" + name] || document.body["client" + name]
    })
}
window.onload = function() {
    if (!+"\v1" && !document.querySelector) {
        document.body.onresize = iframeresize
    } else {
        window.onresize = iframeresize
    }
    function iframeresize() {
        iframeSize();
        return false
    }
}
function iframeSize() {
    var str = iframeWindowSize();
    var pxstrs = new Array();
    iframestrs = str.toString().split(",");
    var heights = iframestrs[0] - 108,
    Body = $('body');
    $('#iframeid').height(heights);
    if (iframestrs[1] < 980) {
        Body.attr('scroll', '');
        Body.removeClass('pxgridsbody')
    } else {
        Body.attr('scroll', 'no');
        Body.addClass('pxgridsbody')
    }
    var sidebar = $("#iframeid").height()+0;
    $('#treemain').height(sidebar+10);
    $("#sidebar").height(sidebar+42);
    iframeWindowSize();
}
iframeSize();


var Script = function () {
// 自定义滚动条
    $("html").niceScroll({autohidemode:false,cursorcolor : "#cacbcf",cursorwidth: '10',cursorborder:"none",horizrailenabled:false,mousescrollstep:55});
};



function edit(uid){
	top.openiframe('index.php?m=member&f=index&v=edit&uid='+uid+'&_su=wuzhicms&_menuid=30&_submenuid=30', 'editUser', '编辑用户', 800, 500);
}
function del(uid){
	if(!confirm('您确认要删除吗，该操作不可恢复！'))return false;
	$.getJSON('index.php?m=member&f=index&v=del&uid='+uid+'&_su=wuzhicms&_menuid=30&_submenuid=30&callback=?', function(data){
		if(data.status == 1){
			toast('删除成功');
			$('#u_'+uid).remove();
		}else{
			toast('删除失败');
		}
	});
}
function setpassword(uid, username, email){
	if(!confirm('您确认要重置该用户的密码吗！'))return false;
	$.getJSON('index.php?m=member&f=index&v=password&uid='+uid+'&username='+username+'&email='+email+'&_su=wuzhicms&_menuid=30&_submenuid=30&callback=?', function(data){
		if(data.status == 1){
			toast('重置成功');
			$("#u_'.$uid.' td").css("background-color", "#EFD04C");
		}else{
			toast('重置失败');
		}
	});
}
function toast(msg, time){
	time = time ? time*1000 : 2000;
	var d = top.dialog({
		id: 'toast',
	    content: msg,
	    fixed: true
	}).showModal();
	setTimeout(function () { d.close().remove(); }, time);
}


function get_child(linkageid, name, pid, field) {
    getChildHtml(linkageid, name, pid, field) ;

};



$(".linkage-menu a").hover(function(){
        $(this).css("background-color","#d9e4ed");
        $(this).css("color","black");
    },function(){
        $(this).css("background-color","");
        $(this).css("color","");
 });
 
 
function getChildHtml(linkageid, name, pid, field) {
   $.ajax({
	type: 'GET',
	url: 'index.php?r=field/getchildhtml',
	datatype : 'json',
	data: '&linkageid='+linkageid+'&pid='+pid+'&math='+Math.floor(Math.random()*1000+1),
	success: function(data){
		data = JSON.parse(data);
                getParentPath(linkageid, pid, field);
                if(data.length == 0){
                    $("#"+field+"target").modal('hide');
                    $("#"+field+"_hidden").val(linkageid);
                }else{
                    var child_html = '';
                    $.each(data, function(i,item) {
                            child_html +="<a onclick=get_child('"+item.linkageid+"','"+item.name+"','"+item.pid+"','"+field+"') href=javascript:void(0)>"+item.name+"</a>&nbsp;&nbsp;";
                    });
                    $('#ul_'+field).empty();
                    $('#ul_'+field).html(child_html);
                }

	}
    })    
}

function getParentPath(linkageid, pid, field){
   $.ajax({
	type: 'GET',
	url: 'index.php?r=field/getpath',
	datatype : 'json',
	data: '&linkageid='+linkageid+'&pid='+pid+'&math='+Math.floor(Math.random()*1000+1),
	success: function(data){
		data = JSON.parse(data);
		var path_html = '';
		$.each(data, function(i,item) {
			path_html +=item;
		});
                $('#path_'+field).empty();
                $('#'+field).empty();
		$('#path_'+field).html(path_html);
                $('#'+field).html(path_html);
	}
    })
}
//关键词个数限制
function reg(p)
{
    var s=$(p).val();
    if(s){
    var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？ ]");
    var rs = "";
    for (var i = 0; i < s.length; i++) {
        rs = rs+s.substr(i, 1).replace(pattern, ',');
    }
    var reg=rs.replace(/,$/gi,"");
    var arr=reg.split(',');
            var con='';
            for (var j = 0; j < arr.length; j++) {
                    if(!arr[j]){
                        alert('关键词输入有误');
                        $(p).focus();
                        return 0;
                    }else{
                        con =1;
                    }
            }
            if(con==1) {
                if (arr.length > 5) {
                    alert('关键词不能超过5个,请修改');
                    arr.pop();
                    $(p).focus();
                    return 0;
                } else {
                    $(p).val(reg);
                }
            }
        }
}
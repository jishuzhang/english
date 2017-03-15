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
// JavaScript Document
$(function () {
    var h=$(".addjk").height();
    $(".addjk").height(h);
    $(".bbinfo").height(h);
    $(".info ul li").eq(0).addClass("hover");
    $(".kind ul li").eq(0).addClass("hover");
    $(".jk ul li").eq(0).addClass("hover");

    /*添加*/
    $(".add ").each(function (index, element) {
        $(this).click(function () {
            $(".tj").eq(index).show();
            $(".shuru").val('');
        })
    });
    $(".add ").eq(2).click(function () {
        $(".addjk,#search3").show();
        $(".name").val("");
    })

    /*版本的确定*/
    $(".yes1").click(function () {
        $(".tj1").hide();
        var cont = $(".shuru1").val();
        if (cont != "") {
            $(".info ul li").removeClass("hover");
            //$(".info ul").append(
            //"<li class='hover'><i>"+cont+"</i><div class='cz'><a title='编辑'href='javascript:;'><span class='glyphicon  glyphicon-edit'></span> </a><a title='删除' href='javascript:;'><span class='glyphicon glyphicon-trash'></span></a></div></li>"
            //);
        }
        $(".kind ul li").hide();
        $(".jk ul li").hide();
        //$("#search2,#search3,.addjk").hide();
        //$(".add").eq(2).hide();
    })
    /*li的点击*/
    //$('body').on("click", '.info ul li', function () {
    //    $(".info ul li").removeClass("hover");
    //    $(this).addClass("hover");
    //    $(".kind ul li,.jk ul li").remove();
    //    $(".kind ul li").remove();
    //    $(".jk ul li").remove();
    //    $(".kind ul li,.jk ul li").removeClass("hover");
    //    $(".kind ul li:nth-child(1),.jk ul li:nth-child(1)").addClass("hover");
    //    $("#search2,#search3,.addjk").show();
    //    $(".add").eq(2).show();
    //    $(".name").val("ddfefeeee");
    //})
    //$('body').on("click", '.kind ul li', function () {
    //    $(".kind ul li").removeClass("hover");
    //    $(this).addClass("hover");
    //})
    //$('body').on("click", '.jk ul li', function () {
    //    $(".jk ul li").removeClass("hover");
    //    $(this).addClass("hover");
    //})
    /*类别的确定*/
    $(".yes2").click(function () {
        $(".tj2").hide();
        var cont = $(".shuru2").val();
        if (cont != "") {
            $(".kind ul li").removeClass("hover");
            //$(".kind ul").append(
            //	"<li class='hover'><i>"+cont+"</i><div class='cz'><a title='编辑'href='javascript:;'><span class='glyphicon  glyphicon-edit'></span> </a><a title='删除' href='javascript:;'><span class='glyphicon glyphicon-trash'></span></a></div></li>"
            //)
            ;
        }
        //$(".jk ul li").hide();
        $(".add").eq(2).show();
        $("#search2").show();
    })
    /*接口名称*/
    $(".yes3").click(function () {
        $(".tj3").hide();
        var cont = $(".shuru3").val();
        if (cont != "") {
            $(".kind ul li").removeClass("hover");

            ;
        }
        //$(".jk ul li").hide();
        $(".add").eq(2).show();
        $("#search2").show();
    })
    /*搜索按钮*/
    $("#sh1").click(function () {
        $(".info ul li").removeClass("hover");
        $(".info ul li:nth-child(1)").addClass("hover");
    })
    $("#sh2").click(function () {
        $(".kind ul li,.info ul li").removeClass("hover");
        $(".kind ul li:nth-child(1),.info ul li:nth-child(1)").addClass("hover");
    })
    $("#sh3").click(function () {
        $(".kind ul li,.jk ul li,.info ul li").removeClass("hover");
        $(".kind ul li:nth-child(1),.jk ul li:nth-child(1),.info ul li:nth-child(1)").addClass("hover");
    })

    /*添加属性*/
    $(".canshu .addsx").click(function () {
        /*只获取最后一个的tr,如果最后一个tr的数组的长度不为0时，允许追加一个tr*/
        var arr2 = new Array();
        var arr;
        var arr1;
        $("#request tr:last").find("td").each(function () {
            arr = $(this).children().val();
            arr1 = $(this).children().attr("name");
            if (arr1 == 'mandatory' || arr1 == 'format') {
                //alert($("#"+arr1).prop("checked"));
                if ($("#" + arr1).prop("checked")) {
                    arr = 1;
                } else {
                    arr = 0;
                }
            }
            arr2[arr1] = arr;
        });
        //console.log(arr2['parameter']);
        if (arr2['parameter'] != ''&&arr2['default'] != '') {
            $(".canshu .table").append("<tr><td><input type='text' name='parameter' class='cs'></td><td> <select name='type'class='cs'><option value='string' selected='selected'>string</option><option value='double'>double</option><option value='int'>int</option><option value='boolean'>boolean</option><option value='float'>float</option><option value='long'>long</option><option value='long'>json</option><option value='long'>data</option></select></td><td><input type='checkbox' id='mandatory' name='mandatory'></td><td><input type='checkbox' id='format' name='format'></td><td><input type='text' class='cs' name='sample'></td><td><input type='text' name='default' onblur='Request()' class='cs'><div class='edt'><a><span class='glyphicon  glyphicon-trash'></span> </a></div></td></tr>")
        }
    })

    $(".backadd").click(function () {
        /*只获取最后一个的tr,如果最后一个tr的数组的长度不为0时，允许追加一个tr*/
        var arr2 = new Array();
        var arr;
        var arr1;
        $("#back_list tr:last").find("td").each(function () {
            arr = $(this).children().val();
            arr1 = $(this).children().attr("name");
            arr2[arr1] = arr;
        });
        if (arr2['parameter'] != '') {
            $(".backcs .table").append("<tr><td><input type='text' name='parameter' class='cs'></td><td><input type='text' name='type' class='cs'></td><td><input type='text' name='description' class='cs'></td><td><input type='text' name='sample'  onblur='Back()' class='cs'><div class='edt'><a><span class='glyphicon  glyphicon-trash'></span> </a></div></td></tr>")
        }
    });

    /*json点击按钮*/
    $(".jsondr").click(function () {
        $(".jsontc").show();
    })
    $(".load").click(function () {
        $(".jsontc").hide();
    })

    /*返回示例点击事件*/
    /*	$(".backsl").click(function(){
     $(".lizi").val("{'ret': 400,'data': '[\"\"]', 'msg': '非法请求：缺少必要参数user_id}")
     })*/

    /*json窗口关闭*/
    $(".jsontc.ijscontc p span").click(function(){
        $(".jsontc.ijscontc").hide();
    })
    $(".jsontc p span").click(function(){
        $(".jsontc").hide();
    })

})

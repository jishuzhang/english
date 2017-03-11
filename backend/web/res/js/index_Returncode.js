
$(document).ready(function(){
    var h =  window.screen.availHeight-200;
    $(".container").height(h);

    /*刘新鹤-返回码JS*/
//点击上下更换排序
    //上移
    $(".Return_btom").on("click","a.up",function() {
        //    var $tr = $('.up').parents("tr");
        //     if ($tr.index() != 0) {
        //        $tr.fadeOut().fadeIn();
        //         $tr.prev().before($tr);

        // }
        var $up = $(".up")
        var $tr = $(this).parents("tr");
        if ($tr.index() != 0) {
            $tr.fadeOut().fadeIn();
            $tr.prev().before($tr);
        }

    });
    //下移
    $(".Return_btom").on("click","a.down",function() {
        var len = $('.down').length;
        var $tr = $(this).parents("tr");
        if ($tr.index() != len) {
            $tr.fadeOut().fadeIn();
            $tr.next().after($tr);
        }
    });

    /*刘新鹤-返回码JS*/
    /*刘新鹤-返回码-点击添加*/
    //$('.Return_add').click(function(){
    //    $('.Return_btom').append('<tr id="sort"><td><input type="text" /></td><td><input type="text" /></td><td><input type="text" /></td><td><a href="#" class="up btn">上移</a> <a href="#" class="down btn">下移</a><a class="btn shan">删除</a></td></tr>');
    //})


    /*刘新鹤-成员权限设置*/
    $(".ce > li > a").click(function(){
        /*$(this).addClass("xz").parents().siblings().find("a").removeClass("xz");*/
        $(this).parents().siblings().find(".er").hide(300);
        $(this).siblings(".er").toggle(300);
        $(this).parents().siblings().find(".er > li > .thr").hide().parents().siblings().find(".thr_nr").hide();

    })

    $(".er > li > a").click(function(){
        /*$(this).addClass("sen_x").parents().siblings().find("a").removeClass("sen_x");*/
        $(this).parents().siblings().find(".thr").hide(300);
        $(this).siblings(".thr").toggle(300);
    })

    $(".thr > li > a").click(function(){
        /* $(this).addClass("xuan").parents().siblings().find("a").removeClass("xuan");*/
        $(this).parents().siblings().find(".thr_nr").hide();
        $(this).siblings(".thr_nr").toggle();
    })
    /*刘新鹤-成员权限设置*/
    /*刘新鹤-成员设置首页*/
    //$('.Mer_establish_01').hover(function() {
    //    $('.Mer_establish_01 span').show();
    //}, function() {
    //    $('.Mer_establish_01 span').hide();
    //});
    /*刘新鹤-成员设置首页*/

});

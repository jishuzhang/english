<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<style>
    .Return_top ul li .save {
        background: #3498db none repeat scroll 0 0;
        border: 0 none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        display: inline;
        height: 30px;
        font-size: 15px;
        line-height: 30px;
        line-height: 30px;
        margin-top: 10px;
        padding: 0 20px;
    }

    .Return_top ul li #import_excel {
        background: #3498db none repeat scroll 0 0;
        border: 0 none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        display: inline;
        height: 30px;
        line-height: 30px;
        margin-top: 10px;
        padding: 0 20px;
    }

    .Return_top ul li a {
        background: #3498db none repeat scroll 0 0;
        border: 0 none;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        display: inline;
        height: 30px;
        width: 50px;
        line-height: 30px;
        margin-top: 10px;
        padding: 0 20px;
    }
    #import {position: absolute; left: 330px; top:0px; }
    .Return_btom td .btn { padding:0 ; }
    .formWrap { position:relative; }

</style>
<div class="wrapper">
    <div class="formWrap">
        <?php $form = ActiveForm::begin(['action' => ['code/inexcel'],'method'=>'post','options'=>['enctype'=>'multipart/form-data'],'id'=>'import']); ?>
        <!--    <form action="index.php?r=code/inexcel" method="post" enctype="multipart/form-data">-->
        <div class="Return_top">
            <ul>
                <li><input type="file" name="upload_file" id="upload_file" style="width:150px; display: none;"></li>
                <li class="returncode_prompt"> <input type="button" id="import_excel" value="导入EXCEL">  </li>
            </ul>
        </div>
        <!--    </form>-->
        <?php ActiveForm::end(); ?>
        <?php $form = ActiveForm::begin(['action' => ['code/create'],'method'=>'post',]); ?>
        <div class="Return_top">
            <p class="Return">返回码</p>
            <ul>
                <li><input type="submit" value="保存" class="save"/></li>
                <li class="returncode_prompt" id="outit"><div><a href="index.php?r=code/outexcel">导出EXCEL</a></div></li>
            </ul>
        </div>

        <table class=" table table-hover Return_btom">
            <thead id="sort">
            <tr>
                <th class="tablehead" width="10%">排序</th>
                <th class="tablehead" width="13%">返回码</th>
                <th class="tablehead" width="17%" style="padding-right: 50px">描述</th>
                <th class="tablehead" width="20%" style="padding-right: 50px">说明</th>
                <th class="tablehead" width="10%">等级</th>
                <th class="tablehead" width="15%">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($info as $key => $val){?>

                <tr id="ddd">
                    <td>
                        <input class="ud" style=" text-align:center;"   type="text" name="orders[]" value="<?= $val['orders'] ?>" />
                    </td>
                    <td  >
                        <input class="ud codes code<?=$val['return_codes_id']?>" style=" text-align:center"  type="text" name="code[]" value="<?= $val['code'] ?>" />
                    </td>
                    <td>
                        <input class="ud" style=" text-align:center"   type="text" name="description[]" value="<?= $val['description'] ?>" />
                    </td>
                    <td>
                        <input class="ud" style=" text-align:center"   type="text" name="caption[]" value="<?= $val['caption'] ?>" />
                    </td>

                    <td style="padding-left: 30px"  >
                        <select class="ud" name="level[]">
                            <option <?php if($val['level']==1){echo "selected='selected'";}?> value="1">1</option>
                            <option <?php if($val['level']==2){echo "selected='selected'";}?> value="2">2</option>
                            <option <?php if($val['level']==3){echo "selected='selected'";}?> value="3">3</option>
                        </select>
                    </td>

<!--                    <input  type="hidden" name="sort[]" value="--><?//=$key;?><!--">-->
                    <td>
                        <input  type="hidden" name="return_codes_id[]" value="<?=$val['return_codes_id']?>" class="hidd">
<!--                        <a  class="up btn">上移</a>-->
<!--                        <a  class="down btn">下移</a>-->
                        <a  style="width: 50px ;text-align:center" class="btn btn-danger deleteTr" href="javascript:makedo('/index.php?r=code/delete&id=<?= $val['return_codes_id'] ?>', '确认删除该记录？')" >删除</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div class="Return_top">
            <ul>
                <li> <input type="submit" class="save" value="排序"/></li>
                <li><div class="Return_add" style="height: 50px" >添加</div></li>
            </ul>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script type="text/javascript">
//    var idd = $(this).attr("id");
//文本框值改变即触发提示是否离开当前页面
$(document).ready(function(){
    var changeFlag=false;
    //标识文本框值是否改变，为true，标识已变
    //文本框值改变即触发
    $("input[type='text']").change(function(){
        changeFlag=true;
    });
    $('.returncode_prompt').click(function(){
        $('.hidd').each(function(){
            var hid = $(this).val();
            if(!hid){
                var code = $(this).parents().parents().find('.code').val();
                if(code){
                    changeFlag=true;
                }
            }
        });
        if(changeFlag==true && !confirm('你有已经编辑的数据未保存，确定要离开？（如刷新或者关闭页面则视为强制退出！！）')){
            return false;
        }
    });
});

    //确认删除？
    function makedo(url,message) {
        if(confirm(message)) location.href = url;
    }

    //js添加操作
    $('.Return_add').click(function(){
        $('.Return_btom').append('<tr id="ddd" >' +
        '<td>' +
        '<input style="text-align:center" type="text" name="orders[]"/>' +
        '</td>' +
        '<td>' +
        '<input class="code" style="text-align:center" type="text" name="code[]"/>' +
        '</td>' +
        '<td>' +
        '<input style="text-align:center" type="text" name="description[]"/>' +
        '</td>' +
        '<td>' +
        '<input style="text-align:center" type="text" name="caption[]"/>' +
        '</td>' +
        '<td style="padding-left: 30px">' +
//        '<input  type="hidden" name="sort[]" value="100000">'+
        '<select class="ud" name="level[]">' +
        '<option value="1">1</option>' +
        '<option value="2">2</option>' +
        '<option value="3">3</option>' +
        '</select>' +
        '</td>' +
        '<td>' +
//        '<a  href="#" class="up1 btn" title="请保存之后在进行移动操作">上移</a>'+
//        '<a  href="#" class="down1 btn" title="请保存之后在进行移动操作">下移</a>'+
        '<input  type="hidden" name="return_codes_id[]" value="" class="hidd"><a style="width: 50px" class="btn btn-danger deleteTr" onclick="deleteTr(this)">删除</a>' +
        '</td>' +
        '</tr>');
    });
    //删除新添加行
    function deleteTr(nowTr){
        //多一个parent就代表向前一个标签,
        // 本删除范围为<td><tr>两个标签,即向前两个parent
        //如果多一个parent就会删除整个table
        $(nowTr).parent().parent().remove();
    }

    function Visionedit(){
        var vision = $(".vision_").text();
        alert(vision);
    }
    //当页面无数据时进行提示无法导出
    $('#outit').click(function(){
        var ttt = $('.ud').val();
        if(!ttt){
            alert('当前页面无数据，无法导出！！！');
            return false;
        }

    });
    //当页面无数据时提醒添加数据
    $('.save').click(function(){
        var ttt = $('.ud').val();
        if(!ttt){
            alert('请先添加数据或者导入数据再进行此操作！！！');
            return false;
        }

    });

    //导入文件提示
    $("#import_excel").click(function(e){

        $("#upload_file").trigger('click');
        $("#upload_file").change(function(){

            var a = $("#upload_file").val();
            var fileExtension = a.split('.').pop().toLowerCase();
            //alert(fileExtension);
            if(fileExtension != "xls" && fileExtension != "xlsx"){
                alert("您选择的不是excel文件！请重新选择");
                return false;
            }

            var is_confirm = confirm("你导入的文件内容将会展示在列表的下方，确定导入吗？");
            if(is_confirm){
                $('#import').submit();
            }
        });


    });

</script>

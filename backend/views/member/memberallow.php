<?php
use yii\widgets\ActiveForm;

?>
<div class="wrapper">
    <div class="member_top_btn">
        <div ><a  href="index.php?r=member/index">成员设置</a></div>
        <div ><a href="javascript:;">成员权限设置</a></div>
    </div>
    <?php $form = ActiveForm::begin(['action' => ['member/app_nodes_save'],'method'=>'post','id'=>'app_nodes_save']); ?>
    <table class="member_center">
        <tr>
            <td class="member_back "><?= $app_title['title'] ?></td>
        </tr>
        <?php foreach($result as $key=>$value){  ?>
            <td colspan="4" class="member_back" value="" ><?php if($key=='member'){echo'设置';}if($key == 'apiajax'){echo'接口管理';}if($key=='test'){echo'测试';}if($key=='code'){echo'返回码';} ;?></td>
        <tr >
            <td colspan="3">
                <?php foreach($value as $k=>$v){  ?>
                        <span><input type="checkbox" <?php if(in_array($v['nodes_id'],$nodes_arr)){  echo "checked='checked'";}?> value="<?= $v['nodes_id']?>" /><?= $v['title']?></span>
                <?php }?>
            </td>
        </tr>
        <?php } ?>
       <!--<tr>
            <td  style="width:210px; display:block;">
                <span class="member_border02" style="border-left:0px;">版本</span>
                <span><input type="checkbox" />修改</span>
                <span><input type="checkbox" />查看</span>
                <span><input type="checkbox" />删除</span>
            </td>

            <td colspan="2" >
                <span class="member_border02">类别</span>
                <span><input type="checkbox" />修改</span>
                <span><input type="checkbox" />查看</span>
                <span><input type="checkbox" />删除</span>
            </td>
            <td >
                <span class="member_border02"> 接口</span>
                <span><input type="checkbox" />修改</span>
                <span><input type="checkbox" />查看</span>
                <span><input type="checkbox" />删除</span>
            </td>
        </tr>
    </table>
    <ul class="ce">
        <li>
            <a href="javascript:;" class="a_01">v1 </a><div class="xiu">
                <span><input type="checkbox" />修改</span>
                <span><input type="checkbox" />查看</span>
                <span><input type="checkbox" />删除</span></div>
            <ul class="er">
                <li class="e_li">
                    <a href="javascript:;">用户数据</a><div class="xiu">
                        <span><input type="checkbox" />修改</span>
                        <span><input type="checkbox" />查看</span>
                        <span><input type="checkbox" />删除</span></div>
                    <ul class="thr">
                        <li>
                            <a href="javascript:;" class="left_30">user</a>
                            <div class="xiu">
                                <span><input type="checkbox" />修改</span>
                                <span><input type="checkbox" />查看</span>
                                <span><input type="checkbox" />删除</span>
                            </div>
                        </li>
                        <li>
                            <a href="javascript:;" class="left_30">other</a>
                            <div class="xiu">
                                <span><input type="checkbox" />修改</span>
                                <span><input type="checkbox" />查看</span>
                                <span><input type="checkbox" />删除</span>
                            </div>
                        </li>

                        <div class="clear"></div>
                    </ul>
                </li>

                <li class="e_li">
                    <a href="javascript:;">资讯内容</a><div class="xiu">
                        <span><input type="checkbox" />修改</span>
                        <span><input type="checkbox" />查看</span>
                        <span><input type="checkbox" />删除</span></div>
                    <ul class="thr">
                        <li>
                            <a href="javascript:;" class="left_30">user</a>
                            <div class="xiu">
                                <span><input type="checkbox" />修改</span>
                                <span><input type="checkbox" />查看</span>
                                <span><input type="checkbox" />删除</span>
                            </div>
                        </li>
                        <li>
                            <a href="javascript:;" class="left_30">other</a>
                            <div class="xiu">
                                <span><input type="checkbox" />修改</span>
                                <span><input type="checkbox" />查看</span>
                                <span><input type="checkbox" />删除</span>
                            </div>
                        </li>

                        <div class="clear"></div>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;">v2 </a><div class="xiu">
                <span><input type="checkbox" />修改</span>
                <span><input type="checkbox" />查看</span>
                <span><input type="checkbox" />删除</span></div>
            <ul class="er">
                <li class="e_li">
                    <a href="javascript:;">用户数据</a><div class="xiu">
                        <span><input type="checkbox" />修改</span>
                        <span><input type="checkbox" />查看</span>
                        <span><input type="checkbox" />删除</span></div>
                    <ul class="thr">
                        <li>
                            <a href="javascript:;" class="left_30">user</a>
                            <div class="xiu">
                                <span><input type="checkbox" />修改</span>
                                <span><input type="checkbox" />查看</span>
                                <span><input type="checkbox" />删除</span>
                            </div>
                        </li>
                        <li>
                            <a href="javascript:;" class="left_30">other</a>
                            <div class="xiu">
                                <span><input type="checkbox" />修改</span>
                                <span><input type="checkbox" />查看</span>
                                <span><input type="checkbox" />删除</span>
                            </div>
                        </li>

                        <div class="clear"></div>
                    </ul>
                </li>

                <li class="e_li">
                    <a href="javascript:;">资讯内容</a><div class="xiu">
                        <span><input type="checkbox" />修改</span>
                        <span><input type="checkbox" />查看</span>
                        <span><input type="checkbox" />删除</span></div>
                    <ul class="thr">
                        <li>
                            <a href="javascript:;" class="left_30">user</a>
                            <div class="xiu">
                                <span><input type="checkbox" />修改</span>
                                <span><input type="checkbox" />查看</span>
                                <span><input type="checkbox" />删除</span>
                            </div>
                        </li>
                        <li>
                            <a href="javascript:;" class="left_30">other</a>
                            <div class="xiu">
                                <span><input type="checkbox" />修改</span>
                                <span><input type="checkbox" />查看</span>
                                <span><input type="checkbox" />删除</span>
                            </div>
                        </li>

                        <div class="clear"></div>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;">v3 </a><div class="xiu">
                <span><input type="checkbox" />修改</span>
                <span><input type="checkbox" />查看</span>
                <span><input type="checkbox" />删除</span></div>
            <ul class="er">
                <li class="e_li">
                    <a href="javascript:;">用户数据</a><div class="xiu">
                        <span><input type="checkbox" />修改</span>
                        <span><input type="checkbox" />查看</span>
                        <span><input type="checkbox" />删除</span></div>
                    <ul class="thr">
                        <li>
                            <a href="javascript:;" class="left_30">user</a>
                            <div class="xiu">
                                <span><input type="checkbox" />修改</span>
                                <span><input type="checkbox" />查看</span>
                                <span><input type="checkbox" />删除</span>
                            </div>
                        </li>
                        <li>
                            <a href="javascript:;" class="left_30">other</a>
                            <div class="xiu">
                                <span><input type="checkbox" />修改</span>
                                <span><input type="checkbox" />查看</span>
                                <span><input type="checkbox" />删除</span>
                            </div>
                        </li>

                        <div class="clear"></div>
                    </ul>
                </li>

                <li class="e_li">
                    <a href="javascript:;">资讯内容</a><div class="xiu">
                        <span><input type="checkbox" />修改</span>
                        <span><input type="checkbox" />查看</span>
                        <span><input type="checkbox" />删除</span></div>
                    <ul class="thr">
                        <li>
                            <a href="javascript:;" class="left_30">user</a>
                            <div class="xiu">
                                <span><input type="checkbox" />修改</span>
                                <span><input type="checkbox" />查看</span>
                                <span><input type="checkbox" />删除</span>
                            </div>
                        </li>
                        <li>
                            <a href="javascript:;" class="left_30">other</a>
                            <div class="xiu">
                                <span><input type="checkbox" />修改</span>
                                <span><input type="checkbox" />查看</span>
                                <span><input type="checkbox" />删除</span>
                            </div>
                        </li>
                        <div class="clear"></div>
                    </ul>
                </li>
            </ul>
        </li>
        <div class="clear"></div>
    </ul>
    <table class="member_btom">
        <tr class="member_back">
            <td colspan="4" class="member_back">测试</td>
        </tr>
        <tr>
            <td colspan="4"><span><input type="checkbox" />查看</span></td>
        </tr>
        <tr class="member_back">
            <td colspan="4" class="member_back">返回码</td>
        </tr>
        <tr>
            <td colspan="4">
                <span><input type="checkbox" />查看</span>
                <span><input type="checkbox" />增加</span>
                <span><input type="checkbox" />删除</span>
                <span><input type="checkbox" />修改</span>
                <span><input type="checkbox" />导入</span>
                <span><input type="checkbox" />导出</span>
                <span><input type="checkbox" />上移</span>
                <span><input type="checkbox" />下移</span>
            </td>
        </tr>
        <tr class="member_back">
            <td colspan="4" class="member_back">数据结构</td>
        </tr>
        <tr>
            <td  style="width:280px; display:block;">
                <span class="member_border02 member_border02_02" style="border-left:0px;">数据库</span>
                <span><input type="checkbox" />增加</span>
                <span><input type="checkbox" />修改</span>
                <span><input type="checkbox" />查看</span>
                <span><input type="checkbox" />删除</span>
            </td>

            <td colspan="2" >
                <span class="member_border02 member_border02_02">数据表</span>
                <span><input type="checkbox" />增加</span>
                <span><input type="checkbox" />修改</span>
                <span><input type="checkbox" />查看</span>
                <span><input type="checkbox" />删除</span>
            </td>
            <td >
                <span class="member_border02 member_border02_02"> 数据字段</span>
                <span><input type="checkbox" />增加</span>
                <span><input type="checkbox" />修改</span>
                <span><input type="checkbox" />查看</span>
                <span><input type="checkbox" />删除</span>
            </td>
        </tr>
        <tr class="member_back">
            <td colspan="5" class="member_back">设置</td>
        </tr>
        <tr>
            <td colspan="3" >
                <span class="member_border02 member_border02_02">成员设置</span>
                <span><input type="checkbox" />增加</span>
                <span><input type="checkbox" />修改</span>
                <span><input type="checkbox" />查看</span>
                <span><input type="checkbox" />删除</span>
            </td>
        </tr>-->
    </table>
    <input type="hidden" id="users_id" value="<?= $users_id ?>">
    <?php ActiveForm::end(); ?>
</div>

<script>
    var url = $('#app_nodes_save').attr('action');
    var method = $('#app_nodes_save').attr('method');
    var users_id = $('#users_id').val();
    $('#app_nodes_save input').change(function (){

        var _csrf = $('input[name="_csrf"]').val();
        var nodes_Id = $(this).val();
        var isSelected = $(this).is(':checked') ? 1 : 0 ;
        var data = {_csrf:_csrf,nodes_id:nodes_Id,users_id:users_id,isSelected:isSelected};

        $.ajax({
            url:url,
            data:data,
            type:method,
            success:function (data){
                if(data==1){

                }else if(data==3){
                    alert('存在');
                }else{
                    alert('失败');
                }
            },
            error:function (e){
                alert(e.responseText);
            },
        });
    });
</script>
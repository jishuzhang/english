<?php
use yii\helpers\Url;

?>
<link href="/res/css/chosen.css" rel="stylesheet">
<div class="wrapper wra">
    <!--版本信息-->
    <div class="bbinfo info">
            <div class="search" id="search1">
                <select class="chosen-select banben" style="float:left;"  name="info[banben]" id="banben">
                    <option value="0" selected="selected">全部</option>
                    <?php if(!empty($vision)){foreach($vision as $key => $value){ ?>
                        <option value="<?=$value['interface_vision_id']?>"><?= $value['vision']?></option>
                    <?php } }?>
                </select>
                <button type="button" id="sh1" class="btn btn-info sh" onclick="Search('banben')" >搜索</button>
            </div>
            <h5>版本信息</h5>
            <ul id="vision_ul">
                <?php if(!empty($v_list)){ foreach($v_list as $k=>$v){ ?>
                <li >
                    <i id="vision_<?=$v['interface_vision_id']?>" value="<?=$v['interface_vision_id']?>"><?= $v['vision'] ?></i>
                    <div class="cz">
                        <a title="编辑" href="javascript:;">
                            <span onclick="Visionedit(<?=$v['interface_vision_id']?>)"  class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a title="删除" href="javascript:;">
                            <span onclick="Delvision(<?=$v['interface_vision_id']?>)" class="glyphicon glyphicon-trash"></span>
                        </a>
                    </div>
                </li>
                <?php }}else{ ?>
                    <li ></li>
                <?php }?>
            </ul>
            <div class="tj tj1">
                <input type="text" id="vision" class="shuru shuru1">
                <input type="button" id="addvision" onclick="Visions()" class="btn btn-info yes yes1" value="确定">
            </div>
            <input type="button" class="btn btn-info add" value="添加">
    </div>
    <!--类别信息-->
    <div class="bbinfo kind">
            <div class="search" id="search2">
                <select class="chosen-select banben" style="float:left;"  name="info[kinds]" id="user">
                    <option value="0" selected="selected">全部</option>
                    <?php if(!empty($type)){ foreach($type as $key=>$value){ ?>
                    <option value="<?= $value['interface_type_id']?>"><?= $value['title']?></option>
                    <?php } }?>
                </select>
                <button type="button" id="sh2" class="btn btn-info sh" onclick="Search('user')">搜索</button>
            </div>

            <h5>类别信息</h5>
            <input type="hidden" id="interface_vision_id" value="<?php if(!empty($v_list)){ echo $v_list[0]['interface_vision_id']; } ?>">
            <ul id="type_ul">
                    <?php if(!empty($type_list)){ foreach($type_list as $k=>$v){?>
                    <li class="cz">
                        <i value="<?=$v['interface_type_id']?>" id="type_<?=$v['interface_type_id']?>"><?= $v['title']?></i>
                        <div class="cz">
                            <a title="编辑" href="javascript:;"><span onclick="Typeedit(<?=$v['interface_type_id']?>)"  class="glyphicon glyphicon-edit"></span> </a>
                            <a title="删除" href="javascript:;"><span onclick="Typedel(<?=$v['interface_type_id']?>)"  class="glyphicon glyphicon-trash"></span> </a>
                        </div>
                    </li>
                    <?php }}else{ ?>
                    <li></li>
                    <?php }?>
            </ul>
            <div class="tj tj2">
                <input type="text" id="type" class="shuru shuru2">
                <input type="button" onclick="Typeadd()" class="btn btn-info yes yes2" value="确定">
            </div>
            <input type="button" class="btn btn-info add" value="添加">
    </div>
    <!--接口名称-->
    <div class="bbinfo jk">
            <div class="search" id="search3">
                <select class="chosen-select banben" style="float:left;"  name="info[kinds]" id="jkname">
                    <option value="0" selected="selected">全部</option>
                    <?php if(!empty($interface)){foreach($interface as $key => $value){ ?>
                    <option value="<?=$value['interface_id']?>"><?=$value['title']?></option>
                    <?php }} ?>
                </select>
                <button type="button" id="sh3" class="btn btn-info sh" onclick="Search('jkname')">搜索</button>
            </div>

            <h5>接口名称</h5>
            <input type="hidden" id="interface_type_id" value="<?php if(!empty($type_list)){ echo $type_list[0]['interface_type_id']; }?>">
            <ul id="api_ul">
                <?php if(!empty($api_list)){ foreach($api_list as $k => $v){ ?>
                <li>
                    <i onclick="jk_ul_li_i(<?=$v['interface_id']?>,this)" value="<?=$v['interface_id']?>" id="interface_<?=$v['interface_id']?>"><?=$v['title']?></i>
                    <div class="cz">
                        <a title="编辑" onclick="Apiedit(<?=$v['interface_id']?>)" href="javascript:;"><span class="glyphicon bianji_03 glyphicon-edit"></span> </a>
                        <a title="删除" onclick="Apidel(<?=$v['interface_id']?>)" href="javascript:;"><span class="glyphicon glyphicon-trash"></span> </a>
                    </div>
                </li>
                <?php }}else{ ?>
                <li></li>
                <?php } ?>
            </ul>
          <div class="tj tj3">
              <input type="text" id="api_title" class="shuru shuru3">
              <input type="button"  onclick="Apiadd()" class="btn btn-info yes yes3" value="确定">
          </div>
            <input type="button" class="btn btn-info add" value="添加">
    </div>



    <div class="addjk">
        <input type="hidden" id="interface_id" value="<?php if(!empty($interface)){ echo $interface[0]['interface_id']; }?>">
        <div class="jkname">
            <span>接口名称：</span><input class="name" class="api_name" id="api_name" type="text" value="<?php if(!empty($api_info)){ echo $api_info['title'];}  ?>">
        </div>
        <div class="jkname">
            <span>接口描述：</span><textarea id="api_description" class="ms"><?php if(!empty($api_info)){ echo $api_info['description'];}?></textarea>
        </div>
        <select name="" class="json" id="api_pam_type">
            <option <?php if(!empty($api_info)){if($api_info['pam_type']=='JSON' ){echo 'selected="selected"';}}?> value="JSON">JSON</option>

<!--            <option --><?php //if($api_info['pam_type']=='JSON' ){echo 'selected="selected"';}?><!-- value="JSON">JSON</option>-->
            <option   <?php if(!empty($api_info)){if($api_info['pam_type']=='XML'){echo 'selected = "selected"';}}?> value="XML">XML</option>


<!--            <option   --><?php //if($api_info['pam_type']=='XML' && !empty($api_info)){echo 'selected = "selected"';}?><!-- value="XML">XML</option>-->
        </select>
        <select name="" class="json" id="api_method">
            <option <?php if(!empty($api_info)){ if($api_info['method']==='GET' ){echo 'selected = "selected"';}}?> value="GET" >GET</option>
            <option <?php if(!empty($api_info)){ if($api_info['method']==='POST' ){echo 'selected = "selected"';}}?> value="POST">POST</option>
            <option <?php if(!empty($api_info)){ if($api_info['method']==='PUT' ){echo 'selected = "selected"';}}?> value="PUT">PUT</option>
            <option <?php if(!empty($api_info)){ if($api_info['method']==='DELETE' ){echo 'selected = "selected"';}}?> value="DELETE">DELETE</option>
        </select>
        <!--请求参数-->
        <div class="canshu">
            <h6>请求参数</h6>
            <table id="request" class="table table-striped table-bordered ">
                <thead>
                <tr class="bg_color">
                    <td>请求参数</td>
                    <td>请求类型</td>
                    <td>是否必填</td>
                    <td>Json格式化传输</td>
                    <td>示例</td>
                    <td>默认值</td>
                </tr>
                <tbody id="request_list">
                <?php if(!empty($api_request)){ foreach($api_request as $key=>$value){?>
                    <tr val="<?= $value['required_id']?>" >
                        <td><input type='text'class='cs' name="parameter" value="<?=$value['parameter']?>"></td>
                        <td>
                            <select name='type' class='cs' id='type'>
                                <option <?php if($value['type']==='string'){echo 'selected = "selected"';}?> value='string'>string</option>
                                <option <?php if($value['type']==='double'){echo 'selected = "selected"';}?> value="double">double</option>
                                <option <?php if($value['type']==='int'){echo 'selected = "selected"';}?> value='int'>int</option>
                                <option <?php if($value['type']==='boolean'){echo 'selected = "selected"';}?> value='boolean'>boolean</option>
                                <option <?php if($value['type']==='float'){echo 'selected = "selected"';}?> value='float'>float</option>
                                <option <?php if($value['type']==='long'){echo 'selected = "selected"';}?> value='long'>long</option>
                                <option <?php if($value['type']==='json'){echo 'selected = "selected"';}?> value='json'>json</option>
                                <option <?php if($value['type']==='data'){echo 'selected = "selected"';}?> value='data'>data</option>
                            </select>
                        </td>
                        <td>
                            <input name="mandatory" type="checkbox" value="<?php echo $value['mandatory']?>" <?php  if($value['mandatory']=='1'){ echo 'checked="checked"'; }?>>
                        </td>
                        <td>
                            <input name="format" type="checkbox" value="<?php $value['format']?>" <?php  if($value['format']=='1'){  echo 'checked="checked"';}  ?>>
                        </td>
                        <td>
                            <input name="sample" value="<?=$value['sample']?>" type='text' class='cs'>
                        </td>
                        <td>
                            <input name="default" value="<?=$value['default']?>" type='text' class='cs'>
                            <div class='edt'>
                                <a><span class='glyphicon  glyphicon-trash' onclick="Delrequest(<?=$value['required_id'] ?>)"></span> </a>
                            </div>
                        </td>
                    </tr>
                <?php }}else{?>
                    <tr></tr>
                <?php } ?>

                </tbody>
                </thead>
            </table>
            <a class="btn btn-info addsx">添加属性</a>
        </div>

        <!--返回参数-->
        <div class="backcs">
            <h6>返回参数</h6>
            <table class="table table-striped table-bordered">
                <thead>
                <tr class="bg_color">
                    <td>参数名称</td>
                    <td>参数类型</td>
                    <td>参数说明</td>
                    <td>示例</td>
                </tr>
                </thead>
                <tbody id="back_list">
                <?php if(!empty($api_return)){ foreach($api_return as $key => $value){?>
                    <tr val="<?= $value['back_id']?>" >
                        <td>
                            <input type='text'class='cs' name="parameter" value="<?=$value['parameter']?>"></td>
                        <td>
                            <input type='text'class='cs' name="type" value="<?=$value['type']?>">
                        </td>
                        <td>
                            <input type='text'class='cs' name="description" value="<?=$value['description']?>">
                        </td>
                        <td>
                            <input type='text' class='cs' name="sample" value="<?=$value['sample']?>">
                            <div class='edt'>
                                <a>
                                    <span class='glyphicon  glyphicon-trash' onclick="Delback(<?=$value['back_id']?>)"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } } else{ ?>
                    <tr></tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="btns">
                <a class="btn btn-info backadd">添加属性</a>
                <a class="btn btn-info jsondr">Json导入</a>
                <a class="btn btn-info clears" onclick="Delback()">清空</a>
                <a class="btn btn-info backsl" onclick="Return_example()">添加返回示例</a>
            </div>
        </div>
        <!--返回示例-->
        <div class="resulttabs">
            <span class="active">返回示例</span>
        </div>
        <div class="cont">
            <textarea class="lizi" id="api_return_sample"><?php if(!empty($api_info)){$api_info['return_sample'];}?></textarea>
        </div>
        <div class="buttons">
            <button class="btn btn-info save" onclick="Interface()">保存</button>
            <a id="get_vision_url" url="<?=Url::to(['test/index'])?>" class="btn btn-primary test">测试</a>
        </div>
    </div>
    <div class="jsontc">
        <p>请输入json<span>X</span></p>
        <textarea id="importjson" class="jsoncont"></textarea>
        <a class="btn btn-info load" onclick="Importjson()">点击导入</a>
    </div>



    <!--接口添加-->

</div>

<script type="text/javascript" src="res/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="res/js/jkmanage.js"></script>
<script type="text/javascript"  src="res/js/apiajax.js"></script>
<script type="text/javascript">
    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        '.chosen-select-width'     : {width:"95%"},
        '.chosen-select-float'     : {float:"left"}
    };

    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

</script>

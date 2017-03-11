<?php
use yii\helpers\Url;
?>
<link rel="stylesheet" href="/res/css/bootstrap.min.css">
<link rel="stylesheet" href="/res/css/bootstrapreset.css">
<link rel="stylesheet" href="/res/css/index_Returncode.css">
<link rel="stylesheet" href="/res/css/main.css">

<!--接口添加-->

<div class="addjk" style="float: left; margin-left: 0;width: 100%;">
    <input type="hidden" id="interface_id" value="<?=$interface[0]['interface_id']?>">
    <div class="jkname">
        <span>接口名称：</span><input class="name" class="api_name" id="api_name" type="text" value="<?=$api_info['title']?>">
    </div>
    <div class="jkname">
        <span>接口描述：</span><textarea id="api_description" class="ms"><?=$api_info['description']?></textarea>
    </div>
    <select name="" class="json" id="api_pam_type">
        <option <?php if($api_info['pam_type']=='JSON'){echo 'selected="selected"';}?> value="JSON">JSON</option>
        <option   <?php if($api_info['pam_type']=='XML'){echo 'selected = "selected"';}?> value="XML">XML</option>
    </select>
    <select name="" class="json" id="api_method">
        <option <?php if($api_info['method']==='GET'){echo 'selected = "selected"';}?> value="GET" >GET</option>
        <option <?php if($api_info['method']==='POST'){echo 'selected = "selected"';}?> value="POST">POST</option>
        <option <?php if($api_info['method']==='PUT'){echo 'selected = "selected"';}?> value="PUT">PUT</option>
        <option <?php if($api_info['method']==='DELETE'){echo 'selected = "selected"';}?> value="DELETE">DELETE</option>
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
            <?php foreach($api_request as $key=>$value){?>
                <tr val="<?= $value['required_id']?>">
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
            <?php }?>

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
            <?php foreach($api_return as $key => $value):?>
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
            <?php endforeach;?>
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
        <textarea class="lizi" id="api_return_sample"><?=$api_info['return_sample']?></textarea>
    </div>
    <div class="buttons">
        <button class="btn btn-info save" onclick="Interface()">保存</button>
        <a id="get_vision_url" url="<?=Url::to(['test/index'])?>" class="btn btn-primary test">测试</a>
    </div>
</div>
<div class="jsontc ijscontc">
    <p>请输入json<span>X</span></p>
    <textarea id="importjson" class="jsoncont"></textarea>
    <a class="btn btn-info load" onclick="Importjson()">点击导入</a>
</div>

<!--接口添加end-->
<script type="text/javascript" src="res/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="res/js/bootstrap.min.js"></script>
<script type="text/javascript" src="res/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="res/js/jkmanage.js"></script>
<script type="text/javascript" src="res/js/apiajax.js"></script>
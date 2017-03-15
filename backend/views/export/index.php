<!DOCTYPE html>
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/2
 * Time: 15:36
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$getType = Yii::$app->request->get('type',1);
?>
<title>百利天下教育管理系统</title>
<link href="res/css/bootstrap.min.css" rel="stylesheet" />
<link href="res/css/bootstrapreset.css" rel="stylesheet" />
<link href="res/css/pxgridsicons.min.css" rel="stylesheet" />
<link href="res/css/style.css" rel="stylesheet" />
<link href="res/css/responsive.css" rel="stylesheet" media="screen"/>
<script  src="/res/js/jquery-2.0.3.min.js"></script>

<!--下拉框-->
<link rel="stylesheet" href="./res/css/chosen.css" />
<script src="/res/js/chosen.jquery.min.js"></script>

<!--时间插件-->
<script type="text/javascript" src="res/js/laydate.js"></script>


<style type="text/css">
    .table>tbody>tr>td{
        padding: 10px 13px;
    }
    .table>thead>tr>th {
        padding: 10px 10px;
    }
    .panel-heading .type-input {
        border: 1px solid #eaeaea;
        border-radius: 4px 0 0 4px;
        box-shadow: none;
        color: #797979;
        float: left;
        height: 35px;
        padding: 0 10px;
        transition: all 0.3s ease 0s;
        width: 80px;
        appearance:none;
        /*-moz-appearance:none;*/
        /*-webkit-appearance:none;*/
    }
    .panel-heading .sr-input {
        border-radius: 0;
    }
    .survey{
        padding: 3px;
        margin: 0 2px;
        border: 1px solid #a9a9a9;
    }

    .chosen-container, [class*="chosen-container"] {
        vertical-align: middle;
    }
    .chosen-container-multi .chosen-choices li.search-field input[type="text"] {
        height: 25px;
    }
    .chosen-container-multi .chosen-choices li.search-choice .search-choice-close::before {
        color: #888;
        content: "";
        display: inline-block;
        font-family: FontAwesome;
        font-size: 13px;
        position: absolute;
        right: 2px;
        top: -1px;
    }
    .chosen-container-single .chosen-search input[type="text"] {
        background:url() !important;
    }
    .operation span{cursor:pointer;}
    .score_list input{width:617px;}

</style>
<body>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <?= Html::a('<i class="icon-gears2 btn-icon"></i>新增方法记录', ['export/index','type' => 1], ['class' => $getType==1 ? 'btn btn-info' : 'btn btn-default']) ?>
                    <?= Html::a('<i class="icon-plus btn-icon"></i>维护方法记录', ['export/index','type'=>2], ['class' => $getType==2 ? 'btn btn-info' : 'btn btn-default']) ?>
                </header>
                <?php $form = ActiveForm::begin()?>
                <br />
                <div class="row">
                    <div class="col-md-3">
                        <select id="sq_1" class="form-control chosen-select" type="text" value="1"  name="info[title]" style="width:200px;">
                            <option value="1">选择用户</option>
                            <?php foreach($allUsers as $evUser):?>
                                <option value="<?=$evUser['userid'] ?>" <?php if($uid == $evUser['userid']):?> selected="selected"<?php endif;?>><?=$evUser['username'] ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <div class="demo1">
                            <input placeholder="请输入日期" style="height:34px;width:170px;" class="laydate-icon"
                                   onClick="laydate({istoday: true,istime: false, format: 'YYYY-MM-DD',choose:function (datas){
                                timeSt = datas;
                           }})">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="demo2">
                            <input placeholder="请输入日期" style="height:34px;width:170px;" class="laydate-icon"
                                   onClick="laydate({istoday: true,istime: false, format: 'YYYY-MM-DD',choose:function (datas){
                                    timeEnd = datas;
                           }})">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary" id="js_search">查询</button>
                        <button type="button" class="btn btn-primary" id="js_export">导出Excel</button>
                    </div>

                </div>
                <br />

                <div class="panel-body" id="panel-bodys">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th style="width: 50px;"></th>
                            <th>用户名</th>
                            <th>函数名称</th>
                            <th>类名称</th>
                            <th>项目别名</th>
                            <th>创建时间</th>
                            <th>统计时间</th>
                            <th>难度/应用</th>
                            <th>描述</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($userMethods)): ?>
                            <?php foreach ($userMethods as $evMethod):?>
                                <tr>
                                    <td><input type="checkbox" name="ids[]" value="<?=$evMethod['id']?>"></td>
                                    <td><?php echo isset($allUsers[$evMethod['uid']]['realname']) ? $allUsers[$evMethod['uid']]['realname'] : '已删除';?></td>
                                    <td><?=$evMethod['method_name']?></td>
                                    <td><?=$evMethod['class_name']?></td>
                                    <td><?= isset($evMethod['project_alias']) ? $evMethod['project_alias'] : '未命名'?></td>
                                    <td <?php if($evMethod['last_exec_time'] < $evMethod['mtime']):?> style="color:red;"<?php endif;?>>
                                        <?=date('Y-m-d H:i',$evMethod['mtime'])?>
                                    </td>
                                    <td><?=date('Y-m-d H:i',$evMethod['last_exec_time'])?></td>
                                    <td><?=$evMethod['coefficient']?></td>
                                    <td>
                                        <a class="btn btn-primary btn-xs description_view" data-des="<?= $evMethod['description'] ?>">查看详情</a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        <?php else:?>
                            <tr>
                                <td colspan="7">没有搜索结果</td>
                            </tr>
                        <?php endif;?>
                        </tbody>
                    </table>

                </div>
        </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pull-left" style="display:none;">
                                <?= Html::submitButton( '排序', ['class' => 'btn btn-info btn-sm','onclick'=>'javascript:this.form.action="'.Url::to([Yii::$app->controller->id.'/sort']).'";'])?>
                                <?= Html::submitButton( '批量删除', ['class' => 'btn btn-info btn-sm','onclick'=>'javascript:this.form.action="'.Url::to([Yii::$app->controller->id.'/remove']).'";'])?>
                            </div>
                            <div class="pull-right">
                                <?= LinkPager::widget(['pagination' => $pages]); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </section>
        </div>
    </div>
</section>

<script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    函数描述
                </h4>
            </div>
            <div class="modal-body">
                在这里添加一些文本
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>
    $('.description_view').click(function(){

        $('.modal-body').html($(this).attr('data-des'));
        $('#myModal').modal('show');

    });
</script>


</body>
<script>

    var timeSt = 0;
    var timeEnd = 0;
    var uid = <?=$filterItems['uid']?>;
    var isExport = 0;
    var type = <?= $getType?>;

    <?php if(isset($filterItems['stTime'])):?>
    timeSt = '<?=$filterItems['stTime'];?>';
    $('.demo1 input').eq(0).val(timeSt);
    <?php endif; ?>

    <?php if(isset($filterItems['endTime'])):?>
    timeEnd = '<?=$filterItems['endTime'];?>';
    $('.demo2 input').eq(0).val(timeEnd);
    <?php endif; ?>


    $(function (){
        var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'没有搜索到结果'},
            '.chosen-select-width'     : {width:"95%"},
            '.chosen-select-float'     : {float:"left"}
        };

        $('#sq_1').chosen(config);

        $("#sq_1").chosen().change(function(){
            uid = $(this).val();
        });

        // 为时间插件 绑定皮肤
        !function () {
            laydate.skin('yalan');
            laydate({elem: '.demo1'});
            laydate({elem: '.demo2'});
        }();

        // 搜索
        $('#js_search').click(function(){
            isExport = 0;
            jump();
        });

        // 导出 excel
        $('#js_export').click(function(){
            isExport = 1;
            jump();
        });

        var jump = function (){

            var param = {st:timeSt,end:timeEnd,isExport:isExport,uid:uid,type:type};
            var urlParam = urlEncode(param);
            var a = "<?php echo Url::to(['export/index'])?>"+urlParam;
            window.location.replace(a);
        };

        /**
         * param 将要转为URL参数字符串的对象
         * key URL参数字符串的前缀
         * encode true/false 是否进行URL编码,默认为true
         *
         * return URL参数字符串
         */
        var urlEncode = function (param, key, encode) {
            if(param==null) return '';
            var paramStr = '';
            var t = typeof (param);
            if (t == 'string' || t == 'number' || t == 'boolean') {
                paramStr += '&' + key + '=' + ((encode==null||encode) ? encodeURIComponent(param) : param);
            } else {
                for (var i in param) {
                    var k = key == null ? i : key + (param instanceof Array ? '[' + i + ']' : '.' + i);
                    paramStr += urlEncode(param[i], k, encode);
                }
            }
            return paramStr;
        };

    });


</script>
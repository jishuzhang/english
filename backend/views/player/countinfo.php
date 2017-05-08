<!DOCTYPE html>
<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use backend\models\Admin;

?>
<html lang="zh-cn" class="no-js sidebar-large">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>教育管理系统</title>
    <link href="res/css/bootstrap.min.css" rel="stylesheet" />
    <link href="res/css/bootstrapreset.css" rel="stylesheet" />
    <link href="res/css/pxgridsicons.min.css" rel="stylesheet" />
    <link href="res/css/style.css" rel="stylesheet" />
    <link href="res/css/responsive.css" rel="stylesheet" media="screen"/>
    <link href="res/css/animation.css" rel="stylesheet" />
    <script src="res/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="res/js/jquery.min.js"></script>
    <script src="res/js/common.js"></script>
    <script src="res/js/jquery-easing.js"></script>
    <script src="res/js/responsivenav.js"></script>
    <!--[if lt IE 9]>
    <script src="res/js/html5shiv.js"></script>
    <script src="res/js/respond.min.js"></script>
    <![endif]-->

    <!--下拉框-->
    <link rel="stylesheet" href="./res/css/chosen.css" />
    <script src="/res/js/chosen.jquery.min.js"></script>

    <!--时间插件-->
    <script type="text/javascript" src="res/js/laydate.js"></script>

</head>
<body class="body">
<style type="text/css">
    .table>tbody>tr>td, .table>thead>tr>th {
        padding: 10px 10px;
    }
    .table>thead>tr>th.tablehead {
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
        width: 60px;
        appearance:none;
    }
    .panel-heading .sr-input {
        border-radius: 0;
    }
</style>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <?= Html::a('<i class="icon-gears2 btn-icon"></i>函数总览', ['countinfo'], ['class' => 'btn btn-info']) ?>
                </header>

                <!--顶部时间搜索插件STAR-->
                <br />
                <div class="Plug">
                    <div class="col-md-3">
                        <select id="sq_1" class="form-control chosen-select" type="text" value="用户名"  name="info[title]" style="width:200px;">
                            <option value="0">选择用户</option>
                            <?php foreach($allUsers as $evUser):?>
                                <option value="<?=$evUser['userid'] ?>" <?php if($uid == $evUser['userid']):?> selected="selected"<?php endif;?>><?=$evUser['username'] ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <div class="demo1">
                            <input placeholder="请输入日期" style="height:34px;width:170px;" class="laydate-icon"
                                   onClick="laydate({istoday: false,istime: false, format: 'YYYY-MM-DD',choose:function (datas){
                                   timeSt = datas;

                           }})">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="demo2">
                            <input placeholder="请输入日期" style="height:34px;width:170px;" class="laydate-icon"
                                   onClick="laydate({istoday: false,istime: false, format: 'YYYY-MM-DD',choose:function (datas){
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
                <!--顶部时间搜索插件END-->

                <div class="panel-body" id="panel-bodys">

                    <table class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th class="tablehead">ID</th>
                            <th class="tablehead">用户</th>
                            <th class="tablehead">添加方法数</th>
                            <th class="tablehead">更新方法数</th>
                            <th class="tablehead">更新时间</th>
                            <span class="g-icon arrow-icon"></span>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if($Countinfo):
                            foreach ($Countinfo as $key => $val): ?>
                                <tr>
                                    <td><?= $val['id'] ?></td>
                                    <td><?= Admin::find()->where(['userid'=>$val['uid']])->one()->realname ?></td>
                                    <td><?= $val['day_add'] ?></td>
                                    <td><?= $val['day_modify'] ?></td>
                                    <td title="添加时间：<?= date('Y-m-d', $val['exec_time']) ?>"><?= date('Y-m-d', $val['exec_time']) ?></td>

                                </tr>
                                <?php
                            endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pull-right">
                                    <div class="pagination pull-left" style="margin-right: 10px; line-height: 30px;">共 <?= $counts ?> 条数据 / 共 <?= $all_pages ?> 页</div>
                                    <?= LinkPager::widget(['pagination' => $pagination]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<script src="res/js/bootstrap.min.js" type="text/javascript"></script>
<script src="res/js/hover-dropdown.js" type="text/javascript"></script>
<script src="res/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="res/js/pxgrids-scripts.js" type="text/javascript"></script>

<script type="text/javascript">

    var timeSt = 0;
    var timeEnd = 0;
    var isExport = 0;
    var uid = 0;


    <?php if(isset($stTime)):?>
    timeSt = '<?=$stTime;?>';
    $('.demo1 input').eq(0).val(timeSt);
    <?php endif; ?>

    <?php if(isset($endTime)):?>
    timeEnd = '<?=$endTime;?>';
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

        /*$("#sq_1").chosen().change(function(){
            uid = $(this).val();
        });*/

        // 为时间插件 绑定皮肤
        !function () {
            laydate.skin('yalan');
            laydate({elem: '.demo1'});
            laydate({elem: '.demo2'});
        }();

        // 搜索
        $('#js_search').click(function(){

            uid = $('#sq_1 option:selected').val();//选中的值
            isExport = 0;
            jump();
        });

        // 导出 excel
        $('#js_export').click(function(){
            uid = $('#sq_1 option:selected').val();//选中的值
            isExport = 1;
            jump();
        });

        var jump = function (){

            var param = {st:timeSt,end:timeEnd,isExport:isExport,uid:uid};
            var urlParam = urlEncode(param);
            var a = "<?php echo Url::to(['note/countinfo'])?>"+urlParam;
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
</body>
</html>
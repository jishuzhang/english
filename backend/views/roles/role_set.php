<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
?>
<!DOCTYPE html>
<html lang="zh-cn" class="no-js sidebar-large">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta title="viewport" content="width=device-width, initial-scale=1">
	<title>百利天下教育管理系统</title>
	<link href="res/css/bootstrap.min.css" rel="stylesheet" />
	<link href="res/css/bootstrapreset.css" rel="stylesheet" />
	<link href="res/css/pxgridsicons.min.css" rel="stylesheet" />
	<link href="res/css/style.css" rel="stylesheet" />
	<link href="res/css/responsive.css" rel="stylesheet" media="screen"/>
	<link href="res/css/animation.css" rel="stylesheet" />
</head>
<body>
<section class="wrapper">
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading">
    <div>
				
		<?= Html::a('<i class="icon-gears btn-icon"></i>权限管理', ['admin/index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="icon-gears btn-icon"></i>管理员添加', ['admin/add_admin'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="icon-gears btn-icon"></i>角色管理', ['roles/role_manage'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="icon-plus btn-icon"></i>角色添加', ['roles/role_add'], ['class' => 'btn btn-info']) ?>
</div>

    </header>
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead" colspan="2">设置权限：<?php echo $r_role['role_name'];?></th>
						<th class="tablehead" colspan="2" id="alert-warning"><span id="warning-tips"></span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
	function check_in($id,$ids,$returnstr = 'checked') {
		if(in_array($id,$ids)) return $returnstr;
	}
                    foreach($parent_top AS $r) {
                        echo '<tr>';
                        echo '<td><label><input type="checkbox"  value="'.$r['nodeid'].'" onclick="st(this);" '.check_in($r['nodeid'],$privates,'checked').'> '.$r['title'].'</label></td>
                            <td></td>
                        </tr>';
                        foreach($result as $rs) {
                            if($rs['pid']!=$r['nodeid']) continue;
                            echo '<tr>
                            <td style="padding-left: 50px;"><label><input type="checkbox" value="' . $rs['nodeid'] . '" onclick="st(this);" '.check_in($rs['nodeid'],$privates,'checked').'> ' . $rs['title'] . '</label></td>
                            <td>';
                            foreach($result as $r2) {
                                if($rs['nodeid'] == $r2['pid']) {
                                    echo '<label><input type="checkbox" value="' . $r2['nodeid'] . '" onclick="st(this);" '.check_in($r2['nodeid'],$privates,'checked').'> ' . $r2['title'] . '</label>';
                                }
                            }
                            echo '</td>
                            </tr>';
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        </section>
    </div>
</div>

<!-- page end-->
</section>
<script type="text/javascript" src="http://statics.bailitop.com/js/jquery-1.10.2.min.js"></script>
<script>
	function set_timer() {
       var t=setTimeout(function(){$('#alert-warning').addClass('hide');clearInterval(t);},3000);
    }	
	function st(obj) {
        if($(obj).is(':checked')) {
            var chk=1;
        } else {
            var chk=0;
        }
        $.get("index.php?r=roles/role_set",{nid:obj.value,chk:chk,role:<?php echo Yii::$app->request->get('id') ?>}, function(data){
            //alert("Data Loaded: " + data);
            $('#alert-warning').removeClass('alert-warning');
            $('#alert-warning').addClass('alert-success');
            $('#alert-warning').removeClass('hide');
            $('#warning-tips').html('<strong>更新成功</strong>');
            set_timer();
        });
    }
		 
</script>


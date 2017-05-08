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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>教育管理系统</title>
	<link href="res/css/bootstrap.min.css" rel="stylesheet" />
	<link href="res/css/bootstrapreset.css" rel="stylesheet" />
	<link href="res/css/pxgridsicons.min.css" rel="stylesheet" />
	<link href="res/css/style.css" rel="stylesheet" />
	<link href="res/css/responsive.css" rel="stylesheet" media="screen"/>
	<link href="res/css/animation.css" rel="stylesheet" />
    <script src="res/js/jquery.min.js"></script>
</head>
<body>
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
        /*   -moz-appearance:none;
           -webkit-appearance:none;*/
    }
    .panel-heading .sr-input {
        border-radius: 0;
    }
</style>
<section class="wrapper">
	<!-- page start-->
	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
							<header class="panel-heading">
    <div>
				
		<?= Html::a('<i class="icon-gears btn-icon"></i>权限管理', ['admin/index'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('<i class="icon-gears btn-icon"></i>管理员添加', ['admin/add_admin'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="icon-gears btn-icon"></i>角色管理', ['roles/role_manage'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<i class="icon-plus btn-icon"></i>角色添加', ['roles/role_add'], ['class' => 'btn btn-default']) ?>
                                <?php $form = ActiveForm::begin([
                                    'action' => ['admin/search'],
                                    'method'=>'post',
                                    'options' => ['class'=>'pull-right position'],
                                ]); ?>
                                <td>
                                    <div class="input-append dropdown">
                                        <select name="search[type]" class="type-input" style="width:100px" id="search_type">
                                            <option value="管理员名" <?php if(isset($type)&&$type=="管理员名"){echo 'selected';} ?>>管理员名</option>
                                            <option value="真实姓名" <?php if(isset($type)&&$type=="真实姓名"){echo 'selected';} ?>>真实姓名</option>
                                        </select>
                                        <input type="text" name="search[content]" placeholder="搜索标题" class="sr-input" value="<?php if(isset($content)){echo $content;} ?>" id="search_content">
                                        <button type="submit" class="btn adsr-btn searchbtn"><i class="icon-search"></i></button>
                                    </div>
                                </td>
                                <?php ActiveForm::end(); ?>
							</header>

							<table class="table table-striped table-advance table-hover">

								<thead>
									<tr>
									    <th>id</th>
										<th>管理员名</th>
										<th>真实姓名</th>
										<th>所属角色</th>
										<th  class="text-center">操作</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($datas as $data):?>
									<tr>
									    <td><?=Html::encode("{$data['userid']}")?></td>
										<td><?=Html::encode("{$data['username']}")?></td>
										<td><?=Html::encode("{$data['realname']}")?></td>
										<td><?=Html::encode("{$data['roles'][0]['role_name']}")?></td>
										<td class="text-center">
										<?php if($now_role_name == 'admin' && $data['username'] == $now_role_name ){?>
										<a href="index.php?r=admin/admin_edit&roleid=<?=Html::encode("{$data['roles'][0]['id']}")?>&id=<?=Html::encode("{$data['userid']}")?>" class="btn-small btn-primary  btn-xs">编辑</a>
										<?php }else if($now_role_name != 'admin' && $data['username'] == 'admin'){?>
										<a href="#" class="btn-small btn-default btn-xs">编辑</a>
										<?php }else{?>
										<a href="index.php?r=admin/admin_edit&roleid=<?=Html::encode("{$data['roles'][0]['id']}")?>&id=<?=Html::encode("{$data['userid']}")?>" class="btn-small btn-primary  btn-xs">编辑</a>
										<?php }?>
										<?php if($now_role_name == 'admin' && $data['username'] == $now_role_name ){?>
										<a href="index.php?r=admin/admin_delete&roleid=<?=Html::encode("{$data['roles'][0]['id']}")?>&id=<?=Html::encode("{$data['userid']}")?>" class="btn-small btn-danger btn-xs" data-confirm="确认要删除吗？">删除</a>
										<?php }else if($now_role_name != 'admin' && $data['username'] == 'admin'){?>
										<a href="#" class="btn-small btn-default btn-xs">删除</a>
										<?php }else{?>
										<a href="index.php?r=admin/admin_delete&roleid=<?=Html::encode("{$data['roles'][0]['id']}")?>&id=<?=Html::encode("{$data['userid']}")?>" class="btn-small btn-danger btn-xs" data-confirm="确认要删除吗？">删除</a>
										<?php }?>
										</td>
									</tr>
								<?php endforeach;?>
								</tbody>
							</table>
							<div class='panel-body'>
								<?= LinkPager::widget(['pagination' => $pagination]) ?>
							</div>
				</section>
			</div>
		</div>
	</section>
<script type="text/javascript">
    $(".pagination a").click(function(){
        var search_content = $("#search_content").val();
        if(search_content){
            var search_type = $("#search_type").val();
            var search_href = $(this).attr("href")+'&type='+search_type+'&content='+search_content;
            $(this).attr("href",search_href);
        }
    });
$(".searchbtn").click(function(){
var search_content = $("#search_content").val();
if(!search_content){
alert('请输入需要查询的内容');
return false;
}
})
</script>
</body>
</html>
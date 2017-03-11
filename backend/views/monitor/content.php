<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<link href="/res/css/chosen.css" rel="stylesheet">
<style>
	.chosen-container-single .chosen-search input[type="text"] {
		background:url() !important;
	}
</style>
<div class="wrapper">
	<div class="mcontent">
		<div class="content_t">
			<h4>监控内容</h4>
		</div>
		<div class="content_c">
			<ul>
				<li><div class="btn btn-info mysubmit col_bao_01 time_limit"  data-code="year"  >年</div></li>
				<li><div class="btn btn-info mysubmit col_bao_01 time_limit"  data-code="quarter" >季度</div></li>
				<li><div class="btn btn-info mysubmit col_bao_01 time_limit"  data-code="month"   >月</div></li>
				<li><div class="btn btn-info mysubmit col_bao_01 time_limit"  data-code="day"   >日</div></li>
			</ul>
		</div>


		<div class="content_x">
			<ul>
				<li>
					<select id="php_app" class="form-control chosen-select" type="text" value="所属应用"  name="info[title]">
						<option value="0">应用</option>
						<?php if(isset($appInfoSet) && !empty($appInfoSet)): ?>
							<?php foreach($appInfoSet as $appFilterId => $appFilterTitle): ?>
								<option value="<?=$appFilterId; ?>"  <?php if(isset($filterItems['appId']) && $filterItems['appId'] == $appFilterId):?> selected="selected"  <?php endif; ?>  ><?=$appFilterTitle;?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</li>
				<li>
					<select id="php_version" class="form-control chosen-select" type="text" value="所属版本" name="info[title]">
						<option value="0">版本</option>
						<?php if(isset($interfaceVersionInfoSet) && !empty($interfaceVersionInfoSet)): ?>
							<?php foreach($interfaceVersionInfoSet as $interfaceVersionId => $interfaceVersionName): ?>
								<option value="<?=$interfaceVersionId; ?>"   <?php if(isset($filterItems['interfaceVersion']) && $filterItems['interfaceVersion'] == $interfaceVersionId):?> selected="selected"  <?php endif; ?> ><?=$interfaceVersionName;?></option>
							<?php endforeach; ?>
						<?php endif; ?>


					</select>
				</li>
				<li>
					<select id="php_interface" class="form-control chosen-select" type="text" value="接口"  name="info[title]">
						<option value="0">接口</option>
						<?php if(isset($interfaceInfoSet) && !empty($interfaceInfoSet)): ?>
							<?php foreach($interfaceInfoSet as $interfaceFilterId => $interfaceFilterTitle): ?>
								<option value="<?=$interfaceFilterId; ?>"   <?php if(isset($filterItems['interfaceId']) && $filterItems['interfaceId'] == $interfaceFilterId):?> selected="selected"  <?php endif; ?> ><?=$interfaceFilterTitle;?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</li>
				<li>
					<select id="php_monitor" class="form-control chosen-select" type="text" value="监控结果"  name="info[title]">
						<option value="0">监控结果</option>
						<?php if(isset($monitorStatusList) && !empty($monitorStatusList)): ?>
							<?php foreach($monitorStatusList as $monitorStatusId): ?>
								<option value="<?=$monitorStatusId; ?>" <?php if(isset($filterItems['monitorStatus']) && $filterItems['monitorStatus'] == $monitorStatusId):?> selected="selected"  <?php endif; ?>><?=$monitorStatusId;?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</li>

				<!--test-->
<!--				<li>-->
<!--					<select name="dept" style="width:100px;" id="dept" class="dept_select chosen-select">-->
<!--						<option value="部门1">苏建辉</option>-->
<!--						<option value="部门2">张盼龙</option>-->
<!--						<option value="部门3">网路文</option>-->
<!--						<option value="部门4">白玉</option>-->
<!--						<option value="部门5">徐金发</option>-->
<!--					</select>-->
<!--				</li>-->


				<li style="width:170px;">
					<div class="box">
						<div class="demo2">
							<input placeholder="请输入日期" style="height:34px;width:170px;" class="laydate-icon"
								   onClick="laydate({istoday: false,istime: false, format: 'YYYY-MM-DD',choose:function (datas){
								   		enterTimeFilter(1,datas);
								   }})">
						</div>
					</div>
				</li>
				<li style="width:170px;">
					<div class="box">
						<div class="demo2">
							<input placeholder="请输入日期" style="height:34px;width:170px;" class="laydate-icon"
								   onClick="laydate({istoday: false,istime: false, format: 'YYYY-MM-DD',choose:function (datas){
								   		enterTimeFilter(2,datas);
								   }})">
						</div>
					</div>
				</li>

				<li><input class="btn btn-info php_submit_search" type="submit" value="搜索" name="submit"></li>

				<li>
					<input class="btn btn-danger mysubmit col_bao_01" type="button" value="监控" onclick="processerbar(3000)">
				</li>

			</ul>
		</div>

		<!--搜索条件-->
		<?php $form = ActiveForm::begin(['action' => ['monitor/content'],'method'=>'get','id'=>'php_search']); ?>
			<input type="hidden" value="9999" class="" name="timeSt">
			<input type="hidden" value="2" class="" name="timeEnd">
			<input type="hidden" value="3" class="" name="appId">
			<input type="hidden" value="4" class="" name="interfaceId">
			<input type="hidden" value="4" class="" name="monitorStatus">
			<input type="hidden" value="4" class="" name="interfaceVersion">
		<?php ActiveForm::end(); ?>

		<div class="content_z">
			<table class="table table-striped table-advance table-hover">
				<thead>
				<tr>
					<th class="tablehead">应用</th>
					<th class="tablehead">版本</th>
					<th class="tablehead">类别</th>
					<th class="tablehead">接口</th>
					<th class="tablehead">监控时间</th>
					<th class="tablehead">监控结果</th>
					<th class="tablehead">邮件</th>
					<th class="tablehead">短信</th>
					<th class="tablehead">访问ip</th>
					<th class="tablehead" style="width:15%;">url</th>
					<th class="tablehead" style="width:15%;">报错信息</th>
					<th class="tablehead"></th>
				</tr>
				</thead>
				<tbody>
				<?php if(isset($interfaceList) && !empty($interfaceList)):?>
					<?php $message='';foreach ($interfaceList as $evInter): ?>
					<tr>
						<td><?php echo isset($appInfoSet[$evInter['app_id']]) ? $appInfoSet[$evInter['app_id']] : '<span style="color:red;">数据丢失</span>'; ?></td>
						<td><?php echo isset($interfaceVersionInfoSet[$evInter['interface_vision_id']]) ? $interfaceVersionInfoSet[$evInter['interface_vision_id']] : '<span style="color:red;">数据丢失</span>';  ?></td>
						<td><?php echo isset($interfaceTypeInfoSet[$evInter['interface_type_id']]) ? $interfaceTypeInfoSet[$evInter['interface_type_id']] : '<span style="color:red;">数据丢失</span>';  ?></td>
						<td><?php echo isset($interfaceInfoSet[$evInter['interface_id']]) ? $interfaceInfoSet[$evInter['interface_id']] : '<span style="color:red;">数据丢失</span>'; ?></td>
						<td><?php echo date('Y-m-d H:i',$evInter['monitor_time']); ?></td>
						<td><?php echo $evInter['result'] ?></td>
						<td style="color:red;font-weight: bold;font-size:18px;">
							<?php if($evInter['email'] == 1): ?>
								√
							<?php else: ?>
								×
							<?php endif; ?>
						</td>
						<td style="color:red;font-weight: bold;font-size:18px;">
							<?php if($evInter['message'] == 1): ?>
								√
							<?php else: ?>
								×
							<?php endif; ?>
						</td>
						<td><?= $evInter['ip'] ?></td>
						<td>
							<span onclick="alert('<?= $evInter['url'] ?>');" style="cursor:pointer;" title="<?= $evInter['url'] ?>">预览</span>
						</td>
						<td>
							<span class="show_Modal" data-toggle="modal" data-target="#myModal">预览<span class="hide ceshi"><?=$evInter['data']?></span></span>
						</td>
						<td>
							<?php if(isset($ipInfoSet) && !in_array($evInter['ip'],$ipInfoSet)): ?>
								<input class="tanhei btn btn-danger btn-xs" type="submit" value="加入黑名单" name="submit" ip_data="<?=$evInter['ip'];?>">
							<?php else: ?>
								<input class="btn btn-danger btn-xs"  type="submit" value="黑名单" name="submit" ip_data="<?=$evInter['ip'];?>">
							<?php endif;?>
						</td>
					</tr>
				<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>
				<?php if(empty($interfaceList)): ?>
					<div style="color:red;font-size:13px;">未查询到相关数据,请重新选择筛选条件</div>
				<?php endif; ?>

		</div>

		<?= linkPager::widget(['pagination'=>$pagination]) ?>

		<div class="tanheic">
			<h4>已成功加入黑名单</h4>
			<ul>
				<li>
					<input class="php_redirect_view btn btn-info mysubmit col_bao_01 " type="submit" value="跳转查看" name="submit">
				</li>

				<li>
					<input class="tanheil btn btn-info mysubmit col_bao_01 " type="submit" value="留在此页" name="submit">
				</li>
			</ul>

			<?php $form = ActiveForm::begin(['action' => ['blacklist/create'],'method'=>'post','id'=>'php_blacklist']); ?>
			<input type="hidden" value="" name="blackIp">
			<input type="hidden" value="6" name="timeLineCode">
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>

<!--监控-->
<div class="jiankong">
	<span class="guanbi">X</span>
	<!-- 进度条 -->
	<div id="probar" class="barline">
		<div id="percent"></div>
		<div id="line" w="100" style="width:0px;"></div>
		<div style="" id="msg"></div>
	</div>
</div>

<!-- 按钮触发模态框 -->

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow-y:inherit;">
	<div class="modal-dialog" style="width: 800px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">报错信息详情</h4>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>

<script type="text/javascript" src="res/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="res/js/laydate.js"></script>
<script>

	$(".show_Modal").click(function(){
		$(this).each(function(){
			var con=$(this).find(">.ceshi").html();
			$("#myModal .modal-body").text(con);
		})

	})



	// 筛选条件初始化
	var timeSt = 0;
	var timeEnd = 0;  // 截止时间
	var appId = 0;   // 应用 id
	var interfaceVersion = 0; // 接口版本 id
	var interfaceId = 0; // 接口 id
	var monitorStatus = 0; // 监控结果

	<?php if(isset($filterItems['timeSt'])):?>
		timeSt = '<?=$filterItems['timeSt'];?>';
		$('.demo2 input').eq(0).val(timeSt);
	<?php endif; ?>

	<?php if(isset($filterItems['timeEnd'])):?>
		timeEnd = '<?=$filterItems['timeEnd'];?>';
		$('.demo2 input').eq(1).val(timeEnd);
	<?php endif; ?>

	<?php if(isset($filterItems['appId'])):?>
		appId = '<?=$filterItems['appId'];?>';
	<?php endif; ?>

	<?php if(isset($filterItems['interfaceVersion'])):?>
		interfaceVersion = '<?=$filterItems['interfaceVersion'];?>';
	<?php endif; ?>

	<?php if(isset($filterItems['interfaceId'])):?>
		interfaceId = '<?=$filterItems['interfaceId'];?>';
	<?php endif; ?>

	<?php if(isset($filterItems['monitorStatus'])):?>
		monitorStatus = '<?=$filterItems['monitorStatus'];?>';
	<?php endif; ?>


	$('#php_monitor').change(function(){
		monitorStatus = $(this).val();
	});

	$('#php_interface').change(function(){
		interfaceId = $(this).val();
	});

	$('#php_app').change(function(){
		appId = $(this).val();
	});

	$('#php_version').change(function(){
		interfaceVersion = $(this).val();
	});

	// 点击 年 季度 月 日 快捷选项卡筛选
	$('.time_limit').click(function(){

		var timeType = $(this).attr('data-code');
		var myDate = new Date();
		var quarterObj = [1,1,1,2,2,2,3,3,3,4,4,4];  // 定义季度集合

		if(timeType.indexOf('year') >= 0){
			timeSt = myDate.getFullYear()+ '-01-01';
			timeEnd = (myDate.getFullYear() + 1) + '-01-01';

		} else if(timeType.indexOf('quarter') >= 0) {
			var quarterIndex = 7;
//					var quarterIndex = myDate.getMonth();

			if(quarterObj[quarterIndex] == 1){

				timeSt = myDate.getFullYear() + '-01-01';
				timeEnd = myDate.getFullYear() + '-04-01';

			} else if(quarterObj[quarterIndex] == 2){

				timeSt = myDate.getFullYear() + '-04-01';
				timeEnd = myDate.getFullYear() + '-07-01';

			} else if(quarterObj[quarterIndex] == 3){

				timeSt = myDate.getFullYear() + '-07-01';
				timeEnd = myDate.getFullYear() + '-10-01';

			} else if(quarterObj[quarterIndex] == 4){

				timeSt = myDate.getFullYear() + '-10-01';
				timeEnd = parseInt(timeSt) + 1 + '-01-01';

			}

		} else if(timeType.indexOf('month') >= 0) {

			// js  0 - 11  表示 12 个月
			timeSt = myDate.getFullYear() + '-'+ (myDate.getMonth() + 1) +'-01';
			timeEnd = myDate.getFullYear() + '-'+ (myDate.getMonth() + 2) +'-01';

		} else if(timeType.indexOf('day') >= 0) {

			timeSt = myDate.getFullYear() + '-'+ (myDate.getMonth() + 1) +'-'+myDate.getDate();
			timeEnd = myDate.getFullYear() + '-'+ (myDate.getMonth() + 1) +'-'+(myDate.getDate()+1);

		} else {
			timeSt = timeEnd = '';
		}

		submitFilter();

	});

	$('.php_submit_search').click(function(){
		submitFilter();
	});

	// 重新生成 form 表单筛选条件 并提交
	function submitFilter(){

		$('input[name="timeSt"]').val(timeSt);
		$('input[name="timeEnd"]').val(timeEnd);
		$('input[name="appId"]').val(appId);
		$('input[name="interfaceId"]').val(interfaceId);
		$('input[name="monitorStatus"]').val(monitorStatus);
		$('input[name="interfaceVersion"]').val(interfaceVersion);
		$("#php_search").submit();

	}





	//---------------------------------时间插件----------------------------
	!function () {
		laydate.skin('yalan');//切换皮肤，请查看skins下面皮肤库
		laydate({elem: '.demo2'});//绑定元素
	}();

	function enterTimeFilter(timeType,currentTime){
		if(timeType === 1){
			timeSt = currentTime;
		}

		if(timeType === 2){
			timeEnd = currentTime;
		}
	}


	$(function () {
		$('.tanhei').click(function () {

			var blackForm = $('#php_blacklist');
			var blackIp = $(this).attr('ip_data');
			var ipRegExp = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;

			// 判断是否为格式正确的IP地址
			if(ipRegExp.test(blackIp)){
				$('input[name="blackIp"]').val(blackIp);
				$.ajax({
					type:blackForm.attr('method'),
					url:blackForm.attr('action'),
					data:blackForm.serialize(),
					dataType:'html',
					async:false,
					success:function(d){
						if(parseInt(d) == 1){
							$(".tanheic").show();
						} else if(parseInt(d) == 2){
							// 数据库错误
						} else if(parseInt(d) == 3){
							// 参数传递错误
						}


					},
					error:function (e){
						alert(e);
					}

				});
			}

		});

		// 留在此页
		$('.tanheil').click(function () {
			$(".tanheic").hide();
		});

		// 跳转查看
		$('.php_redirect_view').click(function(){
			window.location.href = '<?php echo Url::to(['blacklist/index']).'&blackIp=';?>'+$('input[name="blackIp"]').val();
		});
	});


	// 监控弹出窗
	function processerbar(time){
		if(confirm("此举动比较耗费服务器资源,请在访问量较少时刻执行此操作,继续执行点击确定,否则点击取消")){

			$.get('<?php echo Url::to(['monitor/simulation']);?>',function(e){
			});

			$(".jiankong").show();
			$("#probar").show();
			$("#line").each(function(i,item){
				var a=parseInt($(item).attr("w"));
				$(item).animate({
					width: a+"%"
				},time);
			});
			var si = window.setInterval(
				function(){
					a=$("#line").width();
					b=(a/200*100).toFixed(0);
					document.getElementById('percent').innerHTML=b+"%";
					document.getElementById('percent').style.left=a-12+"px";
					document.getElementById('msg').innerHTML="监控中";
					if(document.getElementById('percent').innerHTML=="100%") {
						clearInterval(si);
						document.getElementById('msg').innerHTML="成功";
					}
				},70)
		}

	}

	$(".guanbi").click(function(){
		$(".jiankong").hide();
		history.go(0);
	})

</script>

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
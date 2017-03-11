<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

?>

<div class="wrapper">

    <div class="heitou">
        <h4>黑名单设置</h4>
    </div>
    <div>
        <?php $form = ActiveForm::begin(['action' => ['blacklist/index'],'method'=>'get','id'=>'php_search_ip']); ?>
            <input type="text" name="blackIp" placeholder="请输入查询IP地址" value="<?php echo isset($_GET['blackIp']) && !empty($_GET['blackIp']) ? $_GET['blackIp'] : '';?>">
        <?php ActiveForm::end(); ?>

        <script>
          $('#php_search_ip input[name="blackIp"]').blur(function (){
              if($(this).val() != ''){
                  window.location.href = '<?=Url::to(['blacklist/index'])?>&blackIp='+$(this).val();
              }else{
                  window.location.href = '<?=Url::to(['blacklist/index'])?>';
              }
          });
        </script>

    </div>
    <div class="heinei">
        <table class="table table-striped table-advance table-hover">
            <thead>
            <tr>
                <th class="tablehead">Id</th>
                <th class="tablehead">IP</th>
                <th class="tablehead">添加时间</th>
                <th class="tablehead">限制访问</th>
                <th class="tablehead">操作</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($info_black as $key => $val):?>
            <tr>
                <td><?= $val['black_id'] ?></td>
                <td><?= $val['black_ip'] ?></td>
                <td><?= date('Y-m-d H:i',$val['add_time']); ?></td>
                <td>
                    <select name="form[template]" class="form-control php_duration" ip_data="<?= $val['black_ip'] ?>">
                        <option value="1" <?php if($val['duration'] == 1):?> selected="selected" <?php endif;?> >1小时</option>
                        <option value="2" <?php if($val['duration'] == 2):?> selected="selected" <?php endif;?> >24小时</option>
                        <option value="3" <?php if($val['duration'] == 3):?> selected="selected" <?php endif;?> >7 * 24 小时</option>
                        <option value="4" <?php if($val['duration'] == 4):?> selected="selected" <?php endif;?> >30 * 24 小时</option>
                        <option value="5" <?php if($val['duration'] == 5):?> selected="selected" <?php endif;?> >356 * 24 小时</option>
                        <option value="6" <?php if($val['duration'] == 6):?> selected="selected" <?php endif;?> >永久禁止</option>
                    </select>
                </td>

                <td>
                    <a href="javascript:void(0);" class="php_delete_ip btn btn-info btn-xs mysubmit col_bao_01 " ip_data="<?=$val['black_ip'] ?>">移除</a>
                </td>

            </tr>
            <?php endforeach; ?>

            </tbody>

        </table>
        <?php if(empty($info_black)): ?>
            <div style="color:red;font-size:13px;">未查询到相关数据</div>
        <?php endif; ?>
        <?= linkPager::widget(['pagination'=>$pagination]) ?>

        <?php $form = ActiveForm::begin(['action' => ['blacklist/delete'],'method'=>'post','id'=>'php_change_duration']); ?>
        <input type="hidden" value="" name="blackIp">
        <input type="hidden" value="6" name="timeLineCode">
        <input type="hidden" value="1" name="delete">

        <?php ActiveForm::end(); ?>
    </div>
</div>
<script type="text/javascript">

    $(function(){
        var blackForm = $('#php_change_duration');
        // 更新
        $('.php_duration').change(function (){
            $('input[name="timeLineCode"]').val($(this).val());
            $('input[name="blackIp"]').val($(this).attr('ip_data'));
            $('input[name="delete"]').val(0);
            submitDelete();
        });

        // 删除
        $('.php_delete_ip').click(function(){
            $('input[name="blackIp"]').val($(this).attr('ip_data'));
            $('input[name="delete"]').val(1);
            submitDelete();
        });

        function submitDelete() {
            debugger;
            var _csrf = $('input[name="_csrf"]').val();
            var timeLineCode = $('input[name="timeLineCode"]').val();
            var blackIp = $('input[name="blackIp"]').val();
            var deleteStatus = $('input[name="delete"]').val();
            var data = {_csrf:_csrf,timeLineCode:timeLineCode,blackIp:blackIp,delete:deleteStatus};

            $.ajax({
                type:blackForm.attr('method'),
                url:blackForm.attr('action'),
                data:data,
                dataType:'html',
                async:false,
                success:function(d){
                    if(parseInt(d) == 1){
                        // do nothing
                    } else if(parseInt(d) == 2){
                        location.replace(location);
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


</script>
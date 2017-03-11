<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<div class="wrapper">
    <div class="member_add_btn">
        <div class="current"><a href="index.php?r=member/index">成员设置</a></div>
        <div ><a href="javascript:;">成员添加</a></div>
    </div>
    <div class="member_add_table">
        <table class="table table-striped table-advance table-hover">
            <thead>
            <tr>
                <th class="tablehead">选择</th>
                <th class="tablehead">id</th>
                <th class="tablehead">登录名</th>
                <th class="tablehead">用户名</th>
                <th class="tablehead">所属角色</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($users as $val){
               ?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?php echo $val['users_id']?>"/></td>
                <td><?php echo $val['users_id']?></td>
                <td><?php echo $val['username']?></td>
                <td><?php echo $val['realname']?></td>
                <td><?php echo $val['role']?></td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>

        <div class="panel-body">
            <?= linkPager::widget(['pagination'=>$pagination]) ?>
        </div>
    </div>
    <div class="member_add" id="getValue" >添加</div>
    <script>
        $('#getValue').on('click', function() {
            var valArr = new Array;
            $('input:checkbox[name="ids[]"]:checked').each(function(i){
                valArr[i] = $(this).val();
            });
            var vals = valArr.join(',');//转换为逗号隔开的字符串
            if(!vals){
                alert("没有成员要添加!~");
            }else{
                $.ajax({
                    type:'GET',
                    url:'index.php?r=member/create',
                    data: {vals:vals},
                    dataType:'text',
                    success:function(mes){
                        if(mes == 1){
                            alert("添加成功！");
                             window.location.href='index.php?r=member/index';
                        }else if(mes == 2 ){
                            alert("应用ID为空！");
                        }else{
                            alert(mes+" 有重复应用，请重新添加！");
                        }
                    },
                    error:function(){
                          alert('数据有误请重试！');
                    }
                });
            }
        });
    </script>
</div>
<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<div class="wrapper">
    <div class="log">
        <div class="logtou">
            <h4>接口访问日志</h4>
        </div>
        <div class="logcon">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th class="tablehead">id</th>
                    <th class="tablehead">应用名称</th>
                    <th class="tablehead">应用版本</th>
                    <th class="tablehead">类别</th>
                    <th class="tablehead">接口名称</th>
                    <th class="tablehead">访问者ip</th>
                    <th class="tablehead">访问时间</th>
                    <th class="tablehead" style="width:30%;">url</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($list as $v){?>
                    <tr>
                        <td><?php echo $v['visit_log_id']?></td>
                        <td><?php echo $v['app_title']?></td>
                        <td><?php echo $v['interface_vision_title']?></td>
                        <td><?php echo $v['interface_type']?></td>
                        <td><?php echo $v['interface_title']?></td>
                        <td><?php echo $v['visit_ip']?></td>
                        <td><?php echo date("Y-m-d h:i:s",$v['visit_time']);?></td>
                        <td style="word-break: break-all; word-wrap:break-word;" ><?php echo $v['visit_url']?></td>

                    </tr>
                    <?php
                }?>
                </tbody>
            </table>
        </div>
        <div class="panel-body">
            <?= linkPager::widget(['pagination'=>$pagination]) ?>
        </div>
    </div>
</div>
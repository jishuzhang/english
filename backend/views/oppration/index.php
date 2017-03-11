<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<div class="wrapper">
    <div class="log">
        <div class="logtou">
            <h4>操作日志</h4>
        </div>
        <div class="logcon">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th class="tablehead">id</th>
                    <th class="tablehead">用户名</th>
                    <th class="tablehead">控制器</th>
                    <th class="tablehead">操作内容</th>
                    <th class="tablehead">动作</th>
                    <th class="tablehead">操作时间</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($list as $q){
                    ?>
                    <tr>
                        <td><?php echo $q['oppration_log_id']?></td>
                        <td><?php echo $q['realname']?></td>
                        <td><?php echo $q['m']?></td>
                        <td><?php
                            $oppinfo = yii::$app->db->createCommand("select title from {{%nodes}} where controller=:controller and action=:action", ['controller'=>$q['m'],'action'=>$q['c']])->queryOne();
                            echo $oppinfo['title'];
                            ?>
                        </td>
                        <!--<td>--><?php //echo $q['content']?><!--</td>-->
                        <td><?php if($q['c'] == 'create'){
                                echo "添加";

                            }else if($q['c'] == 'update'){
                                echo "编辑";

                            }else if($q['c'] == 'delete'){
                                echo "删除";

                            }else if($q['c'] == 'index'){
                                echo "查看";
                            }else echo $q['c'];
                            ?></td>
                        <td><?php echo date('Y-m-d h:i:s',$q['oppration_time'])?></td>

                    </tr>

                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="panel-body">
            <?= linkPager::widget(['pagination'=>$pagination]) ?>
        </div>
    </div>
</div>
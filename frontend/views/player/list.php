<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-3-15
 * Time: 9:49
 */
use frontend\assets\AppAsset;

$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;

AppAsset::addCss($this,'/css/video.css');
?>
<h2>视频列表</h2>
<div class="row">
    <?php foreach($model as $evModel):?>
        <div class="col-lg-3 video_item" style="">
            <img src="/res/images/p.png" alt="">
            <section class="video_info">
                <?=$evModel->title;?>
            </section>
        </div>
    <?php endforeach;?>
</div>


</div>



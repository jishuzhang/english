<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-3-15
 * Time: 9:49
 */
use frontend\assets\AppAsset;
use yii\web\View;
use yii\widgets\LinkPager;

$this->title = '视频列表';
$this->params['breadcrumbs'][] = $this->title;

AppAsset::addCss($this,'/css/video.css');
AppAsset::addScript($this,'/js/video.js',View::POS_END);
//页面缓存  http://www.yiifans.com/yii2/guide/caching-page.html
?>
<h2>视频列表</h2>
<div class="row">
    <?php if(!empty($model)):?>
        <?php foreach($model as $evModel):?>
            <div class="col-lg-3">
                <div class="video_item" link="<?php $evModel->poster?>">
                    <img src="<?=$evModel->poster;?>" alt="">
                    <section class="video_info">
                        <a class="video_link" href="<?php $evModel->poster?>"><?=mb_substr($evModel->title,0,10).'...';?></a>
                        <span class="pull-right"><?=date('Y/m/d');?></span>
                    </section>
                </div>
            </div>
        <?php endforeach;?>
    <?php endif;?>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="pull-right">
            <?= LinkPager::widget(['pagination' => $pages]); ?>
        </div>
    </div>
</div>






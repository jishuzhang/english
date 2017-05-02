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
use yii\helpers\Url;

$this->title = '试卷列表';
$this->params['breadcrumbs'][] = $this->title;

AppAsset::addCss($this,'/css/video.css');
AppAsset::addScript($this,'/js/video.js',View::POS_END);
//页面缓存  http://www.yiifans.com/yii2/guide/caching-page.html
?>
<style>
    .wrap > .container{padding:0px;}
    .php-filter .col-md-1{
        height:40px;
        line-height:40px;
        text-align:center;
        font-size:15px;
        margin:15px;
        cursor:pointer;
    }
    .php-filter .col-md-2{
        height:40px;
        line-height:40px;
        text-align:center;
    }
    .active{
        background-color: #D9EDF7;
        color:#fff !important;
        border-radius: 5px;
    }
    .php-time-tag{
        position:absolute;
        right:24px;
        top:9px;
        color:#Fff;
        background:#FBBC05;
        padding:3px;
    }
</style>
<div class="container">

    <div class="row php-filter">
        <div class="col-md-2"><h3>全部攻略</h3></div>

    </div>

    <div class="row" style="margin-top:30px;font-size:15px;">
        <?php if(!empty($model)):?>
            <?php foreach($model as $n => $evModel):?>
                <div class="col-lg-10 col-lg-offset-1" style="margin-top:10px;">
                    <div class="row">
                        <div class="col-md-1">
                            <?php echo $n+1;?>
                        </div>
                        <div class="col-md-9">
                            <a href="<?=Url::to(['strategy/view','id'=> $evModel['id']])?>"><?=$evModel['name']?></a>
                        </div>
                        <div class="col-md-2">
                            作者: admin
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        <?php endif;?>
    </div>

    <?php if(!empty($model)):?>
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-right">
                <?= LinkPager::widget(['pagination' => $pages]); ?>
            </div>
        </div>
    </div>
    <?php endif;?>
</div>







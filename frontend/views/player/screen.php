<?php
/**
 * Created by PhpStorm.
 * User: 1051035513@qq.com
 * Date: 2017-3-13
 * Time: 20:23
 */
use frontend\assets\AppAsset;
use yii\web\View;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '视频学习';
$this->params['breadcrumbs'][] = $this->title;

$viewJs =<<<JS

    $('.video_language strong').mousemove(function(event){

        // 阻止事件冒泡
        window.event.cancelBubble = true;
        $.ajax({
            url:'index.php?r=player/search',
            method:'get',
            data:{str:$(this).text(),tid:tid},
            success:function(e){
                console.info(e);
            },
            error:function(e){
                console.error(e);
            },
            dateType:'json',
        })

    });
JS;

$this->registerJs($viewJs,View::POS_END);
?>

<style>
    .video_language{
        display: block;
        padding: 9.5px;
        margin: 0 0 10px;
        font-size: 15px;
        line-height: 1.42857143;
        color: #333;
        word-break: break-all;
        word-wrap: break-word;
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
    }
    .video_description{
        margin-top:20px;
    }
    .video_language strong{
        cursor:pointer;
    }

    nav{display:none;}
    h3{display:none;}
    .breadcrumb{
        display:none;
    }
</style>
<div class="row" style="display:none">

    <div class="col-lg-9"  style="height:500px;padding:0px;">
        <embed
            src="<?php echo $model['src'];?>"
            type="application/x-shockwave-flash"
            allowscriptaccess="always"
            allowfullscreen="true"
            loop = '1'
            autostart='false'
            wmode="opaque"
            width="100%"
            height="100%">

    </div>

    <div class="col-lg-3" style="background:#252525;height:500px;color:#ACACAC;">
        <section class="video_description">
            <h4 style="margin-top:5px;"><?php echo $model['title'];?></h4>
            <section style="text-indent: 2em;">
                <?php echo $model['description'];?>
            </section>

        </section>
    </div>
</div>
<div class="row">
    <h3>电影台词</h3>

    <div class="col-lg-12 video_language">
        <?php if(isset($translate['en_content']) && !empty($translate['en_content'])):?>
            <?=$translate['en_content']?>
        <?php else:?>
            未搜索到台词
        <?php endif;?>
    </div>

</div>

<div class="row" style="display:none">
    <h3>电影台词翻译</h3>

    <div class="col-lg-12 video_language">
        <?php if(isset($translate['zn_content']) && !empty($translate['zn_content'])):?>
            <?=$translate['zn_content']?>
        <?php else:?>
            未搜索到翻译
        <?php endif;?>
    </div>

</div>

<script>
    var tid = <?php echo isset($translate['tid']) ? $translate['tid'] : 0;?>;
</script>


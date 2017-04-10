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

    $('.video_language strong').mouseenter(function(event){

        // 阻止事件冒泡
        window.event.cancelBubble = true;
        $.ajax({
            url:'index.php?r=player/search',
            method:'get',
            data:{str:$(this).text(),tid:tid},
            success:function(search){
            console.info(search);
                if(search.success){

                    $('#translate_word').text('注释: '+search.data.word);
                    $('#translate_explain').text(search.data.explain);
                    $('#translate_word_detail').fadeIn();

                }else{
                    $('#translate_word').text('');
                    $('#translate_explain').text('未搜索到注释');
                    $('#translate_word_detail').fadeIn();
                }
            },
            error:function(e){
                console.error(e);
            },
            dateType:'json',
        })

    });

    $('.video_language strong').mouseleave(function(event){
          $('#translate_word_detail').fadeOut();
    });

JS;

AppAsset::addCss($this,'/css/video.css');
$this->registerJs($viewJs,View::POS_END);
?>

<div id="translate_word_detail">
    <div id="translate_word"></div>
    <div id="translate_explain"></div>
</div>
<div class="row">

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

<div class="row">
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


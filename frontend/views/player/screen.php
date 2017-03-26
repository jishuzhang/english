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
?>

<style>
    .video_language{
        display: block;
        padding: 9.5px;
        margin: 0 0 10px;
        font-size: 16px;
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
</style>
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
        Sally Albright: How do you expect me to respond to this?<br/>
        Harry Burns: How about you love me too.<br/>
        Sally Albright: How about I'm leaving.<br/>
        Harry: Doesn't what I said mean anything to you?<br/>
        Sally: I'm sorry Harry, I know it's New Years Eve. I know you're feeling lonely, but you just can't show up here,<br/>
            tell me you love me and expect that to make everything alright. It doesn't work this way.<br/>
        Harry: Well how does it work?<br/>
        Sally: I don't know but not in this way.<br/>
        Harry Burns: Well how about this way. I love that you get cold when it's 71 degrees out.<br/>
            I love that it takes you an hour and a half to order a sandwich.<br/>
            I love that you get a little crinkle above your nose when you're looking at me like I'm nuts.<br/>
            I love that after I spend the day with you, I can still smell your perfume on my clothes.<br/>
            And I love that you are the last person I want to talk to before I go to sleep at night.<br/>
            And it's not because I'm lonely, and it's not because it's New Year's Eve.<br/>
            I came here tonight because when you realize you want to spend the rest of your life with somebody,<br/>
            you want the rest of your life to start as soon as possible.<br/>
        Sally：You see！That is just like you, Harry. You say things like that and you make it impossible for me to hate you！<br/>
            And I hate you，Harry. I really hate you. I hate you.<br/>
    </div>

</div>

<div class="row">
    <h3>电影台词翻译</h3>

    <div class="col-lg-12">
        <pre>
        Sally Albright: How do you expect me to respond to this?
        Harry Burns: How about you love me too.
        Sally Albright: How about I'm leaving.
        Harry: Doesn't what I said mean anything to you?
        Sally: I'm sorry Harry, I know it's New Years Eve. I know you're feeling lonely, but you just can't show up here,
            tell me you love me and expect that to make everything alright. It doesn't work this way.
        Harry: Well how does it work?
        Sally: I don't know but not in this way.
        Harry Burns: Well how about this way. I love that you get cold when it's 71 degrees out.
            I love that it takes you an hour and a half to order a sandwich.
            I love that you get a little crinkle above your nose when you're looking at me like I'm nuts.
            I love that after I spend the day with you, I can still smell your perfume on my clothes.
            And I love that you are the last person I want to talk to before I go to sleep at night.
            And it's not because I'm lonely, and it's not because it's New Year's Eve.
            I came here tonight because when you realize you want to spend the rest of your life with somebody,
            you want the rest of your life to start as soon as possible.
        Sally：You see！That is just like you, Harry. You say things like that and you make it impossible for me to hate you！
            And I hate you，Harry. I really hate you. I hate you.
        </pre>
    </div>

</div>



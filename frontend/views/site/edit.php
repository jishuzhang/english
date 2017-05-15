<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\web\View;
use frontend\assets\AppAsset;

$this->title = '修改头像';
$this->params['breadcrumbs'][] = $this->title;

AppAsset::addCss($this,'/css/fileinput.min.css');
AppAsset::addScript($this,'/js/fileinput.min.js');

$viewJs =<<<JS

    $("#input-id").click(function(){
    alert(111);
    });
JS;
$this->registerJs($viewJs,View::POS_END);

?>
<script>
    $("#input-id").fileinput({
        'language' : 'zh',
    });
</script>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>This is the About page. You may modify the following file to customize its content:</p>-->
    <div class="row">
        <div class="col-lg-6">
            <input id="input-id" type="file" class="file" data-preview-file-type="text" >
            <code>支持jpg、jpeg、png、gif格式，大小不超过2.0M</code>
        </div>
    </div>

</div>

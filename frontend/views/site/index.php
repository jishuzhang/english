<?php

/* @var $this yii\web\View */

$this->title = '在线学习';

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>英语只需三步</h1>

        <p class="lead">You have taken the most courageous step.</p>

        <p>
            <a class="btn btn-lg btn-success" href="javascript:void(0);">
                Get started with Yii
            </a>
        </p>
    </div>

    <div class="body-content">

        <div class="row">
            <?php if(!empty($recommend)):?>
                <?php foreach($recommend as $r):?>
                    <div class="col-lg-4">
                        <h2><?=$r->name?></h2>

                        <p><?=$r->description?></p>

                        <p><a class="btn btn-default" href="<?=$r->url?>">快速入口 &raquo;</a></p>
                    </div>
                <?php endforeach;?>
            <?php endif;?>

        </div>

    </div>
</div>

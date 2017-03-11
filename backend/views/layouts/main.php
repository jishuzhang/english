<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/13
 * Time: 10:56
 */
/* @var $this \yii\web\View */
/* @var $content string */
use yii\widgets\ContentDecorator;
?>

<?php ContentDecorator::begin(['viewFile'=>'@app/views/layouts/column.php'])?>

        <?=$content?>

<?php ContentDecorator::end();?>

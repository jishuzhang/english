<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;


/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'res/css/responsive.css',
        'res/css/bootstrap.min.css',
        'res/css/font-awesome.min.css',
//        'res/css/pxgridsicons.min.css',
        'res/css/bootstrapreset.css',
        'res/css/chosen.css',
        'res/css/jquery-ui.min.css',
        'res/css/index_Returncode.css',
        'res/css/main.css',
    ];
    public $js = [
        'res/js/jquery-2.0.3.min.js',
        'res/js/bootstrap.min.js',
        'res/js/jquery-easing.js',
        'res/js/responsivenav.js',
        'res/js/jquery.nicescroll.js',
        'res/js/jquery-1.10.2.min.js',
        'res/js/jquery-ui.min.js',
        'res/js/index_Returncode.js',
    ];
    public $depends = [
    ];
    //在布局文件页面头部引入js
    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
}

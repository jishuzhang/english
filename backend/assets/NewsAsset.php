<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class NewsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'res/css/bootstrap.min.css',
        'res/css/font-awesome.min.css',
        'res/css/pxgridsicons.min.css',
        'res/css/responsive.css',
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
    //在布局页面头部引入js 文件
    public $jsOptions = [
        'position' => View::POS_HEAD   //end  底部
    ];
}
